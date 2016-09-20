<?php
require_once("CLASS_FILES/global_lib.php");
require_once("CLASS_FILES/cDatabase_Connection.php");
$sFirst_name = "";
$sLast_name = "";
$sEmail_address = "";
$sUsername = "";
$sPassword = "";
$sPrivilige_ID = "";
$oDBConnection = new cDatabase_Connection();
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $sFirst_name = checkValue('first_name', "");
    $sLast_name = checkValue('last_name', "");
    $sEmail_address = checkValue('email_address', "");
    $sUsername = checkValue('username', "");
    $sPassword = checkValue('password', "");
    $sPrivilige_ID = checkValue('privilige_level_id', "");
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    $sFirst_name = checkValue('first_name', "");
    $sLast_name = checkValue('last_name', "");
    $sEmail_address = checkValue('email_address', "");
    $sUsername = checkValue('username', "");
    $sPassword = checkValue('password', "");
    $sPrivilige_ID = checkValue('privilige_level_id', "");
}
$salt = generateRandomString(22);
$hash = hashPassword($sPassword, $salt);
$sSQL = <<<SQL
        insert into tbl_agent 
          (fld_first_name, fld_last_name, fld_email_address, fld_username, fld_password, fld_password_salt, fld_fk_id_privilige) 
        values 
          (:First_Name, :Last_Name, :Email_Address, :Username, :Password, :Password_Salt, $sPrivilige_ID)
SQL;
$Array = array(":First_Name" => $sFirst_name,
                ":Last_Name" => $sLast_name,
                ":Email_Address"=> $sEmail_address,
                ":Username" => $sUsername,
                ":Password" => $hash,
                ":Password_Salt" => $salt);
$oDBConnection->commitSQL($sSQL, $Array);
header("location:dashboard.php");