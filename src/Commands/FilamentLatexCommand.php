<?php

namespace TheThunderTurner\FilamentLatex\Commands;

use Illuminate\Console\Command;

class FilamentLatexCommand extends Command
{
    public $signature = 'filament-latex';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
