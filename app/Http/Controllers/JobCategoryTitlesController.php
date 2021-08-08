<?php

namespace App\Http\Controllers;

use App\Models\JobTitles;
use Illuminate\Http\Request;
use App\Models\JobCategories;
use App\Models\JobCategoryTitle;
use App\Http\Controllers\Controller;
use Exception;

class JobCategoryTitlesController extends Controller
{

    /**
     * Display a listing of the job category titles.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $jobCategoryTitles = JobCategoryTitle::with('jobcategory','jobtitle')->get();

        return view('job_category_titles.index', compact('jobCategoryTitles'));
    }

    /**
     * Show the form for creating a new job category title.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        $jobCategories = JobCategories::pluck('title','id')->all();
$jobTitles = JobTitles::pluck('title','id')->all();
        
        return view('job_category_titles.create', compact('jobCategories','jobTitles'));
    }

    /**
     * Store a new job category title in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            JobCategoryTitle::create($data);

            return redirect()->route('job_category_titles.job_category_title.index')
                             ->with('success_message', 'Job Category Title was successfully added!');

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
     * Display the specified job category title.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $jobCategoryTitle = JobCategoryTitle::with('jobcategory','jobtitle')->findOrFail($id);

        return view('job_category_titles.show', compact('jobCategoryTitle'));
    }

    /**
     * Show the form for editing the specified job category title.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $jobCategoryTitle = JobCategoryTitle::findOrFail($id);
        $jobCategories = JobCategories::pluck('title','id')->all();
$jobTitles = JobTitles::pluck('title','id')->all();

        return view('job_category_titles.edit', compact('jobCategoryTitle','jobCategories','jobTitles'));
    }

    /**
     * Update the specified job category title in the storage.
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
            
            $jobCategoryTitle = JobCategoryTitle::findOrFail($id);
            $jobCategoryTitle->update($data);

            return redirect()->route('job_category_titles.job_category_title.index')
                             ->with('success_message', 'Job Category Title was successfully updated!');

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
     * Remove the specified job category title from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $jobCategoryTitle = JobCategoryTitle::findOrFail($id);
            $jobCategoryTitle->delete();

            return redirect()->route('job_category_titles.job_category_title.index')
                             ->with('success_message', 'Job Category Title was successfully deleted!');

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
            'job_category_id' => 'nullable',
            'job_title_id' => 'nullable',
     
        ];

        
        $data = $request->validate($rules);




        return $data;
    }

}
