<?php
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Welcome to GlamConnect</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    /* Quick GlamConnect welcome style */
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(to right,rgb(255, 149, 149),rgb(245, 178, 178));
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .welcome-box {
      text-align: center;
      background: white;
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 8px 20px rgba(127, 123, 123, 0.1);
    }

    .welcome-box h1 {
      font-size: 2.5rem;
      color:rgb(230, 122, 122);
    }

    .welcome-box p {
      font-size: 1.2rem;
      color: #333;
    }
  </style>
</head>
<body>

  <div class="welcome-box">
    <h1>Welcome back, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>!</h1>
    <p>Redirecting to your GlamConnect dashboard...</p>
  </div>

  <script>
    setTimeout(function () {
      window.location.href = "index.php";
    }, 3000); // 3000 ms = 3 seconds
  </script>

</body>
</html>
