<?php
require_once("CLASS_FILES/cPage_load.php");
$oLoginCheck = new cLogin_Test();
echo $oLoginCheck->checkLogin();
$oPage = new page_load_lib;

$html =<<<HTML
        <div id="container">
            <div id="row">
                <div class="col-sm-5 col-sm-offset-1 margin-top">
                    <a href="" target="_blank" class="btn btn-default form-control">See this weeks closed tickets</a>
                </div>
                <div class="col-sm-5 margin-top">
                    <a href="" target="_blank" class="btn btn-default form-control">See this weeks opened tickets</a>
                </div>

                <div class="col-sm-5 col-sm-offset-1 margin-top">
                    <a href="" target="_blank" class="btn btn-default form-control">Percentages by type</a>
                </div>

                <div class="col-sm-5 margin-top">
                    <a href="" target="_blank" class="btn btn-default form-control">?</a>
                </div>
            </div>
        </div>
HTML;

echo $oPage->load_page($html);