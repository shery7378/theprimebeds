$itemCounts = [648 => 5]; // Simulate 1 item ordered 5 times

arsort($itemCounts);
$topIds = array_keys(array_slice($itemCounts, 0, 12, true));
$items = \App\Models\Item::with("category")
    ->whereStatus(1)
    ->whereIn("id", $topIds)
    ->get()
    ->sortBy(function($item) use ($itemCounts) { return -($itemCounts[$item->id] ?? 0); })
    ->values();

if ($items->isNotEmpty()) {
    if ($items->count() < 12) {
        $fallback = \App\Models\Item::with("category")
            ->whereStatus(1)
            ->whereNotIn("id", $items->pluck('id'))
            ->orderBy("id", "desc")
            ->take(12 - $items->count())
            ->get();
        $items = $items->merge($fallback);
    }
    echo "Combined items: " . count($items) . "\n";
    echo json_encode($items->pluck('name')->toArray());
}
