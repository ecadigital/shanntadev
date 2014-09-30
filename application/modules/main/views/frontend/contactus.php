<header>
	<h1><?php echo lang('web_contactus');?></h1>
	<!-- <hr> -->
	<div class="headImage">
		<img src="img/contactus-h.png" alt="">
	</div>
</header>
<div class="innerContent">
	<div class="small-12 medium-7 columns">
		<?php 
		if(empty($getMain)){
			echo '<div style="text-align:center; margin:100px;">'.lang('nodata').'</div>';
		}else{
			$main_contact = $getMain["main_contact"];
			echo html_entity_decode($main_contact);
		}?>
		<img src="img/dummy-map.png" alt="">
	</div>
	<div class="small-12 medium-5 column">
		<form id="contactus">
			<input type="text" placeholder="Name">
			<input type="text" placeholder="Email">
			<input type="text" placeholder="Tel">
			<textarea rows="5">Massage</textarea>
			<div class="ta-right">
				<input type="submit" value="Send Massage >" class="button">
			</div>
		</form>
	</div>
	<div class="small-12 columns">
		<hr>
	</div>
	<div class="small-12 columns">
		<h2 style="color: #D8D2D6;">STORE LOCATION</h2>
	</div>
	<div class="row">
		<div class="small-3 medium-1 columns">
			<div class="map-marker">
				<div>
					<img src="img/assets/marker.png" alt="">
					<span>A</span>
				</div>
			</div>
		</div>
		<div class="small-9 medium-6 column">
			<h3>SHANNTA JEWELRY STORE A</h3>
			<p>
				Central Festival Pattaya43 miles1 Floor,33/98 Moo 9,Pattaya Beach Road,
				Banglamung, Pattaya Chonburi, 20260 Phone : +622-804-3371
			</p>
			<p>
				<b>INFOREMATIONSHOP :</b> <br>
				it all started nearly 30 years ago. Back in 1982 a jeweller's shop that would one day
				become by Danish goldsmith Per Enevold sen and his wife Winnie. <a href="#">View map</a>
			</p>
		</div>
		<div class="small-12 medium-5 column">
			<img src="img/dummy-map-2.png" alt="">
		</div>
	</div><!-- .row -->
	<hr class="smallest">
	<div class="row">
		<div class="small-3 medium-1 columns">
			<div class="map-marker">
				<div>
					<img src="img/assets/marker.png" alt="">
					<span>B</span>
				</div>
			</div>
		</div>
		<div class="small-9 medium-6 column">
			<h3>SHANNTA JEWELRY STORE B</h3>
			<p>
				Central Festival Pattaya43 miles1 Floor,33/98 Moo 9,Pattaya Beach Road,
				Banglamung, Pattaya Chonburi, 20260 Phone : +622-804-3371
			</p>
			<p>
				<b>INFOREMATIONSHOP :</b> <br>
				it all started nearly 30 years ago. Back in 1982 a jeweller's shop that would one day
				become by Danish goldsmith Per Enevold sen and his wife Winnie. <a href="#">View map</a>
			</p>
		</div>
		<div class="small-12 medium-5 column">
			<img src="img/dummy-map-3.png" alt="">
		</div>
	</div><!-- .row -->
	<hr class="smallest">
	<div class="row">
		<div class="small-3 medium-1 columns">
			<div class="map-marker">
				<div>
					<img src="img/assets/marker.png" alt="">
					<span>C</span>
				</div>
			</div>
		</div>
		<div class="small-9 medium-6 column">
			<h3>SHANNTA JEWELRY STORE C</h3>
			<p>
				Central Festival Pattaya43 miles1 Floor,33/98 Moo 9,Pattaya Beach Road,
				Banglamung, Pattaya Chonburi, 20260 Phone : +622-804-3371
			</p>
			<p>
				<b>INFOREMATIONSHOP :</b> <br>
				it all started nearly 30 years ago. Back in 1982 a jeweller's shop that would one day
				become by Danish goldsmith Per Enevold sen and his wife Winnie. <a href="#">View map</a>
			</p>
		</div>
		<div class="small-12 medium-5 column">
			<img src="img/dummy-map-4.png" alt="">
		</div>
	</div><!-- .row -->
</div>