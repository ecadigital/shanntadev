<?php require "inc/init.php"; ?>
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
        <div id="content" class="row page">
            <header>
                <h1>JEWELRY D.I.Y</h1>
                <!-- <hr> -->
                <div class="headImage">
                    <img src="<?php echo __images__;?>/diy-h.png" alt="">
                </div>
            </header>
            <div class="innerContent">
                <div class="small-12 large-7 columns end">
                    <h3>Make your own Bronze and Copper Metal Clay</h3>
                    <p><b>Artist : </b> Charintip B. <b>Date : </b> 10-03-2014</p><br>
                </div>
                <div class="medium-8 large-7 medium-centered columns">
                    <iframe width="100%" height="315" src="//www.youtube.com/embed/nLiHEN52SXk?rel=0" frameborder="0" allowfullscreen></iframe>
                    <br>
                </div><br>
                <div class="small-12 columns cms end">
                    <h3>Binders for DIY Metal Clay</h3>
                    <p>
                        Chemist Kevin has been in touch to say that ordinary wallpaper paste, the dry powder type, works well as a binder.
                        Sharon Morrison from the Seattle area posted some useful information about binders on the Metal Clay Yahoo! Group. She has kindly given us permission
                        to repost her information here.
                    </p>
                    <p>
                        "I use various gums for gluten-free baking - xanthan gum, guar gum, methylcellulose (MC) (I am not sure if this is the same as CMC - carboxy methyl
                        cellulose- which is used to thicken glaze mixtures and is also used for DIY glass clay). I've tried them all for DIY bronze clay: The 'sticky' ones work best for
                        metal clay - methylcellulose and xanthan gum. Guar gum adds body, but doesn't hold things together. I tried Wilton 'gum-tex' (labeled karaya gum), which
                        also adds body, but not much adhesion.
                    </p>
                    <p>
                        My first attempt used 'pre-hydrated' methylcellulose, inspired by a glass clay recipe from Barry Kaiser's website. I substituted MC for CMC, soak MC in water
                        for a day or so and use the resulting clear gel to form a clay-like mixture with fine particles of your choice. I tend to mix by eye, and use leftovers from previous
                        recipes, so my bronze clay has variable shrinkage and properties: it doesn't matter for just playing around. For rings and nice jewelry, commercial clay is
                        MUCH better: finer finish and less shrinkage. I think a good mixture should mostly use a 'sticky' binder with a little bit of 'body' binder and then a drop or two
                        of glycerine for added flexibility. I read somewhere than you can add a little sugar/corn syrup and oil to modifiy the clay: try home made playdough recipes?
                    </p>
                    <p>
                        I suppose you could mix DIY metal clay and commercial clay to get an intermediate quality clay, but you'd have to check for binder incompatibility."
                    </p>
                    <h3>Make your own Bronze and Copper Metal Clay Video Tutorial</h3>
                    <p>
                        This video has the instructions on how to mix your own copper or bronze metal clay from ingredients that are available online. The cost per 100 grams is
                        about 1/4th the cost of commercial pre-mixed metal clay.
                    </p>
                </div><!-- CMS -->
                <div class="clearfix"></div>
                <hr>
                <nav class="moreDiy">
                    <h2>More D.I.Y</h2>
                    <div>
                        <div class="item">
                            <a href="#">
                                <img src="<?php echo __images__;?>/more-diy-1.png" alt="">
                                <aside>Galieria AURUS, Fine Silver Metal Clay with Labradorite</aside>
                            </a>
                        </div>
                        <div class="item">
                            <a href="#">
                                <img src="<?php echo __images__;?>/more-diy-2.png" alt="">
                                <aside>Galieria AURUS, Fine Silver Metal Clay with Labradorite</aside>
                            </a>
                        </div>
                        <div class="item">
                            <a href="#">
                                <img src="<?php echo __images__;?>/more-diy-3.png" alt="">
                                <aside>Galieria AURUS, Fine Silver Metal Clay with Labradorite</aside>
                            </a>
                        </div>
                    </div>
                </nav><!-- moreDiy -->
            </div>
        </div><!-- #content .row.cart -->
        <?php require "inc/layouts/footer-tag.php"; ?>
        <?php require "inc/layouts/javascript.php"; ?>
        <script type="text/javascript" src="<?php echo __js__; ?>/owl.carousel.min.js"></script>
        <!-- javascript here -->
        <script type="text/javascript">
            $(document).ready(function(){
                $(".moreDiy > div").owlCarousel({
                    margin: 15,
                    responsive: {
                        0: {
                            items: 2,
                        },
                        640:{
                            items: 3,
                        }
                    }
                });
            });
        </script>
    </body>
</html>
