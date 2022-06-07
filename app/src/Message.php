<?php

class Message
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function send($user_id, $message, $key, $room_id, $to)
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

    public function sendPrivate($user_id, $message, $key, $to)
    {
        $this->db->query(
            "INSERT INTO messages SET user=:id, message=:m, encryption_key=:mk, reciver_id=:r_id, date=now()"
        );

        $this->db->bind(":id", $user_id, PDO::PARAM_INT);
        $this->db->bind(":m", $message, PDO::PARAM_STR);
        $this->db->bind(":mk", $key, PDO::PARAM_STR);
        $this->db->bind(":r_id", $to, PDO::PARAM_INT);

        return $this->db->execute();
    }

    public function getAll($room_id)
    {
        $this->db->query("SELECT * FROM messages WHERE room_id = :id");

        $this->db->bind(":id", $room_id);

        $this->db->execute();

        return $this->db->resultset();
    }

    public function getPrivate($from, $to)
    {
        $this->db->query("SELECT * FROM messages WHERE reciver_id = :rid UNION SELECT * FROM messages WHERE reciver_id = :rid && user = :user");

        $this->db->bind(":rid", $to);
        $this->db->bind(":user", $from);

        $this->db->execute();

        return $this->db->resultset();
    }

    public function delete($from, $to)
    {
        $this->db->query("DELETE FROM messages WHERE reciver_id = :rid && user = :user");

        $this->db->bind(":rid", $to);
        $this->db->bind(":user", $from);

        $this->db->execute();
    }
}
