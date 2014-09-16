<?php 
$num=0;
if(!empty($listCategories)){
	$no=1;//($page-1)*$limit;
	foreach($listCategories as $list){
		$num++;
				
		$categories_id = $list["product_categories_id"];
		$categories_name = $list["product_categories_name"];
		?>
	
		<div class="large-items-2 columns">
			<a href="products.php?id=<?php echo $categories_id;?>" data-self="img/assets/collection-product-<?php echo $categories_id;?>-hover.png" data-preview="img/demo/product3.png">
				<img src="img/assets/collection-product-<?php echo $categories_id;?>.png" alt="">
				<span><?php echo strtoupper($categories_name);?></span>
			</a>
		</div>
<?php }}?>
<div class="large-items-3 columns preview">
	<img src="img/demo/product3.png" alt="">
</div>