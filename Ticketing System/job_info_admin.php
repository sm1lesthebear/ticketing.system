<?php
require_once("CLASS_FILES/cPage_load.php");
require_once("CLASS_FILES/cDatabase_Connection.php");
require_once("CLASS_FILES/global_lib.php");
$oPage = new page_load_lib;
$oLoginCheck = new cLogin_Test();
echo $oLoginCheck->checkLogin();
$oDBConnection = new cDatabase_Connection();
$sDropdownOptions = "";
$sClientDropdown = "";
$sLocationDropdown = "";
$sTicketType = "";
$sPriorityDropdown = "";
$sGiven_ClientDropdown = "";
$Sub_AgentDisabledDropdown = "";
$JobID = 0;
$AttachmentID = 0;
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    $JobID = checkValue('JobID', 0);
}elseif ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $JobID = checkValue('JobID', 0);
}
$sSQL = "select * from tbl_job where fld_id_job = $JobID";
foreach ($oDBConnection->getfromDB($sSQL) as $row)
{
    $Start_Date = $row['fld_start_date'];
    $sTitle = $row['fld_title'];
    $sDescription = $row['fld_description'];
    $sLocation = $row['fld_location'];
    $sClient_ID = $row['fld_fk_id_client'];
    $sJob_Type_ID = $row['fld_fk_id_job_type'];
    $sStatus_ID = $row['fld_fk_id_status'];
    $sAgent_ID = $row['fld_fk_id_agent'];
    $sPriority_ID = $row['fld_fk_id_priority'];
}
$sSQL = "select fld_id_client, fld_first_name, fld_last_name, fld_phone_number, fld_email_address from tbl_client where fld_id_client = $sClient_ID ";
foreach ($oDBConnection->getfromDB($sSQL) as $row){
    $sClient_First_Name = $row['fld_first_name'];
    $sClient_Second_Name = $row['fld_last_name'];
    $sOptionTitle = $row['fld_first_name'] . ' ' . $row['fld_last_name'];
    $sOptionID = $row['fld_id_client'];
    $sEmail = $row['fld_phone_number'];
    $sPhonenumber = $row['fld_email_address'];
    $sGiven_ClientDropdown .= <<<HTML
                                <option value="$sOptionID">
                                    <span class="col-sm-4">$sOptionTitle</span>
                                    <span class="col-sm-3">$sEmail</span>
                                    <span class="col-sm-3">$sPhonenumber</span>
                                </option>
HTML;
}
$sSQL = "select fld_id_attachment from tbl_attachment A, tbl_job_attachment_bridge AB where A.fld_id_attachment = AB.fld_fk_id_attachment and AB.fld_fk_id_job = $JobID";
foreach ($oDBConnection->getfromDB($sSQL) as $row) {
    $AttachmentID = $row['fld_id_attachment'];
}


$sSQL = "select fld_id_agent, fld_first_name, fld_last_name from tbl_agent where fld_id_agent = $sAgent_ID";
foreach ($oDBConnection->getfromDB($sSQL) as $row) {
    $Sub_AgentName = $row['fld_first_name'] . ' ' . $row['fld_last_name'];
    $Sub_AgentID = $row['fld_id_agent'];
    $Sub_AgentDisabledDropdown .= <<<HTML
                                <option value="$Sub_AgentID">
                                    $Sub_AgentName
                                </option>
HTML;
}
$sGivenLocation = getDropdown("select distinct fld_location from tbl_job where fld_location = '$sLocation'",'fld_location','fld_location');
$sLocationDropdown = getDropdown("select distinct fld_location from tbl_job", 'fld_location','fld_location');
$sTicketType = getDropdown('select * from tbl_job_type','fld_id_job_type','fld_type');
$sGivenType = getDropdown("select * from tbl_job_type where fld_id_job_type = $sJob_Type_ID",'fld_id_job_type','fld_type');
$sPriorityDropdown = getDropdown('select * from tbl_priority', 'fld_id_priority', 'fld_priority');
$sGivenPriority = getDropdown("select * from tbl_priority where fld_id_priority = $sPriority_ID", 'fld_id_priority', 'fld_priority');
$sStatusDropdown = getDropdown("select * from tbl_status", 'fld_id_status', 'fld_status');
$sGivenStatus = getDropdown("select S.fld_id_status, S.fld_status from tbl_status S, tbl_job J where J.fld_fk_id_status = S.fld_id_status and J.fld_id_job = $JobID", 'fld_id_status', 'fld_status');
$sUnnassignedAgents = getDropdown("select DISTINCT A.fld_id_agent, CONCAT(A.fld_first_name, ' ',A.fld_last_name) as Agent_Name from tbl_agent A left join tbl_agent_bridge AB on A.fld_id_agent = AB.fld_fk_id_agent where A.fld_id_agent not in (select fld_fk_id_agent from tbl_agent_bridge AB where AB.fld_fk_id_job = $JobID)", 'fld_id_agent', 'Agent_Name');
$sAssignedAgents = getDropdown("select DISTINCT A.fld_id_agent, CONCAT(A.fld_first_name, ' ',A.fld_last_name) as Agent_Name from tbl_agent A left join tbl_agent_bridge AB on A.fld_id_agent = AB.fld_fk_id_agent where AB.fld_fk_id_job = $JobID",'fld_id_agent','Agent_Name');
$html =<<<HTML
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <h2 id="h2-margin-bottom">Edit ticket number: $JobID</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3 margin-bottom">
            <a href="Comments.php?JobID=$JobID" class="form-control btn btn-default">View Agent Comments</a>
        </div>
    </div>
    <form action="job_edit_get.php?JobID=$JobID" name="ticket_form" enctype="multipart/form-data" method="post" onsubmit="return ticketFormValidate()" class="form-horizontal" role="form">
        <div class="form-group" id="client_select" style="display:none;">
            <label class="col-sm-3" for="client_select">Select a client :</label>
            <div class="col-sm-9">
                <select class="form-control" disabled id="client_select" name="client_select">
                    $sGiven_ClientDropdown
                </select>
            </div>
        </div>
        <div class="form-group" id="client_first_name">
            <label class="col-sm-3" for="client_first_name">Client First Name :</label>
            <div class="col-sm-9">
                <input maxlength="30" type="text" disabled class="form-control" name="client_first_name" id="client_first_name" value="$sClient_First_Name" Placeholder="Enter the clients name...">
            </div>
        </div>
        <div class="form-group" id="client_last_name">
            <label class="col-sm-3" for="client_last_name">Client Surname :</label>
            <div class="col-sm-9">
                <input maxlength="30" type="text" disabled class="form-control" name="client_last_name" id="client_last_name" value="$sClient_Second_Name" Placeholder="Enter the clients surname..">
            </div>
        </div>
        <div class="form-group" id="client_email">
            <label class="col-sm-3" for="client_email">Client Email :</label>
            <div class="col-sm-9">
                <input maxlength="30" type="email" disabled class="form-control" name="client_email" id="client_email" value="$sEmail" Placeholder="Enter the clients email...">
            </div>
        </div>
        <div class="form-group" id="client_phone_number">
            <label class="col-sm-3" for="client_phone_number">Client Phone Number :</label>
            <div class="col-sm-9">
                <input maxlength="30" type="text" disabled class="form-control" name="client_phone_number" id="client_phone_number" value="$sPhonenumber" Placeholder="Enter the clients phone number...">
            </div>
        </div>
        <div class="checkbox-inline col-sm-4 col-sm-offset-6">
            <label>
                <input type="checkbox" onchange="useExistingClient('client_select', 'client_first_name', 'client_last_name', 'client_email', 'client_phone_number', 'use_existing')" id="use_existing" name="ExistingClient" value="1">
                Use Existing Client?
            </label>
        </div>
        <br>
        <br>
        <div class="form-group" id="Start_Date">
            <label class="col-sm-3" for="Start_Date">Submission Date :</label>
            <div class="col-sm-9">
                <input maxlength="30" autocomplete="off" disabled type="date" class="form-control" name="Start_Date" value="$Start_Date" placeholder="Enter a location for your ticket...">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3" for="Sub_Agent">Submitting Agent :</label>
            <div class="col-sm-9"> 
                <select class="form-control"  disabled name="Sub_Agent">
                    $Sub_AgentDisabledDropdown
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3" for="Status">Ticket Status :</label>
            <div class="col-sm-9">
                <select class="form-control" name="Status">
                    $sGivenStatus
                    $sStatusDropdown
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3" for="type">Ticket Type :</label>
            <div class="col-sm-9">
                <select class="form-control"  name="type">
                    $sGivenType
                    $sTicketType
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3" for="priority">Ticket Priority :</label>
            <div class="col-sm-9">
                <select class="form-control"  name="priority">
                    $sGivenPriority
                    $sPriorityDropdown
                </select>
            </div>
        </div>
        <div class="form-group" id="location">
            <label class="col-sm-3" for="location">Location :</label>
            <div class="col-sm-9">
                <input maxlength="30" autocomplete="off" type="text" class="form-control" name="location" value="$sLocation" placeholder="Enter a location for your ticket...">
            </div>
        </div>
        <div class="form-group" id="location_dropdown" style="display:none">
            <label class="col-sm-3" for="location_dropdown">Select location :</label>
            <div class="col-sm-9">
                <select class="form-control" id="location_dropdown" name="location_dropdown">
                    $sGivenLocation
                    $sLocationDropdown
                </select>
            </div>
        </div>
        <div class="checkbox-inline col-sm-4 col-sm-offset-6">
            <label>
                <input type="checkbox" onchange="disableTextorDropdown('location', 'location_dropdown', 'locationtoggle')" id="locationtoggle" name="locationtoggle" value="1">
                Use Existing location?
            </label>
        </div>
        <br>
        <br>
        <div class="form-group">
            <label class="col-sm-3" for="title">Ticket Title :</label>
            <div class="col-sm-9">
                <input maxlength="30" type="text"  class="form-control" id="title" disabled name="title"  value="$sTitle" placeholder="Enter a title for your ticket...">
            </div>
        </div>
        <div class="form-group" id="client_first_name">
            <label class="col-sm-3" for="client_first_name">Description :</label>
            <div class="col-sm-9">
                <textarea class="form-control"  disabled name="description" placeholder="Enter a desciption for your ticket...">$sDescription</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3" for="priority">Unnasign Agent(s) :</label>
            <div class="col-sm-9">
                <select class="form-control" multiple name="Agents_to_Unassign[]">
                    $sAssignedAgents
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3" for="priority">Assign Agent(s) :</label>
            <div class="col-sm-9">
                <select class="form-control" multiple name="Agents_to_Assign[]">
                    $sUnnassignedAgents
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-4 col-sm-offset-1 margin-top">
                <a href="Attachment.php?AttachmentID=$AttachmentID" target="_blank" class="form-control btn btn-default">Attachment</a>
            </div>
            <div class="col-sm-2 col-sm-offset-4 margin-top">
                <input  type="submit" name="submit" class="form-control btn btn-default">
            </div>
            <div class="col-sm-2 col-sm-offset-9 margin-top">
                <a href="job_edit_get.php?JobId=$JobID" class="form-control btn btn-default">Clear</a>
            </div>
            <div class="col-sm-2 col-sm-offset-9 margin-top">
                <a href="dashboard.php" class="form-control btn btn-default">Home</a>
            </div>
        </div>
    </form>
</div>
HTML;
echo $oPage->load_page($html);