<?php

namespace App;

use App\Classes\Utility;
use App\Mail\ForgotPassword;
use App\Mail\WelcomeAccountConfirm;
use App\Models\AddonCard;
use App\Models\Business;
use App\Models\Staff;
use App\Models\SysSetting;
use App\Rules\ValidateBusinessExist;
use App\Rules\ValidateEmailExist;
use Validator;
use Laravel\Passport\HasApiTokens;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use App\Role;

use Mail;

class User extends Model implements AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use HasApiTokens, Authenticatable, Authorizable, CanResetPassword;
    //----- Status types for different users

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'firstname',
        'lastname',
        'status',
        'address1',
        'address2',
        'city',
        'state',
        'zipcode',
        'country_id',
        'timezone_id',
        'contact1',
        'contact2',
        'about',
		'is_deleted',
		'updated_at',
        'strip_data',
        'photo_src'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    const STATUS_ACTIVE = 'active';
    const STATUS_PENDING = 'pending';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_SUSPENDED = 'suspended';

    public static $status_lbl = array(
        User::STATUS_ACTIVE => "Active",
        User::STATUS_PENDING => "Pending",
       // User::STATUS_INACTIVE => "Inactive",
       // User::STATUS_SUSPENDED => "Suspended",
    );

    public static function boot()
    {
        parent::boot();

        //User::observe(new UserActionsObserver);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Checks whether an email exists in the database
     * @param string $password
     * @return boolean TRUE/FALSE
     */
    public static function doesExistEmail($email, $options = [])
    {
        $query1 = User::addSelect('users.id')
            ->where('users.email', '=', $email)
            ->whereRaw('users.is_deleted IS NOT TRUE');
        if (isset($options['user_id'])) {
            $query1->where('users.id', '<>', $options['user_id']);
        }

        return $query1->first()?true:false;

    }

    public static function  validateStaff($request)
    {
        return $request->validate([
            'user_type' => 'required',
            'firstname' => 'required|min:2|max:50',
            'lastname' => 'required|min:2|max:50',
            'email' => ['required', 'email', new ValidateEmailExist(true)],
            'password' => 'required|min:6',
        ]);
    }

    public static function doesExistBusiness($id)
    {
        $query1 = UsersRole::addSelect('users_roles.id')
            ->join('roles', 'roles.id', '=', 'users_roles.role_id')
            ->where('roles.alias', Role::TYPE_CLIENT)
            ->where('user_id', '=', $id)
        ;
        return $query1->first()?true:false;

    }

    public static function doesExistStaff($id)
    {
        $query1 = UsersRole::addSelect('users_roles.id')
            ->join('roles', 'roles.id', '=', 'users_roles.role_id')
            ->where('roles.alias', Role::TYPE_STAFF)
            ->where('user_id', '=', $id)
        ;
        return $query1->first()?true:false;

    }


    public static function validateBusinessUpdates($request)
    {
        $request->validate([
           'id' => ['required',
               function($attribute, $value, $fail) {
                   if (!self::doesExistBusiness($value)) {
                       return $fail("Business does not exists.");
                   }
               }],
            'name' => ['required'],
            'business_category_id' => ['required'],
            'contact1' => ['required'],
            'address1' => ['required'],
            'city' => ['required'],
            'zipcode' => ['required'],
           /* 'state' => ['required'],*/
            'country_id' => ['required'],
            'timezone_id' => ['required'],

        ], [
            'name.required' => 'Business title is required.',
            'business_category_id.required' => 'Please select business category.',
            'country_id.required' => 'Please select country.',
            'timezone_id.required' => 'Please select timezone.',
        ]);
    }

    public static function validateStaffUpdates($request)
    {
        $request->validate([
            'id' => ['required',
              /*  function($attribute, $value, $fail) {
                    if (!self::doesExistStaff($value)) {
                        return $fail("Staff does not exists.");
                    }
                }  */  ],
            'firstname' => ['required'],
            'lastname' => ['required'],
            'dob' => ['required'],
            'gender' => ['required'],
            'contact1' => ['required'],
            'address1' => ['required'],
            'city' => ['required'],
            'zipcode' => ['required'],
            /* 'state' => ['required'],*/
            'country_id' => ['required'],
            'timezone_id' => ['required'],

        ], [
            'name.required' => 'Business title is required.',
            'business_category_id.required' => 'Please select business category.',
            'country_id.required' => 'Please select country.',
            'timezone_id.required' => 'Please select timezone.',
        ]);
    }

    public static function sendWelcomeConfirmEmail($user){
        $bcc = 'skanta.glocal@gmail.com';
        $result = Mail::to($user->email)
            ->bcc($bcc)
          //  ->from('contact@sushikanta.com')
            ->send(new WelcomeAccountConfirm($user));
    }

    public static function sendForgotPasswordEmail($user){
        $bcc = 'skanta.glocal@gmail.com';
        $result = Mail::to($user->email)
            ->bcc($bcc)
            ->send(new ForgotPassword($user));
    }

    public static function resetNewPassword($user, $new_password)
    {

    }

    public static function getUserInfo($email,  $options = [])
    {
        $user = User::select('*')
            ->where('users.email', '=', $email)
            ->whereRaw('users.is_deleted IS NOT TRUE')
            ->first();
        if($user){
            $decoded = [];
            if($user->photo_src){
                $decoded  = json_decode($user->photo_src);
            }
            $user->photo_src_decoded = $decoded;
            $data = UsersRole::addSelect( 'roles.id',   'roles.title', 'roles.alias', 'users_roles.created_at')
                ->where('users_roles.user_id', $user->id)
                ->leftJoin('roles', 'roles.id', '=','users_roles.role_id')
                ->get();

            // ---- getting users role_type, possible values = [ staff | client | both ]
           // if($data->count())
			$role_type = '';
			foreach($data as $key=>$value)
			{
				if($value->alias==Role::TYPE_CLIENT)
				{
					//client
                    $role_type = $role_type ? 'multiple' : Role::TYPE_CLIENT;
					$preferences = Business::select('preferences')->where('user_id', $user->id)->first();
				}
				
				if($value->alias == Role::TYPE_STAFF)
				{
					//staff   Staff
                    $role_type = $role_type ? 'multiple' : Role::TYPE_STAFF;
                    $preferences = Staff::select('preferences')->where('user_id', $user->id)->first();
					
				}

				$value->preferences =(Boolean)false;
				
				if(@$preferences->preferences=='true')
				{
					$value->preferences =(Boolean)true;
				}
			}
			//-- adding additional property role_type to directly identify the associated roles
            $user->role_type = $role_type;
				//print_r($data); die;
            $user->roles = $data;
            $sysSetting = SysSetting::where('type', SysSetting::TYPE_POLICY)->where('key', SysSetting::POLICY_TERMS_CLIENT)->first();
            $user->terms = $sysSetting?$sysSetting->value:'';
        }
        return $user;
    }

    public static function getBusinessDetails($user_id, $options = [])
    {
        $user = User::select('*')
            ->where('users.id', '=', $user_id)
            ->whereRaw('users.is_deleted IS NOT TRUE')
            ->first();
        if($user){
            $decoded = [];
            if($user->photo_src){
                $decoded  = json_decode($user->photo_src);
            }
            $user->photo_src_decoded = $decoded;
            $data = UsersRole::addSelect('roles.title', 'roles.alias', 'users_roles.created_at')
                ->where('users_roles.user_id', $user->id)
                ->leftJoin('roles', 'roles.id', '=','users_roles.role_id')
                ->get();
            $user->roles = $data;

            /*
            $details = Business::select('*')
                ->where('user_id', $user_id)->first();
            */

            $details = Business::leftJoin('timezones','timezones.id', '=', 'businesses.timezone_id');
            $details->leftJoin('business_categories','business_categories.id', '=', 'businesses.business_category_id');
            $details->select('businesses.*', 'timezones.zone as timezone_name', 'timezones.gmt as gmt', 'business_categories.title as business_category_name');
            $details = $details->where('businesses.user_id',$user_id)->first();

            if($details){
                $details->preferences_decoded = $details->preferences?json_decode($details->preferences):null;
            }
            $user->details = $details;


            $sysSetting = SysSetting::where('type', SysSetting::TYPE_POLICY)->where('key', SysSetting::POLICY_TERMS_CLIENT)->first();
            $user->terms = $sysSetting?$sysSetting->value:'';

            $user->default_payment = AddonCard::getDefaultCard($user_id);
        }
        return $user;
    }

    public static function getStaffDetails($user_id, $options = [])
    {
        $user = User::select('*')
            ->where('users.id', '=', $user_id)
            ->whereRaw('users.is_deleted IS NOT TRUE')
            ->first();
        if($user){
            $decoded = new \stdClass();
            if($user->photo_src){
                $decoded  = json_decode($user->photo_src);
            }
            $user->photo_src_decoded = $decoded;
            $data = UsersRole::addSelect('roles.title', 'roles.alias', 'users_roles.created_at')
                ->where('users_roles.user_id', $user->id)
                ->leftJoin('roles', 'roles.id', '=','users_roles.role_id')
                ->get();
            $user->roles = $data;

         //$details = Staff::select('*')->where('user_id', $user_id)->first();

            $details = Staff::leftJoin('timezones','timezones.id', '=', 'staffs.timezone_id');
            $details->select('staffs.*', 'timezones.zone as timezone_name', 'timezones.gmt as gmt');
            $details = $details->where('staffs.user_id',$user_id)->first();

            if($details){
                $details->preferences_decoded = $details->preferences?json_decode($details->preferences):null;
            }
            $user->details = $details;


            $sysSetting = SysSetting::where('type', SysSetting::TYPE_POLICY)->where('key', SysSetting::POLICY_TERMS_STAFF)->first();
            $user->terms = $sysSetting?$sysSetting->value:'';
        }
        return $user;
    }
    public static function enableUser($user_id)
    {
        User::where('id', '=', $user_id)
            ->update(['status' => self::STATUS_ACTIVE]);
    }

    public static function deleteUserAvatarFiles($user_id)
    {
        $user = User::find($user_id);
        $src = $user->photo_src;
        if($src){
            $src = json_decode($src, true);
            if(@$src['thumbs_path']){
                Utility::rmdir($src['thumbs_path']);
            }
            if(@$src['file_path']){
                Utility::rmdir($src['file_path']);
            }
        }
    }

    public static function updatePreference($user_id, $type, $pref_arr_new = [])
    {
        $pref_arr_new = json_decode($pref_arr_new, true);
        if($type == Role::TYPE_CLIENT){
           $data = Business::select('preferences')->where('user_id', $user_id)->first();
            $pref_arr_old = [];
           if($data->preferences){
               $pref_arr_old = json_decode($data->preferences, true);
           }

           $new_pref = array_merge($pref_arr_old, $pref_arr_new);

            return Business::where('user_id', '=', $user_id)->update(['preferences' => json_encode($new_pref)]);
        }
    }


    public static function doesAdminExists($email, $options = [])
    {
        $query1 = User::addSelect('users.id')
            ->where('users.email', '=', $email)
            ->where('users.role_id', 1);
        return $query1->first()?true:false;

    }

    public static function getActiveclientList()
    {
        $user = User::leftJoin('users_roles','users.id', '=', 'users_roles.user_id');
        $user->leftJoin('roles','roles.id', '=', 'users_roles.role_id');
        $user->select('users.id',  'users.firstname', 'users.lastname', 'users.email');
        $user->where('users.status', User::STATUS_ACTIVE);
        return  $user->where('roles.alias', Role::TYPE_CLIENT)->get();
    }

}
