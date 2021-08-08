<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletOperation extends Model
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
    protected $table = 'wallet_operation';

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
					'job_id',
					'wallet_amount',
					'plus_minus_amount',
					'final_amount',
					'plus_minus_type',
					'operation_date',
					'description',
					'transation_details'
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
