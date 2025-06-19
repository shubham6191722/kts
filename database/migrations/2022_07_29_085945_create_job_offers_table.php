<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_offers', function (Blueprint $table) {
            $table->id();
            $table->integer('applied_id')->index()->nullable();
            $table->integer('vacancy_id')->index()->nullable();
            $table->integer('client_id')->index()->nullable();
            $table->integer('candidate_id')->index()->nullable();
            $table->integer('created_id')->index()->nullable();
            $table->enum('offer_status',['0','1','2'])->default('0')->comment('0=> null,1=> Offer accepted,2=> Offer declined')->index()->nullable();
            $table->string('offered_salary')->nullable();
            $table->date('suggested_date')->nullable();
            $table->mediumText('description')->nullable();
            
            $table->mediumText('declined_reason')->nullable();
            $table->integer('job_reference')->nullable();
            $table->integer('r_c_id')->nullable();
            $table->string('offer_letter')->nullable();
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
        Schema::dropIfExists('job_offers');
    }
}
