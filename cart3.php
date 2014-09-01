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
                    <h1>DELIVERY</h1>
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
                            <li class="small-4 medium-2 columns checked current">
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
                        <h2>YOUR DALLIVERY ADDRESSS</h2>
                        <h3>Mandatory field *</h3>
                    </div>
                    <div class="small-12 large-10 columns">
                        <div class="medium-3 columns">
                            <label for="#">Title *</label>
                        </div>
                        <div class="medium-3 columns">
                            <select>
                                <option value="0">select</option>
                                <option value="Mr">Mr.</option>
                                <option value="Mrs">Mrs.</option>
                                <option value="Miss">Miss</option>
                            </select>
                        </div>
                        <div class="medium-3 columns">
                            <label for="#">First Name *</label>
                        </div>
                        <div class="medium-3 columns">
                            <input type="text">
                        </div>
                    </div>
                    <div class="small-12 large-10 large-offset-2 columns">
                        <div class="medium-3 columns">
                            <label for="#">Last Name *</label>
                        </div>
                        <div class="medium-3 columns">
                            <input type="text">
                        </div>
                        <div class="medium-3 columns">
                            <label for="#">Address *</label>
                        </div>
                        <div class="medium-3 columns">
                            <input type="text">
                        </div>
                        <div class="medium-3 columns">
                            <label for="#">Postcode *</label>
                        </div>
                        <div class="medium-3 columns">
                            <input type="text">
                        </div>
                        <div class="medium-3 columns">
                            <label for="#">City</label>
                        </div>
                        <div class="medium-3 columns">
                            <input type="text">
                        </div>
                        <div class="medium-3 columns">
                            <label for="#">Phone *</label>
                        </div>
                        <div class="medium-3 columns">
                            <div class="small-4 columns">
                                <select>
                                    <option value="1">+1</option>
                                    <option value="66">+66</option>
                                    <option value="291">+291</option>
                                </select>
                            </div>
                            <div class="small-8 columns">
                                <input type="text">
                            </div>
                        </div>
                        <div class="medium-3 columns">
                            <label for="#">Shopping method</label>
                        </div>
                        <div class="medium-3 columns">
                            <select>
                                <option value="0">Complimenttary Standart</option>
                            </select>
                        </div>
                        <div class="medium-6 medium-offset-3 columns end">
                            <label><input type="checkbox" value="1"> Include a personalised massage</label>
                        </div>
                    </div>
                </div>
                <br>
                <div class="navigator">
                    <div>
                        <a href="cart2.php" class="arrow_box left prev">Previous</a>
                        <a href="cart4.php" class="arrow_box right next">Continue</a>
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
