<?php

namespace App\Http\Controllers;

use App\MailToken;
use App\Models\AddonCard;
use App\Models\Business;
use App\Models\StaffJob;
use App\Models\StaffJobSkill;
use App\Models\Staff;
use App\Models\ObjSkillsRef;
use App\Models\Job;
use App\Models\Addresses;
use App\Models\JobApplication;
use App\Role;
use App\Rules\ValidateEmailExist;
use App\User;
use App\UsersRole;
use App\Models\JobVacency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\Types\Boolean;
use phpDocumentor\Reflection\Types\Integer;
use Validator;
use Illuminate\Support\Facades\Crypt;
use Route;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    /**
     * Show a list of users
     * @return \Illuminate\View\View
     */

    public function index(Request $request)
    {


        $search = $request->get('search');
        $status = $request->get('status');
        $field = $request->get('field') != '' ? $request->get('field') : 'users.id';
        $sort = $request->get('sort') != '' ? $request->get('sort') : 'desc';
        $users = User::join('users_roles','users_roles.user_id', '=', 'users.id');
        $users->leftJoin('roles','roles.id', '=', 'users_roles.role_id');
        $users->select('users.id','users.firstname','users.lastname','users.email', 'users.created_at','users.status');
        $users->where('roles.alias', Role::TYPE_CLIENT);
		//$users= $users->where('users.is_deleted', false);
		if(trim($search)!='')
		{
			$users->where('users.email', 'like', '%' . $search . '%');
            $users->orWhere('users.firstname', 'like', '%' . $search . '%');
            $users->orWhere('users.lastname', 'like', '%' . $search . '%');
		}

        if($status!='')
        {
            $users->where('users.status', '=', $status);
        }


        $users = $users->orderBy($field, $sort);
        $users=  $users->paginate(20);
	//	echo "<pre>"; print_r($users);
		
		
        $users=  $users->withPath('?search=' . $search . '&field=' . $field . '&sort=' . $sort);
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show a page of user creation
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::pluck('title', 'id');

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Insert new user into the system
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);

        return redirect()->route('users.index')->withMessage(trans('quickadmin::admin.users-controller-successfully_created'));
    }


    /**
     * Show a user edit page
     *
     * @param $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $user  = User::findOrFail($id);
        //dd($user->toArray());
        $roles = Role::pluck('title', 'id');

        return view('admin.user.edit', compact('user', 'roles'));
    }

    /**
     * Update our user information
     *
     * @param Request $request
     * @param         $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user->update($input);

        return redirect()->route('users.index')->withMessage(trans('quickadmin::admin.users-controller-successfully_updated'));
    }
	
	
	

     // update user from website admin page
    public function updateUser($id,Request $request){
        //dd($request->all());

        $update_data['email']= $request->email;
        $update_data['firstname']= $request->firstname;
        $update_data['lastname']= $request->lastname;
        $update_data['status']= $request->status;

        if($request['password']!='')
        {
            $update_data['password'] = Hash::make($request['password']);
        }

        $user = User::where('id',$request->id)->update($update_data);

        //echo "<pre>"; print_r($request->all()); die;
        /*
        $user = User::where('id',$request->id)
                ->update(['email'=>$request->email,'firstname'=>$request->firstname,'lastname'=>$request->lastname,'status'=>$request->status]);
        */

       // dd($user);

        return redirect()->route('users.user.index');
    }


	public function editstaff($id)
    {
        $user  = User::findOrFail($id);
        //dd($user->toArray());
        
        return view('staff.edit', compact('user'));
    }



	public function updatestaff($id,Request $request){
        //dd($request->all());

        //$update_data['email']= $request->email;
        $update_data['firstname']= $request->firstname;
        $update_data['lastname']= $request->lastname;
        $update_data['status']= $request->status;

        if($request['password']!='')
        {
            $update_data['password'] = Hash::make($request['password']);
        }

        $user = User::where('id',$request->id)->update($update_data);
       // dd($user);

        return redirect('admin/users/staff');
    }








    public function show($id){
        $users = User::findOrFail($id);
        return view('admin.user.show',compact('users'));
    }

    /**
     * Destroy specific user
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request , $id)
    {
		
       $type= $request->type;

        $user = User::findOrFail($id);
        /*
		$data['is_deleted']=true;
	    $data['updated_at']=date("Y-m-d");
		$user->update($data);

        */
        //dd($id);
        $user = UsersRole::join('roles','roles.id', '=' ,'users_roles.role_id')
            ->where('users_roles.user_id',$id)
            ->select('roles.alias')
            ->get();
        //dd($user->toArray());
        $temp =array();
        foreach ($user as $item)
        {
            $temp[] = $item->alias;
        }

        if(in_array(Role::TYPE_STAFF, $temp))
        {
            // do for staff
            $staffJob  =  StaffJob::where('staff_user_id',$id)->get();

            if($staffJob)
            {
                foreach($staffJob as $stjob)
                {
                    StaffJobSkill::where('staff_job_id',$stjob->id)->delete();
                }

                StaffJob::where('staff_user_id',$id)->delete();
            }


            JobApplication::where('user_id',$id)->delete();
            Staff::where('user_id',$id)->delete();

            UsersRole::where('user_id',$id)->delete();
            Addresses::where('user_id',$id)->delete();
            User::destroy($id);
        }

        if(in_array(Role::TYPE_CLIENT, $temp))
        {
            // do for client
           $job  =  Job::where('business_user_id',$id)->get();
           if($job)
           {
                foreach($job as $jobList)
                {
                    JobVacency::where('job_id',$jobList->id)->delete();
                    JobApplication::where('job_id',$jobList->id)->delete();
                    ObjSkillsRef::where('obj_id',$jobList->id)->where('obj_table_ref','jobs')->delete();
                }
           }

           Job::where('business_user_id',$id)->delete();

            AddonCard::where('user_id',$id)->delete();
            Business::where('user_id',$id)->delete();

            UsersRole::where('user_id',$id)->delete();
            Addresses::where('user_id',$id)->delete();
            User::destroy($id);

        }



        //dd('scucess');

		if( $type=='client')
		{
			 return redirect()->route('users.user.index')->with('success_message', 'User has been deleted successfully!');;
		}
		else
		{
			 return redirect('admin/users/staff')->with('success_message', 'User has been deleted successfully!');;
		}
    }

    /*
	  get list of all role during register process process
	  @return @json  {"status":true,"message":"","payload":{"roles":[{"id":4,"title":"Client"},{"id":3,"title":"Staff"}]}}
	  @Created By Manjeet Kumar
	  @Created Date: 11-2-2019
	  @Modified Date: 11-2-2019
	*/
	public function roles(Request $request)
	{

		$roles = DB::table('roles')->select('id','title')->whereIn('id', array(3,4))->get();
		$return_data['status']=(Boolean)true;
		$return_data['message']='';
		
		$return_data['data']=array('roles'=>$roles);
        return $return_data;
    }



    public function register(Request $request){
        $input = $request->all();

        /*dd($validation);
        if ($validation->fails()) {
            $data = ['errors' => $validation->errors()];
            return $data;
        }*/

        // $validation = User::validateStaff($request);

        $v = Validator::make($request->all(), [
            'user_type' => 'required',
            'firstname' => 'required|min:2|max:50',
            'lastname' => 'required|min:2|max:50',
            'email' => ['required', 'email', new ValidateEmailExist(true)],
            'password' => 'required|min:6',
        ]);

        if ($v->fails())
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']=$v->errors()->all();
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=array();
            return $return_data;
        }
        /*
        $result = User::doesExistEmail($input['email']);
        if($result)
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']='Email already exists, try another';
            $return_data['payload']=array();
            return $return_data;
        }
        */
        $role_id = Role::get_role_id($input['user_type']);
        $result = [];
        $status = User::STATUS_PENDING;
        if(@$input['provider']){

            $status = User::STATUS_ACTIVE;
        }
        if($role_id){
            $input['password'] = Hash::make($input['password']);
            $input['status'] = $status;
            $user = User::create($input);
            UsersRole::create(['user_id' => $user->id, 'role_id' => $role_id]);
            $result['user_data'] = User::getUserInfo($input['email']);
            if($status == User::STATUS_PENDING){
                User::sendWelcomeConfirmEmail($user);
            }
        }
        return ['status' => 'success', 'data' => $result];
    }


    public function checkEmailExists(Request $request){
        $request->email;
        $result = User::doesExistEmail($request->email);
        return ['result' => $result];
    }

    public function verifyEmailCode(Request $request)
    {
        $arr['status'] = (Boolean)false;
        $arr['message'] ="Invalid code";
        $arr['data'] =new \stdClass();

        if($request->code){
         $data = MailToken::where('code', $request->code)
             ->first();
         if($data){
             if($data['is_clicked']== false){
                 if($data->type == MailToken::TYPE_MAIL_CONFIRMATION){
                     MailToken::where('id', '=', $data->id)
                         ->update(['is_clicked' => true,]);
                     User::enableUser($data->user_id);
                     //$result['status'] = 'verified';

                     $arr['status'] = (Boolean)true;
                     $arr['message'] ="Your account has been successfully varified";

                 }else if ($data->type == MailToken::TYPE_FORGOT_PASSWORD) {
                     $arr['status'] = (Boolean)true;
                     $arr['message'] ="verified";
                     $arr['data']['data'] = $data;
                 }

             }else{
                 $arr['status'] = (Boolean)false;
                 $arr['message'] ="Your account has been already varified";
                 $arr['error']['field_error']=array();
             }
         }
        }

        return $arr;
    }

    public function forgotPassword(Request $request)
    {
        $v = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($v->fails())
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']="Field validation error";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=$v->errors();
            return $return_data;
        }

        $user = User::where('email', $request->email)->first();
		
		if(!$user)
		{
			$return_data['status']=(Boolean)false;
            $return_data['message']="This email does not exists";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=array();
            return $return_data;
		}


        $data = User::sendForgotPasswordEmail($user);

        $return_data['status']=(Boolean)true;
        $return_data['message']="A link has been send to your email for reset password";
        $return_data['data']=new \stdClass();
        return $return_data;


       // return ['status' =>'success', 'data' => $data];
    }

    public function resetPassword(Request $request)
    {
        $v = Validator::make($request->all(), [
            'user_id' => 'required',
            'password' => 'required|min:6',
        ]);

        if ($v->fails())
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']="Field validation error";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=$v->errors();
            return $return_data;
        }


        $user = User::find($request->user_id);

       if(!$user)
       {
           $return_data['status']=(Boolean)false;
           $return_data['message']="No such user ";
           $return_data['data']=new \stdClass();
           $return_data['error']['field_error']=$v->errors();
           return $return_data;

       }


        $user->password =  Hash::make($request->password);
        $data = $user->save();
       // MailToken::destroy($request->mail_token_id);

        $return_data['status']=(Boolean)true;
        $return_data['message']="Password changed successfully.";
        $return_data['data']=new \stdClass();
        return $return_data;

       // return ['status' =>'success', 'data' => $data];
    }

    public function getUserInfo(Request $request){

        $email = $request->username?$request->username:$request->email;
        $user_data = User::getUserInfo($email);
        $data = ['status' => 'failed'];

        if($user_data){
            $data['status'] = 'success';
            $data['user_data'] = $user_data;
        }
        return $data;
    }
 
    public function sendVerificationEmail(Request $request)
    {
       
        $user = User::where('email', $request->email)->first();
        if(!$user )
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']="No such users.";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=array();
            return $return_data;
        }
        elseif($user->status == User::STATUS_ACTIVE)
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']="Your account is already activated.";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=array();
            return $return_data;
        }
        elseif($user->status == User::STATUS_SUSPENDED ||  $user->status == User::STATUS_INACTIVE )
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']="Your account is inactive or suspended.";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=array();
            return $return_data;
        }
        else
        {
            User::sendWelcomeConfirmEmail($user);
           // return ['status' => 'success'];
            $return_data['status']=(Boolean)true;
            $return_data['message']="A verification email has been send to your email, please check.";
            $return_data['data']=new \stdClass();
            return $return_data;
        }
    }

    public function updateUserAvatar(Request $request, $id)
    {
        $data = $request->all();
        $tmp = $_FILES;
        $user = User::find($id);
        if($user->photo_src){
            User::deleteUserAvatarFiles($id);
        }
        $user->update(['photo_src' =>  $data['avatar']]);
        $user_data = User::getUserInfo($user->email);
        return ['status' => 'success', 'user_data' => $user_data];
    }


    public function updateUserPreference(){

    }

		
	// ajax call details  	
	public function clientdetails(Request $request)
	{
		 $req = $request->all();
		 $client_id = $req['id'];
		 
		  $user = User::where('id', $client_id)->first();
		  
		  $role = Role::join('users_roles','users_roles.role_id', '=', 'roles.id');
		  $role= $role->select('roles.*');
		  $role= $role->where('users_roles.user_id', $client_id)->get();
		  
		 $business = Business::join('business_categories','businesses.business_category_id', '=', 'business_categories.id');
		 $business= $business->select('businesses.*', 'business_categories.title' );
		 $business= $business->where('businesses.user_id', $client_id)->first();
		  
		  
		  $addresses = Addresses::join('countries','countries.id', '=', 'addresses.country_id');
		  $addresses= $addresses->select('addresses.*', 'countries.title' );
		  $addresses= $addresses->where('addresses.obj_table_ref', 'businesses');
		  $addresses= $addresses->where('addresses.user_id', $client_id)->get();
		  
		  //AddonCard
		  
		   $card = AddonCard::where('user_id', $client_id)->get();
		   foreach($card as $key=>$value)
		   {
			   $card[$key]->card_number  = '***********' . substr($card[$key]->card_number,-4);
		   }
		   
		  //echo "<pre>";  print_r($card);  die;
		  
        return view('admin.user.details', compact('user', 'role', 'business' , 'addresses', 'card'));
    }
	
	
		
    /*
	  @Descriptuon: get staff details during ajax call of staff details: 
	  @Status: Working
	  @return @html
      @Created By Manjeet Kumar
	  @Created Date: 20-2-2019
	  @Modified Date: 20-2-2019
	*/
	public function staffdetails(Request $request)
	{
		 $req = $request->all();
		 $client_id = $req['id'];
		 
		  $user = User::where('id', $client_id)->first();
		  
		  $role = Role::join('users_roles','users_roles.role_id', '=', 'roles.id');
		  $role= $role->select('roles.*');
		  $role= $role->where('users_roles.user_id', $client_id)->get();
		  
		 $staff = Staff::leftJoin('timezones','staffs.timezone_id', '=', 'timezones.id');
		 $staff= $staff->select('staffs.*', 'timezones.zone' );
		 $staff= $staff->where('staffs.user_id', $client_id)->first();
		  
		  
		 $staff_job = StaffJob::leftJoin('job_titles','staff_jobs.job_title_id', '=', 'job_titles.id'); 
		 $staff_job= $staff_job->select('job_titles.*' , 'staff_jobs.exp_months_count' );
		 $staff_job= $staff_job->where('staff_jobs.staff_user_id', $client_id)->get()->toArray();
		  
		foreach($staff_job as $key=>$value)
		{
			 $staff_job[$key] = $value;
			
			$staff_job[$key]['skills'] = StaffJobSkill::staffJobSkill($value['id']);
		}
		 
		
		  
		  $addresses = Addresses::join('countries','countries.id', '=', 'addresses.country_id');
		  $addresses= $addresses->select('addresses.*', 'countries.title' );
		  $addresses= $addresses->where('addresses.obj_table_ref', 'staffs');
		  $addresses= $addresses->where('addresses.user_id', $client_id)->get();
		  
		  //echo "<pre>";  print_r($card);  die;
		  
        return view('staff.details', compact('user', 'role', 'staff' , 'addresses','staff_job'));
    }


    public function staff(Request $request)
    {
        //$users = User::all();
        $search = $request->get('search');
        $status = $request->get('status');
        $field = $request->get('field') != '' ? $request->get('field') : 'users.id';
        $sort = $request->get('sort') != '' ? $request->get('sort') : 'desc';

        $users = User::join('users_roles','users_roles.user_id', '=', 'users.id');
        $users->leftJoin('roles','roles.id', '=', 'users_roles.role_id');
        $users= $users->select('users.id','users.firstname','users.lastname','users.email', 'users.created_at','users.status');
        $users->where('roles.alias', Role::TYPE_STAFF);

        if($search!='')
		{
			$users = $users->where('users.email', 'like', '%' . $search . '%');
		}

        if($status!='')
        {
            $users = $users->where('users.status', '=', $status);
        }


		$users= $users->where('users.is_deleted', false);
        $users = $users->orderBy($field, $sort);
        $users=  $users->paginate(20);
		
		


        $users=  $users->withPath('?search=' . $search . '&field=' . $field . '&sort=' . $sort);
        return view('staff.index', compact('users'));
    }
}