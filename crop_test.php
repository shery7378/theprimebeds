<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Intervention\Image\ImageManagerStatic as Image;

$url = 'https://theluxurybedcompany.com/wp-content/uploads/2025/01/Baby-Pink-Soft-Velvet-1.jpg';
$img = Image::make($url);

$width = $img->width();
$height = $img->height();

echo "Original size: {$width}x{$height}\n";

// The logo is in the center and bottom text. The top left corner is safe.
// Let's crop the top left 40%
$cropSize = (int)($width * 0.4);

$img->crop($cropSize, $cropSize, 0, 0);

$savePath = public_path('assets/img/test_crop.jpg');
$img->save($savePath);

echo "Cropped and saved to: {$savePath}\n";
