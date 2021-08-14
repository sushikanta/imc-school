<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registrations;
use App\Http\Controllers\Controller;
use Exception;

class RegistrationsController extends Controller
{

    /**
     * Display a listing of the registrations.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $registrationsObjects = Registrations::get();

        return view('registrations.index', compact('registrationsObjects'));
    }

    /**
     * Show the form for creating a new registrations.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        
        
        return view('registrations.create');
    }

    /**
     * Store a new registrations in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            Registrations::create($data);

            return redirect()->route('registrations.registrations.index')
                             ->with('success_message', 'Registrations was successfully added!');

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
     * Display the specified registrations.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $registrations = Registrations::findOrFail($id);

        return view('registrations.show', compact('registrations'));
    }

    /**
     * Show the form for editing the specified registrations.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $registrations = Registrations::findOrFail($id);
        

        return view('registrations.edit', compact('registrations'));
    }

    /**
     * Update the specified registrations in the storage.
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
            
            $registrations = Registrations::findOrFail($id);
            $registrations->update($data);

            return redirect()->route('registrations.registrations.index')
                             ->with('success_message', 'Registrations was successfully updated!');

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
     * Remove the specified registrations from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $registrations = Registrations::findOrFail($id);
            $registrations->delete();

            return redirect()->route('registrations.registrations.index')
                             ->with('success_message', 'Registrations was successfully deleted!');

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
            'email' => 'nullable',
            'full_name' => 'string|min:1|nullable',
            'dob' => 'string|min:1|nullable',
            'gender' => 'string|min:1|nullable',
            'category' => 'string|min:1|nullable',
            'aadhar' => 'string|min:1|nullable',
            'contact_no' => 'string|min:1|nullable',
            'whatsapp_no' => 'string|min:1|nullable',
            'last_school' => 'string|min:1|nullable',
            'hslc_result' => 'string|min:1|nullable',
            'father_name' => 'string|min:1|nullable',
            'father_occupation' => 'string|min:1|nullable',
            'mother_name' => 'string|min:1|nullable',
            'mother_occupation' => 'string|min:1|nullable',
            'present_address' => 'string|min:1|nullable',
            'permanent_address' => 'string|min:1|nullable',
            'village_town' => 'numeric|nullable',
            'district' => 'string|min:1|nullable',
            'state' => 'string|min:1|nullable',
            'pin' => 'string|min:1|nullable',
            'file_photo_path' => 'string|min:1|nullable',
            'file_hslc_admitcard_path' => 'string|min:1|nullable',
            'file_hslc_marksheet_path' => 'string|min:1|nullable',
            'file_aadhaar_path' => 'string|min:1|nullable',
            'stream' => 'string|min:1|nullable',
            'selected_subject' => 'string|min:1|nullable',
     
        ];
        
        $data = $request->validate($rules);


        return $data;
    }

}
