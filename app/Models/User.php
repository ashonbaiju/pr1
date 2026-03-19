<?php
// app/Models/User.php

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }


    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function create($name, $email, $password, $role, $phone = null) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO users (name, email, password, role, phone) VALUES (:name, :email, :password, :role, :phone)");
        return $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $passwordHash,
            'role' => $role,
            'phone' => $phone
        ]);
    }

    public function getStudents() {
        $stmt = $this->db->query("SELECT id, name, email FROM users WHERE role = 'student' ORDER BY name ASC");
        return $stmt->fetchAll();
    }
}
