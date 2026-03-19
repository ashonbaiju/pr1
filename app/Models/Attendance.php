<?php
// app/Models/Attendance.php

class Attendance {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getStudentAttendance($student_id) {
        $query = "
            SELECT a.*, b.name as batch_name 
            FROM attendance a
            JOIN batches b ON a.batch_id = b.id
            WHERE a.student_id = :student_id
            ORDER BY a.date DESC
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['student_id' => $student_id]);
        return $stmt->fetchAll();
    }

    public function getAttendanceStats($student_id) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total, SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present_count FROM attendance WHERE student_id = ?");
        $stmt->execute([$student_id]);
        return $stmt->fetch();
    }

    public function markAttendance($student_id, $batch_id, $date, $status) {
        // Upsert logic if date exists (assumes one attendance per day per student)
        $stmt = $this->db->prepare("SELECT id FROM attendance WHERE student_id = ? AND batch_id = ? AND date = ?");
        $stmt->execute([$student_id, $batch_id, $date]);
        $existing = $stmt->fetch();

        if ($existing) {
            $update = $this->db->prepare("UPDATE attendance SET status = ? WHERE id = ?");
            return $update->execute([$status, $existing['id']]);
        } else {
            $insert = $this->db->prepare("INSERT INTO attendance (student_id, batch_id, date, status) VALUES (?, ?, ?, ?)");
            return $insert->execute([$student_id, $batch_id, $date, $status]);
        }
    }
}
