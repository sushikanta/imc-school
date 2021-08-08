<?php

namespace App\Http\Controllers;

use App\MailToken;
use App\Models\AddonCard;
use App\Models\Business;
use App\Models\StaffJob;
use App\Models\StaffJobSkill;
use App\Models\Staff;
use App\Models\BusinessPayment;
use App\Models\ObjSkillsRef;
use App\Models\Job;
use App\Models\Addresses;
use App\Models\JobApplication;
use App\Role;
use App\Rules\ValidateEmailExist;
use App\User;
use App\UsersRole;
use App\Models\JobVacency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\Types\Boolean;
use phpDocumentor\Reflection\Types\Integer;
use Validator;
use Illuminate\Support\Facades\Crypt;
use Route;
use Illuminate\Support\Facades\DB;

class PaymentsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $start_date = @$request->get('start_date');
        $end_date = @$request->get('end_date');
        $payment_from = @(Integer)$request->get('payment_from');
        $payment_to = @(Integer)$request->get('payment_to');

        $field = $request->get('field') != '' ? $request->get('field') : 'business_payment.payment_time';
        $sort = $request->get('sort') != '' ? $request->get('sort') : 'desc';
        $payment = User::join('business_payment','business_payment.user_id', '=', 'users.id');
        $payment->select('business_payment.*','users.firstname','users.lastname','users.email', 'users.created_at','users.status');

		if(trim($search)!='')
		{
			$payment->where('users.email', 'like', '%' . $search . '%');
            $payment->orWhere('users.firstname', 'like', '%' . $search . '%');
            $payment->orWhere('users.lastname', 'like', '%' . $search . '%');
            $payment->orWhere('business_payment.payment_status', 'like', '%' . $search . '%');
		}

        if($start_date!='')
        {
            $payment->where(DB::raw('date(business_payment.payment_time)'), '>=', $start_date);
        }

        if($end_date!='')
        {
            $payment->where(DB::raw('date(business_payment.payment_time)'), '<=', $end_date);
        }

        if($payment_from!='')
        {
            $payment->where('business_payment.payment_amount', '>=', (double)$payment_from);
        }

        if($payment_to!='')
        {
            $payment->where('business_payment.payment_amount', '<=', (double)$payment_to);
        }


        $payment->orderBy($field, $sort);
        $payment=  $payment->paginate(20);
        $payment=  $payment->withPath('?search=' . $search . '&field=' . $field . '&sort=' . $sort);
       // echo "<pre>"; print_r($payment); die;
        return view('payments.index', compact('payment'));
    }

    public function paymentdetail(Request $request)
    {
        $req = $request->all();
        $payment_id= $req['id'];

        $payment = User::join('business_payment','business_payment.user_id', '=', 'users.id');
        $payment->select('business_payment.*','users.firstname','users.lastname','users.email');
        $payment= $payment->where('business_payment.id', $payment_id)->first();

        if($payment)
        {
            //$payment = $payment->toArray();
            if( $payment->payment_gateway_response ) {
                $payment->payment_gateway_response = json_decode($payment->payment_gateway_response);
            }
        }

      //echo "<pre>"; print_r($payment); echo "</pre>";// die;
        return view('payments.details', compact('payment'));
    }

}