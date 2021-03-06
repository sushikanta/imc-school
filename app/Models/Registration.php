<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class Registration extends Model
{
    public $timestamps = true;
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


    public static function getValidatedData($request)
    {
        $id = $request->id;
        $rules = [
            'email' => ['required'],
            'full_name' => ['required'],
            'dob' => ['required'],
            'gender' => ['required'],
            'category' => 'nullable',
            'aadhar' => ['required'],
            'contact_no' => 'string|min:10|max:15',
            'whatsapp_no' => 'string|min:10|max:15',
            'hslc_result' => 'required|min:1',
            'last_school' => 'required|min:1',

            'father_name' => ['required'],
            'father_occupation' =>['required'],
            'mother_name' => ['required'],
            'mother_occupation' => ['required'],
            'present_address' => ['required'],
            'permanent_address' => ['required'],
            'village_town' => ['required'],
            'district' => ['required'],
            'state' =>['required'],
            'pin' =>['required'],
            'file_photo_path' =>['required'],
            'file_hslc_admitcard_path' =>['required'],
            'file_hslc_marksheet_path' =>['required'],
            'file_aadhaar_path' =>['required'],
            'stream' => 'nullable',
            'selected_subject' => 'nullable'

        ];
        $messages = [
            'file_photo_path.required' => 'Please select a photo.',
            'file_aadhaar_path.required' => 'Please select Aadhar file.',
            'file_hslc_admitcard_path.required' => 'Please select HSLC admit card.',
            'file_hslc_marksheet_path.required' => 'Please select HSLC mark sheet.'
        ];
        $data = $request->validate($rules, $messages);
        if ($request->has('custom_delete_img_src')) {
            $data['img_src'] = null;
        }
        if ($request->hasFile('img_src')) {
            // $img_json_data = $this->savePostedFiles(['type' => 'post', 'control_name'=> 'img_src']);
            //  $data['img_src'] = $this->moveFile($request->file('img_src'));
            // $data['img_src'] = json_encode($img_json_data);
        }


        return $data;
    }


}
