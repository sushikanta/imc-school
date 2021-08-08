<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class CategoriesController extends Controller
{

    /**
     * Display a listing of the categories.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $categories = Category::get();

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        
        
        return view('categories.create');
    }

    /**
     * Store a new category in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            Category::create($data);

            return redirect()->route('categories.category.index')
                             ->with('success_message', 'Category was successfully added!');

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
     * Display the specified category.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);

        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        

        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified category in the storage.
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
            
            $category = Category::findOrFail($id);
            $category->update($data);

            return redirect()->route('categories.category.index')
                             ->with('success_message', 'Category was successfully updated!');

        } catch (Exception $exception) {
            $error_messages = ['unexpected_error' => 'Unexpected error occurred while trying to process your request!'];
             if($exception->validator){
                    $error_messages = $exception->validator;
              }
            return back()->withInput()
                         ->withErrors($error_messages);
        }        
    }

    /**
     * Remove the specified category from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();

            return redirect()->route('categories.category.index')
                             ->with('success_message', 'Category was successfully deleted!');

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
        $id = $request->id;
        $rules = [
            'title' => 'string|min:1|max:255|nullable',
            'published' => 'nullable',
            'slug' => 'string|min:1|max:255|unique:posts,slug,'.$id,
            'meta_description' => 'string|min:5|max:160|nullable',
            'meta_keywords' => 'string|min:5|nullable',
        ];
        $messages = [
            'slug.unique' => 'The slug has already been taken for another post. Please use another slug/keyword'
        ];
        $data = $request->validate($rules);


        return $data;
    }

}
