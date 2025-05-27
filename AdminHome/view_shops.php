<?php
require_once('../config.php');
$stmt = $connection->query("SELECT * FROM shops");
$shops = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Shops | GlamConnect Admin</title>
    <style>
        body { background: #fff6f7; font-family: 'Inter', sans-serif; }
        .shop-table { width: 80%; margin: 2rem auto; border-collapse: collapse; }
        .shop-table th, .shop-table td { padding: 1rem; border-bottom: 1px solid #e48286; }
        .shop-table th { background: #ff7f85; color: #fff; }
        .active { color: green; font-weight: bold; }
        .inactive { color: #e1575a; font-weight: bold; }
        h1 { text-align: center; color: #e1575a; margin-top: 2rem; }
    </style>
</head>
<body>
    <h1>All Shops</h1>
    <table class="shop-table">
        <tr>
            <th>Shop Name</th>
            <th>Description</th>
            <th>Created At</th>
            <th>Status</th>
        </tr>
        <?php foreach ($shops as $shop): ?>
        <tr>
            <td><?= htmlspecialchars($shop['name']) ?></td>
            <td><?= htmlspecialchars($shop['description']) ?></td>
            <td><?= htmlspecialchars($shop['created_at']) ?></td>
            <td class="<?= $shop['active'] ? 'active' : 'inactive' ?>">
                <?= $shop['active'] ? 'Active' : 'Inactive' ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>