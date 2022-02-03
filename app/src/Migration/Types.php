<?php

class Types
{
    public function String($length)
    {
        return "varchar({$length})";
    }

    public function Integer()
    {
        return "int";
    }

    public function Boolean()
    {
        return "tinyint(1)";
    }

    public function Text()
    {
        return "longtext";
    }

    public function DateTime()
    {
        return "datetime";
    }

    public function TimeStamp()
    {
        return "timestamp";
    }
}
