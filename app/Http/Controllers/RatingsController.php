<?php

namespace App\Http\Controllers;

use App\MailToken;
use App\Models\AddonCard;
use App\Models\Business;
use App\Models\StaffJob;
use App\Models\Rating;
use App\Models\Job;
use App\Models\Staff;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Integer;
use Validator;
use Illuminate\Support\Facades\Crypt;
use Route;
use Illuminate\Support\Facades\DB;

class RatingsController extends Controller
{
    public function ratingToStaff(Request $request, $job_id, $user_id )
    {
		$business_user_id  = \Auth::id();

        $v = Validator::make($request->all(), [
            'rating' => 'required|integer|min:0|max:5',
            'review' => 'required'
        ]);

        if ($v->fails())
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']="Field validation error";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=$v->errors();
            return $return_data;
        }

        $job =  Job::where('id', $job_id)->first();
        if(! $job )
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']="Invalid job id.";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=$v->errors();
            return $return_data;
        }


        $already_rated =  Rating::where('job_id', $job_id)->where('rated_by', $business_user_id)->where('user_id', $user_id)->first();
        if($already_rated)
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']="You have already rated to this staff.";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=array();
            return $return_data;
        }
		$data=array();
		$data['job_id'] = $job_id;
        $data['user_id'] = $user_id;
        $data['rating'] = @$request['rating'];
        $data['rated_by'] = $business_user_id;
        $data['review'] = @$request['review'];
        $data['ip'] = $_SERVER['REMOTE_ADDR'];
        $data['created_at']=date("Y-m-d H:i:s");
        //print_r($data); die;

        $rating = Rating::create($data);
        $rating_id = $rating->id;

        $return_data['status']=(Boolean)true;
        $return_data['message']="You have successfully rated to staff.";
        $return_data['data']=array('rating_id'=>$rating_id);
        return $return_data;
    }

    /*
	  @Descriptuon: staff rate to client for particular job
	  @Status: done
	  @return  json
      @Created By Manjeet Kumar
	  @Created Date: 2-4-2019
	  @Modified Date: 2-4-2019
	*/

    public function ratingToClient(Request $request, $job_id)
    {
        $user_id  = \Auth::id();

        $v = Validator::make($request->all(), [
            'rating' => 'required|integer|min:0|max:5',
            'review' => 'required'
        ]);

        if ($v->fails())
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']="Field validation error";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=$v->errors();
            return $return_data;
        }

        $job =  Job::where('id', $job_id)->first();
        if(! $job )
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']="Invalid job id.";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=$v->errors();
            return $return_data;
        }

        $already_rated =  Rating::where('job_id', $job_id)->where('rated_by', $user_id)->first();
        if($already_rated)
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']="You have already rated to this client for this job.";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=array();
            return $return_data;
        }

        $data=array();
        $data['job_id'] = $job_id;
        $data['user_id'] = $job->business_user_id;
        $data['rating'] = @$request['rating'];
        $data['rated_by'] = $user_id;
        $data['review'] = @$request['review'];
        $data['ip'] = $_SERVER['REMOTE_ADDR'];
        $data['created_at']=date("Y-m-d H:i:s");
        //print_r($data); die;
        $rating = Rating::create($data);
        $rating_id = $rating->id;

        $return_data['status']=(Boolean)true;
        $return_data['message']="You have successfully rated to client for this job.";
        $return_data['data']=array('rating_id'=>$rating_id);
        return $return_data;
    }

    /*
     @Descriptuon: staff section list of all rating given by client
     @Status: done
     @return  json
     @Created By Manjeet Kumar
     @Created Date: 2-4-2019
     @Modified Date: 2-4-2019
   */

    public function clientRating(Request $request)
    {

        $user_id  = \Auth::id();

        $job_id= @(Integer)$request['job_id'];

        $rating = Rating::join('jobs','jobs.id', '=', 'ratings.job_id');
        $rating->leftJoin('users','users.id', '=', 'ratings.rated_by');

        $rating->select('ratings.*', 'jobs.event_name' ,'users.firstname','users.lastname','users.email'    );
        $rating->where('ratings.user_id',$user_id);

        if($job_id)
        {
            $rating->where('ratings.job_id',$job_id);
        }

        $rating->orderBy('ratings.created_at','DESC');
        $rating=  $rating->paginate(20);
        $return_data['status']=(Boolean)true;
        $return_data['message']="";
        $return_data['data']= $rating;
        return $return_data;

    }

    /*
   @Descriptuon: client section list of all rating given by staff
   @Status: done
   @return  json
   @Created By Manjeet Kumar
   @Created Date: 2-4-2019
   @Modified Date: 2-4-2019
 */

    public function staffRating(Request $request)
    {
        $user_id  = \Auth::id();

        $job_id= @(Integer)$request['job_id'];

        $rating = Rating::join('jobs','jobs.id', '=', 'ratings.job_id');
        $rating->leftJoin('users','users.id', '=', 'ratings.rated_by');

        $rating->select('ratings.*', 'jobs.event_name' ,'users.firstname','users.lastname','users.email'    );
        $rating->where('ratings.user_id',$user_id);

        if($job_id)
        {
            $rating->where('ratings.job_id',$job_id);
        }

        $rating->orderBy('ratings.created_at','DESC');
        $rating=  $rating->paginate(20);
        $return_data['status']=(Boolean)true;
        $return_data['message']="";
        $return_data['data']= $rating;
        return $return_data;
    }

}