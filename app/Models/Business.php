<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'business_category_id',
        'regd_no',
        'lat',
        'lng',
        'status',
        'avg_rating',
        'preferences',
        'business_name',
        'timezone_id',
        'business_detail',
        'business_picture',
    ];
}
