<?php

namespace App\Http\Controllers;

use App\Models\ObjSkillsRef;
use App\User;
use Illuminate\Http\Request;
use App\Models\JobCategories;
use App\Http\Controllers\Controller;
use Exception;

class ObjSkillsController extends Controller
{

    /**
     * Display a listing of the job categories.
     *
     * @return Illuminate\View\View
     */
    public function index(Request $req)
    {
        $req_obj = $req->all();
        $data = [];
        if(@$req_obj['obj_table_ref'] && @$req_obj['obj_id']){
            $qry = ObjSkillsRef::select('obj_skills_ref.skill_id', 'skills.title','skills.id')
                ->join('skills', 'skills.id', '=', 'obj_skills_ref.skill_id')
                ->where('obj_table_ref', $req_obj['obj_table_ref'])
                ->where('obj_id',   $req_obj['obj_id']);
            if($req_obj['obj_table_ref'] == 'job_titles'){
                $qry->join('job_titles', 'job_titles.id', '=', 'obj_skills_ref.obj_id');
            }
            $data = $qry->get();
        }


        $return_data['status']=(Boolean)true;
        $return_data['message']="";
        $return_data['data']= $data;
        return $return_data;

        //return ['result'=> 'success', 'data' => $data];

    }

}
