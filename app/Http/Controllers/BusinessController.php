<?php

namespace App\Http\Controllers;


use App\Classes\Utility;
use App\Models\Business;
use App\Models\Addresses;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobVacency;
use App\Models\ObjSkillsRef;
use App\Models\StaffJob;
use App\Models\StaffJobSkill;
use App\Models\Staff;
use App\Models\Timezone;
use App\Models\SysSetting;
use App\Models\WalletOperation;
use App\Models\Checkin;
use App\Models\BusinessPayment;
use App\Role;
use App\Todo;
use App\Models\Stripe;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Validator;
class BusinessController extends Controller
{

    public function index()
    {

    }

    public function show($id)
    {
       // $id=(Integer)$id;

        $id  = \Auth::id();

        $data = User::getBusinessDetails($id);
        $return_data['status']=(Boolean)true;
        $return_data['message']="";
        $return_data['data']=$data;
        /*
        $address_details  = Addresses::where('user_id', $id);
        $address_details  = $address_details->where('obj_table_ref', 'businesses');
        $address_details  = $address_details->where('type','profile');
        $address_details = $address_details->first();
        */
        $param['user_id'] = $id;
        $param['obj_table_ref'] = 'businesses';
        $param['type'] = 'profile';

        $return_data['data']['address']=new \stdClass();
        $address_data=  Addresses::getAddress($param);

        if( $address_data)
        {
            $return_data['data']['address'] = $address_data;
        }


        //$return_data['data']['address']=$address_details;

        return $return_data;
    }

    public function update(Request $request, $id)
    {
        $id=(Integer)$id;
       // echo "<pre>"; print_r($request->all()); die;
        $is_exists = User::doesExistBusiness($id);
        if(!$is_exists)
        {
            $arr['status'] = (Boolean)false;
            $arr['message'] ="Business does not exists";
            $arr['data'] =new \stdClass();
            $arr['error']['field_error']=array();
            return  $arr;
        }

        $request->merge(['id' => $id]);

        $v = Validator::make($request->all(), [
            'id' => ['required'],
            'name' => ['required'],
            'business_category_id' => ['required'],
            'contact1' => ['required'],
            'address1' => ['required'],
            'city' => ['required'],
            'zipcode' => ['required'],
            /* 'state' => ['required'],*/
            'country_id' => ['required'],
            'timezone_id' => ['required'],

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

        //$validation = User::validateBusinessUpdates($request);

        $business = User::find($id);
        $business->update($request->all());

        $business_details = Business::where('user_id', $id)->first();

        if($business_details){

            $business_id= $business_details->id;
            $reqs = $request->all();
            $reqs['business_name'] = $reqs['name'];
            $reqs['business_detail'] = @$reqs['business_detail'];
           // print_r($reqs); die;
            $business_details->update($reqs);
        }else{
            $reqs = $request->all();
            $reqs['user_id'] = $id;
            $reqs['business_name'] = $reqs['name'];
            $reqs['business_detail'] = @$reqs['business_detail'];
            $business_id =  Business::create($reqs)->id;
        }
       // update business address
        $address_details  = Addresses::where('user_id', $id);
        $address_details  = $address_details->where('obj_table_ref', 'businesses');
        $address_details  = $address_details->where('object_id',$business_id);
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
            $add['obj_table_ref'] = 'businesses';
            $add['type'] = 'profile';
            $add['object_id'] = $business_id;
            $add['is_default'] = true;
            $add['address1'] = @$reqs['address1'];
            $add['address2'] = @$reqs['address2'];
            $add['zipcode'] = (Integer)@$reqs['zipcode'];
            $add['city'] = @$reqs['city'];
            $add['state'] = @$reqs['state'];
            $add['country_id'] = (Integer)@$reqs['country_id'];
            $add['contact1'] = @$reqs['contact1'];
            $add['contact2'] = @$reqs['contact2'];

           // echo "<pre>"; print_r($add); die;
            Addresses::create($add);
        }

        // update business address
        $return_data['status']=(Boolean)true;
        $return_data['message']="Business details has been updated successfully.";
        $return_data['data']=new \stdClass();
        return $return_data;
    }

	/*
	  @Descriptuon: update staff Preference
	  @Status: done
	  @return  json
      @Created By Manjeet Kumar
	  @Created Date: 21-2-2019
	  @Modified Date: 26-2-2019
	*/



    public function updateStaffPreference(Request $request, $id)
    {
        $id=(Integer)$id;
		$input = $request->all();

        $v = Validator::make($request->all(), [
           'preference' => 'required'
        ]);

        if ($v->fails())
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']="Field validation error";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=$v->errors();
            return $return_data;
        }
		
		if($input['preference']!='true')
		{
			$return_data['status']=(Boolean)false;
            $return_data['message']="Preference must be true";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=array();
            return $return_data;
		}
		
		$user_id  = \Auth::id();
		
		
		$update_data['preferences'] = $input['preference'];
		Staff::where('user_id', $user_id )->update($update_data);
		
        $return_data['status']=(Boolean)true;
        $return_data['message']="Preference has been updated successfully.";
        $return_data['data']=new \stdClass();
        return $return_data;
    }
	
	
	public function updateBusinessPreference(Request $request, $id)
    {
        $id=(Integer)$id;
		$input = $request->all();
		
		
        $v = Validator::make($request->all(), [
           'preference' => 'required'
        ]);

        if ($v->fails())
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']="Field validation error";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=$v->errors();
            return $return_data;
        }
		
		if($input['preference']!='true')
		{
			$return_data['status']=(Boolean)false;
            $return_data['message']="Preference must be true";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=array();
            return $return_data;
		}
		
		$user_id  = \Auth::id();
		
		
		$update_data['preferences'] = $input['preference'];
		Business::where('user_id', $user_id )->update($update_data);
		
        $return_data['status']=(Boolean)true;
        $return_data['message']="Preference has been updated successfully.";
        $return_data['data']=new \stdClass();
        return $return_data;
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

	
	/*
	  @Descriptuon: Update Single Job
	  @Status: done
	  @return  json
      @Created By Manjeet Kumar
	  @Created Date: 21-2-2019
	  @Modified Date: 21-2-2019
	*/

	public function updateSingleJob(Request $req)
    {

        $input = $req->all();

		$v = Validator::make($req->all(), [
			'event_name' => 'required',
			'job_id' => 'required|integer',
            'job_title_id' => 'required|integer',
            'exp_count' => 'required|integer',
            'skills' => 'required|JSON',
			'exp_count_type' => 'required',
			'starting_from' => 'required',
			'ending_at' => 'required',
			'address1' => 'required',
			'address2' => 'required',
			'city' => 'required',
			'contact1' => 'required',
			'country_id' => 'required',
			'description' => 'required',
			'state' => 'required',
			'timezone_id' => 'required|integer',
			'zipcode' => 'required|integer',
            'salary' => 'required|integer',
        ]);

        if ($v->fails())
        {

			$return_data['status']=(Boolean)false;
            $return_data['message']="Field validation error";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=$v->errors();
			 return $return_data;
        }



        $setting =  SysSetting::getSettingsByKey('job');
        // echo "<pre>";print_r($setting); die;
        if($setting['MAX_JOB_SCHEDULE_LIMIT'] )
        {
            $value=  $setting['MAX_JOB_SCHEDULE_LIMIT']['value'];
            $ctrl_type=  $setting['MAX_JOB_SCHEDULE_LIMIT']['ctrl_type'];
            $result =   Utility::maxJobScheduleLimitMinute($value, $ctrl_type );

            $end_time = strtotime($input['ending_at'])-time();
            if( $end_time > $result*60 ) {

     
				$return_data['status']=(Boolean)false;
				$return_data['message']="MAX_JOB_SCHEDULE_LIMIT exceeded ";
				$return_data['data']=new \stdClass();
				$return_data['error']['field_error']=array();
				 return $return_data;
            }
        }


        $business_user_id  = \Auth::id();

        $job_id = (Integer)$input['job_id'];
        $job = Job::where('business_user_id', $business_user_id)->where('id', $job_id);
        $job_details = $job->first();

        //echo "<pre>"; print_r($job_details); die;
        if(!$job_details )
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']="Job id not found";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=array();
            return $return_data;
        }

        /*
        if(  $setting['MIN_JOB_HOURS']['value']  )
        {
            $value=  $setting['MIN_JOB_HOURS']['value'];
            $ctrl_type=  $setting['MIN_JOB_HOURS']['ctrl_type'];
            $result =   Utility::minJobHour($value, $ctrl_type );

            $difftime=  (strtotime($input['ending_at'])-strtotime($input['starting_from']))/3600;

            $min_amount=   $difftime *  $setting['MIN_HOURLY_JOB_RATE']['value'] *  $job_details->vacencies;

            if(  $req['salary']<  $min_amount) {
               
				$return_data['status']=(Boolean)false;
				$return_data['message']="Minumum amount must be gretter than " . $min_amount;
				$return_data['data']=array();
				$return_data['error']['field_error']=array();
				return 	$return_data;
            }
            //echo $min_amount; die;
        }

        */
		 

		
		$input['min_experience'] = @$req['exp_count'];
		$exp_months_count = $req['exp_count'];
		if($req['exp_count_type'] == 'year')
		{
		    $job_data['min_experience'] = $exp_months_count * 12;
		}

		$job_data['event_name'] = @$req['event_name'];
		$job_data['job_title_id'] = @$req['job_title_id'];
		$job_data['starting_from'] = @$req['starting_from'];
		$job_data['ending_at'] = @$req['ending_at'];
		$job_data['address1'] = @$req['address1'];
		$job_data['address2'] = @$req['address2'];
		$job_data['city'] = @$req['city'];
		$job_data['contact1'] = @$req['contact1'];
		$job_data['country_id'] = @$req['country_id'];
		$job_data['description'] = @$req['description'];
		$job_data['state'] = @$req['state'];
		$job_data['timezone_id'] = @$req['timezone_id'];
		$job_data['zipcode'] = @$req['zipcode'];
		$job_data['lat'] = @$req['lat'];
		$job_data['lng'] = @$req['lng'];
        $job_data['salary'] = @$req['salary'];
        if(@$req['status'])
        {
            $job_data['status'] = @$req['status'];
        }

        if( @$req['lat'] && @$req['lng'] )
        {
            $job_data['geometry_location'] = DB::raw('ST_POINT( '.(double)$req['lng'].'  , '.(double)$req['lng'].'   )') ;
        }

        $job_data['updated_at'] = date('Y-m-d H:i:s');
		
		Job::where('id', $job_id )->update($job_data);


		$input['skills']  = json_decode( @$input['skills'] ,true);
        if($job_id && @$input['skills'])
		{
           $this->deleteSkillsForJob($job_id);
           if(is_array($input['skills']) && count($input['skills']))
		   {
               foreach ($input['skills'] as $skill_id){
                   $obj = new ObjSkillsRef();
                   $obj->skill_id = $skill_id;
                   $obj->obj_id =$job_id;
                   $obj->obj_table_ref = 'jobs';
                   $obj->save();
               }
           }
        }

        $return_data['status']=(Boolean)true;
        $return_data['message']="Job details has been updated successfully";
        $return_data['data']= new \stdClass();
        return $return_data;
    }


	 /*
	  @Descriptuon: Add New Job 
	  @Status: done
	  @return  json
      @Created By Manjeet Kumar
	  @Created Date: 21-2-2019
	  @Modified Date: 28-3-2019
	*/

    public function storeJob(Request $req)
    {
        $input = $req->all();


		$v = Validator::make($req->all(), [
			'event_name' => 'required',
            'job_title_id' => 'required|integer',
            'person_no' => 'required|integer',
            'exp_count' => 'required|integer',
            'skills' => 'required',
			'exp_count_type' => 'required',
			'starting_from' => 'required',
			'ending_at' => 'required',
			'address1' => 'required',
//			'address2' => 'required',
			'city' => 'required',
			'contact1' => 'required',
			'country_id' => 'required',
			'description' => 'required',
			'state' => 'required',
			'timezone_id' => 'required',
			'zipcode' => 'required|integer',
            'salary' => 'required|integer',
        ]);

        if ($v->fails())
        {
			$return_data['status']=(Boolean)false;
			$return_data['message']="Field validation error";
			$return_data['data']=new \stdClass();
			$return_data['error']['field_error']=$v->errors();		

			 return $return_data;
        }



        $setting =  SysSetting::getSettingsByKey('job');
        // echo "<pre>";print_r($setting); die;
        if($setting['MAX_JOB_SCHEDULE_LIMIT'] )
        {
            $value=  $setting['MAX_JOB_SCHEDULE_LIMIT']['value'];
            $ctrl_type=  $setting['MAX_JOB_SCHEDULE_LIMIT']['ctrl_type'];
            $result =   Utility::maxJobScheduleLimitMinute($value, $ctrl_type );

            $end_time = strtotime($input['ending_at'])-time();
            if( $end_time > $result*60 ) {

                $return_data['status']=(Boolean)false;
                $return_data['message']="MAX_JOB_SCHEDULE_LIMIT exceeded ";
                $return_data['data']=new \stdClass();
				$return_data['error']['field_error']=array();			
                return $return_data;
            }
        }

        /*
        if(  $setting['MIN_JOB_HOURS']['value']  )
        {
            $value=  $setting['MIN_JOB_HOURS']['value'];
            $ctrl_type=  $setting['MIN_JOB_HOURS']['ctrl_type'];
            $result =   Utility::minJobHour($value, $ctrl_type );

            $difftime=  (strtotime($input['ending_at'])-strtotime($input['starting_from']))/3600;

            $min_amount=   $difftime *  $setting['MIN_HOURLY_JOB_RATE']['value'] *  $input['person_no'];

            if(  $req['salary']<  $min_amount) {
                $return_data['status'] = (Boolean)false;
                $return_data['message'] = " Minimum amount must be gretter than " . round($min_amount,2);
				$return_data['data']=new \stdClass();
				$return_data['error']['field_error']=array();	
                return $return_data;
            }
            //echo $min_amount; die;
        }
        */
        $input['min_experience'] = @$req['exp_count'];
		
		$exp_months_count = $req['exp_count'];
		if($req['exp_count_type'] == 'year')
		{
		    $input['min_experience'] = $exp_months_count * 12;
		}
		
		$business_user_id  = \Auth::id();

		$input['created_at'] = date('Y-m-d H:i:s');
		$input['payment_status'] = 'pending';
		$vacancy = @$input['person_no'];
		$input['vacencies'] =  (Integer)$vacancy;

        if(@$input['status'])
        {
            $input['status'] = @$req['status'];
        }
        else
        {
            $input['status'] = Job::STATUS_DRAFT;
        }

        if( @$input['lat'] && @$input['lng'] )
        {
            $input['geometry_location'] = DB::raw('ST_POINT( '.(double)$input['lng'].'  , '.(double)$input['lng'].'   )') ;
        }

		$input['business_user_id'] = $business_user_id;
	   //print_r( $input); die;
		$job = Job::create($input);
		$job_id = $job->id;
		$this->createVacencies($job_id, @$input['person_no']);


		$input['skills']  = json_decode( @$input['skills'] ,true);

        if($job_id && @$input['skills'])
		{
           $this->deleteSkillsForJob($job_id);
           if(is_array($input['skills']) && count($input['skills'])){
               foreach ($input['skills'] as $skill_id){
                   $obj = new ObjSkillsRef();
                   $obj->skill_id = $skill_id;
                   $obj->obj_id =$job_id;
                   $obj->obj_table_ref = 'jobs';
                   $obj->save();
               }
           }
        }

        $return_data['status']=(Boolean)true;
        $return_data['message']="Job posted successfully.";
        $return_data['data']= array( 'job_id'=>$job_id  );
        return $return_data;
    }
	
	 /*
	  @Descriptuon: Business Get Single Job Details
	  @Status: done
	  @return  json
      @Created By Manjeet Kumar
	  @Created Date: 21-2-2019
	  @Modified Date: 21-2-2019
	*/
	
	public function getSingleJobs(Request $request)
    {
		
		$request = $request->all(); 
		$job_id= @$request['job_id'];
		
		if ($job_id=='')
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']='Please send  job id';
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=array();
            return $return_data;
        }
		
		$business_user_id  = \Auth::id();

		$jobs = Job::leftJoin('job_applications','jobs.id', '=', 'job_applications.job_id');
		$jobs->leftJoin('countries','jobs.country_id', '=', 'countries.id');
		$jobs->leftJoin('job_titles','jobs.job_title_id', '=', 'job_titles.id');
        $jobs->leftJoin('timezones','jobs.timezone_id', '=', 'timezones.id');
		$jobs->select('jobs.*',  DB::raw('count(job_applications.job_id) as total_applicant'),'countries.title as country_name', 'job_titles.title as job_title' );
        $jobs->addSelect('timezones.zone as timezone_name' , 'timezones.gmt');
		$jobs->where('jobs.business_user_id',$business_user_id);
		$jobs->where('jobs.id',$job_id);
		$jobs->groupBy('jobs.id',  'countries.title','job_titles.title' ,'timezones.zone' , 'timezones.gmt'  );
		
		$jobs=  $jobs->first();

		//return $jobs;

		$job_list=new \stdClass();
		if($jobs)
		{
			$job_list= $jobs->toArray();
			
			
			$job_list['address_formatted'] = Utility::getFormattedAddress([
				'address1' => $job_list['address1'],
				'address2' => $job_list['address2'],
				'city' => $job_list['city'],
				'state' => $job_list['state'],
				'country' => @$job_list['country_name'],
			]);

            $job_list['total_confirmed'] =   JobApplication::totalApplicantByStatus( $job_list['id'] , JobApplication::STATUS_CONFIRMED );

            $job_list['skills'] = $this->getSkillsForJob($job_list['id']);
            $format= array();
            foreach($job_list['skills'] as $skill_formating)
            {
                $format[] =$skill_formating['title'];
            }

            $job_list['skills_formated'] = implode(", ", $format);

            $job_list['vacencies_list'] = $this->getVacencies($job_list['id']);
		}

		//echo "<pre>"; print_r($job_list) ; die;


		$return_data['status']=(Boolean)true;
        $return_data['message']="";
        $return_data['data']['jobs']=$job_list;
		return $return_data;
		
    }

    /*
	  @Description : Get Job whose check-in requested
	  @Status: done
	  @return  json
      @Created By Manjeet Kumar
	  @Created Date: 1-4-2019
	  @Modified Date: 1-4-2019
	*/
    public function checkin(Request $req)
    {
       // echo 45;die;

        $business_user_id  = \Auth::id();
        $status = $req->get('status');
        $type = $req->get('type');

        if ($status=='' || $type==''  )
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']='Please send  type and status';
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=array();
            return $return_data;
        }


        $field = $req->get('field') != '' ? $req->get('field') : 'checkin_checkout.checkin_time';
        $sort = $req->get('sort') != '' ? $req->get('sort') : 'desc';

        $jobs = Job::join('checkin_checkout','checkin_checkout.job_id', '=', 'jobs.id');
        $jobs->leftJoin('countries','jobs.country_id', '=', 'countries.id');
        $jobs->leftJoin('job_titles','jobs.job_title_id', '=', 'job_titles.id');
        $jobs->leftJoin('timezones','jobs.timezone_id', '=', 'timezones.id');
       // $jobs->join('checkin_checkout','checkin_checkout.job_id', '=', 'jobs.id');
        $jobs->select('jobs.*', 'countries.title as country_name', 'job_titles.title as job_title');
        $jobs->addSelect('timezones.zone as timezone_name');
        $jobs->where('jobs.business_user_id',$business_user_id);

        if($type=='checkout')
        {
            $jobs->addSelect(DB::raw('count(checkin_checkout.checkout_status) as status_count_applicant'));
            $jobs->where('checkin_checkout.checkout_status',$status);
        }
        else
        {
            $jobs->addSelect(DB::raw('count(checkin_checkout.checkin_status) as status_count_applicant'));
            $jobs->where('checkin_checkout.checkin_status',$status);
        }

       $jobs->groupBy('checkin_checkout.job_id','jobs.id',  'countries.title','job_titles.title','timezones.zone');

        $jobs->orderBy('jobs.created_at','DESC');

        $jobs=  $jobs->paginate(20);

        $jobs->transform(function($item){

            $item['total_confirmed'] =   JobApplication::totalApplicantByStatus( $item->id , JobApplication::STATUS_CONFIRMED );
            $item['total_applicant'] =   JobApplication::totalApplicant( $item->id );

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
            $item['vacencies_list'] = $this->getVacencies($item->id);


            return $item;

        });

        $job_list=array();
        if($jobs)
        {
            $job_list= $jobs->toArray();
        }


        $return_data['status']=(Boolean)true;
        $return_data['message']="";
        $return_data['data']= $job_list;
        return $return_data;

    }

	/*
	  @Descriptuon: Business Get All Posted Job Details
	  @Status: done
	  @return  json
      @Created By Manjeet Kumar
	  @Created Date: 21-2-2019
	  @Modified Date: 15-3-2019
	*/
    public function getJobs(Request $req)
    {
		$business_user_id  = \Auth::id();
        $job_title_id = @array_filter($req->get('job_title_id')); //array
        $status = @array_filter($req->get('status')); //array
        $address_id = @array_filter($req->get('address_id')); //array
        $starting_from = trim($req->get('starting_from')); //text
        $ending_at = trim($req->get('ending_at')); //text
        $job_type = @trim($req->get('job_type')); //text

		$field = $req->get('field') != '' ? $req->get('field') : 'jobs.created_at';
        $sort = $req->get('sort') != '' ? $req->get('sort') : 'desc';

		$jobs = Job::leftJoin('job_applications','jobs.id', '=', 'job_applications.job_id');
		$jobs->leftJoin('countries','jobs.country_id', '=', 'countries.id');
		$jobs->leftJoin('job_titles','jobs.job_title_id', '=', 'job_titles.id');
        $jobs->leftJoin('timezones','jobs.timezone_id', '=', 'timezones.id');
		$jobs->select('jobs.*',  DB::raw('count(job_applications.job_id) as total_applicant'),'countries.title as country_name', 'job_titles.title as job_title');
        $jobs->addSelect('timezones.zone as timezone_name');

		$jobs->where('jobs.business_user_id',$business_user_id);


        if($job_type=='old')
        {
            $jobs->where('jobs.ending_at', '<=',    date("Y-m-d H:i:s"));
        }
        elseif($job_type=='upcoming')
        {
            $jobs->where('jobs.ending_at', '>=',    date("Y-m-d H:i:s"));
        }


		//echo "<pre>"; print_r($_REQUEST); die;
		if(!empty($job_title_id))
		{
            $job_title_id = array_map('intval', $job_title_id);
            $jobs->whereIn('jobs.job_title_id',$job_title_id);
		}

        if(!empty($status))
        {
            $jobs->whereIn('jobs.status',$status);
        }

        if(!empty($address_id))
        {
            $address_id = array_map('intval', $address_id);
            $jobs->whereIn('jobs.address_id',$address_id);
        }

        if($starting_from!='')
        {
            $jobs->where('jobs.starting_from', '>=',   date("Y-m-d H:i:s",strtotime($starting_from))  );
        }

        if($ending_at!='')
        {
            $jobs->where('jobs.ending_at', '<=',    date("Y-m-d H:i:s",strtotime($ending_at))  );
        }

		$jobs->groupBy('jobs.id',  'countries.title','job_titles.title','timezones.zone');

		$jobs->orderBy('jobs.created_at','DESC');
		
		$jobs=  $jobs->paginate(20);
		
		$jobs->transform(function($item){

            $item['total_confirmed'] =   JobApplication::totalApplicantByStatus( $item->id , JobApplication::STATUS_CONFIRMED );

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
            $item['vacencies_list'] = $this->getVacencies($item->id);


		   return $item;
			  
		 });
		
		$job_list=array();
		if($jobs)
		{
			$job_list= $jobs->toArray();
		}


		$return_data['status']=(Boolean)true;
        $return_data['message']="";
        $return_data['data']= $job_list;
		return $return_data;
		
		
		
		/*
		
        $color_codes = Job::COLOR_CODES; // 15 color codes
        $qry = Job::with('jobTitle')
            ->with('country')
            ->where('business_user_id', $business_user_id)
            ;
        $prepare_cal_data = $req->get('include_calendar_data')?true:false;


 
            $qry->where('ending_at','>=', date('Y-m-d H:i:s'));
            $qry->orderBy('id','DESC');
            $data = $qry->get();
            $calender_data = [];
           

            $color_index = 0;
            $data->transform(function($item) use(&$calender_data, $prepare_cal_data, $color_codes, &$color_index){
                $created_at = $event_date = $starting_from_formated = null;
                if($item->created_at){
                    $created_at = Utility::getFormatedDate($item->created_at);
                }


                if($prepare_cal_data){


                    $dt1 = (string) Utility::getFormatedDate($item->starting_from, ['format' => 'Y-m-d']);
                    $dt2 = (string) Utility::getFormatedDate($item->ending_at, ['format' => 'Y-m-d']);

                    $item1 = ['key' => $item->id];
                    $color_code = $color_codes[$color_index];

                    $color_index++;
                    if($dt1 == $dt2){
                        $item1['startingDay'] = true;
                        $item1['endingDay'] = true;
                        $item1['color'] = $color_code;
                        $calender_data[$dt1]['dots'][] = $item1;
                        $calender_data[$dt1]['selected'] = true;
                        $calender_data[$dt1]['selectedColor'] = 'orange';

                    }else{

                        if($dt2=='N/A')
                        {
                            $dates_arr =array($dt1);
                        }
                        else
                        {
                            $dates_arr = Utility::getDatesBetween($dt1, $dt2);
                        }

                        foreach ($dates_arr as $key => $date) {
                            $item1['startingDay'] = true;
                            $item1['endingDay'] = true;
                            $item1['color'] = $color_code;
                            $calender_data[$date]['dots'][] = $item1;
                            $calender_data[$date]['selected'] = true;
                            $calender_data[$date]['selectedColor'] = 'orange';
                        }
                       
                    }
                }

                $event_date = Utility::getFormatedDate($item->starting_from);
                $starting_from_formated = Utility::getFormatedDate($item->starting_from, ['type' => 'full']);
                $ending_at_formated = Utility::getFormatedDate($item->ending_at, ['type' => 'full']);
                $item['status_label'] = ucfirst($item->status);
                $item['created_at_formatted'] = $created_at;
                $item['event_date'] = $event_date;
                $item['starting_from_formatted'] = $starting_from_formated;
                $item['ending_at_formatted'] = $ending_at_formated;
                $item['skills'] = $this->getSkillsForJob($item->id);
                $item['vacencies'] = $this->getVacencies($item->id);
                $item['total_applicant']=DB::table('job_applications')->where('job_id',$item->id)->count();

                $item['address_formatted'] = Utility::getFormattedAddress([
                    'address1' => $item['address1'],
                    'address2' => $item['address2'],
                    'city' => $item['city'],
                    'state' => $item['state'],
                    'country' => @$item['country']['title'],
                ]);


                return $item;
            });
			
        $return_data['status']=(Boolean)true;
        $return_data['message']="";
        $return_data['data']['jobs']= $data;
        if($prepare_cal_data)
        {
            $return_data['data']['calender_data'] = $calender_data;
        }

        return $return_data;
		*/

    }

	/*
	  @Descriptuon: delete Job
	  @Status: done
	  @return  json
      @Created By Manjeet Kumar
	  @Created Date: 21-2-2019
	  @Modified Date: 21-2-2019
	*/
    public function deleteJob(Request $request)
    {
		$request = $request->all(); 
		$job_id= @$request['job_id'];
		
		if ($job_id=='')
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']='Please send  job id';
            $return_data['data']=new \stdClass();
			$return_data['error']['field_error']=array();
            return $return_data;
        }
		
		
		$business_user_id  = \Auth::id();
        $job_id   = (Integer)$job_id;
		
		
		$job = Job::where('business_user_id', $business_user_id)->where('id', $job_id);
		$job_details = $job->first();
		if(!$job_details)
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']='Invalid Job id';
            $return_data['data']=new \stdClass();
			$return_data['error']['field_error']=array();
            return $return_data;
        }
		
		/*
		$job_data['status'] = 'deleted';
		$job_data['updated_at'] = date('Y-m-d H:i:s');
		Job::where('id', $job_id )->update($job_data);
        */

        JobVacency::where('job_id',$job_id)->delete();
        JobApplication::where('job_id',$job_id)->delete();
        ObjSkillsRef::where('obj_id',$job_id)->where('obj_table_ref','jobs')->delete();
        Job::where('id',$job_id)->delete();
        Checkin::where('job_id',$job_id)->delete();

        $return_data['status']=(Boolean)true;
        $return_data['message']="Job deleted successfully.";
        $return_data['data']= array();
        return $return_data;
    }



	 /*
	  @Descriptuon: Get Job Applicant List(Staff) who applied job
	  @Status: done
	  @return  json
      @Created By Manjeet Kumar
	  @Created Date: 21-2-2019
	  @Modified Date: 21-2-2019
	*/

	public function getJobApplicant(Request $request)
    {
		$request = $request->all(); 
		$job_id= @(Integer)$request['job_id'];
        $job_title_id= @(Integer)$request['job_title_id'];
        $status= @$request['status']; //  job applicant status
        $location_name= @array_filter($request['location_name']); //array multiple
        $skills= @array_filter($request['skills']); //array multiple
        $min_experience_month= @(Integer)$request['min_experience_month'];
        $max_experience_month= @(Integer)$request['max_experience_month'];
		
		if ($job_id=='')
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']='Please send  job id';
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=array();
            return $return_data;
        }

		$job = Job::where('id', $job_id);
		$job_details = $job->first();
		if(!$job_details)
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']='Invalid job id';
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=array();
            return $return_data;
        }

		//$job_title_id= $job_details->job_title_id;
		//echo $job_title_id; die;
		$business_user_id  = \Auth::id();

		$jobs = JobApplication::join('users','users.id', '=', 'job_applications.user_id');
        $jobs->leftJoin('staff_jobs','staff_jobs.staff_user_id', '=', 'job_applications.user_id');
        $jobs->leftJoin('addresses','addresses.user_id', '=', 'job_applications.user_id');
        $jobs->leftJoin('staff_job_skills','staff_job_skills.staff_user_id', '=', 'job_applications.user_id');
		$jobs->select('users.id', 'users.firstname','users.lastname','job_applications.status as applicant_status','job_applications.created_at as applied_date','users.photo_src');
		$jobs->where('job_applications.job_id',$job_id);

        $jobs->where('addresses.obj_table_ref','=', 'staffs');
        $jobs->where('addresses.type','=', 'profile');

		if( $status!='')
        {
            $jobs->where('job_applications.status','=', $status);
        }

        if( $job_title_id!='')
        {
            $jobs->where('staff_job_skills.job_title_id','=', $job_title_id);
        }

        if( !empty($skills))
        {
            $jobs->whereIn('staff_job_skills.skill_id', $skills ) ;
        }


        //print_r($location_name) ;die;

        if( !empty($location_name))
        {
            $jobs->whereIn('addresses.state', $location_name ) ;
        }

        if( $min_experience_month!='')
        {
            $jobs->where('staff_jobs.exp_months_count','>=', $min_experience_month);
        }

        if( $max_experience_month!='')
        {
            $jobs->where('staff_jobs.exp_months_count','<=', $max_experience_month);
        }

		$jobs->groupBy('job_applications.user_id','users.id','job_applications.status','job_applications.created_at');


        $jobs=  $jobs->get();



        $applicant_list=array();
		if($jobs)
		{
			$applicant_list= $jobs->toArray();
			
			foreach($applicant_list as $key=>$value)
			{
				
				 $value['photo_src_decoded']=new \stdClass();
				 if($value['photo_src'])
				 {
					$decoded  = json_decode($value['photo_src'],true);
					$applicant_list[$key]['photo_src_decoded'] =$decoded;
				 }
				
			
				$param['user_id'] = $value['id'];
				$param['obj_table_ref'] = 'staffs';
				$param['type'] = 'profile';
				
				$address=new \stdClass();
				$job_title_data=array();
				$address_data=  Addresses::getAddress($param);
				if($address_data)
				{
					$address = $address_data;
					
					$address['address_formatted'] = Utility::getFormattedAddress([
						'address1' => $address_data['address1'],
						'address2' => $address_data['address2'],
						'city' => $address_data['city'],
						'state' => $address_data['state'],
						'country' => @$address_data['country_name'],
					]);
					
				}


                $staff_job=  StaffJob::getStaffJob( $value['id'] );

                $applicant_list[$key]['match_job_title'] = '';
                $applicant_list[$key]['match_experience_month'] = 0;

				foreach($staff_job as $keyskill=> $st_job)
				{
                    $job_skill_data=  StaffJobSkill::staffJobSkillNameArr( $st_job['job_id'] );
                    $staff_job[$keyskill]['skills'] = implode(",",$job_skill_data);

                    if( $job_title_id == $st_job['id'] )
                    {
                        $applicant_list[$key]['match_job_title'] = $st_job['title'];
                        $applicant_list[$key]['match_experience_month'] =$st_job['exp_months_count'];
                    }
                }
			
				$applicant_list[$key]['address'] = $address;
				$applicant_list[$key]['job_title'] = $staff_job;
                $applicant_list[$key]['inout_status'] = Checkin::getCheckinDetails(    $job_id  ,$value['id'] )  ;
			}
		}

		$return_data['status']=(Boolean)true;
        $return_data['message']="";
        $return_data['data']['applicant_list']= $applicant_list;
		return $return_data;
    }
	
	/*
	  @Descriptuon: Confirm or Reject Job Applicant
	  @Status: done
	  @return  json
      @Created By Manjeet Kumar
	  @Created Date: 21-2-2019
	  @Modified Date: 26-2-2019
	*/
    public function confirmApplicant(Request $request)
    {
		$v = Validator::make($request->all(), [
            'job_id' => 'required|integer',
            'user_id' => 'required|integer',
            'status' => 'required'
        ]);

        if ($v->fails())
        {			
			$return_data['status']=(Boolean)false;
			$return_data['message']="Field validation error";
            $return_data['data']=new \stdClass();
			$return_data['error']['field_error']=$v->errors();		
			return $return_data;
        }
		
		
		$request = $request->all(); 
		$job_id= @$request['job_id'];
		$user_id= @$request['user_id'];
		$status= @$request['status'];
		
		
		$vacancy = JobVacency::where('job_id', $job_id )->where('staff_id', $user_id )->first();
		if($vacancy)
		{
			$return_data['status']=(Boolean)false;
            $return_data['message']='These applicant already exists.';
            $return_data['data']=new \stdClass();
			$return_data['error']['field_error']=array();	
            return $return_data;
		}
		
		
		$vacancy = JobVacency::where('job_id', $job_id )->where('staff_id', Null )->first();
		if(!$vacancy)
		{
			$return_data['status']=(Boolean)false;
            $return_data['message']='No vacancy found';
            $return_data['data']=new \stdClass();
			$return_data['error']['field_error']=array();	
            return $return_data;
		}
		
		
		$business_user_id  = \Auth::id();
		
		$applicant_details = JobApplication::where('user_id', $user_id)->where('job_id', $job_id);
		$applicant_details = $applicant_details->first();
		if(!$applicant_details)
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']='No applicant found for this job';
            $return_data['data']=new \stdClass();
			$return_data['error']['field_error']=array();	
            return $return_data;
        }
		
		
		$job_data['status'] = $status;
        $job_data['updated_at'] = date('Y-m-d H:i:s');
		$job_data['updated_by'] = $business_user_id;
		JobApplication::where('id', $applicant_details->id )->update($job_data);
		
		
		if(  $status == 'confirmed')
		{
			$vacarr['status'] = $status;
			$vacarr['staff_id'] = $user_id;
			
			//print_r($vacarr);  die;
			
			JobVacency::where('id', $vacancy->id )->update($vacarr);
		}
		
		//print_r($applicant_details->id); die;
        $return_data['status']=(Boolean)true;
        $return_data['message']="Job applicant status has been updated successfully.";
        $return_data['data']= new \stdClass();
        return $return_data;
    }

    /*
	  @Descriptuon:  Job Applicant full details
	  @Status: done
	  @return  json
      @Created By Manjeet Kumar
	  @Created Date: 8-3-2019
	  @Modified Date: 8-3-2019
	*/


    public function getJobApplicantDetails(Request $request)
    {
        $v = Validator::make($request->all(), [
            'job_id' => 'required|integer',
            'applicant_id' => 'required|integer'
        ]);

        if ($v->fails())
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']="Field validation error";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=$v->errors();
            return $return_data;
        }

        $request = $request->all();
        $job_id= @$request['job_id'];
        $user_id= @$request['applicant_id'];


        $is_applied = JobApplication::where('job_id', '=', $job_id)->where('user_id', '=', $user_id)->first();
        if(!$is_applied)
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']="You have not applied for this job.";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=$v->errors();
            return $return_data;
        }

        $staff= Staff::getStaffDetails($user_id);


        $return_data['status']=(Boolean)true;
        $return_data['message']="";
        $return_data['data']= $staff;
        return $return_data;

    }
	

	public function getAllAddress(Request $request)
    {
		$business_user_id  = \Auth::id();
		$param['user_id'] =  $business_user_id;
		$param['obj_table_ref'] =  'jobs';
		$param['all'] =  true;
		
		$address_data= array();
		
		$address= Addresses::getAddress($param);
		if($address)
		{
			$address_data = $address;
		}
		
		
		$return_data['status']=(Boolean)true;
        $return_data['message']="";
        $return_data['data']['address']=$address_data;
        return $return_data;
	}



	public function addAddress(Request $request)
    {
		$business_user_id  = \Auth::id();
		
		
		$v = Validator::make($request->all(), [
			
			'address1' => 'required',
			'address2' => 'required',
			'city' => 'required',
			'country_id' => 'required|integer',
			'state' => 'required',
			'zipcode' => 'required|integer',
			'contact1' => 'required',
        ]);

        if ($v->fails())
        {

			$return_data['status']=(Boolean)false;
            $return_data['message']="Field validation error";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=$v->errors();
			 return $return_data;
        }

		$reqs = $request->all();
		$add['user_id'] = $business_user_id;
		$add['obj_table_ref'] = 'jobs';
		$add['type'] = 'jobs';
		$add['address1'] = @$reqs['address1'];
		$add['address2'] = @$reqs['address2'];
		$add['zipcode'] = (Integer)@$reqs['zipcode'];
		$add['city'] = @$reqs['city'];
		$add['state'] = @$reqs['state'];
		$add['country_id'] = (Integer)@$reqs['country_id'];
		$add['contact1'] = @$reqs['contact1'];
		$add['contact2'] = @$reqs['contact2'];
	   // echo "<pre>"; print_r($add); die;
		$address= Addresses::create($add);
		$address_id = $address->id;

		$return_data['status']=(Boolean)true;
        $return_data['message']="";
        $return_data['data']=array('address_id'=>$address_id);
        return $return_data;
	}
	
	
	public function getAddressById(Request $request, $id)
    {
		$business_user_id  = \Auth::id();
		
		$address = new \stdClass();
		$address_data = Addresses::where('id', '=', $id)->where('user_id', '=', $business_user_id)->first();
		if($address_data)
		{
			$address  =  $address_data;
		}
		
		$return_data['status']=true;
        $return_data['message']="";
        $return_data['data']=array('address'=>$address);
        return $return_data;
		
	}
	
	
	public function updateAddress(Request $request , $id)
    {
		$business_user_id  = \Auth::id();
		
		
		$v = Validator::make($request->all(), [
			'address1' => 'required',
			'address2' => 'required',
			'city' => 'required',
			'country_id' => 'required|integer',
			'state' => 'required',
			'zipcode' => 'required|integer',
			'contact1' => 'required',
        ]);

        if ($v->fails())
        {

			$return_data['status']=(Boolean)false;
            $return_data['message']="Field validation error";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=$v->errors();
			 return $return_data;
        }

		$reqs = $request->all();
		
		$add['address1'] = @$reqs['address1'];
		$add['address2'] = @$reqs['address2'];
		$add['zipcode'] = (Integer)@$reqs['zipcode'];
		$add['city'] = @$reqs['city'];
		$add['state'] = @$reqs['state'];
		$add['country_id'] = (Integer)@$reqs['country_id'];
		$add['contact1'] = @$reqs['contact1'];
		$add['contact2'] = @$reqs['contact2'];
	   // echo "<pre>"; print_r($add); die;
		Addresses::where('id', '=', $id)->where('user_id', '=', $business_user_id)->update($add);


		$return_data['status']=(Boolean)true;
        $return_data['message']="Address has been updated successfully.";
        $return_data['data']=new \stdClass();
        return $return_data;
	}
	
	public function deleteAddress(Request $request, $id)
    {
		$business_user_id  = \Auth::id();
		$address = new \stdClass();
		$address_data = Addresses::where('id', '=', $id)->where('user_id', '=', $business_user_id)->delete();
		
		$return_data['status']=(Boolean)true;
        $return_data['message']="Address has been deleted successfully.";
        $return_data['data']=new \stdClass();
        return $return_data;
	}




        /*
      @Descriptuon: Checkin  manual
      @Status: done
      @return  json
      @Created By Manjeet Kumar
      @Created Date: 29-3-2019
      @Modified Date: 29-3-2019
    */
    public function manualcheckin(Request $request, $job_id ,  $user_id)
    {

        //$user_id  = \Auth::id();
        $job_id= (Int)$request['job_id'];
        $user_id= (Int)$request['user_id'];
        $req = $request->all();


        $v = Validator::make($request->all(), [
            'checkin_time' => 'required',
        ]);

        if ($v->fails())
        {

            $return_data['status']=(Boolean)false;
            $return_data['message']="Field validation error";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=$v->errors();
            return $return_data;
        }


        $job_id= (Int)$request['job_id'];

        $already_applied =  Checkin::where('job_id', $job_id)->where('user_id', $user_id)->first();
        if($already_applied)
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']="Staff has have already checked in ";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=array();
            return $return_data;
        }


        $data['job_id'] = $job_id;
        $data['user_id'] = $user_id;
        $data['checkin_type'] = 'manual';
        $data['checkin_status'] = Checkin::STATUS_CONFIRMED;
        $data['checkin_time']=date("Y-m-d H:i:s", strtotime($req['checkin_time']));
        $data['checkin_client_comments'] = @$req['checkin_client_comments'];
        $data['checkin_client_update']=date("Y-m-d H:i:s");
        //print_r($data); die;

        $application = Checkin::create($data);
        $checkin_id = $application->id;

        $return_data['status']=(Boolean)true;
        $return_data['message']="Staff checkin process completed successfully";
        $return_data['data']=array('checkin_id'=>$checkin_id);
        return $return_data;
    }


        /*
    @Descriptuon: Check out  manual
    @Status: done
    @return  json
    @Created By Manjeet Kumar
    @Created Date: 29-3-2019
    @Modified Date: 29-3-2019
    */
    public function manualcheckout(Request $request, $job_id ,  $user_id)
    {

        $v = Validator::make($request->all(), [
            'checkout_time' => 'required',
        ]);

        if ($v->fails())
        {

            $return_data['status']=(Boolean)false;
            $return_data['message']="Field validation error";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=$v->errors();
            return $return_data;
        }

        //$user_id  = \Auth::id();
        $job_id= (Int)$request['job_id'];
        $user_id= (Int)$request['user_id'];

        $already_applied =  Checkin::where('job_id', $job_id)->where('user_id', $user_id)->first();
        if($already_applied['checkout_client_update']!='')
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']="You have already changed checkout status";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=array();
            return $return_data;
        }

        //print_r($request['checkout_time']); die;

        $total_time =  gmdate("H:i:s", ( strtotime($request['checkout_time']) -  strtotime($already_applied['checkin_time']))) ;
        // echo $total_time ;die;
        $req = $request->all();
        $data['job_id'] = $job_id;
        $data['user_id'] = $user_id;
        $data['total_work_time'] = $total_time;
        $data['checkout_type'] = 'manual';
        $data['checkout_status'] = Checkin::STATUS_CONFIRMED;
        $data['checkout_time']=@$request['checkout_time'];
        $data['checkout_client_update']=date("Y-m-d H:i:s");
        $data['checkout_client_comment'] = @$req['checkout_client_comment'];


       // print_r($data); die;

        //print_r($req); die;
        Checkin::where('job_id', '=', $job_id)->where('user_id', '=', $user_id)->update($data);

        $return_data['status']=(Boolean)true;
        $return_data['message']="Checkout process completed successfully.";
        $return_data['data']=new \stdClass();
        return $return_data;
    }

    /*
      @Descriptuon: Checkin  status update for a job
      @Status: done
      @return  json
      @Created By Manjeet Kumar
      @Created Date: 18-3-2019
      @Modified Date: 18-3-2019
    */
    public function checkinupdate(Request $request, $job_id ,  $user_id)
    {
		$v = Validator::make($request->all(), [
			'checkin_status' => 'required',
        ]);

        if ($v->fails())
        {

			$return_data['status']=(Boolean)false;
            $return_data['message']="Field validation error";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=$v->errors();
			 return $return_data;
        }

		//$user_id  = \Auth::id();
		$job_id= (Int)$request['job_id'];
		$user_id= (Int)$request['user_id'];
		$checkin_status= $request['checkin_status'];
		
		$already_applied =  Checkin::where('job_id', $job_id)->where('user_id', $user_id)->first();
		if($already_applied['checkin_client_update']!='')
		{
			$return_data['status']=(Boolean)false;
            $return_data['message']="You have already changed status";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=array();
			return $return_data;
		}
		
		
		
		
		
		$data['checkin_status'] = trim($request['checkin_status']);
		$data['checkin_client_update']=date("Y-m-d H:i:s");
		$data['checkin_client_comments'] = @$request['checkin_client_comments'];
		//print_r($req); die;
		Checkin::where('job_id', '=', $job_id)->where('user_id', '=', $user_id)->update($data);
	
		
		$return_data['status']=(Boolean)true;
        $return_data['message']="Checkin process completed successfully";
        $return_data['data']=new \stdClass();
        return $return_data;
	}
	
	/*
	  @Descriptuon: Checkout update status for a job
	  @Status: done
	  @return  json
      @Created By Manjeet Kumar
	  @Created Date: 18-3-2019
	  @Modified Date: 18-3-2019
	*/
    public function checkoutupdate(Request $request, $job_id ,  $user_id)
    {
		$v = Validator::make($request->all(), [
			'checkout_status' => 'required',
        ]);

        if ($v->fails())
        {

			$return_data['status']=(Boolean)false;
            $return_data['message']="Field validation error";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=$v->errors();
			return $return_data;
        }

		//$user_id  = \Auth::id();
		$job_id= (Int)$request['job_id'];
		$user_id= (Int)$request['user_id'];
		
		$already_applied =  Checkin::where('job_id', $job_id)->where('user_id', $user_id)->first();
		if($already_applied['checkout_client_update']!='')
		{
			$return_data['status']=(Boolean)false;
            $return_data['message']="You have already changed status";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=array();
			return $return_data;
		}



		$data['checkout_status'] = trim($request['checkout_status']);
		$data['checkout_client_update']=date("Y-m-d H:i:s");
		$data['checkout_client_comment'] = @$request['checkout_client_comment'];
		//print_r($req); die;
		Checkin::where('job_id', '=', $job_id)->where('user_id', '=', $user_id)->update($data);

		$return_data['status']=(Boolean)true;
        $return_data['message']="Checkout process completed successfully";
        $return_data['data']=new \stdClass();
        return $return_data;
	}
	
	
	/*
	  @Descriptuon:  get Check in out status
	  @Status: done
	  @return  json
      @Created By Manjeet Kumar
	  @Created Date: 18-3-2019
	  @Modified Date: 18-3-2019
	*/
    public function inoutstatus(Request $request, $job_id ,  $user_id)
    {
		
		//$user_id  = \Auth::id();
		$job_id= (Int)$job_id;
		$user_id= (Int)$user_id;
		
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
    @Descriptuon:  add money to wallet working
    @Status: working
    @return  json
    @Created By Manjeet Kumar
    @Created Date: 29-3-2019
    @Modified Date: 29-3-2019
    */
    public function addmoneytowallet(Request $request)
    {
        $business_user_id  = \Auth::id();

        $v = Validator::make($request->all(), [
            'amount' => 'required|integer',
            'card_id' => 'required',
            'currency' => 'required',
            'payment_description' => 'required'
        ]);

        if ($v->fails())
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']="Field validation error";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=$v->errors();
            return $return_data;
        }

        $user_details =  Business::where('user_id', $business_user_id)->first();

        $customer_id='';
        if(@$user_details->strip_data!='')
        {
            $josn_decode= json_decode($user_details->strip_data);
            $customer_id = $josn_decode->id;
        }

        if($customer_id=='')
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']="Your customer id not updated on stripe, please update first";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=array();;
            return $return_data;
        }

        $s = new Stripe();
        $s->url .= 'charges';
        $data['amount'] = $request['amount']*100;
        $data['currency'] = $request['currency'];
        $data['source'] = $request['card_id'];
        $data['description'] = 'add money to wallet of client';
        $payment = $s->post($data);

        $json_val = json_decode( $payment );
        if(!@$json_val->id)
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']=@$json_val->error->message;
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=array();
            return $return_data;
        }

		if(!@$json_val->id  )
		{
			$return_data['status']=(Boolean)false;
			$return_data['message']="Error in strip gateway for charge api";
			$return_data['data']=new \stdClass();
			$return_data['error']['field_error']=array();;
			return $return_data;
		}
		else
		{
		    $data= array();
			$data['user_id'] = $business_user_id;
			$data['payment_amount'] = $request['amount'];
			$data['payment_time'] = date("Y-m-d H:i:s");
			$payment_status= 'pending';
			if($json_val->paid)
            {
                $payment_status= 'success';
            }
			$data['payment_status'] = $payment_status;
			$data['payment_method'] = 'stripe';
			$data['transaction_id'] = $json_val->balance_transaction;
			$data['payment_card'] = $request['card_id'];
            $data['payment_currency'] = $request['currency'];
			$data['payment_gateway_response'] = json_encode($json_val);;
			$data['created_at'] = date("Y-m-d H:i:s");
		   // echo "<pre>"; print_r($add); die;
			$business_payment= BusinessPayment::create($data);
			$payment_id = $business_payment->id;

			if($payment_id  &&  $json_val->paid==true)
			{

                $user_wallet_details = User::where('id','=',$business_user_id)->first();
                $wallet_amount =  $user_wallet_details->wallet_amount;
                $wallet['wallet_amount'] =  $request['amount']+$user_wallet_details->wallet_amount;
                User::where('id', '=', $business_user_id)->update($wallet);

                // wallet operation
                $wallet_operation= array();
                $wallet_operation['user_id'] = $business_user_id;
                $wallet_operation['wallet_amount'] = $user_wallet_details->wallet_amount;
                $wallet_operation['plus_minus_amount'] = $request['amount'];
                $wallet_operation['plus_minus_type'] = 'plus';
                $wallet_operation['final_amount'] = $wallet['wallet_amount'];;
                $wallet_operation['operation_date'] = date("Y-m-d H:i:s");
                $wallet_operation['description'] = 'Add money to wallet';;
                $wallet_operation['transation_details'] = json_encode($json_val);
                // echo "<pre>"; print_r($add); die;
                $wallet_insert= WalletOperation::create($wallet_operation);
			}
		}

      //  echo "<pre>"; print_r($charge_result);

        $return_data['status']=(Boolean)true;
        $return_data['message']="Payment process completed successfully";
        $return_data['data']=new \stdClass();
        return $return_data;
    }

	
    public function deleteSkillsForJob($job_id)
    {
        ObjSkillsRef::where('obj_id', $job_id)
            ->where('obj_table_ref', 'jobs')
            ->delete();
    }

    public function getSkillsForJob($job_id){
        return ObjSkillsRef::select('skills.id','skills.title')->where('obj_skills_ref.obj_id', $job_id)
            ->join('skills', 'skills.id', '=', 'obj_skills_ref.skill_id')
            ->where('obj_table_ref', 'jobs')->get();
    }

    public function createVacencies($job_id, $vacency_count = 0){
        for($i=1; $i <= $vacency_count; $i ++){
            JobVacency::create([
                'job_id' => $job_id,
                'status' => 'pending',
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
    }

    public function deleteVacencies($job_id){
        JobVacency::where('job_id', $job_id)
            ->delete();
    }

    public function getVacencies($job_id)
    {
        return JobVacency::where(['job_id' => $job_id])->get();
    }
}
