<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';
//UTILS
include_once __DIR__ . '../../../utils/DataTable.php';
?>

<script>
    $(document).ready(function () {
        $("#loader").attr("style", "display:none");
        $('[name="sampple-tbl"]').DataTable({
            order: [[2, 'asc']],
            rowGroup: {
            dataSrc: 2
        },
            dom: 'Bfrtip',
            buttons: [
                //  'csv', 'excel', 'pdf',
                {
                    extend: 'print',
                    title: 'Taxpayer List',
                    messageTop: 'Current registered taxpayer',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                'colvis'
            ],
        });

        $('[name="add-taxpayer-link"]').on('click', function (e) {
            e.preventDefault();
            $("#main-content").load('taxpayers-add.php');
        })

        $('[name="edit-info-link"]').on('click', function (e) {
            e.preventDefault();
            var userid = $(this).attr('href');
            $("#main-content").load('taxpayers-edit.php', { id: userid });
        })

        $('[name="view-transction-link"]').on('click', function (e) {
            e.preventDefault();
            var userid = $(this).attr('href');
            $("#main-content").load('taxpayers-property.php', { id: userid });
        })
    });
</script>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Taxpayers</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary" name="add-taxpayer-link">Add New
                Taxpayer</button>
        </div>
    </div>
</div>
<div class="loader" id="loader" data-wordLoad="Loading . . ."></div>
<div class="table-responsive">
    <table class="table table-striped" name="sampple-tbl">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Address</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (AccountController::Get() as $r): ?>
            <?php if ($r['account_role_id'] == Enum_Account_Role::Resident()): ?>
                <?php $User = UserController::GetByUserId($r['user_id']);?>
            <tr>
                <td><?=strtoupper($User->Name)?></td>
                <td><?=$User->Contact?></td>
                <td><?=BarangayController::GetById($User->BarangayId)->Name . ', ' . MunicipalityController::GetById($User->MunicipalityId)->Name . ', ' . ProvinceController::GetById($User->ProvinceId)->Name?>
                </td>
                <td>
                    <div class="d-flex">
                        <a href="<?=$r['user_id']?>" name="edit-info-link" class="me-3 text-decoration-none"> <svg
                                xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-pencil-square me-2" viewBox="0 0 16 16">
                                <path
                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd"
                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                            </svg>Edit</a>
                        <a href="<?=$r['user_id']?>" name="view-transction-link" class="text-decoration-none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-list me-2" viewBox="0 0 16 16">
                                <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                                <path d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zM4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"/>
                              </svg>TDN List</a>
                        <!-- <a href="<?=$r['user_id']?>" name="view-tdn-link" class="text-decoration-none">View TDN</a> -->
                    </div>
                </td>
            </tr>
            <?php endif;?>
            <?php endforeach;?>
        </tbody>
    </table>
</div>