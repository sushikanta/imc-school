<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use LVR;
use LVR\CreditCard\CardCvc;
use LVR\CreditCard\CardNumber;
use LVR\CreditCard\CardExpirationYear;
use LVR\CreditCard\CardExpirationMonth;

class BankAccount extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'account_holder_name',
        'account_holder_type',
        'routing_number',
        'account_number',
        'stripe_response',
		'created_at',
        'country',
        'currency',
        'updated_at',
    ];


    public static function setDefaultAccount($user_id, $account_id)
    {
        BankAccount::where('user_id', '=', $user_id)
              ->update(['is_default' => false]);

        BankAccount::where('id', '=', $account_id)
            ->update(['is_default' => true]);
    }

   

    public static function getAlAccounts($user_id)
    {
        $accounts= BankAccount::where('user_id',  $user_id)->get();
        $accounts->transform(function($item){
            $item['stripe_response_decoded'] = new \stdClass();
            if($item->stripe_response) {
                $item['stripe_response_decoded'] = json_decode($item->stripe_response);
            }
            return $item;
        });
        return $accounts;
    }

    public static function getSingleAccountDetails($user_id  , $account_id  )
    {
        $account = BankAccount::where('user_id', $user_id)->where('id', $account_id)->first();
        if($account) {
            $account['stripe_response_decoded'] = new \stdClass();
            if ($account->stripe_response) {
                $account['stripe_response_decoded'] = json_decode($account->stripe_response);
            }
        }
        else{
            $account =  new \stdClass();
        }
        return $account;
    }

    public static function getDefaultAccountDetails($user_id  )
    {
        $account = BankAccount::where('user_id', $user_id)->orderBy('is_default', 'DESC')->first();
        if($account) {
            $account['stripe_response_decoded'] = new \stdClass();
            if ($account->stripe_response) {
                $account['stripe_response_decoded'] = json_decode($account->stripe_response);
            }
        }
        else{
            $account =  new \stdClass();
        }
        return $account;
    }

}
