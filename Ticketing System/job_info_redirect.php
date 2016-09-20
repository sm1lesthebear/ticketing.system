<?php
require_once("CLASS_FILES/cPage_load.php");
require_once("CLASS_FILES/cDatabase_Connection.php");
require_once("CLASS_FILES/global_lib.php");
$oPage = new page_load_lib;
$oLoginCheck = new cLogin_Test();
echo $oLoginCheck->checkLogin();
$sAgentID = $_SESSION['agentID'];
$oDBConnection = new cDatabase_Connection();
$JobID = "";
$sPriviligeID = "";
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    $JobID = checkValue('JobID', 0);
}elseif ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $JobID = checkValue('JobID', 0);
}
$sSQL = <<<SQL
                select P.fld_id_privilige
                from tbl_privilige P, tbl_agent A 
                where A.fld_fk_id_privilige = P.fld_id_privilige 
                and fld_id_agent = $sAgentID
SQL;
foreach ($oDBConnection->getfromDB($sSQL) as $row)
{
    $sPriviligeID = $row['fld_id_privilige'];
}

if ($sPriviligeID == 1)
{
    header("location:Job_info_admin.php?JobID=$JobID");
}
else
{
    header("location:Job_info_agent.php?JobID=$JobID");
}