<?php

declare(strict_types=1);

namespace App\Api\Controller\v1;

use Api\Request\Users\ShopUserRegisterRequest;
use App\Api\Resource\UserLoginResource;
use App\Api\Service\AuthService;
use App\Api\Service\UserService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\PostMapping;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;

#[Controller(prefix: "api/v1/auth")]
class AuthController extends BaseController
{
    #[Inject]
    protected AuthService $authService;

    #[Inject]
    protected UserService $userService;

    //    #[Inject]
    //    protected ApiUserServiceInterface $userService;

    /**
     * @Title  : 用户账号密码注册
     * @param ShopUserRegisterRequest $request
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @author AsuraTu
     */
    #[PostMapping("register")]
    public function register(ShopUserRegisterRequest $request): ResponseInterface
    {
        return $this->success(
            new UserLoginResource(
                $this->userService->registerByAccount(
                    $request->inputs([
                        'name',
                        'password',
                        'password_confirmation'
                    ])
                )
            )
        );
    }

}
