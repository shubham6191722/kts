<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationsController;
use Illuminate\Http\Request;

use App\Models\JobOffers;
use App\Models\JobActivity;
use App\Models\OfferAccept;
use App\Models\JobVacancy;

class OfferController extends Controller {

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

        $user_id = Auth::user()->id;

        $offer_data_panding = JobOffers::offerCandidatePanding($user_id);
        $offer_data_accepted = JobOffers::offerCandidateAccepted($user_id);
        $offer_data_declined = JobOffers::offerCandidateDeclined($user_id);

        $offer_data_panding_count  = JobOffers::offerCandidatePanding($user_id)->count();
        $offer_data_accepted_count = JobOffers::offerCandidateAccepted($user_id)->count();
        $offer_data_declined_count = JobOffers::offerCandidateDeclined($user_id)->count();
       
        return view('frontend.after_login.offer.index')->with('offer_data_panding',$offer_data_panding)->with('offer_data_accepted',$offer_data_accepted)
                                                       ->with('offer_data_declined',$offer_data_declined)->with('offer_data_panding_count',$offer_data_panding_count)
                                                       ->with('offer_data_accepted_count',$offer_data_accepted_count)->with('offer_data_declined_count',$offer_data_declined_count);
    }

    public function offerAccept(Request $request) {

        $value = $request->value;
        $offer_id = $request->offer_id;
        $user_id = $request->user_id;

        $offer_data = JobOffers::offerGet($offer_id,$user_id);

        $offer_data->offer_status = $value;
        $offer_data->declined_reason = null;

        if ($offer_data->save()) {
            $offer_accept = new OfferAccept;
            $offer_accept->offer_id = $offer_data->id;
            $offer_accept->applied_id = $offer_data->applied_id;
            $offer_accept->vacancy_id = $offer_data->vacancy_id;
            $offer_accept->client_id = $offer_data->client_id;
            $offer_accept->candidate_id = $offer_data->candidate_id;
            $offer_accept->job_reference = $offer_data->job_reference;
            $offer_accept->r_c_id = $offer_data->r_c_id;
            $offer_accept->save();

            $job_vacancy = JobVacancy::find($offer_data->vacancy_id);
            $job_vacancy->jobvacancystatus = 3;
            $job_vacancy->jobvacancystage = 5;
            $job_vacancy->save();

            NotificationsController::notificationNewOfferAccepted($offer_data);

            $text = "Offer accepted";

            $JobActivity = new JobActivity;

            $JobActivity->select_id = $offer_data->candidate_id;
            $JobActivity->client_id = $offer_data->client_id;
            $JobActivity->job_id = $offer_data->vacancy_id;
            $JobActivity->user_id = Auth::user()->id;
            $JobActivity->applied_id = $offer_data->applied_id;
            $JobActivity->text = $text;
            $JobActivity->save();

            return response()->json(['msg'=> $text,'code' => 1]);
        } else {
            return response()->json(['code' => 0]);
        }
    }

    public function offerDeclin(Request $request) {

        $value = $request->value;
        $offer_id = $request->offer_id;
        $user_id = $request->user_id;
        $declined_reason = $request->declined_reason;

        $offer_data = JobOffers::offerGet($offer_id,$user_id);

        $offer_data->offer_status = $value;
        $offer_data->declined_reason = $declined_reason;

        if ($offer_data->save()) {

            NotificationsController::notificationNewOfferDeclined($offer_data);
            
            $text = "Offer Decline.";

            $JobActivity = new JobActivity;

            $JobActivity->select_id = $offer_data->candidate_id;
            $JobActivity->client_id = $offer_data->client_id;
            $JobActivity->job_id = $offer_data->vacancy_id;
            $JobActivity->user_id = Auth::user()->id;
            $JobActivity->applied_id = $offer_data->applied_id;
            $JobActivity->text = $text;
            $JobActivity->save();

            return back()->with("success", "Your Offer Decline.");
        } else {
            return back()->with("error", "Please try again!");
        }
    }

}
