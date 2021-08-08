<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Psr\Http\Message\ServerRequestInterface;
use Laravel\Passport\Http\Controllers\AccessTokenController;

class CustomAccessTokenController extends AccessTokenController
{
    /**
     * Hooks in before the AccessTokenController issues a token
     *
     *
     * @param  ServerRequestInterface $request
     * @return mixed
     */
    public function issueUserToken(ServerRequestInterface $request)
    {
        $httpRequest = request();
        $httpRequest->request->add([
            "client_id"     => '2',
            "client_secret" => '4vmvsdgSWOtpzmsHUE1Br1qQ3vqdMHqby7PIvHyO',
            "grant_type"    => 'password',
            "code"          => '*',
        ]);
        // 1.
        if ($httpRequest->grant_type == 'password') {
            // 2.
            $user = \App\User::where('email', $httpRequest->username)->first();
           /* $validator = \Validator::make($user->toArray(), [
                'status' => [function($attribute, $value, $fail) {
                        if ($value != User::STATUS_ACTIVE) {
                            return $fail("account_unverified");
                        }
                    }]
            ]);*/

            if(false && $user && $user->status !== User::STATUS_ACTIVE)
			{
				$arr['status'] = (Boolean)false;
				$arr['message'] ="Account is not active.";
				$arr['data']=new \stdClass();
				$arr['error']['field_error']=array();


				$data['status'] = $user->status;

				if($user->status == User::STATUS_PENDING)
				{
					//$data['error'] = 'account_pending';
					//$data['message'] = 'Account is not verified';
					// some test codes added
					$arr['error']['type'] = 'account_pending';
					$arr['status'] = (Boolean)false;
					$arr['message'] ="Your account is not verified. Please verify to continue.";

				}
				
                return response($arr)->setStatusCode(200);
            }
            // Perform your validation here

            // If the validation is successfull:
            return $this->issueToken($request);
        }
    }
}