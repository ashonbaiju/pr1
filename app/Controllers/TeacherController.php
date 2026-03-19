<?php
// app/Controllers/TeacherController.php

// Require models
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/Batch.php';
require_once __DIR__ . '/../Models/Material.php';

class TeacherController extends Controller {
    public function __construct() {
        $this->requireRole('teacher');
    }

    public function dashboard() {
        $data = [
            'title' => 'Teacher Dashboard',
            'currentUrl' => '/teacher/dashboard',
            'links' => $this->getSidebarLinks(),
            'stats' => [
                'batches' => 4,
                'total_students' => 120,
                'assignments_due' => 2,
                'messages' => 5
            ]
        ];

        ob_start();
        $this->view('teacher/dashboard', $data);
        $content = ob_get_clean();

        $data['content'] = $content;
        $this->view('layouts/app', $data);
    }

    public function live() {
        $batch_id = $_GET['batch'] ?? 'general';
        $this->renderPage('Host Live Class', 'teacher/live', ['batch_id' => $batch_id]);
    }

    public function uploadMaterial() {
        // Dummy batches for the dropdown
        $batches = [
            ['id' => 1, 'name' => 'Physics Advance'],
            ['id' => 2, 'name' => 'Calculus 101']
        ];
        $this->renderPage('Upload Study Material', 'teacher/upload', ['batches' => $batches, 'error' => '', 'success' => '']);
    }

    public function classes() {
        $batchModel = new Batch();
        $batches = $batchModel->getTeacherBatches($_SESSION['user_id']);
        $this->renderPage('My Classes & Batches', 'teacher/classes', ['batches' => $batches]);
    }

    public function attendance() {
        $batchModel = new Batch();
        $batches = $batchModel->getTeacherBatches($_SESSION['user_id']);
        
        $selectedBatch = $_GET['batch'] ?? null;
        $students = [];
        
        if ($selectedBatch) {
            $students = $batchModel->getStudentsInBatch($selectedBatch);
        }

        $this->renderPage('Manage Attendance', 'teacher/attendance', [
            'batches' => $batches, 
            'selectedBatch' => $selectedBatch,
            'students' => $students,
            'success' => isset($_GET['success']) ? true : false
        ]);
    }

    public function submitAttendance() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once __DIR__ . '/../Models/Attendance.php';
            $attendanceModel = new Attendance();
            
            $batch_id = $_POST['batch_id'] ?? null;
            $date = $_POST['date'] ?? date('Y-m-d');
            $statusArray = $_POST['status'] ?? [];

            if ($batch_id && !empty($statusArray)) {
                foreach ($statusArray as $student_id => $status) {
                    $attendanceModel->markAttendance($student_id, $batch_id, $date, $status);
                }
            }
            $this->redirect('/teacher/attendance?batch=' . $batch_id . '&success=1');
        }
    }

    public function marks() {
        $batchModel = new Batch();
        $batches = $batchModel->getTeacherBatches($_SESSION['user_id']);
        
        $selectedBatch = $_GET['batch'] ?? null;
        $students = [];
        $subject_id = null;
        
        if ($selectedBatch) {
            $students = $batchModel->getStudentsInBatch($selectedBatch);
            // Optionally find the subject ID for this batch and teacher
            foreach($batches as $batch) {
                if ($batch['id'] == $selectedBatch) {
                    // Extract subject indirectly. Since we just need an ID to assign the mark, we'll fetch the subject_id
                    // Note: `getTeacherBatches` returns `subject_name`. Let's just bind the mark to the subject dynamically based on the DB batch_subject_teacher
                    $db = Database::getConnection();
                    $stmt = $db->prepare("SELECT subject_id FROM batch_subject_teacher WHERE batch_id = ? AND teacher_id = ?");
                    $stmt->execute([$selectedBatch, $_SESSION['user_id']]);
                    $res = $stmt->fetch();
                    $subject_id = $res['subject_id'] ?? null;
                    break;
                }
            }
        }

        $this->renderPage('Enter Marks', 'teacher/marks', [
            'batches' => $batches, 
            'selectedBatch' => $selectedBatch,
            'students' => $students,
            'subject_id' => $subject_id,
            'success' => isset($_GET['success']) ? true : false
        ]);
    }

    public function submitMarks() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once __DIR__ . '/../Models/Mark.php';
            $markModel = new Mark();
            
            $batch_id = $_POST['batch_id'] ?? null;
            $subject_id = $_POST['subject_id'] ?? null;
            $exam_name = $_POST['exam_name'] ?? 'Class Test';
            $max_score = floatval($_POST['max_score'] ?? 100);
            $scores = $_POST['scores'] ?? [];

            if ($batch_id && $subject_id && !empty($scores)) {
                foreach ($scores as $student_id => $score) {
                    if ($score !== '') {
                        $markModel->addMark($student_id, $subject_id, $exam_name, floatval($score), $max_score);
                    }
                }
            }
            $this->redirect('/teacher/marks?batch=' . $batch_id . '&success=1');
        }
    }

    public function announcements() {
        $this->renderPage('Announcements', 'teacher/announcements');
    }

    public function processUpload() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $batch_id = $_POST['batch_id'] ?? null;
            $type = $_POST['type'] ?? 'pdf';
            $title = $_POST['title'] ?? '';
            
            if (isset($_FILES['material_file']) && $_FILES['material_file']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../public/uploads/materials/';
                $fileName = time() . '_' . basename($_FILES['material_file']['name']);
                $targetPath = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['material_file']['tmp_name'], $targetPath)) {
                    $materialModel = new Material();
                    $materialModel->upload($_SESSION['user_id'], $batch_id, $type, $title, $fileName);
                    
                    header("Location: " . BASE_URL . "/teacher/materials/upload?success=1");
                    exit;
                }
            }
        }
        header("Location: " . BASE_URL . "/teacher/materials/upload?error=1");
        exit;
    }

    private function renderPage($title, $viewName, $extraData = []) {
        $data = [
            'title' => $title,
            'currentUrl' => '/' . $viewName,
            'links' => $this->getSidebarLinks()
        ];
        
        $data = array_merge($data, $extraData); 
        
        ob_start();
        $this->view($viewName, $data);
        $content = ob_get_clean();
        
        $layoutData = [
            'title' => $title,
            'currentUrl' => '/' . $viewName,
            'links' => $this->getSidebarLinks(),
            'content' => $content
        ];
        
        $this->view('layouts/app', $layoutData);
    }

    private function getSidebarLinks() {
        return [
            ['url' => '/teacher/dashboard', 'icon' => 'fas fa-home', 'label' => 'Dashboard'],
            ['url' => '/teacher/classes', 'icon' => 'fas fa-chalkboard', 'label' => 'My Classes & Batches'],
            ['url' => '/teacher/attendance', 'icon' => 'fas fa-calendar-check', 'label' => 'Attendance'],
            ['url' => '/teacher/materials/upload', 'icon' => 'fas fa-file-upload', 'label' => 'Upload Materials'],
            ['url' => '/teacher/marks', 'icon' => 'fas fa-star', 'label' => 'Enter Marks'],
            ['url' => '/teacher/announcements', 'icon' => 'fas fa-bullhorn', 'label' => 'Announcements']
        ];
    }
}
