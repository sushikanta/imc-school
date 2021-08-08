<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Redirect;
use Schema;
use App\Tmpcountries;
use App\Http\Requests\CreateTmpcountriesRequest;
use App\Http\Requests\UpdateTmpcountriesRequest;
use Illuminate\Http\Request;



class CountriesController extends Controller {

	/**
	 * Display a listing of tmpcountries
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $countriesObjects = Country::all();
       // print_r($countries);
        // dd($countries);
		return view('admin.country.index', compact('countriesObjects'));
	}

	/**
	 * Show the form for creating a new tmpcountries
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    
	    
	    return view('admin.tmpcountries.create');
	}

	/**
	 * Store a newly created tmpcountries in storage.
	 *
     * @param CreateTmpcountriesRequest|Request $request
	 */
	public function store(CreateTmpcountriesRequest $request)
	{
	    
		Tmpcountries::create($request->all());

		return redirect()->route(config('quickadmin.route').'.tmpcountries.index');
	}

	/**
	 * Show the form for editing the specified tmpcountries.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$tmpcountries = Tmpcountries::find($id);
	    
	    
		return view('admin.tmpcountries.edit', compact('tmpcountries'));
	}

	/**
	 * Update the specified tmpcountries in storage.
     * @param UpdateTmpcountriesRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateTmpcountriesRequest $request)
	{
		$tmpcountries = Tmpcountries::findOrFail($id);

        

		$tmpcountries->update($request->all());

		return redirect()->route(config('quickadmin.route').'.tmpcountries.index');
	}

	/**
	 * Remove the specified tmpcountries from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		Tmpcountries::destroy($id);

		return redirect()->route(config('quickadmin.route').'.tmpcountries.index');
	}

    /**
     * Mass delete function from index page
     * @param Request $request
     *
     * @return mixed
     */
    public function massDelete(Request $request)
    {
        if ($request->get('toDelete') != 'mass') {
            $toDelete = json_decode($request->get('toDelete'));
            Tmpcountries::destroy($toDelete);
        } else {
            Tmpcountries::whereNotNull('id')->delete();
        }

        return redirect()->route(config('quickadmin.route').'.tmpcountries.index');
    }

}
