<?php
require_once('../config.php');

// Handle removal (soft delete: set active=0)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove'])) {
    $shop_id = (int)$_POST['remove'];
    $stmt = $connection->prepare("UPDATE shops SET active=0 WHERE id=?");
    $stmt->execute([$shop_id]);
    header("Location: manage_shops.php");
    exit;
}

$stmt = $connection->query("SELECT * FROM shops");
$shops = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Shops | GlamConnect Admin</title>
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

        body { background: #fff6f7; font-family: 'Inter', sans-serif; }
        .shop-table { width: 80%; margin: 2rem auto; border-collapse: collapse; }
        .shop-table th, .shop-table td { padding: 1rem; border-bottom: 1px solid #e48286; }
        .shop-table th { background: #e1575a; color: #fff; }
        h1 { text-align: center; color: #e1575a; margin-top: 2rem; }
    </style>
</head>
<body>
    <h1>Manage Shops</h1>
    <table class="shop-table">
        <tr>
            <th>Shop Name</th>
            <th>Description</th>
            <th>Created At</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php foreach ($shops as $shop): ?>
        <tr>
            <td><?= htmlspecialchars($shop['name']) ?></td>
            <td><?= htmlspecialchars($shop['description']) ?></td>
            <td><?= htmlspecialchars($shop['created_at']) ?></td>
            <td><?= $shop['active'] ? 'Active' : 'Inactive' ?></td>
            <td>
                <?php if ($shop['active']): ?>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="remove" value="<?= $shop['id'] ?>">
                    <button type="submit" class="remove-btn" onclick="return confirm('Remove this shop?')">Remove</button>
                </form>
                <?php else: ?>
                    <span style="color:#aaa;">Removed</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>