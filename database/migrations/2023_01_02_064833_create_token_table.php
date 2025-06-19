<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTokenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('token', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->index()->nullable();
            $table->string('userName')->nullable();
            $table->string('userEmail')->nullable();
            $table->string('userTimeZone')->nullable();
            $table->text('accessToken')->nullable();
            $table->text('expires')->nullable();
            $table->text('refreshToken')->nullable();
            $table->text('resourceOwnerId')->nullable();
            $table->text('values_token_type')->nullable();
            
            $table->text('values_scope')->nullable();
            $table->text('values_ext_expires_in')->nullable();
            $table->text('values_id_token')->nullable();
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
        Schema::dropIfExists('token');
    }
}
