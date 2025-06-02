<?php
class Article {
    private $conn;
    private $table_name = "articles";

    public $id;
    public $title;
    public $content;
    public $excerpt;
    public $image_url;
    public $author;
    public $category;
    public $tags;
    public $published_date;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Ambil semua artikel
    public function getAllArticles($limit = 10, $offset = 0) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  ORDER BY published_date DESC 
                  LIMIT :limit OFFSET :offset";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt;
    }

    // Ambil artikel berdasarkan kategori
    public function getArticlesByCategory($category, $limit = 10) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE category = :category 
                  ORDER BY published_date DESC 
                  LIMIT :limit";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt;
    }

    // Ambil artikel berdasarkan ID
    public function getArticleById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cari artikel
    public function searchArticles($keyword) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE title LIKE :keyword OR content LIKE :keyword 
                  ORDER BY published_date DESC";
        
        $stmt = $this->conn->prepare($query);
        $keyword = "%{$keyword}%";
        $stmt->bindParam(':keyword', $keyword);
        $stmt->execute();
        
        return $stmt;
    }

    // Hitung total artikel
    public function getTotalArticles() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }
}
?>