<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';
//UTILS
include_once __DIR__ . '../../../utils/DataTable.php';
?>
<script>
        $(document).ready(function(){
        $('[name="sampple-tbl"]').DataTable({
            order: [[1, 'asc']],
            rowGroup: {
            dataSrc: 1
        },
            dom: 'Bfrtip',
            buttons: [
            //  'csv', 'excel', 'pdf',
                {
                    extend: 'print',
                    title: 'Municipality',
                    messageTop: 'List of Available Municipality',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                'colvis'
            ],
        });

        $('[ name="add-link"]').on('click', function(e){
            e.preventDefault();
            $("#main-content").load('municipality-add.php');
        });

        $('[name="edit-link" ]').on('click', function(e){
            e.preventDefault();
            var province_id = $(this).attr('href');
            $("#main-content").load('municipality-edit.php', {id: province_id});
        });
    });
</script>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Municipality</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary" name="add-link">Add New
                Municipality</button>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped" name="sampple-tbl">
        <thead>
            <tr>
                <th scope="col">Municipality</th>
                <th scope="col">Province</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (MunicipalityController::Get() as $r): ?>
            <tr>
                <td><?=strtoupper($r['name'])?></td>
                <td><?=ProvinceController::GetById($r['province_id'])->Name?></td>
                <td>
                    <div class="d-flex">
                        <a href="<?=$r['municipality_id']?>" name="edit-link" class="me-3 text-decoration-none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-pencil-square me-2" viewBox="0 0 16 16">
                                <path
                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd"
                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                            </svg>Edit</a>
                    </div>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>