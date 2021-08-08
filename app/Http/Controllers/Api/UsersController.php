<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\MailToken;
use App\Models\AddonCard;
use App\Models\Business;
use App\Models\Staff;
use App\Role;
use App\Rules\ValidateEmailExist;
use App\User;
use App\UsersRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\Types\Boolean;
use Validator;
use Route;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
	/*
	  retgistration process of user
	  @return @json  
	  @Created By Manjeet Kumar
	  @Created Date: 11-2-2019
	  @Modified Date: 11-2-2019
	*/
	
    public function register(Request $request)
	{
        $input = $request->all();
        if($request->input('user_type')){
            $role_id = Role::get_role_id($request->input('user_type'));
            if($role_id){
                $input['role_id'] = $role_id;
            }

        }

        $v = Validator::make($input, [
			'role_id' => 'required',
            'firstname' => 'required|min:2|max:50',
            'lastname' => 'required|min:2|max:50',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        if ($v->fails())
        {
            $return_data['status']=(Boolean)false;
            $return_data['message']="Field validation error";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=$v->errors();
            return $return_data;
        }
		else
		{
			$input['password'] = Hash::make($input['password']);
			$input['status'] = 'pending';
			$user = User::create($input);
			UsersRole::create(['user_id' => $user->id, 'role_id' => $input['role_id'] ]  );
			
			try
			{
				User::sendWelcomeConfirmEmail($user); //send email for account varification
			}
			catch(Exception $e)
			{
				
			}
			$return_data['status']=(Boolean)true;
            $return_data['message']="Your account has been successfully created, please check your email to varify account.";
            $return_data['data']=new \stdClass();
            return $return_data;
		}
    }
   

    public function checkEmailExists(Request $request)
	{
        $result = User::doesExistEmail($request->email);
		
		$return_data['status']=(Boolean)false;
		$return_data['message']="This email is not exists";
		if($result)
		{
			$return_data['status']=(Boolean)true;
			$return_data['message']="This email id is already exists.";
		}
		
		//$return_data['payload']=array();
		
		$return_data['data']=new \stdClass();
        $return_data['error']['field_error']=array();
		
		
		return $return_data;
    }


    public function logout(Request $request)
    {
        $user_id  = \Auth::id();
        $data['is_online'] = false;
        User::where('id', '=', $user_id)->update($data);

        $accessToken = \Auth::user()->token();
        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);

        $accessToken->revoke();

        $return_data['status']=(Boolean)true;
        $return_data['message']="You have successfully logged out.";
        $return_data['data']=new \stdClass();
        return $return_data;
    }

    public function apiLogin(Request $request) 
	{

		$tokenRequest = $request->create('/api/login/token', 'POST', $request->all( ));
        $request->request->add([
            "client_id"     => '2',
            "client_secret" => '4vmvsdgSWOtpzmsHUE1Br1qQ3vqdMHqby7PIvHyO',
            "grant_type"    => 'password',
            "code"          => '*',
        ]);

        $response = Route::dispatch($tokenRequest);
        $data = (array) json_decode($response->getContent());

        if(@$data['access_token'])
        {
            $arr['status'] = (Boolean)true;
            $arr['message'] = "You have successfully logged in.";
            $arr['data']['token'] = $data['access_token'];
            $arr['data']['user_data'] = User::getUserInfo($request->username);
        }
        else
        {
            if(@$data['error']){
                $arr['error'] = (array) $data['error'];
            }

            $arr['status'] = (Boolean)false;
            $arr['message'] =@$data['message'];
            $arr['data'] =null;

        }
        return $arr;
		
    }

}