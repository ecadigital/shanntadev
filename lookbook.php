<?php require "inc/init.php"; ?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <?php require 'inc/layouts/head-tag.php';?>
        <title>Shannta</title>
    </head>
    <body>
        <?php require "inc/layouts/browserhappy.php"; ?>
        <?php require "inc/layouts/topcartmenu.php"; ?>
        <?php require "inc/layouts/topmenu.php"; ?>
        <div id="content" class="row fullPage">
            <div class="row">
                <a href="#">
                    <img src="<?php echo __images__;?>/lookbook-1.png" alt="">
                </a>
            </div>
            <div class="row">
                <a href="#">
                    <img src="<?php echo __images__;?>/lookbook-2.png" alt="">
                </a>
            </div>
            <div class="row">
                <a href="#">
                    <img src="<?php echo __images__;?>/lookbook-3.png" alt="">
                </a>
            </div>
            <div class="row">
                <img src="<?php echo __images__;?>/lookbook-4.png" alt="">
            </div>
        </div><!-- #content .row.cart -->
        <?php require "inc/layouts/footer-tag.php"; ?>
        <?php require "inc/layouts/javascript.php"; ?>
        <!-- javascript here -->
        <script type="text/javascript">
            
        </script>
    </body>
</html>
