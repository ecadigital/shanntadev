<link rel="stylesheet" type="text/css" href="<?php echo DIR_PUBLIC?>module/language/css/style.css" media="all" />
<script type="text/javascript" src="<?php echo DIR_PUBLIC?>module/language/js/function.js"></script>

<?php 
$this->model = $this->load->model('language/Languagemodel');
$listLang = $this->model->listLanguageFront();
include(DIR_FILE.'application/config/routes.php');
$realUrl = (isset($route[$_SESSION['currenturl']]))?$route[$_SESSION['currenturl']]:$_SESSION['currenturl'];

$module = $this->request->getModuleName();
$action = $this->request->getActionName();
//$realUrl = ($module=='') ? '' : $module.'/frontend/'.$action;

?>
<div class="language" id="switchlang">
<?php if(!empty($listLang)){
		$defaultLang = $this->bflibs->getDefaultLangId();
		foreach($listLang as $lang){
			$icon = basename($lang['language_icon']);
			$url=(empty($realUrl))?"home/home/index/":$realUrl."/";
			$pageLink = DIR_ROOT.$url."lang/".$lang['language_id'];
			
			$class = ($defaultLang == $lang['language_id']) ? 'select_'.$lang['language_id'] : '';
?>
<a id="lang_<?php echo $lang['language_id'];?>" title="<?php echo $lang['language_name'];?>" class="switchlang" data-default="<?php echo ($defaultLang == $lang['language_id'])?true:'';?>" href="<?php echo $pageLink;?>"><img src="<?php echo DIR_PUBLIC."upload/language/thumbnails/".$icon?>" /></a>
<?php }}?>
</div>