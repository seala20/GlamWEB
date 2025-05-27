<?php
// Example: Replace this with a database query in production
$shops = [
    "Leraglow – Beauty",
    "Khanyi_Vogue – Clothing",
    "Zanele Haven – Home Décor",
    "Chloe-Luxury" ,// <-- Added new shop
    "ubuhleWear – Fashion",
    "Urban Murangi"
];

$query = strtolower($_GET['q'] ?? '');

$results = [];
if ($query !== '') {
    foreach ($shops as $shop) {
        if (strpos(strtolower($shop), $query) !== false) {
            $results[] = $shop;
        }
    }
}

header('Content-Type: application/json');
echo json_encode($results);
?>