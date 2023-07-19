<?php
declare(strict_types=1);

namespace App\Api\Interfaces;

use App\Api\Vo\ApiUserServiceVo;

/**
 * 前台用户服务抽象
 */
interface ApiUserServiceInterface
{
    public function login(ApiUserServiceVo $userServiceVo);

    public function logout();
}
