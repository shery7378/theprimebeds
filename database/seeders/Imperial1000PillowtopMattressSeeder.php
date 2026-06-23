<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Imperial1000PillowtopMattressSeeder extends Seeder
{
    public function run(): void
    {
        $item = DB::table('items')->where('name', 'like', '%Imperial 1000 Pillowtop Mattress%')->first();
        if (!$item) {
            echo "Imperial 1000 Pillowtop Mattress not found.\n";
            return;
        }

        $jsonStr = file_get_contents(base_path('imperial_1000_pillowtop_mattress.json'));
        $data = json_decode($jsonStr, true);

        // Update main item description
        $shortDesc = $data['description'];
        $fullDesc = "<p>" . str_replace("\n", "<br>", $data['description']) . "</p><ul>";
        foreach($data['bullets'] as $bullet) {
            $fullDesc .= "<li>{$bullet}</li>";
        }
        $fullDesc .= "</ul>";

        $specNames = [];
        $specDescs = [];
        foreach($data['specs'] as $k => $v) {
            // Filter out junk specs
            if (in_array($k, ['Product price:', 'Total options:', 'Order total:', 'Bed Size'])) continue;
            $specNames[] = $k;
            $specDescs[] = $v;
        }

        DB::table('items')->where('id', $item->id)->update([
            'sort_details' => Str::limit(strip_tags($shortDesc), 200),
            'details' => $fullDesc,
            'is_specification' => 1,
            'specification_name' => json_encode($specNames),
            'specification_description' => json_encode($specDescs),
        ]);

        // Clean up existing attributes for this item
        $oldAttrs = DB::table('attributes')->where('item_id', $item->id)->pluck('id');
        if($oldAttrs->count() > 0) {
            DB::table('attribute_options')->whereIn('attribute_id', $oldAttrs)->delete();
            DB::table('attributes')->where('item_id', $item->id)->delete();
        }

        // Helper to insert attributes
        $insertAttr = function($name, $options) use ($item) {
            if(empty($options)) return;
            $attrId = DB::table('attributes')->insertGetId([
                'item_id' => $item->id,
                'name' => $name,
                'keyword' => Str::slug($name),
            ]);
            foreach($options as $opt) {
                // Skip the "Select an option" dummy options
                if (strtolower($opt['name']) === 'select an option') continue;

                // Handle the Emperor string formatting "Emperor\t(+£1,000.00)"
                $optName = explode("\t", $opt['name'])[0];

                DB::table('attribute_options')->insert([
                    'attribute_id' => $attrId,
                    'name' => trim($optName),
                    'price' => $opt['price'],
                    'keyword' => Str::slug(trim($optName)),
                    'stock' => 'unlimited',
                    'variation_images' => json_encode([$opt['image']])
                ]);
            }
        };

        $insertAttr('Size', $data['sizes'] ?? []);
        $insertAttr('Fabric & Colour', $data['fabricColours'] ?? []);
        $insertAttr('Piping Colour', $data['pipingColours'] ?? []);
        $insertAttr('Headboard Height', $data['headboardHeights'] ?? []);
        $insertAttr('Mattress Options', $data['mattressOptions'] ?? []);
        $insertAttr('Other Add-Ons', $data['otherAddOns'] ?? []);

        // Gallery - images are stored locally in storage/products/
        if (!empty($data['productImages'])) {
            DB::table('galleries')->where('item_id', $item->id)->delete();
            foreach($data['productImages'] as $imgUrl) {
                DB::table('galleries')->insert([
                    'item_id' => $item->id,
                    'photo' => $imgUrl
                ]);
            }
        }
        
        echo "Imperial 1000 Pillowtop Mattress fully updated with local images and attributes!\n";
    }
}
