<?php 
class Backend extends CI_Controller{
	private $view;
	private $perpageMember = 10;
	
	public function __construct()
    {
        parent::__construct();
    	if($this->request->getParam('check_login') != 'ignor'){
	     	$this->bflibs->check_login_admin();
			$admin= $this->session->userdata('admin');
	   		if(empty($admin->admin_id)){
	        	redirect('/admin/admin/login', 'refresh');
	        }
   	 	}
		$layout = ($this->request->getParam('layout') == "")?'admin':$this->request->getParam('layout');
		$this->layout->setLayout($layout);
		$this->bflibs->setStack('admin');
		$actions = $this->bflibs->insertActionStack();
    	foreach($actions as $action)
		{
			$this->layout->setActionStack($action["name"],$action["view"]);
		}
		$this->model = $this->load->model('member/Membermodel');
    }
	
	
	/*  MEMBER
	-------------------------------------------------------------------------------------------------------*/
	
	public function index()
	{
		$this->view['targetpage'] = $targetpage = 'member/backend/list_member';
		$this->view['perPage'] = $this->perpageMember;
		$this->layout->view('/backend/index', $this->view);
	}
	public function list_member()
	{
		$this->layout->setLayout('ajax');
		$this->view['module'] = $this->request->getModuleName();
		$this->view['param'] = '';
		$this->view['target'] = '#boxContent';
		$this->view['targetpage'] = $targetpage = 'member/backend/list_member';
		
		$page = $this->request->getParam('page');
		$this->view['page'] = $page = (empty($page))?1:$page;
		
		$limit = $this->request->getParam('limit');
		$this->view['limit'] = $limit = (empty($limit))?50:$limit;
		
		$q = $this->request->getParam('q');
		
		$targetpage = 'member/backend/list_member/limit/'.$limit;
		list($this->view['paginaion'],$this->view['page_description'],$this->view['listMember']) = $this->model->listMember($targetpage,$page,$limit,$q);
		$this->layout->view('/backend/list_member', $this->view);
	}
	public function add_member()
	{
		$this->view['listProvince'] = $this->model->listProvince();
		if($data = $this->input->post()){
		
			$this->model->setValue($data);
			
			//$member_pass = rand(100000,999999);
			
			$member_id = $this->model->addMember($member_pass);
			//$this->model->sendmail($member_id,$member_pass,$data['member_code']);
			//$this->model->sendmail($member_id);
						
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning'); 
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."member/backend/add_member';
				},3000);
			</script>";
		}
		$this->layout->view('/backend/add_member', $this->view);
	}
	public function edit_member()
	{
		$member_id = $this->request->getParam('id');
		$this->view['listEditMember'] = $listEditMember = $this->model->listEditMember($member_id);
		$this->view['listProvince'] = $this->model->listProvince();

		if($data = $this->input->post()){
			
			$this->model->setValue($data);
			$member_id = $this->model->editMember();
			$this->model->sendmail_code($member_id,$data['member_code']);
			
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning');
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."member/backend/index';
				},3000);
			</script>";
		}
		$this->layout->view('/backend/edit_member', $this->view);
	}
	public function delete_member()
	{
		$this->layout->disableLayout();
		$Array_id=array();
		if($data = $this->input->post()){
			$Array_id = explode(',',$data['id']);
		}else{
			$Array_id[0] = $this->request->getParam('id');
		}
		
		for($i=0;$i<count($Array_id);$i++){
			$this->model->deleteMember($Array_id[$i]);
		}
	}
	public function publish_member()
	{
		$this->layout->disableLayout();
		$status = $this->request->getParam('status');
		
		$Array_id=array();
		if($data = $this->input->post()){
			$Array_id = explode(',',$data['id']);
		}else{
			$Array_id[0] = $this->request->getParam('id');
		}
		
		for($i=0;$i<count($Array_id);$i++){
			$this->bflibs->publish('member','member_id',$Array_id[$i],'member_publish',$status);
		}
	}

	public function index_order()
	{
		$this->view['member_id'] = $member_id = $this->request->getParam('id');
		$this->view['targetpage'] = $targetpage = 'member/backend/list_history/id/'.$member_id;
		$this->view['perPage'] = $this->perpageMember;
		
		$listEditMember = $this->model->listEditMember($member_id);
		$this->view['member_name'] = (empty($listEditMember)) ? '-' : $listEditMember['member_first_name'].' '.$listEditMember['member_last_name'];
		
		$this->layout->view('/backend/index_order', $this->view);
	}
	public function list_order()
	{
		$this->layout->setLayout('ajax');
		$this->view['module'] = $this->request->getModuleName();
		$this->view['param'] = '';
		$this->view['target'] = '#boxContent';
		
		$member_id = $this->request->getParam('id');
		$this->view['targetpage'] = $targetpage = 'member/backend/list_order/id/'.$member_id;
		
		$page = $this->request->getParam('page');
		$this->view['page'] = $page = (empty($page))?1:$page;
		
		$limit = $this->request->getParam('limit');
		$this->view['limit'] = $limit = (empty($limit))?$this->perpageMember:$limit;
		
		$q = $this->request->getParam('q');
		
		$targetpage = 'member/backend/list_order/id/'.$member_id.'/limit/'.$limit;
		list($this->view['paginaion'],$this->view['page_description'],$this->view['listHistory']) = $this->model->listHistory($targetpage,$page,$limit,$q,$member_id);
		$this->layout->view('/backend/list_order', $this->view);
	}
	function getSelectParent(){
		$listParent = $this->model->listParent();
		echo '
		<select id="parent_id" name="parent_id">';
			if(!empty($listParent)){
				foreach($listParent as $list){
					echo '<option value="'.$list['member_id'].'">'.$list['member_first_name'].' '.$list['member_last_name'].'</option>';
				}
			}
		echo '</select>';
	}
	
	/*  TEAM
	-------------------------------------------------------------------------------------------------------*/
	
	public function index_team()
	{
		$this->view['member_id'] = $member_id = $this->request->getParam('id');
		$this->view['targetpage'] = $targetpage = 'member/backend/list_team/id/'.$member_id;
		$this->view['perPage'] = $this->perpageMember;
		
		$listEditMember = $this->model->listEditMember($member_id);
		$this->view['member_name'] = (empty($listEditMember)) ? '-' : $listEditMember['member_first_name'].' '.$listEditMember['member_last_name'];
		
		$this->layout->view('/backend/index_team', $this->view);
	}
	public function list_team()
	{
		$this->layout->setLayout('ajax');
		$this->view['module'] = $this->request->getModuleName();
		$this->view['param'] = '';
		$this->view['target'] = '#boxContent';
		
		$member_id = $this->request->getParam('id');
		$this->view['targetpage'] = $targetpage = 'member/backend/list_team/id/'.$member_id;
		
		$this->view['listTeam'] = $this->model->listTeam($member_id);
		
		$this->layout->view('/backend/list_team', $this->view);
	}
	public function add_team()
	{
		$this->view['member_id'] = $member_id = $this->request->getParam('id');
		
		$listEditMember = $this->model->listEditMember($member_id);
		$this->view['member_name'] = (empty($listEditMember)) ? '-' : $listEditMember['member_first_name'].' '.$listEditMember['member_last_name'];
		
		if($data = $this->input->post()){
		
			$this->model->setValue($data);print($data);
			$member_id =$data['parent_id'];
			$this->model->addTeam();
			//$this->model->sendmail($member_id,$member_pass,$data['member_code']);
						
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning'); 
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."member/backend/index_team/id/".$member_id."';
				},1000);
			</script>";
		}
		$this->layout->view('/backend/add_team', $this->view);
	}
	public function edit_team()
	{
		$team_id = $this->request->getParam('id');
		$this->view['listEditTeam'] = $listEditTeam = $this->model->listEditMember($team_id);
		$this->view['member_id'] = $member_id = $listEditTeam['parent_id'];
		
		$listEditMember = $this->model->listEditMember($member_id);
		$this->view['member_name'] = (empty($listEditMember)) ? '-' : $listEditMember['member_first_name'].' '.$listEditMember['member_last_name'];
		
		if($data = $this->input->post()){
			
			$this->model->setValue($data);
			$member_id =$data['parent_id'];
			$this->model->editTeam();
			//$this->model->sendmail_code($member_id,$data['member_code']);
			
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning');
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."member/backend/index_team/id/".$member_id."';
				},1000);
			</script>";
		}
		$this->layout->view('/backend/edit_team', $this->view);
	}

	public function index_history()
	{
		$team_id = $this->request->getParam('id');
		$this->view['targetpage'] = $targetpage = 'member/backend/list_history/id/'.$team_id;
		$this->view['perPage'] = $this->perpageMember;
		
		$listEditTeam = $this->model->listEditMember($team_id);
		$this->view['team_name'] = (empty($listEditTeam)) ? '-' : $listEditTeam['member_first_name'].' '.$listEditTeam['member_last_name'];
		
		$this->view['member_id'] = $member_id = $listEditTeam['parent_id'];
		$listEditMember = $this->model->listEditMember($member_id);
		$this->view['member_name'] = (empty($listEditMember)) ? '-' : $listEditMember['member_first_name'].' '.$listEditMember['member_last_name'];
		
		$this->layout->view('/backend/index_history', $this->view);
	}
	public function list_history()
	{
		$this->layout->setLayout('ajax');
		$this->view['module'] = $this->request->getModuleName();
		$this->view['param'] = '';
		$this->view['target'] = '#boxContent';
		
		$team_id = $this->request->getParam('id');
		$this->view['targetpage'] = $targetpage = 'member/backend/list_history/id/'.$team_id;
		
		$page = $this->request->getParam('page');
		$this->view['page'] = $page = (empty($page))?1:$page;
		
		$limit = $this->request->getParam('limit');
		$this->view['limit'] = $limit = (empty($limit))?$this->perpageMember:$limit;
		
		$q = $this->request->getParam('q');
		
		$targetpage = 'member/backend/list_history/id/'.$team_id.'/limit/'.$limit;
		list($this->view['paginaion'],$this->view['page_description'],$this->view['listHistory']) = $this->model->listHistory($targetpage,$page,$limit,$q,$team_id);
		$this->layout->view('/backend/list_history', $this->view);
	}
	

	/*  POINT
	-------------------------------------------------------------------------------------------------------*/
	
	
	public function index_point()
	{
		$this->view['member_id'] = $member_id = $this->request->getParam('id');
		$q = $this->request->getParam('q');
		$this->view['q'] = urldecode($q);
		
		$bd = $this->bflibs->addZeroDay($this->request->getParam('bd'));
		$bm = $this->bflibs->addZeroDay($this->request->getParam('bm'));
		$by = $this->request->getParam('by');
		$this->view['beg'] = $beg = ($bd==0||$bm==0) ? '' : $bd.'/'.$bm.'/'.$by;
		$ed = $this->bflibs->addZeroDay($this->request->getParam('ed'));
		$em = $this->bflibs->addZeroDay($this->request->getParam('em'));
		$ey = $this->request->getParam('ey');
		$this->view['end'] = $end = ($ed==0||$em==0) ? '' : $ed.'/'.$em.'/'.$ey;
		
		$this->view['listEditMember'] = $this->model->listEditMember($member_id);
		$this->view['targetpage'] = $targetpage = 'member/backend/list_point/id/'.$member_id;
		$this->view['perPage'] = $this->perpageMember;
		$this->layout->view('/backend/index_point', $this->view);
	}
	public function list_point()
	{
		$this->layout->setLayout('ajax');
		$member_id = $this->request->getParam('id');
		$this->view['module'] = $this->request->getModuleName();
		$this->view['param'] = '/id/'.$member_id;
		$this->view['target'] = '#boxContent';
		$this->view['targetpage'] = $targetpage = 'member/backend/list_point/id/'.$member_id;
		
		$page = $this->request->getParam('page');
		$this->view['page'] = $page = (empty($page))?1:$page;
		
		$limit = $this->request->getParam('limit');
		$this->view['limit'] = $limit = (empty($limit))?$this->perpageMember:$limit;
		
		$q = $this->request->getParam('q');
		$type=1;
		$bd = $this->bflibs->addZeroDay($this->request->getParam('bd'));
		$bm = $this->bflibs->addZeroDay($this->request->getParam('bm'));
		$by = $this->request->getParam('by');
		$beg = ($bd==0||$bm==0) ? '' : $bd.'/'.$bm.'/'.$by;
		$ed = $this->bflibs->addZeroDay($this->request->getParam('ed'));
		$em = $this->bflibs->addZeroDay($this->request->getParam('em'));
		$ey = $this->request->getParam('ey');
		$end = ($ed==0||$em==0) ? '' : $ed.'/'.$em.'/'.$ey;
		
		$this->view['addPoint'] = $this->model->sumPoint('1',$beg,$end,$member_id);
		$this->view['delPoint'] = $this->model->sumPoint('0',$beg,$end,$member_id);
		
		$targetpage = 'member/backend/list_point/id/'.$member_id.'/limit/'.$limit;
		list($this->view['paginaion'],$this->view['page_description'],$this->view['listPoint']) = $this->model->listPoint($targetpage,$page,$limit,$q,$member_id,$type,$beg,$end);
		$this->layout->view('/backend/list_point', $this->view);
	}
	public function add_point()
	{
		$this->view['listMember'] = $this->model->listAllMember();
		$this->view['listPoint'] = $this->model->listAllPoint(10);
		
		$bd = $this->bflibs->addZeroDay($this->request->getParam('bd'));
		$bm = $this->bflibs->addZeroDay($this->request->getParam('bm'));
		$by = $this->request->getParam('by');
		$this->view['beg'] = $beg = ($bd==0||$bm==0) ? '' : $bd.'/'.$bm.'/'.$by;
		$ed = $this->bflibs->addZeroDay($this->request->getParam('ed'));
		$em = $this->bflibs->addZeroDay($this->request->getParam('em'));
		$ey = $this->request->getParam('ey');
		$this->view['end'] = $end = ($ed==0||$em==0) ? '' : $ed.'/'.$em.'/'.$ey;
		
		if($data = $this->input->post()){
		
			$this->model->setValue($data);
			$point_id = $this->model->addPoint();			
			
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning'); 
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."member/backend/index_point/id/".$data['member_id']."';
				},3000);
			</script>";
		}
		$this->layout->view('/backend/add_point', $this->view);
	}
	public function delete_point()
	{
		$this->layout->disableLayout();
		$Array_id=array();
		if($data = $this->input->post()){
			$Array_id = explode(',',$data['id']);
		}else{
			$Array_id[0] = $this->request->getParam('id');
		}
		
		for($i=0;$i<count($Array_id);$i++){
			$this->model->deletePoint($Array_id[$i]);
		}
	}
	
	
	/*  SETTING
	-------------------------------------------------------------------------------------------------------*/
	
	public function index_setting()
	{
		$this->view['getMain'] = $this->model->getMain();
		if($data = $this->input->post()){
		
			$this->model->setValue($data);
			$point_id = $this->model->editSetting();			
			
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning'); 
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."member/backend/index_setting';
				},1000);
			</script>";
		}
		$this->layout->view('/backend/index_setting', $this->view);
	}
	

	/*  AJAX
	-------------------------------------------------------------------------------------------------------*/

	public function showAjax()
	{
		$this->layout->disableLayout();
		$type = $this->request->getParam('type');
		switch ($type){
			case 'remove_file':{
				$data = $this->input->post();
				$this->model->remove_file($data['file']);
				break;
			}
		}
		
	}
}
?>