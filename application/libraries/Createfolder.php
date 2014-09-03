<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Createfolder{
	private $modulesName;
	private $controllerName;
	private $actionName;
	private $permit = "0777";
	
	private $folderPermission = "0755";
	private $filePermission = "0755";
	private $newModule ;
	private $templateModule ;
	
	private function getPermit(){
		return $this->permit;
	}

	private function getModulesName() {
	
		return $this->modulesName;
	}

	private function getControllerName() {
		return $this->controllerName;
	}

	private function getActionName() {
		return $this->actionName;
	}

	public function setModulesName($modulesName) {
		$this->modulesName = $modulesName;
	}

	public function setControllerName($controllerName) {
		$this->controllerName = $controllerName;
	}

	public function setActionName($actionName) {
		$this->actionName = $actionName;
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

	public function __construct($params){

		$this->setModulesName($params['module']);
		$this->setControllerName($params['controller']);
		$this->setActionName($params['action']);
	}
	
	public function make(){
		$m = DIR_FILE.DS.'public'.DS.'upload'.DS.$this->getModulesName();
		if(!file_exists($m)){
			mkdir($m);
			chmod($m,$this->getPermit());
			mkdir($m."/".$this->getControllerName());
			chmod($m."/".$this->getControllerName(),$this->getPermit());
		}else{
//			if(!file_exists($m."/".$this->getControllerName())){
//				mkdir($m."/".$this->getControllerName());
//				chmod($m."/".$this->getControllerName(),$this->getPermit());
//			}
		}
	}
	
	
	public function upload()
	{
		$path = 'public/tmp/installs/user/';
		$source = DIR_FILE.$path;
		if(!file_exists($source))
		{
			mkdir($source,$this->getFolderPermission());
		    chmod($source,$this->getFilePermission());
		}
		$config['upload_path'] = DIR_FILE.$path;
		$config['allowed_types'] = 'zip';
		$config['overwrite']  = TRUE;
		
		$this->load->library('upload', $config);
	
		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors("<span>","</span>"));
			return array(false,$error);
		}
		else
		{
			$data = $this->upload->data();
			$this->extractFile($data['full_path'],$path);
			return $this->install($source.$data['raw_name'],true);
		}
	}
	private function extractFile($full_path,$path)
	{
		$ext = $this->bflibs->getExt($full_path);
		if($ext == 'zip')
		{
		    $zip = zip_open($full_path);
		    while($zip_entry = zip_read($zip))
		    {
		        $entry = zip_entry_open($zip,$zip_entry,'r');
		        $filename = zip_entry_name($zip_entry);
		        $target_dir = $path.substr($filename,0,strrpos($filename,'/'));
		        $filesize = zip_entry_filesize($zip_entry);
		        if (is_dir($target_dir) || mkdir($target_dir, $this->getFolderPermission()))
		        {
		            if ($filesize > 0)
		            {
		                $contents = zip_entry_read($zip_entry, $filesize);
		                file_put_contents($path.$filename,$contents);
		            }
		        }
		    }
		}
	}
	
	private function checkExtension($path,$raw_name)
	{
		$query = $this->db->select('extension_name')
				->from($this->tbl_admin_extension)
				->where("extension_name",$raw_name);
		$query = $this->db->get();
		$result = $query->row_array();
		
		if(empty($result))
		{
			$path2Chk = DIR_FILE.$path.$raw_name;
		    $extension = $this->readfile($path2Chk);
		    
		    if(in_array('controllers',$extension) && in_array('models',$extension) && in_array('views',$extension))
		    {
		    	return 'module';
		    }else if(preg_match('/_lang.php$/',$extension[0],$output))
		    {
		    	return 'language ';
		    }else{
		    	return 'undefined';
		    }
		}
	    return '';
	}

	private  function removeFile($templateModule,$path,$extension_type,$delsource)
	{
		if(!empty($extension_type) && $extension_type!='undefined')
		{
			$this->setTemplateModule($templateModule);
			$this->setNewModule($templateModule);
			$source_path = str_replace("\\", "/", DIR_FILE.$path.$this->getTemplateModule());
			$new_path='';
			
			switch (trim($extension_type))
			{
				case 'module' :{
					$new_path = str_replace("\\", "/", DIR_FILE.'application/extensions/module/'.$this->getTemplateModule());
					break;
				}
				case 'language' :{
					$new_path = str_replace("\\", "/", DIR_FILE.'application/language/'.$this->getTemplateModule());
					break;
				}
			}
			/* copy folder ทั้งหมดมาสร้างเป็นโมดูลใหม่ก่อน จะต้องไม่เป็น pathเดียวกัน */
			if($source_path != $new_path)
			{
				$this->copyFolder($source_path,$new_path);
			}
		}
		/* ลบไฟล์ source ทิ้ง */
		if($delsource)
		{
			$this->remove_dir(DIR_FILE.$path);
		}
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
	
		    $result=copy($source, $__dest);
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
		            $result=$this->copyFolder($source."/".$file, $__dest);
		        }
		    }
		    closedir($dirHandle);
		   
		} else {
		    $result=false;
		}
		return $result;
    }
    private function changeName($basename){
    	switch($basename){
    		case $this->getTemplateModule().'.php':{$returnName = $this->getNewModule().'.php';break;}
    		case $this->getTemplateModule().'model.php':{$returnName = $this->getNewModule().'model.php';break;}
    		case $this->getTemplateModule().'.sql':{$returnName = $this->getNewModule().'.sql';break;}
    		case $this->getTemplateModule():{$returnName = $this->getNewModule();break;}
    		default:{$returnName = $basename;break;}
    	}
    	return $returnName;
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
	private  function newModule($templateModule,$newModule)
	{
		if($newModule != '')
		{
			$this->setTemplateModule($templateModule);
			$this->setNewModule($newModule);
			$source_path = DIR_FILE.'application/extensions/module/'.$this->getTemplateModule();
			$new_path = DIR_FILE.'application/modules/'.$this->getNewModule();
			
			/* copy folder ทั้งหมดมาสร้างเป็นโมดูลใหม่ก่อน */
			$this->copyFolder($source_path,$new_path);
			
			/* New file */
			$path_controller = $new_path.'/controllers/';
			$path_view = $new_path.'/views/';
			$controllers = $this->readfile($new_path.'/controllers/');
			$searchCont=array(ucfirst($this->getTemplateModule()),strtolower($this->getTemplateModule()));
			$replaceCont=array(ucfirst($this->getNewModule()),strtolower($this->getNewModule()));
			
			foreach ($controllers as $controller)
			{
				$info = pathinfo($controller);
				$new_controller = $new_path.'/controllers/'.$controller;
				$new_view = $new_path.'/views/'.$info['filename'].'/';
				
				$this->replaceFile($new_controller,$searchCont,$replaceCont);
				$this->replaceView($new_view,$searchCont,$replaceCont);
			}
			
			$new_model = $new_path.'/models/'.$this->getNewModule().'model.php';
			$new_sql = $new_path.'/'.$this->getNewModule().'.sql';
			
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
			/* ------------------------------------------------------------------------- */
			

			/* ทำการเปิดไฟล์เพื่อทำการแก้ไขส่วนต่างๆให้เป็นชื่อของโมดูลใหม่  Controller,Model,View */
			
			$this->replaceFile($new_model,$searchCont,$replaceCont);
			$this->replaceFile($new_sql,$searchCont,$replaceCont);
			return array($this->createTable($new_sql),$lang_file);
		}
	}
	private function replaceFile($file, $searchCont,$replaceCont)
    {
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
			fwrite($handle,str_replace($searchCont,$replaceCont,$contents));
			fclose($handle);
		}
    }
	private function replaceView($folder, $searchCont, $replaceCont)
    {
    	$dirHandle=opendir($folder);
	    while($file=readdir($dirHandle))
	    {
	        if($file!="." && $file!="..")
	        {
	        	$path = $folder.$file;
				$this->replaceFile($path, $searchCont, $replaceCont);			
	        }
	    }
	    closedir($dirHandle);
    }
	
	private function createTable($file){
    	
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
			
			$tables = explode('#',$query);
			$allTable = array();
			foreach ($tables as $table)
			{
				$queries = explode('|',$table);
				$allTable[] = trim($queries[0]); // Name Table
				$this->db->query($queries[1]); // Drop
				$this->db->query($queries[2]); // Create
				if(trim($queries[3])!='')$this->db->query($queries[3]); // Insert
			}
			@unlink($file);
			return $allTable;
		}
    }
}
?>
