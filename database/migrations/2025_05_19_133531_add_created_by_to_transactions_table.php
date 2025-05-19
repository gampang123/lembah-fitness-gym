<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Set nullable to column created_by
            $table->unsignedBigInteger('created_by')->nullable()->after('id');
        });

        // Set default value for created_by to 1 (admin)
        DB::table('transactions')->whereNull('created_by')->update(['created_by' => 1]);

        Schema::table('transactions', function (Blueprint $table) {
            // Add foreign key constraint
            $table->foreign('created_by')->references('id')->on('users');

            // Set Column created_by to not null
            $table->unsignedBigInteger('created_by')->nullable(false)->change();
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn('created_by');
        });
    }

};
