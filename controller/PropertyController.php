<?php

include_once __DIR__ . '/../config.php';

class PropertyController
{
    public static function Insert(Property $m)
    {
        $sql = "INSERT INTO `property`(`user_id`, `tdn`, `province_id`, `municipality_id`, `brgy_id`, `class_id`, `sub_class_id`, `area`, `hectare`, `market_value`, `root`) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
        try {
            return DBx::ExecuteCommand($sql, [$m->UserId, $m->TDN, $m->ProvinceId, $m->MunicipalityId, $m->BrgyId, $m->ClassId, $m->SubClassId, $m->Area, $m->Hectare, $m->MarketValue, $m->Root]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // public static function UpdateById(Property $m)
    // {
    //     $sql = "UPDATE `property` SET `user_id`=?, `tdn`=?, `location_brgy_id`=?, `class_id`=?, `sub_class_id`=?, `area`=?, `hectare`=?, `root`=?, `property_id`=?, `location`=?, `market_value`=? WHERE `property_id`=?";
    //     try {
    //         Dbx::ExecuteCommand($sql, [$m->UserId, $m->TDN, $m->LocationBrgyId, $m->ClassId, $m->SubClassId, $m->Area, $m->Hectare, $m->Root, $m->PropertyId, $m->Location, $m->MarketValue, $m->PropertyId]);
    //     } catch (\Throwable $th) {
    //         throw $th;
    //     }
    // }

    public static function Get()
    {
        return Dbx::GetData("SELECT * FROM `property`");
    }

    public static function GetByTDN($tdn): Property
    {
        $r = Dbx::GetData("SELECT * FROM `property` WHERE `tdn`=?", [$tdn]);
        $m = new Property();
        if (count($r) > 0) {
            $m->PropertyId     = $r[0]['property_id'];
            $m->UserId         = $r[0]['user_id'];
            $m->TDN            = $r[0]['tdn'];
            $m->ProvinceId     = $r[0]['province_id'];
            $m->MunicipalityId = $r[0]['municipality_id'];
            $m->BrgyId         = $r[0]['brgy_id'];
            $m->ClassId        = $r[0]['class_id'];
            $m->SubClassId     = $r[0]['sub_class_id'];
            $m->Area           = $r[0]['area'];
            $m->Hectare        = $r[0]['hectare'];
            $m->MarketValue    = $r[0]['market_value'];
            $m->Root           = $r[0]['root'];
        }
        return $m;
    }
    public static function GetById($id): Property
    {
        $r = Dbx::GetData("SELECT * FROM `property` WHERE `property_id`=?", [$id]);
        $m = new Property();
        if (count($r) > 0) {
            $m->PropertyId     = $r[0]['property_id'];
            $m->UserId         = $r[0]['user_id'];
            $m->TDN            = $r[0]['tdn'];
            $m->ProvinceId     = $r[0]['province_id'];
            $m->MunicipalityId = $r[0]['municipality_id'];
            $m->BrgyId         = $r[0]['brgy_id'];
            $m->ClassId        = $r[0]['class_id'];
            $m->SubClassId     = $r[0]['sub_class_id'];
            $m->Area           = $r[0]['area'];
            $m->Hectare        = $r[0]['hectare'];
            $m->MarketValue    = $r[0]['market_value'];
            $m->Root           = $r[0]['root'];
        }
        return $m;
    }

    public static function GetByUserId($user_id)
    {
        return Dbx::GetData("SELECT * FROM `property` WHERE user_id =?", [$user_id]);
    }

    //DASHBOARD
    public static function GetTotalProperty()
    {
        $sql = "SELECT COUNT(tdn) as c FROM property";
        $r   = DBx::GetData($sql);
        if (count($r) > 0) {
            return $r[0]['c'];
        } else {
            0;
        }
    }
    public static function GetTotalPropertyByUserId($id)
    {
        $sql = "SELECT COUNT(tdn) as c FROM property WHERE user_id =?";
        $r   = DBx::GetData($sql, [$id]);
        if (count($r) > 0) {
            return $r[0]['c'];
        } else {
            0;
        }
    }
}
