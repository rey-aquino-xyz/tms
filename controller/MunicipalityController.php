<?php
include_once __DIR__ . '/../config.php';

class MunicipalityController
{

    public static function Insert(Municipality $m): bool
    {
        $sql = "INSERT INTO `municipality`(`province_id`, `name`) VALUES (?,?)";
        try {
            return DBx::ExecuteCommand($sql, [$m->ProvinceId, strtolower($m->Name)]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function Update(Municipality $m): bool
    {
        $sql = "UPDATE `municipality` SET `province_id`=?,`name`=? WHERE  `municipality_id`=?";
        try {
            return DBx::ExecuteCommand($sql, [$m->ProvinceId, strtolower($m->Name), $m->MunicipalityId]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function UpdateByName($municipality_id, $new_name): bool
    {
        $sql = "UPDATE `municipality` SET `name`=? WHERE  `municipality_id`=?";
        try {
            return DBx::ExecuteCommand($sql, [strtolower($new_name), $municipality_id]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function Delete($id): bool
    {
        $sql = "DELETE FROM `municipality` WHERE `municipality_id`=?";
        try {
            return DBx::ExecuteCommand($sql, [$id]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function Get()
    {
        return DBx::GetData("SELECT * FROM `municipality`");
    }

    public static function GetById($id): Municipality
    {
        $result = DBx::GetData("SELECT * FROM `municipality` WHERE `municipality_id`=?", [$id]);
        $m      = new Municipality();
        if (count($result) > 0) {
            $m->MunicipalityId = $result[0]['municipality_id'];
            $m->ProvinceId     = $result[0]['province_id'];
            $m->Name           = strtoupper($result[0]['name']);
        }
        return $m;
    }

    public static function GetByProvince($province_id)
    {
        return DBx::GetData("SELECT * FROM `municipality` WHERE `province_id`=?", [$province_id]);
    }

    public static function HasDuplicate($name): bool
    {
        $sql = "SELECT * FROM municipality WHERE name=?";
        if (count(DBx::GetData($sql, [strtolower($name)])) > 0) {
            return true;
        } else {
            return false;
        }
    }
}
