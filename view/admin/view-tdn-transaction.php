<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';

$TDN = '';
if (isset($_POST['tdn'])) {
   
}

?>


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb h2">
                <li class="breadcrumb-item"><a href="#" name="taxpayer-link" class="text-decoration-none">Taxpayers</a></li>
                <li class="breadcrumb-item"><a href="#" name="taxpayer-link" class="text-decoration-none">[Name]</a></li>
                <li class="breadcrumb-item active" aria-current="page"></li>
            </ol>
        </nav>
    </h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary" name="add-taxpayer-link">Add New TDN</button>
        </div>
    </div>
</div>