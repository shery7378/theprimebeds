<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FranklinOttomanBedSeeder extends Seeder
{
    public function run(): void
    {
        $item = DB::table('items')->where('name', 'like', '%Franklin Ottoman Bed%')->first();
        if (!$item) {
            echo "Franklin Ottoman Bed not found.\n";
            return;
        }

        $jsonStr = file_get_contents(base_path('franklin_ottoman.json'));
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
            if (in_array($k, ['60', 'Product price:', 'Total options:', 'Order total:', 'Bed Size', 'Headboard Height (in)'])) continue;
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
                DB::table('attribute_options')->insert([
                    'attribute_id' => $attrId,
                    'name' => $opt['name'],
                    'price' => $opt['price'],
                    'keyword' => Str::slug($opt['name']),
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
        
        echo "Franklin Ottoman Bed fully updated with attributes and images!\n";
    }
}
