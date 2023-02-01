<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';
//UTILS
include_once __DIR__ . '../../../utils/DataTable.php';
?>
<script>
    $(document).ready(function () {
        $('[name="sampple-tbl"]').DataTable({
            dom: 'Bfrtip',
            buttons: [
                //  'csv', 'excel', 'pdf',
                {
                    extend: 'print',
                    title: 'Unit Market Value',
                    messageTop: 'List of Agriculture Market Value',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                'colvis'
            ],
        });

        $('[name="add-link"]').on('click', function (e) {
            e.preventDefault();
            $("#main-content").load('agriculture-market-value-add.php');
        });

        $('[name="edit-link"]').on('click', function (e) {
            e.preventDefault();
            var id = $(this).attr('href');
            $("#main-content").load('agriculture-market-value-edit.php', { id: id });
        });
    });
</script>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Agriculture Market Value (Per Hectare)</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary" name="add-link">Add Agriculture Market
                Value</button>
        </div>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-striped" name="sampple-tbl">
        <thead>
            <tr>
                <th scope="col">LANDS</th>
                <th scope="col">1ST</th>
                <th scope="col">2ND</th>
                <th scope="col">3RD</th>
                <th scope="col">4TH</th>
                <th scope="col">5TH</th>
                <th scope="col">6TH</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (AgriMarketValueController::Get() as $r): ?>
            <tr>
                <td><?=strtoupper(AgriSubClassController::GetById($r['agri_sub_class_id'])->Name)?></td>
                <td>
                    <?=$r['1st']?>
                </td>
                <td>
                    <?=$r['2nd']?>
                </td>
                <td>
                    <?=$r['3rd']?>
                </td>
                <td>
                    <?=$r['4th']?>
                </td>
                <td>
                    <?=$r['5th']?>
                </td>
                <td>
                    <?=$r['6th']?>
                </td>
                <td>
                    <div class="d-flex">
                        <a href="<?=$r['agri_market_value_id']?>" name="edit-link" class="me-3 text-decoration-none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-pencil-square me-2" viewBox="0 0 16 16">
                                <path
                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd"
                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                            </svg>Edit
                        </a>
                    </div>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>