<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Rules\ValidateAdminExist;
use App\Rules\ValidateEmailExist;
use App\User;
use Redirect;
use Schema;
use Illuminate\Http\Request;



class AdminController extends Controller {

	/**
	 * Display a listing of tmpcountries
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {

	}

	/**
	 * Show the form for creating a new tmpcountries
	 *
     * @return \Illuminate\View\View
	 */
    public function showLogin()
    {
        return view('admin.login');
    }

    public function showDashboard()
    {
        Post::all();
        $categoryCount = Category::count();
        $postCount = Post::count();
        return view('admin.dashboard', compact('categoryCount', 'postCount'));
       // return view('layouts.app');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', new ValidateAdminExist()],
            'password' => 'required',
        ]);

        $user = User::where('email', $request->get('email'))->first();
        $passwordChecked = \Hash::check($request->get('password'), $user->password);
        if(!$passwordChecked){
            return redirect()->back()->withInput()->withErrors(['password' => "Invalid login credential."]);
        }

        $auth = \Auth::loginUsingId($user->id, $request->get('remember_me'));
        return redirect('admin/dashboard');

    }

    public function logout(){
       \Auth::logout();
        return redirect('admin/login');
    }

    public function showResetPassword()
    {
        $user = \Auth::user();
        return view('admin.reset_password', compact('user'));
    }

    public function resetPassword(Request $request)
    {

        $user = User::findOrFail($request->user_id);

        $request->validate([
            'password' => 'nullable|required_with:password_confirmation|string|confirmed',
        ]);

        $user->password =  \Hash::make($request->password);
        $user->save();
        return redirect()->route('admin.resetpassword')->with('message', 'Password updated successfully');


    }

}
