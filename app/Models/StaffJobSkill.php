<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffJobSkill extends Model
{
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'staff_job_skills';

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
                  'staff_job_id',
                  'skill_id',
                  'staff_user_id',
                  'job_title_id'
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
     * Get the jobCategory for this model.
     */
  
  // need to test with the function
	public static function staffJobSkill($staff_job_id)
    {
		 $staff_job_skill = StaffJobSkill::join('skills','staff_job_skills.skill_id', '=', 'skills.id'); 
		 $staff_job_skill= $staff_job_skill->select('skills.*' );
		 $staff_job_skill= $staff_job_skill->where('staff_job_skills.staff_job_id', $staff_job_id)->get();
		 
		 $staff_job_skill = array();
		  if($staff_job_skill)
		 {
			$staff_job_skill =  $staff_job_skill->toArray();
		 }
		 
		 return $staff_job_skill;
		 
    }
	
	public static function staffJobSkillNameArr($staff_job_id)
    {
		 $staff_job_skill = StaffJobSkill::join('skills','staff_job_skills.skill_id', '=', 'skills.id'); 
		 $staff_job_skill= $staff_job_skill->select('skills.*' );
		 $staff_job_skill= $staff_job_skill->where('staff_job_skills.staff_job_id', $staff_job_id)->get();
		 
		  $staff_skill = array();
		  if($staff_job_skill)
		 {
			$staff_skill_data =  $staff_job_skill->toArray();
			
			foreach($staff_skill_data as $skill)
			{
				$staff_skill[] =$skill['title'];
			}
		 }
		 
		 return $staff_skill;
		 
    }


}
