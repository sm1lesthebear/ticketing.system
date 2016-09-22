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
$sSQL = "select fld_id_client, fld_first_name, fld_last_name, fld_phone_number, fld_email_address from tbl_client";
foreach ($oDBConnection->getfromDB($sSQL) as $row){
    $sOptionTitle = $row['fld_first_name'] . ' ' . $row['fld_last_name'];
    $sOptionID = $row['fld_id_client'];
    $sEmail = $row['fld_phone_number'];
    $sPhonenumber = $row['fld_email_address'];
    $sClientDropdown .= <<<HTML
                                <option value="$sOptionID">
                                    <span class="col-sm-4">$sOptionTitle</span>
                                    <span class="col-sm-3">$sEmail</span>
                                    <span class="col-sm-3">$sPhonenumber</span>
                                </option>
HTML;
}
$sLocationDropdown .= getDropdown('select distinct fld_location from tbl_job','fld_location','fld_location');
$sTicketType .= getDropdown('select * from tbl_job_type','fld_id_job_type','fld_type');
$sPriorityDropdown .= getDropdown('select * from tbl_priority', 'fld_id_priority', 'fld_priority');
$html =<<<HTML
        <div class="container" >
            <div class="col-sm-7 col-sm-offset-4">
                <h2 id="h2-margin-bottom">Create a support ticket</h2>
            </div>
            <form action="ticket_get.php" name="ticket_form" enctype="multipart/form-data" method="post" onsubmit="return ticketFormValidate()" class="form-horizontal" role="form">
                <div class="form-group" id="client_select" style="display:none;">
                    <label class="col-sm-3" for="client_select">Select a client :</label>
                    <div class="col-sm-9">
                        <select class="form-control" id="client_select" name="client_select">
                            $sClientDropdown
                        </select>
                    </div>
                </div>
                <div class="form-group" id="client_first_name">
                    <label class="col-sm-3" for="client_first_name">Client First Name :</label>
                    <div class="col-sm-9">
                        <input maxlength="30" type="text"  class="form-control" name="client_first_name" id="client_first_name" Placeholder="Enter the clients name...">
                    </div>
                </div>
                <div class="form-group" id="client_last_name">
                    <label class="col-sm-3" for="client_last_name">Client Surname :</label>
                    <div class="col-sm-9">
                        <input maxlength="30" type="text"  class="form-control" name="client_last_name" id="client_last_name" Placeholder="Enter the clients surname..">
                    </div>
                </div>
                <div class="form-group" id="client_email">
                    <label class="col-sm-3" for="client_email">Client Email :</label>
                    <div class="col-sm-9">
                        <input maxlength="45" type="email"  class="form-control" name="client_email" id="client_email" Placeholder="Enter the clients email...">
                    </div>
                </div>
                <div class="form-group" id="client_phone_number">
                    <label class="col-sm-3" for="client_phone_number">Client Phone Number :</label>
                    <div class="col-sm-9">
                        <input maxlength="30" type="text"  class="form-control" name="client_phone_number" id="client_phone_number" Placeholder="Enter the clients phone number...">
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
                <div class="form-group">
                    <label class="col-sm-3" for="type">Ticket Type :</label>
                    <div class="col-sm-9">
                        <select class="form-control"  name="type">
                            $sTicketType
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3" for="priority">Ticket Priority :</label>
                    <div class="col-sm-9">
                        <select class="form-control"  name="priority">
                            $sPriorityDropdown
                        </select>
                    </div>
                </div>
                <div class="form-group" id="location">
                    <label class="col-sm-3" for="location">Location :</label>
                    <div class="col-sm-9">
                        <input maxlength="30" autocomplete="off"  type="text" class="form-control" name="location" placeholder="Enter a location for your ticket...">
                    </div>
                </div>
                <div class="form-group" id="location_dropdown" style="display:none">
                    <label class="col-sm-3" for="location_dropdown">Select location :</label>
                    <div class="col-sm-9">
                        <select class="form-control" id="location_dropdown" name="location_dropdown">
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
                        <input maxlength="60" type="text"  class="form-control" id="title" name="title" placeholder="Enter a title for your ticket...">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3" for="description">Description :</label>
                    <div class="col-sm-12">
                        <textarea class="form-control"  name="description" placeholder="Enter a desciption for your ticket..."></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-1 margin-top">
                        <input class="form-control btn btn-default" type="file" name="file_upload" id="file_upload">
                    </div>
                    <div class="col-sm-2 col-sm-offset-4 margin-top">
                        <input  type="submit" name="submit" class="form-control btn btn-default">
                    </div>
                    <div class="col-sm-2 col-sm-offset-9 margin-top">
                        <a href="ticket_submit.php" class="form-control btn btn-default">Clear</a>
                    </div>
                    <div class="col-sm-2 col-sm-offset-9 margin-top">
                        <a href="dashboard.php" class="form-control btn btn-default">Home</a>
                    </div>
                </div>
            </form>
        </div>
HTML;

echo $oPage->load_page($html);