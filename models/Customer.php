<?php
class Customer
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM customer ORDER BY full_name");
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM customer WHERE customer_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO customer (full_name, contactno)
            VALUES (?, ?)
        ");
        return $stmt->execute([
            $data['full_name'],
            $data['contactno']
        ]);
    }

    public function update($id, $data)
    {
        $stmt = $this->pdo->prepare("
            UPDATE customer SET 
                full_name = ?,
                contactno = ?
            WHERE customer_id = ?
        ");
        return $stmt->execute([
            $data['full_name'],
            $data['contactno'],
            $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM customer WHERE customer_id = ?");
        return $stmt->execute([$id]);
    }
}
?>