<?php
require_once 'includes/config.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Fetch featured post
$featuredQuery = $pdo->query("
    SELECT b.*, u.username 
    FROM blogs b 
    JOIN users u ON b.user_id = u.user_id 
    ORDER BY b.created_at DESC 
    LIMIT 1
");
$featuredPost = $featuredQuery->fetch();

// Fetch other posts
$postsQuery = $pdo->query("
    SELECT b.*, u.username 
    FROM blogs b 
    JOIN users u ON b.user_id = u.user_id 
    ORDER BY b.created_at DESC 
    LIMIT 1, 100
");
$posts = $postsQuery->fetchAll();

$imageArray = [
    'images/image1.jpg',
    'images/image2.jpg',
    'images/image3.jpg',
    'images/image4.jpg',
    'images/image5.jpg',
    'images/image6.jpg'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header class="blog-header">
        <div class="nav-container">
            <a href="blog.php" class="logo">EVERYTHING TECH</a>
            <nav>
                <a href="createBlog.php" class="btn">
                    <i class="fas fa-plus"></i> New Post
                </a>
                <a href="logout.php" class="btn" style="margin-left: 10px; background-color: #dc3545;">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </nav>
        </div>
    </header>

    <main class="main-container">
        <?php if ($featuredPost): ?>
        <article class="featured-post">
            <div class="featured-image">
                <img src="<?= $imageArray[array_rand($imageArray)] ?>" alt="Featured Post">
            </div>
            <div class="featured-content">
                <span class="featured-category">Featured</span>
                <h1 class="featured-title"><?= htmlspecialchars($featuredPost['title']) ?></h1>
                <p class="featured-excerpt"><?= substr(htmlspecialchars($featuredPost['content']), 0, 150) ?>...</p>
                <div class="card-meta">
                    <span>By <?= htmlspecialchars($featuredPost['username']) ?></span>
                    <span><?= date('F j, Y', strtotime($featuredPost['created_at'])) ?></span>
                </div>
                <a href="includes/post.php?id=<?= $featuredPost['blog_id'] ?>" class="btn">Read More</a>
            </div>
        </article>
        <?php endif; ?>

        <section class="blog-grid">
            <?php foreach ($posts as $post): ?>
            <article class="blog-card">
                <div class="card-image">
                    <img src="<?= $imageArray[array_rand($imageArray)] ?>" alt="Blog Post">
                </div>
                <div class="card-content">
                    <span class="card-category">Technology</span>
                    <h2 class="card-title"><?= htmlspecialchars($post['title']) ?></h2>
                    <p class="card-excerpt"><?= substr(htmlspecialchars($post['content']), 0, 100) ?>...</p>
                    <div class="card-meta">
                        <span>By <?= htmlspecialchars($post['username']) ?></span>
                        <span><?= date('M j, Y', strtotime($post['created_at'])) ?></span>
                    </div>
                    <a href="includes/post.php?id=<?= $post['blog_id'] ?>" class="btn">Read More</a>
                </div>
            </article>
            <?php endforeach; ?>
        </section>
    </main>

    <script src="assets/script.js"></script>
</body>
</html>
