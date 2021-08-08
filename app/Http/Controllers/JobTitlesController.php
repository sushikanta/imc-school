<?php

namespace App\Http\Controllers;

use App\Models\ObjSkillsRef;
use App\Models\Skill;
use App\Models\Skills;
use App\Models\StaffJob;
use App\Models\StaffJobSkill;
use App\Models\SysSetting;
use App\User;
use App\Models\JobTitles;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use phpDocumentor\Reflection\Types\Boolean;

class JobTitlesController extends Controller
{

    /**
     * Display a listing of the job titles.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $jobTitlesObjects = JobTitles::with('context')->where('is_deleted',false)->get();
        $objSkills  = ObjSkillsRef::select('obj_id')->where('obj_table_ref', 'job_titles')->get()->groupBy('obj_id');

        $jobTitlesObjects = $jobTitlesObjects->transform(function($item) use($objSkills){
            $item->skills_count = @$objSkills[$item->id]?count($objSkills[$item->id]):0;
            return $item;
        });


        return view('job_titles.index', compact('jobTitlesObjects'));
    }

    /**
     * Show the form for creating a new job titles.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
       // $contexts = User::pluck('email','id')->all();
        
        return view('job_titles.create' );
    }

    /**
     * Store a new job titles in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            
            $data = $this->getData($request);
			$data['updated_at']=date("Y-m-d H:i:s");
			$data['created_at']=date("Y-m-d H:i:s");



            JobTitles::create($data);

            return redirect()->route('job_titles.job_titles.index')
                             ->with('success_message', 'Job Titles was successfully added!');

        } catch (Exception $exception) {
            $error_messages = ['unexpected_error' => 'Unexpected error occurred while trying to process your request!'];
             if(@$exception->validator){
                    $error_messages = $exception->validator;
              }
            return back()->withInput()
                         ->withErrors($error_messages);
        }
    }

    /**
     * Display the specified job titles.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $jobTitles = JobTitles::with('context')->findOrFail($id);

        return view('job_titles.show', compact('jobTitles'));
    }

    /**
     * Show the form for editing the specified job titles.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $jobTitles = JobTitles::findOrFail($id);
        $contexts = User::pluck('email','id')->all();

        return view('job_titles.edit', compact('jobTitles','contexts'));
    }

    /**
     * Update the specified job titles in the storage.
     *
     * @param  int $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        try {
            
            $data = $this->getData($request);
            $data['updated_at']=date("Y-m-d H:i:s");
            $jobTitles = JobTitles::findOrFail($id);
            $jobTitles->update($data);

            return redirect()->route('job_titles.job_titles.index')
                             ->with('success_message', 'Job Titles was successfully updated!');

        } catch (Exception $exception) {
            $error_messages = ['unexpected_error' => 'Unexpected error occurred while trying to process your request!'];
             if(@$exception->validator){
                    $error_messages = $exception->validator;
              }
            return back()->withInput()
                         ->withErrors($error_messages);
        }        
    }

    /**
     * Remove the specified job titles from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $jobTitles = JobTitles::findOrFail($id);
			$data['is_deleted']=true;
			$data['updated_at']=date("Y-m-d H:i:s");
			$jobTitles->update($data);
           // $jobTitles->delete();

            return redirect()->route('job_titles.job_titles.index')
                             ->with('success_message', 'Job Titles was successfully deleted!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    
    /**
     * Get the request's data from the request.
     *
     * @param Illuminate\Http\Request\Request $request 
     * @return array
     */
    protected function getData(Request $request)
    {
        $rules = [
            'title' => 'string|min:1|max:255',
            'hourly_rate' => 'required|integer',
           // 'context_id' => 'nullable',
     
        ];

        
        $data = $request->validate($rules);




        return $data;
    }


    public function getJobTitles(){
        $auth_id = \Auth::id();
        $hourly_rate = SysSetting::getHourlyJobRate();

        $qry = JobTitles::addSelect('id', 'title','hourly_rate');
       // $qry->addSelect(\DB::raw($hourly_rate .' AS hourly_rate'));
        $qry->where(function($qry) use ($auth_id) {
                //-- condition to get global/self added job titles
                $qry->whereNull('context_id')
                    ->orWhere('context_id', '=', $auth_id);
                return $qry;
            })
            ->where('published', true);
        $data = $qry->orderBy('title')->get();

        $return_data['status']= $data?true:false;
        $return_data['message']="";
        $return_data['data']= $data;
        return $return_data;

    }

    public function getJobTitlesSkillas(Request $req){
        $qry = JobTitles::addSelect('*')->where('published', true);
        $job_titles = $qry->orderBy('title')->get();

        $qry2 = ObjSkillsRef::addSelect('obj_skills_ref.obj_id AS job_title_id', 'obj_skills_ref.skill_id', 'skills.title AS skill')->join('skills', 'skills.id', '=', 'obj_skills_ref.skill_id')
            ->where('obj_skills_ref.obj_table_ref', '=', 'job_titles');
        $skills_by_title_id = $qry2->get()->groupBy('job_title_id');
        $data = [
            'job_titles' => $job_titles,
            'skills_by_title_id' => $skills_by_title_id,
        ];
        if($req->input('staff_job_skill_id')){
            $staff_job = StaffJob::find($req->input('staff_job_skill_id' ));
            $skills = StaffJobSkill::select('skills.title AS skill', 'skills.id AS skill_id')
                ->join('skills', 'skills.id', '=', 'staff_job_skills.skill_id')
                ->where('staff_job_id', $staff_job->id)->get();


            $data['staff_job'] = $staff_job;
            $data['staff_job_skills'] = $skills;
        }

        $return_data['status']= true;
        $return_data['message']="";
        $return_data['data']= $data;
        return $return_data;

       // return ['status' => 'success', 'data' => $data];
    }

    public function deleteStaffJobTitleWithSkills(Request $req) {
        $requests = $req->all();
        if(@$requests['staff_job_id']){
            StaffJob::destroy($requests['staff_job_id']);
            StaffJobSkill::where('staff_job_id', $requests['staff_job_id'])->delete();
        }
        return ['status' => 'success'];
    }

    public function showSkills($job_title_id)
    {

        $job_titles = JobTitles::orderBy('title','asc')->pluck('title', 'id');
        $associated_skills = ObjSkillsRef::where('obj_id', $job_title_id)->where('obj_table_ref', 'job_titles')->pluck('skill_id');
        $skills  = Skill::select('id', 'title')->where('is_deleted',false)->orderBy('title', 'asc')->get();
        $selected_skills = $skills->whereIn('id', $associated_skills->toArray());
        $unselected_skills = $skills->whereNotIn('id', $associated_skills->toArray());

        return view('job_titles.edit_skills', compact('job_title_id', 'job_titles', 'selected_skills', 'unselected_skills'));
    }

    public function storeSkills(Request $request, $job_title_id){
        ObjSkillsRef::where('obj_id', $job_title_id)->where('obj_table_ref', 'job_titles')->delete();
        if(count($request['skill_ids'])){
            foreach ($request['skill_ids'] as $skill_id){
                $obj = new ObjSkillsRef();
                $obj->skill_id = $skill_id;
                $obj->obj_id = $job_title_id;
                $obj->obj_table_ref = 'job_titles';
                $obj->save();
            }
        }

        return ['message' => 'Records updated successfully.'];
    }

}
