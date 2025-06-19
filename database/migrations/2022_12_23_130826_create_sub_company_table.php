<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_company', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->index()->nullable();
            $table->string('company_name')->nullable();
            $table->mediumText('about')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('benefits_image')->nullable();

            $table->string('video')->nullable();
            $table->string('border_color')->nullable();
            $table->string('background_color')->nullable();
            $table->string('background_text_color')->nullable();
            $table->string('button_color')->nullable();
            $table->string('button_text_color')->nullable();
            $table->string('footer_background_color')->nullable();
            $table->string('footer_icon_color')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('company_logo')->nullable();
            
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_company');
    }
}
