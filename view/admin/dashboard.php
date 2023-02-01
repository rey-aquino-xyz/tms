
<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';
//UTILS
include_once __DIR__ . '../../../utils/DataTable.php';


// echo XtraController::GetPenaltyPercent(2020);
?>
<!-- APEX CHART -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    $(document).ready(function () {
        $('[name="sampple-tbl"]').DataTable({
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

    });
    {
        $.getJSON('dashboard-process.php', { x_taxpayer: 'EDIWOW' }, function (response) {

            // console.log(response);
            var obj = JSON.stringify(response);
            var obj = JSON.parse(obj);
            var values = [];
            var header = [];
            for (var i in obj) {
                values.push(parseInt(obj[i].count));
                header.push(obj[i].brgy);
            }

            var options = {
                chart: {
                    type: 'donut'
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '50%',
                            labels: {
                                show: true,
                            }
                        },
                        customScale: 1
                    }
                },
                dataLabels: {
                    enabled: true,
                    // formatter: function (val) {
                    //     return val + "%"
                    // }
                },
                series: values,
                labels: header,
                title: {
                    text: '',
                },
                noData: {
                    text: 'Loading . . .'
                }
            }

            var chart = new ApexCharts(document.querySelector("#chart"), options);

            chart.render();
        });

        // $.getJSON('dashboard-process.php', { x_property: 'AKOPOGI' }, function (response) {
        //     // var obj = JSON.stringify(response);
        //     // var obj = JSON.parse(obj);
        //     var values = [];
        //     var header = [];
        //     for (var i in response) {
        //         values.push(parseInt(response[i].count));
        //         header.push(response[i].type);
        //     }

        //     var options = {
        //         chart: {
        //             type: 'bar'
        //         },
        //         dataLabels: {
        //             enabled: false,
        //             // formatter: function (val) {
        //             //     return val + "%"
        //             // }
        //         },
        //         series: [
        //             {
        //                 name: 'Classification',
        //                 data: values
        //             }
        //         ],
        //         xaxis: {
        //             categories: header
        //         }
        //     }

        //     var chart = new ApexCharts(document.querySelector("#document-chart"), options);

        //     chart.render();
        // });
    }

</script>
<style>
    .c-dashboardInfo {
        margin-bottom: 15px;
    }

    .c-dashboardInfo .wrap {
        background: #ffffff;
        box-shadow: 2px 10px 20px rgba(0, 0, 0, 0.1);
        border-radius: 7px;
        text-align: center;
        position: relative;
        overflow: hidden;
        padding: 40px 25px 20px;
        height: 100%;
    }

    .c-dashboardInfo__title,
    .c-dashboardInfo__subInfo {
        color: #6c6c6c;
        font-size: 1.18em;
    }

    .c-dashboardInfo span {
        display: block;
    }

    .c-dashboardInfo__count {
        font-weight: 600;
        font-size: 2.5em;
        line-height: 64px;
        color: #323c43;
    }

    .c-dashboardInfo .wrap:after {
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 10px;
        content: "";
    }

    .c-dashboardInfo:nth-child(1) .wrap:after {
        background: linear-gradient(82.59deg, #00c48c 0%, #00a173 100%);
    }

    .c-dashboardInfo:nth-child(2) .wrap:after {
        background: linear-gradient(81.67deg, #0084f4 0%, #1a4da2 100%);
    }

    .c-dashboardInfo:nth-child(3) .wrap:after {
        background: linear-gradient(69.83deg, #0084f4 0%, #00c48c 100%);
    }

    .c-dashboardInfo:nth-child(4) .wrap:after {
        background: linear-gradient(81.67deg, #ff647c 0%, #1f5dc5 100%);
    }

    .c-dashboardInfo__title svg {
        color: #d7d7d7;
        margin-left: 5px;
    }

    .MuiSvgIcon-root-19 {
        fill: currentColor;
        width: 1em;
        height: 1em;
        display: inline-block;
        font-size: 24px;
        transition: fill 200ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
        user-select: none;
        flex-shrink: 0;
    }
</style>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
    <!-- <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
        </div>
        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <span data-feather="calendar" class="align-text-bottom"></span>
            This week
        </button>
    </div> -->
</div>
<div class="container">
    <div id="root">
        <div class="container pt-5">
            <div class="row align-items-stretch">
                <div class="c-dashboardInfo col-lg-3 col-md-6">
                    <div class="wrap">
                        <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">Total
                            Collection (<?=date('Y')?>)
                        </h4><span class="hind-font caption-12 c-dashboardInfo__count">
                            <?=number_format(PaymentController::GetAllCollection(),2)?>
                        </span>
                    </div>
                </div>
                <div class="c-dashboardInfo col-lg-3 col-md-6">
                    <div class="wrap">
                        <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">Total Penalties</h4>
                        <span class="hind-font caption-12 c-dashboardInfo__count">
                        <?=number_format(PaymentController::GetAllPenalties(),2)?>
                        </span>
                    </div>
                </div>
                <div class="c-dashboardInfo col-lg-3 col-md-6">
                    <div class="wrap">
                        <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">Total Taxpayers</h4>
                        <span class="hind-font caption-12 c-dashboardInfo__count">
                            <?=count(UserController::Get()) -1?>
                        </span>
                    </div>
                </div>
               
                <div class="c-dashboardInfo col-lg-3 col-md-6">
                    <div class="wrap">
                        <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">Total Land
                            Properties
                        </h4><span class="hind-font caption-12 c-dashboardInfo__count">
                        <?=PropertyController::GetTotalProperty();?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<p class="p-2 h6 bg-primary text-light">Payment Transaction</p>
<br>
<div class="table-responsive">
    <table class="table table-striped table-sm" name="sampple-tbl">
        <thead>
            <tr>
                <th scope="col">Date</th>
                <th scope="col">PIN No./Tax No.</th>
                <th scope="col">Tax Payer</th>
                <th scope="col">Assesed Value</th>
                <th scope="col">Tax Year</th>
                <th scope="col">Amount</th>
                <th scope="col">Discount</th>
                <th scope="col">Penalty</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach(PaymentController::Get() as $r): ?>
                <tr>
                <?php $PropertyInfor = PropertyController::GetByTDN($r['tdn']);?>
               <td><?=$r['date_paid']?></td>
               <td><?=$r['tdn']?></td>
               <td><?=UserController::GetByUserId($PropertyInfor->UserId)->Name?></td>
               <td><?=PaymentController::GetAssesmentValue($r['tdn'], $r['tax_year'])?></td>
               <td><?=$r['tax_year']?></td>
               <td><?=$r['amount']?></td>
               <td><?=$r['discount']?></td>
               <td><?=$r['penalty']?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<!-- <div class="container row">
    <div class="chartApex col" id="chart"><b>Taxpayer per Barangay</b><br>The pie chart shows the particular taxpayer within the total data set. In this way, it represents a percentage distribution.</div>
    <div class="chartBar col" id="document-chart"><b>Property by Classification</b><br>The barchart shows the total property by classification</div>
</div> -->