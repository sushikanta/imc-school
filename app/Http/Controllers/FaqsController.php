<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class FaqsController extends Controller
{

    /**
     * Display a listing of the faqs.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $qry = Faq::with('faqcategory');
        if($cid = \Request::get('cat_id')){
            $qry->where('faq_category_id', $cid);
        }

        $faqs = $qry->get();
        return view('faqs.index', compact('faqs'));
    }


    /**
     * Show the form for creating a new faq.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        $faqCategories = FaqCategory::pluck('title','id')->all();
        
        return view('faqs.create', compact('faqCategories'));
    }

    /**
     * Store a new faq in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            Faq::create($data);

            return redirect()->route('faqs.faq.index')
                             ->with('success_message', 'Faq was successfully added!');

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
     * Display the specified faq.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $faq = Faq::with('faqcategory')->findOrFail($id);

        return view('faqs.show', compact('faq'));
    }

    /**
     * Show the form for editing the specified faq.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        $faqCategories = FaqCategory::pluck('title','id')->all();

        return view('faqs.edit', compact('faq','faqCategories'));
    }

    /**
     * Update the specified faq in the storage.
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
            
            $faq = Faq::findOrFail($id);
            $faq->update($data);

            return redirect()->route('faqs.faq.index')
                             ->with('success_message', 'Faq was successfully updated!');

        } catch (Exception $exception) {
            $error_messages = ['unexpected_error' => 'Unexpected error occurred while trying to process your request!'];
             if($exception->validator){
                    $error_messages = $exception->validator;
              }
            return back()->withInput()
                         ->withErrors($error_messages);
        }        
    }


    public function updateAjax($id, Request $request)
    {
        if($id){
            $faq = Faq::find($id);
            $type = $request->get('type');
            $value = $request->get('value');
            $message = 'Record updated successfully';
            switch($type) {
                case 'display_client':
                    $value = strtolower($value) == 'true'?true:false;
                    $message = $value? 'The FAQ is now visible to Clients.': 'The FAQ has been removed from Clients.';
                    break;
                case 'display_staff':
                    $value = strtolower($value) == 'true'?true:false;
                    $message = $value? 'The FAQ is now visible to Staffs.': 'The FAQ has been removed from Staffs.';
                    break;
                case 'published':
                    $value = strtolower($value) == 'true'?true:false;
                    $message = $value? 'The FAQ is now published.': 'The FAQ has been unpublished.';
                    break;
                default:
                    echo "This is default.";
            }
            if($faq){
                $faq->update([$type => $value]);
                return ['status'=> 'success', 'message'=> $message];
            }
        }
        return $request->all();
    }

    /**
     * Remove the specified faq from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $faq = Faq::findOrFail($id);
            $faq->delete();

            return redirect()->route('faqs.faq.index')
                             ->with('success_message', 'Faq was successfully deleted!');

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
            'faq_category_id' => 'required|nullable',
            'question' => 'required|string|min:1|nullable',
            'answer' => 'required|string|min:1|nullable',
            'sort' => 'numeric|min:1|nullable|string',
            'display_client' => 'boolean|nullable',
            'display_staff' => 'boolean|nullable',
            'published' => 'boolean|nullable',
     
        ];

        
        $data = $request->validate($rules);




        return $data;
    }


    // -----
    public function getPublishedFaqs()
    {
        $faqs = Faq::getGroupedFaqs();
       // return ['data' => $faqs];

        $return_data['status']=(Boolean)true;
        $return_data['message']='';
        $return_data['data']= $faqs;
        return $return_data;
    }

}
