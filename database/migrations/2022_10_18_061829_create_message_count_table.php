<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessageCountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_count', function (Blueprint $table) {
            $table->id();
            $table->integer('job_id')->index()->nullable();
            $table->integer('client_id')->index()->nullable();
            $table->integer('candidate_id')->index()->nullable();
            $table->integer('applied_id')->index()->nullable();
            $table->string('staff_id')->index()->nullable();
            $table->string('r_c_id')->index()->nullable();
            $table->integer('count')->index()->nullable()->default('0');
            $table->integer('u_count')->index()->nullable()->default('0');
            $table->string('name')->index()->nullable();
            
            $table->string('staff_arr')->index()->nullable();
            $table->integer('created_id')->index()->nullable();
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
        Schema::dropIfExists('message_count');
    }
}
