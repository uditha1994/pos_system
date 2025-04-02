<?php
class Category
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAll()
    {
        try {
            $stmt = $this->conn->query("SELECT * FROM category ORDER BY category_name");
            $results = $stmt->fetchAll();
            return $results;

        } catch (PDOException $e) {
            error_log("Category load error: " . $e->getMessage());
            return [];
        }
    }

    public function getById($id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM category 
            WHERE category_id=?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Category load error: " . $e->getMessage());
            return [];
        }
    }

    public function create($name, $description)
    {
        $stmt = $this->conn->prepare("INSERT INTO category
        (category_name, description) VALUES(?,?)");
        return $stmt->execute([$name, $description]);
    }

    public function update($id, $name, $description)
    {
        $stmt = $this->conn->prepare("UPDATE category SET 
        category_name=?, `description`=? WHERE category_id=?");
        return $stmt->execute([$name, $description, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM category 
        WHERE category_id=?");
        return $stmt->execute([$id]);
    }

    //check if category exists
    public function exists($id)
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM category 
        WHERE category_id=?");
        $stmt->execute([$id]);
        return $stmt->fetchColumn() > 0;
    }

}