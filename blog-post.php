<?php
include("config.php");

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.html');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle new post creation
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $user_id = $_SESSION['id'];
    
    // Handle image upload
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $upload_dir = 'uploads/blog/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $image = uniqid() . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $image);
    }
    
    $sql = "INSERT INTO blog_posts (user_id, title, content, image) 
            VALUES ('$user_id', '$title', '$content', '$image')";
    
    if ($conn->query($sql)) {
        header('Location: blog.html');
    } else {
        echo "Error: " . $conn->error;
    }
} elseif (isset($_GET['id'])) {
    // Handle viewing individual post
    $post_id = $conn->real_escape_string($_GET['id']);
    $sql = "SELECT b.*, u.name 
            FROM blog_posts b 
            JOIN users u ON b.user_id = u.id 
            WHERE b.id = '$post_id'";
    
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();

        // Render the HTML for the blog post
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo htmlspecialchars($post['title']); ?> - CarRento Blog</title>
            <link href="https://fonts.googleapis.com/css2?family=Italianno&display=swap" rel="stylesheet">
            <style>
                body {
                    background-color: #000;
                    color: #fff;
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                }
                .navbar {
                    padding: 15px 50px;
                    background-color: #000;
                    border-bottom: 5px solid #ff2727;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
                }
                .logo {
                    font-family: 'italianno', sans-serif;
                    font-size: 36px;
                    color: #ff1e00;
                }
                .container {
                    max-width: 800px;
                    margin: 50px auto;
                    padding: 20px;
                }
                .blog-image {
                    width: 100%;
                    border-radius: 10px;
                }
                .blog-title {
                    font-size: 2em;
                    color: #ff1e00;
                    margin: 20px 0;
                }
                .blog-content {
                    margin: 20px 0;
                }
                .blog-meta {
                    color: #888;
                    font-size: 0.9em;
                    margin-top: 10px;
                }
            </style>
        </head>
        <body>
            <header class="navbar">
                <div class="logo">Car<span>Rento</span></div>
            </header>
            <div class="container">
                <img src="uploads/blog/<?php echo htmlspecialchars($post['image']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>" class="blog-image">
                <h1 class="blog-title"><?php echo htmlspecialchars($post['title']); ?></h1>
                <p class="blog-meta">Posted by <?php echo htmlspecialchars($post['name']); ?> on <?php echo date('F d, Y', strtotime($post['createdon'])); ?></p>
                <div class="blog-content"><?php echo nl2br(htmlspecialchars($post['content'])); ?></div>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "Post not found";
    }
}

$conn->close();
?>
