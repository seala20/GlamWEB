<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Choose Dashboard</title>
    <style>
        body { font-family: 'Inter', sans-serif; background: #fff6f7; text-align: center; padding-top: 5rem; }
        .btn { background: #e1575a; color: #fff; border: none; border-radius: 20px; padding: 1rem 2.5rem; font-size: 1.2rem; margin: 1rem; text-decoration: none; display: inline-block; }
        .btn:hover { background: #ed6a6a; }
    </style>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <p>Where would you like to go?</p>
    <a href="AdminHome/admin.php" class="btn">Admin Dashboard</a>
    <a href="index.php" class="btn">User Homepage</a>
</body>
</html>