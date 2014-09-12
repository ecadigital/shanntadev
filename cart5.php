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
        <div id="content" class="row cart">
            <header>
                <div class="medium-4 columns">
                    <h1>CONFIRMATION</h1>
                </div>
                <div class="medium-8 columns">
                    <nav>
                        <ul>
                            <li class="small-4 medium-2 columns checked">
                                <div class="large-4 columns">
                                    <div class="circle">1</div>
                                </div>
                                <div class="large-8 columns">
                                    <div class="stepNo">STEP 1</div>
                                    <div class="stepName">Register</div>
                                </div>
                            </li>
                            <li class="small-4 medium-2 columns checked">
                                <div class="large-4 columns">
                                    <div class="circle">2</div>
                                </div>
                                <div class="large-8 columns">
                                    <div class="stepNo">STEP 2</div>
                                    <div class="stepName">Payment</div>
                                </div>
                            </li>
                            <li class="small-4 medium-2 columns checked">
                                <div class="large-4 columns">
                                    <div class="circle">3</div>
                                </div>
                                <div class="large-8 columns">
                                    <div class="stepNo">STEP 3</div>
                                    <div class="stepName">Delivery</div>
                                </div>
                            </li>
                            <li class="small-4 medium-2 columns checked">
                                <div class="large-4 columns">
                                    <div class="circle">4</div>
                                </div>
                                <div class="large-8 columns">
                                    <div class="stepNo">STEP 4</div>
                                    <div class="stepName">Review</div>
                                </div>
                            </li>
                            <li class="small-4 medium-2 columns end checked current">
                                <div class="large-4 columns">
                                    <div class="circle">5</div>
                                </div>
                                <div class="large-8 columns">
                                    <div class="stepNo">STEP 5</div>
                                    <div class="stepName">Confirmation</div>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="clearfix"></div>
            </header>
            <form action="#" method="post">
                <div class="row">
                    <div class="small-12 medium-6 medium-push-6 columns cart5">
                        <div class="row">
                            <div class="small-6 medium-5 columns">
                                <h5>ORDER NUMBER</h5>
                            </div>
                            <div class="small-6 medium-7 columns">
                                <h6>E-45379</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="small-6 medium-5 columns">
                                <h5>PAYMENT METHOD</h5>
                            </div>
                            <div class="small-6 medium-7 columns">
                                <h6>Bank transfer</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="small-6 medium-5 columns">
                                <h5>SHIPPING METHOD</h5>
                            </div>
                            <div class="small-6 medium-7 columns">
                                <h6>Complimentary Starndard</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="small-6 medium-5 columns">
                                <h5>DELIVERY ADDRESS</h5>
                            </div>
                            <div class="small-6 medium-7 columns">
                                <h6>Miss Charintip Bumrungsak</h6>
                                <span>3801 The Gateway, Harbour City, Tsim Sha Tsui, kowloon, Hong Kong 23456</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="small-12 medium-5 columns">
                                <h5>PRODUCT DETAIL</h5>
                            </div>
                            <div class="small-12 medium-7 columns">
                                <div class="row">
                                    <div class="small-12 large-5 columns">
                                        <img src="<?php echo __images__;?>/demo/product5.png" alt="">
                                    </div>
                                    <div class="small-12 large-7 columns">
                                        <h6>JAZZ GLITZ STUD EARRINGS HEMATITE GREEN</h6>
                                        <div>Quantity : 1</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="small-12 large-5 columns">
                                        <img src="<?php echo __images__;?>/demo/product5.png" alt="">
                                    </div>
                                    <div class="small-12 large-7 columns">
                                        <h6>JAZZ GLITZ STUD EARRINGS HEMATITE GREEN</h6>
                                        <div>Quantity : 1</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="small-6 medium-5 columns">
                                <h5>TOTAL</h5>
                            </div>
                            <div class="small-6 medium-7 columns">
                                <h6>1,680 <b>THB</b></h6>
                            </div>
                        </div>
                    </div>
                    <div class="small-12 medium-6 medium-pull-6 columns">
                       <h2>THANK YOU FOR ORDER WITH SHANNTA.COM</h2>
                       <h3>A confirmation e-mail will be sent to you with all the relevant infomation regarding your purchase</h3>
                       <h3>Will your My Shannta account. you can track your order online. to find out more about the benefits of having a MyShannta on shannta.com </h3>
                       <div class="small-3 medium-5 large-4 columns"><a href="#" class="cabtn"><i class="fa fa-print"></i><b> PRINT</b></a></div>
                   </div>
                </div><!-- row -->
                <br>
                <div class="navigator">
                    <div>
                        <a href="index.php" class="button">Continue Shopping</a>
                    </div>
                </div> <!-- .navigator -->
            </form>
        </div><!-- #content .row.cart -->
        <?php require "inc/layouts/footer-tag.php"; ?>
        <?php require "inc/layouts/javascript.php"; ?>
        <!-- javascript here -->
        <script type="text/javascript">
        </script>
    </body>
</html>
