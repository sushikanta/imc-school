<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use LVR;
use LVR\CreditCard\CardCvc;
use LVR\CreditCard\CardNumber;
use LVR\CreditCard\CardExpirationYear;
use LVR\CreditCard\CardExpirationMonth;

class AddonCard extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'card_number',
        'card_holder_name',
        'created_at',
        'updated_at',
        'cvc',
        'expiration_month',
        'expiration_year',
        'strip_card_data'
    ];


    public static function  validateCard($request)
    {

        $validator_1 = \Validator::make($request->all(), [
            'card_number' => ['required'],
            'expiration_year' => ['required'],
            'expiration_month' => ['required'],
            'cvc' => ['required']
        ]);
        if($validator_1->fails()){
            $errors =  $validator_1->errors();
            return ($errors);
        }

        $validator = \Validator::make($request->all(), [
            'card_number' => ['required',  new CardNumber($request->get('card_number'))],
            'expiration_year' => ['required', new CardExpirationYear($request->get('expiration_month'))],
            'expiration_month' => ['required', new CardExpirationMonth($request->get('expiration_year'))],
            'cvc' => ['required', new CardCvc($request->get('card_number'))]
        ]);
        if ($validator->fails()) {
            $errors =  $validator->errors();
            return ($errors);
        }
        return null;
    }

    public static function setDefaultCard($user_id, $card_id)
    {
        AddonCard::where('user_id', '=', $user_id)
              ->update(['is_default' => false]);

        AddonCard::where('id', '=', $card_id)
            ->update(['is_default' => true]);
    }

    public static function getDefaultCard($user_id)
    {
        return AddonCard::where('user_id',  $user_id)->orderBy('is_default', 'DESC')->first();
    }

    public static function getAllCards($user_id)
    {
        $cards= AddonCard::where('user_id',  $user_id)->get();
        $cards->transform(function($item){
            $item['strip_card_data_decoded'] = new \stdClass();
            if($item->strip_card_data) {
                $item['strip_card_data_decoded'] = json_decode($item->strip_card_data);
            }
            return $item;
        });
        return $cards;
    }

    public static function getSingleCardDetails($user_id  , $card_id  )
    {
        $card = AddonCard::where('user_id', $user_id)->where('id', $card_id)->first();
        if($card) {
            $card['strip_card_data_decoded'] = new \stdClass();
            if ($card->strip_card_data) {
                $card['strip_card_data_decoded'] = json_decode($card->strip_card_data);
            }
        }
        else{
            $card =  new \stdClass();
        }
        return $card;
    }

    public static function getDefaultCardDetails($user_id  )
    {
        $card = AddonCard::where('user_id', $user_id)->orderBy('is_default', 'DESC')->first();
        if($card) {
            $card['strip_card_data_decoded'] = new \stdClass();
            if ($card->strip_card_data) {
                $card['strip_card_data_decoded'] = json_decode($card->strip_card_data);
            }
        }
        else{
            $card =  new \stdClass();
        }
        return $card;
    }

}
