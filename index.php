<?php
    // this would destroy the session variables on each reload
   session_start();
   session_destroy();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <link rel="stylesheet" href="css/calendar/jquery.datetimepicker.css" type="text/css" />
    <link rel="stylesheet" href="css/form.css" type="text/css" />
    <title>Multi form Demo</title>
        <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/calendar/jquery.datetimepicker.js"></script>
        <script type="text/javascript" src="js/multiform.js"></script>
    </head>
    <body>
        <div class="right_block_box">
            <div class="multiform_part">
            </div>
            <div id="form_step_nav_wrap">
                <div id="form_step_nav">
                    <div id="form_step_left">
                        <input type="button" value="Previous Step" id="prevStepBtn">
                    </div>
                    <div id="form_step_right">
                        <input type="button" value="Next Step" id="nextStepBtn" >
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
