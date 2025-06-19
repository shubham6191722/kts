<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_activity', function (Blueprint $table) {
            $table->id()->index();
            $table->integer('client_id')->index()->nullable();
            $table->integer('user_id')->index()->nullable();
            $table->integer('job_id')->index()->nullable();
            $table->integer('applied_id')->index()->nullable();
            $table->integer('select_id')->index()->nullable();
            $table->string('text')->nullable();
            $table->integer('managed_by')->nullable();
            $table->mediumText('description')->nullable();
            $table->integer('r_c_id')->nullable()->default('0');
            
            $table->integer('mail_template')->nullable();
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
        Schema::dropIfExists('job_activity');
    }
}
