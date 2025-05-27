<?php
session_start();
require_once('config.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$product_id = intval($_GET['id'] ?? 0);

// Fetch product and check ownership
$stmt = $connection->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    exit("Product not found.");
}

// Check if the logged-in user owns the shop this product belongs to
$shopStmt = $connection->prepare("SELECT user_id FROM shops WHERE id = ?");
$shopStmt->execute([$product['shop_id']]);
$shop = $shopStmt->fetch(PDO::FETCH_ASSOC);

if (!$shop || $shop['user_id'] != $_SESSION['user_id']) {
    exit("You do not have permission to edit this product.");
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $price = floatval($_POST['price']);
    $stock_quantity = intval($_POST['stock_quantity']);
    $image = $product['image'];

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) mkdir($upload_dir);
        $image = $upload_dir . uniqid() . '_' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }

    $stmt = $connection->prepare("UPDATE products SET name=?, price=?, stock_quantity=?, image=? WHERE id=?");
    $stmt->execute([$name, $price, $stock_quantity, $image, $product_id]);
    $message = "Product updated successfully!";
    // Refresh product data
    $stmt = $connection->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <style>
        body { font-family: 'Inter', sans-serif; background: #fff6f7; }
        form { max-width: 500px; margin: 2rem auto; background: #fff; padding: 2rem; border-radius: 20px; box-shadow: 0 4px 16px #e1575a22; }
        label { color: #e1575a; }
        input, textarea { width: 100%; padding: 0.5rem; margin-bottom: 1rem; border-radius: 8px; border: 1px solid #e48286; }
        button { background: #e1575a; color: #fff; border: none; border-radius: 20px; padding: 0.7rem 2rem; font-weight: bold; }
        .msg { text-align: center; color: #e1575a; margin-bottom: 1rem; }
        img { max-width: 100%; border-radius: 12px; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <h2>Edit Product</h2>
        <?php if ($message): ?><div class="msg"><?= htmlspecialchars($message) ?></div><?php endif; ?>
        <label>Product Name</label>
        <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
        <label>Price (R)</label>
        <input type="number" name="price" value="<?= htmlspecialchars($product['price']) ?>" step="0.01" required>
        <label>Stock Quantity</label>
        <input type="number" name="stock_quantity" value="<?= htmlspecialchars($product['stock_quantity']) ?>" min="0" required>
        <label>Current Image</label><br>
        <img src="<?= htmlspecialchars($product['image']) ?>" alt="Product Image"><br>
        <label>Change Image</label>
        <input type="file" name="image" accept="image/*">
        <button type="submit">Update Product</button>
    </form>
</body>
</html>