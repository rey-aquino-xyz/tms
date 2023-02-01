<?php

class Enum_Account_Role
{
    public static function GetStringName($id)
    {
        switch ($id) {
            case 0:
                echo 'Admin';
                break;
            case 1:
                echo 'Secretary';
                break;
            case 2:
                echo 'Resident';
                break;

            default:
                echo 'Resident';
                break;
        }
    }

    public static function Admin()
    {
        return 0;
    }

    public static function Staff()
    {
        return 1;
    }

    public static function Resident()
    {
        return 2;
    }
}
