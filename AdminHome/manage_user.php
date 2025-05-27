<?php

session_start();
require_once('../config.php');

// Only allow admins
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: ../Login.php');
    exit;
}

// Handle delete
if (isset($_GET['delete'])) {
    $del_id = intval($_GET['delete']);
    $connection->prepare("DELETE FROM users WHERE id = ?")->execute([$del_id]);
    header('Location: manage_user.php');
    exit;
}

// Fetch all users
$users = $connection->query("SELECT id, username, email, role FROM users")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Users - Admin</title>
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

        /* Table header */
        .table thead th {
            background: var(--color-primary) !important;
            color: #fff !important;
            border-color: var(--color-primary) !important;
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
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0" style="color: var(--color-headings); font-weight: bold;">Manage Users</h2>
        <a href="admin.php" class="btn btn-dashboard">&larr; Back to Dashboard</a>
    </div>
    <div class="table-responsive">
    <table class="table table-bordered align-middle">
        <thead>
            <tr>
                <th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Owns Shop?</th><th>Order History</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <?php
            // Check if user owns a shop
            $shopStmt = $connection->prepare("SELECT COUNT(*) FROM shops WHERE user_id = ?");
            $shopStmt->execute([$user['id']]);
            $ownsShop = $shopStmt->fetchColumn() > 0;

            // Fetch order count
            $orderStmt = $connection->prepare("SELECT COUNT(*) FROM orders WHERE user_id = ?");
            $orderStmt->execute([$user['id']]);
            $orderCount = $orderStmt->fetchColumn();
            ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= htmlspecialchars($user['role']) ?></td>
                <td>
                    <?php if ($ownsShop): ?>
                        <span class="shop-badge">Yes</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">No</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($orderCount > 0): ?>
                        <a href="view_user_orders.php?user_id=<?= $user['id'] ?>" class="btn btn-sm btn-info">View (<?= $orderCount ?>)</a>
                    <?php else: ?>
                        <span class="badge bg-secondary">None</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="?delete=<?= $user['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this user?')">Delete</a>
                    <!-- Add edit/change role links here -->
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</div>
</body>
</html>