<?php require "inc/init.php"; 
$prev_page = (isset($_SESSION['prev_page'])) ? $_SESSION['prev_page'] : "home.php";
$_SESSION['prev_page'] = "news1.php";

if(!isset($_GET['id'])) echo '<script>window.location="home.php";</script>';
else{
$news_id = $_GET['id'];
?>
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
        
		<div id="content" class="row page"></div><!-- #content .row.cart -->
		
        <?php require "inc/layouts/footer-tag.php"; ?>
        <?php require "inc/layouts/javascript.php"; ?>
        <!-- javascript here -->
        <script type="text/javascript">
            loadPage('news/frontend/detail/lang/<?php echo $defaultLang;?>/id/<?php echo $news_id;?>');
        </script>
    </body>
</html>
<?php }?>
