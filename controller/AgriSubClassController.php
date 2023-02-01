<?php
include_once __DIR__ . '/../config.php';

class AgriSubClassController
{
    public static function Insert(AgriSubClass $m): bool
    {
        $sql = "INSERT INTO `agri_sub_class`(`name`) VALUES (?)";
        try {
            return DBx::ExecuteCommand($sql, [strtolower($m->Name)]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function Update(AgriSubClass $m): bool
    {
        $sql = "UPDATE `agri_sub_class` SET `name`=? WHERE `agri_sub_class_id`=?";
        try {
            return DBx::ExecuteCommand($sql, [$m->Name, strtolower($m->AgriSubClassId)]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function Get()
    {
        return DBx::GetData("SELECT * FROM `agri_sub_class`");
    }

    public static function GetById($id): AgriSubClass
    {
        $r = DBx::GetData("SELECT * FROM `agri_sub_class` WHERE agri_sub_class_id=?", [$id]);
        $m = new AgriSubClass();
        if (count($r) > 0) {
            $m->AgriSubClassId = $r[0]['agri_sub_class_id'];
            $m->Name           = strtoupper($r[0]['name']);
        }
        return $m;
    }

    public static function HasDuplicate($name): bool
    {
        $r = DBx::GetData("SELECT `name` FROM `agri_sub_class` WHERE `name` =?", [strtolower($name)]);
        if (count($r) > 0) {
            return true;
        } else {
            return false;
        }
    }

}
