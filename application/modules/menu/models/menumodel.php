<?php
class Menumodel extends CI_Model {
	private $val;
	private $tbl_admin_menu = "admin_menu";
	private $tbl_admin_group = "admin_group";
	private $tbl_admin_module = "admin_module";
	private $arr_menu = array();
	private $listMenu = array();
	private $listMenuParent = array();
	private $arr_breadcrumbs = array();
	
	public function __construct()
    {
        parent::__construct();
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
    }
	public function setValue($val){
		$this->value = $val;
	}
	
	private function getValue(){
		return $this->value;
	}

	public function listMenu($parent_id,$space)
	{
		$query = $this->db->select(array("$this->tbl_admin_menu.menu_id","$this->tbl_admin_menu.menu_desc","$this->tbl_admin_menu.module_id","$this->tbl_admin_module.module_name","$this->tbl_admin_menu.menu_admin_link","$this->tbl_admin_menu.menu_imgpath_admin","$this->tbl_admin_menu.menu_published_admin","$this->tbl_admin_menu.menu_menutype_admin","$this->tbl_admin_menu.menu_seq","$this->tbl_admin_menu.menu_parent_id","$this->tbl_admin_menu.menu_admin_group"))
				->from($this->tbl_admin_menu)
				->join($this->tbl_admin_module,"$this->tbl_admin_menu.module_id=$this->tbl_admin_module.module_id","left")
				->where("$this->tbl_admin_menu.menu_parent_id",$parent_id)
				->order_by("$this->tbl_admin_menu.menu_seq","asc");
		$query = $this->db->get();
		$result = $query->result_array();
		if(!empty($result)){
			foreach($result as $res){
				$res['menu_desc'] = $this->mkSpace($space).$res['menu_desc'];
				$this->listMenu[] = $res;
				$this->listMenu($res['menu_id'],$space+2);
			}
		}
		return $this->listMenu;
	}
	
	public function listMenuParent($parent_id,$space)
	{
		$query = $this->db->select(array('menu_id','menu_desc'))
				->from($this->tbl_admin_menu)
				->where('menu_published_admin',1)
				->where('menu_parent_id',$parent_id)
				->order_by("menu_seq","asc");
		$query = $this->db->get();
		$result = $query->result_array();
		if(!empty($result)){
			foreach($result as $res){
				
				$this->listMenuParent[] = array('menu_id'=>$res['menu_id'],'menu_desc'=>$this->mkSpace($space).$res['menu_desc']);
				$this->listMenuParent($res['menu_id'],$space+2);
			}
		}
		return $this->listMenuParent;
	}
	public function listMenuParentEdit($parent_id,$space,$id)
	{
		$query = $this->db->select(array('menu_id','menu_desc'))
				->from($this->tbl_admin_menu)
				->where('menu_published_admin',1)
				->where('menu_id !=',$id)
				->where('menu_parent_id',$parent_id)
				->order_by("menu_seq","asc");
		$query = $this->db->get();
		$result = $query->result_array();
		if(!empty($result)){
			foreach($result as $res){
				
				$this->listMenuParent[] = array('menu_id'=>$res['menu_id'],'menu_desc'=>$this->mkSpace($space).$res['menu_desc']);
				$this->listMenuParentEdit($res['menu_id'],$space+2,$id);
			}
		}
		return $this->listMenuParent;
	}
	public function mkSpace($space)
	{
		$str = "";
		if($space > 0){
			for($i = 0;$i < $space; $i++){
				$str .="&nbsp;";
			}
			$str .="|-";
		}
		return $str;
	}
	
	public function listEdit($id)
	{
		$query = $this->db->select()
				->from($this->tbl_admin_menu)
				->where('menu_id',$id);
		$query = $this->db->get();
		$result = $query->row_array();
		return $result;
	}
	
	public function listGroupUser()
	{
		$query = $this->db->select()
				->from($this->tbl_admin_group)
				->order_by("admin_group_seq","asc");
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	
	public function listGroupUserName()
	{
		$query = $this->db->select()
				->from($this->tbl_admin_group)
				->order_by("admin_group_seq","asc");
		$query = $this->db->get();
		$result = $query->result_array();
		$return=array();
		foreach($result as $res){
			$return[$res['admin_group_id']] = $res['admin_group_desc'];
		}
		return $return;
	}
	
	public function listModule()
	{
		$query = $this->db->select()
				->from($this->tbl_admin_module)
				->where('module_type !=','1')
				->order_by("module_seq","asc");
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	
	public function add()
	{
		$val = $this->getValue();
		$menu_id = $this->bflibs->getLastID($this->tbl_admin_menu,'menu_id');
		$menu_seq = $this->bflibs->getLastIdWithGroup($this->tbl_admin_menu,'menu_seq','menu_parent_id',$val['menu_parent_id']);
		$group_id = (!empty($val['admin_group_id']))?implode(",",$val['admin_group_id']).",":'';
		$data = array("menu_id"=>$menu_id,
				"menu_desc"=>$val['menu_desc'],
				"menu_admin_link"=>$val['menu_admin_link'],
				"menu_published_admin"=>$val['menu_published_admin'],
				"menu_menutype_admin"=>$val['menu_menutype_admin'],
				"menu_parent_id"=>$val['menu_parent_id'],
				"menu_seq"=>$menu_seq,
				"menu_admin_group"=>",1,".$group_id
		);
		$this->db->insert($this->tbl_admin_menu,$data);
		return $menu_id;
	}
	
	public function edit()
	{
		$val = $this->getValue();
		$menu_seq = ($val['menu_parent_id'] != $val['menu_old_parent'])?$this->bflibs->getLastIdWithGroup($this->tbl_admin_menu,'menu_seq','menu_parent_id',$val['menu_parent_id']):$val['menu_seq'];
		$group_id = (!empty($val['admin_group_id']))?implode(",",$val['admin_group_id']).",":'';
		$data = array("menu_desc"=>$val['menu_desc'],
				"menu_admin_link"=>$val['menu_admin_link'],
				"menu_published_admin"=>$val['menu_published_admin'],
				"menu_menutype_admin"=>$val['menu_menutype_admin'],
				"menu_parent_id"=>$val['menu_parent_id'],
				"menu_seq"=>$menu_seq,
				"menu_admin_group"=>",1,".$group_id
		);
		$this->db->where('menu_id',$val['menu_id']);
		$this->db->update($this->tbl_admin_menu,$data);
		return $val['menu_id'];
	}
	public function updatePath($path,$id){
	
		$val = $this->getValue();
		if(isset($val["image_path"])){
			$oldext = $this->bflibs->getExt($val["image_path"]);
			$ext = $this->bflibs->getExt($path);
			// กรณีที่นามสกุลเก่าและ นามสกุลไฟล์ที่อัพเข้ามาไม่เหมือนกันจะทำการลบไฟล์เดิมทิ้ง
			if($oldext != $ext){
				$pathImage = DIR_FILE.$val["image_path"];
				unlink($pathImage);
			}
		}
		$data = array("menu_imgpath_admin"=>$path);
		$this->db->where('menu_id',$id);
		$this->db->update($this->tbl_admin_menu,$data);
	}
	public function delete($id)
	{
		$query = $this->db->select()
				->from($this->tbl_admin_menu,"menu_id")
				->where("menu_parent_id",$id);
		$query = $this->db->get();
		$result = $query->result_array();
		
		if(!empty($result)){
			foreach($result as $res){
				$this->delete($res['menu_id']);
			}
		}

		$query_path = $this->db->select('menu_imgpath_admin')
				->from($this->tbl_admin_menu)
				->where('menu_id',$id);
		$query_path = $this->db->get();
		$result_path = $query_path->row_array();
	
		if($result_path['menu_imgpath_admin'] != ''){
			
			$path = DIR_FILE.$result_path['menu_imgpath_admin'];
			unlink($path);
		}
		
		$this->db->where('menu_id',$id);
		$this->db->delete($this->tbl_admin_menu);
		return;
	}
	public function delete_image($id)
	{
		$query = $this->db->select('menu_imgpath_admin')
				->from($this->tbl_admin_menu)
				->where('menu_id',$id);
		$query = $this->db->get();
		$result = $query->row_array();
	
		if($result['menu_imgpath_admin'] != ''){
			
			$path = DIR_FILE.$result['menu_imgpath_admin'];
			unlink($path);
		}
		
		$data = array("menu_imgpath_admin"=>"");
		$this->db->where('menu_id',$id);
		$this->db->update($this->tbl_admin_menu,$data);
	}
	// up menu แบบมี parent id
	public function upMenu($id,$seq,$parent_id)
	{
		$query = $this->db->select()
				->from($this->tbl_admin_menu)
				->where("menu_seq <",$seq)
				->where("menu_parent_id",$parent_id)
				->order_by("menu_seq","desc");
		$query = $this->db->get();
		$newer = $query->row_array();
		if(!empty($newer))
		{
			$oldSeq = array("menu_seq"=>$seq);
			$newSeq = array("menu_seq"=>$newer["menu_seq"]);
		
			if($newer!=null)
			{
				$this->db->where('menu_id',$id);
				$this->db->update($this->tbl_admin_menu,$newSeq);
				$this->db->where('menu_id',$newer["menu_id"]);
				$this->db->update($this->tbl_admin_menu,$oldSeq);
			}
		}
	}
	public function downMenu($id,$seq,$parent_id)
	{
		$query = $this->db->select()
				->from($this->tbl_admin_menu)
				->where("menu_seq >",$seq)
				->where("menu_parent_id",$parent_id)
				->order_by("menu_seq","asc");
		$query = $this->db->get();
		$newer = $query->row_array();
		if(!empty($newer))
		{
			$oldSeq = array("menu_seq"=>$seq);
			$newSeq = array("menu_seq"=>$newer["menu_seq"]);
		
			if($newer!=null)
			{
				$this->db->where('menu_id',$id);
				$this->db->update($this->tbl_admin_menu,$newSeq);
				$this->db->where('menu_id',$newer["menu_id"]);
				$this->db->update($this->tbl_admin_menu,$oldSeq);
			}
		}
	}
	public function publish($id,$status)
	{
		$data = array("menu_published_admin"=>2-($status+1));
		$this->db->where('menu_id',$id);
		$this->db->update($this->tbl_admin_menu,$data);
	}
	
	public function mkMenu($parent_id,$group){
		
		$query = $this->db->select(array('menu_id','menu_desc','menu_imgpath_admin','menu_admin_link','menu_notify'))
				->from($this->tbl_admin_menu)
				->where("menu_parent_id",$parent_id)
				->where("menu_published_admin",1)
				->where("menu_admin_group like","%".$group."%")
				->order_by("menu_seq","asc");
		$query = $this->db->get();
		$result = $query->result_array();
		if(!empty($result)){
			foreach($result as $res){
				$this->arr_menu[$parent_id][] = $res;
				$this->mkMenu($res['menu_id'],$group);
			}
		}
		return $this->arr_menu;
	}
	
	public function first_menu()
	{
		$query = $this->db->select('menu_id')
				->from($this->tbl_admin_menu)
				->where("menu_parent_id",0)
				->order_by("menu_seq","asc");
		$query = $this->db->get();
		$result = $query->row_array();
		return $result['menu_id'];
	}

	public function getParentMenu($menu_id)
	{
		if(!empty($menu_id)){
			$query = $this->db->select('menu_parent_id')
					->from($this->tbl_admin_menu)
					->where("menu_id",$menu_id);
			$query = $this->db->get();
			$result = $query->row_array();
			return $result['menu_parent_id'];
		}
		else{
			return $this->first_menu();
		}
	}
	
	public function mkBreadcrumbs($menu_id,$group){
		
		$query = $this->db->select(array('menu_id','menu_parent_id','menu_desc','menu_admin_link'))
				->from($this->tbl_admin_menu)
				->where("menu_id",$menu_id)
				->where("menu_published_admin",1)
				->where("menu_admin_group like","%".$group."%");
		$query = $this->db->get();
		$result = $query->row_array();
		if(!empty($result)){
			if($result['menu_admin_link'] == '#' || empty($result['menu_admin_link'])){
				$query = $this->db->select(array('menu_id','menu_admin_link'))
						->from($this->tbl_admin_menu)
						->where("menu_parent_id",$result['menu_id'])
						->order_by("menu_seq","asc");
				$query_link = $this->db->get();
				$result_link = $query_link->row_array();
				$result['menu_id'] = $result_link['menu_id'];
				$result['menu_admin_link'] = $result_link['menu_admin_link'];
			}
			$this->arr_breadcrumbs[] = $result;
			$this->mkBreadcrumbs($result['menu_parent_id'],$group);
		}
		return $this->arr_breadcrumbs;
	}
	
	/*  CACHE FILE
	----------------------------------------------------------------------------------------------- */
	public function updateCache($cachefile,$group_id)
	{
		if(!empty($group_id)){
			$cacheName = $cachefile."_".$group_id;
			$this->clearcache($cacheName); //ทำการ เคลียร์ก่อนการ สร้างไฟล์ใหม่ ทุกครั้ง
			if ( ! $structure = $this->cache->get($cacheName)) // ถ้ายังไม่มีการสร้าง cache ไฟล์
			{
			     $data = $this->mkMenu(0,$group_id);
			     $this->cache->save($cacheName, $data, 2592000); //lifetime 30*24*3600 = 30 วัน
			     $this->arr_menu = array();
			}
		}
	}
	
	public function readCache($cachefile,$group_id)
	{
		if(!empty($group_id)){
			$cacheName = $cachefile."_".$group_id;
			$this->chk_update('updatemenu',$cachefile);
			if ( ! $structure = $this->cache->get($cacheName))
			{
				$this->updateCache($cachefile,$group_id);
				return $this->cache->get($cacheName);
			}else{
				return $structure;
			}
		}
	}
	public function clearcache($cachefile)
	{
		if (file_exists(DIR_FILE."application/cache/".$cachefile))
		{
			$this->cache->delete($cachefile);
		}
	}
	
	/*  CHECK UPDATE MENU
	----------------------------------------------------------------------------------------------- */
	public function chk_update($chk,$cachefile)
	{
		$this->load->helper('file');
		$path = './public/tmp/update/'.$chk.'.txt';
		$lastUpdate = read_file($path);
		
		if($lastUpdate == 0)//เมื่อไฟล์ถูกเขียนเป็น 0 ต้องมีการ update menu ใหม่
		{
			$listGroupUser = $this->listGroupUser();
			if(!empty($listGroupUser)){
				foreach($listGroupUser as $groupUser){
					$cacheName = $cachefile.'_'.$groupUser['admin_group_id'];
					$this->clearcache($cacheName);
				}
			}
			write_file($path, 1, 'w+');
		}
	}
}
?>