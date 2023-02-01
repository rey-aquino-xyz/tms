
<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';

if (isset($_GET['x_taxpayer'])) {

    $sql = "SELECT COUNT(barangay), barangay FROM `user` WHERE barangay != '' GROUP BY barangay ORDER BY barangay ASC; ";

    $data = DBx::GetData($sql);
    $result = [];
    foreach($data as $r){
       $a = array("count"=>$r[0], "brgy" => $r[1]);
       array_push($result, $a);
    }
   //$result = array($data[0][0],$data[0][1], $data[0][2],$data[0][3],$data[0][4] );
    // $result = $data;
    //var_dump($data);
    echo json_encode($result);

}


if (isset($_GET['x_property'])) {

    $sql = "SELECT COUNT(t.pin), p.name FROM `tdn` t INNER JOIN propery_classification p ON t.classification_id = p.classification_id GROUP BY p.name; ";

    $data = DBx::GetData($sql);
    $result = [];
    foreach($data as $r){
       $a = array("count"=>$r[0], "type" => $r[1]);
       array_push($result, $a);
    }
    echo json_encode($result);

}