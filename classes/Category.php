<?php
class Category {
    private $conn;
    private $table_name = "categories";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllCategories() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function updatePostCount() {
        $query = "UPDATE categories c 
                  SET post_count = (
                      SELECT COUNT(*) FROM articles a 
                      WHERE a.category = c.name
                  )";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute();
    }
}
?>