<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{

    // -- 15 unique color codes
    const COLOR_CODES = [
        '#800080', // purple
        '#000080', // navy
        '#008080', // teal
        '#0000FF', // blue
        '#008000', // green
        '#FF0000', // red
        '#808000', // olive
        '#FF00FF', // fuchsia
        '#00FF00', // lime
        '#0000FF', // blue
        '#FA8072', // salmon
        '#FFC300', // yellow
        '#FF5733', // orange
        '#581845', // brown
        '#DAF7A6', // light green
        ];

    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISHED = 'published';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_SUSPENDED = 'suspended';
    const PAYMENT_PENDING = 'pending';
    const PAYMENT_CONFIRMED = 'confirmed';

    public static $status_client = array(
        Job::STATUS_DRAFT => "Draft",
        Job::STATUS_PUBLISHED => "Published",
        Job::STATUS_CANCELLED => "Cancelled",
    );

    public static $payment_status = array(
        Job::PAYMENT_PENDING => "Pending",
        Job::PAYMENT_CONFIRMED => "Confirmed",
    );


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
    protected $table = 'jobs';

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
                  'event_name',
                  'job_title_id',
                  'business_user_id',
                  'description',
                  'ending_at',
                  'created_at',
                  'updated_at',
                  'created_by',
                  'status',
                  'salary',
                  'min_experience',
                  'max_experience',
                  'starting_from',
                   'payment_status',
                   'lat',
                   'lng',
                   'address1',
                   'address2',
                   'city',
                   'state',
                   'country_id',
                   'timezone_id',
                   'zipcode',
                    'same_as_business_address',
                    'contact1',
                    'vacencies',
                    'geometry_location'
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


    public function business()
    {
        return $this->belongsTo('App\User','business_user_id');
    }

    public function jobTitle()
    {
        return $this->belongsTo('App\Models\JobTitles','job_title_id');
    }

    public function country()
    {
        return $this->belongsTo('App\Models\Country','country_id');
    }
}
