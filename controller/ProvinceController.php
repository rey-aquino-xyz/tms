<?php
include_once __DIR__ . '/../config.php';

class ProvinceController
{

    public static function Insert(Province $m): bool
    {
        $sql = "INSERT INTO `porvince`(`name`) VALUES (?)";
        try {
            return DBx::ExecuteCommand($sql, [strtolower($m->Name)]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function Update(Province $m): bool
    {
        $sql = "UPDATE `porvince` SET `name`=? WHERE province_id =?";
        try {
            return Dbx::ExecuteCommand($sql, [$m->Name, $m->ProvinceId]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public static function DeleteById($id): bool
    {
        $sql = "DELETE FROM `porvince` WHERE province_id=?";
        try {
            return Dbx::ExecuteCommand($sql, [$id]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function Get()
    {
        return DBx::GetData("SELECT * FROM porvince");
    }

    public static function GetById($id): Province
    {
        $result = DBx::GetData("SELECT * FROM porvince WHERE province_id =?", [$id]);
        $m      = new Province();
        if (count($result) > 0) {
            $m->ProvinceId = $result[0]['province_id'];
            $m->Name       = strtoupper($result[0]['name']);
        }
        return $m;
    }

    public static function HasDuplicate($name): bool
    {
        $sql = "SELECT * FROM porvince WHERE name=?";
        if (count(DBx::GetData($sql, [strtolower($name)])) > 0) {
            return true;
        } else {
            return false;
        }
    }

}
