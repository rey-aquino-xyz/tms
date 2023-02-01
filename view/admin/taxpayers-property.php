<?php
date_default_timezone_set("Asia/Hong_Kong");
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';
//UTILS
include_once __DIR__ . '../../../utils/DataTable.php';
$User = '';

if (isset($_POST['id'])) {
    $User = UserController::GetByUserId($_POST['id']);
}


?>


<script>
    $(document).ready(function () {

        $('[name="sampple-tbl"]').DataTable({
            order: [[1, 'asc']],
            rowGroup: {
                dataSrc: 1
            },
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'print',
                    title: '<?=$User->Name?>',
                    messageTop: 'List of TDN (Tax Declaration Number)',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                'colvis'
            ],
            // columnDefs: [{
            //     targets: -1,
            //     visible: false
            // }]
        });

        $('[name="taxpayer-link"]').on('click', function (e) {
            e.preventDefault();
            $("#main-content").load('taxpayers.php');
        });

        $('[name="view-tdn-transaction-link"]').on('click', function (e) {
            e.preventDefault();
            var id = $(this).attr('href');
            $("#main-content").load('taxpayers-property-payment.php', {id:id});
        });

        $('[name="add-tdn-link"]').on('click', function (e) {
            e.preventDefault();
            $("#main-content").load('taxpayers-property-add.php', { id: '<?=$User->UserId?>' });
        })

    });
</script>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb h2">
                <li class="breadcrumb-item"><a href="#" name="taxpayer-link" class="text-decoration-none">Taxpayers</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><?=$User->Name?></li>
            </ol>
        </nav>
    </h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary" name="add-tdn-link">Add New Property</button>
        </div>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-striped" name="sampple-tbl">
        <thead>
            <tr>
                <th scope="col">PIN No./Tax Dec. No.</th>
                <th scope="col">Class</th>
                <th scope="col">Sub Class</th>
                <th scope="col">Location</th>
                <th scope="col">Land Measure</th>
                <th scope="col">Market Value</th>
                <th scope="col">Assessed Value</th>
                <th scope="col">Options</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (PropertyController::GetByUserId($User->UserId) as $r): ?>
            <tr>
                <td>
                    <?=$r['tdn']?>
                </td>
                <td>
                    <?=Enum_Property_Classification::GetStringName($r['class_id'])?>
                </td>
                <?php if($r['class_id'] == Enum_Property_Classification::Agricultural()) :?>
                    <td><?=AgriSubClassController::GetById($r['sub_class_id'])->Name ?? 'N/A'?></td>
                <?php else:?>
                    <td><?=SubClassificationController::GetById($r['sub_class_id'])->Name ?? 'N/A'?></td>
                <?php endif; ?>

                <!-- LOCATION -->
             
                <td><?=BarangayController::GetById($r['brgy_id'])->Name?></td>
                <!-- LAND AREA/MEASURE -->
                <?php if ($r['class_id'] == Enum_Property_Classification::Agricultural()): ?>
                <td>
                    <?=$r['hectare']?> ha
                </td>
                <?php else: ?>
                <td>
                    <?=$r['area']?> sq.m.
                </td>
                <?php endif;?>

                <!-- MARKET VALUE -->
                <?php if ($r['class_id'] == Enum_Property_Classification::Agricultural()): ?>
                <td>₱
                    <?=$r['market_value']?> / hectare
                </td>
                <?php else: ?>
                <td>₱
                    <?=MarketValueController::GetBySubClassAndYear($r['sub_class_id'], date('Y'))->Value?>
                    / sq.m.
                </td>
                <?php endif;?>

                <!-- ASSESSED VALUE -->
                <?php if ($r['class_id'] == Enum_Property_Classification::Agricultural()): ?>
                <td>
                    ₱
                    <?=number_format(XtraController::CalculateAgriAssesedValue($r['hectare'], $r['market_value'], AssessmentLevelController::GetByClass($r['class_id'])->Value))?>
                </td>
                <?php else: ?>
                <td>
                    ₱
                    <?= number_format(XtraController::CalculateAssedValue($r['area'], MarketValueController::GetBySubClassAndYear($r['sub_class_id'], date('Y'))->Value, AssessmentLevelController::GetByClass($r['class_id'])->Value))?>
                </td>
                <?php endif;?>
                <td>
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
                        <!-- <a href="<?=$r['property_id']?>" class="text-decoration-none" name="view-tdn-transaction-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cash me-1" viewBox="0 0 16 16">
                                <path d="M8 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
                                <path d="M0 4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V4zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V6a2 2 0 0 1-2-2H3z"/>
                              </svg>
                              Payments
                        </a> -->

                    </div>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>