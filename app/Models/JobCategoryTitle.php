<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobCategoryTitle extends Model
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
    protected $table = 'job_category_titles';

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
                  'job_category_id',
                  'job_title_id'
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
    public function jobCategory()
    {
        return $this->belongsTo('App\Models\JobCategories','job_category_id');
    }

    /**
     * Get the jobTitle for this model.
     */
    public function jobTitle()
    {
        return $this->belongsTo('App\Models\JobTitles','job_title_id');
    }



}
