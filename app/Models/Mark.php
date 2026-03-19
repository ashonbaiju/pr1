<?php
// app/Models/Mark.php

class Mark {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getStudentMarks($student_id) {
        $query = "
            SELECT m.*, s.name as subject_name 
            FROM marks m
            JOIN subjects s ON m.subject_id = s.id
            WHERE m.student_id = :student_id
            ORDER BY m.created_at DESC
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['student_id' => $student_id]);
        return $stmt->fetchAll();
    }

    public function addMark($student_id, $subject_id, $exam_name, $score, $max_score) {
        // Upsert logic
        $stmt = $this->db->prepare("SELECT id FROM marks WHERE student_id = ? AND subject_id = ? AND exam_name = ?");
        $stmt->execute([$student_id, $subject_id, $exam_name]);
        $existing = $stmt->fetch();

        if ($existing) {
            $update = $this->db->prepare("UPDATE marks SET score = ?, max_score = ? WHERE id = ?");
            return $update->execute([$score, $max_score, $existing['id']]);
        } else {
            $insert = $this->db->prepare("INSERT INTO marks (student_id, subject_id, exam_name, score, max_score) VALUES (?, ?, ?, ?, ?)");
            return $insert->execute([$student_id, $subject_id, $exam_name, $score, $max_score]);
        }
    }
}
