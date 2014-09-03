<?php $admin = $this->session->userdata('admin');
$this->modelAdmin = $this->load->model('admin/Adminmodel');
$listEdit = $this->modelAdmin->listEdit($admin->admin_id);
?>

Hi, <?php echo $listEdit['admin_user'];?><br>
<a href="<?php echo DIR_ROOT?>" target="_blank">View Website</a> | <a href="<?php echo DIR_ROOT?>admin/admin/profile">Profile</a> | <a href="<?php echo DIR_ROOT?>admin/admin/logout">Logout</a>