<?php
require_once 'config/database.php';
require_once 'classes/Article.php';

$database = new Database();
$db = $database->getConnection();
$article = new Article($db);

$article_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$article_data = $article->getArticleById($article_id);

if (!$article_data) {
    header("Location: blog.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($article_data['title']); ?> | My Portfolio</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navigation -->
    <nav>
        <div class="nav-container">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="gallery.html">Gallery</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </div>
    </nav>
    
    <!-- Article Content -->
    <main class="article-main">
        <article class="single-article">
            <header class="article-header">
                <h1><?php echo htmlspecialchars($article_data['title']); ?></h1>
                <div class="article-meta">
                    <span class="author">By <?php echo htmlspecialchars($article_data['author']); ?></span>
                    <span class="date"><?php echo date('F j, Y', strtotime($article_data['published_date'])); ?></span>
                    <span class="category">Category: <?php echo htmlspecialchars($article_data['category']); ?></span>
                </div>
            </header>
            
            <?php if ($article_data['image_url']): ?>
            <div class="article-image">
                <img src="<?php echo htmlspecialchars($article_data['image_url']); ?>" 
                     alt="<?php echo htmlspecialchars($article_data['title']); ?>">
            </div>
            <?php endif; ?>
            
            <div class="article-content">
                <?php echo nl2br(htmlspecialchars($article_data['content'])); ?>
            </div>
            
            <div class="article-tags">
                <strong>Tags:</strong>
                <?php
                $tags = explode(',', $article_data['tags']);
                foreach ($tags as $tag) {
                    echo "<span class='tag'>" . htmlspecialchars(trim($tag)) . "</span>";
                }
                ?>
            </div>
            
            <div class="article-navigation">
                <a href="blog.php" class="back-to-blog">← Back to Blog</a>
            </div>
        </article>
    </main>
</body>
</html>