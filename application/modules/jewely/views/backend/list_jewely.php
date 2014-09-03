<?php $pagination = true;
$this->model = $this->load->model('jewely/Jewelymodel');
?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="data"> 
	<thead> 
		<tr> 
			<th align="center" width="50"><?php echo lang('web_no');?></th>
			<th align="center" width="7%"><?php echo lang('web_image');?></th>
			<th>หัวข้อ</th>
			<th width="15%" align="center">วันที่อัพเดต</th>
            <th align="center" width="180"><?php echo lang('web_tool');?></th> 
		</tr> 
	</thead>
	<tbody>
	<?php 
	if(!empty($listJewely)){
		$no=($page-1)*$limit;
		foreach($listJewely as $list){
			$jewely_id = $list["jewely_id"];
			$img_db = $this->model->getFirstJewelyImage($jewely_id);
			$img_path = DIR_PUBLIC."images/noimage.png";
			if($img_db!=''){
				$path = "public/upload/jewely/thumbnails/".basename($img_db);
				$dir_file = DIR_FILE.$path;
				if(file_exists($dir_file)){
					$img_path = DIR_ROOT.$path;
				}
			}
			?>
		<tr>
			<td align="center"><?php echo ++$no;?></td>
			<td align="center">
				<img src="<?php echo $img_path?>" style="max-width:150px;" />
			</td>
			<td>
				<a href="<?php echo DIR_ROOT?>jewely/backend/edit_jewely/id/<?php echo $list['jewely_id']; ?>" class="bluesky"><strong><?php echo $list['jewely_name'];?></strong></a>
			</td>
            <td align="center"><?php echo $this->bflibs->timeString($list['jewely_last_modified']);?></td>
			<td align="center">
				<?php echo $this->bflibs->web_tool("pin",$module,array('id'=>$jewely_id,'status'=>$list['jewely_pin']),'pin_jewely','','list_jewely',$target,$pagination);?>
				<?php echo $this->bflibs->web_tool("publish",$module,array('id'=>$jewely_id,'status'=>$list['jewely_publish']),'publish_jewely','','list_jewely',$target,$pagination);?>
				<?php echo $this->bflibs->web_tool("up",$module,array('id'=>$list['jewely_id'],'seq'=>$list['jewely_seq']),'up_jewely',$param,'list_jewely',$target);?>
				<?php echo $this->bflibs->web_tool("down",$module,array('id'=>$list['jewely_id'],'seq'=>$list['jewely_seq']),'down_jewely',$param,'list_jewely',$target);?>
				<?php echo $this->bflibs->web_tool("edit",$module,array('id'=>$list['jewely_id']),'edit_jewely');?>
				<?php echo $this->bflibs->web_tool("delete",$module,array('id'=>$list['jewely_id']),'delete_jewely',$param,'list_jewely',$target);?>
				
				
			</td>
		</tr>
		<?php }}else{?>
		<tr><td colspan="5" align="center"><?php echo lang('web_no_data');?></td></tr>
		<?php }?>
	</tbody>
</table>
<div class="clearfix"></div>
<?php echo $page_description.$paginaion;?>