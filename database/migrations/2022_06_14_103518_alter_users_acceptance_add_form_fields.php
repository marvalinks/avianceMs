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
        Schema::table('acceptance_pools', function (Blueprint $table) {
            $table->string('flight_no')->after('statusCode')->nullable();
            $table->string('uld_option')->after('statusCode')->default('BULK');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('acceptance_pools', function (Blueprint $table) {
            $table->dropColumn(['flight_no', 'uld_option']);
        });
    }
};
