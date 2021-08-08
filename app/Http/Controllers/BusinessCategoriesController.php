<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Models\BusinessCategory;
use App\Http\Controllers\Controller;
use Exception;

class BusinessCategoriesController extends Controller
{

    /**
     * Display a listing of the business categories.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
		//echo 4;die;
        $businessCategories = BusinessCategory::with('parent','context')->where('is_deleted',false)->get();

        return view('business_categories.index', compact('businessCategories'));
    }

    /**
     * Show the form for creating a new business category.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        $parents = BusinessCategory::pluck('title','id')->all();
		//$contexts = User::pluck('firstname','id')->all();
        
        return view('business_categories.create', compact('parents'));
    }

    /**
     * Store a new business category in the storage.
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
            BusinessCategory::create($data);

            return redirect()->route('business_categories.business_category.index')
                             ->with('success_message', 'Business Category was successfully added!');

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
     * Display the specified business category.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $businessCategory = BusinessCategory::with('parent','context')->findOrFail($id);

        return view('business_categories.show', compact('businessCategory'));
    }

    /**
     * Show the form for editing the specified business category.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $businessCategory = BusinessCategory::findOrFail($id);
        $parents = BusinessCategory::pluck('title','id')->all();
//$contexts = User::pluck('firstname','id')->all();

        return view('business_categories.edit', compact('businessCategory','parents'));
    }

    /**
     * Update the specified business category in the storage.
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
            $businessCategory = BusinessCategory::findOrFail($id);
            $businessCategory->update($data);

            return redirect()->route('business_categories.business_category.index')
                             ->with('success_message', 'Business Category was successfully updated!');

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
     * Remove the specified business category from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try { 
            $businessCategory = BusinessCategory::findOrFail($id);
			$data['is_deleted']=true;
			$data['updated_at']=date("Y-m-d H:i:s");
			$businessCategory->update($data);
			
		//echo "<pre>";	print_r($businessCategory); die;
			
            //$businessCategory->delete();

            return redirect()->route('business_categories.business_category.index')
                             ->with('success_message', 'Business Category was successfully deleted!');

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
            'published' => 'string|min:1|nullable',
            'context_id' => 'nullable',
            'sort' => 'numeric|nullable',
     
        ];

        
        $data = $request->validate($rules);




        return $data;
    }

}
