<?php
class Modulemodel extends CI_Model {
	private $value;
	private $tbl_admin_module = 'admin_module';
	private $tbl_admin_extension = 'admin_extension';
	private $folderPermission = "0755";
	private $filePermission = "0755";
	private $newModule ;
	private $templateModule ;
	private $status=array();

	public function setValue($val){
		$this->value = $val;
	}
	
	private function getValue(){
		return $this->value;
	}
	
	private function getNewModule(){
		return $this->newModule;
	}
	
	private function getTemplateModule(){
		return $this->templateModule;
	}
	
	private function setNewModule($val){
		$this->newModule=$val;
	}
	
	private function setTemplateModule($val){
		$this->templateModule=$val;
	}
	
	private function getFolderPermission(){
		return $this->folderPermission;
	}
	
	private function getFilePermission(){
		return $this->filePermission;
	}
	
	public function __construct()
    {
		$this->load->dbforge();
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
	public function listExtensionModule()
	{
		$query = $this->db->select()
				->from($this->tbl_admin_extension)
				->where('extension_type','module')
				->order_by("extension_seq","asc");
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	public function add()
	{
		/* ขั้นตอนการสร้างโมดูลใหม่ ( เลือกแบบที่สร้างมาจากต้นแบบ)
		 * 1. หาชื่อ โมดูล extension และ ชื่อโมดูลใหม่ที่สร้างขึ้นมา
		 * 2. copy folder จาก extension ทั้งหมดมาสร้างเป็นโมดูลใหม่ก่อน
		 * 3. ทำการอ่าน controller เพื่อเปลี่ยนข้อมูลภายใน controller
		 * 4. และเปลี่ยนข้อมูลภายใน view ตามที่มี controller ด้วย
		 */
		
		$val = $this->getValue();
		
		if($val['captcha']=='')
		{
			$newmodule = preg_replace('/[[:space:]]+/', '', trim(strtolower($val['module_name'])));
			$results = false;
			if($val['module_buildfrom'] == 1){ // add module แบบสร้างโฟลเดอร์เอง
			
				$table = '';
				$lang = '';
				$results = $this->checkValidModule($newmodule); //true : พบโฟลเดอร์โมดูลที่จะสร้างสามารถ add ได้
				
			}else if($val['module_buildfrom'] == 2){  // add module แบบเลือกจากต้นแบบ
				
				$query = $this->db->select('extension_name')
						->from($this->tbl_admin_extension)
						->where('extension_id',$val['extension_id']);
				$query = $this->db->get();
				$result = $query->row_array();
				list($table,$lang,$results) = $this->newModule($result['extension_name'],$newmodule); // return table and lang
			}
			if($results){
				$module_id = $this->bflibs->getLastID($this->tbl_admin_module,'module_id');
				$module_seq = $this->bflibs->getLastIdWithGroup($this->tbl_admin_module,'module_seq','module_type','2');
				$module_db = (is_array($table) && !empty($table))?implode('|',$table):$table;
				$data = array("module_id"=>$module_id,
						"module_name"=>$newmodule,
						"module_desc"=>$val['module_desc'],
						"module_type"=>2, /*ระบุเป็น โมดูลประเภทอื่นๆ*/
						"module_buildfrom"=>$val['module_buildfrom'],
						"module_db"=>$module_db,
						"module_lang"=>$lang,
						"module_seq"=>$module_seq,
				);
				$this->db->insert($this->tbl_admin_module,$data);
			}
			return $results;
		}
	}
	/* RENAME
	-----------------------------------------------------------------------------------------*/
	private  function newModule($templateModule,$newModule)
	{
		if($newModule != '')
		{
			$errpr = '';
			$this->setTemplateModule($templateModule);
			$this->setNewModule($newModule);
			$source_path = DIR_FILE.'application/extensions/module/'.$this->getTemplateModule();
			$new_path = DIR_FILE.'application/modules/'.$this->getNewModule();
			
			/* copy folder ทั้งหมดมาสร้างเป็นโมดูลใหม่ก่อน */
			$this->status['copyfolder'] = $this->copyFolder($source_path,$new_path);
			/* New file */
			$path_controller = $new_path.'/controllers/';
			$path_view = $new_path.'/views/';
			$controllers = $this->readfile($path_controller);
			
			if(!empty($controllers)){
				$searchCont=array(ucfirst($this->getTemplateModule()),strtolower($this->getTemplateModule()));
				$replaceCont=array(ucfirst($this->getNewModule()),strtolower($this->getNewModule()));
				
				/* ทำการเปิดไฟล์เพื่อทำการแก้ไขส่วนต่างๆให้เป็นชื่อของโมดูลใหม่  Controller,Model,View */
				foreach ($controllers as $controller)
				{
					$info = pathinfo($controller);
					$new_controller = $path_controller.$controller;
					$new_view = $path_view.$info['filename'].'/';
					
					$this->status['replace_controller'][$controller] = $this->replaceFile($new_controller,$searchCont,$replaceCont);
					$this->status['replace_view'][$info['filename']] = $this->replaceView($new_view,$searchCont,$replaceCont);
				}
				$new_sql = $new_path.'/'.$this->getNewModule().'.sql';
				$this->status['replace_sql'] = $this->replaceSql($new_sql,$searchCont,$replaceCont);
					
			}else{
				$errpr .= 'รูปแบบโมดูลที่สร้างไม่ถูกต้อง ไม่พบ controller<br>';
			}
			
			$path_model = $new_path.'/models/';
			$models = $this->readfile($path_model);
			if(!empty($models)){
				foreach($models as $model){
					$new_model = $path_model.$model;
					$this->status['replace_model'][$model] = $this->replaceFile($new_model,$searchCont,$replaceCont);
				}
			}else{
				$errpr .= 'รูปแบบโมดูลที่สร้างไม่ถูกต้อง ไม่พบ model<br>';
			}
			
			/* การจัดการกับ lang
			------------------------------------------------------------------------------*/
			$lang_file = 0;
			$languages = $this->readfile($new_path.'/language/');
			if(!empty($languages)){
			
				$lang_file = 1;
				$app_lang = DIR_FILE.'application/language/';
				
				foreach($languages as $lang)
				{
					$new_language = $new_path.'/language/'.$lang.'/'.$this->getNewModule().'_lang.php';
					$this->replaceFile($new_language,$searchCont,$replaceCont);
					$this->copyFolder($new_path.'/language/',$app_lang);
				}
			}
			$this->remove_dir($new_path.'/language/');
			/* ------------------------------------------------------------------------- */
			
			/* การจัดการกับ Folder Public
			------------------------------------------------------------------------------*/
			$public = $this->readfile($new_path.'/public/');
			if(!empty($public)){
			
				$pb_module = DIR_FILE.'public/module/';
				
				foreach($public as $pb)
				{
					switch($pb){
						case 'module' :{
							$new_pb_module = $new_path.'/public/'.$pb.'/'.$this->getNewModule();
							$this->copyFolder($new_pb_module,$pb_module);
							break;
						}
					}
				}
			}
			$this->remove_dir($new_path.'/public/');
			return array($this->createTable($new_sql),$lang_file,true);
		}
	}
	public function chk_modulename($module_name)
	{
		$query = $this->db->select('module_name')
				->from($this->tbl_admin_module)
				->where('module_name',$module_name);
		$query = $this->db->get();
		$result = $query->row_array();
		if(empty($result)){
		
			$app_lang = DIR_FILE.'application/language/';
			$languages = $this->readfile($app_lang);
			if(!empty($languages)){
				foreach($languages as $lang)
				{
					$path_lang = $app_lang.$lang.'/'.$module_name.'_lang.php';
					if(file_exists($path_lang)){
						return 'false';
					}
				}
			}
			return 'true';
		}
		else{
			return 'false';
		}
	}
	
	public function checkValidModule($module_name)
	{
		$pathModule = DIR_FILE."application/modules/".$module_name;
	 	if(file_exists($pathModule)){
	 	
	 		$extension = $this->readfile($pathModule);
		    if(in_array('controllers',$extension) && in_array('models',$extension) && in_array('views',$extension))
		    {
		    	return true;
		    }
	 	}else return false;
	}
	public function delete($id)
	{
		$query = $this->db->select(array('module_name','module_type','module_db'))
				->from($this->tbl_admin_module)
				->where('module_id',$id);
		$query = $this->db->get();
		$result = $query->row_array();
		
		/*ไม่สามารถลบโมดูลที่เป็น โมดูลระบบได้*/
		if($result['module_type']!='1')
		{
			/*  remove folder module
			--------------------------------------------------------------------*/
			if($result['module_name'] != ''){
				
				$path = DIR_FILE.'application/modules/'.$result['module_name'];
				$this->remove_dir($path);
			}
			/*  remove data base
			--------------------------------------------------------------------*/
			if($result['module_db'] != ''){
				
				$tables = explode('|',$result['module_db']);
				foreach($tables as $table){
					
					$this->dropTable($table);
				}
			}
			/*  remove file language
			--------------------------------------------------------------------*/
			$module_lang = $this->bflibs->getOne('admin_module','module_lang','module_id',$id);
			if($module_lang == 1){
				$app_lang = DIR_FILE.'application/language/';
				$languages = $this->readfile($app_lang);
				if(!empty($languages)){
					foreach($languages as $lang)
					{
						$path_lang = $app_lang.$lang.'/'.$result['module_name'].'_lang.php';
						unlink($path_lang);
					}
				}
			}
			/*  remove folder public/module
			--------------------------------------------------------------------*/
			$pb_module = DIR_FILE.'public/module/'.$result['module_name'];
			if(file_exists($pb_module)){
				$this->remove_dir($pb_module);
			}
			/*  remove db self
			--------------------------------------------------------------------*/
			$this->db->where('module_id',$id);
			$this->db->delete($this->tbl_admin_module);
		}
	}
	private function dropTable($table_name)
	{
		$this->dbforge->drop_table($table_name);
	}
	
	private function replaceFile($file, $searchCont,$replaceCont)
    {
    	$status = 'false';
    	if (file_exists($file))
		{
		    $handle = @fopen($file, "r");
			$contents="";
			if ($handle) {
			    while (!feof($handle)) {
			        $buffer= fgets($handle, 4096);
			      	$contents.=$buffer;
			    }
			    fclose($handle);
			}
			
			$handle = fopen($file, "w+");
			$status = fwrite($handle,str_replace($searchCont,$replaceCont,$contents));
			fclose($handle);
		}
		return $status;
    }
	private function replaceView($folder, $searchCont, $replaceCont)
    {
    	$dirHandle=opendir($folder);
    	$status = 'false';
	    while($file=readdir($dirHandle))
	    {
	        if($file!="." && $file!="..")
	        {
	        	$path = $folder.$file;
				if(is_file($path)) $status = $this->replaceFile($path, $searchCont, $replaceCont);			
	        }
	    }
	    closedir($dirHandle);
	    return $status;
    }
	private function replaceSql($file, $searchCont,$replaceCont)
    {
    	$result = 'false';
    	if (file_exists($file))
		{
		    $handle = @fopen($file, "r");
			$contents="";
			if ($handle) {
			    while (!feof($handle)) {
			        $buffer= fgets($handle, 4096);
			      	$contents.=$buffer;
			    }
			    fclose($handle);
			}
			
			$handle = fopen($file, "w+");
			fwrite($handle,'^',1);
			$result = fwrite($handle,str_replace($searchCont,$replaceCont,$contents));
			fclose($handle);
		}
		return $result;
    }
	private function readfile($path)
    {
    	$fileArr = array();
    	if(file_exists($path))
    	{
	    	$dirHandle=opendir($path);
		    while($file=readdir($dirHandle))
		    {
		        if($file!="." && $file!="..")
		        {
		        	$fileArr[]=$file;
		        }
		    }
		    closedir($dirHandle);
    	}
	    return $fileArr;
    }
	private function createTable($file){
    	$allTable = '';
		if (file_exists($file))
		{
		    $handle = @fopen($file, "r");
			$query="";
			if ($handle) {
			    while (!feof($handle)) {
			        $buffer= fgets($handle, 4096);
			      	$query.=$buffer;
			    }
			    fclose($handle);
			}
			$tb = explode('^',$query);
			if(!empty($tb[1])){
				$allTable = array();
				$tables = explode('#',$tb[1]);
				foreach ($tables as $table)
				{
					$queriesAll = explode('|',$table);
					foreach($queriesAll as $key=>$queries){
						
						if($key == 0){
							$allTable[] = trim($queries); // Name Table
						}else{
							if(trim($queries)!='')$this->db->query($queries); // Drop, Create, Insert
						}
					}
				}
				@unlink($file);
			}
		}
		
		return $allTable;
    }
	private function copyFolder($source, $dest)
    {
		$source = str_replace("//","/",$source);
		$dest = str_replace("//","/",$dest);
		
		$result=false;

		if (is_file($source)) {
		
		    if ($dest[strlen($dest)-1]=='/') {
		        if (!file_exists($dest)) {
		            cmfcDirectory::makeAll($dest,$this->getFolderPermission(),true);
		        }
		        $basename = $this->changeName(basename($source));
		        $__dest=$dest."/".$basename;
		    } else {
		    	$basename = dirname($dest).'/'.$this->changeName(basename($dest));
		        $__dest=$basename;
		        //$__dest=$dest;
		    }
	
		    copy($source, $__dest);
		    @chmod($__dest,$this->getFilePermission());
			
		} elseif(is_dir($source)) {
		 
		    if ($dest[strlen($dest)-1]=='/') {
		   
		        if ($source[strlen($source)-1]=='/') {
		            //Copy only contents
		        } else {
		            //Change parent itself and its contents
		            $dest=$dest.basename($source);
		            @mkdir($dest);
		            chmod($dest,$this->getFilePermission());
		        }
		    } else {
		    
		        if ($source[strlen($source)-1]=='/') {
		            //Copy parent directory with new name and all its content
		            @mkdir($dest,$this->getFolderPermission());
		            chmod($dest,$this->getFilePermission());

		        } else {
		            //Copy parent directory with new name and all its content   
		            if(basename($dest) == $this->getTemplateModule())
		            {
		            	$dest = dirname($dest).'/'.$this->changeName(basename($dest));
		            }
		            @mkdir($dest,$this->getFolderPermission());
		            @chmod($dest,$this->getFilePermission());
		        }
		    }

		    $dirHandle=opendir($source);
		    while($file=readdir($dirHandle))
		    {
		        if($file!="." && $file!="..")
		        {
		             if(!is_dir($source."/".$file)) {
		               $__dest=$dest."/".$file;
		            } else {
		                $__dest=$dest."/".$file;
		            }			
		            $this->copyFolder($source."/".$file, $__dest);
		        }
		    }
		    closedir($dirHandle);
		}
		return;
    }
    private function changeName($basename){
    	
    	$patterns = '/'.$this->getTemplateModule().'/';
    	return preg_replace($patterns,$this->getNewModule(),$basename);;
    }
	private function remove_dir($dir)
	{
		if(is_dir($dir))
		{
		    $dir = (substr($dir, -1) != "/")? $dir."/":$dir;
		    $openDir = opendir($dir);
		    
		    while(($file = readdir($openDir)) !== false)
		    {
		    	if(!in_array($file, array(".", "..")))
		    	{
		    		if(!is_dir($dir.$file))
			        {
			        	@unlink($dir.$file);
			        }
			        else
			        {
			          	$this->remove_dir($dir.$file);
			        }
		    	}
		    }
		    closedir($openDir);
		    rmdir($dir);
		}
	}
}
?>