<?php
// app/Models/Batch.php

class Batch {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getStudentBatches($student_id) {
        $query = "
            SELECT b.id, b.name as batch_name, s.name as subject_name, t.name as teacher_name
            FROM student_batches sb
            JOIN batches b ON sb.batch_id = b.id
            JOIN batch_subject_teacher bst ON b.id = bst.batch_id
            JOIN subjects s ON bst.subject_id = s.id
            JOIN users t ON bst.teacher_id = t.id
            WHERE sb.student_id = :student_id
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['student_id' => $student_id]);
        return $stmt->fetchAll();
    }

    public function getTeacherBatches($teacher_id) {
        $query = "
            SELECT b.id, b.name as batch_name, s.name as subject_name, c.name as class_name,
                   (SELECT COUNT(*) FROM student_batches WHERE batch_id = b.id) as student_count
            FROM batch_subject_teacher bst
            JOIN batches b ON bst.batch_id = b.id
            JOIN subjects s ON bst.subject_id = s.id
            JOIN classes c ON b.class_id = c.id
            WHERE bst.teacher_id = :teacher_id
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['teacher_id' => $teacher_id]);
        return $stmt->fetchAll();
    }

    public function getStudentsInBatch($batch_id) {
        $query = "
            SELECT u.id, u.name, u.email, u.phone 
            FROM student_batches sb
            JOIN users u ON sb.student_id = u.id
            WHERE sb.batch_id = :batch_id
            ORDER BY u.name ASC
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['batch_id' => $batch_id]);
        return $stmt->fetchAll();
    }

    public function getAllBatches() {
        $query = "
            SELECT b.id, b.name as batch_name, s.name as subject_name, c.name as class_name
            FROM batches b
            JOIN classes c ON b.class_id = c.id
            JOIN batch_subject_teacher bst ON b.id = bst.batch_id
            JOIN subjects s ON bst.subject_id = s.id
            ORDER BY c.name, b.name ASC
        ";
        return $this->db->query($query)->fetchAll();
    }

    public function enrollStudent($student_id, $batch_id) {
        $stmt = $this->db->prepare("INSERT IGNORE INTO student_batches (student_id, batch_id) VALUES (?, ?)");
        return $stmt->execute([$student_id, $batch_id]);
    }
}
