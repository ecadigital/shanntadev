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
                    <h1>REVIEW</h1>
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
                            <li class="small-4 medium-2 columns checked current">
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
                <div class="row productTable">
                    <div class="medium-4 columns">
                        <h2>ORDER DETAIL</h2>
                        <h3>You will find your ourchase details below.</h3>
                    </div>
                    <div class="small-12 medium-5 medium-offset-3 columns addressReview">
                        <h2>DELIVERY ADDRESS</h2>
                        <b>Miss Charintip Bumrungsak</b>
                        <div>3801 The Gateway, Harbour City, Tsim Sha Tsui, Kowloon, Hong Kong 23456</div>
                        <a class="edit"><i class="fa fa-pencil icon"></i> EDIT</a>
                    </div>
                    <table>
                        <tr>
                            <td>
                                <h4>Product</h4>
                            </td>
                            <td class="medium-7">
                                <h4>Description</h4>
                            </td>
                            <td>
                                <h4>Price</h4>
                            </td>
                        </tr>
                        <tr class="first">
                            <td class="image">
                                <img src="<?php echo __images__;?>/demo/product5.png" alt="">
                            </td>
                            <td>
                                <h5>JAZZ GLITZ STUD EARRINGS HEMATITE GREEN</h5>
                                <div class="show-for-medium-up details">Rihodium plated brass statement earring adomed with eye-catching Hematites, Lapis and Fang Details Hematite plated earrings</div>
                            </td>
                            <td>
                                <div class="price">1,680 <b>THB</b></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="image">
                                <img src="<?php echo __images__;?>/demo/product5.png" alt="">
                            </td>
                            <td>
                                <h5>JAZZ GLITZ STUD EARRINGS HEMATITE GREEN</h5>
                                <div class="show-for-medium-up details">Rihodium plated brass statement earring adomed with eye-catching Hematites, Lapis and Fang Details Hematite plated earrings</div>
                            </td>
                            <td>
                                <div class="price">1,680 <b>THB</b></div>
                            </td>
                        </tr>
                    </table>
                    <hr class="review">
                    <div class="small-12 columns optionalCheckbox">
                        <label class="checkbox"><input type="checkbox" value="1"> Include a personalised massage</label>
                    </div>
                    <div class="small-12 medium-4 columns total">
                        <div class="small-3 columns">Shipping</div>
                        <div class="small-9 columns ta-right"> 0 THB</div>
                        <div class="small-3 columns"><b>Total</b></div>
                        <div class="small-9 columns ta-right"><b>3,360 THB</b></div>
                        <div class="clearfix"></div>
                        <label class="checkbox"><input type="checkbox" value="1"> I accept the general <u>terms and condition</u></label>
                    </div>
                </div>
                <br>
                <div class="navigator">
                    <div>
                        <a href="cart3.php" class="arrow_box left prev">Previous</a>
                        <a href="cart5.php" class="arrow_box right next">Continue</a>
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
