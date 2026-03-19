<?php
// app/Controllers/AdminController.php

class AdminController extends Controller {
    public function __construct() {
        // Ensure only admins can access these routes
        $this->requireRole('admin');
    }

    public function dashboard() {
        // Mock data for the dashboard overview until models are fully built
        $data = [
            'title' => 'Admin Dashboard',
            'currentUrl' => '/admin/dashboard',
            'links' => $this->getSidebarLinks(),
            'stats' => [
                'students' => 1250,
                'teachers' => 45,
                'classes' => 12,
                'fees_pending' => '$4,500'
            ]
        ];

        // Start output buffering to capture the inner view content
        ob_start();
        $this->view('admin/dashboard', $data);
        $content = ob_get_clean();

        // Pass inner content to layout
        $data['content'] = $content;
        $this->view('layouts/app', $data);
    }

    public function enrollments() {
        require_once __DIR__ . '/../Models/User.php';
        require_once __DIR__ . '/../Models/Batch.php';
        
        $userModel = new User();
        $batchModel = new Batch();
        
        $students = $userModel->getStudents();
        $batches = $batchModel->getAllBatches();

        $data = [
            'title' => 'Enroll Students & Assign Fees',
            'currentUrl' => '/admin/enrollments',
            'links' => $this->getSidebarLinks(),
            'students' => $students,
            'batches' => $batches,
            'success' => isset($_GET['success']) ? true : false
        ];

        ob_start();
        $this->view('admin/enrollments', $data);
        $content = ob_get_clean();

        $data['content'] = $content;
        $this->view('layouts/app', $data);
    }

    public function submitEnrollment() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once __DIR__ . '/../Models/Batch.php';
            require_once __DIR__ . '/../Models/Fee.php';
            
            $batchModel = new Batch();
            $feeModel = new Fee();
            
            $student_id = $_POST['student_id'] ?? null;
            $batch_ids = $_POST['batches'] ?? [];
            $fee_amount = floatval($_POST['fee_amount'] ?? 0);
            $due_date = $_POST['due_date'] ?? null;

            if ($student_id) {
                // Enroll in batches
                foreach ($batch_ids as $batch_id) {
                    $batchModel->enrollStudent($student_id, $batch_id);
                }
                
                // create fee if specified
                if ($fee_amount > 0 && $due_date) {
                    $feeModel->createFee($student_id, $fee_amount, $due_date);
                }
            }
            $this->redirect('/admin/enrollments?success=1');
        }
    }

    private function getSidebarLinks() {
        return [
            ['url' => '/admin/dashboard', 'icon' => 'fas fa-home', 'label' => 'Dashboard'],
            ['url' => '/admin/enrollments', 'icon' => 'fas fa-user-plus', 'label' => 'Enroll & Fees'],
            ['url' => '/admin/teachers', 'icon' => 'fas fa-chalkboard-teacher', 'label' => 'Teachers'],
            ['url' => '/admin/students', 'icon' => 'fas fa-user-graduate', 'label' => 'Students']
        ];
    }
}
