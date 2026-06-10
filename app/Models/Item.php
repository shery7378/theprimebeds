<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        "name",
        "slug",
        "photo",
        "thumbnail",
        "discount_price",
        "previous_price",
        "purchase_price",
        "category_id",
        "subcategory_id",
        "childcategory_id",
        "tax_id",
        "sku",
        "video",
        "item_type",
        "is_type",
        "status",
        "tags",
        "meta_keywords",
        "meta_description",
        "details",
        "sort_details",
        "social_icons",
        "social_links",
        "is_social",
        "is_specification",
        "specification_name",
        "specification_description",
        "file",
        "link",
        "file_type",
        "bundle_discount",
        "variations",
        "license_name",
        "license_key",
        "stock",
        "vendor_id",
        "custom_text",
        "customization_level",
    ];

    protected $casts = [
        "social_icons" => "json",
        "social_links" => "json",
        "specification_name" => "json",
        "specification_description" => "json",
        "bundle_discount" => "json",
        "variations" => "json",
        "license_name" => "json",
        "license_key" => "json",
    ];

    public $timestamps = true;

    public function category()
    {
        return $this->belongsTo("App\Models\Category")->withDefault();
    }

    public function subcategory()
    {
        return $this->belongsTo("App\Models\Subcategory")->withDefault();
    }

    public function childcategory()
    {
        return $this->belongsTo("App\Models\ChieldCategory")->withDefault();
    }

    public function tax()
    {
        return $this->belongsTo("App\Models\Tax")->withDefault();
    }

    public function galleries()
    {
        return $this->hasMany("App\Models\Gallery");
    }

    public function vendor()
    {
        return $this->belongsTo("App\Models\User", "vendor_id")->withDefault();
    }

    public function reviews()
    {
        return $this->hasMany("App\Models\Review");
    }

    public function wishlist()
    {
        return $this->hasMany("App\Models\Wishlist");
    }

    public function campaigns()
    {
        return $this->hasMany("App\Models\CampaignItem", "item_id", "id");
    }

    public function attributes()
    {
        return $this->hasMany("App\Models\Attribute", "item_id", "id");
    }

    public static function taxCalculate($item): float
    {
        if (!$item || !$item->tax) {
            return 0.0;
        }

        $basePrice = (float) ($item->discount_price ?? 0);
        $taxValue = (float) ($item->tax->value ?? 0);

        if ($basePrice <= 0 || $taxValue <= 0) {
            return 0.0;
        }

        return ($basePrice * $taxValue) / 100;
    }

    /**
     * Check if the item is in stock.
     *
     * Supports both numeric and string stock values.
     */
    public function is_stock(): bool
    {
        $stock = $this->stock;

        if ($this->item_type !== "normal") {
            return true;
        }

        if ($stock === null) {
            return false;
        }

        if (is_numeric($stock)) {
            return (int) $stock > 0;
        }

        $normalizedStock = strtolower(trim((string) $stock));
        if ($normalizedStock === "unlimited") {
            return true;
        }

        return $normalizedStock !== "0" && $normalizedStock !== "";
    }

    /**
     * Alias helper for codebases using camelCase naming.
     */
    public function isStock(): bool
    {
        return $this->is_stock();
    }
}
