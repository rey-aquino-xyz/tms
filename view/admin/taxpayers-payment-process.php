<?php
date_default_timezone_set("Asia/Hong_Kong");
include_once __DIR__ . '../../../config.php';

if (isset($_POST['g_paymentRecord'])) {
    //TAX YEAR
    $tax_year = $_POST['tax_year'];
    //TDN
    $tdn = $_POST['tdn'];

    $AssessValue = PaymentController::GetAssesmentValue($tdn, $tax_year);
    $Basic       = $AssessValue * 0.01;
    $SEF         = $AssessValue * 0.01;

    $Penalty = PaymentController::GetPenalty($AssessValue, $tax_year) ?? 0;
    $Balance = PaymentController::GetTotalPayment($tdn, $tax_year);

    $TotalToPay = 0;
    //CHECK IF LAREADY ISSUED DISCOUNT
    
    $NewDiscount = PaymentController::GetDiscount($AssessValue, $tax_year) ?? 0;
    $Discount = PaymentController::HasAlreadyDiscount($tdn, $tax_year); 
    if ($Discount > 0) {
        $TotalToPay = (($Basic + $SEF + $Penalty) - $Discount) - $Balance;
    } else {
        $TotalToPay = (($Basic + $SEF + $Penalty) - $NewDiscount) - $Balance;
    }

    // $TotalToPay = (($Basic + $SEF + $Penalty) - $Discount) - $Balance;

    $result  = [];
    $r_array = array("assess_val" => $AssessValue, "basic" => $Basic, "sef" => $SEF, "penalty" => $Penalty, "discount" => $Discount > 0 ? 0: $NewDiscount , "total" => $TotalToPay);
    array_push($result, $r_array);

    echo json_encode($result);

}

if (isset($_POST['add_payment'])) {
    $tdn          = $_POST['tdn'];
    $date_paid    = $_POST['date'];
    $tax_year     = $_POST['tax_year'];
    $discount     = $_POST['discount'];
    $penalty      = $_POST['penalty'];
    $assistant_id = $_POST['assistant_id'];
    $amount       = $_POST['amount'];
    $userid       = $_POST['userid'];

    $m              = new Payment();
    $m->TDN         = $tdn;
    $m->DatePaid    = $date_paid;
    $m->TaxYear     = $tax_year;
    $m->Discount    = $discount;
    $m->Penalty     = $penalty;
    $m->Amount      = $amount;
    $m->AssistantId = $assistant_id;
    $m->UserId      = $userid;

    if (PaymentController::Insert($m)) {
        echo 't';
    } else {
        echo 'f';
    }
}
