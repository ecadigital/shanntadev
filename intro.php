<?php require_once("public/config/config.php.inc");

$arrMain = $mysqli->query("SELECT main_intro FROM main WHERE main_id='1' LIMIT 1");
$listMain = $arrMain->fetch_array(MYSQLI_ASSOC);
$main_intro = $listMain['main_intro'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<style type="text/css">
	</style>
<title>Shannta</title>
</head>
   <!-- Extra white-space below is just to make it easier to read. :-) -->

   <!--[if lt IE 7 ]>   <body class="ie6">          <![endif]-->
   <!--[if IE 7 ]>      <body class="ie7">          <![endif]-->
   <!--[if IE 8 ]>      <body class="ie8">          <![endif]-->
   <!--[if IE 9 ]>      <body class="ie9">          <![endif]-->
   <!--[if (gt IE 9) ]> <body class="modern">       <![endif]-->
   <!--[!(IE)]><!-->    <body class="notIE modern"> <!--<![endif]-->
   <div class="wrapper">
		<div id="banner">
			
		</div>
	</div>
    <?php echo html_entity_decode($main_intro);?>
</body>
</html>