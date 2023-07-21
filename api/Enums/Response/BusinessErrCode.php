<?php

namespace Api\Enums\Response;

use Lishun\Enums\Annotations\EnumCode;
use Lishun\Enums\Annotations\EnumCodePrefix;
use Lishun\Enums\Interfaces\EnumCodeInterface;
use Lishun\Enums\Traits\EnumCodeGet;

#[EnumCodePrefix(20, '业务错误码')]
enum BusinessErrCode: int implements EnumCodeInterface
{
    use EnumCodeGet;

    #[EnumCode('业务错误', ext: ['test' => 1])]
    case REST_ERROR = 500;

    #[EnumCode('业务错误1')]
    case REST_ERROR1 = 501;

    #[EnumCode('业务错误2', ext: ['test' => 1])]
    case REST_ERROR2 = 502;

    #[EnumCode('用户已存在')]
    case USER_EXIST = 1001;

    #[EnumCode('对象不存在')]
    case OBJECT_NOT_EXIST = 1002;

    #[EnumCode('用户已被禁用')]
    case USER_BAN = 1003;

    #[EnumCode('用户不存在')]
    case USER_NOT_EXIST = 1004;

    #[EnumCode('用户密码错误')]
    case USER_PASSWORD_ERROR = 1005;

    #[EnumCode('请求过于频繁')]
    case TOO_MANY_REQUESTS = 1006;
}
