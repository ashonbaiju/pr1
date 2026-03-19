<?php
// app/Controllers/AuthController.php

require_once '../app/Models/User.php';

class AuthController extends Controller {

    public function login() {
        // If already logged in, redirect based on role
        if (isset($_SESSION['user_id'])) {
            $this->redirectBasedOnRole($_SESSION['user_role']);
        }
        $this->view('auth/login', ['error' => '']);
    }

    public function register() {
        if (isset($_SESSION['user_id'])) {
            $this->redirectBasedOnRole($_SESSION['user_role']);
        }
        $this->view('auth/register', ['error' => '']);
    }

    public function storeUser() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $role = trim($_POST['role']); // admin, teacher, student
            $phone = trim($_POST['phone']) ?? null;

            if (empty($name) || empty($email) || empty($password) || empty($role)) {
                $this->view('auth/register', ['error' => 'All required fields must be filled.']);
                return;
            }

            $userModel = new User();
            
            // Check if email exists
            if ($userModel->findByEmail($email)) {
                $this->view('auth/register', ['error' => 'Email already registered.']);
                return;
            }

            if ($userModel->create($name, $email, $password, $role, $phone)) {
                // Auto login after registration
                $newUser = $userModel->findByEmail($email);
                $_SESSION['user_id'] = $newUser['id'];
                $_SESSION['user_name'] = $newUser['name'];
                $_SESSION['user_role'] = $newUser['role'];
                
                $this->redirectBasedOnRole($newUser['role']);
            } else {
                $this->view('auth/register', ['error' => 'Failed to register. Please try again.']);
            }
        }
    }

    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            $userModel = new User();
            $user = $userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                // Set Session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role'];

                $this->redirectBasedOnRole($user['role']);
            } else {
                $this->view('auth/login', ['error' => 'Invalid email or password']);
            }
        }
    }

    public function logout() {
        session_destroy();
        $this->redirect('/');
    }

    private function redirectBasedOnRole($role) {
        if ($role === 'admin') {
            $this->redirect('/admin/dashboard');
        } elseif ($role === 'teacher') {
            $this->redirect('/teacher/dashboard');
        } elseif ($role === 'student') {
            $this->redirect('/student/dashboard');
        } else {
            $this->redirect('/');
        }
    }
}
