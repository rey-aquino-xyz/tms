<?php
date_default_timezone_set('Asia/Hong_Kong');
class XtraController
{

    //Unique Id Generator
    public static function GenerateGUID($data = null)
    {
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);
        $data[6] = chr((ord($data[6]) & 0x0f) | 0x40);
        $data[8] = chr((ord($data[8]) & 0x3f) | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }


    public static function GenerateRandompass()
    {
        return bin2hex(openssl_random_pseudo_bytes(4));
    }

    public static function CalculateDocumentValidity($date_released)
    {
        $str = strtotime(date('Y-m-d H:i:s')) - (strtotime($date_released));
        return floor($str / 3600 / 24);
    }

    public static function AddOrdinalNumberSuffix($num)
    {
        if (!in_array(($num % 100), array(11, 12, 13))) {
            switch ($num % 10) {
                // Handle 1st, 2nd, 3rd
                case 1:return $num . 'st';
                case 2:return $num . 'nd';
                case 3:return $num . 'rd';
            }
        }
        return $num . 'th';
    }

    public static function GenerateOTP()
    {
        return mt_rand(000000, 999999);
    }

    public static function CalculateAssedValue($landMeasure, $baseMarketValue, $classLevel)
    {
        return ($landMeasure * $baseMarketValue) * ($classLevel / 100);
    }

    public static function CalculateAgriAssesedValue($landMeasure, $baseMarketLevel, $classLevel)
    {
        return ($landMeasure * $baseMarketLevel) * ($classLevel / 100);
    }

    public static function GetPenaltyPercent($tax_year)
    {

        $current_date = date('Y-m-d');
        $origin_date  = $tax_year . '-' . 01 . '-' . 01;
        $average_days = 30.436875;

        $d1 = date_create($current_date);
        $d2 = date_create($origin_date);

        $diff  = date_diff($d2, $d1);
        $nDays = $diff->format("%a");

        $tMonths = $nDays / $average_days;
        //var_dump($tMonths);
        // if ($tMonths > 0 && $tMonths <= 3) {
        //     return -1;
        // }
        if ((int)$tMonths >= 34) {
            return 72;
        }

        $penalty = array(
            0 => 1,
            1  => 1,
            2  => 1,
            3  => 1,
            4  => 8,
            5  => 12,
            6  => 16,
            7  => 18,
            8  => 20,
            9  => 22,
            10 => 24,
            11 => 26,
            12 => 28,
            13 => 30,
            14 => 32,
            15 => 34,
            16 => 36,
            17 => 38,
            18 => 40,
            19 => 42,
            20 => 44,
            21 => 46,
            22 => 48,
            23 => 50,
            24 => 52,
            25 => 54,
            26 => 56,
            27 => 58,
            28 => 60,
            29 => 62,
            30 => 64,
            31 => 66,
            32 => 68,
            33 => 70,
            34 => 72,
        );

        foreach ($penalty as $x => $x_val) {
            if ($x == (int)$tMonths) {
                return $x_val;
            }
        }
    }

    public static function GenerateInitials(string $name) : string
    {
        $words = explode(' ', $name);
        if (count($words) >= 2) {
            return mb_strtoupper(
                mb_substr($words[0], 0, 1, 'UTF-8') . 
                mb_substr(end($words), 0, 1, 'UTF-8'), 
            'UTF-8');
        }
        return XtraController::makeInitialsFromSingleWord($name);
    }

    public static function makeInitialsFromSingleWord(string $name) : string
    {
        preg_match_all('#([A-Z]+)#', $name, $capitals);
        if (count($capitals[1]) >= 2) {
            return mb_substr(implode('', $capitals[1]), 0, 2, 'UTF-8');
        }
        return mb_strtoupper(mb_substr($name, 0, 2, 'UTF-8'), 'UTF-8');
    }
}
