<?php 
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: blog.php");
    exit();
}

$error = '';
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Modern Blog</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Additional Background and Overlay */
      
        :root {
            --dark-bg: #121212;
            --darker-bg: #0a0a0a;
            --card-bg: #1e1e1e;
            --accent: #6c5ce7;
            --text: #e0e0e0;
            --light-gray: #333333;
            --border: #444444;
        }
        body {
          background-image: url('images/image.jpg');
          background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', sans-serif;
            color: var(--text);
        }
        
        .auth-container {
            width: 100%;
            max-width: 400px;
            padding: 0 20px;
        }
        
        .auth-card {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            border: 1px solid var(--border);
        }
        
        .auth-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .auth-title {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 8px;
            background: linear-gradient(to right, #6c5ce7, #a29bfe);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .auth-subtitle {
            color: #b0b0b0;
            font-size: 14px;
        }
        
        .input-group {
            margin-bottom: 20px;
        }
        
        .auth-input {
            width: 100%;
            padding: 14px 16px;
            background: var(--light-gray);
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 15px;
            color: var(--text);
            transition: all 0.3s ease;
        }
        
        .auth-input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(108, 92, 231, 0.2);
        }
        
        .auth-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(to right, #6c5ce7, #a29bfe);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .auth-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(108, 92, 231, 0.3);
        }
        
        .auth-footer {
            margin-top: 25px;
            text-align: center;
            font-size: 14px;
            color: #b0b0b0;
        }
        
        .auth-link {
            color: #a29bfe;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .auth-link:hover {
            color: #6c5ce7;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1 class="auth-title">Create Account</h1>
                <p class="auth-subtitle">Join our creative community</p>
                
                <?php if($error): ?>
                    <div class="error-message"><?= $error ?></div>
                <?php endif; ?>
            </div>
            
            <form method="POST" action="includes/auth.php">
                <div class="input-group">
                    <input type="text" class="auth-input" name="username" placeholder="Username" required>
                </div>
                
                <div class="input-group">
                    <input type="email" class="auth-input" name="email" placeholder="Email" required>
                </div>
                
                <div class="input-group">
                    <input type="password" class="auth-input" name="password" placeholder="Password" required>
                </div>
                
                <button type="submit" class="auth-btn" name="register-btn">
                    <i class="fas fa-user-plus"></i> Register
                </button>
            </form>
            
            <div class="auth-footer">
                Already have an account? <a href="index.php" class="auth-link">Sign In</a>
            </div>
        </div>
    </div>
</body>
</html>
