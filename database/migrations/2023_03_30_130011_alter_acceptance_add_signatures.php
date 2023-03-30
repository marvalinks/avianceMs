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
            $table->string('shipper_agent_sign')->after('shipper_agent')->nullable();
            $table->string('aviance_security_sign')->after('aviance_security')->nullable();
            $table->string('aviance_agent_sign')->after('aviance_agent')->nullable();
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
            $table->dropColumn(['shipper_agent_sign', 'aviance_security_sign', 'aviance_agent_sign']);
        });
    }
};
