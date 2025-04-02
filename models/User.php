<?php
class user{
    private $pdo;

    public function __construct(PDO $pdo){
        $this -> pdo = $pdo;
    }

    public function getAll(){
        $stmt = $this -> pdo -> query('SELECT * FROM user ORDER BY username');
        return $stmt -> fetchAll();
    }

    public function getById($id){
        $stmt = $this -> pdo -> prepare('SELECT * FROM user WHERE user_id=?');
        $stmt -> execute([$id]);
        return $stmt -> fetch();
    }

    public function create($data){
        $stmt = $this -> pdo -> prepare('INSERT INTO user
        (username, password, full_name, email, role) VALUES(?,?,?,?,?)');
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        return $stmt -> execute([
            $data['username'],
            $hashedPassword,
            $data['full_name'],
            $data['email'],
            $data['role']
        ]);
    }

    public function update($id,$data){
        $stmt = $this -> pdo -> prepare('UPDATE user SET username=?, full_name=?, 
        email=?, role=? WHERE user_id=?');

        return $stmt -> execute([
            $data['username'],
            $data['full_name'],
            $data['email'],
            $data['role'],
            $id
        ]);
    }

    public function delete($id){
        $stmt = $this -> pdo -> prepare('DELETE FROM user WHERE user_id=?');
        return $stmt -> execute ($id);
    }

    public function getByUsername($username){
        $stmt = $this -> pdo -> prepare('SELECT * FROM user WHERE username=?');
        $stmt -> execute([$username]);
        return $stmt -> fetch();
    }

    public function verifyCredentials($username,$password){
        $user = $this -> getByUsername($username);
        if($user && password_verify($password, $user['password'])){
            return $user;
        }
        return false;
    }


}