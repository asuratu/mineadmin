<?php

declare(strict_types=1);

namespace App\Api\Controller\v1;

use Api\Enums\Response\BusinessErrCode;
use Api\Exception\BusinessException;
use Api\Trait\ApiControllerTrait;
use Hyperf\Di\Aop\ProceedingJoinPoint;

class BaseController
{
    use ApiControllerTrait;

    public static function limitCallback(float $seconds, ProceedingJoinPoint $proceedingJoinPoint)
    {
        throw new BusinessException(BusinessErrCode::TOO_MANY_REQUESTS);
        // $seconds 下次生成Token 的间隔, 单位为秒
        // $proceedingJoinPoint 此次请求执行的切入点
        // 可以通过调用 `$proceedingJoinPoint->process()` 继续完成执行，或者自行处理
    }
}
