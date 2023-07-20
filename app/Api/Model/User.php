<?php

declare(strict_types=1);

namespace App\Api\Model;

use Carbon\Carbon;
use Hyperf\Database\Model\SoftDeletes;

/**
 * @property int    $id                主键
 * @property string $name              用户名
 * @property string $email             邮箱
 * @property string $email_verified_at 邮箱验证时间
 * @property string $password          密码
 * @property string $remember_token    记住登录
 * @property Carbon $created_at        创建时间
 * @property Carbon $updated_at        更新时间
 * @property string $deleted_at        删除时间
 */
class User extends BaseModel
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected ?string $table = 'users';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['name', 'email', 'email_verified_at', 'password', 'remember_token', 'created_at', 'updated_at', 'deleted_at', 'phone', 'login_ip', 'login_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    /**
     * 验证密码
     *
     * @param $password
     * @param $hash
     * @return bool
     */
    public static function passwordVerify($password, $hash): bool
    {
        return password_verify($password, $hash);
    }

    /**
     * 密码加密
     *
     * @param $value
     * @return void
     */
    public function setPasswordAttribute($value): void
    {
        $this->attributes['password'] = password_hash($value, PASSWORD_DEFAULT);
    }

}
