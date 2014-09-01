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
                    <h1>MY SELECTION</h1>
                </div>
                <div class="medium-8 columns">
                </div>
                <div class="clearfix"></div>
            </header>
            <form action="#" method="post">
                <div class="row productTable shipping">
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
                        <br>
                    </div>
                    <div class="small-12 medium-4 columns total">
                        <div class="small-3 columns">Shipping</div>
                        <div class="small-9 columns ta-right"> 0 THB</div>
                        <div class="small-3 columns"><b>Total</b></div>
                        <div class="small-9 columns ta-right"><b>3,360 THB</b></div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <br>
                <div class="navigator">
                    <div>
                        <a href="cart0.php" class="arrow_box right next">Continue</a>
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
