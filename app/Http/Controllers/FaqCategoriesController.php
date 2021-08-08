<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class FaqCategoriesController extends Controller
{

    /**
     * Display a listing of the faq categories.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $faqCategories = FaqCategory::get();
        $data = Faq::select('faq_category_id',  \DB::raw('count(*) as total'))->groupBy('faq_category_id')->get()->keyBy('faq_category_id');
        $faqCategories->transform(function($item) use($data){
            $item->counts = @$data[$item->id]?@$data[$item->id]->total: 0;
            return $item;
        });
        return view('faq_categories.index', compact('faqCategories'));
    }

    /**
     * Show the form for creating a new faq category.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        
        
        return view('faq_categories.create');
    }

    /**
     * Store a new faq category in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            FaqCategory::create($data);

            return redirect()->route('faq_categories.faq_category.index')
                             ->with('success_message', 'Faq Category was successfully added!');

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
     * Display the specified faq category.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $faqCategory = FaqCategory::findOrFail($id);

        return view('faq_categories.show', compact('faqCategory'));
    }

    /**
     * Show the form for editing the specified faq category.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $faqCategory = FaqCategory::findOrFail($id);
        

        return view('faq_categories.edit', compact('faqCategory'));
    }

    /**
     * Update the specified faq category in the storage.
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
            
            $faqCategory = FaqCategory::findOrFail($id);
            $faqCategory->update($data);

            return redirect()->route('faq_categories.faq_category.index')
                             ->with('success_message', 'Faq Category was successfully updated!');

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
     * Remove the specified faq category from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $faqCategory = FaqCategory::findOrFail($id);
            $faqCategory->delete();

            return redirect()->route('faq_categories.faq_category.index')
                             ->with('success_message', 'Faq Category was successfully deleted!');

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
            'title' => 'required|string|min:1|max:255|nullable',
            'sort' => 'numeric|min:1|nullable',
     
        ];

        
        $data = $request->validate($rules);




        return $data;
    }

}
