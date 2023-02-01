<?php
include_once __DIR__ . '/../config.php';

class SubClassificationController
{
    public static function Insert(SubClassification $m): bool
    {
        $sql = "INSERT INTO `sub_classification`(`name`, `description`) VALUES (?,?)";
        try {
            return DBx::ExecuteCommand($sql, [$m->Name, $m->Description]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function Update(SubClassification $m): bool
    {
        $sql = "UPDATE `sub_classification` SET `name`=?,`description`=? WHERE `sub_class_id`=?";
        try {
            return DBx::ExecuteCommand($sql, [$m->Name, $m->Description, $m->SubClassificationId]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function Get()
    {
        return DBx::GetData("SELECT * FROM `sub_classification`");
    }

    public static function GetById($id)
    {
        $r = DBx::GetData("SELECT * FROM `sub_classification` WHERE `sub_class_id`=?", [$id]);
        $m = new SubClassification();

        if (count($r) > 0) {
            $m->SubClassificationId = $r[0]['sub_class_id'];
            $m->Name                = $r[0]['name'];
            $m->Description         = $r[0]['description'];
        }
        return $m;
    }


    public static function HasDuplicate($name): bool
    {
        $r = DBx::GetData("SELECT `name` FROM `sub_class` WHERE `name` =?", [strtolower($name)]);
        if (count($r) > 0) {
            return true;
        } else {
            return false;
        }
    }
}
