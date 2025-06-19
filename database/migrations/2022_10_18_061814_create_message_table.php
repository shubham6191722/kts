<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message', function (Blueprint $table) {
            $table->id();
            $table->integer('from_user_id')->index()->nullable();
            $table->integer('to_user_id')->index()->nullable();
            $table->integer('job_id')->index()->nullable();
            $table->integer('client_id')->index()->nullable();
            $table->integer('candidate_id')->index()->nullable();
            $table->integer('applied_id')->index()->nullable();
            $table->integer('r_c_id')->index()->nullable();
            $table->integer('status')->index()->nullable();
            $table->string('staff_id')->index()->nullable();
            
            $table->integer('created_id')->index()->nullable();
            $table->mediumText('message')->nullable();
            $table->integer('message_id')->index()->nullable();
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
        Schema::dropIfExists('message');
    }
}
