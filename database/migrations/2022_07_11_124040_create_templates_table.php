<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->id()->index();
            $table->integer('user_id')->index()->nullable();
            $table->string('template_name')->nullable();
            $table->integer('template_id')->index()->nullable();
            $table->integer('managed_by')->nullable();
            $table->integer('user_select')->nullable();
            $table->integer('sub_company')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('hiring_manager_file_title')->nullable();
            $table->integer('hiring_manager_file_id')->nullable();

            $table->string('jobtitle')->nullable();
            $table->string('jobtenure',20)->nullable();
            $table->dateTime('startdate', $precision = 0)->nullable();
            $table->integer('duration')->nullable();
            $table->integer('lengthofcontract')->nullable();
            $table->string('durationperiod',10)->nullable();
            $table->integer('weeklyworkinghours')->nullable();
            $table->integer('ratelower')->nullable();
            $table->integer('rateupper')->nullable();
            $table->string('ratefrequency',10)->nullable();

            $table->string('ratecurrency',3)->nullable();
            $table->string('locatedcountry',3)->nullable();
            $table->integer('locatedregion')->nullable();
            $table->string('altlocation')->nullable();
            $table->string('locatedpostcode',10)->nullable();
            $table->integer('categoryid')->nullable();
            $table->integer('occupationid')->nullable();
            $table->integer('levelid')->nullable();
            $table->mediumText('jobdescription')->nullable();
            $table->mediumText('skillsrequired')->nullable();

            $table->mediumText('qualificationsrequired')->nullable();
            $table->mediumText('keywords')->nullable();
            $table->integer('jobcategory1')->nullable();
            $table->integer('jobcategory2')->nullable();
            $table->integer('jobcategory3')->nullable();
            $table->integer('jobcategory4')->nullable();
            $table->integer('jobvacancystatus')->nullable();
            $table->integer('jobvacancystage')->nullable();
            $table->string('job_specification')->nullable();
            $table->integer('specification_file_title')->nullable();

            $table->string('specification_file_id')->nullable();
            $table->mediumText('infofromthehiringmanager')->nullable();
            $table->integer('jobworkflow_id')->nullable();
            $table->string('slug')->index()->nullable();
            $table->string('media_specification',20)->nullable();
            $table->string('media_hiring_manager',20)->nullable();
            $table->mediumText('benefits')->nullable();
            $table->mediumText('work_base_preference')->nullable();
            $table->json('staff_select')->nullable();
            $table->json('recruiter_select')->nullable();

            $table->string('staff_arr')->nullable();
            $table->string('recruiter_arr')->nullable();
            $table->string('benefits_image')->nullable();
            $table->string('benefits_file_title')->nullable();
            $table->integer('benefits_file_id')->nullable();
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
        Schema::dropIfExists('templates');
    }
}
