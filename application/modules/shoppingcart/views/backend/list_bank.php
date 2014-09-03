<?php $pagination = true;
?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="data"> 
	<thead> 
		<tr> 
			<th align="center" width="5%"><?php echo lang('web_no');?></th>
			<th align="center" width="20%"><?php echo lang('sp_bank_name');?></th>
            <th align="center" width="15%"><?php echo lang('sp_bank_branch');?></th> 
            <th align="center"><?php echo lang('sp_bank_account');?></th>
            <th align="center" width="12%"><?php echo lang('sp_bank_no');?></th>
            <th align="center" width="12%"><?php echo lang('sp_bank_update');?></th>
            <th align="center" width="150"><?php echo lang('web_tool');?></th>
		</tr> 
	</thead>
	<tbody>
	<?php 
	if(!empty($listBank)){
		$no=($page-1)*$limit;
		foreach($listBank as $list){
			$bank_id = $list["bank_id"];
			$img_db = $list["bank_image"];
			$img_path = DIR_PUBLIC."layout/default/images/empty.png";
			if($img_db!=''){
				$path = "public/upload/bank/thumbnails/".basename($img_db);
				$dir_file = DIR_FILE.$path;
				if(file_exists($dir_file)){
					$img_path = DIR_ROOT.$path;
				}
			}
			?>
		<tr>
			<td align="center"><?php echo ++$no;?></td>
			<td><img src="<?php echo $img_path?>" style="width:25px; height:25px;" /> <a href="<?php echo DIR_ROOT?>shoppingcart/backend/edit_bank/id/<?php echo $list['bank_id'];?>"><?php echo $list['bank_name'];?></a></td>
			<td align="center"><?php echo $list['bank_branch'];?></td>
			<td align="center"><?php echo $list['bank_account'];?></td>
			<td align="center"><?php echo $list['bank_no'];?></td>
			<td align="center"><?php echo $this->bflibs->timeString($list['bank_last_modified']);?></td>
			<td align="center">
				<?php //echo $this->bflibs->web_tool("pin",$module,array('id'=>$bank_id,'status'=>$list['bank_pin']),'pin_bank','','list_bank',$target,$pagination);?>
				<?php echo $this->bflibs->web_tool("publish",$module,array('id'=>$bank_id,'status'=>$list['bank_publish']),'publish_bank','','list_bank',$target,$pagination);?>
				<?php echo $this->bflibs->web_tool("up",$module,array('id'=>$list['bank_id'],'seq'=>$list['bank_seq']),'up_bank',$param,'list_bank',$target);?>
				<?php echo $this->bflibs->web_tool("down",$module,array('id'=>$list['bank_id'],'seq'=>$list['bank_seq']),'down_bank',$param,'list_bank',$target);?>
				<?php echo $this->bflibs->web_tool("edit",$module,array('id'=>$list['bank_id']),'edit_bank');?>
				<?php echo $this->bflibs->web_tool("delete",$module,array('id'=>$list['bank_id']),'delete_bank',$param,'list_bank',$target);?>
            </td>
		</tr>
	<?php }}else{?>
		<tr><td colspan="6" align="center"><?php echo lang('web_no_data');?></td></tr>
	<?php }?>
	</tbody>				  
</table>
<?php echo $page_description.$paginaion;?>