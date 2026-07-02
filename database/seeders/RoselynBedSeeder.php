<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoselynBedSeeder extends Seeder
{
    public function run(): void
    {
        $item = DB::table('items')->where('name', 'like', '%Roselyn Bed%')->first();
        if (!$item) {
            echo "Roselyn Bed not found.\n";
            return;
        }

        $jsonStr = file_get_contents(base_path('roselyn-bed.json'));
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
            if (in_array($k, ['60', '72', '84', '54', '15', '16', '21', 'Product price:', 'Total options:', 'Order total:', 'Bed Size', 'Headboard Height (in)', 'BED SIZE', 'LENGTH (IN)', 'HEADBOARD HEIGHT (IN)', 'FOOTBOARD HEIGHT (IN)'])) continue;
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
        $insertAttr('Base Type', $data['otherAddOns'] ?? []);

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
        
        echo "Roselyn Bed fully updated with attributes and images!\n";
    }
}
