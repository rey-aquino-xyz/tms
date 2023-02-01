<?php

class Enum_Property_Classification
{

    public static function GetStringName($id)
    {
        switch ($id) {
            case 1:
                return 'Residential Lands';
                break;
            case 2:
                return 'Agricultural Lands';
                break;
            case 3:
                return 'Commercial Lands';
                break;
            case 4:
                return 'Industrial Lands';
                break;
            case 5:
                return 'Mineral Lands';
                break;
            case 6:
                return 'Timber Lands';
                break;
            case 7:
                return 'Hospital';
                break;
            case 8:
                return 'Machineries';
                break;
            case 9:
                return 'Recreation';
                break;
            case 10:
                return 'Scientific';
                break;
            case 11:
                return 'Cultural';
                break;
            case 12:
                return 'Others';
                break;
            default:
                return 'Residential Lands';
                break;
        }
    }

    public static function Residential()
    {
        return 1;
    }
    public static function Agricultural()
    {
        return 2;
    }
    public static function Commercial()
    {
        return 3;
    }
    public static function Industrial()
    {
        return 4;
    }
    public static function Mineral()
    {
        return 5;
    }
    public static function Timber()
    {
        return 6;
    }
    public static function Hospital()
    {
        return 7;
    }
    public static function Machineries()
    {
        return 8;
    }
    public static function Recreation()
    {
        return 9;
    }
    public static function Scientific()
    {
        return 10;
    }
    public static function Cultural()
    {
        return 11;
    }
    public static function Others()
    {
        return 12;
    }

}
