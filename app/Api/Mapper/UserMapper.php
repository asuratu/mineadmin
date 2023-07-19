<?php
declare(strict_types=1);

namespace App\Api\Mapper;

use App\Api\Model\User;
use Hyperf\Database\Model\Builder;
use Mine\Abstracts\AbstractMapper;

/**
 * Class SystemApiMapper
 *
 * @package App\System\Mapper
 */
class UserMapper extends AbstractMapper
{
    public $model;

    public function assignModel(): void
    {
        $this->model = User::class;
    }

    /**
     * 搜索处理器
     *
     * @param Builder $query
     * @param array   $params
     * @return Builder
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        return $query;
    }

    public function existsByUsername(string $name): bool
    {
        return $this->model::where('username', $name)->exists();
    }

}
