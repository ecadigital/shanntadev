<?php 
$this->sp_model = $this->load->model('shoppingcart/Shoppingcartmodel');
$notify_neworder = $this->sp_model->notify_neworder();
//$this->member_model = $this->load->model('member/Membermodel');
//$notify_newmember = $this->member_model->notify_newmember();
?>
<div class="topheader">
	<ul class="notebutton">
		<!--<li class="note">
			<a class="messagenotify" href="javascript:void(0);" onclick="loadAjax('<?php echo DIR_ROOT?>member/backend/index','#','');" title="new member">
				<span class="wrap">
					<span class="thicon msgicon"></span>
					<?php if(!empty($notify_newmember['newmember'])){?><span class="count"><?php echo $notify_newmember['newmember'];?></span><?php }?>
				</span>
			</a>
		</li>
		--><li class="note">
			<a class="alertnotify" href="javascript:void(0);" onclick="loadAjax('<?php echo DIR_ROOT?>shoppingcart/backend/index','#','');" title="new order">
				<span class="wrap">
					<span class="thicon infoicon"></span>
					<?php if(!empty($notify_neworder['neworder'])){?><span class="count"><?php echo $notify_neworder['neworder'];?></span><?php }?>
				</span>
			</a>
		</li>
	</ul>
</div>