<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFireExtinguishersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fire_extinguishers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_site_id');
            $table->foreignId('equipment_type_id');
            $table->string('standby_place');
            $table->string('manufacturing_number');
            $table->date('manufactured_at');
            $table->text('comments')->nullable();
            $table->date('q1_check')->nullable();
            $table->date('q2_check')->nullable();
            $table->date('q3_check')->nullable();
            $table->date('q4_check')->nullable();
            $table->date('maintenance_date')->nullable();
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
        Schema::dropIfExists('fire_extinguishers');
    }
}
