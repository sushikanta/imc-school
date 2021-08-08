<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailToken extends Model
{
    //
    protected $fillable = ['user_id', 'code', 'type', 'valid_upto', 'params', 'is_clicked', 'auth_required', 'next_url'];
    public $timestamps = false;

    const TYPE_MAIL_CONTACTUS = 'contactus_email';
    const TYPE_MAIL_CONFIRMATION = 'email_confirmation';
    const TYPE_FORGOT_PASSWORD = 'forgot_password';
    const TYPE_RESET = 'reset';

    public static function getMailToken($user_id, $type, $options = array()){

        $default_valid_upto = date('Y-m-d H:i:s', time() + 24 * 60 * 60 * 3); // default 3 days validity
        $obj = new MailToken();
        $obj->user_id = $user_id;
        $obj->code =  md5(microtime(date('Y-m-d H:i:s')) . $user_id);
        $obj->type = $type;
        $obj->valid_upto = @$options['valid_upto']?$options['valid_upto']:$default_valid_upto;
        $obj->params = json_encode($options);
        $obj->auth_required = @$options['auth_required']?true:false;
        $obj->next_url = @$options['next_url'];
        $obj->save();

        return $obj->code;
    }
}
