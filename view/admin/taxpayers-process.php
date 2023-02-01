<?php
date_default_timezone_set("Asia/Hong_Kong");
include_once __DIR__ . '../../../config.php';

if (isset($_POST['v_contact'])) {
    //VERIFY IF EXIST CONTACT

    if (AccountController::IsContactExist($_POST['v_contact'])) {
        echo 't';
    } else {
        echo 'f';
    }

}

if (isset($_POST['register'])) {
    //CREATE USER FIRST
    $u                 = new User();
    $user_id           = XtraController::GenerateGUID();
    $u->UserId         = $user_id;
    $u->Name           = $_POST['name'];
    $u->Contact        = $_POST['contact'];
    $u->BarangayId     = $_POST['barangay'];
    $u->MunicipalityId = $_POST['municipality'];
    $u->ProvinceId     = $_POST['province'];

    $a                = new Account();
    $generated_pwd    = XtraController::GenerateRandompass();
    $a->UserId        = $user_id;
    $a->Contact       = $_POST['contact'];
    $a->AccountRoleId = Enum_Account_Role::Resident();
    $a->Password      = $generated_pwd;

    //FIRST CREATE USER

    //TODO SEND SMS TO RESIDENT
    if (MailController::SendTempAccount($_POST['contact'], $generated_pwd)) {
        if (UserController::Insert($u)) {
            if (AccountController::Insert($a)) {
                echo 't';
            } else {
                echo 'f';
            }
        }

    }

}

if (isset($_POST['e_id'])) {

    $email   = $_POST['e_email'];
    $user_id = $_POST['e_id'];

    $u                 = new User();
    $u->UserId         = $_POST['e_id'];
    $u->Name           = $_POST['e_name'];
    $u->Contact        = $email;
    $u->ProvinceId     = $_POST['e_province'];
    $u->MunicipalityId = $_POST['e_municipality'];
    $u->BarangayId     = $_POST['e_barangay'];

    if (UserController::UpdateByUserId($u)) {
        echo 't';
    } else {
        echo 'f';
    }

}

if (isset($_POST['g_agri_sub_market_val'])) {
    $sub_class_id = $_POST['g_agri_sub_market_val'];

    $r      = AgriMarketValueController::GetBySubClassId($sub_class_id);
    $first  = array('First' => $r->First ?? 0);
    $second = array('Second' => $r->Second ?? 0);
    $third  = array('Third' => $r->Third ?? 0);
    $fourth = array('Fourth' => $r->Fourth ?? 0);
    $fifth  = array('Fifth' => $r->Fifth ?? 0);
    $sixth  = array('Sixth' => $r->Sixth ?? 0);
    $result = [];
    array_push($result, $first);
    array_push($result, $second);
    array_push($result, $third);
    array_push($result, $fourth);
    array_push($result, $fifth);
    array_push($result, $sixth);
    // var_dump($data);
    echo json_encode($result);
}

if (isset($_POST['g_market_val'])) {
    $sub_class_id = $_POST['g_market_val'];
    $year         = date("Y");
    $r            = MarketValueController::GetBySubClassAndYear($sub_class_id, $year);
    $val          = array('Value' => $r->Value ?? 0);
    $result       = [];
    array_push($result, $val);
    echo json_encode($result);
}

if (isset($_POST['x_calculate_assesed_value'])) {
    $assesment_level = AssessmentLevelController::GetByClass($_POST['class_id']);
    $asses_val       = 0;

    if ($_POST['class_id'] == Enum_Property_Classification::Agricultural()) {
        $asses_val = XtraController::CalculateAgriAssesedValue($_POST['hectare'], $_POST['agriMarketVal'], $assesment_level->Value);
    } else {
        $asses_val = XtraController::CalculateAssedValue($_POST['area'], $_POST['marketVal'], $assesment_level->Value);
    }
    $val    = array('Value' => $asses_val ?? 0);
    $result = [];
    array_push($result, $val);
    // var_dump($result);
    echo json_encode($result);
}

if (isset($_POST['a_pin'])) {
    $m                 = new Property();
    $m->UserId         = $_POST['user_id'];
    $m->Root           = $_POST['a_parent_pin'] ?? 'N/A';
    $m->TDN            = $_POST['a_pin'];
    $m->ProvinceId     = $_POST['a_province_id'];
    $m->MunicipalityId = $_POST['a_municipality_id'];
    $m->BrgyId         = $_POST['a_barangay_id'] ?? 0;
    $m->ClassId        = $_POST['a_class_id'];
    $m->Area           = $_POST['a_area'] ?? 0;
    $m->Hectare        = $_POST['a_hectare'] ?? 0;

    if ($_POST['a_class_id'] == Enum_Property_Classification::Agricultural()) {
        $m->MarketValue = $_POST['a_agri_market_value'];
        $m->SubClassId  = $_POST['a_agri_sub_class'] ?? 0;
    } else {
        $m->MarketValue = 0;
        $m->SubClassId  = $_POST['a_sub_class']?? 0;
    }

    if (PropertyController::Insert($m)) {
        $ph        = new PropertyMeasureHistory();
        $ph->TDN   = $_POST['a_pin'];
        $ph->Month = date('m');
        $ph->Year  = date('Y');
        if ($_POST['a_class_id'] == Enum_Property_Classification::Agricultural()) {
            $ph->Value = $_POST['a_hectare'] ?? 0;
        } else {
            $ph->Value = $_POST['a_area'] ?? 0;
        }
        if (PropertyMeasureHistoryController::Insert($ph)) {
            echo 't';
        } else {
            echo 'f';
        }
    }

}
