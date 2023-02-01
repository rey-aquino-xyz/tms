<?php

include_once __DIR__ . '/../config.php';

class AgriMarketValueController
{
    public static function Insert(AgriMarketValue $m): bool
    {
        $sql = "INSERT INTO `agri_market_value`(`agri_sub_class_id`, `1st`, `2nd`, `3rd`, `4th`, `5th`, `6th`) VALUES (?,?,?,?,?,?,?)";
        try {
            return DBx::ExecuteCommand($sql, [$m->AgriSubClassId, $m->First, $m->Second, $m->Third, $m->Fourth, $m->Fifth, $m->Sixth]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function UpdateById(AgriMarketValue $m): bool
    {
        $sql = "UPDATE `agri_market_value` SET `agri_sub_class_id`=?,`1st`=?,`2nd`=?,`3rd`=?,`4th`=?,`5th`=?,`6th`=? WHERE `agri_market_value_id`=?";
        try {
            return DBx::ExecuteCommand($sql, [$m->AgriSubClassId, $m->First, $m->Second, $m->Third, $m->Fourth, $m->Fifth, $m->Sixth, $m->AgriMarketValueId]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function Get()
    {
        return Dbx::GetData("SELECT * FROM `agri_market_value`");
    }

    public static function GetById($id)
    {
        $r = DBx::GetData("SELECT * FROM `agri_market_value` WHERE agri_market_value_id=?", [$id]);
        $m = new AgriMarketValue();
        if (count($r) > 0) {
            $m->AgriMarketValueId = $r[0]['agri_market_value_id'];
            $m->AgriSubClassId    = $r[0]['agri_sub_class_id'];
            $m->First             = $r[0]['1st'];
            $m->Second            = $r[0]['2nd'];
            $m->Third             = $r[0]['3rd'];
            $m->Fourth            = $r[0]['4th'];
            $m->Fifth             = $r[0]['5th'];
            $m->Sixth             = $r[0]['6th'];
        }
        return $m;
    }

    public static function GetBySubClassId($sub_class_id)
    {
        $r = DBx::GetData("SELECT * FROM `agri_market_value` WHERE agri_sub_class_id=?", [$sub_class_id]);
        $m = new AgriMarketValue();
        if (count($r) > 0) {
            $m->AgriMarketValueId = $r[0]['agri_market_value_id'];
            $m->AgriSubClassId    = $r[0]['agri_sub_class_id'];
            $m->First             = $r[0]['1st'];
            $m->Second            = $r[0]['2nd'];
            $m->Third             = $r[0]['3rd'];
            $m->Fourth            = $r[0]['4th'];
            $m->Fifth             = $r[0]['5th'];
            $m->Sixth             = $r[0]['6th'];
        }
        return $m;
    }
}?>
