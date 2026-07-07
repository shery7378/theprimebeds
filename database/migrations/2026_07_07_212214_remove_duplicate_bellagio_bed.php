<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Find the duplicate Bellagio Bed (the one with the older photo)
        $duplicate = \Illuminate\Support\Facades\DB::table('items')
            ->where('name', 'Bellagio Bed')
            ->where('photo', 'Bli4Bellagio Bed2.jpg')
            ->first();

        if ($duplicate) {
            $itemId = $duplicate->id;
            
            // Delete related attribute options
            $attrIds = \Illuminate\Support\Facades\DB::table('attributes')->where('item_id', $itemId)->pluck('id');
            if ($attrIds->count() > 0) {
                \Illuminate\Support\Facades\DB::table('attribute_options')->whereIn('attribute_id', $attrIds)->delete();
                \Illuminate\Support\Facades\DB::table('attributes')->where('item_id', $itemId)->delete();
            }

            // Delete related gallery images
            \Illuminate\Support\Facades\DB::table('galleries')->where('item_id', $itemId)->delete();

            // Delete the item
            \Illuminate\Support\Facades\DB::table('items')->where('id', $itemId)->delete();
        }
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
