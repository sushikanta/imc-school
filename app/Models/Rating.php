<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
 
    public $timestamps = false;
    protected $table = 'ratings';
    protected $primaryKey = 'id';
    protected $fillable = [
					'user_id',
					'rating',
					'ip',
					'created_at',
					'rated_by',
					'job_id',
					'review'
              ];

  
    protected $dates = [];
    protected $casts = [];
}
