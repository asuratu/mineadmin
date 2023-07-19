<?php
declare(strict_types=1);

namespace App\Api\Service;

use App\Api\Mapper\UserMapper;
use Mine\Abstracts\AbstractService;

/**
 * 接口表服务类
 */
class AuthService extends AbstractService
{
    /**
     * @var UserMapper
     */
    public $mapper;

    public function __construct(UserMapper $mapper)
    {
        $this->mapper = $mapper;
    }


}
