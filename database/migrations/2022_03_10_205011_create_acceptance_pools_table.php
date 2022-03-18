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
        Schema::create('acceptance_pools', function (Blueprint $table) {
            $table->id();
            $table->string('airWaybill');
            $table->integer('pieces');
            $table->float('weight');
            $table->float('volume');
            $table->string('origin');
            $table->string('destination');
            $table->string('statusCode');
            $table->string('author_name');
            $table->string('author_id');
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
        Schema::dropIfExists('acceptance_pools');
    }
};
