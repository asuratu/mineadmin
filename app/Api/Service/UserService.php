<?php
declare(strict_types=1);

namespace App\Api\Service;

use Api\Enums\Response\BusinessErrCode;
use Api\Enums\Response\JwtErrCode;
use Api\Exception\BusinessException;
use App\APi\Event\ApiUserLoginBefore;
use App\Api\Mapper\UserMapper;
use Hyperf\Database\Model\Model;
use Hyperf\Di\Annotation\Inject;
use Mine\Abstracts\AbstractService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\SimpleCache\InvalidArgumentException;

class UserService extends AbstractService
{
    /**
     * @var UserMapper
     */
    public $mapper;

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
        $userinfo = $this->save($data);
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

    public function save(array $data): Model
    {
        // 判断用户名是否存在
        if ($this->isExistByName($data['name'])) {
            throw new BusinessException(BusinessErrCode::USER_EXIST);
        }

        // 登录之前的事件
        $this->evDispatcher->dispatch(new ApiUserLoginBefore($data));

        // 新增用户
        return $this->mapper->create($data);
    }

    public function isExistByName(string $username): bool
    {
        return $this->mapper->existsByColumn("name", $username);
    }
}
