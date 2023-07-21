<?php
declare(strict_types=1);

namespace App\Api\Service;

use Api\Enums\Response\BusinessErrCode;
use Api\Enums\Response\JwtErrCode;
use Api\Enums\User\UserStatus;
use Api\Exception\BusinessException;
use App\Api\Event\ApiUserLoginAfter;
use App\Api\Event\ApiUserLogout;
use App\Api\Mapper\UserMapper;
use App\Shop\Model\ShopUser;
use Hyperf\Di\Annotation\Inject;
use Mine\Abstracts\AbstractService;
use Mine\Constants\StatusCode;
use Mine\Event\UserLoginBefore;
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
     * @Title  : 用户账号密码注册
     * @param array $data
     * @return array
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @author AsuraTu
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

    /**
     * @Title  : 用户账号密码登录
     * @param array $data
     * @return array
     * @throws ContainerExceptionInterface
     * @throws InvalidArgumentException
     * @throws NotFoundExceptionInterface
     * @author AsuraTu
     */
    public function loginByAccount(array $data): array
    {
        $this->evDispatcher->dispatch(new UserLoginBefore($data));
        $userinfo = $this->mapper->checkByColumn('name', $data['name']);
        $userinfoArr = $userinfo->toArray();
        $password = $userinfoArr['password'];
        unset($userinfoArr['password']);
        $userLoginAfter = new ApiUserLoginAfter($userinfoArr);

        if (!$this->mapper->checkPass($data['password'], $password)) {
            throw new BusinessException(BusinessErrCode::USER_PASSWORD_ERROR);
        }

        if ($userinfo['status'] == UserStatus::USER_BAN) {
            $userLoginAfter->loginStatus = false;
            $userLoginAfter->message = BusinessErrCode::USER_BAN->getMsg();
            $this->evDispatcher->dispatch($userLoginAfter);
            throw new BusinessException(BusinessErrCode::USER_BAN);
        }

        $userLoginAfter->message = t('jwt.login_success');
        $token = user('api')->getToken($userLoginAfter->userinfo);
        $userLoginAfter->token = $token;
        $this->evDispatcher->dispatch($userLoginAfter);

        return [
            'userinfo' => $userinfo,
            'token' => $token,
        ];
    }

    public function refresh(string $token): array
    {
        $user = user('api');
        return ['token' => $user->getJwt()->refreshToken($token)];
    }

    /**
     * @Title: 退出登录
     * @throws InvalidArgumentException
     */
    public function logout(): void
    {
        $user = user('api');
        $this->evDispatcher->dispatch(new ApiUserLogout($user->getUserInfo()));
        $user->getJwt()->logout();
    }


}
