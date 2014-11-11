<?php $pagination = true;
$this->model = $this->load->model('slide/Slidemodel');
?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="data"> 
	<thead> 
		<tr> 
			<th align="center" width="50"><?php echo lang('web_no');?></th>
			<th><?php echo lang('slide_name');?></th>
			<th align="center" width="10%"><?php echo lang('slide_image');?></th>
			<th width="15%" align="center"><?php echo lang('slide_update');?></th>
            <th align="center" width="180"><?php echo lang('web_tool');?></th> 
		</tr> 
	</thead>
	<tbody>
	<?php 
	if(!empty($listSlide)){
		$no=($page-1)*$limit;
		foreach($listSlide as $list){
			$slide_id = $list["slide_id"];
			$img_db = $list["slide_image"];
			$img_path = DIR_PUBLIC."images/noimage.png";
			if($img_db!=''){
				$path = "public/upload/slide/thumbnails/".basename($img_db);
				$dir_file = DIR_FILE.$path;
				if(file_exists($dir_file)){
					$img_path = DIR_ROOT.$path;
				}
			}
			?>
		<tr>
			<td align="center"><?php echo ++$no;?></td>
			<td>
				<a href="<?php echo DIR_ROOT?>slide/backend/edit_slide/id/<?php echo $list['slide_id']; ?>" class="bluesky"><strong><?php echo $list['slide_keyhead'];?></strong></a>
				<div><?php echo $list['slide_keymessage'];?></div>
			</td>
			<td align="center"><img src="<?php echo $img_path?>" style="max-width:300px;" /></td>
            <td align="center"><?php echo $this->bflibs->timeString($list['slide_last_modified']);?></td>
			<td align="center">
				<?php echo $this->bflibs->web_tool("pin",$module,array('id'=>$slide_id,'status'=>$list['slide_pin']),'pin_slide','','list_slide',$target,$pagination);?>
				<?php echo $this->bflibs->web_tool("publish",$module,array('id'=>$slide_id,'status'=>$list['slide_publish']),'publish_slide','','list_slide',$target,$pagination);?>
				<?php echo $this->bflibs->web_tool("up",$module,array('id'=>$list['slide_id'],'seq'=>$list['slide_seq']),'up_slide',$param,'list_slide',$target);?>
				<?php echo $this->bflibs->web_tool("down",$module,array('id'=>$list['slide_id'],'seq'=>$list['slide_seq']),'down_slide',$param,'list_slide',$target);?>
				<?php echo $this->bflibs->web_tool("edit",$module,array('id'=>$list['slide_id']),'edit_slide');?>
				<?php echo $this->bflibs->web_tool("delete",$module,array('id'=>$list['slide_id']),'delete_slide',$param,'list_slide',$target);?>				
			</td>
		</tr>
		<?php }}else{?>
		<tr><td colspan="5" align="center"><?php echo lang('web_no_data');?></td></tr>
		<?php }?>
	</tbody>
</table>
<div class="clearfix"></div>
<?php echo $page_description.$paginaion;?>