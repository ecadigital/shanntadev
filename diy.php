<?php require "inc/init.php"; 
$jewely_id = (isset($_GET['id'])) ? $_GET['id'] : 'first';
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <?php require 'inc/layouts/head-tag.php';?>
        <link rel="stylesheet" href="<?php echo __css__; ?>/owl.carousel.css">
        <title>Shannta</title>
    </head>
    <body>
        <?php require "inc/layouts/browserhappy.php"; ?>
        <?php require "inc/layouts/topcartmenu.php"; ?>
        <?php require "inc/layouts/topmenu.php"; ?>
		
        <div id="content" class="row page"></div><!-- #content .row.cart -->
		
        <?php require "inc/layouts/footer-tag.php"; ?>
        <?php require "inc/layouts/javascript.php"; ?>
        <script type="text/javascript" src="<?php echo __js__; ?>/owl.carousel.min.js"></script>
        <!-- javascript here -->
        <script type="text/javascript">
            loadPage('jewely/frontend/index/lang/<?php echo $defaultLang;?>/id/<?php echo $jewely_id;?>');
        </script>
    </body>
</html>
