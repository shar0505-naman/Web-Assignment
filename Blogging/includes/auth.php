<?php
session_start();
require_once 'config.php';

// Handle Registration
if (isset($_POST['register-btn'])) {
    try {
        $username = sanitizeInput($_POST['username']);
        $email = sanitizeInput($_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Check if user already exists
        $stmt = $pdo->prepare("SELECT user_id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        
        if ($stmt->rowCount() > 0) {
            $_SESSION['error'] = "Username or email already exists";
            header("Location: ../register.php");
            exit();
        }

        // Create new user
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $password]);

        // Successful registration
        $_SESSION['success'] = "Registration successful! Please login.";
        header("Location: ../index.php");
        exit();

    } catch(PDOException $e) {
        $_SESSION['error'] = "Registration error: " . $e->getMessage();
        header("Location: ../register.php");
        exit();
    }
}

// Handle Login
if (isset($_POST['login-btn'])) {
    try {
        $login = sanitizeInput($_POST['login']);
        $password = $_POST['password'];

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$login, $login]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            header("Location: ../blog.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid username/email or password";
            header("Location: ../index.php");
            exit();
        }
    } catch(PDOException $e) {
        $_SESSION['error'] = "Login error: " . $e->getMessage();
        header("Location: ../index.php");
        exit();
    }
}
?>