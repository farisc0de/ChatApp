<?php

class Users
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getUser($id)
    {
        $this->db->query("SELECT username FROM users WHERE id = :id");

        $this->db->bind(":id", $id, PDO::PARAM_INT);

        $this->db->execute();

        return $this->db->single();
    }

    public function getUserByUsername($username)
    {
        $this->db->query("SELECT id, username, is_admin FROM users WHERE username = :username");

        $this->db->bind(":username", $username, PDO::PARAM_STR);

        $this->db->execute();

        return $this->db->single();
    }

    public function checkUser($username)
    {
        $this->db->query("SELECT * FROM users WHERE username = :username;");

        $this->db->bind(":username", $username, \PDO::PARAM_STR);

        if ($this->db->execute()) {
            if ($this->db->rowCount()) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function createUser($user_array)
    {
        $sql = sprintf(
            "INSERT INTO users (%s) VALUES (%s)",
            implode(", ", array_keys($user_array)),
            ":" . implode(",:", array_keys($user_array))
        );

        $this->db->query($sql);

        foreach ($user_array as $key => $value) {
            $this->db->bind(":" . $key, $value);
        }

        return $this->db->execute();
    }

    public function getOnline($room_id)
    {
        $this->db->query("SELECT username FROM users WHERE is_online=:s AND current_room = :room");

        $this->db->bind(":s", true, PDO::PARAM_BOOL);
        $this->db->bind(":room", $room_id, PDO::PARAM_INT);

        $this->db->execute();

        return $this->db->resultset();
    }

    public function setOnline($username, $room_number)
    {
        $this->db->query(
            "UPDATE users SET is_online = 1, current_room=:r WHERE username = :username"
        );

        $this->db->bind(":r", $room_number, PDO::PARAM_STR);
        $this->db->bind(":username", $username, PDO::PARAM_STR);

        $this->db->execute();
    }

    public function setOffline($username)
    {
        $this->db->query(
            "UPDATE users SET is_online = 0, current_room = 0 WHERE username = :username"
        );

        $this->db->bind(":username", $username, PDO::PARAM_STR);

        $this->db->execute();
    }
}
