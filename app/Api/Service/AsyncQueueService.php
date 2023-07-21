<?php

namespace App\Api\Service;

use Hyperf\AsyncQueue\Annotation\AsyncQueueMessage;

class AsyncQueueService
{
    #[AsyncQueueMessage("default", delay: 10)]
    public function handleMessage(array $params): void
    {
        console()->info('----------- AsyncQueueService success -----------');
        var_dump($params);
    }
}
