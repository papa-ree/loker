<?php

namespace Bale\Loker\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class PublishConfigLoker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loker:publish-config {--force : Overwrite existing configuration file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish configuration file for bale/loker';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $source = __DIR__.'/../../config/loker.php';
        $target = config_path('loker.php');

        if (! File::exists($source)) {
            $this->error("Config source not found: {$source}");

            return self::FAILURE;
        }

        if (File::exists($target) && ! $this->option('force')) {
            $this->line('Config file already exists: <comment>config/loker.php</comment>. Use <info>--force</info> to overwrite.');

            return self::SUCCESS;
        }

        File::copy($source, $target);
        $this->info('Published config file: <info>config/loker.php</info>');

        return self::SUCCESS;
    }
}
