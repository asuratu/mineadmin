<?php

declare(strict_types=1);

namespace App\Api\Controller\v1;

use Api\Enums\Response\BusinessErrCode;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\PostMapping;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;

#[Controller(prefix: "api/v1/auth")]
class AuthController extends BaseController
{
    //    #[Inject]
    //    protected AuthService $authService;

    //    #[Inject]
    //    protected ApiUserServiceInterface $userService;

    /**
     * @Title  : 用户账号密码注册
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @author AsuraTu
     */
    #[PostMapping("register")]
    public function registerByAccount(): ResponseInterface
    {
        return $this->errRspWithData(BusinessErrCode::REST_ERROR, ['111test' => 'test1']);

        //        $userinfo = $this->save($data);
        //        // 用户信息转数组
        //        $userinfoArr = $userinfo->toArray();
        //        // 登录之后的事件
        //        $userLoginAfter = new ApiUserLoginAfter($userinfoArr);
        //        $userLoginAfter->message = t('jwt.register_success');
        //        // 生成token
        //        try {
        //            $token = user('api')->getToken($userinfoArr);
        //        } catch (Exception $e) {
        //            console()->error($e->getMessage());
        //            throw new NormalStatusException(t('jwt.unknown_error'));
        //        }
        //        $userLoginAfter->token = $token;
        //        // 调度登录之后的事件
        //        $this->evDispatcher->dispatch($userLoginAfter);
        //        return [
        //            'userinfo' => $userinfo,
        //            'token' => $token,
        //        ];
    }

}
