<?php

class Product
{
    private $pdo;

    public function __construct(PDO $conn)
    {
        $this->pdo = $conn;
    }

    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT p.*, c.category_name FROM product p 
        LEFT JOIN category c ON p.category_id = c.category_id ORDER BY p.product_name");
        $results = $stmt->fetchAll();
        return $results;
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT p.*, c.category_name FROM product p 
        LEFT JOIN category c ON p.category_id = c.category_id WHRE p.product_id=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO product(product_id, product_name, description, quantity, category_id) 
        VALUES(?,?,?,?,?)");

        return $stmt->execute([
            $data['product_id'],
            $data['product_name'],
            $data['description'],
            $data['quantity'],
            $data['category_id']
        ]);
    }

    public function update($id, $data)
    {
        $stmt = $this->pdo->prepare('UPDATE product SET product_name=?,
        description=?, quantity=?, category_id=? WHERE product_id=?');
        return $stmt->execute([
            $data['product_name'],
            $data['description'],
            $data['quantity'],
            $data['category_id'],
            $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare('');
        return $stmt->execute([$id]);
    }

    public function getCategories()
    {
        $stmt = $this->pdo->query("SELECT category_id, category_name FROM category 
        ORDER BY category_name");
        return $stmt->fetchAll();
    }
}