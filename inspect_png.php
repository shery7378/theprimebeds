<?php
$imgPath = __DIR__ . '/public/assets/img/162196463701.png';
if (!file_exists($imgPath)) {
    echo "File not found: $imgPath\n";
    exit;
}

$im = imagecreatefrompng($imgPath);
if (!$im) {
    echo "Failed to load PNG\n";
    exit;
}

$width = imagesx($im);
$height = imagesy($im);
$hasTransparency = false;

for ($x = 0; $x < $width; $x++) {
    for ($y = 0; $y < $height; $y++) {
        $color = imagecolorat($im, $x, $y);
        $alpha = ($color >> 24) & 0x7F;
        if ($alpha > 0) {
            $hasTransparency = true;
            break 2;
        }
    }
}

echo "Image has transparency: " . ($hasTransparency ? "YES" : "NO") . "\n";
// Let's print color sample of the corner pixel (0, 0)
$cornerColor = imagecolorat($im, 0, 0);
$r = ($cornerColor >> 16) & 0xFF;
$g = ($cornerColor >> 8) & 0xFF;
$b = $cornerColor & 0xFF;
$a = ($cornerColor >> 24) & 0x7F;
echo "Corner pixel (0,0) RGBA: $r, $g, $b, $a\n";
