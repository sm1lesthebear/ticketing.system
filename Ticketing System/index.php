<?php

require_once("CLASS_FILES/cPage_load.php");

$oPage = new page_load_lib;

$html =<<<HTML
        <div class="container">
            <div class="col-sm-7 col-sm-offset-5">
                <h2 id="h2-margin-bottom">Agent login</h2>
            </div>
            <form action="login_get.php" method="post" class="form-horizontal" role="form">
                <div class="form-group">
                    <label class="col-sm-3" for="username">Username :</label>
                    <div class="col-sm-9">
                        <input maxlength="30" type="text" class="form-control" id="username" name="username" Placeholder="Enter your name...">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3" for="password">Password :</label>
                    <div class="col-sm-9">
                        <input maxlength="30" type="password" class="form-control" id="password" name="password" Placeholder="Enter your name...">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2 col-sm-offset-10">
                        <button class="form-control btn btn-default">Submit</button>
                    </div>
                </div>
            </form>
            <a href="Userguide\Ticket System User Guide.pdf" download> User Guide Download </a>
        </div>
HTML;


echo $oPage->load_page($html);