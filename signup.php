<?php
session_start();
require_once('config.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form inputs
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $role = $_POST['role'] ?? '';
    $created_at = date('Y-m-d H:i:s');

    // Validate role was selected via JS (or fallback)
    if (empty($role)) {
        echo "<div class='msg error'>Please select a role (Buyer or Seller).</div>";
        exit;
    }

    // Validate passwords match
    if ($password !== $confirm_password) {
        echo "<div class='msg error'>Passwords do not match!</div>";
        exit;
    }

    // Hash the password
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    // Check if email already exists
    $query = $connection->prepare("SELECT * FROM users WHERE email = :email");
    $query->bindParam(":email", $email, PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount() > 0) {
        echo "<div class='msg error'>The email address is already registered!</div>";
    } else {
        // Insert new user
        $query = $connection->prepare("INSERT INTO users (username, email, password, role, created_at) VALUES (:username, :email, :password, :role, :created_at)");
        $query->bindParam(":username", $name, PDO::PARAM_STR);
        $query->bindParam(":email", $email, PDO::PARAM_STR);
        $query->bindParam(":password", $password_hash, PDO::PARAM_STR);
        $query->bindParam(":role", $role, PDO::PARAM_STR);
        $query->bindParam(":created_at", $created_at, PDO::PARAM_STR);

        if ($query->execute()) {
            // Styled success message and redirect after 2 seconds
            echo "
            <style>
                .msg.success {
                    background: #fff6f7;
                    color: #e1575a;
                    border: 2px solid #e1575a;
                    border-radius: 20px;
                    padding: 1.2rem 2rem;
                    font-size: 1.2rem;
                    text-align: center;
                    margin: 2rem auto;
                    max-width: 400px;
                    font-weight: bold;
                    box-shadow: 0 4px 16px #e1575a22;
                }
            </style>
            <div class='msg success'>Your registration was successful!<br>Redirecting to login...</div>
            <script>
                setTimeout(function() {
                    window.location.href = 'login.php';
                }, 2000);
            </script>
            ";
            exit;
        } else {
            echo "<div class='msg error'>Registration failed. Please try again.</div>";
        }
    }
}
?>



