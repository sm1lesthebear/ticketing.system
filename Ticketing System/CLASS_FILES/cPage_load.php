<?php
require_once("cNavbar.php");
require_once("cLogin_Test.php");
    class page_load_lib {
        public function load_page($i_pagehtml){
            $oNavbar = new navbar_class_lib();
            $NavHtml = $oNavbar->load_nav();
            return $html = <<<HTML
                <!DOCTYPE html>
                    <html>
                        <title>Nav</title>
                        <link rel="stylesheet" type="text/css" href="./CSS/style_main.css">
                        <link rel="stylesheet" href="./CSS/bootstrap-theme.css">
                        <link rel="stylesheet" href="./CSS/bootstrap.css">
                        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
                        <!--<link rel="stylesheet" href="./CSS/bootstrap-theme.min.css">-->
                        <script src="./JS/bootstrap.js"></script>
                       <!--// <script src="./JS/npm.js"></script>-->
                        <script src="./JS/global_scripts.js"></script>
                        <!-- Latest compiled and minified CSS -->
                        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
                        <!-- Optional theme -->
                        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduWSVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">-->
                        <!-- Latest compiled and minified JavaScript -->
                        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
                        <!--    Jquery Minified  -->
                        
                        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
                        
                        <body>
                            <div id="content">
                                $NavHtml
                                $i_pagehtml
                           </div>
                        </body>
                        </html>
HTML;
        }
    }