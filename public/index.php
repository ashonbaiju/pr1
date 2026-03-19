<?php
// public/index.php
session_start();

// Dynamically determine the base URL to prevent folder alignment errors in XAMPP
$scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
define('BASE_URL', $scriptName === '/' ? '' : $scriptName);

require_once '../config/database.php';
require_once '../app/Core/Router.php';
require_once '../app/Core/Controller.php';

// Instantiate Router
$router = new Router();

// Define Routes
$router->get('/', 'AuthController@login');
$router->post('/login', 'AuthController@authenticate');
$router->get('/register', 'AuthController@register');
$router->post('/register', 'AuthController@storeUser');
$router->get('/logout', 'AuthController@logout');

// Admin Routes
$router->get('/admin/dashboard', 'AdminController@dashboard');
$router->get('/admin/enrollments', 'AdminController@enrollments');
$router->post('/admin/enrollments/submit', 'AdminController@submitEnrollment');

// Teacher Routes
$router->get('/teacher/dashboard', 'TeacherController@dashboard');
$router->get('/teacher/live', 'TeacherController@live');
$router->get('/teacher/materials/upload', 'TeacherController@uploadMaterial');
$router->post('/teacher/materials/upload', 'TeacherController@processUpload');
$router->get('/teacher/classes', 'TeacherController@classes');
$router->get('/teacher/attendance', 'TeacherController@attendance');
$router->post('/teacher/attendance/submit', 'TeacherController@submitAttendance');
$router->get('/teacher/marks', 'TeacherController@marks');
$router->post('/teacher/marks/submit', 'TeacherController@submitMarks');
$router->get('/teacher/announcements', 'TeacherController@announcements');

// Student Routes
$router->get('/student/dashboard', 'StudentController@dashboard');
$router->get('/student/live', 'StudentController@live');
$router->get('/student/subjects', 'StudentController@subjects');
$router->get('/student/materials', 'StudentController@materials');
$router->get('/student/assignments', 'StudentController@assignments');
$router->get('/student/attendance', 'StudentController@attendance');
$router->get('/student/results', 'StudentController@results');
$router->get('/student/fees', 'StudentController@fees');
$router->get('/student/fees/pay', 'StudentController@payFee');
$router->post('/student/fees/process', 'StudentController@processPayment');
$router->get('/student/fees/receipt', 'StudentController@downloadReceipt');
$router->get('/student/chat', 'StudentController@chat');
$router->get('/student/support', 'StudentController@support');

// Common API Routes (Chat)
$router->get('/messages', 'ChatController@index');
$router->get('/api/chat/peers', 'ChatController@getPeers');
$router->get('/api/chat/messages', 'ChatController@getMessages');
$router->post('/api/chat/send', 'ChatController@sendMessage');

// AI API Route
$router->post('/api/ai/chat', 'GeminiController@processMessage');

// Dispatch
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
