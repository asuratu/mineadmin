<?php
declare(strict_types=1);

namespace App\Api\Service;

use App\Api\Mapper\UserMapper;
use Mine\Abstracts\AbstractService;

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

    public function isExist(string $username): bool
    {
        return $this->mapper->existsByColumn("name", $username);
    }
}
