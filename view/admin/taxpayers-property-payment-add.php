<?php
date_default_timezone_set("Asia/Hong_Kong");
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';

$TDN          = '';
$UserInfo     = '';
$PropertyInfo = '';
if (isset($_POST['tdn'])) {
    // $TDN  = $_POST['TDN'];
    // $Year = $_POST['Year'];
    $TDN          = base64_decode($_POST['tdn']);
    $UserInfo     = UserController::GetByUserId(PropertyController::GetByTDN(base64_decode($_POST['tdn']))->UserId);
    $PropertyInfo = PropertyController::GetByTDN(base64_decode($_POST['tdn']));
    // var_dump($UserInfo);
    //CREATE RECORD IF HAS NONE FOR THE CURRENT YEAR

}

?>

<script>
    $(document).ready(function () {
        $('[name="payments-link"]').on('click', function (e) {
            e.preventDefault();
            $("#main-content").load('payments.php');
        });
        $('[name="taxpayers-property-link"]').on('click', function (e) {
            e.preventDefault();
            $("#main-content").load('taxpayers-property.php', { id: '<?=$UserInfo->UserId?>' });
        });
        $('[name="payments-history-link"]').on('click', function (e) {
            e.preventDefault();
            $("#main-content").load('payments-history.php', { tdn: '<?=base64_encode($PropertyInfo->TDN)?>'});
        });

        $('[name="add-payment-form"]').on('submit', function (e) {
            e.preventDefault();
            var tdn = document.getElementById("inputTDN");
            var tax_year = document.getElementById("selectTaxYear");
            var penalty = document.getElementById("inputPenalty");
            var discount = document.getElementById("inputDiscount");
            var amount = document.getElementById("inputAmount");
            var date = document.getElementById("inputDate");
            var assistant_id = document.getElementById("selectAssistant");
            
       

            $.post('taxpayers-payment-process.php', {
                add_payment: 'POST',
                tdn: tdn.value, date: date.value, tax_year: tax_year.value, discount: discount.value, penalty: penalty.value, assistant_id: assistant_id.value, amount: amount.value, userid: '<?=$UserInfo->UserId?>'
            }, function (result) {
                if (result.trim() == 't') {
                    //ALL GOODS
                    swal("Payment Added Successfully", "You can add another one.", "success", { button: false });
                    $('[name="add-payment-form"]')[0].reset();
                    $("#main-content").load('payments-history.php', { tdn: '<?=base64_encode($PropertyInfo->TDN)?>' });
                } else {
                    //ERROR
                    swal("Something Went Wrong", "Please try again later", "error", { button: false });
                }
            });

        });


    });

    function getPaymentRecord(tax_year) {
        var tdn = document.getElementById("inputTDN");
        var assess_value = document.getElementById("inputAssessValue");
        var basic = document.getElementById("inputBasic");
        var sef = document.getElementById("inputSEF");
        var penalty = document.getElementById("inputPenalty");
        var discount = document.getElementById("inputDiscount");
        var total = document.getElementById("inputTotal");

        $.post('taxpayers-payment-process.php', { g_paymentRecord: 'POST', tax_year: tax_year, tdn: tdn.value }, function (result) {

            var obj = JSON.parse(result);
            console.log(obj);

            assess_value.value = parseFloat(obj[0]['assess_val']).toFixed(2);
            basic.value = parseFloat(obj[0]['basic']).toFixed(2);
            var sef_v = parseFloat(obj[0]['sef']).toFixed(2);
            sef.value = sef_v.toLocaleString("en-US");
            penalty.value = parseFloat(obj[0]['penalty']).toFixed(2);
            discount.value = parseFloat(obj[0]['discount']).toFixed(2);
            total.value = parseFloat(obj[0]['total']).toFixed(2);
        });
    }


    function getCalculatedBalance(value) {
        //alert(date);
        if (this.value < 0) { this.value = this.value * -1 };
        var total = document.getElementById("inputTotal");
        var balance = document.getElementById("inputBalance");

        balance.value = total.value - value;
    }
</script>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb h2">
                <li class="breadcrumb-item"><a href="#" name="payments-link" class="text-decoration-none">Payments</a></li>
                <li class="breadcrumb-item"><a href="#" name="payments-history-link" class="text-decoration-none"><?=$TDN?></a></li>
                <li class="breadcrumb-item active" aria-current="page">Adding Payment</li>
            </ol>
        </nav>
    </h2>
</div>



<form action="" name="add-payment-form" class="row g-3">

    <div class="col-md-6">
        <label for="inputTDN" class="form-label">PIN No. / Tax Dec. No</label>
        <input type="text" class="form-control" id="inputTDN" value="<?=$TDN?>" disabled>
    </div>
    <div class="col-md-6">
        <label for="selectTaxYear" class="form-label">Tax Year</label>
        <select id="selectTaxYear" name="p_taxyear" onchange="getPaymentRecord(this.value);" class="form-select"
            required>
            <option value="0">-- SELECT TAX YEAR --</option>
            <?php $GetYears = PaymentController::GetTaxYearByTDN($TDN); ?>
            <?php if(count($GetYears) > 0):?>
            <?php foreach (PaymentController::GetTaxYearByTDN($TDN) as $r): ?>
            <option value="<?=$r['tax_year']?>">
                <?=$r['tax_year']?>
            </option>
            <?php endforeach;?>
            <?php else: ?>
                <option value="<?=date('Y')?>"><?=date('Y')?></option>
            <?php endif;?>
        </select>
    </div>

    <div class="col-md-6">
        <label for="inputAssessValue" class="form-label">Assesed Value</label>
        <input type="text" class="form-control" id="inputAssessValue" value="" disabled>
    </div>

    <div class="col-md-6">
        <label for="inputDate" class="form-label">Date Paid</label>
        <input type="date" class="form-control" id="inputDate" onchange="getPaymentCalculation(this.value);" required>
    </div>

    <div class="col-md-6">
        <label for="inputBasic" class="form-label">BASIC</label>
        <input type="text" class="form-control" id="inputBasic" value="" disabled>
    </div>

    <div class="col-md-6">
        <label for="inputSEF" class="form-label">SEF</label>
        <input type="text" class="form-control" id="inputSEF" value="" disabled>
    </div>

    <div class="col-md-6">
        <label for="inputPenalty" class="form-label">Penalty</label>
        <input type="text" class="form-control" id="inputPenalty" value="" disabled>
    </div>
    <div class="col-md-6">
        <label for="inputDiscount" class="form-label">Discount</label>
        <input type="text" class="form-control" id="inputDiscount" value="" disabled>
    </div>
    <div class="col-md-12">
        <label for="inputTotal" class="form-label">Amount to Pay</label>
        <input type="number" class="form-control" id="inputTotal" value="" required disabled>
    </div>
    <div class="col-md-6">
        <label for="inputAmount" class="form-label">Amount</label>
        <input type="text" class="form-control" id="inputAmount" onkeyup="getCalculatedBalance(this.value)" required>
    </div>

    <div class="col-md-6">
        <label for="selectAssistant" class="form-label">Attending Officer</label>
        <select id="selectAssistant" name="assistant" class="form-select" required>
            <?php foreach (AssistantController::Get() as $r): ?>
            <option value="<?=$r['assistant_id']?>">
                <?=$r['name']?>
            </option>
            <?php endforeach;?>
        </select>
    </div>

    <div class="col-md-12">
        <label for="inputBalance" class="form-label">Balance</label>
        <input type="number" class="form-control" id="inputBalance" value="" required disabled>
    </div>

    <div class="d-flex">
        <button type="submit" class="btn btn-primary btn-md">Save Payment</button>
    </div>
</form>
<br><br><br>