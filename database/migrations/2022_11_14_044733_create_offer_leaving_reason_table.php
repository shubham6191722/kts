<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferLeavingReasonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_leaving_reason', function (Blueprint $table) {
            $table->id();
            $table->integer('offer_id')->index()->nullable();
            $table->integer('applied_id')->index()->nullable();
            $table->integer('vacancy_id')->index()->nullable();
            $table->integer('client_id')->index()->nullable();
            $table->integer('candidate_id')->index()->nullable();
            $table->integer('job_reference')->index()->nullable();
            $table->integer('r_c_id')->index()->nullable();
            $table->date('confirmed_start_date')->nullable();
            $table->date('confirmed_leave_date')->nullable();
            
            $table->integer('reason_for_leaving')->index()->nullable();
            $table->integer('week_count')->index()->nullable();
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
        Schema::dropIfExists('offer_leaving_reason');
    }
}
