<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessPayment extends Model
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
    protected $table = 'business_payment';

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
					'user_id',
					'payment_amount',
					'payment_time',
					'payment_status',
					'payment_method',
					'transaction_id',
					'payment_card',
					'payment_gateway_response',
					'created_at',
                    'payment_currency'

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
    



}
