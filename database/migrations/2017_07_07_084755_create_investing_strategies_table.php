<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvestingStrategiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investing_strategies', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('investor_profile_id');
            $table->string('name');
            $table->mediumText('description')->nullable();
            $table->string('image')->nullabe();
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
        Schema::dropIfExists('investing_strategies');
    }
}
