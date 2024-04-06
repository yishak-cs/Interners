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
            $table->foreignId('university_id')->nullable()->constrained('universities');
            $table->foreignId('department_id')->nullable()->constrained('departments');
            $table->foreignId('fdepartment_id')->nullable()->constrained('faculty_departments');
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
            $table->dropForeign(['university_id']); // This assumes the constraint name follows the convention.
            $table->dropColumn('university_id');// drop the column

            $table->dropForeign(['department_id']);
            $table->dropColumn('department_id');

            $table->dropForeign(['fdepartment_id']);
            $table->dropColumn('fdepartment_id');
        });
    }
};
