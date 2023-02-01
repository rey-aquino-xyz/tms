<?php
date_default_timezone_set("Asia/Hong_Kong");
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';
//UTILS
include_once __DIR__ . '../../../utils/DataTable.php';

$PropertyInfo = '';
$UserInfo     = '';
$Balance      = '';
if (isset($_POST['tdn'])) {
    $PropertyInfo = PropertyController::GetByTDN(base64_decode($_POST['tdn']));
    $UserInfo     = UserController::GetByUserId($PropertyInfo->UserId);
    $Balance      = PaymentController::GetBalance($PropertyInfo->TDN, date('Y'));
}

?>

<script>
    $(document).ready(function () {

        $('[name="sampple-tbl"]').DataTable({
            order: [[1, 'asc']],
            rowGroup: {
            endRender: function ( rows, group ) {
                return 'BALANCE:  ₱ <?=number_format($Balance, 2)?>';
            },
                dataSrc: 1
            },
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'print',
                    title: '<?=$UserInfo->Name?>',
                    messageTop: '<?=$PropertyInfo->TDN?>',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                'colvis'
            ],
        });

        $('[name="payments-link"]').on('click', function (e) {
            e.preventDefault();
            $("#main-content").load('payment.php');
        });

        $('[name="add-payment-link"]').on('click', function (e) {
            e.preventDefault();
            var id =  $(this).attr('href');
             $("#main-content").load('taxpayers-property-payment-add.php', { tdn: '<?=base64_encode($PropertyInfo->TDN)?>'  });
        });

    });
</script>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb h2">
                <li class="breadcrumb-item"><a href="" name="payments-link" class="text-decoration-none">Payments</a></li>
                <li class="breadcrumb-item active" aria-current="page">Payment History / <?=$PropertyInfo->TDN?></li>
            </ol>
        </nav>
    </h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <!-- <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary" name="add-payment-link">Add Payment</button>
        </div> -->
    </div>
</div>
<div class="table-responsive">
    <table class="table table-striped" name="sampple-tbl">
        <thead>
            <tr>
                <th scope="col">Date Paid</th>
                <th scope="col">Tax Year</th>
                <th scope="col">Amount</th>
                <th scope="col">Discount</th>
                <th scope="col">Penalty</th>
                <th scope="col">Attending Officer</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (PaymentController::GetByTDN($PropertyInfo->TDN) as $r): ?>
            <tr>
                <td><?=$r['date_paid']?></td>
                <td><?=$r['tax_year']?></td>
                <td><?=number_format($r['amount'], 2)?></td>
                <td><?=number_format($r['discount'], 2)?></td>
                <td><?=number_format($r['penalty'], 2)?></td>
                <td><?=AssistantController::GetById($r['assistant_id'])->Name?></td>

                <!-- <td>
                    <div class="d-flex">
                        <a href="<?=$r['tdn_id']?>" class="text-decoration-none me-3" name="view-tdn-information-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-pencil-square me-2" viewBox="0 0 16 16">
                                <path
                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd"
                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                            </svg>Edit
                        </a>
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
                </td> -->
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>