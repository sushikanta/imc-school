<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Videos extends Model
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
    protected $table = 'videos';

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
                  'youtube_url',
                  'img_src',
                  'description',
                  'display_type'
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
     * Get created_at in array format
     *
     * @param  string  $value
     * @return array
     */
//    public function getCreatedAtAttribute($value)
//    {
//       // return \DateTime::createFromFormat('j/n/Y g:i A', $value);
//
//    }

    /**
     * Get updated_at in array format
     *
     * @param  string  $value
     * @return array
     */
//    public function getUpdatedAtAttribute($value)
//    {
//        //return \DateTime::createFromFormat('j/n/Y g:i A', $value);
//
//    }

}
