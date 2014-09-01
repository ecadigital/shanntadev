<?php require "inc/init.php"; ?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <?php require 'inc/layouts/head-tag.php';?>
        <link rel="stylesheet" href="<?php echo __css__; ?>/fractionslider.css">
        <link rel="stylesheet" href="<?php echo __css__; ?>/owl.carousel.css">

        <title>Shannta</title>
    </head>
    <body>
        <?php require "inc/layouts/browserhappy.php"; ?>
        <?php require "inc/layouts/topcartmenu.php"; ?>
        <?php require "inc/layouts/topmenu.php"; ?>
        <div id="content" class="row cart">
            <header class="ta-center">
                YOU ARE ENTERING A SECURE ZONE
            </header>
            <article class="boxDotted">
                <section class="large-6 columns">
                    <a href="cart1.php" class="guest">
                        <h1>CONTINUE AS A GUEST</h1>
                    </a>
                </section>
                <section class="large-6 columns">
                    <h1>EXISTING MEMBER</h1>
                    <div>
                        If you already have an account, please sign in below
                        <br>
                        <br>
                    </div>
                    <div class="large-2 columns">
                        <label for="#">Login</label>
                    </div>
                    <div class="large-10 columns">
                        <input type="text">
                    </div>
                    <div class="large-2 columns">
                        <label for="#">Password</label>
                    </div>
                    <div class="large-10 columns">
                        <input type="text">
                        <a class="forgot" href="#">FORGOTTEN YOUR PASSWORD?</a>
                    </div>
                    <div class="large-12 columns ta-center">
                        <button><b>SIGN IN</b></button>
                    </div>
                </section>
                <div class="clearfix"></div>
            </article>
        </div><!-- #content .row.cart -->
        <?php require "inc/layouts/footer-tag.php"; ?>
        <?php require "inc/layouts/javascript.php"; ?>
        <!-- javascript here -->
        <script type="text/javascript">
        </script>
    </body>
</html>
