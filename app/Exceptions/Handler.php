<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use Request;
use Illuminate\Auth\AuthenticationException;
use Response;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
		
		/*
		if ($request->expectsJson()) {
			
			//print_r($exception->getJsonBody());;die;
            $return_data['status']=(Boolean)false;
            $return_data['message']="Error Occured";
            $return_data['data']=new \stdClass();
            $return_data['error']['field_error']=$exception->getJsonBody();
            return response()->json( $return_data , 401);
        }
		*/
        return parent::render($request, $exception);
    }

    /**

     * Convert an authentication exception into an unauthenticated response.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \Illuminate\Auth\AuthenticationException  $exception

     * @return \Illuminate\Http\Response

     */

    protected function unauthenticated($request, AuthenticationException $exception){

        if ($request->expectsJson()) {

            /** return response()->json(['error' => 'Unauthenticated.'], 401); */
            $response = ['status' => false,'message' => 'Invalid access token','data'=>new \stdClass()  ];
            return response()->json($response, 401);
        }
        return redirect()->guest('login');
    }
}
