<?php

include_once __DIR__ . '/../config.php';

class UserController
{

    public static function Insert(User $m): bool
    {
        $sql = "INSERT INTO `user`(`user_id`, `contact`, `name`, `barangay_id`, `municipality_id`, `province_id`) VALUES (?,?,?,?,?,?)";
        try {
            return Dbx::ExecuteCommand($sql, [$m->UserId, $m->Contact, $m->Name, $m->BarangayId, $m->MunicipalityId, $m->ProvinceId]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function UpdateByUserId(User $m): bool
    {
        $sql = "UPDATE `user` SET `contact`=?,`name`=?,`barangay_id`=?,`municipality_id`=?,`province_id`=? WHERE `user_id`=?";
        try {
            return DBx::ExecuteCommand($sql, [$m->Contact, $m->Name, $m->BarangayId, $m->MunicipalityId, $m->ProvinceId, $m->UserId]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function UpdateContact($user_id, $new_contact)
    {
        $sql = "UPDATE `user` SET `contact`=? WHERE `user_id`=?";
        try {
            return DBx::ExecuteCommand($sql, [$new_contact, $user_id]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public static function IsContactExist($contact): bool
    {
        $sql    = "SELECT `user_id`, `contact`, `address`, `name` FROM `user` WHERE `contact`=?";
        $result = DBx::GetData($sql, [$contact]);
        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function Get()
    {
        return DBx::GetData("SELECT * FROM user");
    }

    public static function GetByUserId($user_id): User
    {
        $result = DBx::GetData("SELECT * FROM user WHERE user_id =?", [$user_id]);
        $m      = new User();
        if (count($result) > 0) {
            foreach ($result as $r) {
                $m->UserId         = $r['user_id'];
                $m->Name           = $r['name'];
                $m->Contact        = $r['contact'];
                $m->BarangayId     = $r['barangay_id'];
                $m->MunicipalityId = $r['municipality_id'];
                $m->ProvinceId     = $r['province_id'];
            }
        }
        return $m;
    }
    public static function GetByContact($contact): User
    {
        $result = DBx::GetData("SELECT * FROM user WHERE contact =?", [$contact]);
        $m      = new User();
        if (count($result) > 0) {
            foreach ($result as $r) {
                $m->UserId         = $r['user_id'];
                $m->Name           = $r['name'];
                $m->Contact        = $r['contact'];
                $m->BarangayId     = $r['barangay_id'];
                $m->MunicipalityId = $r['municipality_id'];
                $m->ProvinceId     = $r['province_id'];
            }
        }
        return $m;
    }
}
