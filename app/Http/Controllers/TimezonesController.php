<?php

namespace App\Http\Controllers;

use App\Models\Timezone;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class TimezonesController extends Controller
{

    /**
     * Display a listing of the timezones.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $timezones = Timezone::where('is_deleted',false)->get();

        return view('timezones.index', compact('timezones'));
    }

    /**
     * Show the form for creating a new timezone.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        
        
        return view('timezones.create');
    }

    /**
     * Store a new timezone in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            Timezone::create($data);

            return redirect()->route('timezones.timezone.index')
                             ->with('success_message', 'Timezone was successfully added!');

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
     * Display the specified timezone.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $timezone = Timezone::findOrFail($id);

        return view('timezones.show', compact('timezone'));
    }

    /**
     * Show the form for editing the specified timezone.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $timezone = Timezone::findOrFail($id);
        

        return view('timezones.edit', compact('timezone'));
    }

    /**
     * Update the specified timezone in the storage.
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
            
            $timezone = Timezone::findOrFail($id);
            $timezone->update($data);

            return redirect()->route('timezones.timezone.index')
                             ->with('success_message', 'Timezone was successfully updated!');

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
     * Remove the specified timezone from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $timezone = Timezone::findOrFail($id);
			$data['is_deleted']=true;
			///$data['updated_at']=date("Y-m-d H:i:s");
			$timezone->update($data);
			
			
           // $timezone->delete();

            return redirect()->route('timezones.timezone.index')
                             ->with('success_message', 'Timezone was successfully deleted!');

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
            'zone' => 'string|min:1|nullable',
            'gmt' => 'string|min:1|nullable',
            'country_code' => 'required|string|min:1',
            'published' => 'string|min:1|nullable|boolean',
            'sort' => 'numeric|nullable',
     
        ];

        
        $data = $request->validate($rules);




        return $data;
    }

}
