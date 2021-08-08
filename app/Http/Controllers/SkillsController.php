<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Skill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class SkillsController extends Controller
{

    /**
     * Display a listing of the skills.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $skills = Skill::with('context')->where('is_deleted',false)->get();

        return view('skills.index', compact('skills'));
    }

    /**
     * Show the form for creating a new skill.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        //$contexts = User::pluck('id','id')->all();
        
        return view('skills.create');
    }

    /**
     * Store a new skill in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            
            $data = $this->getData($request);
            $data['updated_at']=date("Y-m-d H:i:s");
			$data['created_at']=date("Y-m-d H:i:s");
            Skill::create($data);

            return redirect()->route('skills.skill.index')
                             ->with('success_message', 'Skill was successfully added!');

        } catch (Exception $exception) {
            $error_messages = ['unexpected_error' => 'Unexpected error occurred while trying to process your request!'];
             if(@$exception->validator){
                    $error_messages = $exception->validator;
              }
            return back()->withInput()
                         ->withErrors($error_messages);
        }
    }

    /**
     * Display the specified skill.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $skill = Skill::with('context')->findOrFail($id);

        return view('skills.show', compact('skill'));
    }

    /**
     * Show the form for editing the specified skill.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $skill = Skill::findOrFail($id);
       // $contexts = User::pluck('id','id')->all();

        return view('skills.edit', compact('skill'));
    }

    /**
     * Update the specified skill in the storage.
     *
     * @param  int $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            $skill = Skill::findOrFail($id);
			$data['updated_at']=date("Y-m-d H:i:s");
            $skill->update($data);

            return redirect()->route('skills.skill.index')
                             ->with('success_message', 'Skill was successfully updated!');

        } catch (Exception $exception) {
            $error_messages = ['unexpected_error' => 'Unexpected error occurred while trying to process your request!'];
             if($exception->validator){
                    $error_messages = $exception->validator;
              }
            return back()->withInput()
                         ->withErrors($error_messages);
        }        
    }

    /**
     * Remove the specified skill from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $skill = Skill::findOrFail($id);
			$data['is_deleted']=true;
			$data['updated_at']=date("Y-m-d H:i:s");
			$skill->update($data);
            //$skill->delete();

            return redirect()->route('skills.skill.index')
                             ->with('success_message', 'Skill was successfully deleted!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    
    /**
     * Get the request's data from the request.
     *
     * @param Illuminate\Http\Request\Request $request 
     * @return array
     */
    protected function getData(Request $request)
    {
        $rules = [
            'title' => 'string|min:1|max:255|nullable',
            'published' => 'boolean|nullable',
            'context_id' => 'nullable',
     
        ];
        
        $data = $request->validate($rules);


        return $data;
    }

}
