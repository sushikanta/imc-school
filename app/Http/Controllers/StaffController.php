<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Staff;
use App\Models\StaffJob;
use App\Models\StaffJobSkill;
use App\Models\Addresses;
use App\Role;
use Illuminate\Support\Facades\DB;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\ObjSkillsRef;
use App\Models\Checkin;
use App\Models\SysSetting;
use App\Todo;
use App\User;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Integer;
use PhpParser\Node\Expr\Cast\Double;
use Validator;
use App\Classes\Utility;
class StaffController extends Controller
{

    public function index()
    {

    }

    public function show($id)
    {
       // $id= (Integer)$id;
        $id  = \Auth::id();
        $data = User::getStaffDetails($id);
        $return_data['status']=(Boolean)true;
        $return_data['message']="";
        $return_data['data']=$data;

        $param['user_id'] = $id;
        $param['obj_table_ref'] = 'staffs';
        $param['type'] = 'profile';

        $return_data['data']['address']=new \stdClass();
        $address_data=  Addresses::getAddress($param);

        if( $address_data)
        {
            $return_data['data']['address'] = $address_data;
        }

        return $return_data;
    }

    public function update(Request $request, $id)
    {
        $id  = \Auth::id();

        $is_exists = User::doesExistStaff($id);
        if(!$is_exists)
        {
            $arr['status'] = (Boolean)false;
            $arr['message'] ="Staff does not exists";
            $arr['data'] =new \stdClass();
            $arr['error']['field_error']=array();
            return  $arr;
        }

        $request->merge(['id' => $id]);


        $v = Validator::make($request->all(), [
            //'id' => ['required'],
            'firstname' => ['required'],
            'lastname' => ['required'],
            'dob' => ['required'],
            'gender' => ['required'],
            'contact1' => ['required'],
            'address1' => ['required'],
            'city' => ['required'],
            'zipcode' => 'required|integer',
            /* 'state' => ['required'],*/
            'country_id' => 'required|integer',
            'timezone_id' => 'required|integer',

        ], [
            'name.required' => 'Business title is required.',
            'business_category_id.required' => 'Please select business category.',
            'country_id.required' => 'Please select country.',
            'timezone_id.required' => 'Please select timezone.',
        ]);

        if ($v->fails())
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']="Field validation error";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=$v->errors();
            return $return_data;
        }

        $staff = User::find($id);
        $staff->update($request->all());

        $details = Staff::where('user_id', $id)->first();
        //print_r( $details ) ; die;

        if($details)
        {
            $staff_details = $request->all();

            $staff_data['gender'] = @$staff_details['gender'];
            $staff_data['dob'] = @$staff_details['dob'];

            if(@$staff_details['lat']!='')
            {
                $staff_data['lat'] = @$staff_details['lat'];
            }

            if(@$staff_details['lng']!='')
            {
                $staff_data['lng'] = @$staff_details['lng'];
            }

            $staff_data['timezone_id'] = @(Integer)$staff_details['timezone_id'];
            $staff_data['staff_details'] = @$staff_details['about'];
           // print_r($staff_update);die;

            $details->update($staff_data);
            $object_id= $details->id;
        }
        else
        {
            $staff_details = $request->all();

            $staff_data['gender'] = @$staff_details['gender'];
            $staff_data['dob'] = @$staff_details['dob'];
            $staff_data['user_id'] = $id;

            if(@$staff_details['lat']!='')
            {
                $staff_data['lat'] = @$staff_details['lat'];
            }

            if(@$staff_details['lng']!='')
            {
                $staff_data['lng'] = @$staff_details['lng'];
            }

            $staff_data['timezone_id'] = @(Integer)$staff_details['timezone_id'];
            $staff_data['staff_details'] = @$staff_details['about'];

            $object_id =  Staff::create($staff_data)->id;
        }

        // update business address
        $address_details  = Addresses::where('user_id', $id);
        $address_details  = $address_details->where('obj_table_ref', 'staffs');
        $address_details  = $address_details->where('object_id',$object_id);
        $address_details  = $address_details->where('is_default',true);
        $address_details = $address_details->first();


        if($address_details)
        {
            $reqs = $request->all();
            $add['address1'] = @$reqs['address1'];
            $add['address2'] = @$reqs['address2'];
            $add['zipcode'] = @$reqs['zipcode'];
            $add['city'] = @$reqs['city'];
            $add['state'] = @$reqs['state'];
            $add['country_id'] = @$reqs['country_id'];
            $add['contact1'] = @$reqs['contact1'];
            $add['contact2'] = @$reqs['contact2'];
            $address_details->update($add);
        }
        else
        {
            $reqs = $request->all();
            $add['user_id'] = $id;
            $add['obj_table_ref'] = 'staffs';
            $add['type'] = 'profile';
            $add['object_id'] = $object_id;
            $add['is_default'] = true;
            $add['address1'] = @$reqs['address1'];
            $add['address2'] = @$reqs['address2'];
            $add['zipcode'] = @$reqs['zipcode'];
            $add['city'] = @$reqs['city'];
            $add['state'] = @$reqs['state'];
            $add['country_id'] = @$reqs['country_id'];
            $add['contact1'] = @$reqs['contact1'];
            $add['contact2'] = @$reqs['contact2'];

            // echo "<pre>"; print_r($add); die;
            Addresses::create($add);
        }

        $return_data['status']=(Boolean)true;
        $return_data['message']="Details has been updated successfully.";
        $return_data['data']=new \stdClass();

        return $return_data;
    }

    public function updatePreference(Request $request, $id)
    {
        $v = Validator::make($request->all(), [
           'preference' => 'required'
        ]);
        $result =  User::updatePreference($id, Role::TYPE_CLIENT,  $request->get('preference'));
       return ['status' => 'success', 'data' => $result];
    }

    public function delete(Request $request, $id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();

        return ['success'=> true];
    }

    private function validator($data)
    {
        return Validator::make((array)$data, [
            'task' => 'required|min:10',
            'user_id' => 'required|integer',
            'done' => 'required|boolean',
        ]);
    }

    public function storeJobSkills(Request $request)
    {
        /*
            exp_count: "23"
            exp_count_type: "month"
            job_title_id: "78"
            skills: ["3", "9", "4", "17"]
         */
        $exp_months_count = $request['exp_count'];
        if($request['exp_count_type'] == 'year'){
           $exp_months_count = $exp_months_count * 24;
        }
        $req = $request->all();
        $req['exp_months_count'] = $exp_months_count;

        $staff_job_id = @$req['staff_job_id']? $req['staff_job_id']: 0;

        // -- updating existing staff job id
        if($staff_job_id){
            //-- searching for the matched job_title_ids to update accordingly
           $staff_job_ids =  StaffJob::where('job_title_id', $request['job_title_id'])
                ->where('id', '<>', $request['staff_job_id'])
                ->get()->pluck('id');
           // -- removing existing staffjobs and related skills


           if($staff_job_ids->count()){
               StaffJob::destroy($staff_job_ids->toArray());
               StaffJobSkill::whereIn('staff_job_id',$staff_job_ids->toArray())->delete();
           }
           $data = StaffJob::find($staff_job_id);
           if($data)
           {
               $data->update($req);
           }
        }else{
            // creating new staff job

            $data = StaffJob::where('job_title_id', $request['job_title_id'])->first();
            if($data){
                $staff_job_id = $data->id;
                $data->update($req);
            }else{
                $saved_data = StaffJob::create($req);
                $staff_job_id = $saved_data->id;
            }
        }

        $req['skills']  = json_decode( $req['skills'] ,true);

        if(count($req['skills'])){
            StaffJobSkill::where('staff_job_id', $staff_job_id)->delete();
            foreach ($req['skills'] as $skill_id){
                StaffJobSkill::create(['staff_job_id' => $staff_job_id, 'skill_id' => $skill_id]);
               // echo $staff_job_id."  r  ";  echo $skill_id; die;
            }
        }

        $return_data['status']=(Boolean)true;
        $return_data['message']="Details has been updated successfully.";
        $return_data['data']=new \stdClass();

        return   $return_data;
    }
	
	
	public function getSingleJobSkills(Request $request, $id )
	{
		$request = $request->all(); 
		//$id= @$request['id'];
		
		if ($id=='')
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']='Please send job title id';
            $return_data['data']=new \stdClass();
			$return_data['error']['field_error']=array();
            return $return_data;
        }
		
		$user_id  = \Auth::id();
		
        $jobs = StaffJob::select('job_titles.title', 'job_titles.id AS job_title_id','staff_jobs.id', 'staff_jobs.exp_months_count')->join('job_titles', 'job_titles.id', '=', 'staff_jobs.job_title_id')
            ->where('staff_user_id', $user_id)->where('staff_jobs.id', (Integer)$id)
            ->orderBy('job_titles.title')
            ->first() ;

       //print_r($jobs); die;
		
		if($jobs)
		{
				$jobs = $jobs->toArray();
				
			    $jobs['skill']=array();
				$skills =  StaffJobSkill::select('staff_job_skills.id','skills.title AS skill', 'skills.id AS skill_id', 'staff_job_skills.staff_job_id')
              ->join('skills', 'skills.id', '=', 'staff_job_skills.skill_id')
              ->where('staff_job_id', $jobs['id'])->get();
				
				if($skills)
				{
					$jobs['skill'] = $skills->toArray();
				}	
		}
		else
		{
			$jobs= new \stdClass();
		}
			
		$return_data['status']=(Boolean)true;
        $return_data['message']="";
        $return_data['data']=$jobs;
        return $return_data;
    }

    public function getJobSkills(Request $request)
	{
		
		$user_id  = \Auth::id();
		
        $jobs = StaffJob::select('staff_jobs.id','job_titles.title', 'job_titles.id AS job_title_id', 'staff_jobs.exp_months_count')->join('job_titles', 'job_titles.id', '=', 'staff_jobs.job_title_id')
            ->where('staff_user_id', $user_id)
            ->orderBy('job_titles.title')
            ->get()

        ;
		
		if($jobs)
		{
			$jobs = $jobs->toArray();
			
			foreach($jobs as $key=>$job)
			{
				
				$jobs[$key]['skill']=array();
				$skills =  StaffJobSkill::select('staff_job_skills.id','skills.title AS skill', 'skills.id AS skill_id', 'staff_job_skills.staff_job_id')
              ->join('skills', 'skills.id', '=', 'staff_job_skills.skill_id')
              ->where('staff_job_id', $job['id'])->get();
				
				if($skills)
				{
					$jobs[$key]['skill'] = $skills->toArray();
				}
			}	
		}
		else
		{
			$jobs= array();
		}
			
		$return_data['status']=(Boolean)true;
        $return_data['message']="";
        $return_data['data']=$jobs;
        return $return_data;
    }

    public function editStaffJobSkill(Request $request, $staff_id)
	{
         $data = StaffJob::find($request['staff_job_id']);
		 if(@$data->id!='')
		 {
			$skills = StaffJobSkill::select('skills.title AS skill', 'skills.id AS skill_id', 'staff_job_skills.staff_job_id')
             ->join('skills', 'skills.id', '=', 'staff_job_skills.skill_id')
             ->where('staff_job_id', $data->id)->get();
		 }

       // $data = ['staff_jobs' => $data, 'skills' => @$skills];
       // return ['status' => 'success', 'data' => $data];
		
		$return_data['status']=(Boolean)true;
        $return_data['message']="";
        $return_data['data']=$data;
		$return_data['data']['skills']=@$skills;
        return $return_data;	
    }
	

	 /*
	  @Descriptuon: Staff add Job Skill  API Service 
	  @Status: done
	  @return  json
      @Created By Manjeet Kumar
	  @Created Date: 21-2-2019
	  @Modified Date: 21-2-2019
	*/
    public function addskills(Request $request)
    {

		$v = Validator::make($request->all(), [
            'job_title_id' => 'required|integer',
            'exp_count' => 'required|integer',
            'exp_count_type' => 'required',
            'skills' => 'required'
        ]);

        if ($v->fails())
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']="Field validation error";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=$v->errors();
            return $return_data;
        }

		$user_id  = \Auth::id();
		
		$staff_job_ids =  StaffJob::where('job_title_id', $request['job_title_id']);
		$staff_job_ids =  $staff_job_ids->where('staff_user_id', $user_id)->first();
		
		if($staff_job_ids)
		{
		    $return_data['status']=(Boolean)false;
            $return_data['message']="This Job title already exists.";
            $return_data['data']=new \stdClass();
			$return_data['error']['field_error']=array();
            return $return_data;
		}
		else
		{
			$exp_months_count = $request['exp_count'];
			if($request['exp_count_type'] == 'year')
			{
			   $exp_months_count = $exp_months_count * 12;
			}
			
			$req = $request->all();
			
			$req['exp_months_count'] = $exp_months_count;
			$req['staff_user_id'] = $user_id;
			$req['created']=date("Y-m-d");
			$req['updated']=date("Y-m-d");
			
			$saved_data = StaffJob::create($req);
			$staff_job_id = $saved_data->id;
			
			
			$req['skills']  = @$req['skills'];
			
			if(count($req['skills']))
			{
				foreach ($req['skills'] as $skill_id)
				{
					StaffJobSkill::create(['staff_job_id' => $staff_job_id, 'staff_user_id' => $user_id, 'job_title_id' => $request['job_title_id'], 'skill_id' => $skill_id]);
				}
			}
		}
		$return_data['status']=(Boolean)true;
        $return_data['message']="Skill has been added successfully";
        $return_data['data']=new \stdClass();
        return $return_data;
	}


	/*
	  @Descriptuon: Update Staff  Job Skills 
	  @Status: Working
	  @return  json
      @Created By Manjeet Kumar
	  @Created Date: 21-2-2019
	  @Modified Date: 19-3-2019
	*/
    public function updateskills(Request $request , $id)
    {
		$id= (Integer)$id;
		
		$v = Validator::make($request->all(), [
            'job_title_id' => 'required|integer',
            'exp_count' => 'required|integer',
            'exp_count_type' => 'required',
            'skills' => 'required'
        ]);

        if ($v->fails())
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']="Field validation error";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=$v->errors();
            return $return_data;
        }
		
		if ($id=='')
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']='Please send job title id';
            $return_data['data']=new \stdClass();
			$return_data['error']['field_error']=array();
            return $return_data;
        }
		
		
		
		$user_id  = \Auth::id();
		
		$staff_job_ids =  StaffJob::where('id', $id);
		$staff_job_ids =  $staff_job_ids->where('staff_user_id', $user_id)->first();
		
		if(!$staff_job_ids)
		{
		    $return_data['status']=(Boolean)false;
            $return_data['message']="This Job title id does not exists.";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=$v->errors();
            return $return_data;
			
		}
		else
		{
			$exp_months_count = $request['exp_count'];
			if($request['exp_count_type'] == 'year')
			{
			   $exp_months_count = $exp_months_count * 12;
			}
			
			$req = $request->all();
			
			
			$staffupdate['job_title_id'] =$request['job_title_id'];
			$staffupdate['exp_months_count'] =$exp_months_count;
			$staffupdate['updated'] =date("Y-m-d");
			
			$update_data = StaffJob::where('id', $staff_job_ids->id)->update($staffupdate);
			
			
			StaffJobSkill::where('staff_job_id',$id)->delete();
			//echo $request['id']; die;
			
			$req['skills']  = $req['skills'];
			
			if(count($req['skills']))
			{
				foreach ($req['skills'] as $skill_id)
				{
					//StaffJobSkill::create(['staff_job_id' => $request['id'], 'skill_id' => $skill_id]);
                    StaffJobSkill::create(['staff_job_id' => $id, 'staff_user_id' => $user_id, 'job_title_id' => $request['job_title_id'],  'skill_id' => $skill_id]);
				}
			}
		}
		
		$return_data['status']=(Boolean)true;
        $return_data['message']="Skill has been updated successfully";
        $return_data['data']=new \stdClass();
        return $return_data;
	}



			/*
	  @Descriptuon: Update Staff  Job Skills 
	  @Status: Working
	  @return  json
      @Created By Manjeet Kumar
	  @Created Date: 21-2-2019
	  @Modified Date: 21-2-2019
	*/
    public function deleteJobSkills(Request $request , $id)
    {
		$id= (Integer)$id;
		
		$user_id  = \Auth::id();
		
		$staff_job_ids =  StaffJob::where('id', $id);
		$staff_job_ids =  $staff_job_ids->where('staff_user_id', $user_id)->first();
		
		if(!$staff_job_ids)
		{
		    $return_data['status']=(Boolean)false;
            $return_data['message']="This Job title id does not exists.";
            $return_data['data']=new \stdClass();
			$return_data['error']['field_error']=array();
            return $return_data;
			
		}
		else
		{
			StaffJobSkill::where('staff_job_id',$id)->delete();
			StaffJob::where('id',$id)->delete();
		}
		
		$return_data['status']=(Boolean)true;
        $return_data['message']="Job title has been deleted successfully";
        $return_data['data']=new \stdClass();
        return $return_data;
	}

	/*
	  @Descriptuon: Update Staff  bank account details
	  @Status: Working
	  @return  json
      @Created By Manjeet Kumar
	  @Created Date: 25-2-2019
	  @Modified Date: 25-2-2019
	*/
    public function updateBankAccount(Request $request)
    {
		
		$v = Validator::make($request->all(), [
			'account_holder_name' => 'required',
            'bank_name' => 'required',
            'account_number' => 'required',
            'ifsc_code' => 'required'
        ]);

        if ($v->fails())
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']="Field validation error";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=$v->errors();
            return $return_data;
        }
		
			$user_id  = \Auth::id();
			
		
			$bank['account_holder_name'] =$request['account_holder_name'];
			$bank['bank_name'] =$request['bank_name'];
			$bank['account_number'] =$request['account_number'];
			$bank['ifsc_code'] =$request['ifsc_code'];
			//print_r($bank); die;
			$update_data = Staff::where('user_id', $user_id)->update($bank);
		
		$return_data['status']=(Boolean)true;
        $return_data['message']="Account details has been updated successfully";
        $return_data['data']=new \stdClass();
        return $return_data;
	}

	 /*
	  @Descriptuon: get staff list during send invite list api 
	  @Status: Working
	  @return  json
      @Created By Manjeet Kumar
	  @Created Date: 20-2-2019
	  @Modified Date: 22-2-2019
	*/
    public function stafflist(Request $request)
    {
        $location = $request->get('location'); //array
		$job_title_id = $request->get('job_title_id'); // array
		$experience_year = $request->get('experience_year'); // array
		
        $field = $request->get('field') != '' ? $request->get('field') : 'users.id';
        $sort = $request->get('sort') != '' ? $request->get('sort') : 'desc';
		
        $users = User::join('users_roles','users_roles.user_id', '=', 'users.id');
        $users->join('roles','roles.id', '=', 'users_roles.role_id');
		$users->leftJoin('staffs','staffs.user_id', '=', 'users.id');
		$users->leftJoin('staff_jobs','staff_jobs.staff_user_id', '=', 'users.id');
		$users->leftJoin('addresses','addresses.user_id', '=', 'users.id');
        $users->select('users.*','users.firstname','users.lastname', 'staffs.user_id' , 'staffs.profile_picture' );
        $users->where('addresses.type', 'profile');
		$users->where('addresses.obj_table_ref', 'staffs');
		$users->where('roles.alias', Role::TYPE_STAFF);

		if($location!='')
		{
			$users->where('addresses.state', 'like', '%' . $location . '%');
		}
		
		if($job_title_id!='')
		{
			$users->where('staff_jobs.job_title_id',$job_title_id);
		}

		if($experience_year!='')
		{
			$users->where('staff_jobs.exp_months_count', '<=', (Integer)$experience_year*12);
		}
		
		$users->groupBy('users.id',  'staffs.user_id',  'staffs.profile_picture');
        $users->orderBy($field, $sort);
        $users=  $users->paginate(20)->toArray();
		
		foreach($users['data'] as $key=>$value)
		{
			$param['user_id'] = $value['id'];
			$param['obj_table_ref'] = 'staffs';
			$param['type'] = 'profile';
			
			$address=array();
			$job_title_data=array();
			
			$address_data=  Addresses::getAddress($param);
			if($address_data)
			{
				$address = $address_data;
			}
			
			$job_title_data=  StaffJob::getStaffJob( $value['id']);
			
			if($job_title_data)
			{
				foreach($job_title_data as $keys=>$job_data)
				{
					if(@$job_data['job_id'])
					{
						$job_skill_data=  StaffJobSkill::staffJobSkill( $job_data['job_id'] );	
						$job_title_data[$keys]['skills'] = $job_skill_data;
					}
				}
			}
			
			$users['data'][$key]['address']=$address;
			$users['data'][$key]['job_title']=$job_title_data;
		}
		
		//echo "<pre>"; print_r($users); die;

        $return_data['status']=(Boolean)true;
        $return_data['message']="";
        $return_data['data']=$users;
        return $return_data;
    }
	
	
		/*
	  @Description: Get all posted  job list with multiple type of searching
	  @Status: done
	  @return  json
      @Created By Manjeet Kumar
	  @Created Date: 21-2-2019
	  @Modified Date: 21-2-2019
	*/
    public function getJobs(Request $req)
    {
		$user_id  = \Auth::id();

	   $title_list=array();
       $job_title_data=   StaffJob::getStaffJob($user_id);
       foreach(@$job_title_data as $list_data)
       {
           $title_list[] = $list_data['id'];
       }
      // print_r($title_list) ;die;

        $job_title_id = @array_filter($req->get('job_title_id')); //array
        $starting_from = trim($req->get('starting_from')); //search
        $ending_at = trim($req->get('ending_at')); //search

        $lat = (Double)trim($req->get('lat')); //search
        $lng = (Double)trim($req->get('lng')); //search
        $range_km = (Integer)trim($req->get('range_km')); //search


		$field = $req->get('field') != '' ? $req->get('field') : 'jobs.id';
        $sort = $req->get('sort') != '' ? $req->get('sort') : 'asc';
		
		$jobs = Job::leftJoin('countries','jobs.country_id', '=', 'countries.id');
		$jobs->leftJoin('job_titles','jobs.job_title_id', '=', 'job_titles.id');
        $jobs->leftJoin('timezones','jobs.timezone_id', '=', 'timezones.id');
		$jobs->select('jobs.*','countries.title as country_name','job_titles.title as job_title');
        $jobs->addSelect('timezones.zone as timezone_name');
		$jobs->where('jobs.status',Job::STATUS_PUBLISHED);
        $jobs->where('jobs.ending_at','>=',date('Y-m-d H:i:s'));

        if(!empty($job_title_id))
        {
            $job_title_id = array_map('intval', $job_title_id);
            $jobs->whereIn('jobs.job_title_id',$job_title_id);
        }
        elseif(!empty( $title_list))
        {
            $jobs->whereIn('jobs.job_title_id', $title_list);
        }

        if($starting_from!='')
        {
            $jobs->where('jobs.starting_from', '>=',   date('Y-m-d H:i:s',strtotime($starting_from))  );
        }

        if($ending_at!='')
        {
            $jobs->where('jobs.ending_at', '<=',    date('Y-m-d H:i:s',strtotime($ending_at))  );
        }

        if( $lat  && $lng && $range_km )
        {
            $jobs->where(DB::raw('(ST_DistanceSphere(jobs.geometry_location, ST_MakePoint('.$lng.','.$lat.'))*1.6)/1609.34'), '<=',    $range_km  );
        }


		$jobs->groupBy('jobs.id',  'countries.title','job_titles.title','timezones.zone');
		$jobs->orderBy('jobs.created_at','DESC');
		
		$jobs=  $jobs->paginate(20);


		$jobs->transform(function($item){
            $user_id  = \Auth::id();
			
			$item['address_formatted'] = Utility::getFormattedAddress([
				'address1' => $item['address1'],
				'address2' => $item['address2'],
				'city' => $item['city'],
				'state' => $item['state'],
				'country' => @$item['country_name'],
			]);

            $item['skills'] = $this->getSkillsForJob($item->id);

            $format= array();
            foreach($item['skills'] as $skill_formating)
            {
                $format[] =$skill_formating['title'];
            }

            $item['skills_formated'] = implode(", ", $format);

            $item['already_applied']  =(Boolean)false;
            $already_applied =  JobApplication::where('job_id', $item->id)->where('user_id', $user_id )->first();
            if($already_applied)
            {
                $item['already_applied']  =(Boolean)true;
            }

		   return $item;  
		 });
		

		
		$job_list=array();
		if($jobs)
		{
			$job_list= $jobs->toArray();
		}

		//print_r($job_list); die;
		$return_data['status']=(Boolean)true;
        $return_data['message']="";
        $return_data['data']= $job_list;
		return $return_data;
	}



	/*
	  @Descriptuon: Staff apply a job 
	  @Status: done
	  @return  json
      @Created By Manjeet Kumar
	  @Created Date: 21-2-2019
	  @Modified Date: 21-2-2019
	*/
    public function applyJob(Request $request, $job_id)
    {
		$user_id  = \Auth::id();
		$job_id= (Int)$job_id;
		
		$already_applied =  JobApplication::where('job_id', $job_id)->where('user_id', $user_id)->first();
		if($already_applied)
		{
			$return_data['status']=(Boolean)false;
            $return_data['message']="You are already applied with this job";
            $return_data['data']=new \stdClass();
			$return_data['error']['field_error']=array();
            return $return_data;
		}
		
		
        $req = $request->all();
        $req['job_id'] = $job_id;
        $req['user_id'] = $user_id;
        $req['status'] = 'pending';
        $req['created_at']=date("Y-m-d H:i:s");
        $req['updated_at']=date("Y-m-d");
			
			//print_r($req); die;
			
			
			$application = JobApplication::create($req);
			$application_id = $application->id;
		
		
		$return_data['status']=(Boolean)true;
        $return_data['message']="your job application has been completed successfully";
        $return_data['data']=array('application_id'=>$application_id);
        return $return_data;
	}

			/*
	  @Descriptuon: Get My Applied Job and Seach Status
	  @Status: done
	  @return  json
      @Created By Manjeet Kumar
	  @Created Date: 21-2-2019
	  @Modified Date: 21-2-2019
	*/
    public function myApplyJob(Request $req)
    {
		$user_id  = \Auth::id();

        $job_title_id = $req->get('job_title_id'); //search
        $status = $req->get('status'); //search
        $starting_from = trim($req->get('starting_from')); //search
        $ending_at = trim($req->get('ending_at')); //search
		
		$field = $req->get('field') != '' ? $req->get('field') : 'job_applications.created_at';
        $sort = $req->get('sort') != '' ? $req->get('sort') : 'desc';

		$jobs = Job::leftJoin('countries','jobs.country_id', '=', 'countries.id');
		$jobs->leftJoin('job_titles','jobs.job_title_id', '=', 'job_titles.id');
		$jobs->join('job_applications','jobs.id', '=', 'job_applications.job_id');
        $jobs->leftJoin('timezones','jobs.timezone_id', '=', 'timezones.id');
		$jobs->select('jobs.*','countries.title as country_name','job_titles.title as job_title','job_applications.status as application_status');
        $jobs->addSelect('timezones.zone as timezone_name');
		$jobs->where('job_applications.user_id',$user_id);

        if(!empty($job_title_id)  && is_array($job_title_id)  )
        {
            $job_title_id = array_map('intval', $job_title_id);
            $jobs->whereIn('jobs.job_title_id',$job_title_id);
        }

        if(!empty($status)  && is_array($status)  )
        {
            $jobs->whereIn('job_applications.status',$status);
        }

        if($starting_from!='')
        {
            $jobs->where('jobs.starting_from', '>=',   date("Y-m-d H:i:s",strtotime($starting_from))  );
        }

        if($ending_at!='')
        {
            $jobs->where('jobs.ending_at', '<=',    date("Y-m-d H:i:s",strtotime($ending_at))  );
        }


		$jobs->groupBy('jobs.id', 'job_applications.status' ,'countries.title','job_titles.title','timezones.zone');
		
		
		$jobs=  $jobs->paginate(20);
		

		$jobs->transform(function($item){
			
			$item['address_formatted'] = Utility::getFormattedAddress([
				'address1' => $item['address1'],
				'address2' => $item['address2'],
				'city' => $item['city'],
				'state' => $item['state'],
				'country' => @$item['country_name'],
			]);

            $item['skills'] = $this->getSkillsForJob($item['id']);

            $format= array();
            foreach($item['skills'] as $skill_formating)
            {
                $format[] =$skill_formating['title'];
            }

            $item['skills_formated'] = implode(", ", $format);

            $login_id  = \Auth::id();
            $item['inout_status'] = Checkin::getCheckinDetails(     $item['id']  ,$login_id )  ;
            //print_r($item['inout_status']) ;die;


		   return $item;
			  
		 });
		
		
		
		$job_list=array();
		if($jobs)
		{
			$job_list= $jobs->toArray();
		}
		
		
		//print_r($job_list); die;
		$return_data['status']=(Boolean)true;
        $return_data['message']="";
        $return_data['data']= $job_list;
		return $return_data;
	}




    /*
     @Description: staff Get Single published Job Details during apply job
     @Status: done
     @return  json
     @Created By Manjeet Kumar Patel
     @Created Date: 11-3-2019
     @Modified Date: 11-3-2019
   */

    public function getSingleJobDetails(Request $request, $job_id)
    {
        $request = $request->all();
        $job_id= @(Integer)$job_id;

        if ($job_id=='')
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']='Please send  job id';
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=array();
            return $return_data;
        }

        $user_id  = \Auth::id();
       // echo $user_id; die;

        //$jobs = Job::leftJoin('job_applications','jobs.id', '=', 'job_applications.job_id');
        $jobs = Job::leftJoin('countries','jobs.country_id', '=', 'countries.id');
        $jobs->leftJoin('job_titles','jobs.job_title_id', '=', 'job_titles.id');
        $jobs->leftJoin('timezones','jobs.timezone_id', '=', 'timezones.id');
        $jobs->select('jobs.*','countries.title as country_name', 'job_titles.title as job_title' );
        $jobs->addSelect('timezones.zone as timezone_name' , 'timezones.gmt');
        $jobs->where('jobs.id',$job_id);
        $jobs->where('jobs.status',Job::STATUS_PUBLISHED);
        $jobs->groupBy('jobs.id',  'countries.title','job_titles.title' ,'timezones.zone' , 'timezones.gmt'  );
        $jobs=  $jobs->first();

        //return $jobs;

        $job_list=new \stdClass();
        if($jobs)
        {
            $job_list= $jobs->toArray();

            $job_list['already_applied']  =(Boolean)false;
            $already_applied =  JobApplication::where('job_id', $job_list['id'])->where('user_id', $user_id )->first();
            if($already_applied)
            {
                $job_list['already_applied']  =(Boolean)true;
            }

            $job_list['address_formatted'] = Utility::getFormattedAddress([
                'address1' => $job_list['address1'],
                'address2' => $job_list['address2'],
                'city' => $job_list['city'],
                'state' => $job_list['state'],
                'country' => @$job_list['country_name'],
            ]);

            $job_list['skills'] = $this->getSkillsForJob($job_list['id']);
            $format= array();
            foreach($job_list['skills'] as $skill_formating)
            {
                $format[] =$skill_formating['title'];
            }

            $job_list['skills_formated'] = implode(", ", $format);
        }

        //echo "<pre>"; print_r($job_list) ; die;

        $return_data['status']=(Boolean)true;
        $return_data['message']="";
        $return_data['data']['jobs']=$job_list;
        return $return_data;

    }

    public function getSkillsForJob($job_id){
        return ObjSkillsRef::select('skills.id','skills.title')->where('obj_skills_ref.obj_id', $job_id)
            ->join('skills', 'skills.id', '=', 'obj_skills_ref.skill_id')
            ->where('obj_table_ref', 'jobs')->get();
    }

	/*
	  @Descriptuon: Checkin for a job
	  @Status: done
	  @return  json
      @Created By Manjeet Kumar
	  @Created Date: 18-3-2019
	  @Modified Date: 18-3-2019
	*/
    public function checkin(Request $request, $job_id)
    {

		$user_id  = \Auth::id();
		$job_id= (Int)$request['job_id'];
		
		$already_applied =  Checkin::where('job_id', $job_id)->where('user_id', $user_id)->first();
		if($already_applied)
		{
			$return_data['status']=(Boolean)false;
            $return_data['message']="You have already checked in ";
            $return_data['data']=new \stdClass();
			$return_data['error']['field_error']=array();
            return $return_data;
		}
		//get checkin setting

        $setting =  SysSetting::getSettingsByKey('job');


        //grace period checking
        if($setting['CHECKIN_GRACE_PERIOD'] )
        {
            $value=  $setting['CHECKIN_GRACE_PERIOD']['value'];
            $ctrl_type=  $setting['CHECKIN_GRACE_PERIOD']['ctrl_type'];
            $grace_time =   Utility::checkinTimeSecond($value, $ctrl_type );
            $now_time= time();
            $job_details =  Job::where('id', $job_id)->first();
            $starting_from= strtotime($job_details['starting_from']);
            $from_time= $starting_from-$grace_time;
            $to_time= $starting_from+$grace_time;

            if(  $now_time>=$from_time &&  $now_time<=$to_time){
            }
            else
            {
                $return_data['status']=(Boolean)false;
                $return_data['message']="Check-in Grace period expired, contact client to manual check-in";
                $return_data['data']=new \stdClass();
                $return_data['error']['field_error']=array();
                return $return_data;
            }
        }
        //grace period checking

			$req = $request->all();
			
			$data['job_id'] = $job_id;
			$data['user_id'] = $user_id;
			$data['checkin_type'] = 'self';
            $data['checkin_status'] = Checkin::STATUS_PENDING;
			//$data['checkin_status'] = 'pending';
			$data['checkin_time']=date("Y-m-d H:i:s");
			//$data['checkout_time']=date("Y-m-d H:i:s");
		    if(@$req['checkin_lat']!='')
            {
                $data['checkin_lat'] = $req['checkin_lat'];
            }

            if(@$req['checkin_lng']!='')
            {
                $data['checkin_lng'] = $req['checkin_lng'];
            }


			//print_r($req); die;
			
			$application = Checkin::create($data);
			$checkin_id = $application->id;
		
		$return_data['status']=(Boolean)true;
        $return_data['message']="Your checkin process completed successfully. please wait for client approval";
        $return_data['data']=array('checkin_id'=>$checkin_id);
        return $return_data;
	}
	
	/*
	  @Descriptuon: Checkout for a job
	  @Status: done
	  @return  json
      @Created By Manjeet Kumar
	  @Created Date: 18-3-2019
	  @Modified Date: 18-3-2019
	*/
    public function checkout(Request $request, $job_id)
    {
		$user_id  = \Auth::id();
		$job_id= (Int)$request['job_id'];
		
		$already_applied =  Checkin::where('job_id', $job_id)->where('user_id', $user_id)->first();
		if(!$already_applied)
		{
			$return_data['status']=(Boolean)false;
            $return_data['message']="You have not checkin for this job";
            $return_data['data']=new \stdClass();
			$return_data['error']['field_error']=array();
            return $return_data;
		}
		
		if($already_applied['checkout_time']!='')
		{
			$return_data['status']=(Boolean)false;
            $return_data['message']="You have already checked out.";
            $return_data['data']=new \stdClass();
			$return_data['error']['field_error']=array();
            return $return_data;
		}
		
		if($already_applied['checkin_status']==Checkin::STATUS_PENDING)
		{
			$return_data['status']=(Boolean)false;
            $return_data['message']="Your checkin is pending. wait for client approval.";
            $return_data['data']=new \stdClass();
			$return_data['error']['field_error']=array();
            return $return_data;
		}


        $job_details =  Job::where('id', $job_id)->first();
        $job_end_time= strtotime($job_details['ending_at']);

        if(  time() >$job_end_time  )
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']="Job end time expired, contact client to manual check-out";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=array();
            return $return_data;
        }

		$total_time =  gmdate("H:i:s", ( time() -  strtotime($already_applied['checkin_time']))) ;
       // echo $total_time ;die;
		$req = $request->all();
		$data['job_id'] = $job_id;
		$data['user_id'] = $user_id;
		$data['total_work_time'] = $total_time;
        $data['checkout_type'] = 'self';
        $data['checkout_status'] = Checkin::STATUS_PENDING;
		$data['checkout_time']=date("Y-m-d H:i:s");

        if(@$req['checkout_lat']!='')
        {
            $data['checkout_lat'] = $req['checkout_lat'];
        }

        if(@$req['checkout_lng']!='')
        {
            $data['checkout_lng'] = $req['checkout_lng'];
        }

		//print_r($req); die;
		Checkin::where('job_id', '=', $job_id)->where('user_id', '=', $user_id)->update($data);
	
		$return_data['status']=(Boolean)true;
		$return_data['message']="Your checkout process completed successfully. please wait for client approval";
		$return_data['data']=new \stdClass();
		return $return_data;
	}
	
	
	/*
	  @Descriptuon: Check in out status
	  @Status: done
	  @return  json
      @Created By Manjeet Kumar
	  @Created Date: 18-3-2019
	  @Modified Date: 18-3-2019
	*/
    public function inoutstatus(Request $request, $job_id)
    {
		$user_id  = \Auth::id();
		$job_id= (Int)$job_id;
		
		$status = new \stdClass();
		$already_applied =  Checkin::where('job_id', $job_id)->where('user_id', $user_id)->first();
		if($already_applied)
		{
			$status  =  $already_applied;
		}
		$return_data['status']=(Boolean)true;
        $return_data['message']="";
        $return_data['data']['status']=$status;
        return $return_data;
	}

    /*
      @Descriptuon: Check in out status
      @Status: done
      @return  json
      @Created By Manjeet Kumar
      @Created Date: 18-3-2019
      @Modified Date: 18-3-2019
    */
    public function availability(Request $request)
    {
        $user_id  = \Auth::id();

        $v = Validator::make($request->all(), [
            'availability' => 'required'
        ]);

        if ($v->fails())
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']="Field validation error";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=$v->errors();
            return $return_data;
        }


        if($request['availability']=='online')
        {
            $data['is_online'] = true;
        }
        else
        {
            $data['is_online'] = false;
        }
        //print_r($req); die;
        User::where('id', '=', $user_id)->update($data);

        $return_data['status']=(Boolean)true;
        $return_data['message']="Status has been updated.";
        $return_data['data']=new \stdClass();
        return $return_data;
    }





}
