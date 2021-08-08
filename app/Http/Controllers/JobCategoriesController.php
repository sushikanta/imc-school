<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Models\JobCategories;
use App\Http\Controllers\Controller;
use Exception;

class JobCategoriesController extends Controller
{

    /**
     * Display a listing of the job categories.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $jobCategoriesObjects = JobCategories::with('parent','context')->where('is_deleted',false)->get();

        return view('job_categories.index', compact('jobCategoriesObjects'));
    }

    /**
     * Show the form for creating a new job categories.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        $parents = JobCategories::pluck('title','id')->all();
		
		//$contexts = User::pluck('firstname','id')->all();
        
        return view('job_categories.create', compact('parents'));
    }

    /**
     * Store a new job categories in the storage.
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
            
            JobCategories::create($data);

            return redirect()->route('job_categories.job_categories.index')
                             ->with('success_message', 'Job Categories was successfully added!');

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
     * Display the specified job categories.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $jobCategories = JobCategories::with('parent','context')->findOrFail($id);

        return view('job_categories.show', compact('jobCategories'));
    }

    /**
     * Show the form for editing the specified job categories.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $jobCategories = JobCategories::findOrFail($id);
        $parents = JobCategories::pluck('title','id')->all();
$contexts = User::pluck('firstname','id')->all();

        return view('job_categories.edit', compact('jobCategories','parents','contexts'));
    }

    /**
     * Update the specified job categories in the storage.
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
            $jobCategories = JobCategories::findOrFail($id);
            $jobCategories->update($data);

            return redirect()->route('job_categories.job_categories.index')
                             ->with('success_message', 'Job Categories was successfully updated!');

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
     * Remove the specified job categories from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $jobCategories = JobCategories::findOrFail($id);
			
			$data['is_deleted']=true;
			$data['updated_at']=date("Y-m-d H:i:s");
			$jobCategories->update($data);
           // $jobCategories->delete();

            return redirect()->route('job_categories.job_categories.index')
                             ->with('success_message', 'Job Categories has been deleted successfully !');

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
            'title' => 'string|min:1|max:255|nullable',
            'parent_id' => 'nullable',
            'published' => 'boolean|nullable',
            'context_id' => 'nullable',
            'sort' => 'string|min:1|nullable',
     
        ];

        
        $data = $request->validate($rules);


        $data['published'] = $request->has('published');


        return $data;
    }


}
