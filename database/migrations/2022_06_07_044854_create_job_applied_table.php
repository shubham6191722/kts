<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobAppliedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_applied', function (Blueprint $table) {
            $table->id()->index();
            $table->integer('user_id')->index()->nullable();
            $table->integer('job_id')->index()->nullable();
            $table->integer('client_id')->index()->nullable();
            $table->string('managed_by')->index()->nullable();
            $table->string('cv_file')->nullable();
            $table->string('notice_period')->nullable();
            $table->string('salary_expectations')->nullable();
            $table->string('work_base_preferences')->nullable();
            $table->string('job_status')->nullable();

            $table->string('job_stage')->nullable();
            $table->integer('job_workflow_id')->index()->nullable();
            $table->integer('job_new')->index()->default('1');
            $table->string('job_title')->nullable();
            $table->integer('job_advertised')->index()->nullable();
            $table->enum('job_reference',['0','1'])->default('0')->comment('0=> no reference,1=> Offer accepted')->index()->nullable();
            $table->enum('unsuccessful_mail_send',['0','1'])->default('0')->comment('0=> No Send Mail,1=> Send Mail')->index()->nullable();
            $table->integer('thumbs_status')->index()->default('0');
            $table->integer('note_status')->nullable();
            $table->integer('created_user_id')->index()->nullable();
            
            $table->text('note')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_applied');
    }
}
