<?php

namespace App\Http\Controllers;

use App\Classes\Utility;
use App\Mail\AdminContactus;
use App\Mail\WelcomeAccountConfirm;
use App\MailToken;
use App\Models\Category;
use App\Models\ContactusQuery;
use App\Models\Country;
use App\Models\Post;
use App\Models\StaffJobs;
use App\Models\Faq;
use App\User;
use App\Models\Timezone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Mail;
use SendGrid;
use SendGrid\Personalization;
use SendGrid\Email;
use View;
use LVR;
use LVR\CreditCard\CardCvc;
use LVR\CreditCard\CardNumber;
use LVR\CreditCard\CardExpirationYear;
use LVR\CreditCard\CardExpirationMonth;
use Illuminate\Foundation\Http\FormRequest;


class TestController extends Controller
{

    public function index(Request $req)
    {
        if($func = $req->get('func')){
            return $this->$func($req);
        }
        return 'No params passed!';
    }
    public function show()
    {
    /*
            php artisan resource-file:create Country --fields=id,title,code,published,sort
    */
        /*$data = User::doesExistEmail('admin@time2staff.com');
        dd($data);*/
        $address = 'skanta.it@gmail.com';
        $subject = 'This is a test mail!';
        $name = 'Skanta Singh';
        $result = Mail::to($address)
            ->send(new WelcomeAccountConfirm());

    }

    public function previewMail(){

        $id = 1;
        $obj = ContactusQuery::find($id);
        $result = Mail::to('realtyninfra@gmail.com')
            ->bcc('skanta.it@gmail.com')
            ->send(new AdminContactus($obj));
        dd($result);
    }

    public function unitTest(Request $request)
    {

        $encrypted = Crypt::encryptString('4012888888881881');

        echo $encrypted;
        $decrypted = Crypt::decryptString($encrypted);
        return $decrypted;

        /*$data = \Request::all();
       if($func = @$data['func']){
           return $this->$func($request);
       }
       dd($data);*/
    }
    public function get_mail_code(){
        $user_id = 1;
        $user = User::find($user_id);
        User::sendWelcomeConfirmEmail($user);
    }

    public function admin_contact_email()
    {
        return view('emails.admin_contactus', ['type' => MailToken::TYPE_MAIL_CONTACTUS, 'id' => 1]);
    }

    public function preview_mail()
    {
        return view('emails.welcome_confirm', ['type' => MailToken::TYPE_MAIL_CONFIRMATION, 'user_id' => 1]);
    }

    public function preview_forgotpassword_mail()
    {
        return view('emails.forgot_password', ['type' => MailToken::TYPE_FORGOT_PASSWORD, 'user_id' => 8]);
    }

    public function get_timezones()
    {
        $requests = \Request::all();
        $tzlist = \DateTimeZone::listIdentifiers(\DateTimeZone::ALL);
        $zones_array = array();
        $timestamp = time();
        foreach ($tzlist as $key => $zone){
            date_default_timezone_set($zone);
            $zones_array[$key]['zone'] = $zone;
            $zones_array[$key]['gmt'] = date('P', $timestamp);
            $tz = new \DateTimeZone($zone);
            $location = $tz->getLocation();
            $zones_array[$key]['country_code'] = $location['country_code'];

            if(@$requests['insert']){
                    $obj  = new Timezone();
                    $obj->zone = $zone;
                    $obj->gmt = date('P', $timestamp);
                    $obj->country_code = $location['country_code'];
                    $obj->save();

            }
        }


        echo  '<pre>';
        print_r($zones_array);
        exit;
        // dd($zones_array);
    }

    public function test_photo_delete()
    {
        $requests = \Request::all();
        if($id = @$requests['id']){
            User::deleteUserAvatarFiles($id);
        }
        dd($requests);
    }

    public function validate_card($request)
    {

        $requests = \Request::all();
        $request->validate([
            'card_number' => ['required'],
            'expiration_year' => ['required'],
            'expiration_month' => ['required'],
            'cvc' => ['required']
        ]);

        $validator = \Validator::make($requests, [
            'card_number' => ['required', 'numeric', new CardNumber(@$requests['card_number'])],
            'expiration_year' => ['required', new CardExpirationYear(@$requests['expiration_month'])],
            'expiration_month' => ['required', new CardExpirationMonth(@$requests['expiration_year'])],
            'cvc' => ['required', new CardCvc(@$requests['card_number'])]
        ]);
        if ($validator->fails()) {
            $errors =  $validator->errors();

            return ($errors);
        }
        return $requests;
    }

    public function phpinfo() {
         phpinfo();
    }

    public function pr(){
        $targetDir = base_path('../uploads');
        print_r($targetDir);
        exit;
    }

    public function getUsersList()
    {
        $country = Country::all();
        // $country = Country::get();
        // $country = Country::first();
        //$country = Country::where('title', 'India')
          //  ->where('code','=', 'IN')
            //->get();
        return $country;
    }


    public function addCountry(Request $request){

        $country = new Country();
        $country->title = $request->title;
        $country->code=$request->code;
        $country->sort=$request->sort;
        $country->published=$request->published;

        $country->save();


        return $country;
    }


    public function updateCountry(Request $request){

//        $country = new Country();
//        $country->title = $request->title;
//        $country->code=$request->code;
//        $country->sort=$request->sort;
//        $country->published=$request->published;

        //return $request;
        $country= Country::where('id',$request->id)
                ->update(['title'=> $request->title,'code'=> $request->code,'sort'=>$request->sort,'published'=> $request->published]);
        return $country;
    }


    public function deleteCountry($id){

        $country= Country::findorFail($id);
        $country->delete();

        return ['success'=> true];
    }



    public function fetchStaffSkills($skill){

        $user = User::join('users_roles','users.id','=','users_roles.user_id')
            ->join('roles','users_roles.role_id','=','roles.id')
            ->where('roles.title',$skill)
            ->select('users.*')
            ->get();

        return ['data'=>$user];
    }

    public function fetchStaffJobSkill($userid){

        $staffJobs = StaffJobs::join('staff_job_skills','staff_job_skills.staff_job_id','=','staff_jobs.id')
            ->join('skills','skills.id', '=', 'staff_job_skills.skill_id')
            ->where('staff_user_id',$userid)
            ->select('staff_jobs.staff_user_id','staff_jobs.job_title_id','staff_jobs.id','staff_job_skills.skill_id','skills.title')
            ->get();
        return $staffJobs;
    }


    public function faqs()
    {
        return Faq::getGroupedFaqs();
    }

    public function getLangData($lang)
    {

        $file_path = asset('i18n/'. $lang.'.json');
        $data = json_decode(file_get_contents($file_path), true);
        return $data;
    }

    public function storeTranslationData(Request $request)
    {
        //return $request->all();

        return ['status' => 'success'];
    }

    public function testUpload(Request $request)
    {
        $all = $request->all();
        $files = $_FILES;
        return ['reqs' => $all, 'files' => $files];
    }

    public function testCard(Request $request)
    {
        // sample url: http://localhost/time2staff/backend/public/unit-test?func=testCard

        try {
            // Use Stripe's library to make requests...
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $customer = \Stripe\Customer::retrieve("cus_EjU5vzRsqFqrMY");

        } catch(\Stripe\Error\Card $e) {
            // Since it's a decline, \Stripe\Error\Card will be caught
            $body = $e->getJsonBody();
            $err  = $body['error'];

            print('Status is:' . $e->getHttpStatus() . "\n");
            print('Type is:' . $err['type'] . "\n");
            print('Code is:' . $err['code'] . "\n");
            // param is '' in this case
            print('Param is:' . $err['param'] . "\n");
            print('Message is:' . $err['message'] . "\n");
        } catch (\Stripe\Error\RateLimit $e) {
            return "ratelimit";
            // Too many requests made to the API too quickly
        } catch (\Stripe\Error\InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
            return "invalid";

        } catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            return "keychange";

        } catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
            return "net";

        } catch (\Stripe\Error\Base $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            return "email";

        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            return "other";

        }
    }

    public function updatePostSlugs()
    {
        $posts = Post::all();
        $posts->transform(function($item) {
           $slug = Utility::slugifyString($item->title);
           Post::where('id', $item->id)
               ->update([
                   'slug' => $slug,
                   'slug_id' => 0
               ]);
            return $item;
        });
        $posts = Post::all();
        dd($posts->toArray());
    }

    public function updateCategorySlugs()
    {
        $cats = Category::all();
        $cats->transform(function($item) {
            $slug = Utility::slugifyString($item->title);
            Category::where('id', $item->id)
                ->update([
                    'slug' => $slug,
                    'slug_id' => 0
                ]);
            return $item;
        });
        $cats = Category::all();
        dd($cats->toArray());
    }


    public function createAdmin(Request $req)
    {

        // https://realtyninfra.com/admin/unit-test?func=createAdmin&email=seo@realtyninfra.com&password=pw4seo2k20realtyninfra&id=2&name=SEO_REALTY
        $pw = $req->password?$req->password: 'password';
        User::insert(
            [
                'id' => $req->id,
                'name' =>  $req->name,
                'role_id' => '1',
                'email' => $req->email,
                'password' =>  \Hash::make($pw),
            ]
        );
        //INSERT INTO `realtyninfra`.`users` (`id`, `role_id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`)
        // VALUES (2, 1, 'admin', 'seo@realtyninfra.com', '$2y$10$BMo8B.YfaPuTiDZQ7e5g0./KmD9ASoNyFsf95Ps2g9g0MNg2T8.hq', 'im2VRGZTLqC7B2vQTTlaIVDhDsCjzY80pT79I7aTXrLTWMgEqmR6xWdykQw2', '2018-08-24 12:27:23', '2019-07-10 14:12:19');
    }

    public function createPDF() {
        return view('pdf');
    }
}
