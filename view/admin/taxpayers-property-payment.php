<?php
date_default_timezone_set("Asia/Hong_Kong");
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';
include_once __DIR__ . '../../../utils/DataTable.php';

$PropertyInfo = '';
$UserInfo     = '';

if (isset($_POST['id'])) {
    $PropertyInfo = PropertyController::GetById($_POST['id']);
    $UserInfo     = UserController::GetByUserId($PropertyInfo->UserId);

    // $m              = new Payment();
    // $m->TDN         = $PropertyInfo->TDN;
    // $m->Amount      = 0;
    // $m->DatePaid    = null;
    // $m->TaxYear     = date('Y');
    // $m->Discount    = 0;
    // $m->AssistantId = 0;

    // PaymentController::InsertCurrentYearPayment($m);
}

?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function () {

        $('[name="sampple-tbl"]').DataTable({
            order: [[3, 'asc']],
            rowGroup: {
                dataSrc: 3
            },
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'print',
                    title: '',
                    messageTop: 'List of TDN (Tax Declaration Number)',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                'colvis'
            ],
        });

        $('[name="taxpayer-link"]').on('click', function (e) {
            e.preventDefault();
            $("#main-content").load('taxpayers.php');
        });

        $('[name ="taxpayers-property-link"]').on('click', function (e) {
            e.preventDefault();
            var id = $(this).attr('href');
            $("#main-content").load('taxpayers-property.php', { id: id });
        });


        $('[name="add-payment-link"]').on('click', function (e) {
            e.preventDefault();
            var id =  $(this).attr('href');
             $("#main-content").load('taxpayers-property-payment-add.php', { tdn: '<?=$PropertyInfo->TDN?>'  });
        });

    });
</script>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb h2">
                <li class="breadcrumb-item"><a href="" name="taxpayer-link" class="text-decoration-none">Taxpayers</a>
                </li>
                <li class="breadcrumb-item"><a href="<?=$UserInfo->UserId?>" name="taxpayers-property-link"
                        class="text-decoration-none"><?=$UserInfo->Name?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?=$PropertyInfo->TDN?></li>
            </ol>
        </nav>
    </h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary" name="add-payment-link">Add Payment</button>
        </div>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-striped" name="sampple-tbl">
        <thead>
            <tr>
                <th scope="col">Location</th>
                <th scope="col">Class</th>
                <th scope="col">Assessed Value</th>
                <th scope="col">Tax Year</th>
                <th scope="col">BASIC</th>
                <th scope="col">SEF</th>
                <th scope="col">Penalty</th>
                <th scope="col">Discount</th>
                <th scope="col">Total</th>
                <th scope="col">Arrears</th>
                <th scope="col">Status</th>
                <th scope="col">Options</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (PaymentController::GetByTDN($PropertyInfo->TDN) as $r): ?>
            <tr>

                <!-- LCOATION -->
                <td><?=BarangayController::GetById($PropertyInfo->BrgyId)->Name?></td>
                <!-- LOCATION -->

                <!-- CLASS -->
                <td>
                    <?=Enum_Property_Classification::GetStringName($PropertyInfo->ClassId)?>
                </td>
                <!-- CLASS -->

                <!-- ASSESED VALUE -->
                <td>
                    ₱
                    <?=number_format(PaymentController::GetAssesmentValue($PropertyInfo->TDN, $r['tax_year']))?>
                </td>
                <!-- ASSESED VALUE -->

                <!-- TAX YEAR -->
                <td>
                    <?=$r['tax_year']?>
                </td>
                <!-- TAX YEAR -->
                <?php $AssesmentVal = PaymentController::GetAssesmentValue($PropertyInfo->TDN, $r['tax_year']);?>
                <td>
                    <?=number_format($AssesmentVal * 0.01,2)?>
                </td>
                <td>
                    <?=number_format($AssesmentVal * 0.01, 2)?>
                </td>

                <!-- PENALTY -->
                <td><?=PaymentController::GetPenalty(PaymentController::GetAssesmentValue($PropertyInfo->TDN, $r['tax_year']), $r['tax_year'])?>
                </td>

                <!-- DISCOUNT -->
                <td><?=PaymentController::GetDiscount($AssesmentVal, $r['tax_year'])?></td>

                <!-- TOTAL -->
                <td>
                    <?=number_format((PaymentController::GetTotalToPay($PropertyInfo->TDN, $r['tax_year']) - PaymentController::GetDiscount($AssesmentVal, $r['tax_year'])),2)?>
                </td>
                <?php $Balance = PaymentController::GetBalance($r['tdn'], $r['tax_year'])?>
                <td><?=$Balance > 0 ? $Balance : 0?></td>

                <td><?=$Balance > 0 ? 'Unpaid' :  'Paid'?></td>
                <td>
                    <div class="d-flex">
                        <!-- <a href="<?=$r['tdn_id']?>" class="text-decoration-none me-3" name="view-tdn-information-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-pencil-square me-2" viewBox="0 0 16 16">
                                <path
                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd"
                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                            </svg>Edit
                        </a> -->
                        <a href="<?=$r['tdn']?>" class="text-decoration-none" name="view-tdn-transaction-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-cash me-1" viewBox="0 0 16 16">
                                <path d="M8 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4z" />
                                <path
                                    d="M0 4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V4zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V6a2 2 0 0 1-2-2H3z" />
                            </svg>
                            View Payments
                        </a>

                    </div>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>