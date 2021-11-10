<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->decimal('annual_e', 3, 1);
            $table->decimal('carry_over', 3, 1);
            $table->decimal('total_leaves', 3, 1);
            $table->decimal('taken_so_far', 3, 1);
            $table->decimal('balance_leaves', 3, 1);

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
        Schema::dropIfExists('leave_details');
    }
}
