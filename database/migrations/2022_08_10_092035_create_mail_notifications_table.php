<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_notifications', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->index()->nullable();
            $table->string('email')->nullable();
            $table->integer('job_id')->index()->nullable();
            $table->string('notifications_type')->nullable();
            $table->integer('status')->default('0');
            $table->integer('job_reference')->default('0');
            $table->integer('r_c_id')->nullable()->default('0');
            $table->integer('created_user_id')->nullable();
            $table->integer('job_applied_user')->nullable();
            
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
        Schema::dropIfExists('mail_notifications');
    }
}
