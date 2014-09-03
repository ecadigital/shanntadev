<?php $pagination = true;
$this->model = $this->load->model('faq/Faqmodel');
?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="data"> 
	<thead> 
		<tr> 
			<th align="center" width="50"><?php echo lang('web_no');?></th>
			<th><?php echo lang('faq_name');?></th>
			<th width="15%" align="center"><?php echo lang('faq_update');?></th>
            <th align="center" width="180"><?php echo lang('web_tool');?></th> 
		</tr> 
	</thead>
	<tbody>
	<?php 
	if(!empty($listFaq)){
		$no=($page-1)*$limit;
		foreach($listFaq as $list){
			$faq_id = $list["faq_id"];
			?>
		<tr>
			<td align="center"><?php echo ++$no;?></td>
			<td>
				<a href="<?php echo DIR_ROOT?>faq/backend/edit_faq/id/<?php echo $list['faq_id']; ?>" class="bluesky"><strong><?php echo $list['faq_question'];?></strong></a>
				<div><?php echo $this->bflibs->getSubString(strip_tags(html_entity_decode($list['faq_answer'])),700);?></div>
			</td>
            <td align="center"><?php echo $this->bflibs->timeString($list['faq_last_modified']);?></td>
			<td align="center">
				<?php echo $this->bflibs->web_tool("pin",$module,array('id'=>$faq_id,'status'=>$list['faq_pin']),'pin_faq','','list_faq',$target,$pagination);?>
				<?php echo $this->bflibs->web_tool("publish",$module,array('id'=>$faq_id,'status'=>$list['faq_publish']),'publish_faq','','list_faq',$target,$pagination);?>
				<?php echo $this->bflibs->web_tool("up",$module,array('id'=>$list['faq_id'],'seq'=>$list['faq_seq']),'up_faq',$param,'list_faq',$target);?>
				<?php echo $this->bflibs->web_tool("down",$module,array('id'=>$list['faq_id'],'seq'=>$list['faq_seq']),'down_faq',$param,'list_faq',$target);?>
				<?php echo $this->bflibs->web_tool("edit",$module,array('id'=>$list['faq_id']),'edit_faq');?>
				<?php echo $this->bflibs->web_tool("delete",$module,array('id'=>$list['faq_id']),'delete_faq',$param,'list_faq',$target);?>
				
				
			</td>
		</tr>
		<?php }}else{?>
		<tr><td colspan="4" align="center"><?php echo lang('web_no_data');?></td></tr>
		<?php }?>
	</tbody>
</table>
<div class="clearfix"></div>
<?php echo $page_description.$paginaion;?>