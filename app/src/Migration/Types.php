<?php

class Types
{
    public static function String($length)
    {
        return "varchar({$length})";
    }

    public static function Integer()
    {
        return "int";
    }

    public static function Boolean()
    {
        return "tinyint(1)";
    }

    public static function Text()
    {
        return "longtext";
    }

    public static function DateTime()
    {
        return "datetime";
    }

    public static function TimeStamp()
    {
        return "timestamp";
    }
}
