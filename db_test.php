<?php
define('LARAVEL_START', microtime(true));
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$services = DB::table('services')->select('title', 'photo')->get();
foreach ($services as $service) {
    echo $service->title . " -> " . $service->photo . "\n";
}
