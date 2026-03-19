<?php
// app/Models/Fee.php

class Fee {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getStudentFees($student_id) {
        $stmt = $this->db->prepare("SELECT * FROM fees WHERE student_id = :student_id ORDER BY due_date DESC");
        $stmt->execute(['student_id' => $student_id]);
        return $stmt->fetchAll();
    }
    
    // For demo payment
    public function markAsPaid($fee_id) {
        $stmt = $this->db->prepare("UPDATE fees SET status = 'paid' WHERE id = :id");
        return $stmt->execute(['id' => $fee_id]);
    }

    public function createFee($student_id, $amount, $due_date) {
        $stmt = $this->db->prepare("INSERT INTO fees (student_id, amount, due_date, status) VALUES (?, ?, ?, 'pending')");
        return $stmt->execute([$student_id, $amount, $due_date]);
    }
}
