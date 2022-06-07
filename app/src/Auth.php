<?php

class Auth
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function newLogin($username, $password)
    {
        $total_failed_login = 5;
        $lockout_time = 10;
        $account_locked = false;
        $code = 0;

        $this->db->query('SELECT * FROM users WHERE username = (:user) LIMIT 1;');

        $this->db->bind(':user', $username, \PDO::PARAM_STR);

        $this->db->execute();

        $row = $this->db->single();

        if (($this->db->rowCount() >= 1) && ($row->failed_login >= $total_failed_login)) {
            $last_login = strtotime($row->last_login);
            $timeout = $last_login + ($lockout_time * 60);
            $timenow = time();

            if ($timenow < $timeout) {
                $account_locked = true;
                $code = 403;
            }
        }

        if (
            ($this->db->rowCount() == 1) &&
            (password_verify($password, $row->password)) &&
            ($account_locked == false)
        ) {
            $last_login = $row->last_login;

            $this->db->query('UPDATE users SET failed_login = 0 WHERE username = (:user) LIMIT 1;');

            $this->db->bind(':user', $username, \PDO::PARAM_STR);

            $this->db->execute();

            $code = 200;
        } else {
            sleep(rand(2, 4));

            $this->db->query(
                'UPDATE users SET failed_login = (failed_login + 1) WHERE username = (:user) LIMIT 1;'
            );

            $this->db->bind(':user', $username, \PDO::PARAM_STR);

            $this->db->execute();

            $code = 401;
        }

        $this->db->query('UPDATE users SET last_login = now() WHERE username = (:user) LIMIT 1;');

        $this->db->bind(':user', $username, \PDO::PARAM_STR);

        $this->db->execute();

        return $code;
    }
}
