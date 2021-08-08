<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    //public $timestamps = false;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'job_applications';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_REJECTED = 'rejected';
    const STATUS_PENDING = 'pending';

    public static $status_applicant = array(
        JobApplication::STATUS_CONFIRMED => "Confirmed",
        JobApplication::STATUS_PENDING => "Pending",
        JobApplication::STATUS_REJECTED => "Rejected",
    );

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'user_id',
				  'job_id',
                  'status',
                  'is_deleted',
				  'status',
                  'updated_by'
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

    public static function totalApplicantByStatus($job_id ,  $status )
    {
        $total_applicant = JobApplication::where('job_id', '=', $job_id)->where('status', '=', $status)->count();
        return $total_applicant;
    }

    public static function totalApplicant($job_id )
    {
        $total_applicant = JobApplication::where('job_id', '=', $job_id)->count();
        return $total_applicant;
    }


}
