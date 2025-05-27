<?php
session_start();
require_once('config.php');

// Only allow logged-in users
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch all shops owned by the user
$shops = $connection->prepare("SELECT * FROM shops WHERE user_id = ?");
$shops->execute([$user_id]);
$shops = $shops->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage My Shops & Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #fff6f7; font-family: 'Inter', sans-serif; }
        .container { max-width: 1000px; margin: 2rem auto; }
        .shop-card { background: #fff; border-radius: 20px; box-shadow: 0 4px 16px #e1575a22; padding: 2rem; margin-bottom: 2rem; }
        .shop-title { color: #e1575a; font-weight: bold; }
        .product-img { max-width: 80px; border-radius: 10px; }
        .btn-edit { background: #e1575a; color: #fff; border-radius: 20px; font-weight: 600; }
        .btn-edit:hover { background: #ed6a6a; }
        .btn-secondary { background: #e1575a; color: #fff; border-radius: 20px; font-weight: 600; }
        .btn-home {
            background: #fff;
            color: #e1575a;
            border-radius: 20px;
            font-weight: 600;
            border: 2px solid #e1575a;
            transition: background 0.2s, color 0.2s;
            padding: 0.5rem 1.5rem;
            margin-top: 1rem;
            display: inline-block;
        }
        .btn-home:hover {
            background: #e1575a;
            color: #fff;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="mb-4" style="color:#e1575a;">Manage My Shops & Products</h2>
    <?php if (empty($shops)): ?>
        <div  style="background-color:rgb(246, 159, 159);"class="alert alert-info">You don't own any shops yet.</div>
    <?php else: ?>
        <?php foreach ($shops as $shop): ?>
            <div class="shop-card">
                <h4 class="shop-title"><?= htmlspecialchars($shop['name']) ?></h4>
                <p><?= htmlspecialchars($shop['description']) ?></p>
                <h5>Products</h5>
                <?php
                $products = $connection->prepare("SELECT * FROM products WHERE shop_id = ?");
                $products->execute([$shop['id']]);
                $products = $products->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <?php if (empty($products)): ?>
                    <div class="alert alert-warning">No products in this shop.</div>
                <?php else: ?>
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price (R)</th>
                                <th>Stock</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td>
                                    <?php if ($product['image']): ?>
                                        <img src="<?= htmlspecialchars($product['image']) ?>" class="product-img" alt="Product Image">
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($product['name']) ?></td>
                                <td><?= number_format($product['price'], 2) ?></td>
                                <td><?= (int)$product['stock_quantity'] ?></td>
                                <td>
                                    <a href="edit_product.php?id=<?= $product['id'] ?>" class="btn btn-edit btn-sm">Edit</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <a href="index.php" class="btn btn-home mt-3">&larr; Back to Home</a>
</div>
</body>
</html>