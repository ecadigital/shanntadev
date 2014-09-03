<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class  Bootstrap {
	function __construct()
	{
		$this->ci =& get_instance();
	}
	function preloading()
	{
		$this->ci->config->set_item('language', $this->ci->bflibs->getDefaultLang());
		$all_langs =$this->ci->bflibs->getResult('admin_module','module_name','module_lang','1');
		if(!empty($all_langs)){
			foreach($all_langs as $lang)
			{
				$this->ci->lang->load($lang['module_name'],$this->ci->bflibs->getDefaultLang());
			}
		}
		$this->ci->lang->load('web',$this->ci->bflibs->getDefaultLang());
		$this->ci->load->helper('language');
	}
}
?>