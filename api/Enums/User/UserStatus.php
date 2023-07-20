<?php

namespace Api\Enums\User;

enum UserStatus: int
{
    case NORMAL = 0;
    case USER_BAN = 1;
}
