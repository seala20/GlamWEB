<?php
session_start();
include('config.php'); // Database connection (PDO)

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch user by email
    $query = $connection->prepare("SELECT * FROM users WHERE email = :email");
    $query->bindParam(":email", $email, PDO::PARAM_STR);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Save common session info
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Check if this user is also in the admin table
        $adminCheck = $connection->prepare("SELECT * FROM admin WHERE user_id = :user_id");
        $adminCheck->bindParam(":user_id", $user['id'], PDO::PARAM_INT);
        $adminCheck->execute();

        if ($adminCheck->rowCount() > 0) {
            $_SESSION['is_admin'] = true;
            // If you want to choose, redirect to a choice page:
            header("Location: choose_dashboard.php");
            exit();
        } else {
            $_SESSION['is_admin'] = false;
            header("Location: welcome.php");
            exit();
        }
    } else {
        echo '<p style="color:red;text-align:center;">Incorrect email or password.</p>';
        header("refresh:2;url=loginPage.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - GlamConnect</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <!-- Include Bootstrap Icons -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"
      rel="stylesheet"
    />
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
        background: #f3b2b6;
        font-family: "Segoe UI", sans-serif;
      }

      .login-container {
        max-width: 500px;
        margin: 50px auto;
        padding: 30px;
        background: #fff;
        border-radius: var(--border-radius);
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--color-border);
      }

      .brand-title {
        font-size: 2rem;
        font-weight: bold;
        color: var(--color-accent);
        text-align: center;
        margin-bottom: 10px;
      }

      .brand-tagline {
        text-align: center;
        color: var(--color-body);
        margin-bottom: 20px;
      }

      label {
        color: var(--color-body-darker);
      }

      .form-control {
        border-radius: var(--border-radius);
        border: 1px solid var(--color-border);
      }

      .btn-glam {
        background-color: var(--color-accent);
        color: #fff;
        border-radius: var(--border-radius);
        border: none;
      }

      .btn-glam:hover {
        background-color: var(--color-secondary);
      }

      a {
        color: var(--color-secondary);
      }

      a:hover {
        color: var(--color-accent);
      }

      input[type="email"]:focus,
      input[type="password"]:focus {
        border-color: #e1575a;
        outline: 0;
        box-shadow: 0 0 0 4px #ff7f85;
      }

      .input-group-text {
        cursor: pointer;
      }
    </style>
  </head>
  <body>
    <div class="login-container">
      <div class="brand-title">GlamConnect</div>
      <div class="brand-tagline">
        Welcome back — Log in to your glam account!
      </div>

      <form action="login.php" method="POST">
        <?php if (!empty($error)): ?>
  <div class="alert alert-danger text-center"><?php echo $error; ?></div>
<?php endif; ?>

        <div class="mb-3">
          <label for="email" class="form-label">Email Address</label>
          <input
            type="email"
            class="form-control"
            id="email"
            name="email"
            required
          />
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <div class="input-group">
            <input
              type="password"
              class="form-control"
              id="password"
              name="password"
              required
            />
            <span class="input-group-text" id="toggle-password">
              <i class="bi bi-eye-slash" id="eye-icon"></i>
              <!-- Eye icon for hiding -->
            </span>
          </div>
        </div>

        <button type="submit" class="btn btn-glam w-100">Log In</button>

        <div class="mt-3 text-center">
          Don’t have an account? <a href="SignUpPage.php">Sign up here</a>
        </div>
        <div class="mt-3 text-center">
          <a href="index.php">Back to Home</a>
        </div>
      </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      // Toggle password visibility
      document
        .getElementById("toggle-password")
        .addEventListener("click", function () {
          let passwordField = document.getElementById("password");
          let eyeIcon = document.getElementById("eye-icon");

          if (passwordField.type === "password") {
            passwordField.type = "text";
            eyeIcon.classList.remove("bi-eye-slash");
            eyeIcon.classList.add("bi-eye");
          } else {
            passwordField.type = "password";
            eyeIcon.classList.remove("bi-eye");
            eyeIcon.classList.add("bi-eye-slash");
          }
        });
    </script>
  </body>
</html>
