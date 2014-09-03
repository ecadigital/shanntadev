<link rel="stylesheet" type="text/css" href="<?php echo DIR_PUBLIC ?>css/ui_custom.css" charset="utf-8" />
<h3><?php echo lang('member_ii');?></h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index">หน้าแรก</a>&nbsp;&nbsp;>&nbsp;&nbsp;
    <a href="<?php echo DIR_ROOT?>member/backend/index"><?php echo lang('member_ii');?></a>&nbsp;&nbsp;>&nbsp;&nbsp;
    ข้อมูลแต้มสะสม<?php echo ($member_id==""||$member_id==0) ? '' : 'ของ '.$listEditMember['member_first_name'].' '.$listEditMember['member_last_name'];?>
</div>
<div class="clearfix formRow">
	<?php 
        echo $this->bflibs->mkSelect('perPage','#boxContent',$targetpage,$perPage);
        //echo $this->bflibs->mkSelect('searchData','#boxContent',$targetpage);
        //echo $this->bflibs->mkSelect('pointType','#boxContent',$targetpage);
    ?>
    <p style="float:left; margin-left:40px;">วันที่ : 
    <input type="text" id="beg_boxContent" name="beg_boxContent" style="width:100px;" value="<?php echo $beg;?>">&nbsp;&nbsp;-&nbsp;&nbsp;
    <input type="text" id="end_boxContent" name="end_boxContent" style="width:100px;" value="<?php echo $end;?>">&nbsp;&nbsp;
    <input type="button" class="button" value="ค้นหา" onclick="getBeg()"></input></p>
    <p style="float:right;">ค้นหา : <input type="text" id="searchData_boxContent" name="searchData_boxContent" style="width:200px;" value="<?php echo $q;?>" onchange="window.location='<?php echo DIR_ROOT;?>member/backend/index_point/id/<?php echo $member_id;?>/q/'+$('#searchData_boxContent').val()+'/limit/'+$('#perPage_boxContent').val()+'/page/1/beg/'+$('#beg_boxContent').val()+'/end/'+$('#end_boxContent').val()"></p>
</div>
<div class="clear"></div>
<div id="boxContent"></div>

<script>
$(document).ready(function (){
	
	beg = $('#beg_boxContent').val();
	Array_beg = beg.split('/');
	bd = Array_beg[0];
	bm = Array_beg[1];
	by = Array_beg[2];
	end = $('#end_boxContent').val();
	Array_end = end.split('/');
	ed = Array_end[0];
	em = Array_end[1];
	ey = Array_end[2];
	loadAjax('<?php echo DIR_ROOT.$targetpage?>/q/'+$('#searchData_boxContent').val()+'/limit/'+$('#perPage_boxContent').val()+'/page/1/bd/'+bd+'/bm/'+bm+'/by/'+by+'/ed/'+ed+'/em/'+em+'/ey/'+ey,'#boxContent','');
	
	$('#beg_boxContent, #end_boxContent').datepicker({
		dateFormat: "dd/mm/yy",
		dayNamesMin: ["อา", "จ", "อ", "พ", "พฤ", "ศ", "ส"], 
		monthNames: ["มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"],
		monthNamesShort: ["มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"],
		changeMonth: true,
		changeYear: true,
	});
	
});
function getBeg(){
	beg = $('#beg_boxContent').val();
	Array_beg = beg.split('/');
	bd = Array_beg[0];
	bm = Array_beg[1];
	by = Array_beg[2];
	end = $('#end_boxContent').val();
	Array_end = end.split('/');
	ed = Array_end[0];
	em = Array_end[1];
	ey = Array_end[2];
	window.location='<?php echo DIR_ROOT;?>member/backend/index_point/id/<?php echo $member_id;?>/q/'+$('#searchData_boxContent').val()+'/limit/'+$('#perPage_boxContent').val()+'/page/1/bd/'+bd+'/bm/'+bm+'/by/'+by+'/ed/'+ed+'/em/'+em+'/ey/'+ey
}
</script>