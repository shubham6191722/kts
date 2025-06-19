<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\CustomFunction\CustomFunction;

use App\Models\BenefitPackage;


class BenefitPackageController extends Controller {

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
    public function index() {
        if(Auth::check()){
            $id = Auth::user()->id;
            if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){
                $u_id = Auth::user()->created_user_id;
            }else{
                $u_id = Auth::user()->id;
            }
            $benefit_package = BenefitPackage::list($u_id);
            return view('admin.benefit_package.index')->with('benefit_package',$benefit_package);
        }else{
            return redirect()->route('home.index');
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
    */
    public function add() {

        if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){
            $u_id = Auth::user()->created_user_id;
        }else{
            $u_id = Auth::user()->id;
        }

        return view('admin.benefit_package.add')->with('u_id',$u_id);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function save(Request $request) {

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'user_id' => 'required',
                ], [
            'title.required' => 'Please enter title!',
            'description.required' => 'Please enter description!',
            'user_id.required' => 'Please try again!',
        ]);

        $title = CustomFunction::filter_input($request->title);
        $description = $request->description;
        $client_id = $request->user_id;

        $new_benefit = new BenefitPackage;
        $new_benefit->title = $title;
        $new_benefit->description = $description;
        $new_benefit->client_id = $client_id;

        if ($new_benefit->save()) {

            $route_name = 'client.benefitPackageList';

            return redirect()->route($route_name)->with('success', 'Benefits Workflows added successfully.');

        }else {
            return back()->with('error', 'Please try again!');
        }

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit($id) {
        if(Auth::check()){
            $data = BenefitPackage::find($id);
            return view('admin.benefit_package.edit')->with('data',$data);
        }else{
            return redirect()->route('home.index');
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function update(Request $request) {

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'id' => 'required',
                ], [
            'title.required' => 'Please enter title!',
            'description.required' => 'Please enter description!',
            'id.required' => 'Please try again!',
        ]);

        $id = $request->id;
        $title = CustomFunction::filter_input($request->title);
        $description = $request->description;

        $new_benefit = BenefitPackage::find($id);
        $new_benefit->title = $title;
        $new_benefit->description = $description;

        if ($new_benefit->save()) {

            $route_name = 'client.benefitPackageList';

            return redirect()->route($route_name)->with('success', 'Benefits Workflows updated successfully.');

        }else {
            return back()->with('error', 'Please try again!');
        }
        
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function delete(Request $request) {
        $request->validate([
            'id' => 'required',
                ], [
            'id.required' => 'Please try again!',
        ]);

        $benefit = BenefitPackage::find($request->id);
        $benefit->deleted_at = date('Y-m-d H:i:s');

        if ($benefit->save()) {
            return back()->with('success', 'Benefits Workflows delete successfully.');
        } else {
            return back()->with('error', 'Please try again!');
        }
        
    }

    public function benefitPackageDataGet(Request $request) {

        $id = $request->package_id;
        $data = BenefitPackage::find($id);
        $message = $data->description;
        return response()->json(['text' => $message,'code' => 1]);
    }

}
