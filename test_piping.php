<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$attr = DB::table('attributes')->where('name', 'Piping Colour')->first();
if ($attr) {
    $options = DB::table('attribute_options')->where('attribute_id', $attr->id)->limit(5)->get();
    foreach ($options as $opt) {
        echo "Option: {$opt->name} - Images: {$opt->variation_images}\n";
    }
}
