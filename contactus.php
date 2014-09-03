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
        <div id="content" class="row page">
            <header>
                <h1>CONTACT US </h1>
                <!-- <hr> -->
                <div class="headImage">
                    <img src="<?php echo __images__;?>/contactus-h.png" alt="">
                </div>
            </header>
            <div class="small-12 large-7 columns end">
                <h2>SHANNTA JEWELRY</h2>
                <p><b>THE UNIQUE ART PRODUCT WITH SEVERAL PRODUCT AND SERVICE ROOM</b><br>
                306, 3rd Floor Bangkok Art and Cukturat Center - Pathumwan Bangkok, Thailand 12390</p> 
                <p><b>SHOP OPEN</b> : Tue - Sun : 10 am - 9 om. <b>TELLEPHONE :</b> +(66)2-214-3018</p>
            </div>
            <div class="small-12 large-7 columns">
                <img src="<?php echo __images__;?>/dummy-map.png" alt="">
            </div>
            <div class="small-12 large-5 column">
                <form>
                    <input type="text" placeholder="Name">
                    <input type="text" placeholder="Email">
                    <input type="text" placeholder="Tel">
                    <textarea rows="5">Massage</textarea>
                    <div class="ta-right">
                        <input type="submit" value="Send Massage >" class="button">
                    </div>
                </form>
            </div>
        </div><!-- #content .row.cart -->
        <?php require "inc/layouts/footer-tag.php"; ?>
        <?php require "inc/layouts/javascript.php"; ?>
        <!-- javascript here -->
        <script type="text/javascript">
            
        </script>
    </body>
</html>
