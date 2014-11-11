<?php $pagination = true;
$this->model = $this->load->model('shop/Shopmodel');
?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="data"> 
	<thead> 
		<tr> 
			<th align="center" width="50"><?php echo lang('web_no');?></th>
			<th align="center" width="7%"><?php echo lang('web_image');?></th>
			<th>ชื่อที่ตั้งร้าน/สาขา</th>
			<th width="15%" align="center"><?php echo lang('web_date');?></th>
            <th align="center" width="180"><?php echo lang('web_tool');?></th> 
		</tr> 
	</thead>
	<tbody>
	<?php 
	if(!empty($listShop)){
		$no=($page-1)*$limit;
		foreach($listShop as $list){
			$shop_id = $list["shop_id"];
			$img_db = $list["shop_image"];
			$img_path = DIR_PUBLIC."layout/default/images/empty.png";
			if($img_db!=''){
				$path = "public/upload/shop/thumbnails/".basename($img_db);
				$dir_file = DIR_FILE.$path;
				if(file_exists($dir_file)){
					$img_path = DIR_ROOT.$path;
				}
			}
			?>
		<tr>
			<td align="center"><?php echo ++$no;?></td>
			<td align="center"><img src="<?php echo $img_path?>" style="max-width:100px;" /></td>
			<td>
				<a href="<?php echo DIR_ROOT?>shop/backend/edit_shop/id/<?php echo $shop_id;?>" class="bluesky" target="_blank"><strong><?php echo $list['shop_name'];?></strong></a>
                <div><?php echo nl2br($list['shop_detail'])?></div>
			</td>
            <td align="center"><?php echo $this->bflibs->timeString($list['shop_last_modified']);?></td>
			<td align="center">
				<?php echo $this->bflibs->web_tool("publish",$module,array('id'=>$shop_id,'status'=>$list['shop_publish']),'publish_shop','','list_shop',$target,$pagination);?>
				<?php echo $this->bflibs->web_tool("up",$module,array('id'=>$list['shop_id'],'seq'=>$list['shop_seq']),'up_shop',$param,'list_shop',$target);?>
				<?php echo $this->bflibs->web_tool("down",$module,array('id'=>$list['shop_id'],'seq'=>$list['shop_seq']),'down_shop',$param,'list_shop',$target);?>
				<?php echo $this->bflibs->web_tool("edit",$module,array('id'=>$shop_id),'edit_shop');?>
				<?php echo $this->bflibs->web_tool("delete",$module,array('id'=>$shop_id),'delete_shop',$param,'list_shop',$target);?>
				
				
			</td>
		</tr>
		<?php }}else{?>
		<tr><td colspan="5" align="center"><?php echo lang('web_no_data');?></td></tr>
		<?php }?>
	</tbody>
</table>
<div class="clearfix"></div>
<?php echo $page_description.$paginaion;?>