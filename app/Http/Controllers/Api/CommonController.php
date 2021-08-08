<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ObjSkillsController;
use App\UsersRole;
use App\Models\Contact;
use App\Models\JobApplication;
use App\Models\Job;
use App\Models\Checkin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\Types\Boolean;
use Illuminate\Support\Facades\DB;
use Validator;

class CommonController extends Controller
{
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

    /*
	  get list of all country
	  @return @json
      @Created By Manjeet Kumar
	  @Created Date: 13-2-2019
	  @Modified Date: 13-2-2019
	*/
    public function country(Request $request)
    {
        $country = DB::table('countries')->select('*')->get();
        $return_data['status']=(Boolean)true;
        $return_data['message']='';
        $return_data['data']=array('country'=>$country);
        return $return_data;
    }

    /*
         get list of all timezone
         @return @json
         @Created By Manjeet Kumar
         @Created Date: 13-2-2019
         @Modified Date: 13-2-2019
      */
    public function timezone(Request $request)
    {
        $timezone = DB::table('timezones')->select('*')->get();
        $return_data['status']=(Boolean)true;
        $return_data['message']='';
        $return_data['data']=array('timezone'=>$timezone);
        return $return_data;
    }


    public function page(Request $request)
    {

        $request_data = @$_REQUEST['key'];

        $data =new \stdClass;
        if($request_data=='privacy') {
            $data = DB::table('sys_settings')->select('*')->where('key',$request_data)->first();

        }
        elseif($request_data=='terms_staff')
        {
            $data  = DB::table('sys_settings')->select('*')->where('key',$request_data)->first();
        }
        elseif($request_data=='terms_client')
        {
            $data  = DB::table('sys_settings')->select('*')->where('key',$request_data)->first();
        }

       // print_r($data); ; die;

        $return_data['status']=(Boolean)true;
        $return_data['message']='';
        $return_data['data']=array('data'=> $data );
        return $return_data;
    }
	
	
	/*
	 @description: Contact us api
	 @Method: Post
	 @return @json
	 @Created By Manjeet Kumar Patel
	 @Created Date: 20-2-2019
	 @Modified Date: 20-2-2019
    */
    public function contactus(Request $request)
    {
       $input = $request->all();

        $v = Validator::make($request->all(), [
            'email' => 'required|email|unique:contact_us',
            'subject' => 'required|min:2|max:50',
            'message' => 'required|min:50',
        ],
		[
            'email.unique' => 'You are already subscribed',
        ]);

        if ($v->fails())
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']="Field validation error";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=$v->errors();
            return $return_data;
        }
		else
		{
			$input['created_at'] = date("Y-m-d");
			$user_data = Contact::create($input);
			$return_data['status']=(Boolean)true;
            $return_data['message']="Your details has been successfully successfully, our representative will contact you soon.";
            $return_data['data']=new \stdClass();
            return $return_data;
		}
    }
	
	 /*
	  get List of Job Status
	  @return @json  
	  @Created By Manjeet Kumar
	  @Created Date: 21-2-2019
	  @Modified Date: 21-2-2019
	*/
	public function jobstatus(Request $request)
	{
		//$status= array('draft'=>'draft','published'=>'published','cancelled'=>'cancelled' );
		$status= Job::$status_client;
		$status_list=array();

		foreach($status as $key=>$value)
        {
            $status_list[] =array('label'=>$value, 'status'=> $key);
        }

        //print_r($status_list) ;die;
		$return_data['status']=(Boolean)true;
		$return_data['message']='';
		$return_data['data']['client_job_status']=$status_list;
        return $return_data;
    }

    /*
     get List of applicant status
     @return @json
     @Created By Manjeet Kumar
     @Created Date: 8-3-2019
     @Modified Date: 8-3-2019
    @return    {"status":true,"message":"","data":{"applicant_status":[{"label":"Confirmed","status":"confirmed"},
    {"label":"Pending","status":"pending"},{"label":"Rejected","status":"rejected"}]}}
   */
    public function applicantstatus(Request $request)
    {
        $status= JobApplication::$status_applicant;
        $status_list=array();

        foreach($status as $key=>$value)
        {
            $status_list[] =array('label'=>$value, 'status'=> $key);
        }

        //print_r($status_list) ;die;
        $return_data['status']=(Boolean)true;
        $return_data['message']='';
        $return_data['data']['applicant_status']=$status_list;
        return $return_data;
    }


    public function minMaxExperience(Request $request)
    {
        $max_val = DB::table('staff_jobs')->max('exp_months_count');
        $min_val = DB::table('staff_jobs')->min('exp_months_count');
        $return_data['status']=(Boolean)true;
        $return_data['message']='';
        $return_data['data']=array('min_experience'=>$min_val, 'max_experience'=>$max_val    );
        return $return_data;
    }


	//check in checkout status
	public function inoutStatus(Request $request)
    {
        $status= Checkin::$inout_status;
        $status_list=array();

        foreach($status as $key=>$value)
        {
            $status_list[] =array('label'=>$value, 'status'=> $key);
        }

        //print_r($status_list) ;die;
        $return_data['status']=(Boolean)true;
        $return_data['message']='';
        $return_data['data']['inout_status']=$status_list;
        return $return_data;
    }


}