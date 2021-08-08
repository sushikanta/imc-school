<?php

namespace App\Http\Controllers;

use App\Models\Countries;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class CountriesController extends Controller
{

    /**
     * Display a listing of the countries.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $countriesObjects = Countries::where('is_deleted',false)->get();

        return view('countries.index', compact('countriesObjects'));
    }

    /**
     * Show the form for creating a new countries.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        
        
        return view('countries.create');
    }

    /**
     * Store a new countries in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            
            $data = $this->getData($request);
			
			//print_r( $data); die;
			
            
            Countries::create($data);

            return redirect('admin/countries')->with('success_message', 'Countries has been added successfully !');

        } catch (Exception $exception) {
			
			//print_r($exception); 
			
            $error_messages = ['unexpected_error' => 'Unexpected error occurred while trying to process your request!'];
             if(@$exception->validator){
                    $error_messages = $exception->validator;
              }
            return back()->withInput()
                         ->withErrors($error_messages);
        }
    }

    /**
     * Display the specified countries.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $countries = Countries::findOrFail($id);

        return view('countries.show', compact('countries'));
    }

    /**
     * Show the form for editing the specified countries.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $countries = Countries::findOrFail($id);
        

        return view('countries.edit', compact('countries'));
    }

    /**
     * Update the specified countries in the storage.
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
            
            $countries = Countries::findOrFail($id);
            $countries->update($data);

            return redirect()->route('countries.countries.index')
                             ->with('success_message', 'Countries was successfully updated!');

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
     * Remove the specified countries from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $countries = Countries::findOrFail($id);
			
			$data['is_deleted']=true;
			//$data['updated_at']=date("Y-m-d H:i:s");
			$countries->update($data);
			
			
            //$countries->delete();

            return redirect()->route('countries.countries.index')
                             ->with('success_message', 'Countries was successfully deleted!');

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
            'code' => 'string|min:1|nullable',
            'published' => 'string|min:1|nullable|boolean',
            'sort' => 'string|min:1|nullable',
     
        ];

        
        $data = $request->validate($rules);




        return $data;
    }

}
