<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Celebration2000MattressSeeder extends Seeder
{
    public function run(): void
    {
        $item = DB::table('items')->where('name', 'Celebration 2000 Mattress (Soft)')->first();
        if (!$item) {
            echo "Celebration 2000 Mattress (Soft) not found.\n";
            return;
        }

        $jsonStr = file_get_contents(base_path('celebration-2000-mattress.json'));
        $data = json_decode($jsonStr, true);

        // Update main item description
        $shortDesc = $data['description'];
        $fullDesc = "<p>" . str_replace("\n", "<br>", $data['description']) . "</p>";

        $specNames = [];
        $specDescs = [];
        foreach($data['specs'] as $k => $v) {
            // Filter out junk specs
            if (in_array($k, ['Product price:', 'Total options:', 'Order total:', 'SIZE'])) continue;
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
                if (strtolower($opt['name']) === 'select an option') continue;

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

        // Gallery
        if (!empty($data['productImages'])) {
            DB::table('galleries')->where('item_id', $item->id)->delete();
            foreach($data['productImages'] as $imgUrl) {
                DB::table('galleries')->insert([
                    'item_id' => $item->id,
                    'photo' => $imgUrl
                ]);
            }
        }
        
        echo "Celebration 2000 Mattress fully updated with attributes and images!\n";
    }
}
