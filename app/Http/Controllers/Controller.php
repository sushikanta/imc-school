<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\FileUploadTrait;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, FileUploadTrait;

    public function __construct()
    {

        // set timezone based on api user calling
        $user = auth('api')->user();
        if($user){
            if($user->timezone_id) {
                 $timezone = DB::table('timezones')->where('id', $user->timezone_id)->first();
                 //print_r($timezone); die;
                date_default_timezone_set($timezone->zone);
             }
             else
             {
                 date_default_timezone_set('UTC');
             }
        }
    }

}
