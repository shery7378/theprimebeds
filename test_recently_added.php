$itemCounts = [];
\App\Models\Order::pluck("cart")->each(function ($cartJson) use (&$itemCounts) {
    $cart = is_string($cartJson) ? json_decode($cartJson, true) : $cartJson;
    if (!is_array($cart)) return;
    foreach ($cart as $key => $cartItem) {
        $itemId = (int) explode("-", $key)[0];
        if ($itemId > 0) {
            $qty = isset($cartItem["qty"]) ? (int) $cartItem["qty"] : 1;
            $itemCounts[$itemId] = ($itemCounts[$itemId] ?? 0) + $qty;
        }
    }
});

if (!empty($itemCounts)) {
    arsort($itemCounts);
    $topIds = array_keys(array_slice($itemCounts, 0, 12, true));
    $items = \App\Models\Item::with("category")
        ->whereStatus(1)
        ->whereIn("id", $topIds)
        ->get()
        ->sortBy(function($item) use ($itemCounts) { return -($itemCounts[$item->id] ?? 0); })
        ->values();
    if ($items->isNotEmpty()) {
        echo json_encode($items->pluck('name', 'id')->toArray());
        exit;
    }
}
$fallback = \App\Models\Item::with("category")->whereStatus(1)->orderBy("id", "desc")->take(12)->get();
echo json_encode($fallback->pluck('name', 'id')->toArray());
