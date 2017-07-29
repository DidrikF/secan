<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSecuritiesOfInterestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('securities_of_interest', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('investor_profile_id');
            $table->unsignedInteger('security_id');
            $table->mediumText('description')->nullabe();
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
        Schema::dropIfExists('securities_of_interest');
    }
}
