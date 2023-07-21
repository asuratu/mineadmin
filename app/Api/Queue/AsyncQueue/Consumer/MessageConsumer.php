<?php

declare(strict_types=1);

namespace App\Api\Queue\AsyncQueue\Consumer;

use Hyperf\AsyncQueue\Process\ConsumerProcess;
use Hyperf\Process\Annotation\Process;

#[Process(name: "async-queue")]
class MessageConsumer extends ConsumerProcess
{
    protected string $queue = 'default';
}
