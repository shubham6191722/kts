<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecruiterCandidateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recruiter_candidate', function (Blueprint $table) {
            $table->id()->index();
            $table->integer('recruiter_id')->index()->nullable();
            $table->integer('job_id')->index()->nullable();
            $table->string('fname')->nullable();
            $table->string('lname')->nullable();
            $table->string('notice_period')->nullable();
            $table->string('salary_expectations')->nullable();
            $table->string('work_base_preferences')->nullable();
            $table->string('cv')->nullable();
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
        Schema::dropIfExists('recruiter_candidate');
    }
}
