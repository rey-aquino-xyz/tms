<?php
include_once __DIR__ . '/../config.php';

class AssistantController
{

    public static function Insert(Assistant $m): bool
    {
        $sql = "INSERT INTO `assistant`(`name`, `contact`, `address`) VALUES (?,?,?)";
        try {
            return DBx::ExecuteCommand($sql, [$m->Name, $m->Contact, $m->Address]);
        } catch (\Throwable $th) {
            throw $th;
        }

    }

    public static function UpdateById(Assistant $m): bool
    {
        $sql = "UPDATE `assistant` SET `name`=?,`contact`=?,`address`=? WHERE `assistant_id`=?";
        try {
            return DBx::ExecuteCommand($sql, [$m->Name, $m->Contact, $m->Address, $m->AssistantId]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function Get()
    {
        return DBx::GetData("SELECT * FROM assistant");
    }

    public static function GetById($id): Assistant
    {
        $r = DBx::GetData("SELECT * FROM `assistant` WHERE `assistant_id`=?", [$id]);
        $m = new Assistant();

        if (count($r) > 0) {
            $m->AssistantId = $r[0]['assistant_id'];
            $m->Name        = $r[0]['name'];
            $m->Contact     = $r[0]['contact'];
            $m->Address     = $r[0]['address'];
        }

        return $m;
    }
}
