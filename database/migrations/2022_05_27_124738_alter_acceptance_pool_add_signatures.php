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
            $table->string('aviance_agent')->after('signeeid')->nullable();
            $table->string('aviance_security')->after('signeeid')->nullable();
            $table->string('shipper_agent')->after('signeeid')->nullable();
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
            $table->dropColumn(['aviance_agent', 'aviance_security', 'shipper_agent']);
        });
    }
};
