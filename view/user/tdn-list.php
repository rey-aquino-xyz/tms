<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';
//UTILS
include_once __DIR__ . '../../../utils/DataTable.php';
$User = '';
if (isset($_SESSION['contact'])) {
    $User = UserController::GetByContact($_SESSION['contact']);
}
?>

<script>
    $(document).ready(function () {
        $("#loader").attr("style","display:none");
        $('[name="sampple-tbl"]').DataTable({
            dom: 'Bfrtip',
            buttons: [
                //  'csv', 'excel', 'pdf',
                {
                    extend: 'print',
                    title: 'List of Properties',
                    messageTop: 'Current registered properties',
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
    });
</script>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2>List of Tax Declaration No.</h2>
</div>
<div class="loader" id="loader" data-wordLoad="Please wait. . ."></div>
<div class="table-responsive">
    <table class="table table-striped" name="sampple-tbl">
        <thead>
            <tr>
                <th scope="col">PIN No./Tax Dec. No.</th>
                <th scope="col">Classification</th>
                <th scope="col">Location</th>
                <th scope="col">Assessed Value</th>
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
                <td>
                <?=BarangayController::GetById($r['brgy_id'])->Name . ', ' . MunicipalityController::GetById($r['municipality_id'])->Name, ', ' . ProvinceController::GetById($r['province_id'])->Name?>
                </td>
                <td><?=number_format(PaymentController::GetAssesmentValue($r['tdn'], date('Y')), 2)?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>