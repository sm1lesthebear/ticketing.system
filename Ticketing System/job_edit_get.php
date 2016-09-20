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
    $sJobID = checkValue('JobID', "");
    $sLocation = checkValue('location', "");
    $sLocationDropdown = checkValue('location_dropdown', "");
    $Existinglocation = checkValue('locationtoggle', "");
    $sType = checkValue('type', "");
    $sPriority = checkValue('priority', "");
    $sStatus = checkValue('Status', "");
    $sTitle = checkValue('title', "");
    $sDescription = checkValue('description', "");
    $aAssignAgents = checkValue('Agents_to_Assign', "");
    $aUnAssignAgents = checkValue('Agents_to_Unassign', "");

}
elseif ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    $sJobID = checkValue('JobID', "");
    $sLocation = checkValue('location', "");
    $sLocationDropdown = checkValue('location_dropdown', "");
    $Existinglocation = checkValue('locationtoggle', "");
    $sStatus = checkValue('Status', "");
    $sType = checkValue('type', "");
    $sPriority = checkValue('priority', "");
    $sTitle = checkValue('title', "");
    $sDescription = checkValue('description', "");
    $aAssignAgents = checkValue('Agents_to_Assign', "");
    $aUnAssignAgents = checkValue('Agents_to_Unassign', "");

}
if ($aAssignAgents != Null OR $aAssignAgents != "")
{
    foreach($aAssignAgents as $agent) {
        $sSQL = <<<SQL
            insert into tbl_agent_bridge (fld_fk_id_agent, fld_fk_id_job) values ($agent,$sJobID);    
SQL;
        $oDBConnection->commitSQL($sSQL, Null);
    }
    echo "Agent(s) Assigned";

}
if ($aUnAssignAgents != Null OR $aUnAssignAgents != "")
{
    foreach($aUnAssignAgents as $agent) {
        $sSQL = <<<SQL
            delete from tbl_agent_bridge where fld_fk_id_agent = $agent AND fld_fk_id_job = $sJobID
SQL;
        $oDBConnection->commitSQL($sSQL, Null);
    }
    echo " - Agent(s) Unnasigned";
}
if (!$Existinglocation == "")
{
    $sLocation = $sLocationDropdown;
}
$sSQL = <<<SQL
      Update tbl_job 
      Set 
        fld_location = :Location, 
        fld_fk_id_priority = '$sPriority', 
        fld_fk_id_job_type = '$sType', 
        fld_fk_id_status = '$sStatus'
      WHERE 
        fld_id_job = $sJobID
SQL;
$Array = array(":Location" => $sLocation);
$oDBConnection->commitSQL($sSQL, $Array);
Echo " - Your Job has been updated, redirecting you now";
header("refresh:3;url=job_info_redirect.php?JobID=$sJobID");