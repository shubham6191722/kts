<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->index()->nullable();
            $table->string('salary')->nullable();
            $table->string('location')->nullable();
            $table->mediumText('key_skills')->nullable();
            $table->string('cv')->nullable();
            $table->string('sector')->nullable();
            $table->mediumText('description')->nullable();
            $table->string('workbasepreference')->nullable();
            $table->string('noticeperiod')->nullable();

            $table->text('n_location')->nullable();
            $table->string('categoryid')->nullable()->default('0');
            $table->string('postcode')->nullable();
            $table->enum('check_notification',['0', '1'])->default(0);
            $table->enum('check_radius',['0', '1'])->default(0);
            $table->integer('distance_km')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('c_w_email')->nullable();
            $table->string('emploment_type')->nullable();
            
            $table->integer('hourly_salary')->nullable();
            $table->integer('annual_salary')->nullable();
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
        Schema::dropIfExists('user_detail');
    }
}
