<a class="tOptions" title="Options" href="<?php echo DIR_ROOT;?>admin/users/addGroup<?php echo $param;?>"><span class="icol-create"></span><?php echo lang('web_add')?></a>
<div class="widget" style="margin-top: 4px;">
	<table cellpadding="0" cellspacing="0" border="0" width="100%" class="tDefault dTable">
		<thead>
			<tr>
				<th width="15%" align="center">No.</th>
				<th width="60%">หมวดหมู่สมาชิก</th>
				<th align="center">Tool</th>
			</tr>
		</thead>
		<?php if(!empty($listGroupUser)){$i=1;foreach($listGroupUser as $list){;?>
		<tr>
			<td align="center"><?php echo $i++;?></td>
			<td>
				<?php echo $list['admin_group_desc']?>
			</td>
			<td align="center">
				<a class="tablectrl_medium bDefault tipS" title="edit" href="javascript:void(0);" onclick="loadAjax('<?php echo DIR_ROOT?>admin/users/editGroup/id/<?php echo $list['admin_group_id'].$param;?>','#','')"><span class="iconb" data-icon="&#xe1db;"></span></a>
				<a class="tablectrl_medium bDefault tipS" title="delete" href="javascript:void(0);" onclick="myConfirm('admin/users/chk_bfdelete/group_id/<?php echo $list['admin_group_id']?>','loadAjax(\'<?php echo DIR_ROOT?>admin/users/deleteGroup/id/<?php echo $list['admin_group_id']?>\',\'\',\'loadAjax(\\\'<?php echo DIR_ROOT?>admin/users/group_index\\\',\\\'#\\\',\\\'\\\')\')')"><span class="iconb" data-icon="&#xe05c;"></span></a>
			</td>
		</tr>
		<?php }}else{?>
		<tr><td colspan="3" align="center"><?php echo "ไม่มีข้อมูล";?></td></tr>
		<?php }?>
	</table>
</div>