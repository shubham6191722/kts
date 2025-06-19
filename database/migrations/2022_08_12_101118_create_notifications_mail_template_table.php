<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsMailTemplateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications_mail_template', function (Blueprint $table) {
            $table->id();
            $table->integer('role')->index()->nullable();
            $table->string('type_text')->nullable();
            $table->string('notifications_type')->nullable();
            $table->string('email_subject')->nullable();
            $table->mediumText('email_description')->nullable();
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
        Schema::dropIfExists('notifications_mail_template');
    }
}
