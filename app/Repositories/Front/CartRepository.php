<?php

namespace App\Repositories\Front;

use App\{Models\Cart, Models\Item, Models\PromoCode, Helpers\PriceHelper};
use App\Models\AttributeOption;
use App\Models\Attribute;
use Illuminate\Support\Facades\Session;

class CartRepository
{
    /**
     * Store cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store($request)
    {
        if (empty($request->all())) {
            $parsedUrl = parse_url($request->getRequestUri(), PHP_URL_QUERY); // Extracts the query part
            parse_str((string) $parsedUrl, $queryArray);
            $qty_check = 0;
            $input = $queryArray ?: [];
            $request->merge($input);
        } else {
            $input = $request->all();
        }

        $qty_check = 0;
        $buyToCart = $request->has("buyToCart") ? $request->buyToCart : false;
        $input["option_name"] = [];
        $input["option_price"] = [];
        $input["attr_name"] = [];

        $qty = isset($input["quantity"]) ? $input["quantity"] : 1;

        $qty = is_numeric($qty) ? $qty : 1;

        if ($input["options_ids"]) {
            foreach (explode(",", $input["options_ids"]) as $optionId) {
                $option = AttributeOption::findOrFail($optionId);
                if ($qty > $option->stock) {
                    $data = [
                        "message" => "Product Out Of Stock",
                        "status" => "outStock",
                    ];
                    return $data;
                }
            }
        }

        $cart = Session::get("cart");

        $item = Item::where("id", $input["item_id"])
            ->select(
                "id",
                "name",
                "photo",
                "discount_price",
                "previous_price",
                "slug",
                "item_type",
                "license_name",
                "license_key",
                "stock",
                "bundle_discount",
            )
            ->first();

        // Check if merchant override is active for this session
        if (Session::has('merchant_id')) {
            $merchantId = Session::get('merchant_id');
            $merchantProduct = \App\Models\MerchantProduct::where('user_id', $merchantId)
                ->where('item_id', $item->id)
                ->where('is_active', true)
                ->first();
                
            if ($merchantProduct) {
                $item->discount_price = $merchantProduct->merchant_price;
                $item->merchant_id = $merchantId; // Track this for cart storage
            }
        }


        if ($item->item_type == "normal") {
            if ($item->stock < $request->quantity) {
                $data = [
                    "message" => "Product Out Of Stock",
                    "status" => "outStock",
                ];
                return $data;
            }
        }

        $single = isset($request->type) ? ($request->type == "1" ? 1 : 0) : 0;

        if (Session::has("cart")) {
            // if ($item->item_type == 'digital' || $item->item_type == 'license') {
            //     $check = array_key_exists($input['item_id'], Session::get('cart'));

            //     if ($check) {
            //         $data = ['message' => 'Product already added', 'status' => 'alreadyInCart'];
            //         return $data;
            //     } else {
            //         if (array_key_exists($input['item_id'] . '-', Session::get('cart'))) {

            //             $data = ['message' => 'Product already added', 'status' => 'alreadyInCart'];
            //             return $data;
            //         }
            //     }
            // }
        }

        $option_id = [];

        if ($single == 1) {
            $attr_name = [];
            $option_name = [];
            $option_price = [];

            if (count($item->attributes) > 0) {
                foreach ($item->attributes as $attr) {
                    if (isset($attr->options[0]->name)) {
                        $attr_name[] = $attr->name;
                        $option_name[] = $attr->options[0]->name;
                        $option_price[] = $attr->options[0]->price;
                        $option_id[] = $attr->options[0]->id;
                    }
                }
            }

            $input["attr_name"] = $attr_name;
            $input["option_price"] = $option_price;
            $input["option_name"] = $option_name;
            $input["option_id"] = $option_id;

            if ($request->quantity != "NaN") {
                $qty = $request->quantity;
                $qty_check = 1;
            } else {
                $qty = 1;
            }
        } else {
            if ($input["attribute_ids"]) {
                foreach (explode(",", $input["attribute_ids"]) as $attrId) {
                    $attr = Attribute::findOrFail($attrId);
                    $attr_name[] = $attr->name;
                }
                $input["attr_name"] = $attr_name;
            }

            if ($input["options_ids"]) {
                foreach (explode(",", $input["options_ids"]) as $optionId) {
                    $option = AttributeOption::findOrFail($optionId);
                    $option_name[] = $option->name;
                    $option_price[] = $option->price;
                    $option_id[] = $option->id;
                }
                $input["option_name"] = $option_name;
                $input["option_price"] = $option_price;
            }
        }

        if (!$item) {
            abort(404);
        }

        $option_price = array_sum($input["option_price"]);
        $attribute["names"] = $input["attr_name"];
        $attribute["option_name"] = $input["option_name"];

        if (isset($request->item_key) && $request->item_key != (int) 0) {
            $cart_item_key = explode("-", $request->item_key)[1];
        } else {
            $cart_item_key = str_replace(
                " ",
                "",
                implode(",", $attribute["option_name"]),
            );
        }

        $attribute["option_price"] = $input["option_price"];
        $cart = Session::get("cart");
        // if cart is empty then this the first product
        if (!$cart || !isset($cart[$item->id . "-" . $cart_item_key])) {
            $license_name = json_decode($item->license_name, true);
            $license_key = json_decode($item->license_name, true);
            if ($request->hasFile("sample_images")) {
                $imageNames = [];
                foreach ($request->file("sample_images") as $file) {
                    $name =
                        time() .
                        "_" .
                        uniqid() .
                        "_" .
                        str_replace(" ", "", $file->getClientOriginalName());
                    $file->move(public_path("assets/preferences"), $name);
                    $imageNames[] = $name;
                }
                $input["sample_images"] = json_encode($imageNames);
            }
            // --- BUNDLE DISCOUNT LOGIC FOR ADD TO CART ---
            $originalUnitPrice = $item->discount_price + $option_price;
            $discountedUnitPrice = $originalUnitPrice;
            $bundle = $item->bundle_discount ?? null;
            $applicableDiscount = 0;
            $qtyForDiscount = $qty;
            if (
                $bundle &&
                isset($bundle["discount_items"], $bundle["discountItems_price"])
            ) {
                foreach ($bundle["discount_items"] as $key => $requiredQty) {
                    if (
                        is_numeric($requiredQty) &&
                        $qtyForDiscount >= (int) $requiredQty
                    ) {
                        $applicableDiscount = max(
                            $applicableDiscount,
                            (float) $bundle["discountItems_price"][$key],
                        );
                    }
                }
            }
            // Fallback: use discount_pct sent by the client when the user
            // manually selected a tier in the First Time Offer modal
            if (
                $applicableDiscount === 0 &&
                isset($input["discount_pct"]) &&
                (float) $input["discount_pct"] > 0
            ) {
                $applicableDiscount = (float) $input["discount_pct"];
            }
            if ($applicableDiscount > 0) {
                $discountedUnitPrice =
                    $originalUnitPrice -
                    $originalUnitPrice * ($applicableDiscount / 100);
                $bundleDiscountTotal =
                    ($originalUnitPrice - $discountedUnitPrice) *
                    $qtyForDiscount;
            } else {
                $bundleDiscountTotal = 0;
            }
            // --- END BUNDLE DISCOUNT LOGIC ---
            $cart[$item->id . "-" . $cart_item_key] = [
                "sample_image" => $input["sample_images"] ?? null,
                "preference_description" => (isset($input["preferences"]) && 
                    $input["preferences"] !== "undefined" && 
                    $input["preferences"] !== "" 
                        ? $input["preferences"] 
                        : null),
                "options_id" => $option_id,
                "attribute" => $attribute,
                "attribute_price" => $option_price,
                "name" => $item->name,
                "slug" => $item->slug,
                "qty" => $qty,
                "price" => $discountedUnitPrice,
                "main_price" => $item->discount_price,
                "merchant_id" => $item->merchant_id ?? null,
                "photo" => $item->photo,
                "type" => $item->item_type,
                "item_type" => $item->item_type,
                "item_l_n" =>
                    $item->item_type == "license" ? end($license_name) : null,
                "item_l_k" =>
                    $item->item_type == "license" ? end($license_key) : null,
                "bundle_discount" => $bundleDiscountTotal,
            ];

            Session::put("cart", $cart);

            $coupon = Session::get("coupon");

            if ($coupon) {
                $promo_code = (object) $coupon["code"];

                $cart = Session::get("cart");
                $cartTotal = PriceHelper::cartTotal($cart, 2);
                $discount = $this->getDiscount(
                    $promo_code->discount,
                    $promo_code->type,
                    $cartTotal,
                );

                $coupon = [
                    "discount" => $discount["sub"],
                    "code" => $promo_code,
                ];
                Session::put("coupon", $coupon);
            }

            $mgs = [
                "message" => __("Product added successfully"),
                "buystatus" => $buyToCart,
                "qty" => count(Session::get("cart")),
            ];
            return $mgs;
        }

        // if cart not empty then check if this product exist then increment quantity
        if (isset($cart[$item->id . "-" . $cart_item_key])) {
            $cart = Session::get("cart");

            if ($qty_check == 1) {
                $cart[$item->id . "-" . $cart_item_key]["qty"] = $qty;
            } else {
                $cart[$item->id . "-" . $cart_item_key]["qty"] += $qty;
            }

            if ($item->item_type == "normal") {
                if (
                    $item->stock <=
                    (int) $cart[$item->id . "-" . $cart_item_key]["qty"]
                ) {
                    $data = [
                        "message" => "Product Out Of Stock",
                        "status" => "outStock",
                    ];
                    return $data;
                }
            }
            // --- BUNDLE DISCOUNT LOGIC START ---
            // Recalculate price with bundle discount and update session
            $currentQty = $cart[$item->id . "-" . $cart_item_key]["qty"];
            $attributePrice =
                $cart[$item->id . "-" . $cart_item_key]["attribute_price"];
            $originalUnitPrice = $item->discount_price + $attributePrice;
            $discountedUnitPrice = $originalUnitPrice;
            $bundle = $item->bundle_discount ?? null;
            $applicableDiscount = 0;
            if (
                $bundle &&
                isset($bundle["discount_items"], $bundle["discountItems_price"])
            ) {
                foreach ($bundle["discount_items"] as $key => $requiredQty) {
                    if (
                        is_numeric($requiredQty) &&
                        $currentQty >= (int) $requiredQty
                    ) {
                        $applicableDiscount = max(
                            $applicableDiscount,
                            (float) $bundle["discountItems_price"][$key],
                        );
                    }
                }
            }
            // Fallback: use discount_pct sent by the client when the user
            // manually selected a tier in the First Time Offer modal
            if (
                $applicableDiscount === 0 &&
                isset($input["discount_pct"]) &&
                (float) $input["discount_pct"] > 0
            ) {
                $applicableDiscount = (float) $input["discount_pct"];
            }
            if ($applicableDiscount > 0) {
                $discountedUnitPrice =
                    $originalUnitPrice -
                    $originalUnitPrice * ($applicableDiscount / 100);
                // Save bundle discount amount in session (per item, total for qty)
                $cart[$item->id . "-" . $cart_item_key]["bundle_discount"] =
                    ($originalUnitPrice - $discountedUnitPrice) * $currentQty;
            } else {
                $cart[$item->id . "-" . $cart_item_key]["bundle_discount"] = 0;
            }
            $cart[$item->id . "-" . $cart_item_key][
                "price"
            ] = $discountedUnitPrice;
            // --- BUNDLE DISCOUNT LOGIC END ---
            // dd($cart);
            Session::put("cart", $cart);

            $coupon = Session::get("coupon");

            if ($coupon) {
                $promo_code = (object) $coupon["code"];

                $cart = Session::get("cart");
                $cartTotal = PriceHelper::cartTotal($cart, 2);
                $discount = $this->getDiscount(
                    $promo_code->discount,
                    $promo_code->type,
                    $cartTotal,
                );

                $coupon = [
                    "discount" => $discount["sub"],
                    "code" => $promo_code,
                ];
                Session::put("coupon", $coupon);
            }

            $mgs = [
                "message" => __("Product added successfully"),
                "buystatus" => $buyToCart,
                "qty" => count(Session::get("cart")),
            ];

            $qty_check = 0;
            return $mgs;
        }

        $mgs = [
            "message" => __("Product add successfully"),
            "buystatus" => $buyToCart,
            "qty" => count(Session::get("cart")),
        ];
        return $mgs;
    }

    public function promoStore($request)
    {
        $input = $request->all();
        $promo_code = PromoCode::where("status", 1)
            ->whereCodeName($input["code"])
            ->where("no_of_times", ">", 0)
            ->first();

        if ($promo_code) {
            $cart = Session::get("cart");
            $cartTotal = PriceHelper::cartTotal($cart, 2);
            $discount = $this->getDiscount(
                $promo_code->discount,
                $promo_code->type,
                $cartTotal,
            );

            $coupon = [
                "discount" => $discount["sub"],
                "code" => $promo_code,
            ];
            Session::put("coupon", $coupon);

            return [
                "status" => true,
                "message" => __("Promo code found!"),
            ];
        } else {
            return [
                "status" => false,
                "message" => __("No coupon code found"),
            ];
        }
    }

    public function getCart()
    {
        $cart = Session::has("cart") ? Session::get("cart") : null;
        return $cart;
    }

    public function getDiscount($discount, $type, $price)
    {
        if ($type == "amount") {
            $sub = $discount;
            $total = $price - $sub;
        } else {
            $val = $price / 100;
            $sub = $val * $discount;
            $total = $price - $sub;
        }

        return [
            "sub" => $sub,
            "total" => $total,
        ];
    }
}
