<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
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
    protected $table = 'posts';

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
                  'category_id',
                  'title',
                  'description',
                  'img_src',
                  'published',
                  'is_main',
                  'published_at',
                  'created_by'
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
     * Get the category for this model.
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category','category_id');
    }

    /**
     * Get the creator for this model.
     */
    public function creator()
    {
        return $this->belongsTo('App\User','created_by');
    }

    /**
     * Set the published_at.
     *
     * @param  string  $value
     * @return void
     */
    public function setPublishedAtAttribute($value)
    {
        $this->attributes['published_at'] = !empty($value) ? \DateTime::createFromFormat($this->getDateFormat(), $value) : null;
    }

    /**
     * Get published_at in array format
     *
     * @param  string  $value
     * @return array
     */
    public function getPublishedAtAttribute($value)
    {
        return $value;
        return \DateTime::createFromFormat('Y-m-d H:i:s', $value);

    }

    /**
     * Get created_at in array format
     *
     * @param  string  $value
     * @return array
     */
    public function getCreatedAtAttribute($value)
    {
        return \DateTime::createFromFormat('j/n/Y g:i A', $value);

    }

    /**
     * Get updated_at in array format
     *
     * @param  string  $value
     * @return array
     */
    public function getUpdatedAtAttribute($value)
    {
        return \DateTime::createFromFormat('j/n/Y g:i A', $value);

    }

}
