<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

$attrs = DB::table('attributes')
    ->whereIn('name', ['Fabric & Colour', 'Piping Colour'])
    ->get();

$updatedCount = 0;

foreach ($attrs as $attr) {
    $options = DB::table('attribute_options')->where('attribute_id', $attr->id)->get();
    foreach ($options as $opt) {
        $slug = Str::slug($opt->name);
        $newImage = 'cropped_colors/' . $slug . '.jpg';
        $currentImages = json_decode($opt->variation_images, true) ?: [];
        
        if (empty($currentImages) || $currentImages[0] !== $newImage) {
            DB::table('attribute_options')
                ->where('id', $opt->id)
                ->update([
                    'variation_images' => json_encode([$newImage])
                ]);
            $updatedCount++;
        }
    }
}

echo "Successfully updated {$updatedCount} attribute options to use local cropped images.\n";

// Also let's fix all local JSON files so future seedings are correct
$files = glob(base_path('*.json'));
$jsonUpdated = 0;
foreach ($files as $file) {
    // Skip composer.json and package.json
    if (in_array(basename($file), ['composer.json', 'package.json'])) continue;
    
    $data = json_decode(file_get_contents($file), true);
    if (!$data) continue;
    
    $changed = false;
    foreach(['fabricColours', 'pipingColours'] as $key) {
        if (isset($data[$key])) {
            foreach($data[$key] as &$color) {
                $slug = Str::slug($color['name']);
                $newImage = 'cropped_colors/' . $slug . '.jpg';
                if ($color['image'] !== $newImage) {
                    $color['image'] = $newImage;
                    $changed = true;
                }
            }
        }
    }
    
    if ($changed) {
        file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        $jsonUpdated++;
    }
}

echo "Successfully fixed {$jsonUpdated} JSON files.\n";
