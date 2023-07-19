<?php

namespace Api\Enums\Response;

use Lishun\Enums\Annotations\EnumCode;
use Lishun\Enums\Annotations\EnumCodePrefix;
use Lishun\Enums\Interfaces\EnumCodeInterface;
use Lishun\Enums\Traits\EnumCodeGet;

#[EnumCodePrefix(20, '业务错误码')]
enum
BusinessErrCode: int implements EnumCodeInterface
{
    use EnumCodeGet;

    #[EnumCode('业务错误', ext: ['test' => 1])]
    case REST_ERROR = 500;

    #[EnumCode('业务错误1')]
    case REST_ERROR1 = 501;

    #[EnumCode('业务错误2', ext: ['test' => 1])]
    case REST_ERROR2 = 502;
}
