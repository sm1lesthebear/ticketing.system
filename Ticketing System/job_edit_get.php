<?php
require_once("CLASS_FILES/global_lib.php");
require_once("CLASS_FILES/cDatabase_Connection.php");
session_start();
$oDBConnection = new cDatabase_Connection();
$ExistingClient = "";
$Existinglocation = "";
$sLocationDropdown = "";
$AgentID = $_SESSION['agentID'];
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $sClientID = checkValue('client_select', "");
    $sClientFirst_name = checkValue('client_first_name', "");
    $sClientLast_Name = checkValue('client_last_name', "");
    $sClientEmail = checkValue('client_email', "");
    $sClientPhone = checkValue('client_phone_number', "");
    $ExistingClient = checkValue('ExistingClient', "");
    $sLocation = checkValue('location', "");
    $sLocationDropdown = checkValue('location_dropdown', "");
    $Existinglocation = checkValue('locationtoggle', "");
    $sType = checkValue('type', "");
    $sPriority = checkValue('priority', "");
    $sTitle = checkValue('title', "");
    $sDescription = checkValue('description', "");

}
elseif ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    $sClientID = checkValue('client_select', "");
    $sClientFirst_name = checkValue('client_first_name', "");
    $sClientLast_Name = checkValue('client_last_name', "");
    $sClientEmail = checkValue('client_email', "");
    $sClientPhone = checkValue('client_phone_number', "");
    $ExistingClient = checkValue('ExistingClient', "");
    $sLocation = checkValue('location', "");
    $sLocationDropdown = checkValue('location_dropdown', "");
    $Existinglocation = checkValue('locationtoggle', "");
    $sType = checkValue('type', "");
    $sPriority = checkValue('priority', "");
    $sTitle = checkValue('title', "");
    $sDescription = checkValue('description', "");
}
if ($ExistingClient == "" OR $ExistingClient == NULL)
{
    $sSQL = <<<SQL
        insert into tbl_client 
          (fld_first_name, fld_last_name, fld_phone_number, fld_email_address) 
        values 
          (:Client_First_Name,:Client_Last_Name, :Client_Phone_Number, :Client_Email_Address)
SQL;
    $Array = array(":Client_First_Name" => $sClientFirst_name,
                    ":Client_Last_Name" => $sClientLast_Name,
                    ":Client_Phone_Number" => $sClientPhone,
                    ":Client_Email_Address" => $sClientEmail);
    $sClientID = $oDBConnection->commitSQL($sSQL, $Array);
}
if (!$Existinglocation == "")
{
    $sLocation = $sLocationDropdown;
}
$sSQL = <<<SQL
      insert into tbl_job 
        (fld_start_date, fld_title, fld_description, fld_location, fld_fk_id_client, fld_fk_id_priority, fld_fk_id_job_type, fld_fk_id_status, fld_fk_id_agent) 
      values 
        (now(), :Title, :Description, :Location,'$sClientID','$sPriority', '$sType', '1','$AgentID')
SQL;
$Array = array(":Title" => $sTitle,
                ":Description" => $sDescription,
                ":Location" => $sLocation);
$sJobID = $oDBConnection->commitSQL($sSQL, $Array);
if (!$attachmentID == "")
{
    $sSQL = <<<SQL
            insert into tbl_job_attachment_bridge 
              (fld_fk_id_job, fld_fk_id_attachment) 
            values 
              ('$sJobID', $attachmentID)
SQL;
    $Array = null;
    $oDBConnection->commitSQL($sSQL, $Array);
}
Echo "Your Job has been submitted. Your job number is: $sJobID";
header("refresh:3;url=dashboard.php");