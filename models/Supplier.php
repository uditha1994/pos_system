<?php
class Supplier
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM supplier ORDER BY supplier_name");
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM supplier WHERE supplier_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO supplier (supplier_name, contactno, address)
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([
            $data['supplier_name'],
            $data['contactno'],
            $data['address']
        ]);
    }

    public function update($id, $data)
    {
        $stmt = $this->pdo->prepare("
            UPDATE supplier SET 
                supplier_name = ?,
                contactno = ?
            WHERE supplier_id = ?
        ");
        return $stmt->execute([
            $data['supplier_name'],
            $data['contactno'],
            $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM supplier WHERE supplier_id = ?");
        return $stmt->execute([$id]);
    }
}
?>