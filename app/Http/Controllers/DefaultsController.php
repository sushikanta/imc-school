<?php

namespace App\Http\Controllers;

use App\Models\AddonCard;
use App\Models\Business;
use App\Models\BusinessCategory;
use App\Models\Country;
use App\Models\JobTitles;
use App\Models\Timezone;
use App\Todo;
use App\User;
use Illuminate\Http\Request;
use Validator;
class DefaultsController extends Controller
{

    public function index(Request $request)
    {
        $timezone = Timezone::where('published', true)->orderBy('sort')->get();
        $timezone->transform(function($item) {
            // {{item.zone}} - GMT ({{item.gmt}}
            $item['title'] = $item->zone .' - GMT('.$item->gmt.')';
            return $item;
        });

        $country= Country::where('published', true)->orderBy('sort')->orderBy('title')->get();
        $business_categories= BusinessCategory::where('published', true)->orderBy('sort')->orderBy('title')->get();

        $input = $request->all();


        if(isset($input['types']) &&  is_array($input['types']) )
        {
            foreach ($input['types'] as $value)
            {
                if($value=="countries")
                {
                    $data['countries']=$country;
                }

                if($value=="timezones")
                {
                    $data['timezone']=$timezone;
                }

                if($value=="business_categories")
                {
                    $data['business_categories']=$business_categories;
                }

                if($value=="job_title")
                {
                    $data['job_title']=JobTitles::orderBy('title')->get();
                }
            }
        }
        else
        {
            $data['countries']=$country;
            $data['timezone']=$timezone;
            $data['business_categories']=$business_categories;
        }

        $return_data['status']=(Boolean)true;
        $return_data['message']='';
        $return_data['data']=$data;
        return $return_data;
    }

    public function show($id)
    {
        $data = User::getBusinessDetails($id);
        return $data;
    }

    public function update(Request $request, $id)
    {
        $request->merge(['id' => $id]);
        $validation = User::validateBusinessUpdates($request);
        return $request;
    }

    public function delete(Request $request, $id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();

        return ['success'=> true];
    }

    private function validator($data)
    {
        return Validator::make((array)$data, [
            'task' => 'required|min:10',
            'user_id' => 'required|integer',
            'done' => 'required|boolean',
        ]);
    }


}
