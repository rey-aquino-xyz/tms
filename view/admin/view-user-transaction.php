<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';
//UTILS
include_once __DIR__ . '../../../utils/DataTable.php';
$User = '';

if (isset($_POST['userid'])) {
    $User = UserController::GetByUserId($_POST['userid']);
}

?>


<script>
    $(document).ready(function () {

        $('[name="sampple-tbl"]').DataTable({
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
            $("#main-content").load('users.php');
        });

        $('[name ="view-tdn-transaction-link"]').on('click', function (e) {
            e.preventDefault();
            $("#main-content").load('view-tdn-transaction.php');
        });
        $('[name="add-tdn-link"]').on('click', function(e){
            e.preventDefault();
            $("#main-content").load('add-tdn.php', {userid : '<?=$User->UserId?>'});
        })

        $('[name="view-tdn-information-link"]').on('click', function(e){
            e.preventDefault();
            var tdnid = $(this).attr('href');
            $("#main-content").load('view-tdn-information.php', {tdn_id : tdnid});
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
            <button type="button" class="btn btn-sm btn-outline-secondary" name="add-tdn-link">Add New TDN</button>
        </div>
    </div>
</div>
<h6>List of Tax Declaration No.</h6>
<hr>
<div class="table-responsive">
    <table class="table table-striped" name="sampple-tbl">
        <thead>
            <tr>
                <th scope="col">PIN No./Tax Dec. No.</th>
                <th scope="col">Classification</th>
                <th scope="col">Location</th>
                <th scope="col">Assessed Value</th>
                <th scope="col">Options</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (TDNController::GetByUserId($User->UserId) as $r): ?>
            <tr>
                <td><?=$r['pin']?></td>
                <td><?=Enum_TDN_Classification::GetStringName($r['classification_id'])?></td>
                <td><?=$r['location']?></td>
                <td>0.00</td>
                <td>
                    <div class="d-flex">
                        <a href="<?=$r['tdn_id']?>" class="text-decoration-none me-3" name="view-tdn-information-link">Edit Information</a>
                        <a href="<?=$r['tdn_id']?>" class="text-decoration-none" name="view-tdn-transaction-link">View Payments</a>
                        <!-- <a href="<?=$r['tdn_id']?>" name="view-transction-link" class="text-decoration-none">View Transaction</a> -->
                        <!-- <a href="<?=$r['user_id']?>" name="view-tdn-link" class="text-decoration-none">View TDN</a> -->
                    </div>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>