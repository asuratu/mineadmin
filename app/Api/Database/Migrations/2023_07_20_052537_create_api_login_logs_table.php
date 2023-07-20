<?php
/**
 * MineAdmin is committed to providing solutions for quickly building web applications
 * Please view the LICENSE file that was distributed with this source code,
 * For the full copyright and license information.
 * Thank you very much for using MineAdmin.
 *
 * @Author X.Mo<root@imoi.cn>
 * @Link   https://gitee.com/xmo/MineAdmin
 */

use Hyperf\Database\Migrations\Migration;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Schema\Schema;

class CreateApiLoginLogsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('api_login_logs', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->comment('登录日志表');
            $table->bigIncrements('id')->comment('主键');
            // user_id
            $table->unsignedBigInteger('user_id')->comment('用户ID');
            $table->addColumn('string', 'username', ['length' => 20, 'comment' => '用户名']);
            $table->addColumn('ipAddress', 'ip', ['comment' => '登录IP地址'])->nullable();
            $table->addColumn('string', 'ip_location', ['length' => 255, 'comment' => 'IP所属地'])->nullable();
            $table->addColumn('string', 'os', ['length' => 50, 'comment' => '操作系统'])->nullable();
            $table->addColumn('string', 'browser', ['length' => 50, 'comment' => '浏览器'])->nullable();
            $table->addColumn('smallInteger', 'status', ['default' => 1, 'comment' => '登录状态 (1成功 2失败)']);
            $table->addColumn('string', 'message', ['length' => 50, 'comment' => '提示消息'])->nullable();
            $table->addColumn('timestamp', 'login_time', ['comment' => '登录时间']);
            $table->addColumn('string', 'remark', ['length' => 255, 'comment' => '备注'])->nullable();
            $table->index('user_id');
            $table->index('username');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_login_logs');
    }
}
