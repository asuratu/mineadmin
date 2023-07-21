<?php
declare(strict_types=1);

namespace App\Api\Service;

use Api\Enums\Response\BusinessErrCode;
use Api\Exception\BusinessException;
use App\Api\Event\ApiUserLoginBefore;
use App\Api\Mapper\UserMapper;
use Hyperf\Database\Model\Model;
use Hyperf\Di\Annotation\Inject;
use Mine\Abstracts\AbstractService;
use Psr\EventDispatcher\EventDispatcherInterface;

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

    public function saveUser(array $data): Model
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

    public function getUserInfo(int $id): Model
    {
        return $this->mapper->findUserFromCache($id);
    }
}
