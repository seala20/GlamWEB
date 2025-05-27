<?php

session_start();
require_once('config.php');

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Check if the user owns a shop
$shopStmt = $connection->prepare("SELECT COUNT(*) FROM shops WHERE user_id = ?");
$shopStmt->execute([$user_id]);
$ownsShop = $shopStmt->fetchColumn() > 0;

// Handle avatar upload
$upload_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatar'])) {
    $avatar = $_FILES['avatar'];
    if ($avatar['error'] === UPLOAD_ERR_OK){
        $ext = pathinfo($avatar['name'], PATHINFO_EXTENSION);
        $filename = 'avatars/user_' . $user_id . '.' . $ext;
        if (!is_dir('avatars')) mkdir('avatars');
        if (move_uploaded_file($avatar['tmp_name'], $filename)) {
            // Save filename to DB
            $stmt = $connection->prepare("UPDATE users SET avatar = ? WHERE id = ?");
            $stmt->execute([$filename, $user_id]);
            $upload_message = "<div class='alert alert-success'>Profile picture updated!</div>";
        } else {
            $upload_message = "<div class='alert alert-danger'>Failed to upload image. Check folder permissions.</div>";
        }
    } else {
        $upload_message = "<div class='alert alert-danger'>No file selected or upload error.</div>";
    }
}

// Fetch user info (including avatar)
$stmt = $connection->prepare("SELECT username, email, avatar FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch past orders (same as before)
$orders = $connection->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$orders->execute([$user_id]);
$orders = $orders->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Profile - GlamConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #fff6f7; font-family: 'Inter', sans-serif; }
        .profile-card { max-width: 600px; margin: 2rem auto; background: #fff; border-radius: 20px; box-shadow: 0 4px 16px #e1575a22; padding: 2rem; }
        .profile-header { color: #e1575a; font-weight: bold; }
        .logout-link { color: #e1575a; font-weight: bold; text-decoration: none; }
        .logout-link:hover { text-decoration: underline; }
        .order-table th, .order-table td { vertical-align: middle; }
        .avatar {
            width: 110px; height: 110px; border-radius: 50%;
            object-fit: cover; border: 4px solid #e1575a; margin-bottom: 1rem;
            display: block; margin-left: auto; margin-right: auto;
        }
        .avatar-upload { text-align: center; margin-bottom: 1rem; }
        .avatar-upload input[type="file"] { display: none; }
        .avatar-upload label {
            background: #e1575a; color: #fff; padding: 0.4em 1.2em; border-radius: 20px;
            cursor: pointer; font-size: 1rem; font-weight: 500; margin-top: 0.5rem; display: inline-block;
        }
        .btn-primary {
            background: #e1575a; color: #fff; border-radius: 20px; font-weight: 600;
            border: none; margin-top: 1rem; padding: 0.5em 1.5em; text-decoration: none;
        }
        .btn-primary:hover {
            background: #ed6a6a; color: #fff; text-decoration: none;
        }
        .btn-home {
            background: #fff;
            color: #e1575a;
            border-radius: 20px;
            font-weight: 600;
            border: 2px solid #e1575a;
            transition: background 0.2s, color 0.2s;
            padding: 0.5rem 1.5rem;
            margin-bottom: 1rem;
            display: inline-block;
            text-decoration: none;
            
        }
        .btn-home:hover {
            background: #e1575a;
            color: #fff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="profile-card">
        <!-- Avatar Display and Upload -->
        <div class="avatar-upload">
            <img src="<?= $user['avatar'] ? htmlspecialchars($user['avatar']) : 'https://ui-avatars.com/api/?name=' . urlencode($user['username']) . '&background=e1575a&color=fff&size=110' ?>" class="avatar" alt="Profile Picture">
            <form method="post" enctype="multipart/form-data">
                <input type="file" name="avatar" id="avatar" accept="image/*" onchange="this.form.submit()">
                <label for="avatar">Change Profile Picture</label>
            </form>
        </div>
        <h2 class="profile-header mb-4">My Profile</h2>
        <p><strong>Name:</strong> <?= htmlspecialchars($user['username']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        <a href="Logout.php" class="logout-link">Log Out</a>
        <hr>
        <h4 class="mt-4 mb-3">Past Orders</h4>
        <?php if (count($orders) === 0): ?>
            <p>You have not placed any orders yet.</p>
        <?php else: ?>
            <table class="table order-table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Shop</th>
                        <th>Total</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($orders as $order):
                    $shop = $connection->prepare("SELECT name FROM shops WHERE id = ?");
                    $shop->execute([$order['shop_id']]);
                    $shop_name = $shop->fetchColumn();
                ?>
                    <tr>
                        <td><?= $order['id'] ?></td>
                        <td><?= htmlspecialchars($shop_name) ?></td>
                        <td>R<?= number_format($order['total'], 2) ?></td>
                        <td><?= date('Y-m-d', strtotime($order['created_at'])) ?></td>
                        <td><?= htmlspecialchars($order['order_status']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        <?php if ($ownsShop): ?>
            <a href="seller_orders.php" class="btn btn-primary mt-3">Go to Seller Dashboard</a>
        <?php endif; ?>
        <?php if (!empty($upload_message)) echo $upload_message; ?>
        <!-- Back to Home Button at the end -->
        <a href="index.php" class="btn btn-home mt-4">&larr; Back to Home</a>
    </div>
</body>
</html>