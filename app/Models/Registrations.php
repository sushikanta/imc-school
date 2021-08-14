<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registrations extends Model
{
    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'registrations';

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
                  'email',
                  'full_name',
                  'dob',
                  'gender',
                  'category',
                  'aadhar',
                  'contact_no',
                  'whatsapp_no',
                  'last_school',
                  'hslc_result',
                  'father_name',
                  'father_occupation',
                  'mother_name',
                  'mother_occupation',
                  'present_address',
                  'permanent_address',
                  'village_town',
                  'district',
                  'state',
                  'pin',
                  'file_photo_path',
                  'file_hslc_admitcard_path',
                  'file_hslc_marksheet_path',
                  'file_aadhaar_path',
                  'stream',
                  'selected_subject'
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
    


    /**
     * Get created_at in array format
     *
     * @param  string  $value
     * @return array
     */
    public function getCreatedAtAttribute($value)
    {
        return \DateTime::createFromFormat('j/n/Y g:i A', $value);

    }

    /**
     * Get updated_at in array format
     *
     * @param  string  $value
     * @return array
     */
    public function getUpdatedAtAttribute($value)
    {
        return \DateTime::createFromFormat('j/n/Y g:i A', $value);

    }

}
