<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
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
    protected $table = 'checkin_checkout';

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
	 
    const STATUS_REJECTED = 'rejected';
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';

    public static $inout_status = array(
        Checkin::STATUS_REJECTED => "Rejected",
        Checkin::STATUS_PENDING => "Pending",
        Checkin::STATUS_CONFIRMED => "Confirmed",
    );
	 
	 
	 
	 
    protected $fillable = [
					'job_id',
					'user_id',
					'checkin_time',
					'checkin_status',
					'checkout_status',
					'checkout_time',
					'total_work_time',
					'checkin_client_update',
					'checkout_client_update',
                    'checkin_lat',
                    'checkin_lng',
                    'checkout_lat',
                    'checkout_lng',
                    'checkin_client_comments',
                    'checkout_client_comment',
                    'checkin_type',
                    'checkout_type'
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


    public static function getCheckinDetails( $job_id, $user_id    )
    {

        $check_in = Checkin::where('user_id', $user_id)->where('job_id', $job_id)->first();
        if(!$check_in) {
            $check_in =  new \stdClass();
        }
        return $check_in;
    }

}
