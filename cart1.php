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
                    <h1>Register</h1>
                </div>
                <div class="medium-8 columns">
                    <nav>
                        <ul>
                            <li class="small-4 medium-2 columns checked current">
                                <div class="large-4 columns">
                                    <div class="circle">1</div>
                                </div>
                                <div class="large-8 columns">
                                    <div class="stepNo">STEP 1</div>
                                    <div class="stepName">Register</div>
                                </div>
                            </li>
                            <li class="small-4 medium-2 columns">
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
                        <h2>YOUR PROFILE</h2>
                        <h3>Mandatory field *</h3>
                    </div>
                    <div class="small-12 large-10 columns">
                        <div class="medium-2 columns">
                            <label for="#">Title *</label>
                        </div>
                        <div class="medium-4-custom columns">
                            <select>
                                <option value="0">select</option>
                                <option value="Mr">Mr.</option>
                                <option value="Mrs">Mrs.</option>
                                <option value="Miss">Miss</option>
                            </select>
                        </div>
                        <div class="medium-2 columns">
                            <label for="#">First Name *</label>
                        </div>
                        <div class="medium-4-custom columns">
                            <input type="text">
                        </div>
                    </div>
                    <div class="small-12 large-10 large-offset-2 columns">
                        <div class="medium-2 columns">
                            <label for="#">Last Name</label>
                        </div>
                        <div class="medium-4-custom columns">
                            <input type="text">
                        </div>
                        <div class="medium-2 columns">
                            <label for="#">Date of birth</label>
                        </div>
                        <div class="medium-4-custom columns">
                            <div class="medium-4 columns">
                                <select name="" id="">
                                    <option value="0">Day</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                    <option value="25">25</option>
                                    <option value="26">26</option>
                                    <option value="27">27</option>
                                    <option value="28">28</option>
                                    <option value="29">29</option>
                                    <option value="30">30</option>
                                    <option value="31">31</option>
                                </select>
                            </div>
                            <div class="medium-4 columns">
                                <select name="" id="">
                                    <option value="0">Month</option>
                                    <option value="1">January</option>
                                    <option value="2">February</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>
                            <div class="medium-4 columns">
                                <select name="" id="">
                                    <option value="0">Year</option>
                                    <option value="2014">2014</option>
                                    <option value="2013">2013</option>
                                    <option value="2012">2012</option>
                                    <option value="2011">2011</option>
                                    <option value="2010">2010</option>
                                    <option value="2009">2009</option>
                                    <option value="2008">2008</option>
                                    <option value="2007">2007</option>
                                    <option value="2006">2006</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="large-2 columns">
                        <h2>YOUR ACCOUNT</h2>
                        <br>
                    </div>
                    <div class="small-12 large-10 columns">
                        <div class="medium-2 columns">
                            <label for="#">E-mail Address *</label>
                        </div>
                        <div class="medium-4-custom columns">
                            <input type="text">
                        </div>
                        <div class="medium-2 columns">
                            <label for="#">Confirm E-mail *</label>
                        </div>
                        <div class="medium-4-custom columns">
                            <input type="text">
                        </div>
                    </div>
                    <div class="small-12 large-10 large-offset-2 columns">
                        <div class="medium-2 columns">
                            <label for="#">Password</label>
                        </div>
                        <div class="medium-4-custom columns">
                            <input type="text">
                        </div>
                        <div class="medium-2 columns">
                            <label for="#">Confirm Password *</label>
                        </div>
                        <div class="medium-4-custom columns">
                            <input type="text">
                        </div>
                    </div>
                </div> <!-- .row -->
                <div class="navigator">
                    <div>
                        <a href="cart2.php" class="arrow_box right next">Continue</a>
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
