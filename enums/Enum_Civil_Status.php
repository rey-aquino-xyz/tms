<?php

class Enum_Civil_Status
{
    public static function GetStringName($id)
    {
        switch ($id) {
            case 0:
                echo 'Single';
                break;
            case 1:
                echo 'Married';
                break;
            case 2:
                echo 'Separated';
                break;
            case 3:
                echo 'Widow/er';
                break;
            default:
                echo 'Single';
                break;
        }
    }

    public static function Single()
    {
        return 0;
    }
    public static function Married()
    {
        return 1;
    }
    public static function Separated()
    {
        return 2;
    }
    public static function Widowed()
    {
        return 3;
    }
}
