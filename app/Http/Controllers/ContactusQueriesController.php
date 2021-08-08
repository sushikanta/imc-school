<?php

namespace App\Http\Controllers;

use App\Mail\AdminContactus;
use Illuminate\Http\Request;
use App\Models\ContactusQuery;
use App\Http\Controllers\Controller;
use Exception;
use Mail;


class ContactusQueriesController extends Controller
{

    /**
     * Display a listing of the contactus queries.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $contactusQueries = ContactusQuery::get();

        return view('contactus_queries.index', compact('contactusQueries'));
    }

    /**
     * Show the form for creating a new contactus query.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        
        
        return view('contactus_queries.create');
    }

    /**
     * Store a new contactus query in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            ContactusQuery::create($data);

            return redirect()->route('contactus_queries.contactus_query.index')
                             ->with('success_message', 'Contactus Query was successfully added!');

        } catch (Exception $exception) {
            $error_messages = ['unexpected_error' => 'Unexpected error occurred while trying to process your request!'];
             if(@$exception->validator){
                    $error_messages = $exception->validator;
              }
            return back()->withInput()
                         ->withErrors($error_messages);
        }
    }


    public function submitQuery(Request $request)
    {
        try {

            $data = $this->getData($request);

            /*$obj = ContactusQuery::create($data);

            Mail::to('realtyninfra@gmail.com')
                ->bcc('skanta.it@gmail.com')
                ->send(new AdminContactus($obj));*/

            return redirect()->route('contact')
                ->with('success_message', 'Your Message has been submitted successfully. ');

        } catch (Exception $exception) {
            $error_messages = ['unexpected_error' => $exception->getMessage()];
            if(@$exception->validator){
                $error_messages = $exception->validator;
            }
            return back()->withInput()
                ->withErrors($error_messages);
        }
    }

    /**
     * Display the specified contactus query.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $contactusQuery = ContactusQuery::findOrFail($id);

        return view('contactus_queries.show', compact('contactusQuery'));
    }

    /**
     * Show the form for editing the specified contactus query.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $contactusQuery = ContactusQuery::findOrFail($id);
        

        return view('contactus_queries.edit', compact('contactusQuery'));
    }

    /**
     * Update the specified contactus query in the storage.
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
            
            $contactusQuery = ContactusQuery::findOrFail($id);
            $contactusQuery->update($data);

            return redirect()->route('contactus_queries.contactus_query.index')
                             ->with('success_message', 'Contactus Query was successfully updated!');

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
     * Remove the specified contactus query from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $contactusQuery = ContactusQuery::findOrFail($id);
            $contactusQuery->delete();

            return redirect()->route('contactus_queries.contactus_query.index')
                             ->with('success_message', 'Contactus Query was successfully deleted!');

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
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'subject' => 'required',
            'details' => 'required',
     
        ];
        
        $data = $request->validate($rules);


        return $data;
    }

}
