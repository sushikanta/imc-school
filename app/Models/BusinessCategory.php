<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessCategory extends Model
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
    protected $table = 'business_categories';

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
                  'parent_id',
                  'published',
                  'context_id',
				  'is_deleted',
				  'created_at',
				  'updated_at',
                  'sort'
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
     * Get the parent for this model.
     */
    public function parent()
    {
        return $this->belongsTo('App\Models\BusinessCategory','parent_id');
    }

    /**
     * Get the context for this model.
     */
    public function context()
    {
        return $this->belongsTo('App\User','context_id');
    }



}
