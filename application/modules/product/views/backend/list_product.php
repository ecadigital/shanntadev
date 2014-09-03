<?php $pagination = true;
$this->model = $this->load->model('product/Productmodel');
?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="data"> 
	<thead> 
		<tr> 
			<th align="center" width="50"><?php echo lang('web_no');?></th>
			<th align="center" width="7%"><?php echo lang('web_image');?></th>
			<th>ชื่อสินค้า</th>
			<th width="15%" align="center">หมวดหมู่สินค้า</th>
			<th width="10%" align="center">ราคา</th>
			<th width="15%" align="center"><?php echo lang('product_update');?></th>
            <th align="center" width="170"><?php echo lang('web_tool');?></th> 
		</tr> 
	</thead>
	<tbody>
	<?php 
	if(!empty($listProduct)){
		$no=($page-1)*$limit;
		foreach($listProduct as $list){
			$product_id = $list["product_id"];
			$img_db = $this->model->getFirstProductImage($product_id);
			$img_path = DIR_PUBLIC."images/noimage.png";
			if($img_db!=''){
				$path = "public/upload/product/thumbnails/".basename($img_db);
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
				<a href="<?php echo DIR_ROOT?>product/backend/edit_product/id/<?php echo $product_id;?>" class="bluesky" target="_blank"><strong><?php echo $list['product_name'];?></strong></a>
				<div><i><?php echo nl2br($list['product_detail']);?></i></div>
			</td>
			<td align="center">
				<?php echo $list['product_categories_name']?>
			</td>
			<td align="right">
				<?php 
				if($list['product_discount']==''||$list['product_discount']==0||$list['product_discount']=='0%'){
					echo number_format($list['product_price']);
				}else{
					echo '
					<div style="height:15px;"><div style="float:left; font-weight:bold;"><i>ราคาเดิม</i></div></div>
					<div style="height:15px;"><div style="float:right; text-decoration:line-through;"><i>'.number_format($list['product_price']).'</i></div></div>
					<div style="height:15px;"><div style="float:left; font-weight:bold;"><i>ส่วนลด</i></div></div>
					<div style="height:15px;"><div style="float:right;"><i>'.$list['product_discount'].'</i></div></div>
					<div style="height:15px;"><div style="float:left; font-weight:bold;">ราคาสุทธิ</div></div>
					<div style="height:15px;"><div style="float:right;">'.number_format($list['product_newprice']).'</div></div>';
				}
				?>
			</td>
            <td align="center"><?php echo $this->bflibs->timeString($list['product_last_modified']);?></td>
			<td align="center">
				<?php echo $this->bflibs->web_tool("rec",$module,array('id'=>$product_id,'status'=>$list['product_rec']),'rec_product','','list_product',$target,$pagination);?>
				<?php echo $this->bflibs->web_tool("hot",$module,array('id'=>$product_id,'status'=>$list['product_hot']),'hot_product','','list_product',$target,$pagination);?>
				<?php //echo $this->bflibs->web_tool("pro",$module,array('id'=>$product_id,'status'=>$list['product_pro']),'pro_product','','list_product',$target,$pagination);?>
				<?php //echo $this->bflibs->web_tool("sale",$module,array('id'=>$product_id,'status'=>$list['product_sale']),'sale_product','','list_product',$target,$pagination);?>
                <!--<div style="padding-top:20px;">-->
				<?php echo $this->bflibs->web_tool("up",$module,array('id'=>$list['product_id'],'seq'=>$list['product_seq']),'up_product',$param,'list_product/type/'.$type,$target);?>
				<?php echo $this->bflibs->web_tool("down",$module,array('id'=>$list['product_id'],'seq'=>$list['product_seq']),'down_product',$param,'list_product/type/'.$type,$target);?>
				<?php //echo $this->bflibs->web_tool("pin",$module,array('id'=>$product_id,'status'=>$list['product_pin']),'pin_product','','list_product',$target,$pagination);?>
				<?php echo $this->bflibs->web_tool("publish",$module,array('id'=>$product_id,'status'=>$list['product_publish']),'publish_product','','list_product',$target,$pagination);?>
				<?php echo $this->bflibs->web_tool("edit",$module,array('id'=>$product_id),'edit_product');?>
				<?php echo $this->bflibs->web_tool("delete",$module,array('id'=>$product_id),'delete_product',$param,'list_product',$target);?>
				<!--</div>-->
				
			</td>
		</tr>
		<?php }}else{?>
		<tr><td colspan="7" align="center"><?php echo lang('web_no_data');?></td></tr>
		<?php }?>
	</tbody>
</table>
<div class="clearfix"></div>
<?php if(!empty($listProduct)) echo $page_description.$paginaion;?>