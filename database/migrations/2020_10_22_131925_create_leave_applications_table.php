<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('leave_id');
            $table->foreignId('leave_type_id');
            $table->foreignId('application_status_id');
            $table->date('from');
            $table->date('to');
            $table->integer('half_day')->nullable();
            $table->decimal('days_taken', 3, 1);
            $table->string('reason', 100)->nullable();
            $table->dateTime('approval_date')->nullable();

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
        Schema::dropIfExists('leave_applications');
    }
}
