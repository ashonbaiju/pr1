<?php
// app/Models/Material.php

class Material {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getStudentMaterials($student_id) {
        $query = "
            SELECT m.*, u.name as teacher_name, b.name as batch_name
            FROM materials m
            JOIN users u ON m.teacher_id = u.id
            JOIN batches b ON m.batch_id = b.id
            JOIN student_batches sb ON b.id = sb.batch_id
            WHERE sb.student_id = :student_id
            ORDER BY m.created_at DESC
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['student_id' => $student_id]);
        return $stmt->fetchAll();
    }

    public function upload($teacher_id, $batch_id, $type, $title, $file_path) {
        $stmt = $this->db->prepare("INSERT INTO materials (teacher_id, batch_id, type, title, file_path) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$teacher_id, $batch_id, $type, $title, $file_path]);
    }
}
