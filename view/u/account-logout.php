<?php

session_start();

unset($_SESSION['contact']);
session_destroy();

header('location:/tms/');
exit();