<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laraveldaily\Quickadmin\Observers\UserActionsObserver;




class Tmpcountries extends Model {

    

    

    protected $table    = 'tmpcountries';
    
    protected $fillable = [
          'title',
          'code',
          'published',
          'sort_id'
    ];
    

    public static function boot()
    {
        parent::boot();

        Tmpcountries::observe(new UserActionsObserver);
    }
    
    
    
    
}