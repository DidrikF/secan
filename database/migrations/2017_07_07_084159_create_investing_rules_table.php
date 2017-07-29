<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvestingRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investing_rules', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('investor_profile_id');
            $table->string('text');
            $table->string('type')->nullable();
            $table->float('quantitative_measure')->nullable();
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
        Schema::dropIfExists('investing_rules');
    }
}
