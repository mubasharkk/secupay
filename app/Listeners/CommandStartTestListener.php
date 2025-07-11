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

            $result = Process::run('DB_DATABASE=testing bash ./database/sql/mysql-init.sh');

            // Command output
            echo $result->output() . PHP_EOL;

            echo ($result->successful() ? 'Secupay test database import completed' : 'Import failed') . PHP_EOL;
        }
    }
}
