<?php 
$admin = $this->session->userdata('admin');
$this->model = $this->load->model('menu/Menumodel');
$listMenu = $this->model->readCache('menu',$admin->admin_group);

$menu_id = $this->request->getParam('menu');
$parent_menu = $this->model->getParentMenu($menu_id);
$menu_id = ($parent_menu != 0)?$parent_menu:$menu_id;
?>
<?php if(!empty($listMenu[0])){?>
<ul class="nav">
<?php foreach($listMenu[0] as $index=>$menu){
	$icon = ($menu['menu_imgpath_admin']!='')?'<img src="'.DIR_ROOT.$menu['menu_imgpath_admin'].'"/>':'';
	$active = ((empty($menu_id) && $index == 0) || ($menu_id == $menu['menu_id']))?'class="active"':'';
	$link = (isset($listMenu[$menu['menu_id']][0]))?$listMenu[$menu['menu_id']][0]['menu_admin_link']."/menu/".$listMenu[$menu['menu_id']][0]['menu_id']:$menu['menu_admin_link'];
?>

	<li><a href="<?php echo DIR_ROOT.$link;?>" <?php echo $active;?>><?php echo $icon?><span><?php echo $menu['menu_desc'];?></span></a></li>

<?php }?>
</ul>
<?php }?>