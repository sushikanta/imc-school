<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
  
    public $timestamps = false;
    protected $table = 'contact_us';
    protected $primaryKey = 'id';
	 protected $fillable = [
                  'name',
                  'email',
                  'subject',
				  'message',
				  'subscribe_news',
				  'created_at'
              ];

}
