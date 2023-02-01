<?php
include_once __DIR__ . '/../config.php';

class MarketValueController
{

    public static function Insert(MarketValue $m): bool
    {
        $sql = "INSERT INTO `market_value`(`classification_id`, `value`, `year`, `sub_class_id`) VALUES (?,?,?,?)";
        try {
            return Dbx::ExecuteCommand($sql, [$m->ClassificationId, $m->Value, $m->Year, $m->SubClassificationId]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public static function Update(MarketValue $m): bool
    {
        $sql = "UPDATE `market_value` SET `classification_id`=?,`value`=?,`year`=? , `sub_class_id` =? WHERE `market_value_id`=?";
        try {
            return Dbx::ExecuteCommand($sql, [$m->ClassificationId, $m->Value, $m->Year, $m->SubClassificationId, $m->MarketValueId]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function Get()
    {
        return DBx::GetData("SELECT * FROM `market_value` ORDER BY `year` DESC");

    }

    public static function GetById($id): MarketValue
    {
        $r = DBx::GetData("SELECT * FROM `market_value` WHERE `market_value_id`=?", [$id]);
        $m = new MarketValue();
        if (count($r) > 0) {
            $m->MarketValueId       = $r[0]['market_value_id'];
            $m->ClassificationId    = $r[0]['classification_id'];
            $m->SubClassificationId = $r[0]['sub_class_id'];
            $m->Value               = $r[0]['value'];
            $m->Year                = $r[0]['year'];
        }
        return $m;
    }

    // public static function GetByClassAndYear($class_id, $year)
    // {
    //     $r = DBx::GetData("SELECT * FROM `market_value` WHERE `classification_id`=? AND `year` =?", [$$class_id, $year]);
    //     $m = new MarketValue();
    //     if (count($r) > 0) {
    //         $m->MarketValueId       = $r[0]['market_value_id'];
    //         $m->ClassificationId    = $r[0]['classification_id'];
    //         $m->SubClassificationId = $r[0]['sub_class_id'];
    //         $m->ProvinceId          = $r[0]['province_id'];
    //         $m->MunicipalityId      = $r[0]['municipality_id'];
    //         $m->BarangayId          = $r[0]['barangay_id'];
    //         $m->Value               = $r[0]['value'];
    //         $m->Year                = $r[0]['year'];
    //     }
    //     return $m;
    // }

    public static function GetByClassAndYearAndBrgy($class_id, $year, $brgy)
    {
        $r = DBx::GetData("SELECT * FROM `market_value` WHERE `classification_id`=? AND `year` =? AND `barangay_id` = ?", [$class_id, $year, $brgy]);
        $m = new MarketValue();
        if (count($r) > 0) {
            $m->MarketValueId       = $r[0]['market_value_id'];
            $m->ClassificationId    = $r[0]['classification_id'];
            $m->SubClassificationId = $r[0]['sub_class_id'];
            $m->ProvinceId          = $r[0]['province_id'];
            $m->MunicipalityId      = $r[0]['municipality_id'];
            $m->BarangayId          = $r[0]['barangay_id'];
            $m->Value               = $r[0]['value'];
            $m->Year                = $r[0]['year'];
        }
        return $m;
    }

    public static function GetBySubClassAndYear($sub_class_id, $year){
        $r = DBx::GetData("SELECT * FROM `market_value` WHERE `sub_class_id`=? AND `year` =?", [$sub_class_id, $year]);
        $m = new MarketValue();
        if (count($r) > 0) {
            $m->MarketValueId       = $r[0]['market_value_id'];
            $m->ClassificationId    = $r[0]['classification_id'];
            $m->SubClassificationId = $r[0]['sub_class_id'];
            $m->Value               = $r[0]['value'];
            $m->Year                = $r[0]['year'];
        }
        return $m;
    }

}
?>