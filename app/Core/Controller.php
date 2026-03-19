<?php
// app/Core/Controller.php

class Controller {
    // Render a view
    protected function view($view, $data = []) {
        extract($data);
        $viewFile = "../app/Views/{$view}.php";
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("View {$view} not found!");
        }
    }

    // Redirect
    protected function redirect($url) {
        header("Location: " . BASE_URL . $url);
        exit();
    }

    // Check Authentication and Role
    protected function requireRole($requiredRole) {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/');
        }
        if ($_SESSION['user_role'] !== $requiredRole) {
            die("Unauthorized access.");
        }
    }
}
