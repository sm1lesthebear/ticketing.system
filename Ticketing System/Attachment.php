<?php
require_once("CLASS_FILES/cDatabase_Connection.php");
require_once("CLASS_FILES/global_lib.php");
$oDBConnection = new cDatabase_Connection();
$AttachmentID = 0;
$Data = "";
$sType = "";
$sSQL = "";
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    $AttachmentID = checkValue('AttachmentID', 0);
}elseif ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $AttachmentID = checkValue('AttachmentID', 0);
}
if ($AttachmentID == 0) {
    echo "No file Found";
    header("refresh:3;url=dashboard.php");
}else {
    $sSQL = "select fld_data, fld_type from tbl_attachment where fld_id_attachment = $AttachmentID";
    foreach($oDBConnection->getfromDB($sSQL) as $row) {
        $Data = $row['fld_data'];
        $sType = $row['fld_type'];
    }
    header("content-type:$sType");
    echo $Data;
}

