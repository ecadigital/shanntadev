<h3><?php echo $listDetailPromotions['promotions_name'];?></h3>
<?php echo $this->bflibs->replacePathSlash($listDetailPromotions['promotions_detail']);?>
<?php if(!empty($listDetailPromotions['promotions_image'])){?>
<img src="<?php echo DIR_ROOT.$listDetailPromotions['promotions_image']?>" />
<?php }?>