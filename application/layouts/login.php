<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
	<head>
		<?php $layout = 'login';?>
	    <title>Login</title>
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	    
	    <!-- All CSS -->
	    <link rel="stylesheet" type="text/css" href="<?php echo DIR_PUBLIC ?>css/reset.css" charset="utf-8" />
	    <link rel="stylesheet" type="text/css" href="<?php echo DIR_PUBLIC ?>layout/<?php echo $layout ?>/css/style.css" charset="utf-8" />
	    <!-- All CSS -->
	    
	    <!-- All JS -->
	    <script type="text/javascript" src="<?php echo DIR_PUBLIC ?>js/jquery-1.7.min.js" ></script>
	    <script type="text/javascript" src="<?php echo DIR_PUBLIC ?>js/script.js" ></script>
	    <script type="text/javascript" src="<?php echo DIR_PUBLIC ?>layout/<?php echo $layout ?>/js/script.js" ></script>
	    <!-- All JS -->
	    
	</head>
    <body>
        <!--<div id="header">
            <div class="inHeaderLogin"></div>
        </div>-->

        <div id="content" style="margin-top:150px;">
            <?php echo $content?>
        </div>
        
        <div class="clearfix"></div>
    </body>
</html>