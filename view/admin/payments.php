
<?php
date_default_timezone_set("Asia/Hong_Kong");
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';
//UTILS
include_once __DIR__ . '../../../utils/DataTable.php';
?>
<script>
        $(document).ready(function(){
        $('[name="sampple-tbl"]').DataTable({
            order: [[11, 'desc']],
            rowGroup: {
                dataSrc: 11
            },
            dom: 'Bfrtip',
            buttons: [
            //  'csv', 'excel', 'pdf',
                {
                    extend: 'print',
                    title: 'Barangay',
                    messageTop: 'List of Available Barangay',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                'colvis'
            ],
        });

        $('[name="add-payment-link"]').on('click', function(e){
            e.preventDefault();

        });


        $('[name="view-tdn-transaction-link"]').on('click', function(e){
            e.preventDefault();
            var tdn = $(this).attr('href');
            $("#main-content").load('payments-history.php', { tdn : tdn });
        });

    });
</script>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Payments</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <!-- <button type="button" class="btn btn-sm btn-outline-secondary" name="add-payment-link">Add Payment</button> -->
            <!-- <button type="button" class="btn btn-sm btn-outline-secondary">Export</button> -->
        </div>
        <!-- <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <span data-feather="calendar" class="align-text-bottom"></span>
            This week
        </button> -->
    </div>
</div>

<!-- <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas> -->
<div class="table-responsive">
    <table class="table table-striped table-sm" name="sampple-tbl">
        <thead>
            <tr>
                <th scope="col">Owner</th>
                <th scope="col">PIN No./TDN</th>
                <!-- <th scope="col">Location</th> -->
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
        <?php foreach (PropertyController::Get() as $r): ?>
            <tr>
                <td><?=UserController::GetByUserId($r['user_id'])->Name?></td>
                <td><?=$r['tdn']?></td>
                <!-- LCOATION -->
                <!-- <td><?=BarangayController::GetById($r['brgy_id'])->Name?></td> -->
                <!-- LOCATION -->

                <!-- CLASS -->
                <td>
                    <?=XtraController::GenerateInitials(Enum_Property_Classification::GetStringName($r['class_id']))?>
                </td>
                <!-- CLASS -->

                <!-- ASSESSED VALUE -->
                <?php if ($r['class_id'] == Enum_Property_Classification::Agricultural()): ?>
                <?php $AssesmentVal = ''; ?>
                <td>
                    ₱
                    <?php $AssesmentVal = XtraController::CalculateAgriAssesedValue($r['hectare'], $r['market_value'], AssessmentLevelController::GetByClass($r['class_id'])->Value)?>
                    <?=number_format(XtraController::CalculateAgriAssesedValue($r['hectare'], $r['market_value'], AssessmentLevelController::GetByClass($r['class_id'])->Value))?>
                </td>
                <?php else: ?>
                <td>
                    ₱
                    <?php $AssesmentVal = XtraController::CalculateAssedValue($r['area'], MarketValueController::GetBySubClassAndYear($r['sub_class_id'], date('Y'))->Value, AssessmentLevelController::GetByClass($r['class_id'])->Value)?>
                    <?=number_format(XtraController::CalculateAssedValue($r['area'], MarketValueController::GetBySubClassAndYear($r['sub_class_id'], date('Y'))->Value, AssessmentLevelController::GetByClass($r['class_id'])->Value))?>
                </td>
                <?php endif;?>
                <!-- ASSESED VALUE -->

                <!-- TAX YEAR -->
                <td>
                    <?=date('Y')?>
                </td>
                <!-- TAX YEAR -->
                
                <!-- BASIC -->
                <td>
                    <?=number_format($AssesmentVal * 0.01, 2)?>
                </td>
                <!-- BASIC -->

                <!-- SEF -->
                <td>
                    <?=number_format($AssesmentVal * 0.01, 2)?>
                </td>
                <!-- SEF -->

                <!-- PENALTY -->
                <td><?=PaymentController::GetPenalty($AssesmentVal, date('Y'))?>
                </td>

                <!-- DISCOUNT -->
                <td><?= number_format(PaymentController::GetDiscount($AssesmentVal, date('Y')), 2)?></td>

                <!-- TOTAL -->
                <td>
                    <?=number_format((PaymentController::GetTotalToPay($r['tdn'], date('Y')) - PaymentController::GetDiscount($AssesmentVal, date('Y'))), 2)?>
                </td>

                <?php $Balance = PaymentController::GetBalance($r['tdn'], date('Y'))?>
                <td><?=number_format($Balance, 2)?></td>
                <td><?=number_format($Balance, 2) > 0 ? 'UNPAID' : 'PAID'?></td>
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
                        <a href="<?=base64_encode($r['tdn'])?>" class="text-decoration-none" name="view-tdn-transaction-link">
                            <!-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-cash me-1" viewBox="0 0 16 16">
                                <path d="M8 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4z" />
                                <path
                                    d="M0 4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V4zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V6a2 2 0 0 1-2-2H3z" />
                            </svg> -->
                            Payment History
                        </a>

                    </div>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>