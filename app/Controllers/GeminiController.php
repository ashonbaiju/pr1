<?php
// app/Controllers/GeminiController.php

class GeminiController extends Controller {
    
    // In a real production app, store this in .env
    private $apiKey = 'DEMO_KEY'; 

    public function processMessage() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;
        
        $data = json_decode(file_get_contents('php://input'), true);
        $userMessage = $data['message'] ?? '';
        
        if (empty($userMessage)) {
            echo json_encode(['reply' => 'Please ask a question.']);
            return;
        }

        header('Content-Type: application/json');

        if ($this->apiKey === 'DEMO_KEY' || empty($this->apiKey)) {
            // Simulated AI delay for DEMO purposes
            sleep(1);
            $reply = $this->getMockedAIResponse($userMessage);
            echo json_encode(['reply' => $reply]);
            return;
        }

        // Real Gemini API Call
        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=' . $this->apiKey;
        
        $payload = [
            "contents" => [
                ["parts" => [["text" => "You are an AI Tutor for a student web application. Answer this educational question: " . $userMessage]]]
            ]
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        
        $response = curl_exec($ch);
        curl_close($ch);

        $responseData = json_decode($response, true);
        
        if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
            $reply = $responseData['candidates'][0]['content']['parts'][0]['text'];
        } else {
            $reply = "I'm having trouble connecting to my AI brain right now. Try again later!";
        }

        echo json_encode(['reply' => $reply]);
    }

    private function getMockedAIResponse($msg) {
        $msg = strtolower($msg);
        if (strpos($msg, 'physics') !== false || strpos($msg, 'gravity') !== false) {
            return "Gravity is the force by which a planet or other body draws objects toward its center. It keeps all of the planets in orbit around the sun!";
        }
        if (strpos($msg, 'math') !== false || strpos($msg, 'calculus') !== false) {
            return "Calculus is the mathematical study of continuous change. The two major branches are differential calculus and integral calculus.";
        }
        if (strpos($msg, 'hello') !== false || strpos($msg, 'hi') !== false) {
            return "Hello there! I am your AI Tutor. How can I help you with your studies today?";
        }
        return "That's an excellent question! As your AI tutor, I suggest reviewing your latest uploaded notes on that topic. Let me know if you need a specific concept broken down step-by-step.";
    }
}
