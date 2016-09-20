<?php
require_once("CLASS_FILES/global_lib.php");
require_once("CLASS_FILES/cLogin_Test.php");
$oDBConnection = new cDatabase_Connection();
$sUsername = "";
$sPassword = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $sUsername = checkValue('username', "");
    $sPassword = checkValue('password', "");
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    $sUsername = checkValue('username', "");
    $sPassword = checkValue('password', "");
}
$oLoginTest = new cLogin_Test();
$oLoginTest->setVar($sUsername,$sPassword);
$bLoginTry = $oLoginTest->login_test();
if ($bLoginTry == true) {
    echo "Login Successful";
    header("refresh:3;url=dashboard.php");
}
else
{
    echo "Login Unsuccessful";
    header("refresh:3;url=index.php");
}