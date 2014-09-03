<h3>User</h3>
<div class="shortcutHome">
	<a href="<?php echo DIR_ROOT?>menu/admin/add"><img src="<?php echo DIR_PUBLIC?>layout/admin/images/dash_view.png"><br>Add Menu</a>
</div>

<table cellpadding="0" cellspacing="0" width="100%" class="data">
    <tr>
        <th width="6%">No</th>
        <th>Menu Name</th>
        <th width="25%">Link</th>
        <th width="20%">User Access</th>
        <th width="200">Tools</th>
    </tr>
    <tbody>
    <?php if(!empty($listMenu)){
        $i=1;
        foreach($listMenu as $list){
    ?>
        <tr>
            <td align="center"><?php echo $i++;?></td>
            <td>
                <?php echo $list['menu_desc']?>
            </td>
            <td>
                <?php echo $list['menu_admin_link']?>
            </td>
            <td>
                <?php 
            $admin_group = explode(",",$list['menu_admin_group']);
            foreach($admin_group as $key=>$group){
                if(!empty($group)){
                    $admin_group[$key] = $listGroupUserName[$group];
                }else{
                    unset($admin_group[$key]);
                }
            }
                echo implode(",",$admin_group);
                ?>
                <br />
            </td>
    
            <td class="tableActs">
                <a class="<?php echo ($list['menu_published_admin'] == '1')?'tablectrl_medium bGreen tipS':'tablectrl_medium bRed tipS';?>" title="<?php echo ($list['menu_published_admin'] == '1')?lang('web_publish'):lang('web_unpublish');?>" href="javascript:void(0);" onclick="loadAjax('<?php echo DIR_ROOT?>menu/admin/publish/id/<?php echo $list['menu_id']?>/status/<?php echo $list['menu_published_admin']?>','','loadAjax(\'<?php echo DIR_ROOT?>menu/admin/index\',\'#\',\'\')')"><span class="iconb" data-icon="&#xe028;"></span></a>
                
                <a class="tablectrl_medium bDefault tipS" title="<?php echo lang('web_up');?>" href="javascript:void(0);" onclick="loadAjax('<?php echo DIR_ROOT?>menu/admin/up/id/<?php echo $list['menu_id']?>/seq/<?php echo $list['menu_seq']?>/parent_id/<?php echo $list['menu_parent_id']?>','','loadAjax(\'<?php echo DIR_ROOT?>menu/index/menu\',\'#left_sidebar\',\'\')|loadAjax(\'<?php echo DIR_ROOT?>menu/admin/index\',\'#\',\'\')')"><div class="fs1 iconb" data-icon="&#xe241;"></div></a>
                
                <a class="tablectrl_medium bDefault tipS" title="<?php echo lang('web_down');?>" href="javascript:void(0);" onclick="loadAjax('<?php echo DIR_ROOT?>menu/admin/down/id/<?php echo $list['menu_id']?>/seq/<?php echo $list['menu_seq']?>/parent_id/<?php echo $list['menu_parent_id']?>','','loadAjax(\'<?php echo DIR_ROOT?>menu/index/menu\',\'#left_sidebar\',\'\')|loadAjax(\'<?php echo DIR_ROOT?>menu/admin/index\',\'#\',\'\')')"><div class="fs1 iconb" data-icon="&#xe240;"></div></a>
                
                <a class="tablectrl_medium bDefault tipS" title="<?php echo lang('web_edit');?>" href="<?php echo DIR_ROOT?>menu/admin/edit/id/<?php echo $list['menu_id'];?>/menu/<?php echo $menu;?>"><span class="iconb" data-icon="&#xe1db;"></span></a>
                
                <a class="tablectrl_medium bDefault tipS" title="<?php echo lang('web_delete');?>" href="javascript:void(0);" onclick="confirmDialog('<?php echo lang('web_cf_delete');?>','loadAjax(\'<?php echo DIR_ROOT?>menu/admin/delete/id/<?php echo $list['menu_id']?>\',\'\',\'loadAjax(\\\'<?php echo DIR_ROOT?>menu/admin/index\\\',\\\'#\\\',\\\'\\\')\')','<?php echo lang("web_ok")?>','<?php echo lang("web_cancel")?>')"><span class="iconb" data-icon="&#xe05c;"></span></a>

            </td>
        </tr>
        <?php 
        }
    }else{?>
        <tr><td colspan="5" align="center"><?php echo lang('web_no_data');?></td></tr>
    <?php }?>
	</tbody>
</table>