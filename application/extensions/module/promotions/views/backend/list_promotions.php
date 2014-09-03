<?php $target = '#boxContent';$pagination = true;?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="table_content"> 
	<thead> 
		<tr> 
			<th align="center" width="10%"><?php echo lang('web_no');?></th>
			<th><?php echo lang('promotions_name');?></th>
			<th width="15%"><?php echo lang('promotions_create_date');?></th>
            <th align="center" width="155"><?php echo lang('web_tool');?></th> 
		</tr> 
	</thead>
	<tbody>
	<?php if(!empty($listPromotions)){
		$no=($page-1)*$limit;
		foreach($listPromotions as $list){;?>
		<tr>
			<td align="center"><?php echo ++$no;?></td>
			<td>
				<a class="bluesky" href="javascript:void(0);" onclick="loadAjax('<?php echo DIR_ROOT?>promotions/backend/edit_promotions/id/<?php echo $list['promotions_id']?>','#','')"><?php echo $list['promotions_name']?></a>
			</td>
			<td>
				<?php echo $this->bflibs->timeString($list['promotions_create_date']);?>
			</td>
			<td>
				<?php echo $this->bflibs->web_tool("publish",$this->request->getModuleName(),array('id'=>$list['promotions_id'],'status'=>$list['promotions_publish']),'publish_promotions','','list_promotions',$target,$pagination);?>
				<?php echo $this->bflibs->web_tool("up",$this->request->getModuleName(),array('id'=>$list['promotions_id'],'seq'=>$list['promotions_seq']),'up_promotions','','list_promotions',$target,$pagination);?>
				<?php echo $this->bflibs->web_tool("down",$this->request->getModuleName(),array('id'=>$list['promotions_id'],'seq'=>$list['promotions_seq']),'down_promotions','','list_promotions',$target,$pagination);?>
				<?php echo $this->bflibs->web_tool("edit",$this->request->getModuleName(),array('id'=>$list['promotions_id']),'edit_promotions','','list_promotions');?>
				<?php echo $this->bflibs->web_tool("delete",$this->request->getModuleName(),array('id'=>$list['promotions_id']),'delete_promotions','','list_promotions',$target,$pagination);?>
			</td>
		</tr>
		<?php }}else{?>
		<tr><td colspan="5" align="center"><?php echo lang('web_no_data');?></td></tr>
		<?php }?>
	</tbody>
</table>
<div class="clearfix"></div>
<?php echo $page_description.$paginaion;?>