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
            $table->tinyInteger('status')->default(0)->comment('状态 (0正常 1停用)');
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
            $table->dropColumn(['status', 'phone', 'login_ip', 'login_time']);
        });
    }
}
