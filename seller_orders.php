<?php
session_start();
require_once('config.php');

// Only allow logged-in users
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Handle status update
if (isset($_POST['update_status'])) {
    $order_id = intval($_POST['order_id']);
    $new_status = $_POST['new_status'];
    $stmt = $connection->prepare("UPDATE orders SET order_status = ? WHERE id = ?");
    $stmt->execute([$new_status, $order_id]);
    $success = "Order #$order_id status updated to $new_status.";
}

// Get all shops owned by this user
$shops = $connection->prepare("SELECT id, name FROM shops WHERE user_id = ?");
$shops->execute([$user_id]);
$shop_ids = array_column($shops->fetchAll(PDO::FETCH_ASSOC), 'id');

if (empty($shop_ids)) {
    $orders = [];
} else {
    // Get all orders for these shops
    $in  = str_repeat('?,', count($shop_ids) - 1) . '?';
    $orders_stmt = $connection->prepare(
        "SELECT o.*, u.username, u.email, s.name AS shop_name 
         FROM orders o
         JOIN users u ON o.user_id = u.id
         JOIN shops s ON o.shop_id = s.id
         WHERE o.shop_id IN ($in)
         ORDER BY o.created_at DESC"
    );
    $orders_stmt->execute($shop_ids);
    $orders = $orders_stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Possible statuses for sellers to set
$statuses = ['Shipped', 'Delivered', 'Cancelled'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seller Dashboard - Manage Orders | GlamConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --color-primary: #ff7f85;
            --color-secondary: #e1575a;
            --color-accent: #ed6a6a;
            --color-headings: #e48286;
            --color-body: #918ca4;
            --color-body-darker: #5c5577;
            --color-border: #ccc;
            --border-radius: 30px;
        }

        /* General Button Style */
        .btn,
        .btn-primary,
        .btn-dashboard,
        .btn-danger,
        .btn-info,
        .btn-home,
        .remove-btn {
            background: var(--color-primary) !important;
            color: #fff !important;
            border-radius: 20px !important;
            font-weight: 600 !important;
            border: none !important;
            transition: background 0.2s;
            box-shadow: 0 2px 8px #e1575a22;
        }

        .btn:hover,
        .btn-primary:hover,
        .btn-dashboard:hover,
        .btn-home:hover,
        .remove-btn:hover {
            background: var(--color-secondary) !important;
            color: #fff !important;
        }

        .btn-danger {
            background: var(--color-accent) !important;
        }
        .btn-danger:hover {
            background: var(--color-secondary) !important;
        }

        .btn-info {
            background: var(--color-accent) !important;
        }
        .btn-info:hover {
            background: var(--color-secondary) !important;
        }

        body {
            background: #fff6f7;
            font-family: 'Inter', 'Roboto', sans-serif;
            color: var(--color-body-darker);
        }
        .seller-container {
            max-width: 1100px;
            margin: 3rem auto;
            background: #fff;
            border-radius: var(--border-radius);
            box-shadow: 0 4px 24px rgba(229, 87, 90, 0.08);
            padding: 2.5rem 2rem;
        }
        h2 {
            color: var(--color-headings);
            font-weight: bold;
        }
        .table thead th {
            background: var(--color-primary) !important;
            color: #fff !important;
            border-color: var(--color-primary) !important;
        }
        .form-select, .btn {
            border-radius: 20px;
        }
        .alert-success {
            background: #fff6f7;
            color: #e1575a;
            border: 2px solid #e1575a;
            border-radius: 20px;
            font-weight: bold;
            text-align: center;
        }
        .alert-warning, .alert-info {
            background: #fff6f7;
            color: #e1575a;
            border: 2px solid #e1575a;
            border-radius: 20px;
            font-weight: bold;
            text-align: center;
        }
        
        .alert-info {
            background: #e1f7ff;
            color:#ff7f85;
            border: 2px solid #ed6a6a;
            border-radius: 20px;
            font-weight: bold;
            text-align: center;
        }

        /* Links */
        a, .link-arrow {
            color: var(--color-secondary) !important;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }
        a:hover, .link-arrow:hover {
            color: var(--color-accent) !important;
            text-decoration: underline;
        }

        /* Badges */
        .badge, .shop-badge, .badge.bg-secondary {
            background: var(--color-secondary) !important;
            color: #fff !important;
            border-radius: 12px !important;
            padding: 0.2em 0.8em !important;
            font-size: 0.95em !important;
        }
        .badge.bg-info, .badge.bg-info.text-dark {
            background: var(--color-accent) !important;
            color: #fff !important;
        }
    </style>
</head>
<body>
<div class="seller-container">
    <a href="index.php" class="btn btn-home mb-3">&larr; Back to Home</a>
    <h2 class="mb-4">My Shop Orders</h2>
    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <?php if (empty($shop_ids)): ?>
        <div class="alert alert-warning">You don't own any shops yet.</div>
    <?php elseif (empty($orders)): ?>
        <div style="background-color: #e48286; color: #fff6f7;" class="alert alert-info">No orders have been placed for your shops yet.</div>
    <?php else: ?>
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Buyer</th>
                    <th>Email</th>
                    <th>Shop</th>
                    <th>Total (R)</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Update Status</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= $order['id'] ?></td>
                    <td><?= htmlspecialchars($order['username']) ?></td>
                    <td><?= htmlspecialchars($order['email']) ?></td>
                    <td><?= htmlspecialchars($order['shop_name']) ?></td>
                    <td><?= number_format($order['total'], 2) ?></td>
                    <td>
                        <span class="badge bg-info text-dark"><?= htmlspecialchars($order['order_status']) ?></span>
                    </td>
                    <td><?= date('Y-m-d', strtotime($order['created_at'])) ?></td>
                    <td>
                        <form method="post" class="d-flex gap-2 align-items-center">
                            <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                            <select name="new_status" class="form-select form-select-sm" required>
                                <?php foreach ($statuses as $status): ?>
                                    <option value="<?= $status ?>" <?= $order['order_status'] === $status ? 'selected' : '' ?>>
                                        <?= $status ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" name="update_status" class="btn btn-sm btn-primary">Update</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>
</body>
</html>