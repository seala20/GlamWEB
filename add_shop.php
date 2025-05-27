<?php
session_start();
require_once('config.php');

// Allow all logged-in users to access this page
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$message = '';
$show_popup = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $shop_name = trim($_POST['shop_name']);
    $shop_desc = trim($_POST['shop_desc']);
    $user_id = $_SESSION['user_id'];

    // Insert shop
    $stmt = $connection->prepare("INSERT INTO shops (user_id, name, description) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $shop_name, $shop_desc]);
    $shop_id = $connection->lastInsertId();

    // Loop through 3 products
    for ($i = 1; $i <= 3; $i++) {
        $prod_name = trim($_POST["product_name_$i"]);
        $prod_price = floatval($_POST["price_$i"]);
        $prod_in_stock = isset($_POST["in_stock_$i"]) ? 1 : 0;

        // Handle image upload
        $img_field = "image_$i";
        $img_name = '';
        if (!empty($_FILES[$img_field]['name'])) {
            $upload_dir = 'uploads/';
            if (!is_dir($upload_dir)) mkdir($upload_dir);
            $img_name = $upload_dir . uniqid() . '_' . basename($_FILES[$img_field]['name']);
            move_uploaded_file($_FILES[$img_field]['tmp_name'], $img_name);
        }

        // Insert product
        $stmt = $connection->prepare("INSERT INTO products (shop_id, name, price, image, in_stock) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$shop_id, $prod_name, $prod_price, $img_name, $prod_in_stock]);
    }

    $message = "Shop and products added successfully!";
    $show_popup = true;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Shop & Products</title>
    <style>
        body { font-family: 'Inter', sans-serif; background: #fff6f7; }
        form { max-width: 600px; margin: 2rem auto; background: #fff; padding: 2rem; border-radius: 20px; box-shadow: 0 4px 16px #e1575a22; }
        label { display: block; margin-bottom: 0.5rem; color: #e1575a; }
        input, textarea { width: 100%; padding: 0.5rem; margin-bottom: 1rem; border-radius: 8px; border: 1px solid #e48286; }
        button { background: #e1575a; color: #fff; border: none; border-radius: 20px; padding: 0.7rem 2rem; font-weight: bold; }
        .msg { text-align: center; color: #e1575a; margin-bottom: 1rem; }
        .product-section { border: 1px solid #e48286; border-radius: 12px; padding: 1rem; margin-bottom: 1rem; }
        .popup {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0; top: 0; width: 100vw; height: 100vh;
            background: rgba(229, 87, 90, 0.15);
            justify-content: center; align-items: center;
        }
        .popup-content {
            background: #fff;
            border-radius: 20px;
            padding: 2rem 2.5rem;
            box-shadow: 0 4px 24px #e1575a33;
            text-align: center;
            color: #e1575a;
        }
        .popup-content button, .back-home-btn {
            background: #e1575a;
            color: #fff;
            border: none;
            border-radius: 20px;
            padding: 0.7rem 2rem;
            font-weight: bold;
            margin-top: 1rem;
            cursor: pointer;
            transition: background 0.2s;
        }
        .popup-content button:hover, .back-home-btn:hover {
            background: #ed6a6a;
        }
        .back-home-btn {
            display: block;
            margin: 2rem auto 0 auto;
            text-align: center;
        }
    </style>
</head>
<body>
    <div><p style="text-align: center; color:#e48286; font-weight:bold;">“GlamConnect covers local delivery for your customers—no extra fees, no hassle. Our 15% commission includes it all!”</p></div>
    <form method="post" enctype="multipart/form-data">
        <h2>Add New Shop & 3 Products</h2>
        <?php if ($message): ?><div class="msg"><?= htmlspecialchars($message) ?></div><?php endif; ?>
        <label for="shop_name">Shop Name</label>
        <input type="text" name="shop_name" id="shop_name" required>
        <label for="shop_desc">Shop Description</label>
        <textarea name="shop_desc" id="shop_desc"></textarea>
        <hr>
        <?php for ($i = 1; $i <= 3; $i++): ?>
        <div class="product-section">
            <h4>Product <?= $i ?></h4>
            <label for="product_name_<?= $i ?>">Product Name</label>
            <input type="text" name="product_name_<?= $i ?>" id="product_name_<?= $i ?>" required>
            <label for="price_<?= $i ?>">Price (R)</label>
            <input type="number" name="price_<?= $i ?>" id="price_<?= $i ?>" step="0.01" required>
            <label for="image_<?= $i ?>">Product Image</label>
            <input type="file" name="image_<?= $i ?>" id="image_<?= $i ?>" accept="image/*" required>
            <label>
                <input type="checkbox" name="in_stock_<?= $i ?>" checked> In Stock
            </label>
        </div>
        <?php endfor; ?>
        <button type="submit">Add Shop & Products</button>
    </form>

    <!-- Back to Home Button -->
    <a href="index.php" class="back-home-btn">← Back to Home</a>

    <!-- Success Popup -->
    <div class="popup" id="successPopup">
        <div class="popup-content">
            <h3>🎉 Shop Added!</h3>
            <p>Your shop has been successfully added to the shops page.</p>
            <button onclick="closePopup()">OK</button>
        </div>
    </div>
    <script>
        <?php if ($show_popup): ?>
        document.getElementById('successPopup').style.display = 'flex';
        function closePopup() {
            document.getElementById('successPopup').style.display = 'none';
            window.location.href = 'index.php';
        }
        <?php else: ?>
        function closePopup() {}
        <?php endif; ?>
    </script>
</body>
</html>