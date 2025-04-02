<?php 
include 'includes/config.php';
if(!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = sanitizeInput($_POST['title']);
    $content = sanitizeInput($_POST['content']);
    $user_id = $_SESSION['user_id'];

    try {
        // Fetch a random image from the images table
        $imageQuery = $pdo->query("SELECT image_filename FROM images ORDER BY RAND() LIMIT 1");
        $image = $imageQuery->fetchColumn(); // Get the image filename

        // Insert the blog post into the database with the random image
        $stmt = $pdo->prepare("INSERT INTO blogs (title, content, user_id, image_filename) VALUES (?, ?, ?, ?)");
        $stmt->execute([$title, $content, $user_id, $image]);

        $_SESSION['success'] = "Post created successfully!";
        header("Location: blog.php");
    } catch(PDOException $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
        header("Location: createBlog.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Blog Post</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Navigation Bar at the top -->
    <nav class="navbar">
        <div class="navbar-content">
            <h2>Create New Post</h2>
            <div>
                <!-- Back Button linking to blog.php -->
                <a href="blog.php" class="btn">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content Container --> 
    <div class="container">
        <div class="editor-container">
            <!-- Form for creating a new blog post -->
            <form method="POST">
                <!-- Input field for blog title -->
                <input type="text" name="title" class="editor-input" placeholder="Blog Title" required>
                <!-- Text area for blog content -->
                <textarea name="content" id="blogContent" class="editor-input" placeholder="Write your blog post..." required></textarea>
                <!-- Button to submit the form -->
                <button type="submit" class="btn">Publish Post</button>
            </form>
        </div>
    </div>
    <!-- Linking external JavaScript file for added functionlity --> 
    <script src="assets/script.js"></script>
</body>
</html>
