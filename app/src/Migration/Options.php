<?php

class Options
{
    public function NotNull()
    {
        return "NOT NULL";
    }

    public function Null()
    {
        return "NULL";
    }

    public function CurrentTimeStamp()
    {
        return "DEFAULT CURRENT_TIMESTAMP";
    }

    public function DefaultValue($value)
    {
        return "DEFAULT {$value}";
    }

    public function UnSigned()
    {
        return "UNSIGNED";
    }

    public function AutoIncrement()
    {
        return "AUTO_INCREMENT";
    }

    public function Unique($column)
    {
        return "UNIQUE({$column})";
    }

    public function Index($column)
    {
        return "INDEX({$column})";
    }

    public function PrimaryKey($key)
    {
        return "PRIMARY KEY ({$key})";
    }

    public function ForeignKey($foreign_key, $references)
    {
        $ref = implode("", array_keys($references));
        $key = implode("", array_values($references));
        return "FOREIGN KEY ({$foreign_key}) REFERENCES {$ref}({$key}) ON DELETE CASCADE ON UPDATE CASCADE";
    }
}
