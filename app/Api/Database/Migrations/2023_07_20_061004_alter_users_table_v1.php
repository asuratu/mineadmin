<?php

use Hyperf\Database\Migrations\Migration;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Schema\Schema;

class AlterUsersTableV1 extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 20)->default("")->comment('手机号码');
            $table->string('login_ip', 50)->default("")->comment('登录IP地址');
            $table->dateTime('login_time')->nullable()->comment('登录时间');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'login_ip', 'login_time']);
        });
    }
}
