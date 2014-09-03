<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title></title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />


<link rel="stylesheet" href="<?php echo DIR_PUBLIC?>layout/default/css/normalize.min.css">
<link rel="stylesheet" href="<?php echo DIR_PUBLIC?>layout/default/css/main.css">
<link rel="stylesheet" href="<?php echo DIR_PUBLIC?>layout/default/css/slider.css" type="text/css" media="screen">
<link rel="stylesheet" href="<?php echo DIR_PUBLIC?>layout/default/css/inner.css">
<link rel="stylesheet" href="<?php echo DIR_PUBLIC?>layout/default/css/homedesign.css">
<link rel="stylesheet" href="<?php echo DIR_PUBLIC?>layout/default/css/colorbox.css" />
<link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow&v1' rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300&v2' rel='stylesheet' type='text/css'>
<script src="<?php echo DIR_PUBLIC?>layout/default/js/jquery-1.9.1.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php echo DIR_PUBLIC?>layout/default/js/jquery-1.9.1.min.js"><\/script>')</script>
<script src="<?php echo DIR_PUBLIC?>layout/default/js/jquery.easing.1.3.js"></script>
<script src="<?php echo DIR_PUBLIC?>layout/default/js/touchswipe.js"></script>
<script src="<?php echo DIR_PUBLIC?>layout/default/js/swipe.js"></script>
<script src="<?php echo DIR_PUBLIC?>layout/default/js/jquery.colorbox-min.js"></script>


<script src="<?php echo DIR_PUBLIC?>layout/default/js/main.js"></script>
<script src="<?php echo DIR_PUBLIC?>layout/default/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>

<script src="<?php echo DIR_PUBLIC?>layout/default/js/jquery.vaccordion.js"></script>

<script src="<?php echo DIR_PUBLIC?>js/script.js"></script>

<script>
    $(document).ready(function(){
        $(".group3").colorbox({rel:'group3', transition:"fade", width:"85%", height:"auto"});
        var heightval1 = $(window).height();
        $.versatileTouchSlider('#inside', {
              slideWidth: '100%', //some number. ex: 650 or '100%'
              slideHeight: heightval1, //some number. ex: 400 or 'auto'
              showPreviousNext: true,
              currentSlide: 0,
              scrollSpeed: 800,
              autoSlide: false,
              autoSlideDelay: 7000,
              showPlayPause: false,
              showPagination: true,
              alignPagination: 'center',
              alignMenu: 'left',
              swipeDrag: true,
              sliderType: 'image_banner',
              pageStyle: 'bullets', // numbers, bullets, thumbnails
              orientation: 'horizontal', // horizontal, vertical (if vertical, the "slideHeight" option must be a number, not 'auto')
              onScrollEvent: function(slideNum) { textAnimate(slideNum) }, 
              ajaxEvent: function() {}
        });	        
        var heightval = $(window).height();
        //alert(heightval);
        $('.column2').css('height',heightval+'px');
        $('.column1').css('height',heightval+'px');
        //$('.column1 .box').css('height',heightval+'px');
        $('.column2 ul li').click(function(){
            $('.column2 ul li').removeClass('menuactive');
            $(this).addClass('menuactive');
            var cnt = $(this).attr('id');
            
            switch (cnt) {
                case 'concept':
                    $('.box').fadeOut(400);
                    $('.box.'+cnt).delay(100).fadeIn(400);
                break; 	
                
                case 'design':
                    $('.box').fadeOut(400);
                    $('.box.'+cnt).delay(100).fadeIn(400);
                 break; 	
                
                case 'facilities':
                    $('.box').fadeOut(400);
                    $('.box.'+cnt).delay(100).fadeIn(400);								   
                 break; 	
                
                
                case 'promotion':
                    $('.box').fadeOut(400);
                    $('.box.'+cnt).delay(100).fadeIn(400);							    
                break; 	
                
                case 'location':
                    $('.box').fadeOut(400);
                    $('.box.'+cnt).delay(100).fadeIn(400);						    
                    break; 
                
                case 'contact':
                    $('.box').fadeOut(400);
                    $('.box.'+cnt).delay(100).fadeIn(400);							    
                    break; 	
            }
        });
    });
</script>
</head>

<body>
    <!--[if lt IE 7]>
        <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->

	<div class="wrapper">
    	<div id="overlay"></div>
		<div class="main-wrapper"><?php echo $switchlang;?>	
      		<?php echo $content;?>
        </div><!--main-wrapper-->
    </div><!--wrapper-->
    
      


</body>
<?php /*?><!--<body>
	<div id="wrapper" style="background:#f2f2f2;">
		<?php echo $frontmenu;?>
		<?php echo $switchlang;?>		
	
		<div id="ref-inner">	
 			<div class="inner">
                <?php echo $content;?>
            </div><!--inner-->
        </div><!--ref inner-->
	</div><!--wrpper-->
	<?php echo $sitemap;?>
    
</body>--><?php */?>
</html>