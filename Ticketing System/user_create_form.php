<?php
require_once("CLASS_FILES/cPage_load.php");
require_once("CLASS_FILES/cDatabase_Connection.php");
require_once("CLASS_FILES/global_lib.php");
$oLoginCheck = new cLogin_Test();
echo $oLoginCheck->checkLogin();
echo $oLoginCheck->checkPriv();

$sPrivilige_ID = "";
$sPrivilige_Title = "";
$sDropdown = <<<HTML
        <option value="-99">Please select a privilige level...</option>
HTML;
$sDropdown .= getDropdown('select * from tbl_privilige',  'fld_id_privilige', 'fld_privilige');

$html = <<<HTML
        <div class="container">
            <div class="col-sm-7 col-sm-offset-5">
                <h2 id="h2-margin-bottom">Create Agent Account</h2>
            </div>
            <form action="user_submit.php" method="post" class="form-horizontal" role="form">
                <div class="form-group">
                    <label class="col-sm-3" for="first_name">First Name :</label>
                    <div class="col-sm-9">
                        <input maxlength="30" required type="text" class="form-control" name="first_name" Placeholder="Enter your first name...">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3" for="last_name">Last Name :</label>
                    <div class="col-sm-9">
                        <input maxlength="30" required type="text" class="form-control" name="last_name" Placeholder="Enter your last name...">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3" for="email_address">Email Address :</label>
                    <div class="col-sm-9">
                        <input maxlength="30" required type="email" class="form-control" name="email_address" Placeholder="Enter your email account...">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3" for="last_name">Username :</label>
                    <div class="col-sm-9">
                        <input maxlength="30" required type="text" class="form-control" name="username" Placeholder="Enter a username...">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3" for="password">Password :</label>
                    <div class="col-sm-9">
                        <input maxlength="30" minlength="12" required type="password" id="password" class="form-control" name="password" Placeholder="Enter a Password...">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3" for="password_confirm">Password Confirmation:</label>
                    <div class="col-sm-9">
                        <input maxlength="30" minlength="12" id="password_confirm"  onkeyup="passwordcheck('password', 'password_confirm')" required type="password" class="form-control" name="password_confirm" Placeholder="Confirm your Password...">
                        <p id="PasswordNotMatch" style="display:none;">Passwords Do Not Match</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3" for="privilige_level_id">Privilige Type :</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="privilige_level_id">
                             $sDropdown
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2 col-sm-offset-10">
                        <button id="submit" class="form-control btn btn-default">Submit</button>
                    </div>
                </div>
            </form>
        </div>
HTML;
$oPage = new page_load_lib();
echo $oPage->load_page($html);
