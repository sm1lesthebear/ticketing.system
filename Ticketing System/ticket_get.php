<?php
require_once("CLASS_FILES/global_lib.php");
require_once("CLASS_FILES/cDatabase_Connection.php");
session_start();
$oDBConnection = new cDatabase_Connection();
$ExistingClient = "";
$Existinglocation = "";
$sLocationDropdown = "";
$attachmentID = "";
$NoImage = false;
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
if (isset($_FILES["file_upload"]))
{
    $file = $_FILES["file_upload"];
    $file_name = $file['name'];
    $file_location = $file['tmp_name'];
    $file_type = $file['type'];
    $file_size = $file['size'];
    $uploadOk = 1;
    switch ($file_type)
    {
        case 'image/jpeg':
            $uploadOk = 1;
            break;
        case 'application/pdf':
            $uploadOk = 1;
            break;
        case 'application/x-pdf':
            $uploadOk = 1;
            break;
        case 'application/acrobat':
            $uploadOk = 1;
            break;
        case 'applications/vnd.pdf':
            $uploadOk = 1;
            break;
        case 'text/pdf':
            $uploadOk = 1;
            break;
        case 'text/x-pdf':
            $uploadOk = 1;
            break;
        case 'image/jpg':
            $uploadOk = 1;
            break;
        case "image/bmp":
            $uploadOk = 1;
            break;
        case "image/png":
            $uploadOk = 1;
            break;
        case "image/gif":
            $uploadOk = 1;
            break;
        case Null:
            $uploadOk = 1;
            $NoImage = True;
            break;
        default:
            $uploadOk = 0;
            echo "Unknown/not permitted file type <br>";
    }
    if ($file_size > 5000000)
    {
        echo "sorry your upload is too large, there is a 5mb limit on uploads<br>";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0)
    {
        header("refresh:3;url=ticket_submit.php");
        die;
    }
    else
    {
        if (!$NoImage) {
            $fOpen = fopen($file_location, "r");
            $contents = fread($fOpen, $file_size);
            fclose($fOpen);
            $sSQL = <<<SQL
                      insert into tbl_attachment 
                        (fld_type, fld_data) 
                      values 
                        (:fld_type, :fld_data)
SQL;
            $Array = array(":fld_type" => $file_type,
                            ":fld_data" => $contents);
            $attachmentID = $oDBConnection->commitSQL($sSQL, $Array);
        }
    }
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