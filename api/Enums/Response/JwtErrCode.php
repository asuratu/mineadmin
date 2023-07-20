<?php

namespace Api\Enums\Response;

use Lishun\Enums\Annotations\EnumCode;
use Lishun\Enums\Annotations\EnumCodePrefix;
use Lishun\Enums\Interfaces\EnumCodeInterface;
use Lishun\Enums\Traits\EnumCodeGet;

#[EnumCodePrefix(30, 'JWT错误码')]
enum JwtErrCode: int implements EnumCodeInterface
{
    use EnumCodeGet;

    #[EnumCode('获取token失败')]
    case GET_TOKEN_ERROR = 1001;

}
