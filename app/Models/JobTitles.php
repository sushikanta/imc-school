<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobTitles extends Model
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
    protected $table = 'job_titles';

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
                  'title',
				  'is_deleted',
				  'created_at',
				  'updated_at',
                  'context_id',
                  'hourly_rate'
				  
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
     * Get the context for this model.
     */
    public function context()
    {
        return $this->belongsTo('App\User','context_id');
    }



}
