<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Validator;
use App\Models\AddonCard;
use App\Models\Business;
use App\User;
use App\Models\Staff;
use App\Models\Stripe;
use Route;
use Illuminate\Support\Facades\DB;
class CardsController extends Controller
{
  
  
  
  
  /*
       @Descriptuon: get all card details
      @Status: done
      @return  json
      @Created By Manjeet Kumar
      @Created Date: 20-3-2019
      @Modified Date: 20-3-2019
    */
    public function getAllCards(Request $request)
    {
        $user_id  = \Auth::id();
        $card =  AddonCard::getAllCards($user_id);

        $return_data['status']=(Boolean)true;
        $return_data['message']="";
        $return_data['data']= @$card;
        return $return_data;
    }
  
  
  /*
      @Descriptuon: get single card details
      @Status: done
      @return  json
      @Created By Manjeet Kumar
      @Created Date: 20-3-2019
      @Modified Date: 20-3-2019
    */

    public function getCardById(Request $request, $card_id)
    {
        $user_id  = \Auth::id();
        $card_id = (Integer)$card_id;
        $card =  AddonCard::getSingleCardDetails($user_id , $card_id   );
        $return_data['status']=true;
        $return_data['message']="";
        $return_data['data']= @$card;
        return $return_data;
    }

    // delete from stripe gateway
	public function deleteCard(Request $request, $card_id)
    {
        $user_id  = \Auth::id();
        $card_id = (Integer)$card_id;
        $card_details =  AddonCard::getSingleCardDetails($user_id , $card_id  );

        if(!@$card_details->id){
            $return_data['status']=(Boolean)false;
            $return_data['message']="Card id was invalid";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=array();
            return $return_data;
        }

        $delete_data=  AddonCard::where('user_id', $user_id)->where('id', $card_id)->delete();

        $business_data =  Business::where('user_id', $user_id)->first(); //business data
        $strip_data =    json_decode($business_data['strip_data']);
        $customer_id= @$strip_data->id;


        $s = new Stripe();
        $s->url .= 'customers/'.$customer_id.'/sources/'.@$card_details->strip_card_data_decoded->id;
        //echo  $s->url; die;
        $cards = $s->delete();
        $json_val = json_decode( $cards);
        if(!@$json_val->deleted)
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']=@$json_val->error->message;
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=array();
            return $return_data;
        }


        $return_data['status']=(Boolean)true;
        $return_data['message']="Card has been deleted successfully.";
        $return_data['data']= new \stdClass();
        return $return_data;
    }

     // add new card into stripe gateway
    public function addCard(Request $request)
    {
        $errors = AddonCard::validateCard($request);
        if($errors){

            $return_data['status']=(Boolean)false;
            $return_data['message']="The given data was invalid";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=$errors;
            return $return_data;
        }

        $user_id  = \Auth::id();

        $reqs = $request->all();
        //get business user details
        $user_data =  User::where('id', $user_id)->first(); //user data
        $business_data =  Business::where('user_id', $user_id)->first(); //business data


        $strip_data =    json_decode($business_data['strip_data']);
        //print_r($strip_data->id ) ;die;
        $customer_id= @$strip_data->id;
        if(!@$strip_data->id)
        {
            $s = new Stripe();
            $s->url .= 'customers';
            $data['description'] = $business_data->business_name;
            $data['email'] = $user_data->email;
            $customer = $s->post($data);
            $json_val = json_decode( $customer);
           // print_r( $json_val);die;
            if(!@$json_val->id)
            {
                $return_data['status']=(Boolean)false;
                $return_data['message']=@$json_val->error->message;
                $return_data['data']=new \stdClass();
                $return_data['error']['field_error']=array();
                return $return_data;
            }

            $customer_id= $json_val->id;

            $customer_update['user_id'] =  $user_id;
            $customer_update['strip_data'] =json_encode($json_val);
            Business::where('user_id', $user_id )->update($customer_update);
        }

        $s = new Stripe();
        $s->url .= 'tokens';
        $data=array();
        $data['card']['number'] = $reqs['card_number'];
        $data['card']['exp_month'] = $reqs['expiration_month'];
        $data['card']['exp_year'] = $reqs['expiration_year'];
        $data['card']['cvc'] = $reqs['cvc'];
        $data['card']['name'] = $reqs['card_holder_name'];
        $data['card']['currency'] = 'NOK';
       // echo "<pre>"; print_r($data ); die;
        $card = $s->post($data);
        $json_val = json_decode( $card);

        if(!@$json_val->id)
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']=@$json_val->error->message;
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=array();
            return $return_data;
        }

        $s = new Stripe();
        $s->url .= 'customers/'.$customer_id.'/sources';
        $data=array();
        $data['source'] = $json_val->id;
        $customer = $s->post($data);
        $json_val = json_decode( $customer);
        if(!@$json_val->id)
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']=@$json_val->error->message;
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=array();
            return $return_data;
        }

        $card_data =array();
        $card_data['user_id'] =  $user_id;
        $card_data['card_number'] =  @$json_val->last4;
        $card_data['card_holder_name'] =  @$json_val->name;
        $card_data['expiration_month'] = @$json_val->exp_month;
        $card_data['expiration_year'] =  @$json_val->exp_year;
        $card_data['created_at'] =  date('Y-m-d');
        $card_data['updated_at'] =  date('Y-m-d');
        $card_data['strip_card_data'] =json_encode($json_val);
        $card =  AddonCard::create( $card_data );
       // echo "<pre>"; print_r($json_val );  die;

       // $customer_strip= \Stripe\Customer::update( $strip_data->id,  [  'source' => $token->id ]  ); //update to server



        // $user_id = $request->get('user_id');
        $card_id = $card->id;
        if($request->get('set_default')){
            AddonCard::setDefaultCard($user_id, $card_id);
        }

        $return_data['status']=(Boolean)true;
        $return_data['message']="Card has been added successfully.";
        $return_data['data']=new \stdClass();
        return $return_data;
    }

    // updatecard card into stripe gateway
    public function updateCard(Request $request, $id)
    {
        $v = Validator::make($request->all(), [
            'expiration_year' => 'required',
            'expiration_month' => 'required|min:2|max:50',
            'card_holder_name' => 'required|min:2|max:50'
        ]);

        if ($v->fails())
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']=$v->errors()->all();
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=array();
            return $return_data;
        }

        $user_id  = \Auth::id();


        $card_details =  AddonCard::getSingleCardDetails($user_id , $id  );

       //echo "<pre>"; print_r($card_details) ;die;

        if(!$card_details)
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']='Invalid  card id';
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=array();
            return $return_data;
        }

        $reqs = $request->all();
        //get business user details
        $user_data =  User::where('id', $user_id)->first(); //user data
        $business_data =  Business::where('user_id', $user_id)->first(); //business data


        $strip_data =    json_decode($business_data['strip_data']);
        //print_r($strip_data->id ) ;die;
        $customer_id= $strip_data->id;
        if(!@$strip_data->id)
        {
            $s = new Stripe();
            $s->url .= 'customers';
            $data['description'] = $business_data->business_name;
            $data['email'] = $user_data->email;
            $customer = $s->post($data);
            $json_val = json_decode( $customer);
            // print_r( $json_val);die;
            if(!@$json_val->id)
            {
                $return_data['status']=(Boolean)false;
                $return_data['message']=@$json_val->error->message;
                $return_data['data']=new \stdClass();
                $return_data['error']['field_error']=array();
                return $return_data;
            }

            $customer_id= $json_val->id;

            $customer_update['user_id'] =  $user_id;
            $customer_update['strip_data'] =json_encode($json_val);
            Business::where('user_id', $user_id )->update($customer_update);
        }


        $s = new Stripe();
        $s->url .= 'customers/'.$customer_id.'/sources/'.@$card_details->strip_card_data_decoded->id;
        //echo $s->url; die;
        $data=array();
        $data['name'] = $reqs['card_holder_name'];
        $data['exp_month'] = $reqs['expiration_month'];
        $data['exp_year'] = $reqs['expiration_year'];

        $customer = $s->post($data);
        $json_val = json_decode( $customer);
        if(!@$json_val->id)
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']=@$json_val->error->message;
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=array();
            return $return_data;
        }

        $card_data =array();
        $card_data['user_id'] =  $user_id;
        $card_data['card_number'] =  @$json_val->last4;
        $card_data['card_holder_name'] =  @$json_val->name;
        $card_data['expiration_month'] = @$json_val->exp_month;
        $card_data['expiration_year'] =  @$json_val->exp_year;
        $card_data['created_at'] =  date('Y-m-d');
        $card_data['updated_at'] =  date('Y-m-d');
        $card_data['strip_card_data'] =json_encode($json_val);
        AddonCard::where('id', $id )->update($card_data);

        if($request->get('set_default')){
            AddonCard::setDefaultCard($user_id, $id);
        }

        $return_data['status']=(Boolean)true;
        $return_data['message']="Card has been updated successfully.";
        $return_data['data']=new \stdClass();
        return $return_data;
    }


    //get default card details
    public function getDefaultCard(Request $request)
    {
        $user_id  = \Auth::id();
        $card =  AddonCard::getDefaultCardDetails($user_id );
        $return_data['status']=(Boolean)true;
        $return_data['message']="";
        $return_data['data']= @$card;
        return $return_data;
    }
}