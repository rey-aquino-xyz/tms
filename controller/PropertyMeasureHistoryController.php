<?php

include_once __DIR__ . '/../config.php';

class PropertyMeasureHistoryController
{
    public static function Insert(PropertyMeasureHistory $m): bool
    {
        $sql = "INSERT INTO `property_measure_history`(`tdn`, `month`, `year`, `value`) VALUES (?,?,?,?)";
        try {
            return DBx::ExecuteCommand($sql, [$m->TDN, $m->Month, $m->Year, $m->Value]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function UpdateById(PropertyMeasureHistory $m): bool
    {
        $sql = "UPDATE `property_measure_history` SET `tdn`=?,`month`=?,`year`=?,`value`=? WHERE `property_measure_id`=?";
        try {
            return DBx::ExecuteCommand($sql, [$m->TDN, $m->Month, $m->Year, $m->Value, $m->PropertyMeasureId]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function Get()
    {
        return DBx::GetData("SELECT * FROM `property_measure_history`");
    }

    public static function GetById($id)
    {
        $r = DBx::GetData("SELECT * FROM `property_measure_history` WHERE `property_measure_id`=?", [$id]);
        $m = new PropertyMeasureHistory();
        if (count($r) > 0) {
            $m->PropertyMeasureId = $r[0]['property_measure_id'];
            $m->TDN               = $r[0]['tdn'];
            $m->Month             = $r[0]['month'];
            $m->Year              = $r[0]['year'];
            $m->Value             = $r[0]['value'];
        }
        return $m;
    }

    public static function GetByTDN($tdn)
    {
        $r = DBx::GetData("SELECT * FROM `property_measure_history` WHERE `tdn`=?", [$tdn]);
        $m = new PropertyMeasureHistory();
        if (count($r) > 0) {
            $m->PropertyMeasureId = $r[0]['property_measure_id'];
            $m->TDN               = $r[0]['tdn'];
            $m->Month             = $r[0]['month'];
            $m->Year              = $r[0]['year'];
            $m->Value             = $r[0]['value'];
        }
        return $m;
    }

    public static function GetByTDNYear($tdn, $year)
    {
        $r = DBx::GetData("SELECT * FROM `property_measure_history` WHERE `tdn`=? AND `year`=?", [$tdn, $year]);
        $m = new PropertyMeasureHistory();
        if (count($r) > 0) {
            $m->PropertyMeasureId = $r[0]['property_measure_id'];
            $m->TDN               = $r[0]['tdn'];
            $m->Month             = $r[0]['month'];
            $m->Year              = $r[0]['year'];
            $m->Value             = $r[0]['value'];
        }
        return $m;
    }

}
