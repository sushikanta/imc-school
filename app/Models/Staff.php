<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 14-01-2019
 * Time: 13:00
 */

namespace App\Models;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Models\Addresses;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
protected $table = 'staffs';
public $timestamps = false;
public $fillable =[
'user_id',
    'gender',
    'dob',
    'video_profile_url',
    'is_online',
    'lat',
    'lng',
    'status',
    'avg_rating',
    'worked_hrs',
	'staff_details',
    'timezone_id',
    'preferences',
	'account_holder_name',
	'bank_name',
	'account_number',
	'ifsc_code'
];


    public static function getStaffDetails($id)
    {
        $user = User::where('id', '=', $id)->first();

        if($user)
        {
            $user_details['id'] = $user->id;
            $user_details['email'] =$user->email;
            $user_details['firstname'] = $user->firstname;
            $user_details['lastname'] =$user->lastname;
            $user_details['photo_src'] = $user->photo_src;
            $decoded = new \stdClass();
            if($user->photo_src){
                $decoded  = json_decode($user->photo_src);
            }
            $user_details['photo_src_decoded'] = $decoded;

            $details = Staff::leftJoin('timezones','timezones.id', '=', 'staffs.timezone_id');
            $details->select('staffs.*', 'timezones.zone as timezone_name', 'timezones.gmt as gmt');
            $details = $details->where('staffs.user_id', $id)->first();

            $user_details['details']= new \stdClass();
            if($details)
            {
                $user_details['details'] = $details->toArray();

                $rating_details = Staff::getRating($id);
                $user_details['details']['avg_rating'] = ($rating_details->avg_rating)?$rating_details->avg_rating:0;
                $user_details['details']['total_user_rated'] = $rating_details->total_user_rated;
            }

            $staff_job=  StaffJob::getStaffJob( $id );
            foreach($staff_job as $keyskill=> $st_job)
            {
                $job_skill_data=  StaffJobSkill::staffJobSkillNameArr( $st_job['job_id'] );
                $staff_job[$keyskill]['skills'] = implode(",",$job_skill_data);
            }

            if($staff_job)
            {
                $user_details['job_title'] = $staff_job;
            }
            else
            {
                $user_details['job_title'] = array();
            }

            $param['user_id'] = $id;
            $param['obj_table_ref'] = 'staffs';
            $param['type'] = 'profile';

            $user_details['address']=new \stdClass();
            $address_data=  Addresses::getAddress($param);

            if( $address_data)
            {
                $user_details['address'] = $address_data;
            }
        }
        else
        {
            $user_details = new \stdClass();
        }

        //print_r($user_details) ;die;
        return  $user_details;
    }


    public static function getRating($user_id)
    {
        $rating = DB::table('ratings');
        $rating->select(DB::raw('avg(rating) as avg_rating ') ,  DB::raw('count(user_id) as total_user_rated ') );
        $rating = $rating->where('user_id',$user_id)->first();
        return $rating;
    }
}