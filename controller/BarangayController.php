<?php
include_once __DIR__ . '/../config.php';

class BarangayController
{

    public static function Insert(Barangay $m): bool
    {
        $sql = "INSERT INTO `barangay`(`municipality_id`, `name`) VALUES (?,?)";
        try {
            return DBx::ExecuteCommand($sql, [$m->MunicipalityId, strtolower($m->Name)]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function Update(Barangay $m): bool
    {
        $sql = "UPDATE `barangay` SET `municipality_id`=?,`name`=? WHERE `barangay_id`=?";
        try {
            return DBx::ExecuteCommand($sql, [$m->MunicipalityId, strtolower($m->Name), $m->BarangayId]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function UpdateByName($new_name, $barangay_id): bool
    {
        $sql = "UPDATE `barangay` SET `name`=? WHERE `barangay_id`=?";
        try {
            return DBx::ExecuteCommand($sql, [strtolower($new_name), $barangay_id]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function Get()
    {
        return DBx::GetData("SELECT * FROM barangay");
    }
    public static function GetById($barangay_id): Barangay
    {
        $r = DBx::GetData("SELECT * FROM barangay WHERE barangay_id=?", [$barangay_id]);
        $m = new Barangay();
        if (count($r) > 0) {
            $m->BarangayId     = $r[0]['barangay_id'];
            $m->MunicipalityId = $r[0]['municipality_id'];
            $m->Name           = strtoupper($r[0]['name']);
        }
        return $m;
    }

    public static function GetByMunicipality($municipality_id)
    {
        return DBx::GetData("SELECT * FROM barangay WHERE municipality_id=? ORDER BY `name` ASC", [$municipality_id]);
    }

    public static function HasDuplicate($name, $municipality_id): bool
    {
        $r = DBx::GetData("SELECT * FROM barangay WHERE name=? AND municipality_id=?", [strtolower($name), $municipality_id]);
        if (count($r) > 0) {
            return true;
        } else {
            return false;
        }
    }
}
