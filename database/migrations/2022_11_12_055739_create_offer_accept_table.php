<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferAcceptTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_accept', function (Blueprint $table) {
            $table->id();
            $table->integer('offer_id')->index()->nullable();
            $table->integer('applied_id')->index()->nullable();
            $table->integer('vacancy_id')->index()->nullable();
            $table->integer('client_id')->index()->nullable();
            $table->integer('candidate_id')->index()->nullable();
            $table->integer('job_reference')->index()->nullable();
            $table->integer('r_c_id')->index()->nullable();
            $table->enum('offer_status',['0','1','2'])->default('0')->comment('0=> null,1=> Offer accepted,2=> Offer declined')->index();
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
        Schema::dropIfExists('offer_accept');
    }
}
