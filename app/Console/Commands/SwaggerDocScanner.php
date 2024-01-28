<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use OpenApi\Generator;

class SwaggerDocScanner extends Command
{
    protected $signature = 'swaggerdoc:scan';

    public function handle()
    {
        $path = dirname(dirname(__DIR__));
        $outputPath = dirname(dirname(dirname(dirname(__DIR__)))) . DIRECTORY_SEPARATOR . 'swaggerdoc.json';
        $this->info('Scanning ' . $path);

        // Menggunakan Generator::scan dari namespace OpenApi
        $openApi = Generator::scan([$path]);

        // Menghilangkan header('Content-Type: application/json'); karena kita hanya menyimpan dalam file
        file_put_contents($outputPath, $openApi->toJson());
        $this->info('Output ' . $outputPath);
    }
}
