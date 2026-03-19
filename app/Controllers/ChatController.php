<?php
// app/Controllers/ChatController.php

require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/Chat.php';

class ChatController extends Controller {
    
    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
    }

    public function index() {
        $data = [
            'name' => $_SESSION['user_name'] ?? 'User',
            'title' => 'Peer to Peer Chat',
            'currentUrl' => '/messages',
            'links' => $this->getSidebarForRole($_SESSION['user_role'])
        ];
        
        ob_start();
        $this->view('chat/index', $data);
        $content = ob_get_clean();
        
        $data['content'] = $content;
        $this->view('layouts/app', $data);
    }

    public function getPeers() {
        $chatModel = new Chat();
        $peers = $chatModel->getPeers($_SESSION['user_id']);
        header('Content-Type: application/json');
        echo json_encode($peers);
    }

    public function getMessages() {
        if (!isset($_GET['peer_id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'peer_id required']);
            return;
        }

        $chatModel = new Chat();
        $messages = $chatModel->getMessages($_SESSION['user_id'], $_GET['peer_id']);
        
        $user_id = $_SESSION['user_id'];
        $formatted = array_map(function($msg) use ($user_id) {
            return [
                'id' => $msg['id'],
                'is_mine' => ($msg['sender_id'] == $user_id),
                'message' => $msg['message'],
                'timestamp' => $msg['created_at']
            ];
        }, $messages);

        header('Content-Type: application/json');
        echo json_encode($formatted);
    }

    public function sendMessage() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;
        
        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['receiver_id']) || !isset($data['message'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid payload']);
            return;
        }

        $chatModel = new Chat();
        $success = $chatModel->sendMessage($_SESSION['user_id'], $data['receiver_id'], $data['message']);

        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }

    private function getSidebarForRole($role) {
        if ($role === 'teacher') {
            return [
                ['url' => '/teacher/dashboard', 'icon' => 'fas fa-home', 'label' => 'Dashboard'],
                ['url' => '/teacher/classes', 'icon' => 'fas fa-chalkboard', 'label' => 'My Classes & Batches'],
                ['url' => '/teacher/attendance', 'icon' => 'fas fa-calendar-check', 'label' => 'Attendance'],
                ['url' => '/teacher/materials/upload', 'icon' => 'fas fa-file-upload', 'label' => 'Upload Materials'],
                ['url' => '/teacher/marks', 'icon' => 'fas fa-star', 'label' => 'Enter Marks'],
                ['url' => '/teacher/announcements', 'icon' => 'fas fa-bullhorn', 'label' => 'Announcements']
            ];
        } elseif ($role === 'student') {
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
        } else {
            return [
                ['url' => '/admin/dashboard', 'icon' => 'fas fa-home', 'label' => 'Dashboard']
            ];
        }
    }
}
