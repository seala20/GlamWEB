<?php

session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item = [
        'product_id' => $_POST['product_id'],
        'shop_id' => $_POST['shop_id'],
        'name' => $_POST['name'],
        'price' => (float)$_POST['price'],
        'image' => $_POST['image']
    ];
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    $_SESSION['cart'][] = $item;
    header('Location: cart.php');
    exit;
}
header('Location: shop.php');
exit;
?>