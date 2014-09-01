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

<<<<<<< HEAD
        <title>Shannta</title>
=======
        <title>Shanntaaa</title>
>>>>>>> origin/dev
    </head>
    <body>
    <div>sdsdsjkdjs</div>
        <?php require "inc/layouts/browserhappy.php"; ?>
        <?php require "inc/layouts/topcartmenu.php"; ?>
        <div class="headSlider row show-for-medium-up">
            <div class="fs_loader"></div>
            <div class="slide one" data-in="scrollLeft">
                <p data-in="right" data-position="220,20" data-delay="500"  data-time="1250">Slide transitions</p>
                <p data-in="right" data-position="260,20" data-delay="1500" data-time="2250">set individual animation per slide</p>
                <p data-in="right" data-position="300,20" data-delay="2000" data-time="2750">or just set it global</p>
                <img data-in="bottomLeft" data-time="1000" data-position="0,470" src="http://lorempixel.com/g/400/200/">
                <img data-in="bottomLeft" data-time="1500" data-delay="750" data-position="100,340" src="http://lorempixel.com/g/400/200/">
                <img data-fixed src="http://lorempixel.com/g/400/200/" width="1000" height="500">
            </div>
            <div class="slide two" data-in="fade">
                <p data-in="fade"   data-position="20,20" data-delay="500"  data-time="1250">scroll 'em</p>
                <p data-in="fade"   data-position="20,110"  data-delay="1500" data-time="2250">blend 'em</p>
                <p data-in="fade"   data-position="20,200"  data-delay="2500" data-time="3250">fade 'em</p>
                <img data-in="topRight" data-time="1000" data-position="80,70" src="http://lorempixel.com/g/400/200/">
                <img data-in="bottomRight" data-time="1500" data-delay="750" data-position="180,140" src="http://lorempixel.com/g/400/200/">
                <img data-fixed src="http://lorempixel.com/g/400/200/" width="1000" height="500">
            </div>
        </div><!-- headSlider -->
        <?php require "inc/layouts/topmenu.php"; ?>
        <div class="headSlider show-for-small-only">
            <!-- <div class="slide"><img src="http://lorempixel.com/g/400/200/" alt="" data-position="100,100"></div> -->
            <!-- <div class="slide"><img src="http://lorempixel.com/g/400/200/" alt="" data-position="100,200"></div> -->
            <div class="fs_loader"></div>
            <div class="slide one" data-in="scrollLeft">
                <p data-in="right" data-position="220,20" data-delay="500"  data-time="1250">Slide transitions</p>
                <p data-in="right" data-position="260,20" data-delay="1500" data-time="2250">set individual animation per slide</p>
                <p data-in="right" data-position="300,20" data-delay="2000" data-time="2750">or just set it global</p>
                <img data-in="bottomLeft" data-time="1000" data-position="0,470" src="http://lorempixel.com/g/400/200/">
                <img data-in="bottomLeft" data-time="1500" data-delay="750" data-position="100,340" src="http://lorempixel.com/g/400/200/">
                <img data-fixed src="http://lorempixel.com/g/400/200/" width="1000" height="500">
            </div>
            <div class="slide two" data-in="fade">
                <p data-in="fade"   data-position="20,20" data-delay="500"  data-time="1250">scroll 'em</p>
                <p data-in="fade"   data-position="20,110"  data-delay="1500" data-time="2250">blend 'em</p>
                <p data-in="fade"   data-position="20,200"  data-delay="2500" data-time="3250">fade 'em</p>
                <img data-in="topRight" data-time="1000" data-position="80,70" src="http://lorempixel.com/g/400/200/">
                <img data-in="bottomRight" data-time="1500" data-delay="750" data-position="180,140" src="http://lorempixel.com/g/400/200/">
                <img data-fixed src="http://lorempixel.com/g/400/200/" width="1000" height="500">
            </div>
        </div><!-- headSlider -->
        <div id="content" class="row">
            <section class="small-12 medium-6-gutter columns catagories">
                <article class="innerCatagorie">
                    <section class="small-7 medium-7 large-8 columns details">
                        <h1>COLLECTION</h1>
                        <section>
                            <h2>ORGANIC CIRCLES GOLD CUPS</h2>
                            and our crane systems are professional designed
                        </section>
                    </section><!-- details -->
                    <section class="small-5 medium-5 large-4 columns rightImage">
                        <img src="<?php echo __images__;?>/demo/product1.png" alt="">
                    </section><!-- rightImage -->
                </article><!-- innerProduct -->
            </section><!-- catagories -->
            <section class="small-12 medium-6-gutter columns catagories">
                <article class="innerCatagorie">
                    <section class="small-7 medium-7 large-8 columns details">
                        <h1>JEWELRY D.I.Y</h1>
                        <section>
                            <strong>Rellable suppllers in Europe.</strong><br>
                            and our crene systems are professional design and manufactured...
                        </section>
                    </section><!-- details -->
                    <section class="small-5 medium-5 large-4 columns rightImage">
                        <img src="<?php echo __images__;?>/demo/product2.png" alt="">
                    </section><!-- rightImage -->
                </article><!-- innerProduct -->
            </section><!-- catagories -->
            <section class="small-12 columns catagories">
                <nav class="paginationCatagorieSlider row show-for-medium-up">
                    <div class="medium-2 columns item arrow_box " data-merge="1"><a href="#">CHARMS</a></div>
                    <div class="medium-2 columns item arrow_box " data-merge="1"><a href="#">BRACELETS</a></div>
                    <div class="medium-2 columns item arrow_box " data-merge="1"><a href="#">RINGS</a></div>
                    <div class="medium-2 columns item arrow_box active" data-merge="1"><a href="#">EARRINGS</a></div>
                    <div class="medium-4 columns item arrow_box " data-merge="2"><a href="#">NECKLACES AND PENDANTS</a></div>
                    <div class="" data-merge="1"></div>
                </nav>
                <div class="catagorieSlider">
                    <article class="item">
                        <section class="small-12 medium-6 medium-push-6 columns">
                            <img src="<?php echo __images__;?>/demo/product3.png" alt="">
                        </section>
                        <section class="small-12 medium-6 medium-pull-6 columns details">
                            <h1>EARRINGS</h1>
                            <p><strong>Sterling silver, 14k gold. two-tone and an abundance of beautiful gemstones make up the PANDORA</strong></p>
                            <a href="#" class="button">See all Errings</a>
                        </section>
                        <div class="clearfix"></div>
                    </article>
                    <article class="item">
                        <section class="small-12 medium-6 medium-push-6 columns">
                            <img src="<?php echo __images__;?>/demo/product3.png" alt="">
                        </section>
                        <section class="small-12 medium-6 medium-pull-6 columns details">
                            <h1>EARRINGS</h1>
                            <p><strong>Sterling silver, 14k gold. two-tone and an abundance of beautiful gemstones make up the PANDORA</strong></p>
                            <a href="#" class="button">See all Errings</a>
                        </section>
                        <div class="clearfix"></div>
                    </article>
                    <article class="item">
                        <section class="small-12 medium-6 medium-push-6 columns">
                            <img src="<?php echo __images__;?>/demo/product3.png" alt="">
                        </section>
                        <section class="small-12 medium-6 medium-pull-6 columns details">
                            <h1>EARRINGS</h1>
                            <p><strong>Sterling silver, 14k gold. two-tone and an abundance of beautiful gemstones make up the PANDORA</strong></p>
                            <a href="#" class="button">See all Errings</a>
                        </section>
                        <div class="clearfix"></div>
                    </article>
                    <article class="item">
                        <section class="small-12 medium-6 medium-push-6 columns">
                            <img src="<?php echo __images__;?>/demo/product3.png" alt="">
                        </section>
                        <section class="small-12 medium-6 medium-pull-6 columns details">
                            <h1>EARRINGS</h1>
                            <p><strong>Sterling silver, 14k gold. two-tone and an abundance of beautiful gemstones make up the PANDORA</strong></p>
                            <a href="#" class="button">See all Errings</a>
                        </section>
                        <div class="clearfix"></div>
                    </article>
                    <article class="item">
                        <section class="small-12 medium-6 medium-push-6 columns">
                            <img src="<?php echo __images__;?>/demo/product3.png" alt="">
                        </section>
                        <section class="small-12 medium-6 medium-pull-6 columns details">
                            <h1>EARRINGS</h1>
                            <p><strong>Sterling silver, 14k gold. two-tone and an abundance of beautiful gemstones make up the PANDORA</strong></p>
                            <a href="#" class="button">See all Errings</a>
                        </section>
                        <div class="clearfix"></div>
                    </article>
                </div><!-- productSlider -->
            </section><!-- products -->
            <div class="clearfix"></div>
        </div><!-- row -->
        <?php require "inc/layouts/footer-tag.php"; ?>
        <?php require "inc/layouts/javascript.php"; ?>
        <script type="text/javascript" src="<?php echo __js__; ?>/jquery.fractionslider.min.js"></script>
        <script type="text/javascript" src="<?php echo __js__; ?>/owl.carousel.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $('.headSlider').fractionSlider({
                    'fullWidth':            false,
                    'controls':             false, 
                    'pager':                true,
                    'fullWidth':            true,
                    'responsive':           true,
                    'dimensions':           '1000,500',
                });
                var sync1 = $(".catagorieSlider");
                var sync2 = $(".paginationCatagorieSlider");
                var flag = false;
                var slides = sync1.owlCarousel({
                    loop: true,
                    items: 1,
                    autoplay: true,
                    autoplayTimeout: 3000,
                    autoplayHoverPause: true,

                    onInitialized: function(e){
                        if (sync2.children().hasClass("active")) {
                            sync1.trigger('to.owl.carousel', [sync2.children(".active").index(), 300, true]);
                            // alert(sync2.children(".active").index());
                        };
                    // alert(1);
                  }
                }).on('change.owl.carousel', function(e) {
                    sync2.children().removeClass("active");
                    sync2.children().eq(e.relatedTarget.relative(e.property.value)).addClass("active");
                }).data('owl.carousel');
                var thumbs = sync2.on('click', '.item', function(e) {
                        e.preventDefault();
                        sync2.children().removeClass("active");
                        sync1.trigger('to.owl.carousel', [$(this).index(), 300, true]);
                        $(this).addClass("active");
                }).data('owl.carousel');
            });
        </script>
    </body>
</html>
