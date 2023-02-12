<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //if the database space was an issue the contated and hired columns
        //could be declared as tinyInteger and use 0 and 1 for true and false
        //because the type size is lesser
        Schema::create('contact_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('company_id');
            $table->unsignedInteger('candidate_id');
            $table->boolean('contacted');
            $table->boolean('hired')->nullable();

            $table->foreign('company_id')->on('companies')->references('id');
            $table->foreign('candidate_id')->on('candidates')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_history');
    }
};
