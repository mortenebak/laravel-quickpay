<?php

namespace Netbums\Quickpay\Commands;

use Illuminate\Console\Command;

class QuickpayCommand extends Command
{
    public $signature = 'laravel-quickpay';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
