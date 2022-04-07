<?php

class Messages
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function sendMessage($user_id, $message, $key, $room_id)
    {
        $this->db->query(
            "INSERT INTO messages SET user=:id, message=:m, encryption_key=:mk, room_id=:r_id, date=now()"
        );

        $this->db->bind(":id", $user_id, PDO::PARAM_INT);
        $this->db->bind(":m", $message, PDO::PARAM_STR);
        $this->db->bind(":mk", $key, PDO::PARAM_STR);
        $this->db->bind(":r_id", $room_id, PDO::PARAM_INT);

        return $this->db->execute();
    }

    public function getMessages($room_id)
    {
        $this->db->query("SELECT * FROM messages WHERE room_id = :id");

        $this->db->bind(":id", $room_id);

        $this->db->execute();

        return $this->db->resultset();
    }
}
