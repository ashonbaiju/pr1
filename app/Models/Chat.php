<?php
// app/Models/Chat.php

class Chat {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getMessages($user1_id, $user2_id) {
        $query = "
            SELECT * FROM chat_messages 
            WHERE (sender_id = :u1 AND receiver_id = :u2) 
               OR (sender_id = :u3 AND receiver_id = :u4)
            ORDER BY created_at ASC
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'u1' => $user1_id, 'u2' => $user2_id,
            'u3' => $user2_id, 'u4' => $user1_id
        ]);
        return $stmt->fetchAll();
    }

    public function sendMessage($sender_id, $receiver_id, $message) {
        $stmt = $this->db->prepare("INSERT INTO chat_messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
        return $stmt->execute([$sender_id, $receiver_id, $message]);
    }
    
    // Get users that you have chatted with or can chat with
    public function getPeers($user_id) {
         $query = "SELECT id, name, role FROM users WHERE id != :id";
         $stmt = $this->db->prepare($query);
         $stmt->execute(['id' => $user_id]);
         return $stmt->fetchAll();
    }
}
