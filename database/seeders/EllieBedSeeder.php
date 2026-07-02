<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\AttributeOption;
use Illuminate\Support\Str;

class EllieBedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents(__DIR__.'/ellie.json');
        $data = json_decode($json, true);

        // Check if item already exists by SKU to prevent duplication
        $item = Item::where('sku', $data['sku'])->first();
        if ($item) {
            echo "Item already exists.\n";
            return;
        }

        $item = new Item();
        $item->name = $data['title'];
        $item->slug = 'Ellie-Bed';
        $item->sku = $data['sku'];
        $item->category_id = Category::first()->id ?? 1;
        $item->subcategory_id = 152; // The Luxury Collection
        $item->details = $data['description'];
        $item->purchase_price = 799; 
        $item->previous_price = 799;
        $item->discount_price = 799;
        $item->status = 1;
        $item->item_type = 'normal';
        $item->is_type = 'undefine';
        $item->stock = 999;
        $item->photo = $data['productImages'][0] ?? null;
        $item->thumbnail = $data['productImages'][0] ?? null;

        $item->save();

        if (isset($data['productImages']) && count($data['productImages']) > 1) {
            $images = array_slice($data['productImages'], 1);
            foreach ($images as $img) {
                $gallery = new \App\Models\Gallery();
                $gallery->item_id = $item->id;
                $gallery->photo = $img;
                $gallery->save();
            }
        }

        $attributes = [
            'Size' => $data['sizes'] ?? [],
            'Fabric & Colour' => $data['fabricColours'] ?? [],
            'Piping Colour' => $data['pipingColours'] ?? [],
            'Headboard Height' => $data['headboardHeights'] ?? [],
            'Mattress' => $data['mattressOptions'] ?? [],
            'Add-Ons' => $data['otherAddOns'] ?? [],
        ];

        foreach ($attributes as $attrName => $options) {
            if (empty($options)) continue;
            $attr = new Attribute();
            $attr->item_id = $item->id;
            $attr->name = $attrName;
            $attr->keyword = Str::slug($attrName);
            $attr->save();

            foreach ($options as $opt) {
                $option = new AttributeOption();
                $option->attribute_id = $attr->id;
                $option->name = $opt['name'];
                $option->price = $opt['price'];
                $option->keyword = Str::slug($opt['name']);
                if (isset($opt['image']) && $opt['image']) {
                    $option->variation_images = json_encode([$opt['image']]);
                }
                $option->save();
            }
        }

        echo "Ellie Bed attached successfully! Item ID: " . $item->id . "\n";
    }
}
