<ul class="userList">

<?php 
$this->model = $this->load->model('admin/Adminmodel');
$admin= $this->session->userdata('admin');

$this->model->updateOnlineUser($admin->admin_user);
$res_admin = $this->model->listOnlineUser();
if(!empty($res_admin)){
	foreach($res_admin as $list){
		$admin_image = ($list['admin_image']=='') ? DIR_PUBLIC.'images/userLogin2.png' : DIR_ROOT.$list['admin_image'];
		$res_online = $this->model->checkOnlineUser($list['admin_user']);
		echo '
		<li>
			<a href="javascript:void(0)" title="">
				<img src="'.$admin_image.'" width="36" alt="" />
				<span class="contactName">
					<strong>'.$list['admin_user'].'</strong>
					<i>'.$list['admin_group_desc'].'</i>
				</span>';
				
				if(!empty($res_online)){
					echo '<span class="status_available"></span>';
				}else{
					echo '<span class="status_off"></span>';
				}
				
				echo '
				<span class="clear"></span>
			</a>
		</li>';
	}
}
?>

</ul>
<div class="clear"></div>
<div class="divider"><span></span></div>
