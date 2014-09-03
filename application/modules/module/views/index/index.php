<div class="box_shadow">
	<div class="fr sep_to" id="content_actions">
		<button class="btn btn_blue sep_bo" onclick="loadAjax('<?php echo DIR_ROOT?>module/index/add','#','')"><span><?php echo lang('web_new');?></span></button>
	</div>
	<table cellpadding="0" cellspacing="0" border="0" width="100%" class="table_content">
		<tr>
			<th width="10%" align="center"><?php echo lang('web_no');?></th>
			<th width="20%" align="center"><?php echo lang('web_module_name');?></th>
			<th width="20%" align="center"><?php echo lang('web_db');?></th>
			<th ><?php echo lang('web_desc');?></th>
			<th align="center" width="100"><?php echo lang('web_tool');?></th>
		</tr>
		<?php if(!empty($listModule)){$i=1;foreach($listModule as $list){;?>
		<tr>
			<td align="center"><?php echo $i++;?></td>
			<td>
				<?php echo $list['module_name']?>
			</td>
			<td>
				<?php echo $list['module_db']?>
			</td>
			<td>
				<?php echo $list['module_desc']?>
			</td>
			<td align="center">
<!--				<a class="edit" title="edit" href="javascript:void(0);" onclick="loadAjax('<?php echo DIR_ROOT?>module/index/edit/id/<?php echo $list['module_id']?>','#','')">edit</a>-->
				<a class="delete" title="<?php echo lang('web_delete');?>" href="javascript:void(0);" onclick="confirmDialog('<?php echo lang('web_cf_delete_module');?>','loadAjax(\'<?php echo DIR_ROOT?>module/index/delete/id/<?php echo $list['module_id']?>\',\'\',\'loadAjax(\\\'<?php echo DIR_ROOT?>module/index/index\\\',\\\'#\\\',\\\'\\\')\')','<?php echo lang('web_ok');?>','<?php echo lang('web_cancel');?>')"><?php echo lang('web_delete');?></a>
			</td>
		</tr>
		<?php }}else{?>
		<tr><td colspan="5" align="center"><?php echo lang('web_no_data');?></td></tr>
		<?php }?>
	</table>
</div>