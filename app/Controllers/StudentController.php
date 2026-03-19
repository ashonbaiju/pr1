<?php
// app/Controllers/StudentController.php
// Require all newly created models for real data integration
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/Batch.php';
require_once __DIR__ . '/../Models/Material.php';
require_once __DIR__ . '/../Models/Attendance.php';
require_once __DIR__ . '/../Models/Fee.php';
require_once __DIR__ . '/../Models/Chat.php';

class StudentController extends Controller {
    public function __construct() {
        $this->requireRole('student');
    }

    public function dashboard() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
            $this->redirect('/');
        }
        
        $attendanceModel = new Attendance();
        $stats = $attendanceModel->getAttendanceStats($_SESSION['user_id']);
        $total = $stats['total'] > 0 ? $stats['total'] : 1;
        $percentage = round(($stats['present_count'] / $total) * 100);

        $data = [
            'name' => $_SESSION['user_name'],
            'title' => 'Student Dashboard',
            'currentUrl' => '/student/dashboard',
            'links' => $this->getSidebarLinks(),
            'attendance_percentage' => $percentage
        ];
        ob_start();
        $this->view('student/dashboard', $data);
        $content = ob_get_clean();

        $data['content'] = $content;
        $this->view('layouts/app', $data);
    }

    public function subjects() {
        $batchModel = new Batch();
        $batches = $batchModel->getStudentBatches($_SESSION['user_id']);
        $this->renderPage('My Subjects & Teachers', 'student/subjects', ['batches' => $batches]);
    }

    public function live() {
        $batch_id = $_GET['batch'] ?? 'general';
        $this->renderPage('Live Video Class', 'student/live', ['batch_id' => $batch_id]);
    }

    public function materials() {
        $materialModel = new Material();
        $materials = $materialModel->getStudentMaterials($_SESSION['user_id']);
        $this->renderPage('Study Materials', 'student/materials', ['materials' => $materials]);
    }

    public function assignments() {
        $this->renderPage('Homework', 'student/assignments');
    }

    public function attendance() {
        $attendanceModel = new Attendance();
        $records = $attendanceModel->getStudentAttendance($_SESSION['user_id']);
        $stats = $attendanceModel->getAttendanceStats($_SESSION['user_id']);
        
        $total = $stats['total'] > 0 ? $stats['total'] : 1;
        $percentage = round(($stats['present_count'] / $total) * 100);

        $this->renderPage('Attendance Record', 'student/attendance', [
            'records' => $records, 
            'percentage' => $percentage
        ]);
    }

    public function results() {
        require_once __DIR__ . '/../Models/Mark.php';
        $markModel = new Mark();
        $marks = $markModel->getStudentMarks($_SESSION['user_id']);
        $this->renderPage('Marks & Results', 'student/results', ['marks' => $marks]);
    }

    public function fees() {
        $feeModel = new Fee();
        $fees = $feeModel->getStudentFees($_SESSION['user_id']);
        
        $pendingCount = 0;
        foreach ($fees as $fee) {
            if ($fee['status'] == 'pending') $pendingCount++;
        }

        $this->renderPage('Fee Status', 'student/fees', [
            'fees' => $fees,
            'pendingCount' => $pendingCount,
            'success' => isset($_GET['success']) ? true : false
        ]);
    }
    
    public function payFee() {
        $feeModel = new Fee();
        $fees = $feeModel->getStudentFees($_SESSION['user_id']);
        $pendingAmount = 0;
        $invoiceIds = [];
        
        foreach ($fees as $fee) {
            if ($fee['status'] == 'pending') {
                $pendingAmount += $fee['amount'];
                $invoiceIds[] = $fee['id'];
            }
        }
        
        if ($pendingAmount == 0) {
            $this->redirect('/student/fees');
        }

        $this->renderPage('Secure Checkout', 'student/pay', [
            'amount' => $pendingAmount,
            'invoice_ids' => implode(',', $invoiceIds)
        ]);
    }
    
    public function processPayment() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;
        
        $ids = explode(',', $_POST['invoice_ids'] ?? '');
        $feeModel = new Fee();
        
        foreach($ids as $id) {
            if(trim($id) !== '') {
                $feeModel->markAsPaid($id);
            }
        }
        
        $this->redirect('/student/fees?success=1');
    }
    
    public function downloadReceipt() {
        $id = $_GET['id'] ?? 0;
        if(!$id) { $this->redirect('/student/fees'); }
        
        // In a real app we'd verify the fee belongs to the student and generate PDF headers.
        // We will output a printable HTML receipt.
        $feeModel = new Fee();
        $fees = $feeModel->getStudentFees($_SESSION['user_id']);
        $targetFee = null;
        foreach($fees as $f) {
            if($f['id'] == $id && $f['status'] == 'paid') {
                $targetFee = $f; break;
            }
        }
        
        if(!$targetFee) { $this->redirect('/student/fees'); }
        
        // Render raw without layout
        $this->view('student/receipt', ['fee' => $targetFee, 'student' => $_SESSION['user_name']]);
    }

    public function chat() {
        $this->renderPage('AI Tutor Chat', 'student/chat', []);
    }

    public function support() {
        $this->renderPage('Bug Report & Support', 'student/support', []);
    }

    private function renderPage($title, $viewName, $extraData = []) {
        $data = [
            'title' => $title,
            'currentUrl' => '/' . $viewName,
            'links' => $this->getSidebarLinks()
        ];
        
        // Merge the extra database-polled data so the views can access them
        $data = array_merge($data, $extraData); 
        
        ob_start();
        $this->view($viewName, $data);
        $content = ob_get_clean();
        
        // Use the base data for the layout wrapper
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
            ['url' => '/student/dashboard', 'icon' => 'fas fa-home', 'label' => 'Dashboard'],
            ['url' => '/student/subjects', 'icon' => 'fas fa-book-reader', 'label' => 'My Subjects & Teachers'],
            ['url' => '/student/materials', 'icon' => 'fas fa-file-download', 'label' => 'Study Materials'],
            ['url' => '/student/assignments', 'icon' => 'fas fa-tasks', 'label' => 'Homework'],
            ['url' => '/student/attendance', 'icon' => 'fas fa-calendar-check', 'label' => 'Attendance'],
            ['url' => '/student/results', 'icon' => 'fas fa-chart-line', 'label' => 'Marks / Results'],
            ['url' => '/student/fees', 'icon' => 'fas fa-receipt', 'label' => 'Fee Status'],
            ['url' => '/student/chat', 'icon' => 'fas fa-robot', 'label' => 'AI Tutor Chat'],
            ['url' => '/student/support', 'icon' => 'fas fa-bug', 'label' => 'Bug Report / Support']
        ];
    }
}
