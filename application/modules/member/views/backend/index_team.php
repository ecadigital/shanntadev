<h3>ข้อมูลลูกค้าของ <?php echo $member_name;?></h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index">Home</a>
    &nbsp;&nbsp;>&nbsp;&nbsp;
    <a href="<?php echo DIR_ROOT?>member/backend/index"><?php echo lang('member_ii');?></a>
    &nbsp;&nbsp;>&nbsp;&nbsp;
    ข้อมูลลูกค้าของ <?php echo $member_name;?>
</div>
<div class="clearfix formRow">
	<?php 
        echo $this->bflibs->mkSelect('perPage','#boxContent',$targetpage,$perPage);
        echo $this->bflibs->mkSelect('searchData','#boxContent',$targetpage);
    ?>
</div>
<div style="float:left; margin-top:20px; margin-left:-140px;"><a href="<?php echo DIR_ROOT?>member/backend/add_team/id/<?php echo $member_id; ?>" class="bluesky"><strong>เพิ่มข้อมูลลูกค้า</strong></a></div>
<div class="clear"></div>
<div id="boxContent"></div>

<script>
$(document).ready(function (){
	loadAjax('<?php echo DIR_ROOT.$targetpage?>','#boxContent','');
});

function delTeam(id){
	if(confirm("ยืนยันการลบข้อมูลสมาชิก ?")){
		$.ajax({ 
			url: "<?php echo DIR_ROOT;?>member/frontend/delete_team/id/"+id,
			success: function(response){
				$("#row_"+id).hide();
			}
		});
	}
}
function editTeam(id){
	name = $('#name_'+id).val();
	$.ajax({ 
		url: "<?php echo DIR_ROOT;?>member/frontend/edit_team/id/"+id+"/name/"+name,
		success: function(response){
			$('#boxTeam_'+id).html(name).show();
			$('#boxEditTeam_'+id).hide();
		}
	});
}
function showEditTeam(id){
	$('#boxTeam_'+id).hide();
	$('#boxEditTeam_'+id).show();
}
</script>