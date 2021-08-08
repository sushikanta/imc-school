<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\AddonCard;
use App\Models\Business;
use App\User;
use App\Models\Staff;
use App\Models\Stripe;
use App\Models\BankAccount;
use Route;
use Illuminate\Support\Facades\DB;
class BankAccountsController extends Controller
{
  
  /*
       @Descriptuon: get all bank account
      @Status: done
      @return  json
      @Created By Manjeet Kumar
      @Created Date: 27-3-2019
      @Modified Date: 27-3-2019
   */
    public function getAllAccounts(Request $request)
    {
        $user_id  = \Auth::id();
        $accounts =  BankAccount::getAlAccounts($user_id);
        $return_data['status']=(Boolean)true;
        $return_data['message']="";
        $return_data['data']= @$accounts;
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

    public function getAcountById(Request $request, $account_id)
    {
        $user_id  = \Auth::id();
        $account_id = (Integer)$account_id;
        $account =  BankAccount::getSingleAccountDetails($user_id , $account_id   );
        $return_data['status']=true;
        $return_data['message']="";
        $return_data['data']= @$account;
        return $return_data;
    }

    // delete from stripe gateway
	public function deleteAccount(Request $request, $account_id)
    {
        $user_id  = \Auth::id();
        $account_id = (Integer)$account_id;
        $account_details =  BankAccount::getSingleAccountDetails($user_id , $account_id  );

        if(!@$account_details->id){
            $return_data['status']=(Boolean)false;
            $return_data['message']="Account id was invalid";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=array();
            return $return_data;
        }

        $delete_data=  BankAccount::where('user_id', $user_id)->where('id', $account_id)->delete();

        $staff_data =  Staff::where('user_id', $user_id)->first(); //business data
        $strip_data =    json_decode($staff_data['stripe_response']);
        $customer_id= @$strip_data->id;


        $s = new Stripe();
        $s->url .= 'customers/'.$customer_id.'/sources/'.@$account_details->stripe_response_decoded->id;
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
        $return_data['message']="Account has been deleted successfully.";
        $return_data['data']= new \stdClass();
        return $return_data;
    }

     //  addAccount into stripe gateway
    public function addAccount(Request $request)
    {
        $v = Validator::make($request->all(), [
            'account_holder_name' => 'required',
            'account_holder_type' => 'required',
            'routing_number' => 'required|integer',
            'account_number' => 'required',
            'account_holder_name' => 'required'
        ]);

        if ($v->fails())
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']="Field validation error";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=$v->errors();
            return $return_data;
        }


        $user_id  = \Auth::id();

        $reqs = $request->all();
        //get business user details
        $user_data =  User::where('id', $user_id)->first(); //user data
        $staff_data =  Staff::where('user_id', $user_id)->first(); //staff data

        $strip_data =    json_decode($staff_data['stripe_response']);
        //print_r($strip_data->id ) ;die;
        $customer_id= @$strip_data->id;
        if(!@$strip_data->id)
        {
            $s = new Stripe();
            $s->url .= 'customers';
            $data['description'] = $user_data->firstname;
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
            $customer_update['stripe_response'] =json_encode($json_val);
            Staff::where('user_id', $user_id )->update($customer_update);
        }



        $s = new Stripe();
        $s->url .= 'tokens';
        $data=array();
        $data['bank_account']['country'] = 'US';
        $data['bank_account']['currency'] = 'USD';
        $data['bank_account']['account_holder_name'] = $reqs['account_holder_name'];
        $data['bank_account']['account_holder_type'] = $reqs['account_holder_type'];
        $data['bank_account']['routing_number'] = $reqs['routing_number'];
        $data['bank_account']['account_number'] = $reqs['account_number'];
       //echo "<pre>"; print_r($data ); die;
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

        $account_data =array();
        $account_data['user_id'] =  $user_id;
        $account_data['country'] =  @$json_val->country;
        $account_data['currency'] =  @$json_val->currency;
        $account_data['account_holder_name'] = @$json_val->account_holder_name;
        $account_data['account_holder_type'] =  @$json_val->account_holder_type;
        $account_data['routing_number'] =  @$json_val->routing_number;
        $account_data['account_number'] =  @$json_val->last4;
        $account_data['created_at'] =  date('Y-m-d H:i:s');
        $account_data['updated_at'] =  date('Y-m-d H:i:s');
        $account_data['stripe_response'] =json_encode($json_val);
        $card =  BankAccount::create( $account_data );
        //echo "<pre>"; print_r($json_val );  die;
       // $customer_strip= \Stripe\Customer::update( $strip_data->id,  [  'source' => $token->id ]  ); //update to server

        // $user_id = $request->get('user_id');
        $card_id = $card->id;
        if($request->get('set_default')){
            BankAccount::setDefaultAccount($user_id, $card_id);
        }

        $return_data['status']=(Boolean)true;
        $return_data['message']="Account has been added successfully.";
        $return_data['data']=new \stdClass();
        return $return_data;
    }

    // update Account into stripe gateway API
    public function updateAccount(Request $request, $id)
    {
        $v = Validator::make($request->all(), [
            'account_holder_name' => 'required',
            'account_holder_type' => 'required|min:2|max:50'
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

        $bank_details =  BankAccount::getSingleAccountDetails($user_id , $id  );

       //echo "<pre>"; print_r($card_details) ;die;

        if(!$bank_details)
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']='Invalid  Account id';
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=array();
            return $return_data;
        }

        $reqs = $request->all();
        //get business user details
        $user_data =  User::where('id', $user_id)->first(); //user data
        $staff_data =  Staff::where('user_id', $user_id)->first(); //staff data

        $strip_data =    json_decode($staff_data['stripe_response']);
        //print_r($strip_data->id ) ;die;
        $customer_id= @$strip_data->id;
        if(!@$strip_data->id)
        {
            $s = new Stripe();
            $s->url .= 'customers';
            $data['description'] = $user_data->firstname;
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
            $customer_update['stripe_response'] =json_encode($json_val);
            Staff::where('user_id', $user_id )->update($customer_update);
        }



        $s = new Stripe();
        $s->url .= 'customers/'.$customer_id.'/sources/'.@$bank_details->stripe_response_decoded->id;
        //echo $s->url; die;
        $data=array();
        $data['account_holder_name'] = $reqs['account_holder_name'];
        $data['account_holder_type'] = $reqs['account_holder_type'];

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

        $account_data =array();
        $account_data['user_id'] =  $user_id;
        $account_data['country'] =  @$json_val->country;
        $account_data['currency'] =  @$json_val->currency;
        $account_data['account_holder_name'] = @$json_val->account_holder_name;
        $account_data['account_holder_type'] =  @$json_val->account_holder_type;
        $account_data['routing_number'] =  @$json_val->routing_number;
        $account_data['account_number'] =  @$json_val->last4;
        $account_data['updated_at'] =  date('Y-m-d H:i:s');
        $account_data['stripe_response'] =json_encode($json_val);
        BankAccount::where('id', $id )->update($account_data);

        if($request->get('set_default')){
            BankAccount::setDefaultAccount($user_id, $id);
        }

        $return_data['status']=(Boolean)true;
        $return_data['message']="Account has been updated successfully.";
        $return_data['data']=new \stdClass();
        return $return_data;
    }


    //get default account details API
    public function getDefaultAccount(Request $request)
    {
        $user_id  = \Auth::id();
        $account =  BankAccount::getDefaultAccountDetails($user_id );
        $return_data['status']=(Boolean)true;
        $return_data['message']="";
        $return_data['data']= @$account;
        return $return_data;
    }
}