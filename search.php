<?php
require_once 'config/database.php';
require_once 'classes/Article.php';

$database = new Database();
$db = $database->getConnection();
$article = new Article($db);

$keyword = isset($_GET['q']) ? trim($_GET['q']) : '';
$search_results = [];

if ($keyword) {
    $search_stmt = $article->searchArticles($keyword);
    $search_results = $search_stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results | My Portfolio</title>
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
    
    <main>
        <div class="search-results">
            <h1>Search Results for "<?php echo htmlspecialchars($keyword); ?>"</h1>
            
            <?php if (empty($search_results)): ?>
                <p>No articles found matching your search.</p>
            <?php else: ?>
                <p>Found <?php echo count($search_results); ?> article(s)</p>
                
                <?php foreach ($search_results as $row): ?>
                <article class="search-result">
                    <h3><a href="article.php?id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['title']); ?></a></h3>
                    <p><?php echo htmlspecialchars($row['excerpt']); ?></p>
                    <small><?php echo date('F j, Y', strtotime($row['published_date'])); ?> | <?php echo htmlspecialchars($row['category']); ?></small>
                </article>
                <?php endforeach; ?>
            <?php endif; ?>
            
            <a href="blog.php">← Back to Blog</a>
        </div>
    </main>
</body>
</html>