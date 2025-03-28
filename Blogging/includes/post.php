<?php
require_once 'config.php';

// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

// Ensure a valid post ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: ../blog.php");
    exit();
}

$postId = intval($_GET['id']);

// Fetch the post from the database
$stmt = $pdo->prepare("
    SELECT b.*, u.username 
    FROM blogs b 
    JOIN users u ON b.user_id = u.user_id 
    WHERE b.blog_id = ?
");
$stmt->execute([$postId]);
$post = $stmt->fetch();

// If post does not exist, redirect to blog
if (!$post) {
    header("Location: ../blog.php");
    exit();
}

// Random image selection for the post
$imageArray = [
    '../images/image1.jpg',
    '../images/image2.jpg',
    '../images/image3.jpg',
    '../images/image4.jpg',
    '../images/image5.jpg',
    '../images/image6.jpg'
];
$selectedImage = $imageArray[array_rand($imageArray)];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($post['title']) ?></title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .post-container {
            max-width: 800px;
            background: white;
            margin: 20px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .post-title {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }
        .post-meta {
            color: #777;
            font-size: 14px;
            margin-bottom: 15px;
        }
        .post-image {
            width: 100%;
            max-height: 350px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 15px;
        }
        .post-body {
            font-size: 18px;
            line-height: 1.6;
            color: #444;
            margin-bottom: 20px;
        }
        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            transition: 0.3s;
        }
        .back-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="post-container">
        <img src="<?= $selectedImage ?>" alt="Blog Image" class="post-image">
        <h1 class="post-title"><?= htmlspecialchars($post['title']) ?></h1>
        <div class="post-meta">
            <span>By <?= htmlspecialchars($post['username']) ?></span> | 
            <span><?= date('F j, Y', strtotime($post['created_at'])) ?></span>
        </div>
        <p class="post-body"><?= nl2br(htmlspecialchars($post['content'])) ?></p>
        <a href="../blog.php" class="back-btn">← Back to Blog</a>
    </div>
</body>
</html>
