<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\CustomFunction\CustomFunction;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\SiteAddress;

class SiteAddressController extends Controller {

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
            if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){
                $id = Auth::user()->created_user_id;
            }else{
                $id = Auth::user()->id;
            }
            $site_address_data = SiteAddress::clientAddressGet($id);
            return view('admin.site_address.index')->with('site_address_data',$site_address_data)->with('id',$id);
        }else{
            return redirect()->route('home.index');
        }
    }

    public function create(Request $request){

        if(Auth::check()){

            $request->validate([
                'client_id' => 'required',
                'site_title' => 'required',
                'site_address' => 'required',
                    ], [
                'client_id.required' => 'Please try again!',
                'site_title.required' => 'Please enter site title!',
                'site_address.required' => 'Please enter site address!',
            ]);
            

            $str     = $request->site_address;
    
            $site_address = new SiteAddress;
            $site_address->site_title = $request->site_title;
            $site_address->client_id = $request->client_id;
            $site_address->site_address = $str;

            if ($site_address->save()) {

                return back()->with('success', 'Site Address successfully add.');

            } else {
                return back()->with('error', 'Please try again!');
            }
        }else{
            return redirect()->route('home.index');
        }
    }

    public function update(Request $request) {

        $request->validate([
            'id' => 'required',
            'site_title' => 'required',
            'site_address' => 'required',
                ], [
            'id.required' => 'Please try again!',
            'site_title.required' => 'Please enter site title!',
            'site_address.required' => 'Please enter site address!',
        ]);

        $str     = $request->site_address;

        $site_address = SiteAddress::find($request->id);

        $site_address->site_title = $request->site_title;
        $site_address->site_address = $str;
        $site_address->updated_at = date('Y-m-d H:i:s');
        if ($site_address->save()) {

            return back()->with('success', 'Site Address successfully updated.');

        } else {
            return back()->with('error', 'Please try again!');
        }
    }

}
