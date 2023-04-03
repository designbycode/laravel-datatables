<?php

namespace Designbycode\Datatables\Console\Commands;

use Illuminate\Console\Command;

class DatatablesCommand extends Command
{
    public $signature = 'datatables';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
