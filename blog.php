<?php
// Include database dan class
require_once 'config/database.php';
require_once 'classes/Article.php';
require_once 'classes/Category.php';

// Inisialisasi database
$database = new Database();
$db = $database->getConnection();

// Inisialisasi class
$article = new Article($db);
$category = new Category($db);

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5; // artikel per halaman
$offset = ($page - 1) * $limit;

// Ambil artikel
$articles_stmt = $article->getAllArticles($limit, $offset);
$total_articles = $article->getTotalArticles();
$total_pages = ceil($total_articles / $limit);

// Ambil kategori
$categories_stmt = $category->getAllCategories();
$category->updatePostCount(); // Update jumlah post per kategori
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Portfolio | Blog</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="header-content">
            <h1>My Blog</h1>
            <p>Thoughts, ideas, and inspirations</p>
        </div>
    </header>
    
    <!-- Navigation -->
    <nav>
        <div class="nav-container">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="gallery.html">Gallery</a></li>
                <li><a href="blog.php" class="active">Blog</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </div>
    </nav>
    
    <!-- Main Content -->
    <main>
        <section class="blog-intro">
            <h2>Latest Articles</h2>
            <p>Welcome to my blog where I share insights, tutorials, and thoughts on web development, design, and technology.</p>
        </section>
        
        <div class="blog-container">
            <section class="blog-posts">
                <?php
                // Tampilkan artikel dari database
                while ($row = $articles_stmt->fetch(PDO::FETCH_ASSOC)) {
                    $published_date = date('F j, Y', strtotime($row['published_date']));
                    echo "
                    <article class='blog-post'>
                        <img src='{$row['image_url']}' alt='{$row['title']}' class='blog-post-img'>
                        <div class='blog-post-content'>
                            <p class='blog-post-date'>{$published_date}</p>
                            <h3>{$row['title']}</h3>
                            <div class='blog-post-excerpt'>
                                <p>{$row['excerpt']}</p>
                            </div>
                            <div class='blog-post-meta'>
                                <span class='category'>Category: {$row['category']}</span>
                                <span class='tags'>Tags: {$row['tags']}</span>
                            </div>
                            <a href='article.php?id={$row['id']}' class='read-more'>Read More</a>
                        </div>
                    </article>";
                }
                ?>
                
                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="blog.php?page=<?php echo $page - 1; ?>" class="prev">Previous</a>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="blog.php?page=<?php echo $i; ?>" 
                           class="<?php echo ($i == $page) ? 'active' : ''; ?>">
                           <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>
                    
                    <?php if ($page < $total_pages): ?>
                        <a href="blog.php?page=<?php echo $page + 1; ?>" class="next">Next</a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </section>
            
            <aside class="sidebar">
                <!-- About Widget -->
                <div class="sidebar-widget">
                    <h3>Tentang Saya</h3>
                    <p>Hai! Saya Elsa Monica Siwy dengan NIM 230211060003 saat ini saya berada Semester 4 pada Program Studi Teknik Informatika, Tujuan saya membuat website ini untuk memenuhi Tugas Mata Kuliah Pemograman Web</p>
                </div>
                
                <!-- Categories Widget -->
                <div class="sidebar-widget">
                    <h3>Categories</h3>
                    <ul class="categories-list">
                        <?php
                        $categories_stmt->execute(); // Reset pointer
                        while ($cat_row = $categories_stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<li><a href='category.php?cat={$cat_row['slug']}'>{$cat_row['name']} <span class='count'>{$cat_row['post_count']}</span></a></li>";
                        }
                        ?>
                    </ul>
                </div>
                
                <!-- Search Widget -->
                <div class="sidebar-widget">
                    <h3>Search</h3>
                    <form action="search.php" method="GET" class="search-form">
                        <input type="text" name="q" placeholder="Search articles..." required>
                        <button type="submit">Search</button>
                    </form>
                </div>
            </aside>
        </div>
    </main>
    
    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <p>&copy; 2025 Elsa Portfolio. All rights reserved.</p>
            <div class="social-links">
                <a href="https://github.com/ElsaMonica77" title="GitHub">GitHub</a>
                <a href="https://www.linkedin.com/in/elsa-monica-siwy-664352289" title="LinkedIn">LinkedIn</a>
                <a href="https://wa.me/6281340298862" title="WhatsApp">WhatsApp</a>
                <a href="https://www.instagram.com/elsamonicasiwy" title="Instagram">Instagram</a>
            </div>
            <p>Universitas Sam Ratulangi</p>
        </div>
    </footer>
</body>
</html>