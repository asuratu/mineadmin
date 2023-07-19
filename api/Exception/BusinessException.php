<?php

declare(strict_types=1);

namespace Api\Exception;

use Lishun\Enums\Interfaces\EnumCodeInterface;
use Mine\Exception\NormalStatusException;
use Throwable;

class BusinessException extends NormalStatusException
{
    public function __construct(mixed $message = null, mixed $code = 0, Throwable $previous = null)
    {
        if ($message instanceof EnumCodeInterface) {
            $msg = $message->getMsg();
            $code = $message->getCode();
            parent::__construct($msg, $code, $previous);
        } else {
            parent::__construct($message, $code, $previous);
        }
    }
}
