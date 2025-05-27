<?php

session_start();
require_once('../config.php');

// Only allow admins
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: Login.php");
    exit();
}

// Handle status update
if (isset($_POST['update_status'])) {
    $order_id = intval($_POST['order_id']);
    $new_status = $_POST['new_status'];
    $connection->prepare("UPDATE orders SET order_status = ? WHERE id = ?")->execute([$new_status, $order_id]);
    $success = "Order #$order_id status updated to $new_status.";
}

// Fetch all orders with user and shop info
$orders = $connection->query(
    "SELECT o.*, u.username, u.email, s.name AS shop_name 
     FROM orders o
     JOIN users u ON o.user_id = u.id
     JOIN shops s ON o.shop_id = s.id
     ORDER BY o.created_at DESC"
)->fetchAll(PDO::FETCH_ASSOC);

// Possible statuses
$statuses = ['Pending', 'Confirmed', 'Shipped', 'Delivered', 'Cancelled'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Orders - Admin | GlamConnect</title>
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
        .admin-container {
            max-width: 1200px;
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
        .btn-dashboard {
            background: var(--color-primary);
            color: #fff;
            border-radius: 20px;
            font-weight: 600;
            border: none;
            margin-bottom: 1.5rem;
            transition: background 0.2s;
        }
        .btn-primary {
            background:#e48286;
            color: #fff;
            border-radius: 20px;
            font-weight: 600;
            border: none;
            transition: background 0.2s;
        }
        .btn-dashboard:hover {
            background: var(--color-secondary);
            color: #fff;
        }
        .table thead th {
            background: var(--color-primary);
            color: #fff;
            border-color: var(--color-primary);
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
        .form-select{
            color: var(--color-secondary);
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
<div class="admin-container">
    <a href="admin.php" class="btn btn-dashboard mb-3">&larr; Back to Dashboard</a>
    <h2 class="mb-4">Manage Orders</h2>
    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>User</th>
                    <th>Email</th>
                    <th>Shop</th>
                    <th>Total (R)</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Commission (15%)</th>
                    <th>Update Status</th>
                    <th>Delivery Method</th>
                    <th>Delivery Cost</th>
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
                    <td><?= htmlspecialchars($order['payment_method'] ?? 'Card') ?></td>
                    <td>
                        <span class="badge bg-info text-dark"><?= htmlspecialchars($order['order_status']) ?></span>
                    </td>
                    <td><?= date('Y-m-d', strtotime($order['created_at'])) ?></td>
                    <td>R<?= number_format($order['commission'], 2) ?></td>
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
                    <td><?= htmlspecialchars($order['delivery_method']) ?></td>
                    <td>R<?= number_format($order['delivery_cost'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>