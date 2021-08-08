<?php

namespace App\Http\Controllers;

use App\Models\SysSetting;
use Doctrine\Common\Inflector\Inflector;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class SettingsController extends Controller
{


    /**
     * Display a listing of the sys settings.
     *
     * @return Illuminate\View\View
     */
    public function show($type, Request $request)
    {
        $type_title = Inflector::singularize(ucfirst(strtolower($type)));
        $data = SysSetting::getSettingsByKey($type);
        if ($request->wantsJson())
		{
			
			 $arr['status'] = (Boolean)true;
             $arr['message'] ="";
             $arr['data'] =$data;
			 return $arr;
              //  return ['status' => (Boolean)true, 'data' => $data];
        }
        return view('settings.show', compact('type', 'type_title', 'data'));
    }


    public function create($type)
    {
        $type_title = Inflector::singularize(ucfirst(strtolower($type)));
        return view('settings.create', compact('type', 'type_title'));
    }

    public function edit($type, Request $req)
    {
        $inner_key = $req->input('inner_key');
        $type_title = Inflector::singularize(ucfirst(strtolower($type)));
        $data = SysSetting::getSettingsByKey($type, $inner_key);
        return view('settings.create', compact('type', 'type_title', 'data'));
    }

    /**
     * Show the form for creating a new sys setting.
     *
     * @return Illuminate\View\View
     */


    /**
     * Store a new sys setting in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request, $main_key)
    {
        try {
            
            $data = $this->getData($request);
            if($request->input('edit_key')){
                $data['edit_key'] = $request->input('edit_key');
            }
            SysSetting::storeSettingByKey($main_key, $data['key'], $data);

            return redirect()->route('settings.object.index', $main_key)
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


    public function destroy(Request $request, $main_key)
    {
        try {
            SysSetting::deleteSettingByKey($main_key, $request->input('inner_key'));

            return redirect()->route('settings.object.index')
                ->with('success_message', 'Setting was successfully deleted!');

        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }




    public function update($id, Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            $sysSetting = SysSetting::findOrFail($id);
            $sysSetting->update($data);

            return redirect()->route('settings.configurations.index')
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


    public function showClientTerms()
    {
        $policy_type = SysSetting::POLICY_TERMS_CLIENT;
        $sysSetting = SysSetting::where('type', SysSetting::TYPE_POLICY)->where('key', $policy_type)->first();
        return view('settings.edit_policy', compact('sysSetting', 'policy_type'));
    }

    public function showStaffTerms()
    {
        $policy_type = SysSetting::POLICY_TERMS_STAFF;
        $sysSetting = SysSetting::where('type', SysSetting::TYPE_POLICY)->where('key', $policy_type)->first();
        return view('settings.edit_policy', compact('sysSetting', 'policy_type'));
    }

    public function showPrivacy()
    {
        $policy_type = SysSetting::POLICY_PRIVACY;
        $sysSetting = SysSetting::where('type', SysSetting::TYPE_POLICY)->where('key', $policy_type)->first();
        return view('settings.edit_policy', compact('sysSetting', 'policy_type'));
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
                $route_alias = 'settings.terms.client';
            }else if($request->policy_type == SysSetting::POLICY_TERMS_STAFF){
                $route_alias = 'settings.terms.staff';
            }else {
                $route_alias = 'settings.privacy';
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
            'key' => 'string|min:1|nullable',
            'value' => 'string|min:1|nullable',
            'description' => 'string|min:1|max:1000|nullable',
            'ctrl_type' => 'string|min:1|max:1000|nullable',
        ];
        
        $data = $request->validate($rules);


        return $data;
    }

}
