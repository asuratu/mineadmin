<?php

declare(strict_types=1);

namespace App\Api\Listener;

use App\APi\Event\ApiUserLoginAfter;
use App\Api\Model\User;
use App\System\Service\SystemLoginLogService;
use Carbon\Carbon;
use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;
use Mine\Helper\Str;
use Mine\MineRequest;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use RedisException;

/**
 * Class LoginListener
 */
#[Listener]
class LoginListener implements ListenerInterface
{
    public function listen(): array
    {
        return [
            ApiUserLoginAfter::class
        ];
    }

    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface|RedisException
     */
    public function process(object $event): void
    {
        $request = container()->get(MineRequest::class);
        $service = container()->get(SystemLoginLogService::class);

        $redis = redis();

        $agent = $request->getHeader('user-agent')[0];
        $ip = $request->ip();
        $now = Carbon::now()->toDateTimeString();

        $service->save([
            'user_id' => $event->userinfo['id'],
            'username' => $event->userinfo['name'],
            'ip' => $ip,
            'ip_location' => Str::ipToRegion($ip),
            'os' => os($agent),
            'browser' => browser($agent),
            'status' => !$event->loginStatus,
            'message' => $event->message,
            'login_time' => $now,
            'type' => 1,
        ]);

        $key = sprintf("%sToken:%s", config('cache.default.prefix'), $event->userinfo['id']);

        $redis->exists($key) && $redis->del($key);

        ($event->loginStatus && $event->token) && $redis->set($key, $event->token, config('jwt.ttl'));

        if ($event->loginStatus) {
            $event->userinfo['login_ip'] = $ip;
            $event->userinfo['login_time'] = $now;

            User::query()
                ->where('id', $event->userinfo['id'])
                ->update([
                    'login_ip' => $ip,
                    'login_time' => $now,
                ]);
        }
    }

}
