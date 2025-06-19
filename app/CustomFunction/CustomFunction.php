<?php

namespace App\CustomFunction;

use DateTime;
use Illuminate\Support\Facades\Auth;
use File;
use Intervention\Image\ImageManagerStatic as Image;

use App\Models\OfferAccept;
use App\Models\RecruiterCandidate;
use App\Models\User;
use App\Models\ScheduleTime;

Class CustomFunction
{

    public static function random_string($limit)
    {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet .= "0123456789";
        $max = strlen($codeAlphabet); // edited

        for ($i = 0; $i < $limit; $i++) {
            $token .= $codeAlphabet[random_int(0, $max - 1)];
        }

        return $token;
    }

    public static function random_string_capital($limit)
    {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "0123456789";
        $max = strlen($codeAlphabet); // edited

        for ($i = 0; $i < $limit; $i++) {
            $token .= $codeAlphabet[random_int(0, $max - 1)];
        }

        return $token;
    }

    public static function random_number($limit)
    {
        $token = "";
        $codeAlphabet = "0123456789";
        $max = strlen($codeAlphabet); // edited

        for ($i = 0; $i < $limit; $i++) {
            $token .= $codeAlphabet[random_int(0, $max - 1)];
        }

        return $token;
    }

    public static function filter_input($input)
    {
        $input = trim($input);
        $input = htmlentities($input);
        $input = addslashes($input);

        return $input;
    }

    public static function decode_input($input)
    {
        $input = htmlspecialchars_decode($input);
        $input = stripslashes($input);
        return $input;
    }

    public static function get_time_difference($time)
    {

        $output = date('j M, Y h:i a', strtotime($time));
        $now = date('Y-m-d H:i:s');

        $date1 = date_create($now);
        $date2 = date_create($time);
        $diff = date_diff($date1, $date2);

        if ($diff->d == 0) {
            $h = $diff->h;
            $i = $diff->i;
            $s = $diff->s;

            if ($i == 0) {
                $output = "just now";
            } else if ($h == 0) {
                $output = $i . " min ago";
            } else {
                $output = $h . " hr ago";
            }
        }

        return $output;
    }

    public static function validate_input($input, $vtype)
    {
        if ($vtype == "email") {
            if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
                return true;
            }
        }
        if ($vtype == "text_only") {
            if (preg_match("/^[a-zA-Z]*$/", $input)) {
                return true;
            }
        }
        if ($vtype == "text_with_space") {
            if (preg_match("/^[a-zA-Z ]*$/", $input)) {
                return true;
            }
        }
        if ($vtype == "text_with_number") {
            if (preg_match("/^[a-zA-Z0-9]*$/", $input)) {
                return true;
            }
        }
        if ($vtype == "text_with_number_space") {
            if (preg_match("/^[a-zA-Z0-9 ]*$/", $input)) {
                return true;
            }
        }
        if ($vtype == "price") {
            if (preg_match("/^[0-9.]*$/", $input)) {
                return true;
            }
        }
        if ($vtype == "all_text") {
            $text = strpos($input, '`');
            if (empty($text)) {
                return true;
            }
        }
        if ($vtype == "number_only") {
            if (preg_match("/^[0-9]*$/", $input)) {
                return true;
            }
        }
        if ($vtype == "phone_number") {
            if (preg_match("/^[+0-9-]*$/", $input)) {
                return true;
            }
        }
        return false;
    }

    public static function limited_text($text, $limit)
    {
        $text = CustomFunction::decode_input($text);
        $text = strip_tags($text);

        $len = strlen($text);

        if ($len > $limit) {
            $text_final = substr($text, 0, $limit) . '....';
        } else {
            $text_final = $text;
        }

        return $text_final;
    }

    public static function limited_text_no_strip_tags($text, $limit)
    {
        $text = CustomFunction::decode_input($text);

        $len = strlen($text);

        if ($len > $limit) {
            $text_final = substr($text, 0, $limit) . '....';
        } else {
            $text_final = $text;
        }

        return $text_final;
    }

    public static function base_encode_string($str)
    {
        $random = mt_rand(0, 9999999999);
        $newstr = $random . '#' . $str;
        $encode = base64_encode($newstr);
        return $encode;
    }

    public static function base_decode_string($str)
    {
        $decode_str = base64_decode($str);
        $decode_ex = explode('#', $decode_str);
        $decode = $decode_ex[1];
        return $decode;
    }

    public static function generateVideoEmbedUrl($url)
    {
        $finalUrl = '';
        if (strpos($url, 'player.vimeo.com/') !== false) {
            $finalUrl = $url;
        } else if (strpos($url, 'vimeo.com/') !== false) {
            $videoId = explode("vimeo.com/", $url)[1];
            if (strpos($videoId, '&') !== false) {
                $videoId = explode("&", $videoId)[0];
            }
            $finalUrl .= 'https://player.vimeo.com/video/' . $videoId;
        } else if (strpos($url, 'youtube.com/embed') !== false) {
            $finalUrl = $url;
        } else if (strpos($url, 'youtube.com/') !== false) {
            $videoId = explode("v=", $url)[1];
            if (strpos($videoId, '&') !== false) {
                $videoId = explode("&", $videoId)[0];
            }
            $finalUrl .= 'https://www.youtube.com/embed/' . $videoId;
        } else if (strpos($url, 'youtu.be/') !== false) {
            $videoId = explode("youtu.be/", $url)[1];
            if (strpos($videoId, '&') !== false) {
                $videoId = explode("&", $videoId)[0];
            }
            $finalUrl .= 'https://www.youtube.com/embed/' . $videoId;
        } else if (strpos($url, 'wistia.com') !== false) {
            $videoId = explode("wistia.com/medias/", $url)[1];
            if (strpos($videoId, '?wvideo') !== false) {
                $videoId = explode("?wvideo", $videoId)[0];
            }
            $finalUrl .= 'https://fast.wistia.net/embed/iframe/' . $videoId;
        } else {
            $finalUrl = $url;
        }
        return $finalUrl;
    }

    public static function grab_vimeo_thumbnail($vimeo_url)
    {
        $cover_img = "";

        if (!empty($vimeo_url)) {

            $getURL = 'http://vimeo.com/api/oembed.json?url=' . $vimeo_url;
            //$getURL .= '&width=600&height=225';
            $getURL .= '&w=600&h=225';

            $data = json_decode(@file_get_contents($getURL));
            if (!empty($data)) {

                if (isset($data->thumbnail_url) && !empty($data->thumbnail_url)) {

                    $thumbnail_url = $data->thumbnail_url;
                    $cover_img = $data->thumbnail_url;

                    $getExtension_ar = @pathinfo($thumbnail_url);
                    if (isset($getExtension_ar) && !empty($getExtension_ar)) {

                        if (isset($getExtension_ar['dirname']) && !empty($getExtension_ar['dirname'])) {

                            $dirname = $getExtension_ar['dirname'];

                            if (isset($getExtension_ar['extension']) && !empty($getExtension_ar['extension'])) {

                                $extension = $getExtension_ar['extension'];

                                if (isset($getExtension_ar['filename']) && !empty($getExtension_ar['filename'])) {

                                    $filename_ar = explode("_", $getExtension_ar['filename']);

                                    if (isset($filename_ar[0]) && !empty($filename_ar[0])) {

                                        $thumb_ratio = "600x338";
                                        $cover_img = $dirname . "/" . $filename_ar[0] . "_" . $thumb_ratio . "." . $extension;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $cover_img = str_replace("http://", "https://", $cover_img);

        return $cover_img;
    }

    public static function get_youtube_cover_img($url, $type = 'mqdefault')
    {
        $cover_img = "";
        $is_valid_url = 0; // 1 = youtube, 2 = vimeo
        if (strpos($url, 'youtube.com') !== false) {
            $is_valid_url = 1;
        } else if (strpos($url, 'youtu.be') !== false) {
            $is_valid_url = 1;
        } else if (strpos($url, 'vimeo.com') !== false) {
            $is_valid_url = 2;
        }

        if ($is_valid_url == 1) {
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
            $youtube_id = $match[1];

            if ($type == "thumbnail") {
                $cover_img = "https://img.youtube.com/vi/$youtube_id/default.jpg";
            } else if ($type == "mqdefault") {
                $cover_img = "https://img.youtube.com/vi/$youtube_id/mqdefault.jpg";
            }
        }
        if ($is_valid_url == 2) {
            $url_pieces = explode('/', $url);
            $id = end($url_pieces);
            $hash = unserialize(@file_get_contents('http://vimeo.com/api/v2/video/' . $id . '.php'));
            if (!empty($hash)) {
                $cover_img = $hash[0]['thumbnail_large'];
            } else {
                $cover_img = self::grab_vimeo_thumbnail($url);
            }
        }
        return $cover_img;
    }

    public static function string_to_slug($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    public static function partition(Array $list, $p)
    {
        $listlen = count($list);
        $partlen = floor($listlen / $p);
        $partrem = $listlen % $p;
        $partition = array();
        $mark = 0;
        for ($px = 0; $px < $p; $px++) {
            $incr = ($px < $partrem) ? $partlen + 1 : $partlen;
            $partition[$px] = array_slice($list, $mark, $incr);
            $mark += $incr;
        }
        return $partition;
    }

    public static function fileUpload($file, $oldFileName = null, $folderName = null)
    {
        $random_no = self::random_string(10);
        $name = $random_no . '.' . $file->getClientOriginalExtension();
        if ($file->move('uploads' . $folderName, $name)) {
            if ($oldFileName != null) {
                self::removeFile($oldFileName, $folderName);
            }
            return $name;
        }
        return null;
    }

    public static function removeFile($fileName = null, $folderName = null)
    {
        $file ='uploads' . $folderName . '/' . $fileName;
        if (file_exists($file)) {
            unlink($file);
            return true;
        }
        return false;
    }

    public static function old_time_elapsed_string($datetime, $full = false)
    {

        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );

        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full)
            $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    public static function time_elapsed_string($datetime, $full = false)
    {

        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );

        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full)
            $string = array_slice($string, 0, 1);

        if (!empty($string)) {

            $new_string = array();
            if (isset($string['y']) && !empty($string['y'])) {

                $new_string['y'] = $string['y'];

            } else if (isset($string['m']) && !empty($string['m'])) {

                $new_string['m'] = $string['m'];

            } else if (isset($string['w']) && !empty($string['w'])) {

                $new_string['w'] = $string['w'];

            } else if (isset($string['d']) && !empty($string['d'])) {

                $new_string['d'] = $string['d'];

            } else if (isset($string['h']) && !empty($string['h'])) {

                $new_string['h'] = $string['h'];

            } else if (isset($string['i']) && !empty($string['i'])) {

                $new_string['i'] = $string['i'];

            } else if (isset($string['s']) && !empty($string['s'])) {

                $new_string['s'] = $string['s'];
            } else {

                $new_string = array();
            }

            $string = $new_string;
        }

        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    public static function role_name()
    {
        $role_name = '';
        if(Auth::check()){
            $role = Auth::user()->role;
            $role_name = '';
            if($role == 1 ){
                $role_name = 'rats-5768';
            }elseif($role == 2 ){
                $role_name = 'client';
            }elseif($role == 3 ){
                $role_name = 'staff';
            }elseif($role == 4 ){
                $role_name = 'recruiter';
            }elseif($role == 5 ){
                $role_name = 'candidate';
            }
        }

        return $role_name;
    }

    public static function mediaUpload($file, $oldFileName = null, $folderName = null,$folderPath = null,$staffPath = null)
    {
        $random_no = self::random_string(3);
        // $name = $random_no . '.' . $file->getClientOriginalExtension();
        $extension = $file->getClientOriginalExtension();

        $fileName = $file->getClientOriginalName();
        $folder = substr($fileName, 0, strpos($fileName, '.'));
        $string = str_replace(' ', '-', $folder);
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);

        $file_title = $string;

        $name = $string.'-'.$random_no . '.' . $file->getClientOriginalExtension();

        if(File::isDirectory(url('uploads').$folderName)){

        }else{
            File::makeDirectory(url('uploads').$folderName, 0777, true, true);
        }



        $file_arr = array();

        $clientName = $folderName.$folderPath;
        $adminFolder = $folderName.'1';

        if ($file->move('uploads' . $clientName, $name)) {
            if ($oldFileName != null) {
                self::removeFile($oldFileName, $clientName);
            }
            if($extension == "jpg" || $extension == "png" || $extension == "jpeg" || $extension == "gif"){
                $destinationPath = 'uploads' . $clientName.'/';

                $image = Image::make($destinationPath.$name);
                $width = $image->width();
                if($width >= '1920'){
                    $image->resize(1920, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                $image->save($destinationPath.$name, 75);
            }

            // $clientPath = url('uploads').$clientName.'/'.$name;
            // $adminPath = url('uploads').$adminFolder.'/'.$name;
            // if($staffPath){
            //     $adminFolder = $folderName.$staffPath;
            //     $staffPath = url('uploads').$adminFolder.'/'.$name;
            //     File::copy($clientPath,$staffPath);
            // }

            // File::copy($clientPath,$adminPath);

            $file_arr['name'] = $name;
            $file_arr['extension'] = $extension;
            $file_arr['file_title'] = $file_title;

            return $file_arr;
        }
        return null;
    }

    public static function get_time_forment($time)
    {

        $output = date('h:i a', strtotime($time));
        return $output;
    }

    public static function get_time_forment_24($time)
    {

        $output = date('G:i:s', strtotime($time));
        return $output;
    }

    public static function get_date_forment($dete)
    {

        $output = date('d-m-Y', strtotime($dete));
        return $output;
    }

    public static function get_date_time_forment($dete)
    {

        $output = date('d-m-Y h:i a', strtotime($dete));
        return $output;
    }

    public static function remove_html_tags($string, $html_tags)
    {
        $tagStr = "";

        foreach($html_tags as $key => $value){
            $tagStr .= $key == count($html_tags)-1 ? $value : "{$value}|";
        }

        $pat_str= array("/(<\s*\b({$tagStr})\b[^>]*>)/i", "/(<\/\s*\b({$tagStr})\b\s*>)/i");
        $result = preg_replace($pat_str, "", $string);
        $result = preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/si",'<$1$2>', $result);
        return $result;
    }

    public static function scriptStripper($input){
        $output = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $input);
        $output = preg_replace('#<iframe(.*?)>(.*?)</iframe>#is', '', $output);
        return $output;
    }

    public static function cvUpload($file, $oldFileName = null, $folderName = null,$folderPath = null,$staffPath = null)
    {
        $random_no = self::random_string(3);
        // $name = $random_no . '.' . $file->getClientOriginalExtension();
        $extension = $file->getClientOriginalExtension();

        $fileName = $file->getClientOriginalName();
        $folder = substr($fileName, 0, strpos($fileName, '.'));
        $string = str_replace(' ', '-', $folder);
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);

        $name = $string.'-'.$random_no . '.' . $file->getClientOriginalExtension();

        if(File::isDirectory(url('uploads').$folderName)){

        }else{
            File::makeDirectory(url('uploads').$folderName, 0777, true, true);
        }

        $file_arr = array();

        $clientName = $folderName.$folderPath;

        if ($file->move('uploads' . $clientName, $name)) {
            if ($oldFileName != null) {
                self::removeFile($oldFileName, $clientName);
            }
            if($extension == "jpg" || $extension == "png" || $extension == "jpeg" || $extension == "gif"){
                $destinationPath = 'uploads' . $clientName.'/';

                $image = Image::make($destinationPath.$name);
                $width = $image->width();
                if($width >= '1920'){
                    $image->resize(1920, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                $image->save($destinationPath.$name, 75);
            }

            $file_arr['name'] = $name;
            $file_arr['extension'] = $extension;

            return $file_arr;
        }
        return null;
    }

    public static function number_format($input){
        $output = number_format($input, 0, '.', ',');;
        return $output;
    }

    public static function random_color(){
        $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
        $color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
        return $color;
    }

    public static function monthYear(){

        $months_year = array();
        for ($i = 0; $i <= 11; $i++)
        {
            $months[] = date("m", strtotime( date( 'Y-m-01' )." -$i months"));
            $year[] = date("Y", strtotime( date( 'Y-m-01' )." -$i months"));
            $months_year = array_merge($months_year, ["month" => $months]);
            $months_year = array_merge($months_year, ["year" => $year]);
        }
        return $months_year;
    }

    public static function getZipcode($zip){

        $key = env('GOOGLE_KEY');
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($zip)."&key=".$key;
        $result_string = file_get_contents($url);
        $result = json_decode($result_string, true);
        if($result['status'] == 'OK'){
          $result1[]=$result['results'][0];
          $result2[]=$result1[0]['geometry'];
          $result3[]=$result2[0]['location'];
          $result3 = $result3[0];
        }else{
          $result3['lat'] = '';
          $result3['lng'] = '';
        }
        return $result3;
    }

    public static function getZipcodeTest($zip){

        $key = env('GOOGLE_KEY');
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($zip)."&key=".$key;
        $result_string = file_get_contents($url);
        $result = json_decode($result_string, true);
        if($result['status'] == 'OK'){
          $result1[]=$result['results'][0];
          $result2[]=$result1[0]['geometry'];
          $result3[]=$result2[0]['location'];
          $result3 = $result3[0];
        }else{
          $result3['lat'] = '';
          $result3['lng'] = '';
        }
        return $result3;
    }

    public static function getCandidateName($id){

        $offer_accept = OfferAccept::where('vacancy_id','=',$id)->get();

        $user_name = array();
        foreach($offer_accept as $key => $o_value){
            $name = $companyname = null;
            if(isset($o_value->candidate_id) && !empty($o_value->candidate_id)){
                if($o_value->offer_status == '1'){
                    if(isset($o_value->job_reference) && !empty($o_value->job_reference)){
                        $clientData = User::clientData($o_value->r_c_id);
                        $name = RecruiterCandidate::recruiterCandidateName($o_value->candidate_id);
                        $companyname = '-';
                        if(isset($clientData->company_name) && !empty($clientData->company_name)){
                            $companyname = $clientData->company_name;
                        }

                        $user_data = $name.'<span class="label label-lg label-light-info label-inline text-capitalize ml-2" data-toggle="tooltip" data-theme="dark" data-html="true" title="Recruiter Company Name">'.$companyname.'</span>';
                    }else{
                        $user_data = User::getUserName($o_value->candidate_id);
                    }
                }else{
                    $user_data = '--';
                }
                $user_name[] = $user_data;
            }
        }
        return $user_name[0];
        // return $user_name;
    }

    public static function week_between_two_dates($date1, $date2)
    {
        //Create a DateTime object for the first date.
        $firstDate = new DateTime($date1);

        //Create a DateTime object for the second date.
        $secondDate = new DateTime($date2);

        //Get the difference between the two dates in days.
        $differenceInDays = $firstDate->diff($secondDate)->days;

        //Divide the days by 7
        $differenceInWeeks = $differenceInDays / 7;

        //Round down with ceil and return the difference in weeks.
        $weekCount = ceil($differenceInWeeks);

        return $weekCount;
    }

    public static function offerFleUpload($file, $oldFileName = null, $folderName = null,$user_id = null,$job_id = null)
    {
        $random_no = self::random_string(3);

        $fileName = $file->getClientOriginalName();
        $folder = substr($fileName, 0, strpos($fileName, '.'));
        $string = str_replace(' ', '-', $folder);
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);

        $name = $string.'-'.$random_no .'-'.$user_id .'-'.$job_id . '.' . $file->getClientOriginalExtension();

        if ($file->move('uploads' . $folderName, $name)) {
            if ($oldFileName != null) {
                self::removeFile($oldFileName, $folderName);
            }
            return $name;
        }
        return null;
    }

    public static function isDateGet($date)
    {
        $date_ar = array();
        $data_ar = array();

        for($i = 0; $i < 30; $i++)
        {
            $current_date = new DateTime($date);
            if(count($date_ar) < 10)
            {
                $new_date = $current_date->modify('+'.$i.' day');
                $week_day = $new_date->format('w');
                if(($week_day != 6) && ($week_day != 0))
                {
                    $date_ar[] = $new_date->format('Y-m-d');
                }
            }
        }

        $count = count($date_ar);

        $data_ar['start_date'] =  $date_ar[0];
        $data_ar['end_date'] =  $date_ar[$count-1];
        $data_ar['date'] =  $date_ar;

        return $data_ar;

    }

    public static function isTimeGet($interval, $start_time, $end_time,$gap)
    {
        $start = new DateTime($start_time);
        $end = new DateTime($end_time);

        $startTime = $start->format('H:i');
        $endTime = $end->format('H:i');

        $i=0;

        $time = [];

        while(strtotime($startTime) <= strtotime($endTime)){

            $start = $startTime;
            $end = date('H:i',strtotime('+'.$gap.' minutes',strtotime($startTime)));

            $gap_time = $interval + $gap;

            $startTime = date('H:i',strtotime('+'.$gap_time.' minutes',strtotime($startTime)));

            $i++;

            if(strtotime($startTime) <= strtotime($endTime)){
                $time[$i]['full_time'] = $start .' To '.$end;
                $time[$i]['start_time'] = $start;
                $time[$i]['end_time'] = $end;
                $time[$i]['check_start_time'] = str_replace(':', '', $start);
                $time[$i]['check_end_time'] = str_replace(':', '', $end);
            }

        }

        return $time;

    }

    public static function dateTimeMerge($date,$time)
    {
        $data = [];

        foreach($date as $key => $val){
            $data[$val] = $time;
        }

        return $data;
    }

    public static function isGetSystemTimeAndDate($date,$id,$gap)
    {
        $get_date = self::isDateGet($date);
        $start_date = $get_date['start_date'];
        $end_date = $get_date['end_date'];
        $get_full_date = $get_date['date'];

        $start_time = $end_time = null;
        $time_intersect = [];

        $ScheduleTime = [];

        $first_key = array_key_first($id);

        $get_distance = User::find($id[$first_key]);

        // $ScheduleTimeDistance = ScheduleTime::findUserData($get_distance->created_user_id);
        // $distance = $ScheduleTimeDistance->time_distance;
        $distance = 0;

        foreach($id as $uKey => $i_val){
            $ScheduleTime[$uKey] = ScheduleTime::findUserData($i_val);
        }

        for($i = 0; $i < count($ScheduleTime); $i++){
            $schedule_time = @json_decode($ScheduleTime[$i]['schedule_time'],TRUE);
            $time_intersect[] = $schedule_time;
        }

        if(count($time_intersect) == 1){
            $intersect = $time_intersect[0];
        }else{
            $intersect = call_user_func_array('array_intersect',$time_intersect);
        }
        // $intersect = call_user_func_array('array_intersect',$time_intersect);
        $firstKey = array_key_first($intersect);
        $endKey = array_key_last($intersect);

        $start_time = $intersect[$firstKey];

        $end = new DateTime($intersect[$endKey]);
        $endTime = $end->format('H:i');
        $endTime = date('H:i',strtotime('+ 60 minutes',strtotime($endTime)));
        $end_time = $endTime;

        $time = self::isTimeGet($distance,$start_time,$end_time,$gap);

        $full_array = self::dateTimeMerge($get_full_date,$time);

        $data = array();
        $data['start_date'] =  $start_date;
        $data['end_date'] =  $end_date;
        $data['full_array'] =  $full_array;
        $data['date'] =  $get_full_date;

        return $data;
    }

    public static function isDateGetFullMonth($date)
    {
        $date_ar = array();
        $data_ar = array();

        for($i = 0; $i < 30; $i++)
        {
            $current_date = new DateTime($date);
            if(count($date_ar) < 30)
            {
                $new_date = $current_date->modify('+'.$i.' day');
                $week_day = $new_date->format('w');
                if(($week_day != 6) && ($week_day != 0))
                {
                    $date_ar[] = $new_date->format('Y-m-d');
                }
            }
        }

        $count = count($date_ar);

        return $date_ar;

    }

    public static function isFullDate($date)
    {
        $data = date('l jS F Y', strtotime($date));
        return $data;

    }

}
