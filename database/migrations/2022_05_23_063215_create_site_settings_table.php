<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id()->index();
            $table->string('site_title')->nullable();
            $table->string('site_favicon')->nullable();
            $table->string('site_header_logo')->nullable();
            $table->mediumText('site_notification_email')->nullable();
            $table->string('site_email_logo')->nullable();
            $table->string('facebook_link')->nullable();
            $table->string('lnstagram_link')->nullable();
            $table->string('twitter_link')->nullable();
            $table->string('footer_address')->nullable();
            
            $table->string('footer_email')->nullable();
            $table->string('footer_number')->nullable();
            $table->string('footer_copy_text')->nullable();
            $table->string('site_footer_logo')->nullable();
            $table->string('user_manual')->nullable();
            $table->string('site_talent_logo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_settings');
    }
}
