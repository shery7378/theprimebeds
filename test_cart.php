<?php
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8000/product/add/cart?item_id=114&options_ids=&attribute_ids=&quantity=1&type=1&item_key=0&add_type=0&discount_pct=0'); 
curl_setopt($ch, CURLOPT_POST, 1); 
curl_setopt($ch, CURLOPT_POSTFIELDS, []); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
$response = curl_exec($ch); 
echo 'Response: ' . $response . "\n"; 
echo 'HTTP Code: ' . curl_getinfo($ch, CURLINFO_HTTP_CODE) . "\n"; 
curl_close($ch);
