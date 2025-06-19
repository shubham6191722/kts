<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutlookEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outlook_event', function (Blueprint $table) {
            $table->id();
            $table->text('outlook_event_id')->nullable();
            $table->string('event_id')->nullable();
            $table->integer('user_id')->index()->nullable();
            $table->longText('full_data')->nullable();
            $table->integer('check_organizer')->default('0');
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
        Schema::dropIfExists('outlook_event');
    }
}
