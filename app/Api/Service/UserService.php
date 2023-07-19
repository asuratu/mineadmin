<?php
declare(strict_types=1);

namespace App\Api\Service;

use App\Api\Mapper\UserMapper;
use Mine\Abstracts\AbstractService;

/**
 * 接口表服务类
 */
class UserService extends AbstractService
{
    /**
     * @var UserMapper
     */
    public $mapper;

    public function __construct(UserMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function save(array $data): int
    {
        return 21;
//        if ($this->mapper->existsByUsername($data['name'])) {
//            throw new NormalStatusException(StatusCode::getMessage(StatusCode::ERR_USER_EXIST), StatusCode::ERR_USER_EXIST);
//        }
//        // 登录之前的事件
//        $this->evDispatcher->dispatch(new UserLoginBefore($data));
//        // 新增用户
//        return $this->mapper->create($data);
    }
}
