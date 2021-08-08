<?php

namespace App\Models;

use App\Classes\Utility;
use Illuminate\Database\Eloquent\Model;
use DB;
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
                  'display_type',
                  'published_at',
                  'created_by',
                  'slug',
                  'slug_id',
                    'meta_description',
                    'meta_keywords',
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


    public static function boot() {

        parent::boot();


       /* Post::saving(function($data) {
            //--if saving data contains title then need to pass through the slug creation process
            if($data->title){
                Post::createSlug($data);
            }
            //--
            return true;
        });*/
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
        return \DateTime::createFromFormat('j/n/Y g:i A', $value);

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

    public static function resetOldMainPoststoUnspecified($main_post_id)
    {
        Post::where('display_type', 'main')->where('id', '<>', $main_post_id)->update(['display_type' => 'unspecified']);
    }

    public static function createSlug(&$data) {

        $data->slug_id = 0;
        $title_slug = Utility::slugifyString($data->title);

        $slugDetail = Post::select('slug_id', 'id')
            ->where(DB::raw('LOWER(title)'), '=', strtolower($data->title))
            ->orderBy('slug_id', 'DESC')
            ->first();
        if(@$slugDetail) {
            if($slugDetail->id == $data->id) {
                if($slugDetail->slug_id){
                    $title_slug =  $title_slug.$slugDetail->slug_id;
                }
                $data->slug = $title_slug;
                $data->slug_id = $slugDetail->slug_id;
            } else {
                $slug_id = $slugDetail->slug_id + 1;
                $data->slug = $title_slug.intval($slug_id);
                $data->slug_id = intval($slug_id);
            }

        } else {
            $data->slug = $title_slug;
            $data->slug_id = 0;
        }

        return $data;
    }


}
