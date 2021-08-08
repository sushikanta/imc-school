<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobTitles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Models\JobApplication;
use App\Models\Addresses;
use App\Models\StaffJob;
use App\User;
use App\Models\StaffJobSkill;
use App\Models\JobVacency;
use App\Models\ObjSkillsRef;

class JobController extends Controller
{
    //
    public function __invoke()
    {
    }

    public function index()
    {
        return Job::all();
    }

    public function show($id)
    {
        return Job::find($id);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $validator = $this->validator($data);

        if ($validator->fails()) {
            $data = ['errors' => $validator->errors()];
            return response($data)->setStatusCode(422);

        }

        return Job::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $obj = Job::findOrFail($id);
        $data = $request->all();
        $validator = $this->validator($data);

        if ($validator->fails()) {
            $data = ['errors' => $validator->errors()];
            return response($data)->setStatusCode(422);
        }
        $obj->update($request->all());
        return $obj;
    }

    public function delete(Request $request, $id)
    {
        $obj = Job::findOrFail($id);
        $obj->delete();

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


    public function createjob(Request $request)
    {
        $search = @$request->get('search');
        $user_id = @$request->get('user_id');
        $status = @$request->get('status');
        $start_date = @$request->get('start_date');
        $end_date = @$request->get('end_date');
        $salary_from = @(Integer)$request->get('salary_from');
        $salary_to = @(Integer)$request->get('salary_to');
        $payment_status = @$request->get('payment_status');

        $field = $request->get('field') != '' ? $request->get('field') : 'jobs.id';
        $sort = $request->get('sort') != '' ? $request->get('sort') : 'desc';
        $jobs = Job::leftJoin('job_titles','job_titles.id', '=', 'jobs.job_title_id');
		$jobs = $jobs->leftJoin('job_applications','job_applications.job_id', '=', 'jobs.id');
        $jobs=  $jobs->select('jobs.*','job_titles.title',DB::raw('count(job_applications.job_id) as total_applicant' ));
		//$jobs=  $jobs->select( DB::raw('count(jobs.id)' ) );
		if(trim($search)!='')
		{
			$jobs->where('job_titles.title', 'like', '%' . $search . '%');
		}

        if($user_id!='')
        {
            $jobs->where('jobs.business_user_id', '=', $user_id);
        }

        if($status!='')
        {
            $jobs->where('jobs.status', '=', $status);
        }

        if($payment_status!='')
        {
            $jobs->where('jobs.payment_status', '=', $payment_status);
        }

        if($salary_from!='')
        {
            $jobs->where('jobs.salary', '>=', $salary_from);
        }

        if($salary_to!='')
        {
            $jobs->where('jobs.salary', '<=', $salary_to);
        }


        if($start_date!='')
        {
            $jobs->where(DB::raw('date(jobs.ending_at)'), '>=', $start_date);
        }

        if($end_date!='')
        {
            $jobs->where(DB::raw('date(jobs.ending_at)'), '<=', $end_date);
        }

		
		$jobs = $jobs->groupBy('jobs.id', 'job_titles.title');
        $jobs = $jobs->orderBy($field, $sort);
        $jobs=  $jobs->paginate(20);
        $jobs=  $jobs->withPath('?search=' . $search . '&field=' . $field . '&sort=' . $sort);
		
		$client_list= User::getActiveclientList();
		//dd($client_list);
        return view('job.index', compact('jobs','client_list'));
    }


	public function getjobdetails(Request $request)
    {
		$job=array();
		
		$req = $request->all();
		$job_id= $req['id'];
		
		$jobs = Job::leftJoin('job_titles','job_titles.id', '=', 'jobs.job_title_id');
		$jobs = $jobs->leftJoin('countries','countries.id', '=', 'jobs.country_id');
		$jobs = $jobs->leftJoin('users','users.id', '=', 'jobs.business_user_id');
		$jobs = $jobs->leftJoin('timezones','timezones.id', '=', 'jobs.timezone_id');
	    $jobs= $jobs->select('jobs.*', 'job_titles.title as job_title','countries.title as country_name', 'users.email', 'users.firstname' , 'users.lastname'  , 'timezones.zone'  );
		$jobs= $jobs->where('jobs.id', $job_id)->first();
		
		if($jobs)
		{
			$jobs = $jobs->toArray();
		}
		else
		{
			$jobs =array();
		}
		
		//echo "<pre>"; print_r($jobs); echo "</pre>";
		
       return view('job.details', compact('jobs'));
    }
	
	/*
	  @Descriptuon: get Applicant details from admin panel view
	  @Status: Working
	  @return @html
      @Created By Manjeet Kumar
	  @Created Date: 26-2-2019
	  @Modified Date: 26-2-2019
	*/
	public function jobapplicant(Request $request)
    {
		$job=array();
		
		$req = $request->all();
		$job_id= $req['id'];

		$jobs = JobApplication::join('users','users.id', '=', 'job_applications.user_id');
		$jobs= $jobs->select('users.id', 'users.firstname','users.lastname','job_applications.status as applicant_status','job_applications.created_at as applied_date','users.photo_src');
	
	
		$jobs = $jobs->where('job_applications.job_id',$job_id);
		
		$jobs->groupBy('users.id','job_applications.status','job_applications.created_at');
		
		$jobs=  $jobs->get();
		$applicant=array();
		if($jobs)
		{
			$applicant= $jobs->toArray();
			
			foreach($applicant as $key=>$value)
			{
					$applicant[$key]['photo_src_decode'] = json_decode($value['photo_src'], true);
				
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
				
				$applicant[$key]['address'] = $address;
				$applicant[$key]['job_title'] = $job_title_data;
				
			}
			
		}
		
		
		//$picture = json_decode($applicant[0]['photo_src'], true);
		
		//echo "<pre>"; print_r($applicant) ; echo "</pre>";
		
       return view('job.applicant', compact('applicant'));
    }
	
	public function deletejob(Request $request, $id)
    {
        try 
		{ 
           /*
            $job = Job::findOrFail($id);
			$data['is_deleted']=true;
			$data['status']='deleted';
			$data['updated_at']=date("Y-m-d H:i:s");
			$job->update($data);
            */

            JobVacency::where('job_id',$id)->delete();
            JobApplication::where('job_id',$id)->delete();
            ObjSkillsRef::where('obj_id',$id)->where('obj_table_ref','jobs')->delete();
            Job::where('id',$id)->delete();

            return redirect('admin/job/createjob')->with('success_message', 'Job has been deleted successfully');

        } 
		catch (Exception $exception) 
		{

            return back()->withInput()->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    public function editjob(Request $request, $id)
    {
        $jobs = Job::where('jobs.id', $id)->first();

       // echo "<pre>";print_r( $jobs->toArray()) ;

        $status= array('draft','published','cancelled');
        $payment_status= array('pending','confirmed','cancelled');

        return view('job.edit', compact('jobs','status', 'payment_status' ));
    }


    public function updatejob(Request $request, $id)
    {

        $rules = [
            'event_name' => 'string|min:1|max:255',
            'description' => 'string',
            'status' => 'string',
        ];

        $request->validate($rules);

        $data['event_name'] =$request['event_name'];
        $data['description'] =$request['description'];
        $data['status'] =$request['status'];
        $data['salary'] =(Integer)$request['salary'];
        $data['min_experience'] =(Integer)$request['min_experience'];
        $data['payment_status'] =$request['payment_status'];
        $data['address1'] =$request['address1'];
        $data['address2'] =$request['address2'];
        $data['city'] =$request['city'];
        $data['state'] =$request['state'];
        $data['zipcode'] =(Integer)$request['zipcode'];
        $data['contact1'] =$request['contact1'];

        $update_data = Job::where('id', $id)->update($data);
        return redirect('admin/job/createjob')->with('success_message', 'Job details has been updated successfully');
    }

}
