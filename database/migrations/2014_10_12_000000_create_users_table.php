<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id()->index();
            $table->string('name')->index()->nullable();
            $table->string('lname')->index()->nullable();
            $table->string('email')->index()->unique();
            $table->integer('c_code')->nullable();
            $table->string('country_code')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('town')->nullable();
            $table->string('company_name')->unique()->nullable();

            $table->string('job_title')->nullable();
            $table->string('users_needed')->nullable();
            $table->tinyInteger('role')->index()->default('5');
            $table->timestamp('email_verified_at')->nullable();
            $table->tinyInteger('email_confirm')->default('0');
            $table->string('email_key')->nullable();
            $table->tinyInteger('status')->default('0');
            $table->integer('created_user_id')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('cover_image')->nullable();

            $table->integer('company_credits')->default('0');
            $table->string('department')->nullable();
            $table->string('recruitment_specialism')->nullable();
            $table->string('password')->nullable();
            $table->string('pass_reset_token')->nullable();
            $table->string('client_slug')->nullable();
            $table->enum('talent_pool_status',['0','1'])->default('0')->comment('0=> DeActive,1=> Active')->index()->nullable();
            $table->string('sub_model')->nullable();
            $table->date('sub_created')->nullable();
            $table->date('sub_expires')->nullable();

            $table->integer('sub_cost')->nullable();
            $table->string('sub_payment_terms')->nullable();
            $table->integer('credits_allotted')->nullable()->default('0');
            $table->date('credits_expire')->nullable();
            $table->string('user_manual')->nullable();
            $table->string('policy_url')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            
            $table->timestamp('check_status')->nullable();
            $table->enum('offer_status',['0','1'])->default('0')->comment('0=> DeActive,1=> Active')->index()->nullable();
            $table->integer('event_time_slot_select')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
