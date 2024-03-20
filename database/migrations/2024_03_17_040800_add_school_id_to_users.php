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
        Schema::table('users', function (Blueprint $table) {
            //
            $table->foreignId('school_id')->nullable()->constrained('schools');
            $table->foreignId('department_id')->nullable()->constrained('departments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
        // When dropping a foreign key, you should specify the exact constraint name.
        // If you didn't specify a constraint name when creating the foreign key,
        // Laravel uses the "table_column_foreign" convention.
            $table->dropForeign(['school_id']); // This assumes the constraint name follows the convention.
            $table->dropColumn('school_id');// drop the column

            $table->dropForeign(['department_id']);
            $table->dropColumn('department_id');
        });
    }
};
