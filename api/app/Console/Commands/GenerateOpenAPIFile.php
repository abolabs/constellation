<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use OpenApi\Generator;

class GenerateOpenAPIFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-openapi-file';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate openapi file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $openapi = Generator::scan(
            [app_path()],
            [
                "version" => "3.1.0"
            ]
        );
        echo $openapi->toYaml();
    }
}
