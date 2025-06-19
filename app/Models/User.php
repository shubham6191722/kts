<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\SiteSetting;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'lname',
        'email',
        'c_code',
        'phone',
        'town',
        'company_name',
        'job_title',
        'users_needed',
        'role',
        'email_verified_at',
        'email_confirm',
        'email_key',
        'status',
        'company_logo',
        'cover_image',
        'company_credits',
        'password',
        'remember_token',
        'department',
        'recruitment_specialism',
        'client_slug',
        'talent_pool_status',

        'sub_model',
        'sub_created',
        'sub_expires',
        'sub_cost',
        'sub_payment_terms',
        'credits_allotted',
        'credits_expire',
        'deleted_at',
        'check_status',
        'event_time_slot_select',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public static function getAll() {
        return self::where('role', "!=", 1)->orderBy('name', 'desc')->get();
    }


    public static function candidateList() {
        $user_data = self::select('users.*','users.id as main_id','user_detail.*')
                        ->leftJoin('user_detail', function($join) {
                            $join->on('users.id', '=', 'user_detail.user_id');
                        })
                        ->where('users.role','=',5)
                        ->where('users.deleted_at', "=", null)
                        ->orderBy('users.id',  "desc")
                        ->get();
        return $user_data;
    }

    public static function candidateListData($id) {
        $user_data = self::select('users.*','users.id as main_id','user_detail.*')
                        ->leftJoin('user_detail', function($join) {
                            $join->on('users.id', '=', 'user_detail.user_id');
                        })
                        ->where('users.role','=',5)
                        ->where('users.deleted_at', "=", null)
                        ->where('users.id', "=", $id)
                        ->first();
        return $user_data;
    }

    public static function clientList() {
        return self::where('role', "=", 2)->where('created_user_id', "=", null)->where('deleted_at', "=", null)->orderBy('id', 'desc')->get();
    }

    public static function clientListForClient($id) {
        return self::where('role', "=", 2)->where('created_user_id', "=", $id)->where('deleted_at', "=", null)->orderBy('id', 'desc')->get();
    }

    public static function clientJobVacancy() {
        return self::where('role', "=", 2)->where('created_user_id', "=", null)->where('email_confirm','=',1)->where('deleted_at', "=", null)->orderBy('id', 'desc')->get();
    }

    public static function clientName($id) {
        $user_name = self::where('id', "=", $id)->first();
        $full_name = null;
        $name = null;
        $lname = null;
        if(isset($user_name->name) && !empty($user_name->name)){
            $name = $user_name->name;
        }
        if(isset($user_name->lname) && !empty($user_name->lname)){
            $lname = $user_name->lname;
        }
        if(isset($name) && !empty($name)){
            $full_name = $name;
        }
        if((isset($lname) && !empty($lname)) && (isset($name) && !empty($name))){
            $full_name = $name.' '.$lname;
        }
        return $full_name;
    }

    public static function clientCompany($id) {
        $user_name = self::where('id', "=", $id)->first();
        $company_name = null;
        if(isset($user_name->company_name) && !empty($user_name->company_name)){
            $company_name = $user_name->company_name;
        }
        return $company_name;
    }

    public static function clientData($id) {
        $user_name = self::where('id', "=", $id)->first();
        return $user_name;
    }

    public static function clientDataData($id) {
        $user_name = self::where('id', "=", $id)->get();
        return $user_name;
    }

    public static function staffList($id) {
        $user_name = self::where('created_user_id', "=", $id)->where('role', "=", 3)->where('deleted_at', "=", null)->orderBy('id', 'desc')->get();
        return $user_name;
    }

    public static function clientListMessage($id) {
        $query  = self::select('users.id', 'users.name','message_count.id as message_id');

        $query->leftJoin('message_count', function($join) {
            $join->on('users.id', '=', 'message_count.candidate_id');
        });

        $query->where('users.created_user_id','=',null);
        $query->where('users.role','=',2);
        $query->where('users.deleted_at', "=", null);
        $query->orderBy('users.updated_at', 'desc');

        $result = $query->get();

        return $result;

        $user_name = self::where('created_user_id', "=", $id)->where('role', "=", 3)->where('deleted_at', "=", null)->get();
        return $user_name;
    }

    public static function staffListMessage($id) {
        // $query  = self::select('users.id', 'users.name','message_count.id as message_id','message_count.client_id as message_client_id','message_count.candidate_id as message_candidate_id');
        $query  = self::select('users.id', 'users.name');

        // $query->leftJoin('message_count', function($join) {
        //     $join->on('users.id', '=', 'message_count.staff_id');
        // });

        $query->where('users.created_user_id','=',$id);
        $query->where('users.role','=',3);
        $query->where('users.deleted_at', "=", null);
        $query->orderBy('users.updated_at', 'desc');

        $result = $query->get();

        return $result;

        $user_name = self::where('created_user_id', "=", $id)->where('role', "=", 3)->where('deleted_at', "=", null)->get();
        return $user_name;
    }

    public static function recruiterList($id) {
        $user_name = self::where('created_user_id', "=", $id)->where('role', "=", 4)->where('deleted_at', "=", null)->orderBy('id', 'desc')->get();
        return $user_name;
    }

    public static function recruiterListAll() {
        $user_name = self::where('role', "=", 4)->where('deleted_at', "=", null)->orderBy('id', 'desc')->get();
        return $user_name;
    }

    public static function candidateData() {
        $candidate = self::where('role', "=", 5)->where('talent_pool_status', "=", "1")->orderBy('id', 'desc')->paginate(9);
        return $candidate;
    }

    public static function candidateDataGet($id) {
        $candidate = self::where('client_slug', "=", $id)->first();
        return $candidate;
    }

    public static function getEmail($id) {
        if($id == 1){
            $email = SiteSetting::getSiteEmail();
        }else{
            $user_name = self::where('id', "=", $id)->first();
            $email = null;
            if(isset($user_name->email) && !empty($user_name->email)){
                $email = $user_name->email;
            }
        }
        return $email;
    }

    public static function getUserName($id) {
        $user_name = self::where('id', "=", $id)->first();
        $full_name = null;
        $name = null;
        $lname = null;
        if(isset($user_name->name) && !empty($user_name->name)){
            $name = $user_name->name;
        }
        if(isset($user_name->lname) && !empty($user_name->lname)){
            $lname = $user_name->lname;
        }
        if(isset($name) && !empty($name)){
            $full_name = $name;
        }
        if((isset($lname) && !empty($lname)) && (isset($name) && !empty($name))){
            $full_name = $name.' '.$lname;
        }
        return $full_name;
    }

    public static function getTown($id) {
        $user_name = self::where('id', "=", $id)->first();
        $town = null;
        if(isset($user_name->town) && !empty($user_name->town)){
            $town = $user_name->town;
        }
        return $town;
    }

    public static function getCandidateFull() {
        $user_data = self::select('users.*','user_detail.*')
                        ->leftJoin('user_detail', function($join) {
                            $join->on('users.id', '=', 'user_detail.user_id');
                        })
                        ->where('users.status','=',1)
                        ->where('users.role','=',5)
                        ->where('users.deleted_at', "=", null)
                        ->get();
        return $user_data;
    }

    public static function getRole($id) {
        $user_data = self::where('id','=',$id)
                        ->where('status','=',1)
                        ->first();
        if($user_data->role == 1){
            $role = 'Admin';
        }elseif($user_data->role == 2){
            $role = 'Client';
        }elseif($user_data->role == 3){
            $role = 'Staff';
        }else{
            $role = '';
        }
        return $role;
    }

    public static function staffIdGet($id) {
        $user_data = self::where('created_user_id','=',$id)
                         ->where('role','=',3)
                         ->where('status','=',1)
                         ->get();
        $staff_id = null;
        if(isset($user_data) && !empty($user_data)){
          foreach($user_data as $key => $value){
              $staff_id[] = $value->id;
          }
        }
        return $staff_id;
    }

    public static function checkUserActiveDeactive($id) {
        $user_data = self::where('id','=',$id)->first();

        if(isset($user_data->deleted_at) && !empty($user_data->deleted_at)){
            $check = false;
        }else{
            $check = true;
        }

        return $check;
    }

    public static function getUserJobTitle($id) {
        $user_name = self::where('id', "=", $id)->first();
        $job_titlte = null;
        if(isset($user_name->job_title) && !empty($user_name->job_title)){
            $job_titlte = $user_name->job_title;
        }
        return $job_titlte;
    }

    public static function checkTimeSolt($id) {
        $data = self::where('id', "=", $id)->where('deleted_at', "=", null)->first();
        $check_time_slot = $data->event_time_slot_select;
        return $check_time_slot;
    }

    public static function chatMessageCompanyName($id) {
        $data = self::find($id);
        if($data->role == 1){
            $name = 'Re:Source Group';
        }elseif($data->role == 2){
            $name = null;
            if(isset($data->company_name) && !empty($data->company_name)){
                $name = $data->company_name;
            }
        }elseif($data->role == 3){
            $name = null;
            if(isset($data->created_user_id) && !empty($data->created_user_id)){
                $name = user::clientCompany($data->created_user_id);
            }
        }elseif($data->role == 4){
            $name = null;
            if(isset($data->company_name) && !empty($data->company_name)){
                $name = $data->company_name;
            }
        }elseif($data->role == 5){
            $name = null;
        }

        return $name;
    }

    public static function getHiringManager($id) {
        $data1 = self::where('created_user_id','=',$id)->where('role','=',2)->get();
        $data2 = self::where('created_user_id','=',$id)->where('role','=',3)->get();
        $data3 = self::where('id','=',$id)->get();

        $staff_data = $data1->concat($data2)->shuffle();
        $data = $staff_data->concat($data3)->shuffle();
        return $data;
    }

    public static function getHiringManagerStaff($id) {
        $data1 = self::where('created_user_id','=',$id)->where('role','=',2)->get();
        $data2 = self::where('created_user_id','=',$id)->where('role','=',3)->get();

        $data = $data1->concat($data2)->shuffle();
        return $data;
    }

    public static function checkUserStaffClient($id) {
        $data = self::find($id);
        if(isset($data->created_user_id) && !empty($data->created_user_id)){
            $result = 'staff';
        }else{
            $result = 'client';
        }
        return $result;
    }

    public static function getRoleChat($id) {
        // $user_data = self::where('id','=',$id)->where('status','=',1)->first();
        $user_data = self::where('id','=',$id)->first();
        if($user_data->role == 1){
            $role = 'Admin';
        }elseif($user_data->role == 2){
            $role = 'Client';
        }elseif($user_data->role == 3){
            $role = 'Staff';
        }elseif($user_data->role == 4){
            $role = 'Recruiter';
        }else{
            $role = '';
        }
        return $role;
    }

    public static function checkSubClientOrNot($id) {
        $user_data = self::where('id','=',$id)->where('status','=',1)->first();

        if(isset($user_data->created_user_id) && !empty($user_data->created_user_id)){
            $user_id = $user_data->created_user_id;
        }else{
            $user_id = $id;
        }
        return $user_id;
    }

    public static function checkUserDelete($id) {
        $user_data = self::where('id','=',$id)->first();

        if(isset($user_data->deleted_at) && !empty($user_data->deleted_at)){
            return false;
        }else{
            return true;
        }
    }

}
