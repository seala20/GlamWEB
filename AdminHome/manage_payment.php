<?php
// filepath: c:\xampp\htdocs\GlamWEB\AdminHome\manage_payment.php
session_start();
require_once('../config.php');
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: Login.php");
    exit();
}

// Total commission earned
$total_commission = $connection->query("SELECT SUM(commission) FROM orders")->fetchColumn();

// Commission per shop
$shop_commissions = $connection->query("
    SELECT s.name, SUM(o.commission) as commission_total
    FROM orders o
    JOIN shops s ON o.shop_id = s.id
    GROUP BY o.shop_id
")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Payments - Admin</title>
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
        body { background: #fff6f7; font-family: 'Inter', sans-serif; }
        .admin-container { max-width: 900px; margin: 3rem auto; background: #fff; border-radius: var(--border-radius); box-shadow: 0 4px 24px #e1575a22; padding: 2.5rem 2rem; }
        h2 { color: var(--color-headings); font-weight: bold; }
        .badge, .badge--primary, .badge--secondary { background: var(--color-primary); color: #fff; border-radius: 12px; padding: 0.2em 0.8em; font-size: 1em; }
        .badge--secondary { background: var(--color-secondary); }
        .badge-small { font-size: 0.85em; padding: 0.1em 0.5em; }
    </style>
</head>
<body>
<div class="admin-container">
    <a href="admin.php" class="btn btn-dashboard mb-3">&larr; Back to Dashboard</a>
    <h2 class="mb-4">Manage Payments & Platform Earnings</h2>
    <div class="mb-4">
        <span class="badge badge--primary badge-large">Platform Commission Rate: 15%</span>
        <span class="badge badge--secondary badge-large ms-2">Total Earned: R<?= number_format($total_commission, 2) ?></span>
    </div>
    <h4>Commission Earned Per Shop</h4>
    <table class="table table-bordered align-middle">
        <thead>
            <tr>
                <th>Shop Name</th>
                <th>Total Commission (R)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($shop_commissions as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td>R<?= number_format($row['commission_total'], 2) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>