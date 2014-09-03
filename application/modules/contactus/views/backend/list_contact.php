<?php $pagination = true;?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="data"> 
	<thead> 
		<tr> 
			<th align="center" width="50"><?php echo lang('web_no');?></th>
			<th align="center" width="10%"><?php echo lang('web_name');?></th>
			<th align="center" width="15%"><?php echo lang('web_email');?></th>
			<th align="center" width="10%"><?php echo lang('web_tel');?></th>
			<th align="center"><?php echo lang('web_message');?></th>  
            <th align="center" width="130"><?php echo lang('web_date');?></th> 
            <th align="center" width="60"><?php echo lang('web_tool');?></th> 
		</tr>
	</thead>
	<tbody><?php 
	if(!empty($listContact)){
		$no=($page-1)*$limit;
		foreach($listContact as $list){;?>
		<tr>
			<td align="center"><?php echo ++$no;?></td>
			<td>
				<?php echo $list['contactus_name'];?>
			</td>
			<td>
				<?php echo $list['contactus_email'];?>
			</td>
			<td>
				<?php echo $list['contactus_tel'];?>
			</td>
			<td>
				<div><strong><?php echo $list['contactus_topic'];?></strong></div>
				<div><?php echo nl2br($list['contactus_detail']);?></div>
			</td>
			<td>
				<?php echo $this->bflibs->timeString($list['contactus_date'])?>
			</td>
			<td align="center">
				<?php echo $this->bflibs->web_tool("delete",$module,array('id'=>$list['contactus_id']),'delete_contact',$param,'list_contact',$target);?>
			</td>
		</tr>
	<?php }}else{?>
		<tr><td colspan="8" align="center"><?php echo lang('web_no_data');?></td></tr>
	<?php }?>
	</tbody>				  
</table>
<?php echo $page_description.$paginaion;?>