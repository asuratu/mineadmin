<?php
declare(strict_types=1);

namespace App\Api\Service;

use Api\Enums\Response\JwtErrCode;
use Api\Exception\BusinessException;
use App\Api\Event\ApiUserLoginAfter;
use App\Api\Mapper\UserMapper;
use Hyperf\Di\Annotation\Inject;
use Mine\Abstracts\AbstractService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * 接口表服务类
 */
class AuthService extends AbstractService
{
    /**
     * @var UserMapper
     */
    public $mapper;

    #[Inject]
    protected UserService $userService;

    #[InJect]
    protected EventDispatcherInterface $evDispatcher;

    public function __construct(UserMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function registerByAccount(array $data): array
    {
        $userinfo = $this->userService->saveUser($data);
        // 用户信息转数组
        $userinfoArr = $userinfo->toArray();
        // 登录之后的事件
        $userLoginAfter = new ApiUserLoginAfter($userinfoArr);
        $userLoginAfter->message = t('jwt.register_success');
        // 生成token
        try {
            $token = user('api')->getToken($userinfoArr);
        } catch (InvalidArgumentException $e) {
            console()->error($e->getMessage());
            throw new BusinessException(JwtErrCode::GET_TOKEN_ERROR);
        }

        $userLoginAfter->token = $token;

        // 调度登录之后的事件
        $this->evDispatcher->dispatch($userLoginAfter);
        return [
            'userinfo' => $userinfo,
            'token' => $token,
        ];

    }


}
