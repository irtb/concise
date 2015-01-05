<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-01-04 01:04:48
         compiled from "/opt/www/concise/App/Templet/login.html" */ ?>
<?php /*%%SmartyHeaderCode:90458138154a7f82501dfa5-96439860%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '011b280c68bb311512d9c2b40cdb982e42c996d3' => 
    array (
      0 => '/opt/www/concise/App/Templet/login.html',
      1 => 1420304311,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '90458138154a7f82501dfa5-96439860',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_54a7f8251293c4_30515504',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54a7f8251293c4_30515504')) {function content_54a7f8251293c4_30515504($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">
<head>
    <!--
        ===
        This comment should NOT be removed.

        Charisma v2.0.0

        Copyright 2012-2014 Muhammad Usman
        Licensed under the Apache License v2.0
        http://www.apache.org/licenses/LICENSE-2.0

        http://usman.it
        http://twitter.com/halalit_usman
        ===
    -->
    <meta charset="utf-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="BabYuan Login">
    <meta name="author" content="Muhammad Usman">

    <!-- The styles -->
    <link href="<?php echo @constant('WWW');?>
/Public/css/bootstrap-cerulean.min.css" rel="stylesheet">

    <link href="<?php echo @constant('WWW');?>
/Public/css/charisma-app.css" rel="stylesheet">
    <link href="<?php echo @constant('WWW');?>
/Public/bower_components/fullcalendar/dist/fullcalendar.css" rel="stylesheet">
    <link href="<?php echo @constant('WWW');?>
/Public/bower_components/fullcalendar/dist/fullcalendar.print.css" rel="stylesheet" media="print">
    <link href="<?php echo @constant('WWW');?>
/Public/bower_components/chosen/chosen.min.css" rel="stylesheet">
    <link href="<?php echo @constant('WWW');?>
/Public/bower_components/colorbox/example3/colorbox.css" rel="stylesheet">
    <link href="<?php echo @constant('WWW');?>
/Public/bower_components/responsive-tables/responsive-tables.css" rel="stylesheet">
    <link href="<?php echo @constant('WWW');?>
/Public/bower_components/bootstrap-tour/build/css/bootstrap-tour.min.css" rel="stylesheet">
    <link href="<?php echo @constant('WWW');?>
/Public/css/jquery.noty.css" rel="stylesheet">
    <link href="<?php echo @constant('WWW');?>
/Public/css/noty_theme_default.css" rel="stylesheet">
    <link href="<?php echo @constant('WWW');?>
/Public/css/elfinder.min.css" rel="stylesheet">
    <link href="<?php echo @constant('WWW');?>
/Public/css/elfinder.theme.css" rel="stylesheet">
    <link href="<?php echo @constant('WWW');?>
/Public/css/jquery.iphone.toggle.css" rel="stylesheet">
    <link href="<?php echo @constant('WWW');?>
/Public/css/uploadify.css" rel="stylesheet">
    <link href="<?php echo @constant('WWW');?>
/Public/css/animate.min.css" rel="stylesheet">

    <!-- jQuery -->
    <?php echo '<script'; ?>
 src="<?php echo @constant('WWW');?>
/Public/bower_components/jquery/jquery.min.js"><?php echo '</script'; ?>
>

    <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <?php echo '<script'; ?>
 src="http://html5shim.googlecode.com/svn/trunk/html5.js"><?php echo '</script'; ?>
>
    <![endif]-->

    <!-- The fav icon -->
    <link rel="shortcut icon" href="<?php echo @constant('WWW');?>
/Public/img/favicon.ico">

</head>

<body>
<div class="ch-container">
    <div class="row">
        
    <div class="row">
        <div class="col-md-12 center login-header">
            <h2>Welcome to BabYuan</h2>
        </div>
        <!--/span-->
    </div><!--/row-->

    <div class="row">
        <div class="well col-md-5 center login-box">
            <div class="alert alert-info">
                Please login with your Username and Password.
            </div>
            <!-- <form class="form-horizontal" action="/login/do_login.php" method="post"> -->
                <fieldset>
                    <div class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user red"></i></span>
                        <input type="text" class="form-control" placeholder="Username" id="username">
                    </div>
                    <div class="clearfix"></div><br>

                    <div class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock red"></i></span>
                        <input type="password" class="form-control" placeholder="Password" id="password">
                    </div>
                    <div class="clearfix"></div>

                    <div class="input-prepend">
                        <label class="remember" for="remember"><input type="checkbox" id="remember"> Remember me</label>
                    </div>
                    <div class="clearfix"></div>

                    <p class="center col-md-5">
                        <button type="button" class="btn btn-primary">Login</button>
                    </p>
                </fieldset>
            <!-- </form> -->
        </div>
        <!--/span-->
    </div><!--/row-->
</div><!--/fluid-row-->

</div><!--/.fluid-container-->

<!-- external javascript -->

<?php echo '<script'; ?>
 src="<?php echo @constant('WWW');?>
/Public/bower_components/bootstrap/dist/js/bootstrap.min.js"><?php echo '</script'; ?>
>

<!-- library for cookie management -->
<?php echo '<script'; ?>
 src="<?php echo @constant('WWW');?>
/Public/js/jquery.cookie.js"><?php echo '</script'; ?>
>
<!-- calender plugin -->
<?php echo '<script'; ?>
 src="<?php echo @constant('WWW');?>
/Public/bower_components/moment/min/moment.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo @constant('WWW');?>
/Public/bower_components/fullcalendar/dist/fullcalendar.min.js"><?php echo '</script'; ?>
>
<!-- data table plugin -->
<?php echo '<script'; ?>
 src="<?php echo @constant('WWW');?>
/Public/js/jquery.dataTables.min.js"><?php echo '</script'; ?>
>

<!-- select or dropdown enhancer -->
<?php echo '<script'; ?>
 src="<?php echo @constant('WWW');?>
/Public/bower_components/chosen/chosen.jquery.min.js"><?php echo '</script'; ?>
>
<!-- plugin for gallery image view -->
<?php echo '<script'; ?>
 src="<?php echo @constant('WWW');?>
/Public/bower_components/colorbox/jquery.colorbox-min.js"><?php echo '</script'; ?>
>
<!-- notification plugin -->
<?php echo '<script'; ?>
 src="<?php echo @constant('WWW');?>
/Public/js/jquery.noty.js"><?php echo '</script'; ?>
>
<!-- library for making tables responsive -->
<?php echo '<script'; ?>
 src="<?php echo @constant('WWW');?>
/Public/bower_components/responsive-tables/responsive-tables.js"><?php echo '</script'; ?>
>
<!-- tour plugin -->
<?php echo '<script'; ?>
 src="<?php echo @constant('WWW');?>
/Public/bower_components/bootstrap-tour/build/js/bootstrap-tour.min.js"><?php echo '</script'; ?>
>
<!-- star rating plugin -->
<?php echo '<script'; ?>
 src="<?php echo @constant('WWW');?>
/Public/js/jquery.raty.min.js"><?php echo '</script'; ?>
>
<!-- for iOS style toggle switch -->
<?php echo '<script'; ?>
 src="<?php echo @constant('WWW');?>
/Public/js/jquery.iphone.toggle.js"><?php echo '</script'; ?>
>
<!-- autogrowing textarea plugin -->
<?php echo '<script'; ?>
 src="<?php echo @constant('WWW');?>
/Public/js/jquery.autogrow-textarea.js"><?php echo '</script'; ?>
>
<!-- multiple file upload plugin -->
<?php echo '<script'; ?>
 src="<?php echo @constant('WWW');?>
/Public/js/jquery.uploadify-3.1.min.js"><?php echo '</script'; ?>
>
<!-- history.js for cross-browser state change on ajax -->
<?php echo '<script'; ?>
 src="<?php echo @constant('WWW');?>
/Public/js/jquery.history.js"><?php echo '</script'; ?>
>
<!-- application script for Charisma demo -->
<?php echo '<script'; ?>
 src="<?php echo @constant('WWW');?>
/Public/js/charisma.js"><?php echo '</script'; ?>
>

<?php echo '<script'; ?>
>
$(function(){
    $('.btn-primary').click(function(){
        if ($('#username').val() == '' || $('#password').val() == '') {
            return false;
        };
    });
});
<?php echo '</script'; ?>
>
</body>
</html>
<?php }} ?>
