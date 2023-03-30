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
            $table->string('code')->after('uld_number')->nullable();
            $table->boolean('is_signed')->after('code')->default(0);
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
            $table->dropColumn(['code', 'is_signed']);
        });
    }
};
