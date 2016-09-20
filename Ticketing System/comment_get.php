<?php
require_once("CLASS_FILES/global_lib.php");
require_once("CLASS_FILES/cDatabase_Connection.php");
session_start();
$oDBConnection = new cDatabase_Connection();
$agentID = $_SESSION['agentID'];
$comment_content = "";
$jobID = "";
$CommentID = "";
$attachmentID = "";
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    $jobID = checkValue('jobID', 0);
    $comment_content = checkValue('comment_content', 0);
}elseif ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $jobID = checkValue('jobID', 0);
    $comment_content = checkValue('comment_content', 0);

}

if (isset($_FILES["file_upload"]))
{
    $file = $_FILES["file_upload"];
    $file_location = $file['tmp_name'];
    $file_type = $file['type'];
    $file_size = $file['size'];
    $NoImage = false;
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
        header("refresh:3;url=Comments.php?JobID=$jobID");
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
            echo "Attachment Added";
        }
    }
}

if ($comment_content != "" AND $comment_content != Null) {
    $sSQL = <<<SQL
        insert into tbl_note 
            (fld_content, fld_fk_id_agent_note, fld_fk_id_job_note) 
        values 
            (:content, :agentID, :jobID)
SQL;
    $Array = array(":content" => $comment_content,
        ":agentID" => $agentID,
        ":jobID" => $jobID);
    $CommentID = $oDBConnection->commitSQL($sSQL, $Array);
    echo " - Comment Added";
}else{
    echo " - no comment found";
}
if (!$attachmentID == "" AND !$CommentID == "")
{
    $sSQL = <<<SQL
            insert into tbl_note_attachment_bridge 
              (fld_fk_id_note, fld_fk_id_attachment) 
            values 
              ('$CommentID', $attachmentID)
SQL;
    $Array = null;
    $oDBConnection->commitSQL($sSQL, $Array);
    echo " - comment and attachment have been added, redirecting you now";
    header("refresh:3;url=Comments.php?JobID=$jobID");
    die;
}else{
    echo " - Attachment not added, redirecting you now";
    header("refresh:3;url=Comments.php?JobID=$jobID");
    die;
}