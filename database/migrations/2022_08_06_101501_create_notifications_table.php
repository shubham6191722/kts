<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->index()->nullable();
            $table->integer('job_id')->index()->nullable();
            $table->integer('job_applied_user')->index()->nullable();
            $table->string('notifications_type')->nullable();
            $table->mediumText('notifications_content')->nullable();
            $table->string('url')->nullable();
            $table->integer('status')->default('0');
            $table->integer('job_reference')->default('0');
            $table->integer('r_c_id')->nullable()->default('0');
            
            $table->integer('created_user_id')->nullable();
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
        Schema::dropIfExists('notifications');
    }
}
