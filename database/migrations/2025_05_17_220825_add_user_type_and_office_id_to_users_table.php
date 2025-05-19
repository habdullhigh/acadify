<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add user_type column with default value 'student'
            $table->string('user_type')->default('student')->after('password');

            // Add office_id column and foreign key constraint
            $table->unsignedBigInteger('office_id')->nullable()->after('user_type');
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('user_type');
            $table->dropForeign(['office_id']);
            $table->dropColumn('office_id');
        });
    }
};
