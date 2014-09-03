<?php $pagination = true;
$this->model = $this->load->model('news/Newsmodel');
?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="data"> 
	<thead> 
		<tr> 
			<th align="center" width="50"><?php echo lang('web_no');?></th>
			<th align="center" width="7%"><?php echo lang('web_image');?></th>
			<th><?php echo lang('news_name');?></th>
			<th width="15%" align="center"><?php echo lang('news_update');?></th>
            <th align="center" width="180"><?php echo lang('web_tool');?></th> 
		</tr> 
	</thead>
	<tbody>
	<?php 
	if(!empty($listNews)){
		$no=($page-1)*$limit;
		foreach($listNews as $list){
			$news_id = $list["news_id"];
			$img_db = $this->model->getFirstNewsImage($news_id);
			$img_path = DIR_PUBLIC."images/noimage.png";
			if($img_db!=''){
				$path = "public/upload/news/thumbnails/".basename($img_db);
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
				<a href="<?php echo DIR_ROOT?>news/backend/edit_news/id/<?php echo $list['news_id']; ?>" class="bluesky"><strong><?php echo $list['news_name'];?></strong></a>
			</td>
            <td align="center"><?php echo $this->bflibs->timeString($list['news_last_modified']);?></td>
			<td align="center">
				<?php echo $this->bflibs->web_tool("pin",$module,array('id'=>$news_id,'status'=>$list['news_pin']),'pin_news','','list_news',$target,$pagination);?>
				<?php echo $this->bflibs->web_tool("publish",$module,array('id'=>$news_id,'status'=>$list['news_publish']),'publish_news','','list_news',$target,$pagination);?>
				<?php echo $this->bflibs->web_tool("up",$module,array('id'=>$list['news_id'],'seq'=>$list['news_seq']),'up_news',$param,'list_news',$target);?>
				<?php echo $this->bflibs->web_tool("down",$module,array('id'=>$list['news_id'],'seq'=>$list['news_seq']),'down_news',$param,'list_news',$target);?>
				<?php echo $this->bflibs->web_tool("edit",$module,array('id'=>$list['news_id']),'edit_news');?>
				<?php echo $this->bflibs->web_tool("delete",$module,array('id'=>$list['news_id']),'delete_news',$param,'list_news',$target);?>
				
				
			</td>
		</tr>
		<?php }}else{?>
		<tr><td colspan="5" align="center"><?php echo lang('web_no_data');?></td></tr>
		<?php }?>
	</tbody>
</table>
<div class="clearfix"></div>
<?php echo $page_description.$paginaion;?>