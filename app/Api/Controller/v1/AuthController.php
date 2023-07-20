<?php

declare(strict_types=1);

namespace App\Api\Controller\v1;

use App\Api\Request\Users\UserAccountLoginRequest;
use App\Api\Request\Users\UserRegisterRequest;
use App\Api\Resource\UserLoginResource;
use App\Api\Service\AuthService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\PostMapping;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\SimpleCache\InvalidArgumentException;

#[Controller(prefix: "api/v1/auth")]
class AuthController extends BaseController
{
    #[Inject]
    protected AuthService $authService;

    /**
     * @Title  : 用户账号密码注册
     * @param UserRegisterRequest $request
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @author AsuraTu
     */
    #[PostMapping("register")]
    public function register(UserRegisterRequest $request): ResponseInterface
    {
        $data = $request->validated();
        $result = $this->authService->registerByAccount($data);
        return $this->success(new UserLoginResource($result));
    }

    /**
     * @Title  : 用户账号密码登录
     * @param UserAccountLoginRequest $request
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface|InvalidArgumentException
     * @author AsuraTu
     */
    #[PostMapping("login")]
    public function login(UserAccountLoginRequest $request): ResponseInterface
    {
        $data = $request->validated();
        $result = $this->authService->loginByAccount($data);
        return $this->success(new UserLoginResource($result));
    }

}
