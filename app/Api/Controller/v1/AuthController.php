<?php

declare(strict_types=1);

namespace App\Api\Controller\v1;

use App\Api\Request\Users\UserAccountLoginRequest;
use App\Api\Request\Users\UserRegisterRequest;
use App\Api\Resource\UserLoginResource;
use App\Api\Resource\UserResource;
use App\Api\Service\AuthService;
use App\Api\Service\UserService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Mine\Annotation\Auth;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\SimpleCache\InvalidArgumentException;

#[Controller(prefix: "api/v1/auth")]
class AuthController extends BaseController
{
    #[Inject]
    protected AuthService $authService;

    #[Inject]
    protected UserService $userService;

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

    /**
     * @Title  : 获取当前登录的用户信息
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @author AsuraTu
     */
    #[GetMapping("me"), Auth("api")]
    public function me(): ResponseInterface
    {
        $id = user('api')->getId();
        $result = $this->userService->getUserInfo($id);
        return $this->success(new UserResource($result));
    }

    /**
     * @Title  : 刷新token
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @author AsuraTu
     */
    #[PostMapping("refresh"), Auth("api")]
    public function refresh(): ResponseInterface
    {
        $token = $this->request->header('Authorization');
        $token = explode(' ', $token)[1];
        return $this->success($this->authService->refresh($token));
    }

    /**
     * @Title  : 退出登录
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws InvalidArgumentException
     * @throws NotFoundExceptionInterface
     * @author AsuraTu
     */
    #[PostMapping("logout"), Auth("api")]
    public function logout(): ResponseInterface
    {
        $this->authService->logout();
        return $this->success();
    }


}
