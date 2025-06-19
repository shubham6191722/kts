<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\CustomFunction\CustomFunction;
use Config;
use Illuminate\Support\Facades\Response;

use App\Models\User;
use App\Models\SiteSetting;
use App\Models\Media;

class MediaController extends Controller {

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
                $id = Auth::user()->created_user_id;
            }else{
                $id = Auth::user()->id;
            }

            if(Auth::user()->role == 3){
                $id = Auth::user()->id;
            }
            $media_data = Media::getData($id);
            return view('admin.media.index')->with('id',$id)->with('media_data',$media_data);
        }else{
            return redirect()->route('home.index');
        }

    }

    public function create(Request $request) {

        if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){
            $user_id = Auth::user()->created_user_id;
        }else{
            $user_id = Auth::user()->id;
        }
        $folderName = '/job_vacancy/';
        $folderPath = $request->user_select;
        $folderPath = '';
        $file_title = $request->file_title;

        $staffPath = null;
        if(Auth::user()->role == 3){
            $folderPath = Auth::user()->id;
            $staffPath = Auth::user()->created_user_id;
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = CustomFunction::mediaUpload($file, null, $folderName,$folderPath,$staffPath);
            $cover_image = $fileName;
        }
        $file_name = $cover_image['name'];
        $file_type = $cover_image['extension'];

        $media = new Media;
        $media->user_id = $user_id;
        $media->file_name = $file_name;
        $media->file_type = $file_type;
        $media->file_title = $file_title;
        if ($media->save()) {
            return back()->with('success', 'Media successfully Add.');
        } else {
            return back()->with('error', 'Please try again!');
        }

    }

    public function update(Request $request) {

        $file_title = $request->file_title;
        $id = $request->id;

        $media = Media::find($id);
        $media->file_title = $file_title;

        if ($media->save()) {
            return back()->with('success', 'Media successfully Updated.');
        } else {
            return back()->with('error', 'Please try again!');
        }

    }

    public function download($id=null) {

        if(isset($id) && !empty($id)){

            $result = Media::find($id);
            $file_name = $result->file_name;
            $user_id = $result->user_id;
            $file_path = 'uploads/job_vacancy/';
            $file_full_path = $file_path.$file_name;

            $headers = array(
                'Content-Type' => 'application/msword',
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
                'Content-Type' => 'application/vnd.ms-word.document.macroEnabled.12',
                'Content-Type' => 'application/vnd.ms-word.template.macroEnabled.12',
            );

            return Response::download($file_full_path, $file_name, $headers);

        }else{
            return redirect('/');
        }

    }

    public function delete(Request $request) {

        $request->validate([
            'id' => 'required',
                ], [
            'id.required' => 'Please try again!',
        ]);

        $media = Media::find($request->id);

        $user = User::find($media->user_id);

        $oldFileName = $media->file_name;
        $folderName = '/job_vacancy';

        CustomFunction::removeFile($oldFileName, $folderName);

        if ($media->delete()) {
            return back()->with('success', 'Media successfully delete.');
        } else {
            return back()->with('error', 'Please try again!');
        }
    }

}
