<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;

$jsonPath = base_path('ivy_ottoman.json');
$data = json_decode(file_get_contents($jsonPath), true);

$saveDir = public_path('assets/img/cropped_colors');
if(!is_dir($saveDir)) {
    mkdir($saveDir, 0777, true);
}

function processColors(&$colors, $saveDir, &$urlMapping) {
    foreach($colors as &$color) {
        $url = $color['image'];
        if(strpos($url, 'http') === 0) {
            $filename = Str::slug($color['name']) . '.jpg';
            $localPath = $saveDir . '/' . $filename;
            
            if(!file_exists($localPath)) {
                echo "Processing: {$color['name']}...\n";
                try {
                    $img = Image::make($url);
                    $width = $img->width();
                    $cropSize = (int)($width * 0.4);
                    $img->crop($cropSize, $cropSize, 0, 0);
                    $img->save($localPath, 90);
                } catch (\Exception $e) {
                    echo "Failed to process {$url}: " . $e->getMessage() . "\n";
                    continue;
                }
            }
            $newPath = 'cropped_colors/' . $filename;
            $urlMapping[$url] = $newPath;
            $color['image'] = $newPath;
        }
    }
}

$urlMapping = [];
echo "Processing Fabric Colours...\n";
processColors($data['fabricColours'], $saveDir, $urlMapping);

echo "Processing Piping Colours...\n";
processColors($data['pipingColours'], $saveDir, $urlMapping);

// Replace in productImages
if (isset($data['productImages'])) {
    foreach ($data['productImages'] as &$pImg) {
        if (isset($urlMapping[$pImg])) {
            $pImg = $urlMapping[$pImg];
        }
    }
}

// Write JSON back
file_put_contents($jsonPath, json_encode($data, JSON_PRETTY_PRINT));
echo "JSON updated successfully.\n";

// Run Seeder
echo "Running seeder...\n";
Artisan::call('db:seed', ['--class' => 'IvyOttomanBedSeeder']);
echo "Seeder finished.\n";
