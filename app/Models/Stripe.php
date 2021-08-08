<?php

/* 
@description: This api is used to for strip payment gateway
@created By : Manjeet Kumar Patel
@Created Date: 25March2019
Licence: GPL 
*/


namespace App\Models;

class Stripe {
	
	 public $url = 'https://api.stripe.com/v1/';
	 
	public function get()
	{
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_USERPWD, env('STRIPE_SECRET') . ':' . '');

		$result = curl_exec($ch);
		curl_close ($ch);
		return $result;
	}
	
	public function post($data_array)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_USERPWD, env('STRIPE_SECRET') . ':' . '');
		$headers = array();
		$headers[] = 'Content-Type: application/x-www-form-urlencoded';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		curl_close ($ch);
		return $result;	
	}
	
	
	public function delete(){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
		curl_setopt($ch, CURLOPT_USERPWD, env('STRIPE_SECRET') . ':' . '');
		$result = curl_exec($ch);
		curl_close ($ch);
		return $result;	
	}
	
}




//$s = new Stripe();

/*  //get customer by id 
$s->url .= 'customers/cus_ElIen1wMX9HxEo';
$customer = $s->get();
echo "<pre>"; print_r($customer); 

*/


/* // get all customer
$s->url .= 'customers?limit=3';
$customer = $s->get();
echo "<pre>"; print_r($customer); 
*/

/* // ad customer
$s->url .= 'customers';
$data['description'] = 'Customer';
$data['source'] = 'tok_mastercard';
$customer = $s->post($data);
echo "<pre>"; print_r($customer); 
*/

/*
//update customer 
$s->url .= 'customers/cus_ElIen1wMX9HxEo';
$data['description'] = ' manjeet kumar patel';
$data['source'] = 'tok_mastercard';
$customer = $s->post($data);
echo "<pre>"; print_r($customer); 
*/
/*
//delete  customer

$s->url .= 'customers/cus_ElIen1wMX9HxEo';
$customer = $s->delete();
echo "<pre>"; print_r($customer); 
*/