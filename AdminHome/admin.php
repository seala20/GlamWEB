<?php 
session_start();

// Security check
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: Login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | GlamConnect</title>
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

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color:rgb(249, 243, 243);
            color: var(--color-body-darker);
            margin: 0;
        }

        .hero {
            background: linear-gradient(rgba(255, 127, 133, 0.8), rgba(255, 127, 133, 0.8)),
            url('images/hero2.jpg');
            background-position: center;
            background-size: cover;
            color: white;
            padding: 4rem 2rem;
            text-align: center;
            border-radius: 0 0 var(--border-radius) var(--border-radius);
        }

        .hero h1 {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 6rem;
            font-weight: 700 !important;
            margin-bottom: 1rem;
        }

        .admin-section {
            margin-top: 2rem;
        }

        .admin-header {
            background-image: url('../images/APPLE.jpg');
            background-size: center;           /* Ensures the image covers the area */
            background-position: center;      /* Centers the image */
            background-repeat:repeat;     /* Prevents tiling */
            color: white;
            padding: 4rem 2rem;
            border-radius: var(--border-radius);
            margin-bottom: 2rem;
            min-height: 350px;                /* Adjust as needed for your design */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            border-radius: var(--border-radius);
            border: none;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease;
            background-color: rgb(239, 178, 178);
            color:white;
            text-align: center;
            padding: 2rem;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-title {
            color: white;
        }

        .btn-primary {
            background-color:rgb(219, 139, 139);
            border: none;
            border-radius: 20px;
        }

        .btn-primary:hover {
            background-color: var(--color-accent);
        }

        .admin-subtitle {
            font-size: 2rem;
            font-weight: 300;
            font-style: italic;
            font-family: 'Times New Roman', Times, serif;
            text-shadow: 2px 2px 7px #e48286;
            margin-top: 2rem;         /* Adjust as needed for spacing */
            margin-bottom: 2rem;
            text-align: center;
            line-height: 1.3;
            display: block;
        }

        .admin-big-card {
            min-height: 260px;
            font-size: 1.25rem;
            border-radius: var(--border-radius);
        }
        @media (min-width: 768px) {
            .admin-big-card {
                min-height: 320px;
                font-size: 1.35rem;
            }
        }
    </style>
</head>
<body>
<!-- Back to Website Button -->
<div class="text-end" style="padding: 2rem;">
    <a href="../index.php" class="btn btn-outline-primary" style="background: #fff; color: var(--color-secondary); border-radius: 20px; font-weight: 600; border: 2px solid var(--color-secondary);">
        &larr; Back to Website
    </a>
</div>

<div class="admin-header text-center">
    <div style="padding: 2rem; border-radius: var(--border-radius); color: white;">
        <h1 style="font-size: 4rem; font-weight: 600; letter-spacing: 2px; color: white; text-shadow: 2px 2px 8px #e1575a;">
            Welcome, GlamConnect Admin
        </h1>
        <p class="admin-subtitle">Manage your marketplace like the boss you are.</p>
    </div>
</div>


    <!-- Admin Tools Section -->
    <div class="container admin-section">
    <div class="row g-4 justify-content-center">
        <!-- Manage Shops -->
        <div class="col-12 col-md-4 d-flex">
            <div class="card p-4 text-center flex-fill admin-big-card">
                <h3 class="card-title">Manage Shops</h3>
                <p class="card-text">Review and remove shops violating policies.</p>
                <a href="manage_shops.php" class="btn btn-primary mt-2">Go to Shops</a>
            </div>
        </div>
        <!-- Manage Users -->
        <div class="col-12 col-md-4 d-flex">
            <div class="card p-4 text-center flex-fill admin-big-card">
                <h3 class="card-title">Manage Users</h3>
                <p class="card-text">View users and restrict access if necessary.</p>
                <a href="manage_user.php" class="btn btn-primary mt-2">Go to Users</a>
            </div>
        </div>
        <!-- View Shops -->
        <div class="col-12 col-md-4 d-flex">
            <div class="card p-4 text-center flex-fill admin-big-card">
                <h3 class="card-title">View Shops</h3>
                <p class="card-text">Browse all public shops in the marketplace.</p>
                <a href="view_shops.php" class="btn btn-primary mt-2">View Shops</a>
            </div>
        </div>
        <!-- Manage Orders -->
        <div class="col-12 col-md-6 d-flex">
            <div class="card p-4 text-center flex-fill admin-big-card">
                <h3 class="card-title">Manage Orders</h3>
                <p class="card-text">View, track, and update all orders placed on GlamConnect.</p>
                <a href="manage_orders.php" class="btn btn-primary mt-2">Go to Orders</a>
            </div>
        </div>
        <!-- Manage Payments -->
        <div class="col-12 col-md-6 d-flex">
            <div class="card p-4 text-center flex-fill admin-big-card">
                <h3 class="card-title">Manage Payments</h3>
                <p class="card-text">View platform earnings and seller commissions.</p>
                <a href="manage_payment.php" class="btn btn-primary mt-2">Go to Payments</a>
            </div>
        </div>
    </div>
</div>
        </div>
</body>
</html>
</body>
</html>
