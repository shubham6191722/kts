<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobEvent extends Model {

    protected $table = 'job_event';

    protected $fillable = [
        'applied_id',
        'event_staff_select',
        'created_user_id',
        'user_id',
        'vacancy_id',
        'client_id',
        'event_title',
        'event_type',
        'event_description',
        'interview_type',
        'video_link',
        'address_select',
        'event_date',
        'event_time',
        'job_reference',
        'r_c_id',
        'event_status',
        'outlook_user',
        'confirm_date',
        'confirm_time',
        'event_slug',
        'random_string',
        'check_time_slot',
        'time_slot',
        'date_slot',
        'deleted_at',
    ];

    // public static function getAll($id) {
    //     return self::where('applied_id','=',$id)->where('deleted_at','=',null)->orderBy('id', 'asc')->get();
    // }

    public static function getAll() {
        // $data =  self::where('deleted_at','=',null)->orderBy('id', 'asc')->get();
        $data = self::select('users.id as users_client_id','users.deleted_at as client_deleted_at','job_event.*','job_vacancy.managed_by')
                        ->leftJoin('users', function($join) {
                            $join->on('job_event.client_id', '=', 'users.id');
                        })
                        ->leftJoin('job_vacancy', function($join) {
                            $join->on('job_event.vacancy_id', '=', 'job_vacancy.id');
                        })
                        ->where('job_event.event_status','=',1)
                        ->where('job_event.deleted_at','=',null)
                        ->where('users.deleted_at','=',null)
                        ->where('job_vacancy.managed_by','=',1)
                        ->orderBy('job_event.id', 'asc')
                        ->get();
        return $data;
    }

    public static function pendingGetAll() {
        // $data =  self::where('deleted_at','=',null)->orderBy('id', 'asc')->get();
        $data = self::select('users.id as users_client_id','users.deleted_at as client_deleted_at','job_event.*')
                        ->leftJoin('users', function($join) {
                            $join->on('job_event.client_id', '=', 'users.id');
                        })
                        ->leftJoin('job_vacancy', function($join) {
                            $join->on('job_event.vacancy_id', '=', 'job_vacancy.id');
                        })
                        ->where('job_event.deleted_at','=',null)
                        // ->where('job_event.event_status','!=',1)
                        ->where('users.deleted_at','=',null)
                        ->where('job_vacancy.managed_by','=',1)
                        ->orderBy('job_event.updated_at', 'desc')
                        ->get();
        return $data;
    }
    public static function pendingGetAllSearch($q_user_id,$q_job_vacancy) {
        // $data =  self::where('deleted_at','=',null)->orderBy('id', 'asc')->get();
        $query = self::select('users.id as users_client_id','users.deleted_at as client_deleted_at','job_event.*');
        $query = $query->leftJoin('users', function($join) {$join->on('job_event.client_id', '=', 'users.id');});
        $query = $query->leftJoin('job_vacancy', function($join) {$join->on('job_event.vacancy_id', '=', 'job_vacancy.id');});

        if(!empty($q_user_id) && $q_user_id != 'all'){
            $query = $query->Where(function($q) use($q_user_id) {
                $q->where('job_event.client_id','=',$q_user_id);
            });
        }

        if(!empty($q_job_vacancy) && $q_job_vacancy != 'all'){
            $query = $query->Where(function($q) use($q_job_vacancy) {
                $q->where('job_event.vacancy_id','=',$q_job_vacancy);
            });
        }

        $query = $query->where('job_event.deleted_at','=',null);
        $query = $query->where('users.deleted_at','=',null);
        $query = $query->where('job_vacancy.managed_by','=',1);
        $query = $query->orderBy('job_event.updated_at', 'desc');
        $data = $query->get();
        return $data;
    }

    public static function confirmGetAll() {
        // $data =  self::where('deleted_at','=',null)->orderBy('id', 'asc')->get();
        $data = self::select('users.id as users_client_id','users.deleted_at as client_deleted_at','job_event.*')
                        ->leftJoin('users', function($join) {
                            $join->on('job_event.client_id', '=', 'users.id');
                        })
                        ->leftJoin('job_vacancy', function($join) {
                            $join->on('job_event.vacancy_id', '=', 'job_vacancy.id');
                        })
                        ->where('job_event.deleted_at','=',null)
                        ->where('job_event.event_status','=',1)
                        ->where('users.deleted_at','=',null)
                        ->where('job_vacancy.managed_by','=',1)
                        ->orderBy('job_event.updated_at', 'desc')
                        ->get();
        return $data;
    }

    public static function eventCandidateGet($id) {
        $month = date('m');
        $year = date('Y');
        $date = $year.'-'.$month.'-'.'01';

        $event_data = self::where('user_id','=',$id)
                            ->where('event_status','=',1)
                            ->whereDate('event_date','>',$date)
                            ->where('deleted_at','=',null)->where('job_reference','=',0)->orderBy('id', 'asc')->get();
        return $event_data;
    }

    public static function pendingEventCandidateGet($id) {
        return self::where('user_id','=',$id)
        ->where('event_status','=',0)
        ->where('deleted_at','=',null)->where('job_reference','=',0)->orderBy('id', 'asc')->get();
    }

    public static function eventClientGet($id) {
        return self::where('client_id','=',$id)
        ->where('event_status','=',1)
        ->where('deleted_at','=',null)->orderBy('id', 'asc')->get();
    }

    public static function pendingEventClientGet($id) {
        return self::where('client_id','=',$id)
        // ->where('event_status','!=',1)
        ->where('deleted_at','=',null)->orderBy('updated_at', 'desc')->get();
    }

    public static function pendingEventClientGetSearch($id,$q_job_vacancy) {
        $query = self::where('client_id','=',$id);

        if(!empty($q_job_vacancy) && $q_job_vacancy != 'all'){
            $query = $query->Where(function($q) use($q_job_vacancy) {
                $q->where('vacancy_id','=',$q_job_vacancy);
            });
        }

        $query = $query->where('deleted_at','=',null);
        $data = $query->orderBy('updated_at', 'desc')->get();

        return $data;
    }

    public static function confirmEventClientGet($id) {
        return self::where('client_id','=',$id)
        ->where('event_status','=',1)
        ->where('deleted_at','=',null)->orderBy('updated_at', 'desc')->get();
    }

    public static function eventStaffGet($id) {
        $result = self::select('job_event.*','job_vacancy.id as job_vacancy_id')
                        ->leftJoin('job_vacancy', function($join) {
                            $join->on('job_event.vacancy_id', '=', 'job_vacancy.id');
                        })
                        ->whereRaw('FIND_IN_SET('.$id.',job_vacancy.staff_arr)')
                        ->where('job_event.event_status','=',1)
                        ->where('job_event.deleted_at','=',null)
                        ->where('job_vacancy.deleted_at','=',null)
                        ->orderBy('job_event.id', 'asc')->get();
        return $result;
    }

    public static function pendingEventStaffGet($id) {
        $result = self::select('job_event.*','job_vacancy.id as job_vacancy_id')
                        ->leftJoin('job_vacancy', function($join) {
                            $join->on('job_event.vacancy_id', '=', 'job_vacancy.id');
                        })
                        ->whereRaw('FIND_IN_SET('.$id.',job_vacancy.staff_arr)')
                        // ->where('job_event.event_status','!=',1)
                        ->where('job_event.deleted_at','=',null)
                        ->where('job_vacancy.deleted_at','=',null)
                        ->orderBy('job_event.updated_at', 'desc')->get();
        return $result;
    }

    public static function pendingEventStaffGetSearch($id,$q_job_vacancy) {
        $query = self::select('job_event.*','job_vacancy.id as job_vacancy_id');
        $query = $query->leftJoin('job_vacancy', function($join) {$join->on('job_event.vacancy_id', '=', 'job_vacancy.id');});
        $query = $query->whereRaw('FIND_IN_SET('.$id.',job_vacancy.staff_arr)');
        if(!empty($q_job_vacancy) && $q_job_vacancy != 'all'){
            $query = $query->Where(function($q) use($q_job_vacancy) {
                $q->where('job_event.vacancy_id','=',$q_job_vacancy);
            });
        }
        $query = $query->where('job_event.deleted_at','=',null);
        $query = $query->where('job_vacancy.deleted_at','=',null);
        $result = $query->orderBy('job_event.updated_at', 'desc')->get();
        return $result;
    }

    public static function confirmEventStaffGet($id) {
        $result = self::select('job_event.*','job_vacancy.id as job_vacancy_id')
                        ->leftJoin('job_vacancy', function($join) {
                            $join->on('job_event.vacancy_id', '=', 'job_vacancy.id');
                        })
                        ->whereRaw('FIND_IN_SET('.$id.',job_vacancy.staff_arr)')
                        ->where('job_event.event_status','=',1)
                        ->where('job_event.deleted_at','=',null)
                        ->where('job_vacancy.deleted_at','=',null)
                        ->orderBy('job_event.updated_at', 'desc')->get();
        return $result;
    }

    public static function eventOnlyStaffGet($id) {
        $result = self::select('job_event.*','job_vacancy.id as job_vacancy_id')
                        ->leftJoin('job_vacancy', function($join) {
                            $join->on('job_event.vacancy_id', '=', 'job_vacancy.id');
                        })
                        ->whereRaw('FIND_IN_SET('.$id.',job_event.event_staff_select)')
                        ->where('job_event.event_status','=',1)
                        ->where('job_event.deleted_at','=',null)
                        ->where('job_vacancy.deleted_at','=',null)
                        ->orderBy('job_event.id', 'asc')->get();
        return $result;
    }

    public static function pendingEventOnlyStaffGet($id) {
        $result = self::select('job_event.*','job_vacancy.id as job_vacancy_id')
                        ->leftJoin('job_vacancy', function($join) {
                            $join->on('job_event.vacancy_id', '=', 'job_vacancy.id');
                        })
                        ->whereRaw('FIND_IN_SET('.$id.',job_event.event_staff_select)')
                        // ->where('job_event.event_status','!=',1)
                        ->where('job_event.deleted_at','=',null)
                        ->where('job_vacancy.deleted_at','=',null)
                        ->orderBy('job_event.updated_at', 'desc')->get();
        return $result;
    }

    public static function pendingEventOnlyStaffGetSearch($id,$q_job_vacancy) {
        $query = self::select('job_event.*','job_vacancy.id as job_vacancy_id');
        $query = $query->leftJoin('job_vacancy', function($join) {$join->on('job_event.vacancy_id', '=', 'job_vacancy.id');});
        $query = $query->whereRaw('FIND_IN_SET('.$id.',job_event.event_staff_select)');
        if(!empty($q_job_vacancy) && $q_job_vacancy != 'all'){
            $query = $query->Where(function($q) use($q_job_vacancy) {
                $q->where('job_event.vacancy_id','=',$q_job_vacancy);
            });
        }
        $query = $query->where('job_event.deleted_at','=',null);
        $query = $query->where('job_vacancy.deleted_at','=',null);
        $result = $query->orderBy('job_event.updated_at', 'desc')->get();
        return $result;
    }

    public static function confirmEventOnlyStaffGet($id) {
        $result = self::select('job_event.*','job_vacancy.id as job_vacancy_id')
                        ->leftJoin('job_vacancy', function($join) {
                            $join->on('job_event.vacancy_id', '=', 'job_vacancy.id');
                        })
                        ->whereRaw('FIND_IN_SET('.$id.',job_event.event_staff_select)')
                        ->where('job_event.event_status','=',1)
                        ->where('job_event.deleted_at','=',null)
                        ->where('job_vacancy.deleted_at','=',null)
                        ->orderBy('job_event.updated_at', 'desc')->get();
        return $result;
    }

    public static function clientEventsData($user_id,$toDay,$formDay,$max_data) {
        return self::where('client_id','=',$user_id)->where('event_status','=',1)->whereBetween('confirm_date', [$toDay, $formDay])->where('deleted_at','=',null)->orderBy('event_date', 'asc')->limit($max_data)->get()->toArray();
    }

    public static function recruiterEventsData($user_id,$toDay,$formDay,$max_data) {
        $data = self::where('user_id','=',$user_id)
                    ->where('event_status','=',1)
                    ->where('check_time_slot','=',2)
                    ->whereBetween('confirm_date', [$toDay, $formDay])
                    ->where('deleted_at','=',null)
                    ->orderBy('confirm_date', 'asc')
                    ->limit($max_data)
                    ->get()
                    ->toArray();
        $data_normal = self::where('user_id','=',$user_id)
                    ->where('event_status','=',1)
                    ->where('check_time_slot','=',1)
                    ->whereBetween('confirm_date', [$toDay, $formDay])
                    ->where('deleted_at','=',null)
                    ->orderBy('confirm_date', 'asc')
                    ->limit($max_data)
                    ->get()
                    ->toArray();
        $fulldata = array_merge($data_normal,$data);
        usort($fulldata, function($a, $b) {
            return $a['confirm_date'] <=> $b['confirm_date'];
        });
        return $fulldata;
    }

    public static function pendingRecruiterEventsData($user_id,$toDay,$formDay,$max_data) {
        $data = self::where('user_id','=',$user_id)
        ->where('event_status','=',0)
        // ->whereBetween('event_date', [$toDay, $formDay])
        // ->where('check_time_slot','=',2)
        ->where('deleted_at','=',null)
        ->orderBy('event_date', 'asc')
        // ->limit($max_data)
        ->get()->toArray();
        return $data;
    }

    public static function candidateEventsData($user_id,$toDay,$formDay,$max_data) {
        $data = self::where('user_id','=',$user_id)
                    ->where('job_reference','=','0')
                    ->where('job_event.event_status','=',1)
                    ->whereBetween('confirm_date', [$toDay, $formDay])
                    ->where('deleted_at','=',null)
                    ->orderBy('confirm_date', 'asc')
                    ->limit($max_data)
                    ->get()
                    ->toArray();
        return $data;
    }

    public static function pendingCandidateEventsData($user_id,$toDay,$formDay,$max_data) {
        $data = self::where('user_id','=',$user_id)->where('job_reference','=','0')->where('job_event.event_status','=',0)
        // ->whereBetween('event_date', [$toDay, $formDay])
        ->where('deleted_at','=',null)->orderBy('event_date', 'asc')
        // ->limit($max_data)
        ->get()->toArray();
        return $data;
    }

    public static function eventRecruiterGet($id) {
        $data = self::where('user_id','=',$id)
        ->where('event_status','=',1)
        ->where('deleted_at','=',null)->where('job_reference','=',1)->orderBy('id', 'asc')->get();
        return $data;
    }

    public static function pendingEventRecruiterGet($id) {
        $data = self::where('user_id','=',$id)
        ->where('event_status','=',0)
        ->where('deleted_at','=',null)->where('job_reference','=',1)->orderBy('id', 'asc')->get();
        return $data;
    }

    public static function liveInterviewsCount($id) {
        // $data = self::where('client_id','=',$id)->where('deleted_at','=',null)->groupBy('user_id')->orderBy('event_date', 'asc')->get()->toArray();
        $data = self::where('client_id','=',$id)
            ->where('deleted_at','=',null)
            // ->groupBy('user_id')
            ->where('event_status','=','1')
            ->orderBy('event_date', 'asc')
            ->get()
            ->toArray();
        return $data;
    }

    public static function getPendingEvent($id) {
        $data = self::where('random_string','=',$id)
            ->where('deleted_at','=',null)
            ->orderBy('event_date', 'asc')
            ->first();
        return $data;
    }

    public static function getAllPastEvent($date) {
        $data = self::where('updated_at','<',$date)->update([ 'check_time_slot' => 1, 'event_status' => 1]);
        return $data;
    }

}
