<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;

class SwaggerDocScanner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swaggerdoc:scan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $path = dirname(dirname(__DIR__));

        $outputPath = dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . 'public/swaggerdoc.json';
        $this->info('Scanning ' . $path);
        $openApi = \OpenApi\scan($path);
        header('Content-Type: application/json');
        file_put_contents($outputPath, $openApi->toJson());
        $this->info('Output ' . $outputPath);
    }
}
