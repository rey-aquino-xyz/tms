<?php

// DBHelper
include_once 'utils/DBx.php';

//PHPMAILER
include_once 'utils/phpmailer/Exception.php';
include_once 'utils/phpmailer/PHPMailer.php';
include_once 'utils/phpmailer/SMTP.php';

//MODEL
include_once 'model/Account.php';
include_once 'model/User.php';
include_once 'model/Province.php';
include_once 'model/Municipality.php';
include_once 'model/Barangay.php';
include_once 'model/AgriSubClass.php';
include_once 'model/AssessmentLevel.php';
include_once 'model/MarketValue.php';
include_once 'model/SubClassification.php';
include_once 'model/AgriMarketValue.php';
include_once 'model/Assistant.php';
include_once 'model/Property.php';
include_once 'model/PropertyMeasureHistory.php';
include_once 'model/Payment.php';


//CONTROLLER
include_once 'controller/AccountController.php';
include_once 'controller/UserController.php';
include_once 'controller/XtraController.php';
include_once 'controller/MailController.php';
include_once 'controller/OTPVerificationController.php';
include_once 'controller/ProvinceController.php';
include_once 'controller/MunicipalityController.php';
include_once 'controller/BarangayController.php';
include_once 'controller/AgriSubClassController.php';
include_once 'controller/AssessmentLevelController.php';
include_once 'controller/MarketValueController.php';
include_once 'controller/SubClassController.php';
include_once 'controller/AgriMarketValueController.php';
include_once 'controller/AssistantController.php';
include_once 'controller/PropertyController.php';
include_once 'controller/PropertyMeasureHistoryController.php';
include_once 'controller/PaymentController.php';

//ENUM
include_once 'enums/Enum_Account_Role.php';
include_once 'enums/Enum_Civil_Status.php';
include_once 'enums/Enum_Property_Classification.php';


?>
