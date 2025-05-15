<?php
session_start();
include('config.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form inputs
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $role = $_POST['role'] ?? '';

    // Validate role was selected via JS (or fallback)
    if (empty($role)) {
        echo "<p class='error'>Please select a role (Buyer or Seller).</p>";
        exit;
    }

    // Validate passwords match
    if ($password !== $confirm_password) {
        echo "<p class='error'>Passwords do not match!</p>";
        exit;
    }

    // Hash the password
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    // Check if email already exists
    $query = $connection->prepare("SELECT * FROM users WHERE email = :email");
    $query->bindParam(":email", $email, PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount() > 0) {
        echo "<p class='error'>The email address is already registered!</p>";
    } else {
        // Insert new user
        $query = $connection->prepare("INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password_hash, :role)");
        $query->bindParam(":username", $name, PDO::PARAM_STR);
        $query->bindParam(":email", $email, PDO::PARAM_STR);
        $query->bindParam(":password_hash", $password_hash, PDO::PARAM_STR);
        $query->bindParam(":role", $role, PDO::PARAM_STR);

        if ($query->execute()) {
            echo "<p class='success'>Your registration was successful!</p>";
            // Optionally redirect:
            // header("Location: login.html");
            // exit;
        } else {
            echo "<p class='error'>Registration failed. Please try again.</p>";
        }
    }
}
?>



