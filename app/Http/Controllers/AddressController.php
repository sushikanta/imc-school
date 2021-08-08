<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 16-01-2019
 * Time: 12:59
 */

namespace App\Http\Controllers;


use App\Models\Addresses;
use App\Models\Country;
use App\User;
use Exception;
use Illuminate\Http\Request;

class AddressController extends Controller
{

public function index(){
    $addresses = Addresses::select('address1','address2','city','state','zipcode','countries.title as country')
            ->join('countries','countries.id', '=', 'addresses.country_id')
            ->get();

    //$country = Country::all();


    return view('addresses/index',compact('addresses'));
}


public function create(){
    $country = Country::all();
    return view('addresses/create',compact('country'));
}

public function store(Request $request){

    try{
        $data = $this->getData($request);

       //dd($data);
        Addresses::create($data);

        return redirect()->route('addresses.address.index');
    }catch (Exception $exception){
        dd($exception);
        $error_messages = ['unexpected_error' => 'Unexpected error occurred while trying to process your request!'];
        if(@$exception->validator){
            $error_messages = $exception->validator;
        }
        return back()->withInput()
            ->withErrors($error_messages);
    }


}

    protected function getData($request)
    {
        $rules = [
            'address1' => 'string|min:1|max:255|nullable',
            'address2' => 'string|min:1|max:255|nullable',
            'city' => 'string|min:1|max:255|nullable',
            'state' => 'string|min:1|max:255|nullable',
            'zipcode' => 'string|min:1|nullable',
            'country_id' => 'string|min:1|nullable',

        ];

        $data = $request->validate($rules);

        return $data;
    }


}