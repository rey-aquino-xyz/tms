<?php

include_once __DIR__ . '/../config.php';

class AccountController
{

    public static function Insert(Account $m)
    {
        $Sql = "INSERT INTO `account`(`account_role_id`, `user_id`, `contact`, `pwd`) VALUES (?,?,?,?)";

        $Pwd_Hash = password_hash($m->Password, PASSWORD_BCRYPT);
        try {
            DBx::ExecuteCommand($Sql, [$m->AccountRoleId, $m->UserId, $m->Contact, $Pwd_Hash]);
            return true;
        } catch (\Throwable $th) {

            throw $th;
            return false;
        }
    }

    public static function Get()
    {
        return DBx::GetData("SELECT * FROM account");
    }

    public static function GetByAccountId($account_id)
    {
        $sql    = "SELECT * FROM account WHERE account_id = ?";
        $m      = new Account();
        $result = DBx::GetData($sql, [$account_id]);
        if (count($result) > 0) {

            foreach ($result as $r) {
                $m->AccountId     = $r['account_id'];
                $m->AccountRoleId = $r['account_role_id'];
                $m->UserId        = $r['user_id'];
                $m->Contact       = $r['contact'];
                $m->Password      = $r['pwd'];
            }
        }
        return $m;
    }

    public static function GetByContact($contact)
    {
        $sql    = "SELECT * FROM account WHERE contact = ?";
        $m      = new Account();
        $result = DBx::GetData($sql, [$contact]);
        if (count($result) > 0) {

            foreach ($result as $r) {
                $m->AccountId     = $r['account_id'];
                $m->AccountRoleId = $r['account_role_id'];
                $m->UserId        = $r['user_id'];
                $m->Contact       = $r['contact'];
                $m->Password      = $r['pwd'];
            }
        }
        return $m;
    }

    public static function IsContactExist($contact)
    {
        $sql    = "SELECT * FROM account WHERE contact = ?";
        $result = Dbx::GetData($sql, [$contact]);
        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function Authenticate($contact, $pwd)
    {
        $acc = AccountController::GetByContact($contact);
        if ($contact == $acc->Contact) {
            return password_verify($pwd, $acc->Password);
        }
    }

    public static function UpdatePassword($contact, $pwd)
    {
        $sql      = "UPDATE `account` SET `pwd`=? WHERE `contact` = ?";
        $Pwd_Hash = password_hash($pwd, PASSWORD_BCRYPT);
        try {
            DBx::ExecuteCommand($sql, [$Pwd_Hash, $contact]);
            return true;
        } catch (\Throwable $th) {
            throw $th;
            return false;
        }

    }

    public static function UpdateContact($user_id, $new_contact)
    {
        $sql = "UPDATE `account` SET `contact`=? WHERE `user_id` = ?";

        try {
            DBx::ExecuteCommand($sql, [$new_contact, $user_id]);
            return true;
        } catch (\Throwable $th) {
            throw $th;
            return false;
        }
    }
    //SEED ADMIN ACCOUNT

    public static function SeedTempAdminAccount()
    {
        //CHECK IF HAS ADMIN ACCOUNT
        $sql_check_admin_exist = "SELECT * FROM account WHERE account_role_id = ?";
        if (count(DBx::GetData($sql_check_admin_exist, [Enum_Account_Role::Admin()])) == 0) {
            //NO ADMIN ACCOUNT. CREATE ONE
            $user_id = XtraController::GenerateGUID();

            $u          = new User();
            $u->UserId  = $user_id;
            $u->Name    = 'System Administrator';
            $u->Contact = 'admin@tms.com';
            $u->BarangayId = 0;
            $u->MunicipalityId =0;
            $u->ProvinceId = 0;
            // $u->Address = 'N/A';

            $m = new Account();

            $m->AccountRoleId = Enum_Account_Role::Admin();
            $m->UserId        = $user_id;
            $m->Contact       = 'admin@tms.com';
            $m->Password      = '123';

            try {
                AccountController::Insert($m);
                UserController::Insert($u);
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    }
}
