<?php

namespace Api\Trait;

use Api\Enums\Response\BusinessErrCode;
use Mine\Traits\ControllerTrait;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;

trait ApiControllerTrait
{
    use ControllerTrait;

    /**
     * @Title  : 业务错误返回
     * @param BusinessErrCode $code
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @author AsuraTu
     */
    public function errRsp(BusinessErrCode $code): ResponseInterface
    {
        return $this->error($code->getMsg(), $code->getCode());
    }

    /**
     * @Title  : 业务错误返回, 携带数据
     * @param BusinessErrCode $code
     * @param array           $data
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @author AsuraTu
     */
    public function errRspWithData(BusinessErrCode $code, array $data): ResponseInterface
    {
        return $this->error($code->getMsg(), $code->getCode(), $data);
    }
}
