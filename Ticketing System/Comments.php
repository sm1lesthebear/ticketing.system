<?php
require_once("CLASS_FILES/cPage_load.php");
require_once("CLASS_FILES/cDatabase_Connection.php");
require_once("CLASS_FILES/global_lib.php");
$oPage = new page_load_lib;
$oLoginCheck = new cLogin_Test();
echo $oLoginCheck->checkLogin();
$oDBConnection = new cDatabase_Connection();
$AttachmentID = 0;
$commentHTML = "";
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    $jobID = checkValue('JobID', 0);
}elseif ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $jobID = checkValue('JobID', 0);
}


$sSQL = <<<SQL
SELECT 
    A.fld_first_name,
    A.fld_last_name,
    N.fld_content,
	ATT.fld_fk_id_attachment
FROM
    tbl_agent A,
    tbl_note N
    LEft join 
		tbl_note_attachment_bridge ATT
	ON N.fld_id_note = ATT.fld_fk_id_note
WHERE
	A.fld_id_agent = N.fld_fk_id_agent_note
    AND N.fld_fk_id_job_note = $jobID
	ORDER BY N.fld_id_note
SQL;
foreach ($oDBConnection->getfromDB($sSQL) as $row) {
    $AgentName = $row['fld_first_name'] . ' ' . $row['fld_last_name'];
    $sContent = $row['fld_content'];
    $AttachmentID = $row['fld_fk_id_attachment'];

    $commentHTML .= <<<HTML
                <tr>
                    <td>$AgentName</td>
                    <td>$sContent</td>
                    <td><a href="Attachment.php?AttachmentID=$AttachmentID" target="_blank" class="btn btn-default">View Attachment</a></td>
                </tr>
HTML;
}




$html =<<<HTML
        <div id="container">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="pre-scrollable">
                    <table class="table">
                        <!--generated table info-->
                        <tr>
                            <th>Agent Name</th>
                            <th>Comment</th>
                            <th>Attachment</th>
                        </tr>
                        $commentHTML

                    </table>
                </div>
                <div class="row">
                    <div class="col-sm-3 margin-top">
                        <p>Add Attachment</p>
                    </div>
                    <div class="col-sm-7 margin-top">
                        <p>Comment</p>
                    </div>
                    <div class="col-sm-2 margin-top">
                        <p> </p>
                    </div>
                </div>
                <div class="row">
                    <form action="comment_get.php" name="ticket_form" enctype="multipart/form-data" method="post" onsubmit="return ticketFormValidate()" class="form-horizontal" role="form">
                        <div class="col-sm-3 margin-top">
                            <input class="form-control btn btn-default" type="file" name="file_upload" id="file_upload">
                        </div>
                        <div class="col-sm-7  margin-top">
                            <textarea class="form-control" required name="comment_content" placeholder="Enter a comment"></textarea>
                        </div>
                        <input type="hidden" name="jobID" value="$jobID">
                        <div class="col-sm-2 margin-top">
                            <input  type="submit" name="submit" class="form-control btn btn-default">
                        </div>
                        <div class="col-sm-2 col-sm-offset-10 margin-top">
                            <a href="job_info_redirect.php?JobID=$jobID" target="_blank" class="form-control btn btn-default">Go Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
HTML;

echo $oPage->load_page($html);