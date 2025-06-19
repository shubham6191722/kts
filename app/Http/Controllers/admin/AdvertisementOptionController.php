<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\CustomFunction\CustomFunction;
use Illuminate\Http\Request;
use App\Models\AdvertisementOption;

use Illuminate\Support\Facades\Auth;
use Hash;
use Mail;
use Session;

class AdvertisementOptionController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){

        if(Auth::check()){
            $id = Auth::user()->id;
            if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){
                $u_id = Auth::user()->created_user_id;
            }else{
                $u_id = Auth::user()->id;
            }
            $optionList = AdvertisementOption::list($u_id);
            return view('admin.advertisement_option.index')->with('optionList',$optionList)->with('u_id',$u_id);
        }else{
            return redirect()->route('home.index');
        }
       
        
    }

    public function create(Request $request) {

        if(Auth::check()){

            $request->validate([
                'option_name' => 'required',
                    ], [
                'option_name.required' => 'Please enter Option Name!',
            ]);
    
            $option_data = new AdvertisementOption;
            $option_data->option_name = $request->option_name;
            $option_data->client_id = $request->client_id;
            $option_data->created_at = date('Y-m-d H:i:s');
            
            if ($option_data->save()) {
                return back()->with('success', 'Opption successfully add.');
            } else {
                return back()->with('error', 'Please try again!');
            }
        }else{
            return redirect()->route('home.index');
        }
        
    }

    public function update(Request $request) {

        $request->validate([
            'option_name' => 'required',
                ], [
            'option_name.required' => 'Please enter Option Name!',
        ]);

        $option_data = AdvertisementOption::find($request->id);;
        $option_data->option_name = $request->option_name;
        $option_data->updated_at = date('Y-m-d H:i:s');

        if ($option_data->save()) {

            return back()->with('success', 'Opption successfully update.');
            
        } else {
            return back()->with('error', 'Please try again!');
        }
    }
    
    public function delete(Request $request) {

        $request->validate([
            'id' => 'required',
                ], [
            'id.required' => 'Please try again!',
        ]);

        $option_data = AdvertisementOption::find($request->id);

        if ($option_data->delete()) {
            return back()->with('success', 'Option successfully delete.');
        } else {
            return back()->with('error', 'Please try again!');
        }
    }

}