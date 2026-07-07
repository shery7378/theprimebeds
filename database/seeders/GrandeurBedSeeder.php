<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GrandeurBedSeeder extends Seeder
{
    public function run(): void
    {
        $item = DB::table('items')->where('name', 'like', '%Grandeur Bed%')->first();
        if (!$item) {
            echo "Grandeur Bed not found.\n";
            return;
        }

        $jsonStr = file_get_contents(base_path('grandeur-bed.json'));
        $data = json_decode($jsonStr, true);

        // Build description HTML
        $shortDesc = $data['description'];
        $fullDesc = "<p>" . str_replace("\n", "<br>", $data['description']) . "</p><ul>";
        foreach ($data['bullets'] as $bullet) {
            $fullDesc .= "<li>{$bullet}</li>";
        }
        $fullDesc .= "</ul>";

        // Determine main photo (skip logo and dimension images)
        $mainPhoto = $item->photo;
        if (!empty($data['productImages'])) {
            foreach ($data['productImages'] as $imgUrl) {
                if (stripos($imgUrl, 'luxlogo') === false && stripos($imgUrl, 'Dimensions') === false && stripos($imgUrl, 'woocommerce-placeholder') === false) {
                    $mainPhoto = $imgUrl;
                    break;
                }
            }
        }

        DB::table('items')->where('id', $item->id)->update([
            'sort_details' => Str::limit(strip_tags($shortDesc), 200),
            'details' => $fullDesc,
            'is_specification' => 1,
            'photo' => $mainPhoto,
        ]);

        // Clean existing attributes and options
        $oldAttrs = DB::table('attributes')->where('item_id', $item->id)->pluck('id');
        if ($oldAttrs->count() > 0) {
            DB::table('attribute_options')->whereIn('attribute_id', $oldAttrs)->delete();
            DB::table('attributes')->where('item_id', $item->id)->delete();
        }

        $insertAttr = function ($name, $options) use ($item) {
            if (empty($options)) return;
            $attrId = DB::table('attributes')->insertGetId([
                'item_id' => $item->id,
                'name' => $name,
                'keyword' => Str::slug($name),
            ]);
            foreach ($options as $opt) {
                DB::table('attribute_options')->insert([
                    'attribute_id' => $attrId,
                    'name' => $opt['name'],
                    'price' => $opt['price'],
                    'keyword' => Str::slug($opt['name']),
                    'stock' => 'unlimited',
                    'variation_images' => json_encode([$opt['image']]),
                ]);
            }
        };

        $insertAttr('Size', $data['sizes'] ?? []);
        $insertAttr('Fabric & Colour', $data['fabricColours'] ?? []);
        $insertAttr('Piping Colour', $data['pipingColours'] ?? []);
        $insertAttr('Headboard Height', $data['headboardHeights'] ?? []);
        $insertAttr('Mattress Options', $data['mattressOptions'] ?? []);
        $insertAttr('Base Type', $data['otherAddOns'] ?? []);

        // Gallery – only actual bed product photos
        if (!empty($data['productImages'])) {
            DB::table('galleries')->where('item_id', $item->id)->delete();
            foreach ($data['productImages'] as $imgUrl) {
                // Skip main photo (already displayed)
                if ($imgUrl === $mainPhoto) continue;
                // Skip logo images
                if (stripos($imgUrl, 'luxlogo') !== false) continue;
                // Skip dimension/chart images
                if (stripos($imgUrl, 'Dimensions') !== false) continue;
                // Skip thumbnails (150x150, 430x430)
                if (preg_match('/-\d+x\d+\.(jpg|png|webp)$/i', $imgUrl) && (stripos($imgUrl, '150x150') !== false || stripos($imgUrl, '430x430') !== false)) continue;
                // Skip size icons
                if (preg_match('/(SINGLE|DOUBLE|KING|SUPER-KING|EMPEROR|SMALL-DOUBLE)\.(png|jpg)/i', $imgUrl)) continue;
                // Skip fabric/colour swatch images
                if (preg_match('/(Soft-Velvet|Naples|Arlington|Teddy|Velvetto|Textured-Velvet|Chenille)/i', $imgUrl)) continue;
                // Skip mattress option images
                if (preg_match('/(IMPERIAL|Oxford|SHAKESPEARE|cloud-3000|AMBASSADOR-2000|CELEBRATION|Bamboo)/i', $imgUrl)) continue;
                // Skip divan drawer options
                if (preg_match('/(divan-no-drawer|divan-two-drawer|divan-left-drawer|divan-right-drawer|newnonstoragebase|newstoragebases)/i', $imgUrl)) continue;
                // Skip "no mattress" image
                if (stripos($imgUrl, '/no.png') !== false || stripos($imgUrl, '/no-1.png') !== false || stripos($imgUrl, 'No-image-smaller') !== false || stripos($imgUrl, 'woocommerce-placeholder') !== false) continue;
                // Skip SVG icons
                if (stripos($imgUrl, '.svg') !== false) continue;
                // Skip payment strip
                if (stripos($imgUrl, 'Payment-Strip') !== false) continue;
                // Skip pixel/tracking images
                if (stripos($imgUrl, 'pixel.wp.com') !== false || stripos($imgUrl, 'g.gif') !== false) continue;
                // Skip shop icon
                if (stripos($imgUrl, 'shop-150x150') !== false) continue;
                // Skip screenshot image
                if (stripos($imgUrl, 'Screenshot') !== false) continue;
                // Skip specific irrelevant add-ons/beading
                if (stripos($imgUrl, 'silver-beading') !== false || stripos($imgUrl, 'bronze-beading') !== false) continue;
                
                // Exclude other beds explicitly
                if (preg_match('/\/(Avery|Delilah|Isabella|Lyon|Lyla|Luciano|Marilyn|Roselyn|Superior|Elegance|Ari|Ava|Lily|Sensatori|Ambassador|Amelia|Lottie|Court|Celine|Eloise|Richardson|Franklin|Tara-Luxe|Crosby|Manhattan|Midland|Boston|Westin|Manorhouse|Mount-Vale|Allure|Ivy|Indulgence|Sono|Hyatt|Rosie|Merry-Kids|Dolsie|Fontaine|Vermont|Perri|Charlie|Florence|Invicta)-/i', $imgUrl) && stripos($imgUrl, 'Grandeur') === false) continue;

                // Include if it's a real Grandeur Bed image
                if (stripos($imgUrl, 'Grandeur') !== false) {
                    DB::table('galleries')->insert([
                        'item_id' => $item->id,
                        'photo' => $imgUrl,
                    ]);
                }
            }
        }

        echo "Grandeur Bed fully updated with attributes, images, and correct main photo!\n";
    }
}
?>
