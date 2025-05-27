<?php

session_start();
require_once('../config.php');

// Only allow admins
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

if (!isset($_GET['user_id'])) {
    echo "No user selected.";
    exit;
}

$user_id = intval($_GET['user_id']);

// Fetch user info
$stmt = $connection->prepare("SELECT username, email FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "User not found.";
    exit;
}

// Fetch orders
$orderStmt = $connection->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$orderStmt->execute([$user_id]);
$orders = $orderStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Order History for <?= htmlspecialchars($user['username']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Order History for <?= htmlspecialchars($user['username']) ?> (<?= htmlspecialchars($user['email']) ?>)</h2>
    <a href="manage_user.php" class="btn btn-secondary mb-3">&larr; Back to User Management</a>
    <?php if (count($orders) === 0): ?>
        <div class="alert alert-info">This user has not placed any orders.</div>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Shop</th>
                    <th>Total</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($orders as $order):
                // Get shop name
                $shop = $connection->prepare("SELECT name FROM shops WHERE id = ?");
                $shop->execute([$order['shop_id']]);
                $shop_name = $shop->fetchColumn();
            ?>
                <tr>
                    <td><?= $order['id'] ?></td>
                    <td><?= htmlspecialchars($shop_name) ?></td>
                    <td>R<?= number_format($order['total'], 2) ?></td>
                    <td><?= date('Y-m-d', strtotime($order['created_at'])) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
</body>
</html>