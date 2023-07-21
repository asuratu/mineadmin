<?php

return [
    'default' => [
        'driver' => Hyperf\AsyncQueue\Driver\RedisDriver::class,
        'redis' => [
            'pool' => 'default'
        ],
        'channel' => 'queue', //队列前缀
        'timeout' => 2, //pop 消息的超时时间
        'retry_seconds' => [1, 5, 10, 20], //失败后重新尝试间隔
        'handle_timeout' => 10, //消息处理超时时间
        'processes' => 1, //增加异步队列进程数量，加快消费速度
        'concurrent' => [ //并发执行的协程数量配置
            'limit' => 5, //限制并发执行的协程数量
        ],
    ],
];
