<?php

class Messages
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function sendMessage($user_id, $message)
    {
        $this->db->query("INSERT INTO messages SET user=:id, message=:m, date=now()");

        $this->db->bind(":id", $user_id, PDO::PARAM_INT);
        $this->db->bind(":m", $message, PDO::PARAM_STR);

        return $this->db->execute();
    }

    public function getMessages()
    {
        $this->db->query("SELECT * FROM messages");

        $this->db->execute();

        return $this->db->resultset();
    }
}
