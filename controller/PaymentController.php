<?php
date_default_timezone_set("Asia/Hong_Kong");
include_once __DIR__ . '/../config.php';

class PaymentController
{

    public static function Insert(Payment $m): bool
    {
        $sql = "INSERT INTO `payment`(`tdn`, `amount`, `date_paid`, `tax_year`, `discount`, `penalty`, `assistant_id`, `user_id`) VALUES (?,?,?,?,?,?,?,?)";
        try {
            return DBx::ExecuteCommand($sql, [$m->TDN, $m->Amount, $m->DatePaid, $m->TaxYear, $m->Discount, $m->Penalty, $m->AssistantId, $m->UserId]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function UpdateById(Payment $m): bool
    {
        $sql = "UPDATE `payment` SET `tdn`=?,`amount`=?,`date_paid`=?,`tax_year`=?,`discount`=?,`assistant_id`=?, `penalty` =? , `user_id` =? WHERE `payment_id`=?";
        try {
            return DBx::ExecuteCommand($sql, [$m->TDN, $m->Amount, $m->DatePaid, $m->TaxYear, $m->Discount, $m->AssistantId, $m->Penalty, $m->UserId, $m->AssistantId]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function Get()
    {
        return DBx::GetData("SELECT * FROM `payment`");
    }

    public static function GetByTDN($tdn)
    {
        return DBx::GetData("SELECT * FROM `payment` WHERE `tdn` =?", [$tdn]);
    }

    public static function GetById($payment_id): Payment
    {
        $r = DBx::GetData("SELECT * FROM `payment` WHERE `payment_id` =?", [$payment_id]);
        $m = new Payment();
        if (count($r) > 0) {
            $m->PaymentId   = $r[0]['payment_id'];
            $m->TDN         = $r[0]['tdn'];
            $m->DatePaid    = $r[0]['date_paid'];
            $m->TaxYear     = $r[0]['tax_year'];
            $m->Discount    = $r[0]['discount'];
            $m->Penalty     = $r[0]['penalty'] ?? 0;
            $m->AssistantId = $r[0]['assistant_id'];
            $m->UserId      = $r[0]['user_id'];

        }
        return $m;
    }

    public static function HasCurrentYearPayment($tdn)
    {
        $r = Dbx::GetData("SELECT * FROM `payment` WHERE `tdn` =? AND `tax_year` =?", [$tdn, date('Y')]);
        if (count($r) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function GetAssesmentValue($tdn, $tax_year)
    {
        //GET PROPERTY INFO
        $p_info = PropertyController::GetByTDN($tdn);
        //GET IF HAS CHANGE IS MEASUREMENT
        $p_measure_history = PropertyMeasureHistoryController::GetByTDNYear($tdn, $tax_year);

        $AssesementValue = 0;

        if ($p_info->ClassId == Enum_Property_Classification::Agricultural()) {
            $AssesementValue = XtraController::CalculateAgriAssesedValue($p_measure_history->Value ?? $p_info->Hectare, $p_info->MarketValue, AssessmentLevelController::GetByClass($p_info->ClassId)->Value);
        } else {
            $AssesementValue = XtraController::CalculateAgriAssesedValue($p_measure_history->Value ?? $p_info->Area, MarketValueController::GetBySubClassAndYear($p_info->SubClassId, $tax_year)->Value, AssessmentLevelController::GetByClass($p_info->ClassId)->Value);
        }
        return $AssesementValue;
    }

    public static function GetTotalToPay($tdn, $tax_year)
    {
        $AssesValue = PaymentController::GetAssesmentValue($tdn, $tax_year);
        $Penalty    = PaymentController::GetPenalty($AssesValue, $tax_year);
        $BasicSEF   = ($AssesValue * 0.01) * 2;
        return $BasicSEF + $Penalty;
    }

    public static function HasAlreadyDiscount($tdn, $tax_year)
    {
        $result = DBx::GetData("SELECT sum(discount) as d FROM payment WHERE tdn = ? AND tax_year =?", [$tdn, $tax_year]);
        return $result[0]['d'];
    }

    public static function GetDiscount($assess_value, $tax_year)
    {
        $Discount    = 0;
        $PenaltyRate = XtraController::GetPenaltyPercent($tax_year);

        if ($PenaltyRate < 8) {

            $Discount = ($assess_value * 0.01) * 2 * 0.1;
        }
        return $Discount;
    }
    public static function GetPenalty($assess_value, $tax_year)
    {
        $Penalty     = 0;
        $PenaltyRate = XtraController::GetPenaltyPercent($tax_year);
        if ($PenaltyRate >= 8) {
            $Penalty = $assess_value * ($PenaltyRate / 100);
        }
        return number_format($Penalty, 2);
    }

    public static function GetBalance($tdn, $tax_year)
    {
        //FIRST CALCULATE TOTAL TO BE PAID
        $Discount    = PaymentController::GetDiscountFromDB($tdn, $tax_year);
        $amountToPay = PaymentController::GetTotalToPay($tdn, $tax_year);
        //GET ALL PAYMENT IF MADE
        $totalPaymentMade = PaymentController::GetTotalPayment($tdn, $tax_year);
        return $amountToPay - $totalPaymentMade - $Discount;
    }

    public static function GetDiscountFromDB($tdn, $tax_year)
    {
        $r = DBx::GetData("SELECT SUM(discount) as a FROM `payment` WHERE `tdn` =? AND `tax_year` =?", [$tdn, $tax_year]);
        return $r[0]['a'] ?? 0;
    }

    public static function GetTotalPayment($tdn, $tax_year)
    {
        $r = DBx::GetData("SELECT SUM(amount) as a FROM `payment` WHERE `tdn` =? AND `tax_year` =?", [$tdn, $tax_year]);
        return $r[0]['a'] ?? 0;
    }

    // ADD PAYMETN IF HAS NO RECORD
    public static function InsertCurrentYearPayment(Payment $m)
    {

        //CHECK IF HAS NO RECORD
        if (PaymentController::HasCurrentYearPayment($m->TDN) == false) {
            //INSERT
            PaymentController::Insert($m);
        }
    }
    public static function GetTaxYearByTDN($tdn)
    {
        $sql = "SELECT tax_year FROM `payment` WHERE tdn = ?  GROUP BY tax_year ORDER BY tax_year DESC";
        return DBx::GetData($sql, [$tdn]);
    }

    // DASBOARD
    public static function GetAllCollection()
    {
        $sql = "SELECT SUM(amount) as a FROM payment WHERE tax_year =? ";
        $r   = DBx::GetData($sql, [date('Y')]);
        if (count($r) > 0) {
            return $r[0]['a'];
        } else {
            return 0;
        }
    }

    public static function GetAllPenalties()
    {
        $sql = "SELECT SUM(penalty) as a FROM payment WHERE tax_year =? ";
        $r   = DBx::GetData($sql, [date('Y')]);
        if (count($r) > 0) {
            return $r[0]['a'];
        } else {
            return 0;
        }
    }

    public static function GetAllCollectionByTDN($tdn)
    {
        $sql = "SELECT SUM(amount) as a FROM payment WHERE tax_year =? AND tdn = ?";
        $r   = DBx::GetData($sql, [date('Y'), $tdn]);
        if (count($r) > 0) {
            return $r[0]['a'];
        } else {
            return 0;
        }
    }

    public static function GetPaymentByUserId($user_id)
    {
        $sql = "SELECT * FROM `payment` WHERE user_id = ?  ORDER BY date_paid DESC";
        return DBx::GetData($sql, [$user_id]);
    }
}
