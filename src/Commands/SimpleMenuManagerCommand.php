<?php

namespace Postare\SimpleMenuManager\Commands;

use Illuminate\Console\Command;

class SimpleMenuManagerCommand extends Command
{
    public $signature = 'filament-simple-menu-manager';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
