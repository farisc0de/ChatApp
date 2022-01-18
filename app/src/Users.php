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
        $this->db->query("SELECT id, username FROM users WHERE username = :username");

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

    public function getOnline()
    {
        $this->db->query("SELECT username FROM users WHERE is_online=:s");

        $this->db->bind(":s", true, PDO::PARAM_BOOL);

        $this->db->execute();

        return $this->db->resultset();
    }

    public function setOnline($username)
    {
        $this->db->query("UPDATE users SET is_online = 1 WHERE username = :username");

        $this->db->bind(":username", $username, PDO::PARAM_STR);

        $this->db->execute();
    }

    public function setOffline($username)
    {
        $this->db->query("UPDATE users SET is_online = 0 WHERE username = :username");

        $this->db->bind(":username", $username, PDO::PARAM_STR);

        $this->db->execute();
    }
}
