<?php $pagination = true;
$this->model = $this->load->model('lookbook/Lookbookmodel');
?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="data"> 
	<thead> 
		<tr> 
			<th align="center" width="50"><?php echo lang('web_no');?></th>
			<th>LOOKBOOK</th>
			<th width="15%" align="center">วันที่อัพเดต</th>
            <th align="center" width="180"><?php echo lang('web_tool');?></th> 
		</tr> 
	</thead>
	<tbody>
	<?php 
	if(!empty($listLookbook)){
		$no=($page-1)*$limit;
		foreach($listLookbook as $list){
			$lookbook_id = $list["lookbook_id"];
			$img_db = $list["lookbook_path"];
			$img_path = DIR_PUBLIC."images/noimage.png";
			if($img_db!=''){
				$path = "public/upload/lookbook/thumbnails/".basename($img_db);
				$dir_file = DIR_FILE.$path;
				if(file_exists($dir_file)){
					$img_path = DIR_ROOT.$path;
				}
			}
			?>
		<tr>
			<td align="center"><?php echo ++$no;?></td>
			<td>
				<img src="<?php echo $img_path?>" style="max-width:150px;" />
			</td>
            <td align="center"><?php echo $this->bflibs->timeString($list['lookbook_last_modified']);?></td>
			<td align="center">
				<?php echo $this->bflibs->web_tool("publish",$module,array('id'=>$lookbook_id,'status'=>$list['lookbook_publish']),'publish_lookbook','','list_lookbook',$target,$pagination);?>
				<?php echo $this->bflibs->web_tool("up",$module,array('id'=>$list['lookbook_id'],'seq'=>$list['lookbook_seq']),'up_lookbook',$param,'list_lookbook',$target);?>
				<?php echo $this->bflibs->web_tool("down",$module,array('id'=>$list['lookbook_id'],'seq'=>$list['lookbook_seq']),'down_lookbook',$param,'list_lookbook',$target);?>
				<?php echo $this->bflibs->web_tool("edit",$module,array('id'=>$list['lookbook_id']),'edit_lookbook');?>
				<?php echo $this->bflibs->web_tool("delete",$module,array('id'=>$list['lookbook_id']),'delete_lookbook',$param,'list_lookbook',$target);?>
				
				
			</td>
		</tr>
		<?php }}else{?>
		<tr><td colspan="4" align="center"><?php echo lang('web_no_data');?></td></tr>
		<?php }?>
	</tbody>
</table>
<div class="clearfix"></div>
<?php echo $page_description.$paginaion;?>