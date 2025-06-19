<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_event', function (Blueprint $table) {
            $table->id()->index();
            $table->integer('applied_id')->index()->nullable();
            $table->string('event_staff_select')->index()->nullable();
            $table->integer('created_user_id')->index()->nullable();
            $table->integer('user_id')->index()->nullable();
            $table->integer('vacancy_id')->index()->nullable();
            $table->integer('client_id')->index()->nullable();
            $table->string('event_title')->nullable();
            $table->string('event_type')->nullable();
            $table->longText('event_description')->nullable();

            $table->string('interview_type')->nullable();
            $table->longText('video_link')->nullable();
            $table->integer('address_select')->nullable();
            $table->date('event_date')->nullable();
            $table->time('event_time')->nullable();
            $table->integer('job_reference')->default('0');
            $table->integer('r_c_id')->nullable();
            $table->integer('event_status')->nullable();
            $table->string('outlook_user')->nullable();
            $table->date('confirm_date')->nullable();

            $table->time('confirm_time')->nullable();
            $table->string('event_slug')->nullable();
            $table->string('random_string')->nullable();
            $table->longText('check_time_slot')->nullable();
            $table->longText('time_slot')->nullable();
            $table->longText('date_slot')->nullable();
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
        Schema::dropIfExists('job_event');
    }
}
