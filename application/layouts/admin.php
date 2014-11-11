<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
<head>
	<?php $layout = 'admin';?>
    <title>Admin</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo DIR_PUBLIC?>layout/<?php echo $layout;?>/images/favicon.ico">
    
    <!-- All CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo DIR_PUBLIC ?>css/reset.css" charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="<?php echo DIR_PUBLIC ?>css/uploadify.css" charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="<?php echo DIR_PUBLIC ?>css/style.css" charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="<?php echo DIR_PUBLIC ?>css/jquery.fancybox-1.3.4.css" charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="<?php echo DIR_PUBLIC ?>layout/<?php echo $layout;?>/css/style.css" charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="<?php echo DIR_PUBLIC ?>layout/<?php echo $layout;?>/css/top_menu.css" charset="utf-8" />
    <!-- All CSS -->
    
    <!-- All JS -->
    <script type="text/javascript" src="<?php echo DIR_PUBLIC ?>js/jquery-1.7.min.js" ></script>
	<script type="text/javascript" src="<?php echo DIR_PUBLIC ?>js/jquery-ui-1.8.20.custom.js"></script>
    <script type="text/javascript" src="<?php echo DIR_PUBLIC ?>js/jquery.validate.js" ></script>
    <script type="text/javascript" src="<?php echo DIR_PUBLIC ?>js/jquery.fancybox-1.3.4.js" ></script>
    <script type="text/javascript" src="<?php echo DIR_PUBLIC ?>js/jquery.uploadify-3.1.js" ></script>
    <script type="text/javascript" src="<?php echo DIR_PUBLIC ?>js/plugin.js"></script>
	<script type="text/javascript" src="<?php echo DIR_PUBLIC ?>js/script.js" ></script>
    <!-- All JS -->
    
</head>
<body>
<div id="header">
	<div class="inHeader">
		<div class="inHeaderMenu">
        	<?php echo $top_menu;?>
        </div>
		<div class="mosAdmin">
		<?php echo $showlogin;?>
		</div>
	<div class="clear"></div>
	</div>
</div>

<div id="wrapper">
	<!--<div id="leftBar">
    	<?php echo $left_sidebar?>
	</div>-->
	<div id="rightContent">
    	<?php echo $content?>
	</div>
	<div class="clear"></div>
	<div id="footer">
		&copy; 2012 MOS css template : Modified by Jiwako | <a href="<?php echo DIR_ROOT;?>">Shannta</a>
	</div>
</div>
</body>
</html>