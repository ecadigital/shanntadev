<div class="box_shadow">
	<div class="fr sep_to" id="content_actions">
		<button class="btn btn_blue sep_bo" onclick="loadAjax('<?php echo DIR_ROOT?>language/index/add','#','')"><span><?php echo lang('web_add');?></span></button>
	</div>
	<table cellpadding="0" cellspacing="0" border="0" width="100%" class="table_content">
		<tr>
			<th width="10%" align="center"><?php echo lang('web_no');?></th>
			<th width="20%" align="center"><?php echo lang('web_lang');?></th>
			<th width="20%" align="center"><?php echo lang('web_alias');?></th>
			<th><?php echo lang('web_desc');?></th>
			<th width="5%" align="center"><?php echo lang('web_admin');?></th>
			<th width="5%" align="center"><?php echo lang('web_front');?></th>
			<th align="center" width="160"><?php echo lang('web_tool');?></th>
		</tr>
		<?php if(!empty($listLanguage)){$i=1;foreach($listLanguage as $list){;?>
		<tr>
			<td align="center"><?php echo $i++;?></td>
			<td>
				<?php echo $list['language_name']?>
				<?php if($list['language_icon'] != ''){?>
					<img src="<?php echo DIR_ROOT.$list['language_icon']?>" />
				<?php }?>
			</td>
			<td>
				<?php echo $list['language_alias']?>
			</td>
			<td>
				<?php echo $list['language_desc']?>
			</td>
			<td align="center">
				<?php $srcImg = ($list['language_admin'] == '1')?'images/icons/star-on.png':'images/icons/star-off.png'; ?>
				<a class="star" href="javascript:void(0);" data-default='<?php echo $list['language_admin']?>' onclick="loadAjax('<?php echo DIR_ROOT?>language/index/defaultadmin/id/<?php echo $list['language_id']?>','','loadAjax(\'<?php echo DIR_ROOT?>language/index/index\',\'#\',\'\')')"><img src="<?php echo DIR_PUBLIC.$srcImg?>"/></a>
			</td>
			<td align="center">
				<?php $srcImg = ($list['language_front'] == '1')?'images/icons/star-on.png':'images/icons/star-off.png'; ?>
				<a class="star" href="javascript:void(0);" data-default='<?php echo $list['language_front']?>' onclick="loadAjax('<?php echo DIR_ROOT?>language/index/defaultfront/id/<?php echo $list['language_id']?>','','loadAjax(\'<?php echo DIR_ROOT?>language/index/index\',\'#\',\'\')')"><img src="<?php echo DIR_PUBLIC.$srcImg?>"/></a>
			</td>
			<td align="center">
				<a class="up" title="<?php echo lang('web_up');?>" href="javascript:void(0);" onclick="loadAjax('<?php echo DIR_ROOT?>language/index/up/id/<?php echo $list['language_id']?>/seq/<?php echo $list['language_seq']?>','','loadAjax(\'<?php echo DIR_ROOT?>language/index/index\',\'#\',\'\')')"><?php echo lang('web_up');?></a>
				<a class="down" title="<?php echo lang('web_down');?>" href="javascript:void(0);" onclick="loadAjax('<?php echo DIR_ROOT?>language/index/down/id/<?php echo $list['language_id']?>/seq/<?php echo $list['language_seq']?>','','loadAjax(\'<?php echo DIR_ROOT?>language/index/index\',\'#\',\'\')')"><?php echo lang('web_down');?></a>
				<a class="edit" title="<?php echo lang('web_edit');?>" href="javascript:void(0);" onclick="loadAjax('<?php echo DIR_ROOT?>language/index/edit/id/<?php echo $list['language_id']?>','#','')"><?php echo lang('web_edit');?></a>
				<a class="delete" title="<?php echo lang('web_delete');?>" href="javascript:void(0);" onclick="confirmDialog('<?php echo lang('web_cf_delete');?>','loadAjax(\'<?php echo DIR_ROOT?>language/index/delete/id/<?php echo $list['language_id']?>/default/<?php echo $list['language_admin']?>\',\'\',\'loadAjax(\\\'<?php echo DIR_ROOT?>language/index/index\\\',\\\'#\\\',\\\'\\\')\')','<?php echo lang('web_ok');?>','<?php echo lang('web_cancel');?>')"><?php echo lang('web_delete');?></a>
			</td>
		</tr>
		<?php }}else{?>
		<tr><td colspan="7" align="center"><?php echo lang('web_no_data');?></td></tr>
		<?php }?>
	</table>
</div>
<script>
/*  STAR
----------------------------------------------------------------------------------------------- */	

$("a.star").hover(function(event){

	$(this).find('img').attr({"src":"<?php echo DIR_PUBLIC.'images/icons/star-on.png'?>"});

},function(event){
	var df = $(this).attr('data-default');
	if(df != '1')
	{
		$(this).find('img').attr({"src":"<?php echo DIR_PUBLIC.'images/icons/star-off.png'?>"});
	}
});
function changImage(obj)
{
	$(obj).find('img').attr({"src":"<?php echo DIR_PUBLIC.'images/icons/star-on.png'?>"});
}
</script>