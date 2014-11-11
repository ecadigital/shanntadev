<script type="text/javascript" src="<?php echo DIR_PUBLIC;?>js/Chart.js"></script>
<?php 
$this->modelMem = $this->load->model('member/Membermodel');
$this->modelCart = $this->load->model('shoppingcart/Shoppingcartmodel');

$Array_member = array();
$i=0;
for($m=1;$m<=12;$m++){
	$num_member = $this->modelMem->countMemberByMonth($year.'-'.str_pad($m,2,0,STR_PAD_LEFT));
	$Array_member[$i] = $num_member;
	$i++;
}

$Array_order1 = array();
$Array_order2 = array();
$i=0;
for($m=1;$m<=12;$m++){
	list($num_member1,$num_member2) = $this->modelCart->countOrderByMonth($year.'-'.str_pad($m,2,0,STR_PAD_LEFT));
	$Array_order1[$i] = $num_member1;
	$Array_order2[$i] = $num_member2;
	$i++;
}
?>
<div style="padding-bottom:10px;">
	<strong>เลือกปี </strong><select id="year" name="year" onchange="changeYear()">
		<?php 
		for($y=date("Y");$y>=2013;$y--){
			echo '<option value="'.$y.'" '; if($y==$year) echo 'selected="selected"'; echo '>'.$y.'</option>';
		}
		?>
	</select>
</div>
<div class="fluid" style="margin-top:10px;">
	<div class="widget">
		<div class="formRow">
			<div class="grid5" style="text-align:center;">
				<strong>กราฟแท่งแสดงจำนวนสมาชิกที่ลงทะเบียนกับเว็บไซต์ ประจำปี <?php echo $year;?></strong>
				<canvas id="canvas" height="450" width="600"></canvas>
			</div>
			<div class="grid1" style="border-right:3px solid #ccc; height:430px;">&nbsp;</div>
			<div class="grid1">&nbsp;</div>
			<div class="grid5" style="text-align:center;">
				<strong>กราฟแท่งแสดงจำนวนสินค้าที่ขายได้ แยกตามประเภทลูกค้า ประจำปี <?php echo $year;?></strong>
				<div style="float:right; margin-top:10px;text-align:left;">
					<div>
						<div style="float:left; width:10px; height:10px; background-color:rgba(220,220,220,0.5); border:rgba(220,220,220,0.8) solid 2px;"></div>&nbsp;&nbsp;
						<label> ถูกซื้อโดยสมาชิก</label> 
					</div>
					<div style="margin-top:5px;">
						<div style="float:left; width:10px; height:10px; background-color:rgba(151,187,205,0.5); border:rgba(151,187,205,0.8) solid 2px;"></div> &nbsp;&nbsp;
						<label> ถูกซื้อโดยลูกค้าทั่วไป</label> 
					</div>
				</div>
				<canvas id="canvas2" height="450" width="600"></canvas>
			</div>
		</div>
	</div>
</div>


<script>
//var randomScalingFactor = function(){ return Math.round(Math.random()*100)};

var barChartData = {
	labels : ["ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค."],
	datasets : [
		{
			fillColor : "rgba(220,220,220,0.5)",
			strokeColor : "rgba(220,220,220,0.8)",
			highlightFill: "rgba(220,220,220,0.75)",
			highlightStroke: "rgba(220,220,220,1)",
			data : <?php echo json_encode($Array_member);?>//$.parseJSON(<?php echo json_encode($Array_member);?>);
		}
	]

}

var barChartData2 = {
	labels : ["ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค."],
	datasets : [
		{
			fillColor : "rgba(220,220,220,0.5)",
			strokeColor : "rgba(220,220,220,0.8)",
			highlightFill: "rgba(220,220,220,0.75)",
			highlightStroke: "rgba(220,220,220,1)",
			data : <?php echo json_encode($Array_order1);?>
		},
		{
			fillColor : "rgba(151,187,205,0.5)",
			strokeColor : "rgba(151,187,205,0.8)",
			highlightFill : "rgba(151,187,205,0.75)",
			highlightStroke : "rgba(151,187,205,1)",
			data : <?php echo json_encode($Array_order2);?>
		}
	]

}
window.onload = function(){
	var ctx = document.getElementById("canvas").getContext("2d");
	window.myBar = new Chart(ctx).Bar(barChartData, {
		responsive : true,
		showTooltips: false,
	});
	
	var ctx2 = document.getElementById("canvas2").getContext("2d");
	window.myBar = new Chart(ctx2).Bar(barChartData2, {
		responsive : true,
		showTooltips: false,
	});
}

function changeYear(){
	year = $('#year').val();
	window.location='<?php echo DIR_ROOT;?>main/backend/dashboard/year/'+year;
}
</script>