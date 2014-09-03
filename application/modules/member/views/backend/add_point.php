<?php if(isset($redirect)){ echo $redirect; }else{ ?>
<script type="text/javascript" src="<?php echo DIR_PUBLIC?>js/jquery.chosen.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo DIR_PUBLIC ?>css/chzn.css">
<link rel="stylesheet" type="text/css" href="<?php echo DIR_PUBLIC ?>css/ui_custom.css" charset="utf-8" />

<h3><?php echo lang('member_point_add');?></h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index">หน้าแรก</a>&nbsp;&nbsp;>&nbsp;&nbsp;
    <a href="<?php echo DIR_ROOT?>member/backend/index"><?php echo lang('member_ii');?></a>&nbsp;&nbsp;>&nbsp;&nbsp;
	<?php echo lang('member_point_add');?>
</div>

<div id="showWarning" style="height:40px;"></div>

<div class="fluid">
	<iframe frameborder="0" width="0" height="0" id="myIframe" name="myIframe"></iframe>
	<form class="formElement" method="post" id="member_form" name="member_formAdd" target="myIframe" action="<?php echo DIR_ROOT?>member/backend/add_point">
        <div class="widget">
            
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="member_id"><?php echo lang('member_ii');?></label>
                    <span class="required"></span>
                </div>
                <div class="grid3 searchDrop">
                    <select id="member_id" name="member_id" data-placeholder="<?php echo lang('sp_member_select');?>" class="select" style="width:350px;" tabindex="2">
                        <!--<option value=""></option> -->
                        <?php 
                        if(!empty($listMember)){
                            foreach ($listMember as $list){
                                echo '<option value="'.$list['member_id'].'">';								
								if($list['member_code']!='') echo '('.$list['member_code'].') ';
								echo $list['member_first_name'].' '.$list['member_last_name'].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
           	<div class="clear"></div>
            
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="member_point_type"><?php echo lang('member_point_type');?></label>
                    <span class="required"></span>
                </div>
                <div class="grid3" style="margin-top:5px;">
                    <div style="float:left;"><input type="radio" id="member_point_type[]" name="member_point_type" value="1" checked="checked"> เพิ่ม</div>
                    <div style="float:left; margin-left:20px;"><input type="radio" id="member_point_type[]" name="member_point_type" value="0"> ลด</div>
                </div>
            </div>
           	<div class="clear"></div>              
            
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="member_point_reason"><?php echo lang('member_point_reason');?></label>
                    <span class="required"></span>
                </div>
                <div class="grid6">
                    <input type="text" id="member_point_reason" name="member_point_reason" placeholder="<?php echo lang('member_point_reason');?>" style="width:250px;">
                </div>
            </div>
           	<div class="clear"></div>         
            
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="member_point_val"><?php echo lang('member_point_val');?></label>
                    <span class="required"></span>
                </div>
                <div class="grid6">
                    <input type="text" id="member_point_val" name="member_point_val" placeholder="0" onkeypress="return chkNumberInteger(event)" style="width:60px;">
                </div>
            </div>
           	<div class="clear"></div>
            
            <div class="formRow">
                <input type="hidden" id="captcha" name="captcha" value=""></input>
                <input type="submit" class="button" value="<?php echo lang('web_save');?>"></input>
            </div>
        </div>
	</form>
</div>


<h4>รายการเพิ่มเติมคะแนนล่าสุด 10 อันดับ</h4>

    <p style="float:left; margin-left:40px;">วันที่ : 
    <input type="text" id="beg_boxContent" name="beg_boxContent" style="width:100px;" value="<?php echo $beg;?>">&nbsp;&nbsp;-&nbsp;&nbsp;
    <input type="text" id="end_boxContent" name="end_boxContent" style="width:100px;" value="<?php echo $end;?>">&nbsp;&nbsp;
    <input type="button" class="button" value="ค้นหา" onclick="getBeg()"></input></p>
    
    <table cellpadding="0" cellspacing="0" border="0" width="100%" class="data"> 
        <thead> 
            <tr> 
                <th align="center" width="50"><?php echo lang('web_no');?></th>
                <th align="center" width="20%"><?php echo lang('member_name');?></th>
                <th align="center" width="20%"><?php echo lang('member_point_val');?></th>
                <th align="center"><?php echo lang('member_point_reason');?></th>
                <th align="center" width="15%"><?php echo lang('member_point_date');?></th>
                <th align="center" width="100"><?php echo lang('web_tool');?></th>
            </tr> 
        </thead>
        <tbody>
        <?php 
        if(!empty($listPoint)){
            $no=0;
            foreach($listPoint as $list){
                $member_point_id = $list["member_point_id"];
                ?>
            <tr>
                <td align="center"><?php echo ++$no;?></td>
                <td><?php echo $list["member_first_name"].' '.$list["member_last_name"];?></td>
                <td><?php echo ($list['member_point_type']==1) ? 'ได้รับ' : 'ลด';?> <?php echo $list['member_point_val'];?> แต้ม</td>
                <td><?php echo $list['member_point_reason'];?></td>
                <td align="center"><?php echo $this->bflibs->timeString($list['member_point_date']);?></td>
                <td align="center"><a href="<?php echo DIR_ROOT?>member/backend/index_point/id/<?php echo $list['member_id'];?>">ดูคะแนนทั้งหมด</a></td>
            </tr>
            <?php }}else{?>
            <tr><td colspan="6" align="center"><?php echo lang('web_no_data');?></td></tr>
            <?php }?>
        </tbody>
    </table>
<script>
$(document).ready(function(){
	
	$("#member_id").chosen(); 
		
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
	
	$('#beg_boxContent, #end_boxContent').datepicker({
		dateFormat: "dd/mm/yy",
		dayNamesMin: ["อา", "จ", "อ", "พ", "พฤ", "ศ", "ส"], 
		monthNames: ["มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"],
		monthNamesShort: ["มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"],
		changeMonth: true,
		changeYear: true,
	});
	
	$("#member_form").validate({
		rules: {
			'member_id' : {
				required: true,
			},
			'member_point_reason' : {
				required: true,
			},
			'member_point_val' : {
				required: true,
				number: true
			},
		},
	   	submitHandler: function(form) {
			document.member_formAdd.submit();
	 	}
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
	window.location='<?php echo DIR_ROOT;?>member/backend/index_point/id//q//limit/20/page/1/bd/'+bd+'/bm/'+bm+'/by/'+by+'/ed/'+ed+'/em/'+em+'/ey/'+ey
}
</script>
<?php }?>