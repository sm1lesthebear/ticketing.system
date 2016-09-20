<?php
require_once("CLASS_FILES/cPage_load.php");
require_once("CLASS_FILES/cDatabase_Connection.php");
require_once("CLASS_FILES/global_lib.php");
$oPage = new page_load_lib;
$oLoginCheck = new cLogin_Test();
echo $oLoginCheck->checkLogin();
$sAgentID = $_SESSION['agentID'];
$oDBConnection = new cDatabase_Connection();
$sJobHtml = "";
$sSQL = "";
$sOffset = 0;
$sLimitVal = 0;
$count = 0;
$sPriviligeID = "";
$sAgentFirstName = "";
$sAgentLastName = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
        $sOffset = checkValue('offset', 0);
        $sLimitVal = checkValue('curVal', 0);
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET')
{
        $sLimitVal = checkValue('curVal', 0);
        $sOffset = checkValue('offset', 0);
}

if ((isset($sLimitVal) AND $sLimitVal !== "") AND (isset($sOffset) AND $sOffset !== "")) {
        $sLimitVal = $sLimitVal + $sOffset;
}
if ($sLimitVal < 0) {
        $sLimitVal = 0;
}
$sSQL = <<<SQL
                select P.fld_id_privilige, A.fld_first_name, A.fld_last_name
                from tbl_privilige P, tbl_agent A 
                where A.fld_fk_id_privilige = P.fld_id_privilige 
                and fld_id_agent = $sAgentID
SQL;

foreach ($oDBConnection->getfromDB($sSQL) as $row)
{
        $sAgentFirstName = $row['fld_first_name'];
        $sAgentLastName = $row['fld_last_name'];
        $sPriviligeID = $row['fld_id_privilige'];
}
$sAgentName = $sAgentFirstName . ' ' . $sAgentLastName;
if ($sPriviligeID == 1)
{

        $sSQL = <<<SQL
                select J.fld_id_job, J.fld_start_date, J.fld_title, J.fld_description, P.fld_priority 
                from tbl_job J, tbl_priority P
                where J.fld_fk_id_priority = P.fld_id_priority 
                and J.fld_fk_id_status = 1
                order by P.fld_id_priority DESC
                limit 8 offset $sLimitVal
SQL;
}
else
{
        $sSQL = <<<SQL
                select fld_id_job, fld_start_date, fld_title, fld_description, P.fld_priority 
                from tbl_job J, tbl_priority P, tbl_agent_bridge AB 
                where J.fld_fk_id_priority = P.fld_id_priority 
                and J.fld_fk_id_status = 1
                and J.fld_id_job = AB.fld_fk_id_job
                and AB.fld_id_agent_bridge = $sAgentID
                order by P.fld_id_priority DESC
                limit 8 offset $sLimitVal
SQL;
}
foreach ($oDBConnection->getfromDB($sSQL) as $row)
{
        $count++;
        $sJobID = $row['fld_id_job'];
        $sTitle = $row['fld_title'];
        $sDescription = substr($row['fld_description'], 0, 75) . ". . .";
        $sPriority = $row['fld_priority'];
        $sDate = $row['fld_start_date'];

        $sJobHtml .= <<<HTML
                    <div class="col-sm-10 col-sm-offset-1">
                        <a href="job_info_redirect.php?JobID=$sJobID" class="list-group-item">
                            <span class="row">
                                <span class="col-sm-3">$sTitle</span>
                                <span class="col-sm-5">$sDescription</span>
                                <span class="col-sm-2">$sPriority</span>
                                <span class="col-sm-2">$sDate</span>
                            </span>
                        </a>
                    </div>
HTML;
}
if (((($count + 7) - $sOffset) < 0)){
        header('location:dashboard.php');
}


// This page is going to be reworked to fit with http://getbootstrap.com/css/#tables-condensed which is a much nicer format
// Honestly had I known about it I would have saved a tonne of time

$html =<<<HTML
        <pre id="container">
            <pre id="margin-right-left">
            <div class="row">
                <h1 class="col-sm-10 col-sm-offset-2 h1-margin-bottom">Active Jobs of Agent $sAgentName</h1>
                <div class="list-group">
                    $sJobHtml
                </div>
            </div>
            <div class="row">
                <div class=" margin-top">
                    <div class="col-sm-2">
                        <form class="form" action="dashboard.php" method="post">
                            <div class="form-group">
                                <input type="hidden" name="curVal" value="$sLimitVal">
                                <input type="hidden" name="offset" value="-8">
                                <button class="form-control btn btn-default" name="previous">Previous</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-2">
                        <form class="form" action="ticket_submit.php" method="post">
                            <div class="form-group">                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
                                <button class="form-control btn btn-default" name="kkk">Add Ticket</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-4">
                        <form class="form" action="dashboard_closed.php" method="post">
                            <div class="form-group">
                                <button class="form-control btn btn-default" name="closed">See Closed Tickets</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-2">
                        <form class="form" action="reports.php" method="post">
                            <div class="form-group">
                                <button class="form-control btn btn-default" name="kkk">See Reports</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-2">
                        <form class="form" action="dashboard.php" method="post">
                            <div class="form-group">
                                <input type="hidden" name="curVal" value="$sLimitVal">
                                <input type="hidden" name="offset" value="8">
                                <button class="form-control btn btn-default" name="next">Next</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </pre>
HTML;

echo $oPage->load_page($html);

