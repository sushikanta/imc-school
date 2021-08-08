<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SysSetting extends Model
{

    const TYPE_CONFIG = 'config';
    const TYPE_POLICY = 'policy';
    const POLICY_TERMS_STAFF = 'terms_staff';
    const POLICY_TERMS_CLIENT = 'terms_client';
    const POLICY_PRIVACY = 'privacy';

    const CTRL_TYPE_STRING = 'string';
    const CTRL_TYPE_MINUTE = 'minute';
    const CTRL_TYPE_HOUR = 'hour';
    const CTRL_TYPE_DAY = 'day';
    const CTRL_TYPE_MONTH = 'month';
    const CTRL_TYPE_YEAR = 'year';
    const CTRL_TYPE_AMOUNT = 'amount';
    const CTRL_TYPE_number = 'number';

    const KEY_MIN_HOURLY_JOB_RATE  = "MIN_HOURLY_JOB_RATE";

    const CTRL_TYPES = [
        Self::CTRL_TYPE_AMOUNT => 'Amount',
        Self::CTRL_TYPE_number => 'Number',
        Self::CTRL_TYPE_STRING => 'String',
        Self::CTRL_TYPE_MINUTE => 'Minutes',
        Self::CTRL_TYPE_HOUR => 'Hours',
        Self::CTRL_TYPE_DAY => 'Days',
        Self::CTRL_TYPE_MONTH => 'Months',
        Self::CTRL_TYPE_YEAR => 'Years',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sys_settings';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'type',
                  'key',
                  'value',
                  'description',
                  'ctrl_type',
                  'published'
              ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];


    public static function getSettingsByKey($key, $inner_key = null)
    {
        $record = SysSetting::where('key', $key)->first();
        $result = null;
        if($record && $record->value){
            $result = json_decode($record->value, true);
            if($inner_key){
                return  @$result[$inner_key]?$result[$inner_key]: null;
            }
        }
        return $result;
    }

    public static function getHourlyJobRate()
    {
       $setting =  self::getSettingsByKey('job', self::KEY_MIN_HOURLY_JOB_RATE);
       return $setting?$setting['value']:100;
    }

    public static function storeSettingByKey($key, $inner_key, $data) {
        $record = SysSetting::where('key', $key)->first();
        $result = [];
        if($record && $record->value){
            $result = json_decode($record->value, true);
            if(isset($data['edit_key'])){
               unset($result[$data['edit_key']]);
            }
            $result[$inner_key] = $data;
            $record->update(['value' => json_encode($result)]);
        }else{
            $obj = new SysSetting();
            $obj->key  = $key;
            $obj->value  = json_encode([$inner_key => $data]);
            $obj->save();

        }


    }

    public static function deleteSettingByKey($key, $inner_key) {
        $record = SysSetting::where('key', $key)->first();
        if($record && $record->value){
            $result = json_decode($record->value, true);
            unset($result[$inner_key]);
            $record->update(['value' => json_encode($result)]);
        }


    }


}
