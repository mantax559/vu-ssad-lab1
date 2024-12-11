<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\Console\Command\Command as CommandAlias;

class RedisClearCommand extends Command
{
    protected $signature = 'redis:clear';

    protected $description = 'Clear redis';

    public function handle(): int
    {
        Redis::flushDB();

        $this->info('Redis cleared successfully!');

        return CommandAlias::SUCCESS;
    }
}
