<?php
/***********************************************************************
	* New Account Auto Validator
************************************************************************/
if(isset($_REQUEST['ac']))
{
	$reg_ac	= trim(htmlentities(addslashes($_REQUEST['ac'])));
	$reg_mod   = strtolower(substr($reg_ac,0,3));
	
	//RQL - Crop / Equipment Listing Request
	//ADV - Advert Post
	//SST - Share Stories
	//SGN = Account Signup
	
	if($reg_mod == 'sgn')
	{
		$clsVerify = new clsVerify;
		$result 	= $clsVerify->verifySignupAccount($reg_ac);
		if($result['result'] === 1) { 
			$redirect ="home/?fc=signin&qst=106&ureg=".$result['user']; 
		  	?><script>location.href = "<?php echo $redirect; ?>"; </script><?php exit;
		}
	}
}
/***********************************************************************
	* New Account Auto Validator
************************************************************************/


$pg_title = "";
$my_alias_h1 = ""; $my_alias_h2 = ""; $my_alias_h3 = ""; $my_alias_h4 = ""; $my_alias_h5 = ""; 
$menu_brief = "";
$my_intro   = "";
$my_breadcrumb = "";
$comMenuID 	  =  $comMenuSection =  $comMenuType    =  $comMenuAccess  = "";

$meta_image 	= SITE_LOGO;
$meta_desc  	 = META_DESC;
$meta_keywords = META_KEYS;

$com_active  = ''; //$com;
$cont_active = '';
$currCont    = array();

$cont_sector_id	= '';
$cont_project_id   = '';
	

$my_request = str_replace(SITE_FOLDER, "", $_SERVER['REQUEST_URI']); //echobr($_SERVER['REQUEST_URI']);
$qpos = strripos($my_request,"?" );

if($qpos) 
{
	$urlQueryA = substr($my_request,0, strripos($my_request,"?" )); 
	$urlQueryB = substr($my_request, strripos($my_request,"?" )+1);
	parse_str(html_entity_decode($urlQueryB), $urlQueryArr);
	if (array_key_exists('tk', $urlQueryArr)) {
		unset($urlQueryArr['tk']);
	}
	if(substr($urlQueryA,strlen($urlQueryA)-1,1)=="/") {$urlQueryStr="?";} else { $urlQueryStr="/?"; }
	
	foreach($urlQueryArr as $qkey => $qval) 
	{ $urlQueryStr .= $qkey.'='.$qval.'&'; } 
	
	$my_request = $urlQueryA.$urlQueryStr;
}

//echobr(SITE_FOLDER); //exit;
define('REF_ACTIVE_URL', $my_request);
$_SESSION['sess_oc_active_url'] = $my_request;

if ($item)
{
	$currCont 	  = master::$contMain['full'][$item];
	$com_active 	= $currCont['id_menu'];	
	$artSection 	 = $currCont['id_section'];
	$cont_sector_id	= $currCont['sector_id'];
	$cont_project_id   = $currCont['project_id'];
}
elseif($com)
{
	//echobr($com);
	$menu_link = htmlspecialchars($com);
	if (array_key_exists($menu_link, master::$menuBundle['seo'])) {
		$com_active = master::$menuBundle['seo'][$menu_link]; 
	}
	else
	{
		/*$url_path = ltrim($my_request, '/');   
		$url_pats = explode('/', $url_path);  
		
		if(count($url_pats) > 0) 
		{
			$menu_link = $url_pats[0];
			if (array_key_exists($menu_link, master::$menuBundle['seo'])) {
				$com_active = master::$menuBundle['seo'][$menu_link]; 
			}
		}*/
		$com_active = 'not-found';
	}
}
else
{
	$com = 1; $com_active = $com;
}

//echobr('com:'.$com.' - com_active:'.$com_active.' - item:'.$item);
if($com_active == 'not-found') 
{
	$my_header   		= 'Page Not Found';
	$my_page_head	 = $my_header;
	$my_redirect 	  = '404.php';
	$my_breadcrumb    = "<a href=\"./\">Home</a> &nbsp; / &nbsp; ";
}
else
{ 	
	$my_header 		= master::$menuBundle['full'][$com_active]['title'];
	$my_alias 		 = master::$menuBundle['full'][$com_active]['title_alias'];
	$my_redirect 	  = master::$menuBundle['full'][$com_active]['link_menu'];
	$seo_name		 = master::$menuBundle['full'][$com_active]['menu_seo_name'];
	$meta_seolink	 = SITE_DOMAIN_LIVE.$seo_name.'/';
	
	$my_rdr_path 	  = $seo_name.'/';
	
		
	$comMenuID 	  = master::$menuBundle['full'][$com_active]['id'];
	$comMenuSection = master::$menuBundle['full'][$com_active]['id_section'];
	$comMenuType    = master::$menuBundle['full'][$com_active]['id_menu_type'];
	$comMenuAccess  = master::$menuBundle['full'][$com_active]['id_access'];
	
	if($my_alias <> '') { $my_header = $my_alias; }
	
	if($my_redirect == 'index.php') { $my_header = ""; }
	if($my_redirect == 'search.php' or $this_page == 'search.php') { $my_header = "Site Search"; $my_rdr_path = $this_page; }
	if($my_redirect == 'member.php' or $this_page == 'member.php') { $my_header = "Members"; }
	if($my_redirect == 'accounts.php' or $my_redirect == 'profile.php') { $my_header = "Member Area"; }
	if($my_redirect == 'result.php' or $this_page == 'result.php') { $my_header = "Notifications"; }
	if($my_redirect == 'mailing.php' or $this_page == 'mailing.php') { $my_header = "Mailing Subscription"; }
	if($my_redirect == 'events_register.php' or $this_page == 'events_register.php') { $my_header = $my_header ." Online Booking"; }
	if($my_header == 'order') { $my_header = "Place Order"; }
		
	
		
	$my_page_head	 = $my_header;
	
	
	
	if ($item)
	{
		
		if($com_active == 1) { }
		
		//$com_active 	= $currCont['id_menu'];	
		$my_page_head  = master::$menuBundle['full'][$com_active]['title'];
		$my_redirect   = master::$menuBundle['full'][$com_active]['link_menu'];
		
		if($currCont['link_menu'] <> $my_redirect) 
		{ $my_redirect = $currCont['link_menu']; }
		
		
		
		$meta_title 		  = ucfirst($currCont['title']);
		$meta_desc 	       = trim(smartTruncateNew(strip_tags_clean($currCont['article']), 100, '.'));
		
		$my_header = $meta_title;
		$pg_title  = $meta_title;
		$my_alias_h5 = $meta_title; // . " &rsaquo; ";		//strtolower()
		
		if(preg_match('/<img[^>]+\>/i',$currCont['article'],$regs)) 
		{
			if(preg_match('/src="([^"]*)"/i', $regs[0], $image_array ))
			{
				$meta_image 	   = SITE_DOMAIN_LIVE . urldecode($image_array[1]);  
			}
		}else {
			$meta_image  = $ddSelect->getContentImage($item);
		}
		
		$meta_seolink	   = SITE_DOMAIN_LIVE.$item.'/'.$currCont['link_seo'].'/';
	}
	
	
	
	//$my_header .= ' - ';	
		
	$thisSite =  ($my_header <> "")? $my_header.' - '. SITE_TITLE_SHORT : SITE_TITLE_LONG;		
	$pg_title1 = "<a href=\"./\">Home</a> &nbsp; / &nbsp; ";
	
	
	define('RDR_REF_PATH', $my_rdr_path);
	
	
	//$nav_Menu_Main = $dispData->buildMenu_Main($com_active, 1);
	$my_breadcrumb = $pg_title1 . $dispData->buildMenu_Crumbs($com_active) . $my_alias_h5 ;

}
//$nav_FootLinks = implode("", $dispData->linkToFoot);


$projectStatusClass = array(
	'Completed' => 'completed',
	'On Schedule/Ahead of Schedule' => 'on_schedule',
	'Commenced' => 'set_medium',
	'Not Started/Behind Schedule' => 'behind_schedule',
	'Ahead of Schedule' => 'on_schedule',
);

//echo $this_page.REF_QSTR;

include('cls.paginator.php');
				
?>