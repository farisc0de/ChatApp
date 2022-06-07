<?php

class Room
{
    private Database $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $this->db->query("SELECT * FROM rooms");

        $this->db->execute();

        return $this->db->resultset();
    }

    public function create($room_name)
    {
        $this->db->query("INSERT INTO rooms SET room_name = :name");

        $this->db->bind(":name", $room_name, PDO::PARAM_STR);

        return $this->db->execute();
    }

    public function update($room_id, $new_name)
    {
        $this->db->query("UPDATE rooms SET room_name = :new_name WHERE id = :id");

        $this->db->bind(":new_name", $new_name, PDO::PARAM_STR);
        $this->db->bind(":id", $room_id, PDO::PARAM_INT);

        return $this->db->execute();
    }

    public function delete($room_id)
    {
        $this->db->query("DELETE FROM rooms WHERE id = :room_id");

        $this->db->bind(":room_id", $room_id, PDO::PARAM_INT);

        return $this->db->execute();
    }
}
