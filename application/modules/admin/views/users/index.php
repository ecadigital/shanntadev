<?php 
$admin= $this->session->userdata('admin');

if($p==2){ 	$name = "Admin ระดับสูง";		$admin_group_can = 'จัดการข้อมูลได้ทุกอย่าง';  }
else		{	$name = "Admin ระดับกลาง";	$admin_group_can = 'จัดการข้อมูลสินค้า, รายการสั่งซื้อ, ข่าว/โปรโมชั่น, ติดต่อเรา และจัดการหน้าอื่นๆ';  }
?>
<h3><?php echo $name?></h3>
<div style="color:#E46C6E;"><i><?php echo $admin_group_can;?></i></div>

<?php /*?><div class="shortcutHome">
	<a href="<?php echo DIR_ROOT?>admin/users/add"><img src="<?php echo DIR_PUBLIC?>layout/admin/images/dash_admin_add.png"><br>Add User</a>
</div>
<?php if($admin->admin_group==1){?>
<div class="shortcutHome">
	<a href="<?php echo DIR_ROOT?>admin/users/add"><img src="<?php echo DIR_PUBLIC?>layout/admin/images/dash_admin.png"><br>Group User</a>
</div>
<?php }?><?php */?>
<div style="padding-top:10px; font-weight:bold;"><a href="<?php echo DIR_ROOT?>admin/users/add/p/<?php echo $p;?>">เพิ่มผู้ดูแลระบบ</a></div>
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="data">
    <thead>
        <tr>
            <th width="30" align="center">#</th>
            <!--<th width="12%" align="center">รูป</th>-->
            <th >ชื่อ</th>
            <th width="20%">อีเมล์</th>
            <th width="20%">ชื่อผู้ใช้</th>
           <!-- <th>Group</th>-->
            <th align="center" width="120">Tools</th>
        </tr>
    </thead>
    <?php 
	$no=0;
	if(!empty($listAllUser)){
		foreach($listAllUser as $list){
			$no++;
			?>
    <tr>
        <td align="center"><?php echo $no;?></td>
        <!--<td align="center">
            <?php if($list['admin_image'] !=""){?>
            <img src="<?php echo DIR_ROOT.$list['admin_image']?>" class="b_shadow" width="75"/>
            <?php }?>
        </td>-->
        <td>
            <?php echo $list['admin_name']?>
        </td>
        <td>
            <?php echo $list['admin_email']?>
        </td>
        <td>
            <?php echo $list['admin_user']?>
        </td>
        <!--<td>
            <?php echo $listGroupUserName[$list['admin_group_id']]?>
        </td>-->
        <td align="center">
            <a class="<?php echo ($list['admin_block'] == '1')?'tablectrl_medium bGreen tipS':'tablectrl_medium bRed tipS';?>" title="<?php echo ($list['admin_block'] == '1')?'normal':'lock';?>" href="javascript:void(0);" onclick="loadAjax('<?php echo DIR_ROOT?>admin/users/publish/id/<?php echo $list['admin_id']?>/status/<?php echo $list['admin_block']?>','','loadAjax(\'<?php echo DIR_ROOT?>admin/users/index\',\'#\',\'\')')"><span class="iconb" data-icon="<?php echo ($list['admin_block'] == '1')?'&#xe1c0;':'&#xe1be;';?>" style="padding: 0 2px;"></span></a>
            <a class="button-edit" title="edit" href="<?php echo DIR_ROOT?>admin/users/edit/id/<?php echo $list['admin_id'].$param?>" ></a>
            <!--<a class="button-delete" title="delete" href="javascript:void(0);" onclick="myConfirm('do you want to delete ?','','','OK','Cancel','loadAjax(\'<?php echo DIR_ROOT?>admin/users/delete/id/<?php echo $list['admin_id']?>/p/<?php echo $p;?>\',\'\',\'loadAjax(\\\'<?php echo DIR_ROOT?>admin/users/index\\\',\\\'#\\\',\\\'\\\')\')')"></a>-->
            <a onclick="myConfirm('คุณต้องการจะลบข้อมูลนี้หรือไม่','','','ตกลง','ยกเลิก','loadAjax(\'<?php echo DIR_ROOT?>admin/users/delete/id/<?php echo $list['admin_id']?>/p/<?php echo $p;?>\',\'\',\'window.location=\\\'<?php echo DIR_ROOT?>admin/users/index/p/<?php echo $p;?>\\\';\')' )" href="javascript:void(0);" title="ลบ" class="delete"></a>
        </td>
    </tr>
	<?php }}else{?>
    <tr><td colspan="5" align="center"><?php echo lang('web_no_data');?></td></tr>
    <?php }?>
</table>
