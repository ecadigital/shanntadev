<?php 
$module = $this->request->getModuleName();
$action = $this->request->getActionName();
?>

<div class="tab bold tc white">Main Menu<div class="shadow"></div></div>
<div id="micro_accordion">
    <div class="micro">
    	<?php 
		if($module == ''){
			echo '<h5>Home<div class="dot"></div></h5>';
		}else{
    		echo '<a href="'.DIR_ROOT.'"><h4>Home<div class="dot"></div></h4></a>';
		}
		?>
    </div>
    <div class="micro">
		<?php 
		if($module == 'aboutus'){
			echo '<h5>About Us<div class="dot"></div></h5>';
		}else{
    		echo '<a href="'.DIR_ROOT.'aboutus"><h4>About Us<div class="dot"></div></h4></a>';
		}
		?>
    </div>
    <div class="micro">
		<?php 
		if($module == 'product'){
			echo '<a href="'.DIR_ROOT.'product"><h5>Products<div class="dot"></div></h5></a>';
		}else{
    		echo '<a href="'.DIR_ROOT.'product"><h4>Products<div class="dot"></div></h4></a>';
		}
		?>
    </div>
    <div class="micro">
		<?php 
		if($module == 'order'){
			echo '<h5>Product Order<div class="dot"></div></h5>';
		}else{
    		echo '<a href="'.DIR_ROOT.'orders/frontend/index"><h4>Product Order<div class="dot"></div></h4></a>';
		}
		?>
    </div>
    <div class="micro">
		<?php 
		if($module == 'news'){
			echo '<h5>News Update<div class="dot"></div></h5>';
		}else{
    		echo '<a href="'.DIR_ROOT.'news"><h4>News Update<div class="dot"></div></h4></a>';
		}
		?>
    </div>
    <div class="micro">
		<?php 
		if($module == 'service'){
			echo '<h5>Service<div class="dot"></div></h5>';
		}else{
    		echo '<a href="'.DIR_ROOT.'service"><h4>Service<div class="dot"></div></h4></a>';
		}
		?>
    </div>
    <div class="micro">
		<?php 
		if($module == 'promotion'){
			echo '<h5>Promotion<div class="dot"></div></h5>';
		}else{
    		echo '<a href="'.DIR_ROOT.'promotion"><h4>Promotion<div class="dot"></div></h4></a>';
		}
		?>
    </div>
    <div class="micro">
		<?php 
		if($module == 'contactus'){
			echo '<h5>Contact Us<div class="dot"></div></h5>';
		}else{
    		echo '<a href="'.DIR_ROOT.'contactus"><h4>Contact Us<div class="dot"></div></h4></a>';
		}
		?>
    </div>
</div>

<div class="clearfix"></div>
<script>
$(function(){
	$('#micro_accordion').microAccordion({openSingle: true,});
});
</script>