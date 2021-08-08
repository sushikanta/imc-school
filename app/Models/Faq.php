<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
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
    protected $table = 'faqs';

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
                  'faq_category_id',
                  'question',
                  'answer',
                  'sort',
                  'display_client',
                  'display_staff',
                  'published'
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
     * Get the faqCategory for this model.
     */
    public function faqCategory()
    {
        return $this->belongsTo('App\Models\FaqCategory','faq_category_id');
    }

    public static function getGroupedFaqs()
    {
        $faqs = Faq::where('published', true)->with('faqcategory')->get();
        $data = null;
        if($faqs->count()){
            $faq_categories = [];
            foreach ($faqs as $faq){
                if(!isset($faq_categories[$faq->faq_category_id])){
                    $faq_categories[$faq->faq_category_id] = $faq->faqcategory;
                }
            }

            $faq_staffs = $faqs->filter(function ($item, $key) {
                return $item->display_staff;
            });
            $faq_clients = $faqs->filter(function ($item, $key) {
                return $item->display_client;
            });


            $faq_staffs = $faq_staffs->sortBy('sort')->groupBy('faq_category_id');
            $faq_clients = $faq_clients->sortBy('sort')->groupBy('faq_category_id');
            $data = ['categories' => $faq_categories, 'staffs' => $faq_staffs, 'clients' => $faq_clients];
        }
        return $data;
    }



}
