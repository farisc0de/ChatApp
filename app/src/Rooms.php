<?php

class Rooms
{
    private Database $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getRooms()
    {
        $this->db->query("SELECT * FROM rooms");

        $this->db->execute();

        return $this->db->resultset();
    }

    public function createRoom($room_name)
    {
        $this->db->query("INSERT INTO rooms SET room_name = :name");

        $this->db->bind(":name", $room_name, PDO::PARAM_STR);

        return $this->db->execute();
    }

    public function updateRoom($room_id, $new_name)
    {
        $this->db->query("UPDATE rooms SET room_name = :new_name WHERE id = :id");

        $this->db->bind(":new_name", $new_name, PDO::PARAM_STR);
        $this->db->bind(":id", $room_id, PDO::PARAM_INT);

        return $this->db->execute();
    }

    public function deleteRoom($room_id)
    {
        $this->db->query("DELETE FROM rooms WHERE id = :room_id");

        $this->db->bind(":room_id", $room_id, PDO::PARAM_INT);

        return $this->db->execute();
    }
}
