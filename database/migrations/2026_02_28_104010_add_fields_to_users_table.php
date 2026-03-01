<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 50)->unique()->after('name');
            $table->string('full_name', 100)->nullable()->after('username');
            $table->date('date_of_birth')->nullable()->after('full_name');
            $table->string('phone', 20)->nullable()->after('date_of_birth');
            $table->enum('role', ['user', 'admin'])->default('user')->after('phone');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'full_name', 'date_of_birth', 'phone', 'role']);
        });
    }
};