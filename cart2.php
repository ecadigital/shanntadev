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
                    <h1>PAYMENT</h1>
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
                            <li class="small-4 medium-2 columns checked current">
                                <div class="large-4 columns">
                                    <div class="circle">2</div>
                                </div>
                                <div class="large-8 columns">
                                    <div class="stepNo">STEP 2</div>
                                    <div class="stepName">Payment</div>
                                </div>
                            </li>
                            <li class="small-4 medium-2 columns ">
                                <div class="large-4 columns">
                                    <div class="circle">3</div>
                                </div>
                                <div class="large-8 columns">
                                    <div class="stepNo">STEP 3</div>
                                    <div class="stepName">Delivery</div>
                                </div>
                            </li>
                            <li class="small-4 medium-2 columns">
                                <div class="large-4 columns">
                                    <div class="circle">4</div>
                                </div>
                                <div class="large-8 columns">
                                    <div class="stepNo">STEP 4</div>
                                    <div class="stepName">Review</div>
                                </div>
                            </li>
                            <li class="small-4 medium-2 columns end">
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
                    <div class="large-2 columns">
                        <h2>PAYMENT</h2>
                    </div>
                    <div class="small-12 large-10 columns">
                        <div class="medium-2 columns">
                            <label for="#">Payment Method</label>
                        </div>
                        <div class="medium-4-custom columns end">
                            <select name="" id="">
                                <option value="creditcard">Credit Card</option>
                                <option value=""></option>
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="large-2 columns">
                        <h2>DETAIL CARD</h2>
                    </div>
                    <div class="small-12 large-10 columns">
                        <div class="medium-2 columns">
                            <label for="#">Card</label>
                        </div>
                        <div class="medium-10 columns end">
                            <label><input type="radio" name="card" value="visa">&nbsp;&nbsp;<img src="<?php echo __images__;?>/assets/bank-1.png"></label>
                            <label><input type="radio" name="card" value="master">&nbsp;&nbsp;<img src="<?php echo __images__;?>/assets/bank-2.png"></label>
                        </div>
                    </div>
                    <div class="small-12 large-10 large-offset-2 columns">
                        <div class="medium-2 columns">
                            <label for="#">Card number</label>
                        </div>
                        <div class="medium-4-custom columns">
                            <input type="text">
                        </div>
                        <div class="medium-2 columns">
                            <label for="#">Name of Card Hoder</label>
                        </div>
                        <div class="medium-4-custom columns">
                            <input type="text">
                        </div>
                    </div>
                    <div class="small-12 large-10 large-offset-2 columns">
                        <div class="medium-2 columns">
                            <label for="#">Expiration date</label>
                        </div>
                        <div class="medium-4-custom columns">
                            <div class="medium-6 columns">
                                <select name="years">
                                    <option value="2017">2017</option>
                                    <option value="2016">2016</option>
                                    <option value="2015">2015</option>
                                    <option value="2014">2014</option>
                                </select>
                            </div>
                            <div class="medium-5 columns">
                                <select name="month">
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="04">04</option>
                                    <option value="05">05</option>
                                    <option value="06">06</option>
                                    <option value="07">07</option>
                                    <option value="08">08</option>
                                    <option value="09">09</option>
                                    <option value="09">10</option>
                                    <option value="09">11</option>
                                    <option value="09">12</option>
                                </select>
                            </div>
                        </div>
                        <div class="medium-2 columns">
                            <label for="#">Security cord</label>
                        </div>
                        <div class="medium-4-custom columns">
                            <input type="text">
                        </div>
                    </div>
                </div> <!-- .row -->
                <div class="notice ta-center">
                    For security reasons, please note that your credit information is not retained
                </div>
                <br>
                <div class="navigator">
                    <div>
                        <a href="cart1.php" class="arrow_box left prev">Previous</a>
                        <a href="cart3.php" class="arrow_box right next">Continue</a>
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
