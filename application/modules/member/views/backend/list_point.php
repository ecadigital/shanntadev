<?php $pagination = true;
$this->model = $this->load->model('member/Membermodel');
?>
<div><strong>สรุปผล</strong>&nbsp;&nbsp;&nbsp;&nbsp;
	<u>เพิ่ม</u> <?php echo number_format($addPoint);?> แต้ม &nbsp;&nbsp;
	<u>ลด</u> <?php echo number_format($delPoint);?> แต้ม
</div>
    <table cellpadding="0" cellspacing="0" border="0" width="100%" class="data"> 
        <thead> 
            <tr> 
                <th align="center" width="50"><?php echo lang('web_no');?></th>
                <th align="center" width="15%"><?php echo lang('member_point_val');?></th>
                <th align="center"><?php echo lang('member_point_reason');?></th>
                <th align="center" width="15%"><?php echo lang('member_point_date');?></th>
                <th align="center" width="50"><?php echo lang('web_tool');?></th> 
            </tr> 
        </thead>
        <tbody>
        <?php 
        if(!empty($listPoint)){
            $no=($page-1)*$limit;
            foreach($listPoint as $list){
                $member_point_id = $list["member_point_id"];
                ?>
            <tr>
                <td align="center"><?php echo ++$no;?></td>
                <td><?php echo ($list['member_point_type']==1) ? 'ได้รับ' : 'ลด';?> <?php echo number_format($list['member_point_val']);?> แต้ม</td>
                <td><?php echo $list['member_point_reason'];?></td>
                <td><?php echo $this->bflibs->timeString($list['member_point_date']);?></td>
                <td align="center">
                    <?php echo $this->bflibs->web_tool("delete",$module,array('id'=>$member_point_id),'delete_point',$param,'list_point',$target);?>
                </td>
            </tr>
            <?php }}else{?>
            <tr><td colspan="5" align="center"><?php echo lang('web_no_data');?></td></tr>
            <?php }?>
        </tbody>
    </table>
<?php //}?>
<div class="clearfix"></div>
<?php echo $page_description.$paginaion;?>