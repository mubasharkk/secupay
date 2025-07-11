<?php

namespace App\Listeners;

use Illuminate\Console\Events\CommandStarting;
use Illuminate\Support\Facades\Process;

class CommandStartTestListener
{
    /**
     * Handle the event.
     */
    public function handle(CommandStarting $event): void
    {
        if ($event->command === 'test') {
            echo "Importing database" . PHP_EOL;

            $database = env('DB_DATABASE', 'laravel'); // @phpstan-ignore-line

            $result   = Process::run("DB_DATABASE={$database} bash ./database/sql/mysql-init.sh");

            // Command output
            echo $result->output() . PHP_EOL;

            echo ($result->successful() ? 'Secupay test database import completed' : 'Import failed') . PHP_EOL;
        }
    }
}
