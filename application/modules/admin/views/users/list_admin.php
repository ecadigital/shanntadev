

<div class="widget" id="dyn" style="margin-top: 4px;">
	<table cellpadding="0" cellspacing="0" border="0" width="100%" class="dTable checkAll" id="Group_User">
		<thead>
			<tr>
				<th width="30" align="center"><input type="checkbox" id="checkAll" name="checkAll" class="check" /></th>
				<th width="12%" align="center">รูป</th>
				<th width="30%">ชื่อแอดมิน</th>
				<th width="30%">อีเมล์</th>
				<th>กลุ่ม</th>
				<th align="center" width="120">Tool</th>
			</tr>
		</thead>
		<?php if(!empty($listAllUser)){$i=1;foreach($listAllUser as $list){;?>
		<tr>
			<td><input type="checkbox" class="check" id="chk_<?php echo $list['admin_id'];?>" name="checkbox" value="<?php echo $list['admin_id'];?>"/></td>
			<td align="center">
				<?php if($list['admin_image'] !=""){?>
				<img src="<?php echo DIR_ROOT.$list['admin_image']?>" class="b_shadow" width="75"/>
				<?php }?>
			</td>
			<td>
				<?php echo $list['admin_user']?>
			</td>
			<td>
				<?php echo $list['admin_email']?>
			</td>
			<td>
				<?php echo $listGroupUserName[$list['admin_group_id']]?>
			</td>
			<td align="center">
				<a class="<?php echo ($list['admin_block'] == '1')?'tablectrl_medium bGreen tipS':'tablectrl_medium bRed tipS';?>" title="<?php echo ($list['admin_block'] == '1')?'normal':'lock';?>" href="javascript:void(0);" onclick="loadAjax('<?php echo DIR_ROOT?>admin/users/publish/id/<?php echo $list['admin_id']?>/status/<?php echo $list['admin_block']?>','','loadAjax(\'<?php echo DIR_ROOT?>admin/users/index\',\'#\',\'\')')"><span class="iconb" data-icon="<?php echo ($list['admin_block'] == '1')?'&#xe1c0;':'&#xe1be;';?>" style="padding: 0 2px;"></span></a>
				<a class="tablectrl_medium bDefault tipS" title="edit" href="<?php echo DIR_ROOT?>admin/users/edit/id/<?php echo $list['admin_id'].$param?>" ><span class="iconb" data-icon="&#xe1db;"></span></a>
				<a class="tablectrl_medium bDefault tipS" title="delete" href="javascript:void(0);" onclick="confirmDialog('do you want to delete ?','loadAjax(\'<?php echo DIR_ROOT?>admin/users/delete/id/<?php echo $list['admin_id']?>\',\'\',\'loadAjax(\\\'<?php echo DIR_ROOT?>admin/users/index\\\',\\\'#\\\',\\\'\\\')\')','<?php echo lang('web_ok');?>','<?php echo lang('web_cancel');?>')"><span class="iconb" data-icon="&#xe05c;"></span></a>
			</td>
		</tr>
		<?php }}?>
	</table>
<!--	<a onclick="deleteAll('<?php echo DIR_ROOT?>admin/users/delete','<?php echo DIR_ROOT?>admin/users/index','','');" href="javascript:void(0);">xxxx</a>-->
</div>
<script>
$(function(){
	var id = '#Group_User';
	$(id).dataTable({
		"bJQueryUI": false,
		"bAutoWidth": false,
		"iDisplayLength":2,
		"sPaginationType": "full_numbers",
		"sDom": '<"H"fl>t<"F"ip>',
		"aoColumns": [{ "bSortable": false },{ "bSortable": false },{ "bSortable": true },{ "bSortable": true },{ "bSortable": true },{ "bSortable": false }],
	});
	$(id+'_wrapper select').uniform();
	$(id+"_wrapper div.selector span").addClass('small');
});

function deleteAll(url_dalete, url_redirect,name,txt){
	
	name = (name == '')?'checkbox':name;
	txt = (txt == '')?'Do you want to delete select data ?':txt;
	var chkbox = getCheckboxByName(name);
	
	if(chkbox != -1){
		var data = "id="+chkbox;
		confirmDialog(txt,'loadAjaxPost(\''+url_dalete+'\',\'\',\''+data+'\',\'loadAjax(\\\''+url_redirect+'\\\',\\\'#\\\',\\\'\\\',\\\'\\\')\',\'\')','ok','cancel')
	}
}
</script>
