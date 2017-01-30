<?php

class data_arrays extends master
{
	
	public $menuMain = array();
	public $menuLong = array();
	public $menuSubs = array();
	
	public $menuMainSelect;
	
	public $menuGroups = array();
	public $menuSelect = array();
	
	//public $menuDepts = array();
	
	public $menuMain_portal = array();
	public $menuLong_portal = array();
	
	public $comArr = array();
	
	//public $contMain = array();
	public $contLong = array();
	public $contMainExtras = array();
	
	public $contFacts = array();
	public $contTabsDept = array();
	public $contActivities = array();
	public $contPlaces = array();
	public $contEvents = array();
	public $contNews = array();
	
	
	public $contPrograms = array();
	
	public $linkToHead = array();
	public $linkToQuick = array();
	public $linkToFoot = array();
	public $linkTabsDept = array();
	public $linkTabsCircuit = array();
	public $linkTabsHome = array();
	public $linkTabsCustom = array();
	
	private $link_temp = array();
	
	public $bannMain = array();
	
	public $navMainCurrent;
	
	var $menu;
	var $key;
	
	public $coom;
	public $coom_b;
	
	var $out;
	var $parent;
	var $h_lnk;
	var $h_cnt;
	var $sel_crit;
	var $com_active;
	
	
	
	
	/*
	@START -- BUILD: Content Array
	***********************************************************/
	
	function buildContent_Arr($menu_id='', $county_id='')
	{
		
		$masterContent = array();
		$sq_crit = "";
		if($menu_id <> '') { $sq_crit = " WHERE `menu_id` = ".$this->quote_si($menu_id)." "; }
			
		$sq_contlinks = "SELECT `content_id`, `content_title`, `content_seo`, `content_article`, `content_created`, `content_attributes`, `content_tags`, `date_modified`, `id_access`, `id_section`, `published`, `seq`, `menu_id`, `county_id`, `menu_title`, `menu_link`, `section_link`, `section_title` FROM `oc_vw_content` ".$sq_crit."; ";


		$rs_contlinks = $this->dbQuery($sq_contlinks);
		$rs_contlinks_count = $this->recordCount($rs_contlinks);

		if($rs_contlinks_count>=1)
		{
			while($cn_contlinks_a = $this->fetchRow($rs_contlinks, 'assoc'))
			{
				$cn_contlinks  = array_map("clean_output", $cn_contlinks_a);
				
				if( strlen($cn_contlinks['menu_link']) <= 5 && $cn_contlinks['menu_link'] <> "#" ) 
				{ $link = $cn_contlinks['section_link']; } else 
				{ $link = $cn_contlinks['menu_link']; }


				$content_id	  		= $cn_contlinks['content_id'];
				$cDate	  			= strtotime($cn_contlinks['content_created']);
				$menu_id 			= $cn_contlinks['menu_id'];
				$county_id 			= $cn_contlinks['county_id'];
				$id_section 		= $cn_contlinks['id_section'];
				$content_attributes = @unserialize($cn_contlinks['content_attributes']);

				$cn_contlinks['content_created'] 		= $cDate;
				$cn_contlinks['content_attributes'] 	= $content_attributes;
				$cn_contlinks['content_link'] 			= $link;

				$masterContent['full'][$content_id] 					= $cn_contlinks;
				$masterContent['section'][$id_section][$content_id] 	= $content_id;
				$masterContent['parent'][$menu_id][$content_id] 		= $content_id;



			}

			master::$contMain	= $masterContent;
			//master::$menuToContents	 = @$masterContent['parent'];
		}

			
		
	}
	
	
	
	
	/*
	@START -- BUILD: Menu Array
	***********************************************************/
	
	function buildMenu_Arr()
	{
		$masterMenus = array();
		
		$sq_mainlinks = "SELECT
    `oc_dt_menu`.`menu_id`
    , `oc_dt_menu`.`menu_title`
    , `oc_dt_menu`.`menu_seo`
    , `oc_dt_menu`.`menu_attributes`
    , `oc_dt_menu`.`menu_href`
    , `oc_dt_menu`.`menu_image`
    , `oc_dt_menu`.`menu_date`
    , `oc_dt_menu`.`menu_tags`
    , `oc_dt_menu`.`id_type_menu`
    , `oc_dt_menu`.`id_section`
    , `oc_dt_menu`.`id_access`
    , `oc_dt_menu`.`post_by`
    , `oc_dt_menu`.`published`
    , `oc_dt_menu_parent`.`menu_parent_id`
    , `oc_dt_conf_sections`.`section_title`
    , `oc_dt_conf_sections`.`section_link`
    , `oc_dt_conf_menu_type`.`menutype`
FROM
    `oc_dt_menu`
    LEFT JOIN `oc_dt_menu_parent` 
        ON (`oc_dt_menu`.`menu_id` = `oc_dt_menu_parent`.`menu_id`)
    INNER JOIN `oc_dt_conf_sections` 
        ON (`oc_dt_menu`.`id_section` = `oc_dt_conf_sections`.`section_id`)
    INNER JOIN `oc_dt_conf_menu_type` 
        ON (`oc_dt_menu`.`id_type_menu` = `oc_dt_conf_menu_type`.`menutype_id`)
WHERE (`oc_dt_menu`.`published` =1)
ORDER BY `oc_dt_menu`.`seq` ASC, `oc_dt_menu`.`id_type_menu` ASC, `oc_dt_menu_parent`.`menu_parent_id` ASC, `oc_dt_menu`.`menu_title` ASC;"; 

		$rs_mainlinks = $this->dbQuery($sq_mainlinks);
		$rs_mainlinks_count = $this->recordCount($rs_mainlinks);

		//$date_update = 0;

		if($rs_mainlinks_count>=1)
		{
			$menu_loop=1;
			while($cn_mainlinks = $this->fetchRow($rs_mainlinks, 'assoc'))
			{

				//if(intval($cn_mainlinks['date_update']) > $date_update)
				//{ $date_update 	= intval($cn_mainlinks['date_update']); }

				$menu_link 		= $cn_mainlinks['menu_href'];
				$section_link 	 = $cn_mainlinks['section_link'];

				if(strlen($menu_link) >= 2 or $menu_link == "#" ) 
				{ $link = $menu_link; } else { $link = $section_link; }

				$id_link 		  = $cn_mainlinks['menu_id'];
				$id_menu_type     = $cn_mainlinks['id_type_menu'];
				$id_section       = $cn_mainlinks['id_section'];
				$id_parent        = $cn_mainlinks['menu_parent_id'];

				$title   			= clean_output($cn_mainlinks['menu_title']);
				$title_alias      = clean_output(@$cn_mainlinks['title_alias']);
				$metawords        = clean_output($cn_mainlinks['menu_tags']);
				$menu_seo_name	  = $cn_mainlinks["menu_seo"];


				$image 	  	      = @$cn_mainlinks['image'];
				$image_show       = @$cn_mainlinks['image_show'];
				$quicklink        = @$cn_mainlinks['quicklink'];
				$to_footer        = @$cn_mainlinks['to_footer'];

				$menuItem = array 
				(	
					'id'			  => 	''.$id_link.'',
					'title'		   => 	''.$title.'',
					'title_alias'	 => 	'',	
					'menu_seo_name'   => 	''.$menu_seo_name.'',					
					'id_section'	  => 	''.$id_section.'',
					'id_menu_type'	=> 	''.$id_menu_type.'',
					'link_menu'	   => 	''.$link.'',					
					'metawords'	   => 	''.$metawords.'',
					'to_footer'	   => 	''.$to_footer.'',
					'to_quick'		=> 	''.$quicklink.'',
					'id_access'	  => 	''.$cn_mainlinks["id_access"].''													
				);
				
				/*$menuItem = array 
				(						
					'id'			  => 	''.$id_link.'',
					'title'		   => 	''.$title.'',
					'title_alias'	 => 	''.$title_alias.'',	
					'menu_seo_name'   => 	''.$menu_seo_name.'',					
					'id_section'	  => 	''.$id_section.'',
					'id_menu_type'	=> 	''.$id_menu_type.'',
					'link_menu'	   => 	''.$link.'',					
					'metawords'	   => 	''.$metawords.'',
					'to_footer'	   => 	''.$to_footer.'',
					'to_quick'		=> 	''.$quicklink.'',
					'id_access'	  => 	''.$cn_mainlinks["id_access"].''													
				);*/

				$cn_mainlinks['menu_link'] = ''.$link.'';
				$cn_mainlinks['id_menu_type'] = ''.$id_menu_type.'';
				
				
				$masterMenus['full'][$id_link] 	  			  	= $menuItem; //$cn_mainlinks; //
				$masterMenus['type'][$id_menu_type][$id_link]   = $id_link;
				$masterMenus['section'][$id_section][$id_link]  = $id_link;

				$masterMenus['seo'][$menu_seo_name] 		    = $id_link;


				if($id_parent <> '') 
				{   $masterMenus['child'][$id_parent][$id_link] = $id_link; 
					$masterMenus['mom']['_link'][$id_link] 	  = $id_parent;
				}


				//@@ Menu Header
				/*if($quicklink == 1) 
				{
					if (!@array_key_exists($id_link, $masterMenus['type'][6])) {
						$masterMenus['type'][6][$id_link] = $id_link;  
					}
				}*/


				//@@ Sitemap Base
				/*if($id_menu_type == 6 or $id_menu_type == 5 or $id_menu_type == 1) 
				{
						$masterMenus['type']['_tree'][$id_link] = $id_link;  			
				}*/

				//@@ Menu Groups
				if($id_menu_type == 4)
				{
						$masterMenus['group'][$id_link] = $id_link;  			
				}

				//@@ Tab Links
				if($id_menu_type == 3) 
				{
					$masterMenus['tabs'][$id_parent][$id_link] = $id_link;
				}


				//@@ Directory Categories
				if($id_section == 13) 
				{
					//master::$directoryCatsMenu
					$masterMenus['dircat'][''.$menu_seo_name.''] = $title;
				}



				//@@ Footer Links
				if($to_footer == 1) 
				{ 
					if (!@array_key_exists($id_link, $masterMenus['type'][5])) {
						$masterMenus['type'][5][$id_link] = $id_link; 
					}
				}

				//if($cn_mainlinks["id_access"] == 2) 
				//{ master::$menuLocks[$id_link] = get_MenuAccess($id_link); }



			}
		}
		
		if(is_array($masterMenus))
		{
			master::$menuBundle	   = $masterMenus;
			/*master::$XmenusFull		= @$masterMenus['full'];
			master::$XmenusType		= @$masterMenus['type'];
			master::$XmenusSection	 = @$masterMenus['section'];
			master::$XmenusChild	   = @$masterMenus['child'];
			master::$XmenusSeo		 = @$masterMenus['seo'];
			master::$XmenusMom		 = @$masterMenus['mom'];
			master::$XmenusTabs		= @$masterMenus['tabs'];*/
			//master::$directoryCatsMenu= @$masterMenus['dircat'];
		}
		
	}
	
	
	
	/*
	@START -- BUILD: County Menu Array
	***********************************************************/
	
	function buildMenu_County($page='home')
	{
		$countyMenus = array();
		
		$sq_mainlinks = "SELECT `county_id` , `county` , `published` FROM `oc_county` order by `county` ;"; 
		$rs_mainlinks = $this->dbQuery($sq_mainlinks);
		$rs_mainlinks_count = $this->recordCount($rs_mainlinks);

		//$date_update = 0;

		if($rs_mainlinks_count>=1)
		{
			while($cn_mainlinks = $this->fetchRow($rs_mainlinks, 'assoc'))
			{
				$county_id 		= $cn_mainlinks['county_id'];
				$county			= clean_output($cn_mainlinks['county']);
				$county_ref		= strtolower(clean_alphanum($county));
				//$link_county	= 'county.php?tag='.$county_ref;	
				$link_county	= 'county.php?cid='.$county_id;				

				if($page == 'home'){
					$countyMenus[] = '<a href="'.$link_county.'" class="button button-border button-white button-light button-large button-rounded tright nomarginX">'.$county.'</a> ';
				}
				else {
					$countyMenus[$county_id] = array(	
						'county_id'		=> ''.$county_id.'',
						'county'		=> ''.$county.'',
						'link_county'	=> ''.$link_county.''													
					);
				}
			}
		}
		//displayArray($countyMenus);
		if($page == 'home'){
			return $countyMenus; 
		} else {	
			if(count($countyMenus))
			{
				master::$menuCounty	   = $countyMenus;
			}
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function buildMenu_ArrOne()
	{
		
		/* $this->connect() or trigger_error('SQL', E_USER_ERROR); */			
		$cache_data = array();
		
		$menus_modstamp = @$_SESSION['sess_oc_menus']['_modstamp'];
		
		$rs_check = $this->dbQuery("SELECT `cache_id`, `cache_date`, `cache_data` FROM `oc_cache_vars` where `cache_id` = 'menuChest'"); 
			
		if($this->recordCount($rs_check) == 1 )
		{ 
			$cn_check    = $this->fetchRow($rs_check);
			$cache_date  = $cn_check['cache_date'];
			if($cache_date > $menus_modstamp)
			{
				$cache_data  = unserialize($cn_check['cache_data']);	
				$_SESSION['sess_oc_menus'] = 	$cache_data;
			}
			else
			{
				$cache_data = $_SESSION['sess_oc_menus'];
			}
		}
			
		//displayArray($cache_data); exit;
		if(is_array($cache_data))
		{
			master::$menuBundle	   = $cache_data;
			master::$menuBundle['full']		= $cache_data['full'];
			master::$menuBundle['type']		= $cache_data['type'];
			master::$menuBundle['section']	 = $cache_data['section'];
			master::$menuBundle['child']	   = @$cache_data['child'];
			master::$menuBundle['seo']		 = @$cache_data['seo'];
			master::$menuBundle['mom']		 = @$cache_data['mom'];
			master::$menuBundle['tabs']		= @$cache_data['tabs'];
			master::$directoryCatsMenu= @$cache_data['dircat'];
		}
		
	}
	
	
	
	
	function buildMenu_Main ($com_active, $id_menu_type = 1, $id_parent = 0 , $nav_type="mainNav", $county_id = '')
	{   
		$out 		  	   = "";
		$nav_class_main    = "";
		$nav_class_sub     = "";
		$nav_id	   	    = $nav_type;
		$linkClass	     = "";
		
		if($nav_type=="mainNav") 
		{ 
			if($id_parent == 0) { $nav_id = $nav_type; $nav_class_main = "  sf-menu "; }
			$nav_class_sub = ""; 
			$linkClass = "";  
		}
		
		if($nav_type=="treeview") 
		{ 
			if($id_parent == 0) { $nav_id = "tree"; $nav_class_main = "treeview "; }
			$nav_class_sub = ""; 
			$linkClass = "";  
		}
		
		if($nav_type=="nav_top") 
		{ 
			if($id_parent == 0) { $nav_id = $nav_type; $nav_class_main = "  nav_wireX sf-menu "; }
			$nav_class_sub = ""; 
			$linkClass = "";  
			$nav_type = "";
		}
		
		
		if($nav_type=="nav_dloads") 
		{ 
			if($id_parent == 0) {} $nav_id = $nav_type; $nav_class_main = "  bul-gry dark "; //$nav_type; //
			$nav_class_sub = ""; 
			$linkClass = "";  
		}
		
		if($nav_type=="nav_cols") 
		{ 
			if($id_parent == 0) {} $nav_id = ""; $nav_class_main = " nav_sidex bul-gryx darkx "; //$nav_type; //
			$nav_class_sub = ""; 
			$linkClass = "";  
		}
		
		if($nav_type=="nav_side") 
		{ 
			if($id_parent == 0) {} $nav_id = $nav_type; $nav_class_main = "navX bs-docs-sidenavX nav_side"; 
			$nav_class_sub = ""; 
			$linkClass = "";  
		}
		
		if($nav_id <> "nav_top")  
		{
			$out .=  "<ul id=\"".$nav_id."\" class=\"". $nav_class_main . $nav_class_sub."\">"."\n"; 
		}
		
		if($nav_type == "treeview") 
		{
			if($id_menu_type == 0)
			{ $menu = master::$menuBundle['child'][$id_parent]; }
			else
			{ $menu = master::$menuBundle['type']['_tree']; asort($menu); }
		}
		elseif($nav_type == "nav_side") 
		{	
			//$nav_parent = master::$menuBundle['mom']['_link'][$com_active];
			$menu = master::$menuBundle['child'][$id_parent]; 
		}
		else
		{
			if($id_menu_type <> 0 and array_key_exists($id_menu_type, master::$menuBundle['type']))
			{ $menu = master::$menuBundle['type'][$id_menu_type];  }
			else
			{ $menu = master::$menuBundle['child'][$id_parent]; }
		}
		
		//displayArray($menu);
		
		if($nav_type == "nav_tabs") 
		{
			$menu = master::$menuBundle['tabs'][$id_parent]; 
		}
		
		if(is_array($menu))
		{
			foreach($menu as $key => $val )	//=> $ml
			{
				$ml 	      = master::$menuBundle['full'][$val];
				$ml_has_subs = '';
				$ml_subs = 0;
				if (array_key_exists('child', master::$menuBundle) and is_array(master::$menuBundle['child']) and array_key_exists($val, master::$menuBundle['child'])) 
				{ $ml_subs = count(master::$menuBundle['child'][$val]); $ml_has_subs = ' sf-with-ul'; }
				
				$target = "";
				//displayArray($ml);
				if( is_array($ml)) 
				{
		
						$link 		  = $ml['link_menu'];				//'_page.php'; //
						$link_seo     = $ml['menu_seo_name'].'/';	//.'.htm';
						
						
						$lbit = substr($link,0,3);	//EXTERNAL
						if($lbit == 'htt' or $lbit == 'www' or $lbit == 'ftp' or $lbit == 'ww2') 
						{ 
							$redirect = $link;
							if(substr($lbit,0,2)  == 'ww') { $redirect = 'http://'. $link; }
							$sURL = urlencode($redirect); 
							$link = $redirect; //'out.php?url='.$sURL;  
							$target = ' target="_blank" ';
						} 
						elseif( $link <> "#") 
						{ 	$link = $link . '?com='.$key; 
						  	//$link = $link_seo;
						}
						
						//if( $link == "index.php" or $ml['id'] == 1) { $link = ''; }
						
						if($county_id <> '' and $ml['id_menu_type'] == 10 or $county_id <> '' and $nav_type == "nav_side"){
							$link = $link . '&cid='.$county_id; 
						}
								
						if( $link == "#") { $linkb = ""; } 
						else { $linkb = " href=\"$link\" ";	} 
						
						
						if ( $ml['id'] == $com_active ) { $isActive = " current";} else { $isActive = "";}
						
						
					if($ml['id_access'] == 2) 
					{   $folderlock = "nav-locked"; 
						if ( $ml['id'] == $com_active ) { $folderlock = "nav-locked-open"; }				
					} else { $folderlock = ""; }
					
					
					
					if($ml['to_footer'] == 1 or $ml['id_menu_type'] == 5) { 
						if (!array_key_exists($key, $this->linkToFoot)) {
							$this->linkToFoot[$key] = "<li><a $linkb  class=\"". $isActive ."\">".$ml['title']."</a></li>"; 
						}
					}
					
					
					//@@ Tab Links
					if($ml['id_menu_type'] == 3)  
					{	//RDR_REF_BASE
						//tab=".$ml['menu_seo_name']
						
						//$linktab = " href=\"#\" data-id=\"".$key."\" data-url=\"contabs.php?com=".$key."&isec=".$ml['id_section']."\" ";
						$linktab = " href=\"".$link."\" data-id=\"".$key."\" data-url=\"contabs.php?com=".$key."&isec=".$ml['id_section']."\" ";
						
						if (!array_key_exists($key, $this->linkTabsDept)) {
							$this->linkTabsDept[$id_parent][$key] = "<li><a $linktab  class=\"". $isActive ."\">".$ml['title']."</a></li>"; 
						}
					}
					
					
					
					
					/*if($ml['to_quick'] == 1) { 
						if (!array_key_exists($key, $this->linkToQuick)) {
							$this->linkToQuick[$key] = "<li><a $linkb  class=\"". $isActive ."\">".$ml['title']."</a></li>"; 
						}
					}*/
					
					
					$this->coom = 3; if($this->coom > 3) $this->coom = 2;
					$this->navMainCurrent = $key;

					$countConts = '';


					/*if(array_key_exists($key, master::$menuToContents))
					{ $countConts = ' ('.count(master::$menuToContents[$key]).')';  }*/

					//<span class=\"".$linkClass.$folderlock."\">	</span>	

					$menu_title = $ml['title'];

					/*if($nav_id == 'nav_top' or $nav_id == 'mainNav') {
						if($ml['id'] == '1') { $menu_title = '<i class="fa fa-home" id="nav_link_home_fa"></i><span id="nav_link_home">&nbsp; '.$ml['title'].'</span>'; }
					}*/

					//. $ml_has_subs
					//$out .=  "<li id=\"m".$key."\" class=\"".$isActive."\"><a $linkb  class=\"".$isActive." linkMenu ".$ml_has_subs."\" data-id=\"".$ml['id']."\" $target>".$menu_title . $countConts ."</a>";
					
					$out .=  '<li id="m'.$key.'" class="'.$isActive.'"><a '.$linkb.'  class="'.$isActive.' linkMenu '.$ml_has_subs.'" data-id="'.$ml['id'].'" '.$target.'>'.$menu_title . $countConts .'</a>';
					
					if($ml_subs > 0){
						//$out .=  "\n".$this->buildMenu_Main ($com_active, 0, $ml['id'] , $nav_type);
					}

					$this->coom = 2;

					$out .=  "</li>"."\n";//;
					
					
					
				}
			}
		}
		
		if($nav_id <> "nav_top")  {  
			$out .=  "</ul>"."\n";
		}
		return $out;
	}
	
	
	function buildMenu_Crumbs ($com, $result = '', $county_id='')
	{	//echo $com; exit;
		$sep = CRUMBS_SEP; 
		$crumb = '';
		$hasMom = false;
		
		if(is_array(master::$menuBundle['full']) and array_key_exists($com, master::$menuBundle['full']))
		{
			$parent_menu_type = '';
			if(array_key_exists('mom', master::$menuBundle) and 
			   is_array(master::$menuBundle['mom']) and 
			   array_key_exists($com, master::$menuBundle['mom']['_link'])) 
			{ 
				$hasMom 	 = true; 
				$pero  		 = master::$menuBundle['mom']['_link'][$com];
				$pero_arr	 = master::$menuBundle['full'][$pero];
				$parent_menu_type = $pero_arr['id_menu_type'];
			}
			$crumbMenu = master::$menuBundle['full'][$com];
			
			
			//$title_url 	  	    = display_linkMenu($crumbMenu['link_menu'], $crumbMenu['menu_seo_name']);	
			
			$link 	= $crumbMenu['link_menu'].'?com='.$com;	
			
			/* add county_id to link */
			if($county_id <> '' and $crumbMenu['id_menu_type'] == 10 or $county_id <> '' and $parent_menu_type ==10)
			{ $link = $link . '&cid='.$county_id;  }
			/* END:: add county_id to link */
			
			
			$title_url			= ' href="'.$link.'" ';
			$title_active_plain   = $crumbMenu['title'];
			$title_active 	     = '<a '.$title_url.'>'.$title_active_plain.'</a>';
			
			$title_type   	       = $crumbMenu['id_menu_type']; //echobr($title_type);
			if($title_type == 1) { $this->menuMainSelect = $com; }
			
			if($hasMom) {
				//$pero  		 = master::$menuBundle['mom']['_link'][$com];
				//$pero_arr	 = master::$menuBundle['full'][$pero];
				
				$pero_ref	 = $pero_arr['link_menu'].'?com='.$pero;
				if($county_id <> '' and $pero_arr['id_menu_type'] == 10 ){ $pero_ref = $pero_ref . '&cid='.$county_id;  }
				
				$pero_url	 = ' href="'.$pero_ref.'" ';
				//$pero_url 	 = display_linkMenu($pero_arr['link_menu'], $pero_arr['menu_seo_name']);	
				
				//displayArray($pero_arr);
				$pero_title   = '<a '.$pero_url.'>'.$pero_arr['title'].'</a>';
				
				if(array_key_exists($pero, master::$menuBundle['mom']['_link'])){
					$result = $this->buildMenu_Crumbs($pero);
				}
				
				if($result == '')
				{
					$crumb = $result . $pero_title . $sep . $title_active . $sep;
				}
				else
				{
					$crumb = $result . $title_active . $sep;	//. $sep
				}			
			}
			else
			{
				$crumb =  $title_active . $sep;
			}
		}
		return $crumb;
	}
	
	
	
	
	function buildContent_ArrOne()
	{
		
		/* $this->connect() or trigger_error('SQL', E_USER_ERROR); */			
		$cache_data = array();
		
		$content_modstamp = @$_SESSION['sess_oc_content']['_modstamp'];
		
		$rs_check = $this->dbQuery("SELECT `cache_id`, `cache_date`, `cache_data` FROM `oc_cache_vars` where `cache_id` = 'contentChest'"); 
			
		if($this->recordCount($rs_check) == 1 )
		{ 
			$cn_check    = $this->fetchRow($rs_check);
			$cache_date  = $cn_check['cache_date'];
			
			if($cache_date > $content_modstamp)
			{
				$cache_data  = unserialize($cn_check['cache_data']);	
				$_SESSION['sess_oc_content'] = 	$cache_data;
			}
			else
			{
				$cache_data = $_SESSION['sess_oc_content'];
			}
		
		master::$contMain		   = $cache_data;
		master::$contMainNew		= $cache_data['full'];
		master::$contSection		= @$cache_data['section'];
		master::$menuToContents	 = @$cache_data['parent'];	//menuToContents
		master::$menuIntros	    = @$cache_data['intros'];
		master::$contFront		 = @$cache_data['front'];
		}
				
		
	}
	
	
	
	function siteContentDates($cont_id)
	{
		
		$sq_eventlinks = "SELECT DATE_FORMAT(`date`, '%Y%m%d') AS `ev_date`, DATE_FORMAT(`date`,'%l:%i %p') AS `ev_time_start`,  DATE_FORMAT(`end_date`, '%l:%i %p') AS `ev_time_end`, UNIX_TIMESTAMP(DATE_FORMAT(`date`, '%Y%m%e')) AS `ev_date_unix` FROM oc_dt_content_dates WHERE (`id_content` =".quote_smart($cont_id).") ORDER BY `ev_date_unix` ;";
		// `oc_dt_content_dates`.`date` >=CURRENT_DATE() and 
		
		$rs_eventlinks = $this->dbQuery($sq_eventlinks);	
		$rs_eventlinks_count = $this->recordCount($rs_eventlinks);
		
		$eventDates    = array();
		
		if($rs_eventlinks_count>=1)
		{
			while($cn_eventlinks = $this->fetchRow($rs_eventlinks))
			{
				$eventDates[] = array 
				(
					'ev_date'	    => 	''.strtotime($cn_eventlinks['ev_date']).'',
					'ev_time_start'  => 	''.$cn_eventlinks['ev_time_start'].'',
					'ev_time_end'    => 	''.$cn_eventlinks['ev_time_end'].''
				);				
			}
		}
		return $eventDates;
	}
	
	
	
	/*
	@@@ GALLERY ITEMS
	***********************************************************/
	
	function siteGallery()
	{
		/* $this->connect() or trigger_error('SQL', E_USER_ERROR); */			
		$dataGallery = array();
		
		$cat_modstamp = @$_SESSION['sess_oc_gallery']['_modstamp'];		
		$rs_check = $this->dbQuery("SELECT `cache_id`, `cache_date`, `cache_data` FROM `oc_cache_vars` where `cache_id` = 'galleryChest'"); 
			
		if($this->recordCount($rs_check) == 1 )
		{ 
			$cn_check    = $this->fetchRow($rs_check);
			$cache_date  = $cn_check['cache_date'];
			
			if($cache_date > $cat_modstamp)
			{ 
				$dataGallery  = @unserialize($cn_check['cache_data']);	
				$_SESSION['sess_oc_gallery'] = 	$dataGallery;
			}
			else
			{  
				$dataGallery = $_SESSION['sess_oc_gallery'];
			}
		}
		
		if(count($dataGallery) > 1)
		{
		 //master::$listGallery_long = $dataGallery['full']; 
		 master::$listGallery = $dataGallery;
		 		
			/*foreach($dataGallery as $gkey => $gval)
			{ if($gkey <> 'full') { master::$listGallery[$gkey] = $gval; } }*/
		}
		
		
	}
	
	
	function siteGalleryTop($galCat = '')
	{
		//echobr(count(master::$contMainNew));
		
		if($galCat == '') 
		{
			
			$arr = master::$listGallery['cat']['gallery'];
		
			foreach ($arr as $k => $v) { 
				
				$pic_arr = master::$listGallery['full'][$v];
				
				$pic_parent_id = $pic_arr['pic_parent_id'];
				$parent_title  = $pic_arr['title'];
				
				/*if($pic_arr['pic_parent'] == '_cont')
				{ $parent_title = @master::$contMainNew[$pic_parent_id]['title']; }
				else
				{ $parent_title = @master::$menuBundle['full'][$pic_parent_id]['title']; }*/
				
				$pic_arr['pic_parent_title'] = $parent_title;
				
				master::$listGallery_top[] = $pic_arr; 
					
			}
			
			/*$arr = master::$listGallery['parent'];
		
			foreach ($arr as $k => $v) { 
				if($k <> '_resource' and $k <> '_link')	// or $k == 'crop'
				{
					foreach ($v as $pk => $pp) 
					{
						$pic_arr = master::$listGallery['full'][current($pp)];
						$pic_arr['pic_total'] = count($pp);
						
						$pic_parent_id = $pic_arr['pic_parent_id'];
						$parent_title  = '';
						
						if($pic_arr['pic_parent'] == '_cont')
						{ $parent_title = @master::$contMainNew[$pic_parent_id]['title']; }
						else
						{ $parent_title = @master::$menuBundle['full'][$pic_parent_id]['title']; }
						
						$pic_arr['pic_parent_title'] = $parent_title;
						
						master::$listGallery_top[] = $pic_arr; 
					}
				}
			}*/
		}
		else
		{
			$arr = master::$listGallery[$galCat];
			foreach ($arr as $pk=>$pp) {
				$pic_arr = master::$listGallery['full'][current($pp)];
				$pic_arr['pic_total'] = count($pp);
				master::$listGallery_top[] = $pic_arr; 
			}
		}
	}
	
	
	
	
	
	
	/*
	@@@ RESOURCE CENTER ITEMS
	***********************************************************/
	
	function siteDocuments()
	{
		/* $this->connect() or trigger_error('SQL', E_USER_ERROR); */			
		$dataResources = array();
		
		$cat_modstamp = @$_SESSION['sess_oc_resources']['_modstamp'];		
		$rs_check = $this->dbQuery("SELECT `cache_id`, `cache_date`, `cache_data` FROM `oc_cache_vars` where `cache_id` = 'resourceChest'"); 
			
		if($this->recordCount($rs_check) == 1 )
		{ 
			$cn_check    = $this->fetchRow($rs_check);
			$cache_date  = $cn_check['cache_date'];
			
			if($cache_date > $cat_modstamp)
			{ 
				$dataResources  = unserialize($cn_check['cache_data']);	
				$_SESSION['sess_oc_resources'] = 	$dataResources;
			}
			else
			{  
				$dataResources = $_SESSION['sess_oc_resources'];
			}
		}
		
		master::$listResources = $dataResources; 
		
			
	}
	
	function siteDocuments__OLD()
	{
		/*master::$listResources['_seo']    = array();
		master::$listResources['_feat']   = array();
		master::$listResources['_link']   = array();
		master::$listResources['_cont']   = array();*/
		
		
		/* $this->connect() or trigger_error('SQL', E_USER_ERROR); */
				
		$sq_gallery = " SELECT
    `oc_dt_downloads`.`id`
    , `oc_dt_downloads_parent`.`id_menu`
    , `oc_dt_downloads_parent`.`id_content`
    , `oc_dt_downloads`.`date_posted`
    , `oc_dt_downloads`.`title`
    , `oc_dt_downloads`.`description`
    , `oc_dt_downloads`.`link` as `filename`
    , `oc_dt_downloads`.`dtype` as `filetype`
    , `oc_dt_downloads`.`dsize` as `filesize`
    , `oc_dt_downloads`.`hlight`
    , `oc_dt_downloads`.`hits`
	, `oc_dt_downloads`.`link_seo`
FROM
    `oc_dt_downloads`
    INNER JOIN `oc_dt_downloads_parent` 
        ON (`oc_dt_downloads`.`id` = `oc_dt_downloads_parent`.`id_download`)
WHERE (`oc_dt_downloads`.`published` =1)
ORDER BY `oc_dt_downloads`.`date_updated` DESC;";
		
		$rs_gallery = $this->dbQuery($sq_gallery);
		$rs_gallery_count = $this->recordCount($rs_gallery);
		
		if($rs_gallery_count>=1)
		{
			
			while($cn_gallery = $this->fetchRow($rs_gallery))
			{
				$id_file      = $cn_gallery['id'];
				$id_content   = $cn_gallery['id_content'];
				$id_link 	  = $cn_gallery['id_menu'];
				$featured 	 = $cn_gallery['hlight'];			
				$file_seo	 = $cn_gallery['link_seo'];
				
				if($id_link <> 0)    { $pic_parent = '_link'; $pic_parent_id = $id_link; }
				if($id_content <> 0) { $pic_parent = '_cont'; $pic_parent_id = $id_content; }
				
				$filetype	 = trim($cn_gallery['filetype']);
				
				$gallery_item = array 
					(
						'id'			 => 	''.$cn_gallery['id'].'',
						'title'		  => 	''.clean_output($cn_gallery['title']).'',						
						'filename'	   => 	''.trim($cn_gallery['filename']).'',
						'filetype'	   => 	''.$filetype.'',
						'posted'         => 	''.$cn_gallery['date_posted'].'',
						'details'	    => 	''.clean_output($cn_gallery['description']).'',
						'hits'           => 	''.$cn_gallery['hits'].'',
						'pic_parent'     => 	''.$pic_parent.'',
						'pic_parent_id'  => 	''.$pic_parent_id.'',
						'file_seo'       => 	''.$file_seo.''
					);
					
					master::$listResources[$id_file] 	= $gallery_item; 
					master::$listResources['_seo'][$file_seo] = $id_file;
					//master::$listGallery_cat[''.$filetype.''][$id_photo] = $id_photo; //$gallery_item; 
				
				if($featured == 1)
				{   master::$listResources['_feat'][$id_file] = $id_file; }						
						
				if($id_link <> 0)    { 
					master::$listResources['_link'][$id_link][$id_file] = $id_file; 
				}
				if($id_content <> 0) { 
					master::$listResources['_cont'][$id_content][$id_file] = $id_file; 
				}			
				
			}
		}
	}
	
	
	
	
	
	/*
	@START -- BUILD: Events Array
	***********************************************************/
	function siteEventsFuture()
	{
		/* $this->connect() or trigger_error('SQL', E_USER_ERROR); */
		$response["events"] = array();
		
		$sq_eventlinks = " SELECT `oc_dt_content_dates`.`id_content`,    DATE_FORMAT(`oc_dt_content_dates`.`date`,'%b %e %Y') AS `date`, `oc_dt_content`.`title`,  `oc_dt_content`.`arr_extras` AS `location` FROM `oc_dt_content_dates` INNER JOIN `oc_dt_content`  ON (`oc_dt_content_dates`.`id_content` = `oc_dt_content`.`id`) WHERE (`oc_dt_content`.`published` =1) GROUP BY `oc_dt_content`.`title`, `oc_dt_content_dates`.`id_content` ORDER BY `oc_dt_content_dates`.`date` DESC ";
		// `oc_dt_content_dates`.`date` >=CURRENT_DATE() and 
		$rs_eventlinks = $this->dbQuery($sq_eventlinks);
		$rs_eventlinks_count = $this->recordCount($rs_eventlinks);
		$truncFilter 	= "<img>";
		if($rs_eventlinks_count>=1)
		{
			$ev_loop=1;
			while($cn_eventlinks = $this->fetchRow($rs_eventlinks))
			{
				$cont_id			= $cn_eventlinks[0];
				$cont_date		  = $cn_eventlinks[1];
				$cont_dateb 		 = strtotime($cont_date);
				$cont_title		 = master::$contMainNew[$cont_id]['title'];		
				$cont_article	   = master::$contMainNew[$cont_id]['article'];
				$cont_brief 		 = smartTruncateNew(strip_tags($cont_article, $truncFilter),250);
				$cont_location	  = master::$contMainNew[$cont_id]['location'];
				$cont_section	  = master::$contMainNew[$cont_id]['id_section'];
				$booking	       = master::$contMainNew[$cont_id]['booking'];
				$booking_amount    = master::$contMainNew[$cont_id]['booking_amount'];
				$cont_seo		   = $cont_id.'/'.master::$contMainNew[$cont_id]['link_seo'];
				//$item_link	      = display_linkArticle($cont_id, $cont_seo);
				
				$eventItem 	= array(
					'evid' 	 => ''.$cont_id.'',
					'date'     => ''.$cont_dateb.'',
					'title'    => ''.$cont_title.'',
					'location' => ''.$cont_location.'',
					'description' => ''.$cont_brief.'',
					'id_section' => ''.$cont_section.'',
					'booking' => ''.$booking.'',
					'booking_amount' => ''.$booking_amount.'',
					'link' => ''.$cont_seo.''
				);
				
				array_push($response["events"], $eventItem);		
				//$this->contEvents[] = $eventItem;				
				$ev_loop += 1;				
			}
		}
		return $response; //$this->contEvents;
	}
	
	
	
	
	
	
	
	
	/*
	@BUILD: NAV TABS ARTICLE TITLES
	***********************************************************/
	
	function build_navTabArticles ( $parent, $limit = 100, $optionalTitle = '' )
	{
		$output = ''; $parentTitle = '';
		
		if($optionalTitle == '')
		{
			if($this->menuLong[$parent]['title_alias'] <> '') 
			{	$parentTitle = $this->menuLong[$parent]['title_alias']; } else 
			{	$parentTitle = $this->menuLong[$parent]['title']; }	
			$output = '<h3 class="txtupper">'.$parentTitle.'</h3>';
			$output .= '<div class="info-b"><ul class="bul-gry" >';
			$pageurl = 'department.php';
			$pagehash = ' #'.$parent.'';
		} 
		else {
			$parentTitle = $optionalTitle;
			$output = '<h4 class="txtupper txtred">'.$parentTitle.'</h4>';
			$output .= '<div class="wside_nav"><ul class="nav_context" >';
			$pageurl = 'dept.php';
			$pagehash = '';
		}
		
		
		$tabContFull   	 = $this->contTabsDept[$parent];
		$tabContPaged 	= array_chunk($tabContFull, $limit, true);		
		$tabContTitles   = $tabContPaged[0];

		
		foreach ($tabContTitles as $menu => $cont) 
		{ 
			if($this->menuLong[$menu]['id_section'] == 7)
			{
				$linka   = ''.$pageurl.'?com='.$menu.'&tab='.$parent.''.$pagehash.'';
				$conta   = $this->menuLong[$menu]['title'];			
				$output .= '<li><a href="'.$linka.'">'.$conta.'</a></li>';
			}
		}
		$output .=  '</ul></div>';
		
		
		if(count($tabContFull) > $limit) {
		$output .=  '<div class="padd5_t"><a href="context.php?com='.$parent.'" class="postDate read_more_right" style="border:1px solid #f00">VIEW ALL</a></div>';
		}
		
		return $output;
	}
	
	
	
	
	/*
	@BUILD: NAV SINGLE COLUMNS
	***********************************************************/
		
	function build_navCategorySingle ( $id_category, $com_active = '', $linkLimit = 4, $cat_class='nav_cols' )
	{
		$out = '';
		if(array_key_exists($id_category, master::$menuBundle['full']))  
		{
			
			$swl 		= master::$menuBundle['full'][$id_category];			
			$parent 	 = $swl['id'];
			
			$box_title  = $swl[ 'title' ];
			$box_links  = $this->buildMenu_Main ($com_active, 0, $parent, $cat_class);
			
			$box_title = 'Sectors';
			
			$out .= '<div class="box-cont">';
			$out .= '<div class="box-cont-title">'.$box_title.'</div>';
			
			$out .= $box_links;
			$out .= '<div class="padd10"></div></div>';
		}
		return $out;
	}
	
	
	
	/*
	@BUILD: NAV FOOTER COLUMNS
	***********************************************************/
		
	function build_navColumnsFoot ( $com_active, $linkLimit = 4, $cat_section = 'navSide' )
	{
		$menu = $this->menuGroups;
		//displayArray($menu);
		$out = '';
		
		$tagsOpen 	 = '';
		$tagsClose 	= '';
		$cat_class	= '';
		
		if($cat_section == 'navSide')
		{
			$tagsOpen 	 = '<div class="padd10"></div><div class="phpkb-tree"><div class="padd5">';
			$tagsClose 	= '</div></div>';
			$cat_class	= 'nav_dloads';
		}
		
		if($cat_section == 'nav_cols')
		{
			$cat_class	= 'nav_cols';
		}
		
		
		$out .= '<div class="pagerX">';
		
		foreach($menu as $key)	// => $swl
		{
			$swl = master::$menuBundle['full'][$key];
			
			$parent = $swl['id'];
			
			$box_title = $swl[ 'title' ];
			$box_links = $this->buildMenu_Main ($com_active, 0, $parent, $cat_class);
			
			/*$out .= $tagsOpen . '<div class="panel panel-default panel-alt">
				<div class="panel-heading">
					<h3 class="txtbrown">'. $box_title .'</h3>
				</div>
				<div class="panel-body">
					<div class="">'. $box_links .'</div>
				</div>
			</div>' . $tagsClose;*/
				
				$out .= "<div class=\"nav_foot_col\">
						<h5 class=\"foot_col_header\">". $box_title ."</h5>".
						$box_links .
						"</div>";/*$this->buildMenu_Main ($com_active, 0, $parent, '')*/
			
			
		}
		
		$out .= '</div>';
		return $out;
	}
	
	
	
	
	/*
	@BUILD: TAB LINKS
	***********************************************************/
		
	function build_navTabs ( $menu, $com_active, $linkLimit = 4 )
	{
		
		foreach($menu as $key => $valID)
		{
			$swl = $valID; //$this->menuLong[$valID];
			
			if( is_array($swl)) 
			{
			$link 	= $swl['link_menu'];
			$isec    = $swl['id_section'];
			
			if ( $swl['id'] == $com_active ) { $isActive = " current";} else { $isActive = "";}
			
			$linktab = " href=\"#\" data-id=\"".$key."\" data-url=\"contabs.php?com=".$key."&tab=".$key."&isec=".$isec."\" ";
			
			
			$parent = $swl[ 'id' ];$com_active = 0;
			echo "<li><a $linktab  class=\"". $isActive ."\">".$swl['title']."</a></li>";
				
			
			}
		}
		
		//return $out;
	}
	
	
	/*
	@BUILD: other site menus
	***********************************************************/
	
	function build_generalMenu ( $menu, $com, $com_active, $nav_id="", $id_menu_type = 1, $static = 0 )
	{
		$out =  ""; 
		$mcom = 1 ;
		
		$mloops = 0 ;
		
		$ul_identity = "id=\"".$nav_id."\"";
		 	
			if( $nav_id == "nav_side") { $ul_identity = "class=\"".$nav_id."\""; }
			if( $nav_id == "zentabs_ul") { $ul_identity = "class=\"".$nav_id."\""; }
		
		$out = "";
		if( $nav_id <> "treeview") { $out .=  "<ul ".$ul_identity.">";	}
		
		
		
		foreach($menu as $key => $ml)
		{
		if( is_array($ml)) 
		{ 
			if( $nav_id == "treeview") 
			{
				if ( $ml['id_menu_type'] == $id_menu_type  or 
					 $ml['id_menu_type'] == '4'  or
					 $ml['id_menu_type'] == '6' ) 
				{	
					
					$link = $ml['link_menu'];	
					if ( $link == "#")	{ 	$linkb = ""; } else {	$linkb = " href=\"$link?com=".$key." \" ";	} 
					if ( $ml ['id'] == $com ) { $isActive = " selected ";} else { $isActive = "";}
						
					if (array_key_exists('children', $ml) and is_array($ml['children'])) 
					{	$add_class = "expandable"; $add_icons = "<div class=\"hitarea expandable-hitarea\"></div>";
					} else 
					{ 	$add_class = ""; $add_icons = ""; }
					
					//\n 
					$out .=  "<li class=\"".$add_class."\">$add_icons<a class=\"".$isActive."\" $linkb>". $ml[ 'title' ] ."</a>";
					$out .=  $this->build_SubMenu ( $menu, $key, "?com=".$key."&com2=", $com_active ,"treeview", 3);
					$out .=  "</li>";
				}
			}
			
			else
			{
				
				if ( $ml [ 'id_menu_type' ] == $id_menu_type ) 
				{		
						$link = $ml['link_menu'];	
						
					//  *********************************** @beg :: BASIC LINKS ***********************************
						if ( $link == "#")	{ 	$linkb = ""; } else {	$linkb = " href=\"$link?com=".$key." \" ";	} 
						if ( $ml ['id'] == $com ) { $isActive = " class =\"current\" ";} else { $isActive = "";}
						
					//  *********************************** @end :: BASIC LINKS ***********************************
					
						
					//  *********************************** @beg :: TABBED LINKS ***********************************
						if( $nav_id == "zentabs_ul") 
						{
							$link = "_tabs_ajax_content.php"; 
							$linkb 	= " href=\"$link?id=".$key."\" id=\"tab".$key."\" ";
							if($mloops == 0) { $isActive = " class =\"current\" "; }
						}
					// *********************************** @end :: TABBED LINKS ***********************************
					
						if($nav_id=="accountNav"){	$navClass = " account_nav_sec";	}
					
					//  ===========================================================================================								
					
					
				
						
					$out .=   "<li class=\"".$isActive.$navClass."\"><a $linkb class=\"".$isActive."\">". $ml[ 'title' ] ."</a>";
					$out .=  $this->build_SubMenu ( $menu, $key, "?com=".$key."&com2=", $com_active ,$nav_id, 3, $com); 
					$out .=   "</li>";
					
					$mloops += 1 ;
				}
				
			} //for static
			
		}
		
		}
		
		if( $nav_id <> "treeview") 
		{
			$out .=  "</ul>";
		}
		
		return $out;
	}
	
	
	
	
	/*
	@BUILD: side menu
	***********************************************************/
	function build_articlesMenu ( $menu, $com, $com_active, $section_num = 6)
	{
		$out =  ""; 
		$mcom = 1 ;
		
		$mloops = 0 ;
		
		$ul_identity = "id=\"".$nav_id."\"";
		 
			if( $nav_id == "zentabs_ul") { $ul_identity = "class=\"".$nav_id."\""; }
		
		$out = "";
		$out .=  "<ul class=\"nav_side\">";	//".$ul_identity."
		
		foreach($menu as $key => $ml)
		{
			if( is_array($ml)) 
			{ 
			
				if ( $ml['id_section'] == $section_num ) 
				{		
						$link = $ml['link_menu'];	
						
					//  *********************************** @beg :: BASIC LINKS ***********************************
						if ( $link == "#")	{ 	$linkb = ""; } else {	$linkb = " href=\"$link?com=".$key." \" ";	} 
						if ( $ml ['id'] == $com ) { $isActive = " class =\"current\" ";} else { $isActive = "";}
						
					//  *********************************** @end :: BASIC LINKS ***********************************
					
					
					//  *********************************** @beg :: EXTERNAL LINKS ***********************************
						/*if(substr($link,0,4) <> "http") { $link = "http://".$link; }
						if ( $link == "#")	{ 	$linkb = ""; } else {	$linkb = " href=\"$link\" ";	} 
						if ( $ml ['id'] == $com ) { $isActive = " class =\"current\" ";} else { $isActive = "";}*/
						
					//  *********************************** @end :: BASIC LINKS ***********************************
					
					
					//  ===========================================================================================
					
						
					//  *********************************** @beg :: TABBED LINKS ***********************************
					
					// *********************************** @end :: TABBED LINKS ***********************************
					//  ===========================================================================================								
					
						$out .=   "<li><a $linkb $isActive>". $ml[ 'title' ] ."</a>";
						
							if( $nav_id <> "zentabs_ul") 
							{	$out .=  $this->build_SubMenu ( $menu, $key, "?com=".$key."&com2=", $com_active ,"", 3); }
						
						$out .=   "</li>";
					
					$mloops += 1 ;
				}
				
			}
			//else { echo "not array"; }
		}
		$out .=  "</ul>";
		return $out;
	}
	
	
	
	
	function build_SideMenu ( $menu, $parent, $com_active, $path="" )
	{
		
		echo "<div class=\"wside_nav\">";
		foreach($menu as $key => $swl)
		{
		if( is_array($swl)) 
		{
			//echo $key;
			if ( $swl [ 'id' ] == $parent ) 
			{
				if( $this->build_SubMenu ( $menu, $parent, $path, $com_active ,"", 4) == FALSE )
				{	
					//echo "hakuna";
				} 
				else 
				{
				$meStyle= " class=\"\" ";
				echo  "<h4 $meStyle>". $swl[ 'title' ] ."</h4><div>";
				//echo  $this->build_SubMenu ( $menu, $parent, $path, $com_active ,"", 4);
				
				echo $this->build_SubMenu ( $menu, $key, "?com=".$key."&com2=", $com_active , $mainNavClass, 3, $com);
				//build_SubMenu ( $menu, $el_id, $path, $com_active, $nav_cat="", $nav_level="", $com="" )
				
				echo  "</div>";
				}
				
			}
		}
		}
		echo  "</div>";
		//return $out;
	}
	
	
	
	
	/*
	@BUILD: sub menu
	***********************************************************/
	
	function build_SubMenu ( $menu, $el_id, $path, $com_active, $nav_cat="", $nav_level="", $com="", $nlimit="", $nexpand="Y" )
	{
		$has_subcats = FALSE;
		
		
		if (array_key_exists($el_id, $this->menuSubs) and is_array($this->menuSubs[$el_id])) 
		{
		
			$submenu_class = "";	
			$submenu_icons = "";			
			$out  		  = ""; 
			$out_close 	= ""; 
			
			if(trim($nav_cat) == "sf-menu") { $submenu_class = " filetree "; $submenu_icons = " folder ";	 }
			
			//if($nav_cat <> "" and trim($nav_cat) <> "sf-menu") { $submenu_class = " $nav_cat "; }
			//if($nav_cat=="treeview") { $submenu_class = " style=\"display: none\" "; }
			//echoBr($nav_cat);
			//echoBr($nlimit);
			if($nlimit == "") 
			{   $menuChildren = $this->menuSubs[$el_id]; }
			else
			{   $submenuArray = array_chunk($this->menuSubs[$el_id], $nlimit, true); 
				$menuChildren = $submenuArray[0];
				$nexpand = "";
			}
			//$menuChildren = $this->menuSubs[$el_id]; 
			
			
			
			$out .= "<ul class=\" $submenu_class\">"; 
			
			$linkLoop = 1;
			
			foreach($menuChildren as $key => $childID)
			{
				$sl = $this->menuLong[$childID];
				
				//displayArray($sl); exit;
				
				if( is_array($sl)) 
				{
					$isActive = "  ";
					if ( $sl['id'] == $com_active ) { $isActive = " current ";} 
					
					$has_subcats = TRUE;
					
					$npath = $path.$key."&com".$nav_level."=";
										
					if($sl['link_menu']<>"#") { 
						$lbit = substr($sl['link_menu'],0,3);	//EXTERNAL
						if($lbit == 'htt' or $lbit == 'www' or $lbit == 'ftp' or $lbit == 'ww2') 
						{ 
							$redirect = $sl['link_menu'];
							if(substr($lbit,0,2)  == 'ww') { $redirect = 'http://'. $sl['link_menu']; }
							$sURL = urlencode($redirect); 
							$link = 'out.php?url='.$sURL;  
						} else 
						{ $link = $sl['link_menu'] . $npath; }
					} else { $link = '#'; }
					
					
					if($sl['id_access'] == 2) { 
						$folderlock = "nav-locked"; /*$link = "#";*/
						if ( $sl['id'] == $com_active ) { $folderlock = "nav-locked-open"; }
						
				
					
					 } else { $folderlock = ""; }
					
					
					if($link <> '#'){  } $linkd = " href=\"$link\" ";
					
					if($sl['to_footer'] == 1 ) { 
						if (!array_key_exists($key, $this->linkToFoot)) {
							$this->linkToFoot[$key] ="<li><a".$linkd.">".$sl['title']."</a></li>"; 
						}
					}
					
					if($sl['to_quick'] == 1) { 
						if (!array_key_exists($key, $this->linkToQuick)) {
							$this->linkToQuick[$key] ="<li><a".$linkd.">".$sl['title']."</a></li>";  
						}
					}
					
					
				$countSubs = '';
				
				/*if(array_key_exists($key, $this->menuSubs) and is_array($this->menuSubs[$key]))
				{
					//$countSubs = ' ('.count($this->menuSubs[$key]).')';
				}*/
				
				if(array_key_exists($key, master::$menuToContents)) //and is_array($this->menuSubs[$key])
				{
					$countSubs = ' ('.count(master::$menuToContents[$key]).')'; 
				}
					
					//<div class=\"hitarea expandable-hitarea\"></div>
					$out .= "<li class=\"expandable ".$isActive."\" >"; 
					$out .= "<span class=\"".$submenu_icons." ".$folderlock." ".$isActive."\"><a".$linkd." class=\"".$isActive." linkMenu\" data-id=\"".$sl['id']."\">".$sl['title'] .$countSubs."</a></span>"; 
					
					$mpath = $npath."&com2=".$key;
					
					if($nexpand == "Y")
					{
						//if(array_key_exists('children', $sl) and is_array($sl['children'])) {
						if(array_key_exists($childID, $this->menuSubs) and is_array($this->menuSubs[$childID])) {
							//another level sub menu
							$out .=  $this->build_SubMenu ( $menu, $childID, $npath, $com_active, $nav_cat, ($nav_level+1), $com ); 
						}
					}
						
					$out .= "</li>"."\n"; //."\n"; 
					$linkLoop += 1;
					
				}
			}
			
			$out .= "</ul>";
			$out .= $out_close; //"</td></tr></table></div></div>";
			return ( $has_subcats ) ? $out : FALSE;
			//return ( $out ) ? $has_subcats : FALSE;
		}
	}
	
	
	
	
	
	/*
	@BUILD: foot menu
	***********************************************************/
	
	//$out .=  $this->build_SubMenu ( $menu, $key, "?com=".$key."&com2=", $com_active , $mainNavClass, 3, $com);
	
	function build_FootMenu ( $menu, $com_active )
	{
		
		echo "<div class=\"pager\">";
		foreach($menu as $key => $swl)
		{
		if( is_array($swl)) 
		{
			//echo $key;
			if ( $swl['id_menu_type'] == 1  and $swl['id'] <> 1 or $swl['id_menu_type'] == 3 ) 
			{
				$meStyle= " class=\"box-title linegray\" ";
				$parent = $swl[ 'id' ];$com_active = 0;
				echo  "<div class=\"nav_foot_col\">";
				echo  "<h3 $meStyle>". $swl[ 'title' ] ."</h3>";
				echo  $this->build_SubMenu ( $menu, $parent, "?com=".$parent."&com2=", $com_active ,"nav_foot", 3);
				echo  "</div>";
			}
		}
		}
		echo  "</div>";
		//return $out;
	}
	
	
	/*
	@BUILD: main menu Select
	***********************************************************/
	
	function build_MenuSelectRage ($sel_this = 0, $sel_array = "", $access = '1')
	{
		$menuList = master::$menuBundle['full']; 
		array_sort_by_column($menuList, 'id', SORT_ASC);
		//displayArray($menuList); exit;
		$optsFields = array();
		$optsKeys = array();
		
		foreach($menuList as $ml)
		{
			$isSel = "";
			
			//if($sel_crit == $ml['id']) { $isSel = " selected";} else { $isSel = ""; }
			
			if(is_array($sel_array)){
				$optVal = $ml['id'];
				if(in_array($optVal, $sel_array)) { $isSel = " selected";} else { $isSel = ""; }						
			}
			
			if ( $sel_this == $ml['id']) {	$isSel .= " disabled=\"disabled\" ";  }
			
			
			if (!array_key_exists($ml['id'], $optsKeys))
			{
				$optsFields[] = "<option value=\"". $ml['id'] ."\" $isSel>". $ml['title'] ."</option>";
				$optsKeys[$ml['id']] = $ml['id'];
			}
			
			
			
			if(is_array(master::$menuBundle['child']) and array_key_exists($ml['id'], master::$menuBundle['child']) )
			{
				$menuKids = master::$menuBundle['child'][$ml['id']];
				$parent = "../";
				foreach($menuKids as $kkey => $kval)
				{
					if(is_array($sel_array) and in_array($kval, $sel_array)) 
					{ $isSel = " selected";} else { $isSel = ""; }
					if($sel_this == $kval) 
					{	$isSel .= " disabled=\"disabled\" ";  }
					
					if (!array_key_exists($kval, $optsKeys))
					{
					$kidArray = master::$menuBundle['full'][$kval];
					$optsFields[] = "<option value=\"". $kval ."\" $isSel>". $parent . $kidArray['title'] ."</option>";
					$optsKeys[$kval] = $kval;
					}
				}
			}
				
		}
		//displayArray($optsFields); exit;
		return implode('',$optsFields);
	}
	
	
	
	
	
	/*
	@BUILD: Accordion
	***********************************************************/
	
	function build_Accordion ( $parent, $sec = 3 )
	{
		//$this->faqMain = "";
		$faqMain = '';
		$faqNum = 1;
		//if(count($this->contLong[$parent][$sec])>0) {
		if(array_key_exists($parent, master::$menuToContents))	
		{	//$this->contLong[$parent][$sec]
			//foreach($this->contLong[$parent][$sec] as $key => $swlf)
			asort(master::$menuToContents[$parent]);
			foreach(master::$menuToContents[$parent] as $contkey)
			{
				//if( is_array($swlf))  {}
				$cont_arr 	   = master::$contMainNew[$contkey];
				$faqtitle 	   = $cont_arr['title'];
				$faqtitle_alias = $cont_arr['title_sub'];
				$faqarticle	 = $cont_arr['article'];
				
				if($faqtitle_alias <> '') { $faqtitle_alias = ' &nbsp; <span>'. $faqtitle_alias .'</span>'; }
						
			$faqMain .= '<div class="accordion-header"><a href="javascript:">'. $faqNum .'. '. $faqtitle .' '. $faqtitle_alias .'</a></div>';
			$faqMain .= '<div class="accordion-content">';
			$faqMain .= $faqarticle;
			$faqMain .= '</div>';
					
				$faqNum += 1;
			}
		}
		return $faqMain;
	}
	
	
	
	
	

			
/*
	@END: class
*/	
}
	

$folderPath = substr($_SERVER['REQUEST_URI'],0,strrpos($_SERVER['REQUEST_URI'],"/"));
$folderPath = substr($folderPath,strrpos($folderPath,"/")+1);

$folderPortal = 1;


$dispData=new data_arrays;
$dispData->buildMenu_Arr();
//$dispData->buildContent_Arr();

$reqPage = $_SERVER['REQUEST_URI']; 

if(!strpos($reqPage,'sysman/')  and (substr($this_page,0,5) <> 'poll_') and $this_page <> 'ajforms.php' and $this_page <> 'cart-post.php')
{ 
	//$dispData->buildMenu_Arr();
	//$dispData->buildContent_Arr();
	//$dispData->siteGallery(); 
} 

//echo __DIR__;
?>