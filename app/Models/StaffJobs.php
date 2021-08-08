<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 09-01-2019
 * Time: 17:40
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class StaffJobs extends Model
{

    protected $table = 'staff_jobs';

    protected $fillable = [
        'staff_user_id','job_title_id'
    ];
}