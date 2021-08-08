<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffJob extends Model
{
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'staff_jobs';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'staff_user_id',
                  'job_title_id',
                  'exp_months_count',
                  'created',
                  'updated'
              ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];
    
    /**
     * Get the jobCategory for this model.
     */


    public static function storeStaffJob($options = [])
    {
      /*  $old_data = StaffJob::where('job_title_id', $options['job_title_id'])->first();
        $obj = new StaffJob();
        $obj->staff_user_id = */
    }

	// need to test wthis functio 
	public static function getStaffJob($user_id, $type='all')
    {
		 $staff_job = StaffJob::join('job_titles','staff_jobs.job_title_id', '=', 'job_titles.id'); 
		 $staff_job= $staff_job->select('job_titles.*' , 'staff_jobs.exp_months_count','staff_jobs.id as job_id' );
		 $staff_job= $staff_job->where('staff_jobs.staff_user_id', $user_id);
		 
		 if($type=='all')
		 {
			 $staff_job= $staff_job->get();
		 }
		 else
		 {
			 $staff_job= $staff_job->first();
		 }
		 
		 
		 if($staff_job)
		 {
			$staff_job =  $staff_job->toArray();
		 }
		 else
         {
             $staff_job = array();
         }
		 return $staff_job;
    }
	
	public static function getStaffJobWithJobTitle($user_id, $job_title_id)
    {
		 $staff_job = StaffJob::join('job_titles','staff_jobs.job_title_id', '=', 'job_titles.id'); 
		 $staff_job= $staff_job->select('job_titles.*' , 'staff_jobs.exp_months_count','staff_jobs.id as job_id' );
		 $staff_job= $staff_job->where('staff_jobs.staff_user_id', $user_id);
		 $staff_job= $staff_job->where('job_titles.id', $job_title_id);
		 
		 $staff_job= $staff_job->first();
		 
		 if($staff_job)
		 {
			$staff_job =  $staff_job->toArray();
		 }
		 else
		 {
			 $staff_job  =array();
		 }
		 return $staff_job;
    }
	

}
