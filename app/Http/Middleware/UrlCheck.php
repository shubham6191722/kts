<?php

namespace App\Http\Middleware;

use Closure;
use Redirect;
use App\Models\SiteSetting;

class UrlCheck {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next) {

        $site_title = $site_notification_email = $site_favicon = $site_header_logo = $site_email_logo = $facebook_link = $lnstagram_link = $footer_address = $footer_email = $footer_number = $footer_copy_text = $site_footer_logo = "";

        $siteSetting = SiteSetting::first();

        if (isset($siteSetting) && !empty($siteSetting)) {
            $site_title = $siteSetting->site_title;
            $site_favicon = url('uploads') . '/site_setting/' . $siteSetting->site_favicon;
            $site_header_logo = url('uploads') . '/site_setting/' . $siteSetting->site_header_logo;
            $site_email_logo = url('uploads') . '/site_setting/' . $siteSetting->site_email_logo;
            $site_notification_email = $siteSetting->site_notification_email;

            $facebook_link = $siteSetting->facebook_link;
            $lnstagram_link = $siteSetting->lnstagram_link;
            $twitter_link = $siteSetting->twitter_link;

            $footer_address = $siteSetting->footer_address;
            // $footer_email = $siteSetting->footer_email;
            // $footer_number = $siteSetting->footer_number;
            $footer_copy_text = $siteSetting->footer_copy_text;
            $site_footer_logo = url('uploads') . '/site_setting/' . $siteSetting->site_footer_logo;
        }

        define('site_title', $site_title);
        define('site_favicon', $site_favicon);
        define('site_header_logo', $site_header_logo);
        define('site_email_logo', $site_email_logo);
        define('site_notification_email', $site_notification_email);

        define('facebook_link', $facebook_link);
        define('lnstagram_link', $lnstagram_link);
        define('twitter_link', $twitter_link);

        define('footer_address', $footer_address);
        // define('footer_email', $footer_email);
        // define('footer_number', $footer_number);
        define('footer_copy_text', $footer_copy_text);
        define('site_footer_logo', $site_footer_logo);
        // define('world_link', $world_link);

        $current_fullURL_ar = explode("/index.php", url()->full());

        if (!empty($current_fullURL_ar) && count($current_fullURL_ar) >= 2) {
            $new_request = $current_fullURL_ar[0] . $current_fullURL_ar[1];
            return Redirect::to($new_request);
        } else {
            return $next($request);
        }
    }

}
