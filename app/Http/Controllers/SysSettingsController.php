<?php

namespace App\Http\Controllers;

use App\Models\SysSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class SysSettingsController extends Controller
{


    /**
     * Display a listing of the sys settings.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $sysSettings = SysSetting::get();

        return view('sys_settings.index', compact('sysSettings'));
    }

    /**
     * Show the form for creating a new sys setting.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        
        
        return view('sys_settings.create');
    }

    /**
     * Store a new sys setting in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            SysSetting::create($data);

            return redirect()->route('sys_settings.sys_setting.index')
                             ->with('success_message', 'Sys Setting was successfully added!');

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
     * Display the specified sys setting.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $sysSetting = SysSetting::findOrFail($id);

        return view('sys_settings.show', compact('sysSetting'));
    }

    /**
     * Show the form for editing the specified sys setting.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $sysSetting = SysSetting::findOrFail($id);
        

        return view('sys_settings.edit', compact('sysSetting'));
    }

    /**
     * Update the specified sys setting in the storage.
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
            
            $sysSetting = SysSetting::findOrFail($id);
            $sysSetting->update($data);

            return redirect()->route('sys_settings.sys_setting.index')
                             ->with('success_message', 'Sys Setting was successfully updated!');

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
     * Remove the specified sys setting from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $sysSetting = SysSetting::findOrFail($id);
            $sysSetting->delete();

            return redirect()->route('sys_settings.sys_setting.index')
                             ->with('success_message', 'Sys Setting was successfully deleted!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }


    public function showClientTerms()
    {
        $policy_type = SysSetting::POLICY_TERMS_CLIENT;
        $sysSetting = SysSetting::where('type', SysSetting::TYPE_POLICY)->where('key', $policy_type)->first();
        return view('sys_settings.edit_policy', compact('sysSetting', 'policy_type'));
    }

    public function showStaffTerms()
    {
        $policy_type = SysSetting::POLICY_TERMS_STAFF;
        $sysSetting = SysSetting::where('type', SysSetting::TYPE_POLICY)->where('key', $policy_type)->first();
        return view('sys_settings.edit_policy', compact('sysSetting', 'policy_type'));
    }

    public function showPrivacy()
    {
        $policy_type = SysSetting::POLICY_PRIVACY;
        $sysSetting = SysSetting::where('type', SysSetting::TYPE_POLICY)->where('key', $policy_type)->first();
        return view('sys_settings.edit_policy', compact('sysSetting', 'policy_type'));
    }

    public function updatePolicy(Request $request)
    {
        try {

            $data = $this->getData($request);

            if($request->id){
                $sysSetting = SysSetting::findOrFail($request->id);
                $sysSetting->update($data);
            }else{
                $data['type'] = SysSetting::TYPE_POLICY;
                $data['key'] = $request->policy_type;
                SysSetting::create($data);
            }

            if($request->policy_type == SysSetting::POLICY_TERMS_CLIENT){
                $route_alias = 'sys_settings.terms.client';
            }else if($request->policy_type == SysSetting::POLICY_TERMS_STAFF){
                $route_alias = 'sys_settings.terms.staff';
            }else {
                $route_alias = 'sys_settings.privacy';
            }
            return redirect()->route($route_alias)
                ->with('success_message', 'Details updated successfully!');

        } catch (Exception $exception) {
            $error_messages = ['unexpected_error' => 'Unexpected error occurred while trying to process your request!'];
            if($exception->validator){
                $error_messages = $exception->validator;
            }
            return back()->withInput()
                ->withErrors($error_messages);
        }
    }

    public function getPolicy(Request $request)
    {
        if($request->type == SysSetting::POLICY_PRIVACY){
            $sysSetting = SysSetting::where('type', SysSetting::TYPE_POLICY)->where('key', $request->type)->first();
            return $sysSetting;
        }else if($request->type == 'terms'){
            $sysSetting = SysSetting::where('type', SysSetting::TYPE_POLICY)->whereIn('key', [SysSetting::POLICY_TERMS_STAFF, SysSetting::POLICY_TERMS_CLIENT])->get()->keyBy('key');
            return $sysSetting;
        }
        return null;
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
            'type' => 'string|min:1|nullable',
            'key' => 'string|min:1|nullable',
            'value' => 'string|min:1|nullable',
            'description' => 'string|min:1|max:1000|nullable',
            'published' => 'boolean|nullable',
     
        ];
        
        $data = $request->validate($rules);


        return $data;
    }

}
