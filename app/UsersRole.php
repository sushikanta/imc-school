<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersRole extends Model
{
    protected $fillable = ['user_id', 'role_id', 'context_id', 'created_at'];
    public $timestamps = false;
    public $relation_ids = [];

    public static function storeStaff(){
        $staff_id = Role::get_role_id('staff');
    }



}

