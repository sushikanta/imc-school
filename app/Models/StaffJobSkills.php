<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 09-01-2019
 * Time: 15:42
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class StaffJobSkills extends Model
{

    protected $table = 'staff_job_skills';


    protected $fillable = [
      'skill_id','staff_job_id'
    ];

}