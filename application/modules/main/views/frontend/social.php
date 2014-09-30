<?php 
$main_email = '';
$main_facebook = '';
$main_instagram = '';
if(!empty($getMain)){
	$main_email = $getMain["main_email"];
	$main_facebook = $getMain["main_facebook"];
	$main_instagram = $getMain["main_instagram"];
}

if($type=='small'){?>

<a href="mailto:<?php echo $main_email;?>"><i class="fa fa-envelope icons"></i> <?php echo $main_email;?></a>
<a href="http://www.facebook.com/<?php echo $main_facebook;?>"><i class="fa fa-facebook-square icons"></i> www.facebook.com/<?php echo $main_facebook;?></a>
<a href="http://instagram.com/<?php echo $main_instagram;?>"><i class="fa fa-instagram icons"></i> @<?php echo $main_instagram;?></a>

<?php }else{?>

<a href="mailto:<?php echo $main_email;?>"><i class="fa fa-envelope icons"></i></a>
<a href="http://www.facebook.com/<?php echo $main_facebook;?>"><i class="fa fa-facebook-square icons"></i></a>
<a href="http://instagram.com/<?php echo $main_instagram;?>"><i class="fa fa-instagram icons"></i></a>

<?php }?>