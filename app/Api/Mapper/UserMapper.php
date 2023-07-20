<?php
declare(strict_types=1);

namespace App\Api\Mapper;

use App\Api\Model\User;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Model;
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

    public function existsByColumn(string $column, string $str): bool
    {
        return $this->model::where($column, $str)->exists();
    }

    public function create(array $data): Model
    {
        $this->filterExecuteAttributes($data, $this->getModel()->incrementing);
        return $this->model::create($data);
    }

    public function checkByColumn(string $column, string $str): Model|Builder
    {
        // 使用模型缓存
        return $this->model::query()
            ->where($column, $str)
            ->firstOrFail();
    }

    public function checkPass(string $password, string $hash): bool
    {
        return $this->model::passwordVerify($password, $hash);
    }

}
