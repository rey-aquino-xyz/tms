<?php
include_once __DIR__ . '/../config.php';

class AssessmentLevelController
{
    public static function Insert(AssessmentLevel $m): bool
    {
        $sql = "INSERT INTO `assessment_level`(`class_id`, `value`) VALUES (?,?)";
        try {
            return DBx::ExecuteCommand($sql, [$m->ClassificationId, $m->Value]);
        } catch (\Throwable $th) {
            throw $th;
        }

    }

    public static function UpdateValByClass(AssessmentLevel $m): bool
    {
        $sql = "UPDATE `assessment_level` SET `value`=? WHERE `class_id`=?";
        try {
            return DBx::ExecuteCommand($sql, [$m->Value, $m->ClassificationId]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function Get()
    {
        return DBx::GetData("SELECT `assessment_level_id`, `class_id`, `value` FROM `assessment_level`");
    }
    public static function GetByClass($class_id)
    {
        $r = DBx::GetData("SELECT * FROM `assessment_level` WHERE `class_id`=?", [$class_id]);
        $m = new AssessmentLevel();
        if (count($r) > 0) {
            $m->AssessmentLevelId = $r[0]['assessment_level_id'];
            $m->ClassificationId  = $r[0]['class_id'];
            $m->Value             = $r[0]['value'];
        }
        return $m;
    }
    public static function HasDuplicate($class_id): bool
    {
        $r = DBx::GetData("SELECT * FROM `assessment_level` WHERE class_id=?", [$class_id]);
        if (count($r) > 0) {
            return true;
        } else {
            return false;
        }
    }

}
