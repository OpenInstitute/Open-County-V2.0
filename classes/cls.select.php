<?php
// GLOBAL VARIABLES AND SELECTS

class drop_downs extends master
{
	var $tbl;
	var $col1;
	var $col2;
	var $col3;
	var $query;
	var $crit;
	var $crit2;
	var $line2;
	
	
	
	function checks($tbl, $col1, $col2, $title, $crit){ 		
		//$this->connect() or trigger_error('SQL', E_USER_ERROR);
		
		$sq_more = "";
		if($tbl == 'oc_reg_cats') { $sq_more = " and system_cat = '0' "; }
		
		$result=$this->dbQuery("SELECT $col1, $col2 FROM $tbl where published=1 $sq_more order by seq, $col2");
		$records = $this->recordCount($result);
		if($records >=1 )	
		{
			
			$i=0;
			//echo "<input type=\"checkbox\" class=\"hidden required\" name=\"".$title."[]\" id=\"".$title."\" title=\"Please select option(s)!\" validate=\"required:true\" >";
			//echo '<label class="error hidden" for="'.$title.'[]">Please select option(s)!</label>';
			while($qry_data = $this->fetchRow($result))
			{
				if($crit == $qry_data[0]) { $isOn = " checked "; } else { $isOn = ""; }
				$rec_id = $qry_data[0];
				$labelid = $title."_".$qry_data[0];
				if($i==0) { $validate = " validate=\"required:true\" class=\"required\" "; } else { $validate = ""; }
				//
				echo "<label for=\"$labelid\" class=\"labelradio\"><input type=\"checkbox\" name=\"".$title."[]\" id=\"$labelid\" value='$qry_data[0]'  $isOn $validate >  $qry_data[1] &nbsp; </label>";
			$i += 1;
			}
			
			/*echo "<label for=\"".$title."_other\" class=\"labelradio\"><input type=\"checkbox\" name=\"".$title."_other\" id=\"".$title."_other\" > Other <em>(key-in below)</em></label>";*/
			//
		}	
	}	
	
	
	
	
	
/******************************************************************
@begin :: SELECT DROP DOWN
********************************************************************/		
	
	function dropper_sel_title($tbl, $col1, $col2, $crit = "", $crit2 = "") 
	{ 
		//$this->connect() or trigger_error('SQL', E_USER_ERROR);
				
		$line = "";
		
		$result=$this->dbQuery("SELECT $col1, $col2, `published` FROM $tbl where `published`=1 ".$crit2." order by $col2");
			
			//$line .= '<option value="" selected></option>';
			
			while($qry_data = $this->fetchRow($result))
			{
				if(strlen($qry_data[1])>=1)
				{
					$isSelected	= "";					
					$fielditem   = clean_output($qry_data[1]);
					
					if(is_array($crit)){
						if(in_array($fielditem, $crit)) { $isSelected = " selected";} 						
					}
					else
					{	if($crit <> "") { 
						 	if($fielditem == $crit) { $isSelected = " selected "; }
						 }
					} 
					
					//if($crit == $fielditem) { $isSelected = " selected "; } else { $isSelected = ""; }
					$line .= '<option value="'.$fielditem.'" '.$isSelected.'>'.$fielditem.'</option>'; // $selected
				}
			}
		return $line;
	}			
	
	
	
	function dropper_select($tbl, $col1, $col2, $crit = "", $firstDefault = "Select", $multiple = 0, $ordercol = "")
	{ // dropper_select
		$out = "";
		//$this->connect() or trigger_error('SQL', E_USER_ERROR);
		
		if($multiple == 0) {
		$out = "<option value=''>$firstDefault</option>";
		}
		if($crit == "" and $firstDefault <> "blank"){
		//$out = "<option value='' selected></option>";	//selected
		}
		
		$sqPublished = " where `published`= '1' ";
		
		$tblFilta = trim(substr($tbl,0,9)); //
		if($tblFilta == 'oc_app_') { $sqPublished = ""; }
		
		if($ordercol == "") { $ordercol = $col2; }
		
		$result=$this->dbQuery("SELECT $col1, $col2, `published` FROM $tbl $sqPublished order by $ordercol");
			
			while($qry_data = $this->fetchRow($result))
			{
				if(strlen($qry_data[1])>=1)
				{
					$notpublished = ($qry_data[2] == 1) ? "" : " class='op_notpublished' ";
					$selected="";
					if(is_array($crit)) { if(in_array($qry_data[0], $crit)) { $selected = " selected";}  }
					elseif($crit <> "") { if($qry_data[0] == $crit) { $selected=" selected "; } } 
					
					$out .= "<option value='".$qry_data[0]."' ".$notpublished."  ".$selected.">$qry_data[1]</option>";
				}
			}
			
			return $out;
	}											//dropper_select
	
	
	
	function dropper_conf($conf_type, $crit = "", $returnId = 't', $firstDefault = "Select")
	{ 
		$out = "<option value=''>$firstDefault</option>";
		
		$sq_crit = " where `published`= '1' and `choice_cat`= ".$this->quote_si($conf_type)." ";
		
		$result = $this->dbQuery("SELECT `choice_item`, `choice_id` FROM `oc_dt_conf_choices` $sq_crit ;");
			
			while($qry_data = $this->fetchRow($result))
			{
				if(strlen($qry_data[0])>=1)
				{
					$selected="";
					if(is_array($crit)) { if(in_array($qry_data[0], $crit)) { $selected = " selected";}  }
					elseif($crit <> "") { if($qry_data[0] == $crit) { $selected=" selected "; } } 
					
					$opval = ($returnId <> 't') ? $qry_data[1] : $qry_data[0];
					$out .= "<option value='".$opval."' ".$selected.">$qry_data[0]</option>";
				}
			}
			
			return $out;
	}
	
	
	function drop_sel($tb_key, $crit='', $label='') {
		$result = ''; $attr = array();
				
		switch($tb_key){
			case "jobgroup":   $attr = array("oc_conf_jobgroup", "id_jobgroup", "jobgroup"); break;			
			case "bank_code":  $attr = array("oc_conf_banks", "bank_code", "title");  break;			
			case "ward": 	   $attr = array("oc_conf_wards", "id_ward", "ward");  break;
			case "member": 	 $attr = array("oc_member", "id_member", "m_name");  break;
			case "committee":  $attr = array("oc_committee", "id_committee", "title");  break;
			case "region":     $attr = array("oc_conf_regions", "id_region", "region");  break;
		}		
		return $this->dropper_select($attr[0], $attr[1], $attr[2], $crit, $label);				
	}
	
	
	function dropper_type_detail($conf_type_id, $crit = "", $firstDefault = "Select")
	{ 
		$out = "<option value=''>$firstDefault</option>";
		
		$sq_crit = " where `published`= '1' and `conf_type_id`= ".$this->quote_si($conf_type_id)." ";
		
		$result = $this->dbQuery("SELECT `id_type`, `type_title` FROM `oc_conf_types_detail` $sq_crit ;");
			
			while($qry_data = $this->fetchRow($result))
			{
				if(strlen($qry_data[1])>=1)
				{
					$selected="";
					if(is_array($crit)) { if(in_array($qry_data[0], $crit)) { $selected = " selected";}  }
					elseif($crit <> "") { if($qry_data[0] == $crit) { $selected=" selected "; } } 
					
					$out .= "<option value='".$qry_data[0]."' ".$selected.">$qry_data[1]</option>";
				}
			}
			
			return $out;
	}
	

/* ============================================================================================= */
/* DEFAULT SELECTORS
/* --------------------------------------------------------------------------------------------- */	

	function dropperSection($crit="", $cat = "menu")
	{ 
		$out = "";
		//$this->connect() or trigger_error('SQL', E_USER_ERROR);
		
		$sq_crit = " WHERE (`published` = 1 AND `section_cat` = 'all') or (`published` = 1 AND `section_cat` = ".quote_smart($cat).") ";
		
		$sq = "SELECT `section_id`, `section_title` FROM `oc_dt_conf_sections` $sq_crit ORDER BY `seq` ASC, `section_title` ASC ;";
		
		$result=$this->dbQuery($sq);
			
			while($qry_data = $this->fetchRow($result))
			{
				
				if(strlen($qry_data[1])>=1)
				{
					$selected="";
					if(is_array($crit)){
						if(in_array($qry_data[0], $crit)) { $selected = " selected";} 						
					}
					elseif($crit <> "") { 
						if($qry_data[0] == $crit) { $selected=" selected "; }
					} 
				}
				
				$out .= "<option value='".$qry_data[0]."' ".$selected.">$qry_data[1]</option>";
			}
			
			return $out;
	}


	function dropperCounties($crit="")
	{ 
		$out = "";
		//$out = "<option value=''> </option>";
		//$out .= "<option value='99'>All Counties / General</option>";
		
		$sq = "SELECT `county_id`, `county` FROM `oc_county` ORDER BY `county` ASC ;";
		
		$result = $this->dbQuery($sq);
			
			while($qry_data = $this->fetchRow($result))
			{
				$selected="";
				if(is_array($crit)){
					if(in_array($qry_data[0], $crit)) { $selected = " selected";} 						
				}
				elseif($crit <> "") { 
					if($qry_data[0] == $crit) { $selected=" selected "; }
				} 
				$out .= "<option value='".$qry_data[0]."' ".$selected.">$qry_data[1] County</option>";
			}
			
			return $out;
	}


/* ============================================================================================= */
/* POPULATORS -- PROJECT >>> LINKS
/* --------------------------------------------------------------------------------------------- */	
	
	function populateProjectLinks($link_type, $link_id, $sector_id, $project_id = '') 
	{
		//$this->connect() or trigger_error('SQL', E_USER_ERROR);
		
		if($link_type <> '' and $link_id <> '' and $sector_id <> '' )
		{
			
			$sq_clean = " delete from `oc_app_project_links` where `".trim($link_type)."` = ".quote_smart($link_id)."; ";
			$rs_clean = $this->dbQuery($sq_clean); 
		
			$sq_query = "INSERT INTO `oc_app_project_links` (`sector_id`,`project_id`,`".trim($link_type)."` ) values (".quote_smart($sector_id).", ".quote_smart($project_id).", ".quote_smart($link_id)." );  ";
			$rs_query = $this->dbQuery($sq_query); 		 
		
		}
	}

	
	function getProjectLinks($link_type, $link_id) 
	{
		//$this->connect() or trigger_error('SQL', E_USER_ERROR);
		$plinks = ''; 
		if($link_type <> '' and $link_id <> '')
		{
			$sq_query = "SELECT `sector_id` , `project_id`, `".trim($link_type)."` FROM `oc_app_project_links` WHERE (`".trim($link_type)."` = ".quote_smart($link_id).")";
			$rs_query = $this->dbQuery($sq_query); 	
			if($this->recordCount($rs_query))
			{	$plinks = $this->fetchRow($rs_query, 'assoc'); }
		
		}
		return $plinks;
	}
	
	
	function getProjectParents($cat, $crit) 
	{
		$out = ''; $tb_name = ''; $tb_key = ''; $tb_col = '';
		if($cat == 'sectors') { $tb_name = 'oc_app_sector'; $tb_key  = 'sector_id'; $tb_col = 'title'; }
		if($cat == 'pillars') { $tb_name = 'oc_app_pillar'; $tb_key  = 'pillar_id'; $tb_col = 'title'; }
		if($cat <> '')
		{
			//$this->connect() or trigger_error('SQL', E_USER_ERROR);
			$rs_data= @$this->dbQuery("SELECT `".$tb_col."` FROM `".$tb_name."` WHERE `".$tb_key."`=".quote_smart($crit).";");
			if(@$this->recordCount($rs_data)){
				$cn_data = @$this->fetchRow($rs_data);
				$out = $cn_data[0];
			}
		}
	
		return $out;
	}
	
	
	function getProjectList($sector_id)
	{
		//$this->connect() or trigger_error('SQL', E_USER_ERROR);
		
		$projectArray = array();
		
		if($sector_id <> '')
		{
			$sq_data = "SELECT `project_id`, `pname` as `project_name` FROM `oc_app_project` WHERE (`published`=1 and `sector_id` = ".quote_smart($sector_id)."); ";
		//echo $sq_data;
			$rs_data = $this->dbQuery($sq_data);
			if($this->recordCount($rs_data)) 
			{
				while($cn_data = $this->fetchRow($rs_data))
				{
					$project_id  	= $cn_data[0];
					$project_name  = clean_output($cn_data[1]);
					$projectArray[$project_id] = $project_name;				
				}
			}	
		}
		return $projectArray;
	}


	function getProjectDetails($project_id)
	{
		//$this->connect() or trigger_error('SQL', E_USER_ERROR);
		
		$projectArray = array();
		
		if($project_id <> '')
		{
			$sq_data = "SELECT
    `oc_app_project`.*
    , `oc_app_pillar`.`title` AS `pillar`
    , `oc_app_sector`.`title` AS `sector`
    , `oc_app_ministry`.`name` AS `ministry`
    , `oc_app_location`.`name` AS `location`
FROM
    `oc_app_project`
    LEFT JOIN `oc_app_pillar` 
        ON (`oc_app_project`.`pillar_id` = `oc_app_pillar`.`pillar_id`)
    LEFT JOIN `oc_app_sector` 
        ON (`oc_app_project`.`sector_id` = `oc_app_sector`.`sector_id`)
    LEFT JOIN `oc_app_ministry` 
        ON (`oc_app_project`.`ministry_id` = `oc_app_ministry`.`ministry_id`)
    LEFT JOIN `oc_app_location` 
        ON (`oc_app_project`.`location_id` = `oc_app_location`.`location_id`)
WHERE (`oc_app_project`.`project_id` = ".quote_smart($project_id)." AND `oc_app_project`.`published` =1); ";
		//echo $sq_data;
			$rs_data = $this->dbQuery($sq_data);
			if($this->recordCount($rs_data)) 
			{
				$projectArray = $this->fetchRow($rs_data, 'assoc');				
			}	
		}
		return $projectArray;
	}
	
	
	function getProjectComponents($project_id)
	{
		//$this->connect() or trigger_error('SQL', E_USER_ERROR);
		
		$compArray = array();
		
		if($project_id <> '')
		{
			$sq_data = "SELECT
    `oc_app_project_component`.`published`
    , `oc_app_project_component`.*
    , `oc_app_location`.`name` AS `location`
    , `oc_app_location`.`lon` AS `longitude`
    , `oc_app_location`.`lat` AS `latitude`
FROM
    `oc_app_project_component`
    LEFT JOIN `oc_app_location` 
        ON (`oc_app_project_component`.`location_id` = `oc_app_location`.`location_id`)
WHERE (`oc_app_project_component`.`published` =1 AND `oc_app_project_component`.`project_id` = ".quote_smart($project_id)."); ";
		//echo $sq_data;
			$rs_data = $this->dbQuery($sq_data);
			if($this->recordCount($rs_data)) 
			{
				while($cn_data = $this->fetchRow($rs_data, 'assoc'))
				{ $compArray[] = (object) array_map("clean_output",$cn_data); }				
			}	
		}
		return $compArray;
	}


	
	function getProjectGallery($project_id)
	{
		//$this->connect() or trigger_error('SQL', E_USER_ERROR);
		
		$gallArray = array();
		
		if($project_id <> '')
		{
			//$sq_data = "SELECT `sector_id` , `project_id` , `id_gallery` FROM `oc_app_project_links` WHERE (`project_id`  = ".quote_smart($project_id)." AND `id_gallery` <> 0); ";
			
			$sq_data = "SELECT `sector_id` , `project_id` , `id_content`, `id_gallery` FROM `oc_app_project_links` WHERE (`project_id`  = ".quote_smart($project_id)."); ";
			$rs_data = $this->dbQuery($sq_data);
			if($this->recordCount($rs_data)) 
			{
				while($cn_data = $this->fetchRow($rs_data))
				{
					$id_content  = $cn_data['id_content']; 
					$id_gallery  = $cn_data['id_gallery']; 
					
					if($id_content <> 0) { $gallArray['cont'][] = $id_content; }
					if($id_gallery <> 0) { $gallArray['gall'][] = $id_gallery; }
					
					//$gallArray[]  = $cn_data[2];				
				}
			}	
		}
		return $gallArray;
		
	}




/* ============================================================================================= */
/* POPULATORS -- CONTENT >>> PARENT
/* --------------------------------------------------------------------------------------------- */	
	
	function populateContentParent($id_content, $array_menu, $array_county = '0') 
	{
		//$this->connect() or trigger_error('SQL', E_USER_ERROR);
		
		$out = 0;
		$sq_query = array();
		
		if(is_array($array_menu) and $id_content <> '')
		{
			
			$sq_clean = " delete from `oc_dt_content_parent` where `content_id` = ".quote_smart($id_content)."; ";
			$rs_clean = $this->dbQuery($sq_clean); 
		
			foreach($array_menu as $kval) {  
				$sq_query[] = "insert IGNORE into `oc_dt_content_parent` (`content_id`,`menu_id`, `county_id` ) values (".quote_smart($id_content).", ".quote_smart($kval).", '0'); ";				
			} 
		
			foreach($array_county as $cval) {  
				$sq_query[] = "insert IGNORE into `oc_dt_content_parent` (`content_id`,`menu_id`, `county_id` ) values (".quote_smart($id_content).", '0', ".quote_smart($cval)."); ";				
			} 
			//displayArray($sq_query); exit;
			$rs_query = $this->dbQueryMulti($sq_query); 
			
		$out = count($array_menu);
			
		}
		//return $out;
	}




/* ============================================================================================= */
/* POPULATORS -- KEYWORDS LOG
/* --------------------------------------------------------------------------------------------- */	
	
	function populateKeywords($parent_type, $parent_id, $array_keys) 
	{
		//$this->connect() or trigger_error('SQL', E_USER_ERROR);
		
		$out = 0;
		$sq_query = array();
		
		if(is_array($array_keys) and $parent_type<>'' and $parent_id<>'')
		{
			
		$sq_clean = " delete from `oc_log_keywords` where `parent_type`=".quote_smart($parent_type)." and `parent_id`=".quote_smart($parent_id)." ";
		$rs_clean = $this->dbQuery($sq_clean); 
		
			foreach($array_keys as $kval) 
			{  
				$sq_query = " insert IGNORE into `oc_log_keywords` (`keyword`, `parent_type`, `parent_id` ) values "
				." (".quote_smart($kval).", ".quote_smart($parent_type).", ".quote_smart($parent_id).");  ";
				$rs_query = $this->dbQuery($sq_query); 
			} 
			
			$out = count($array_keys);
			//if(count($sq_query)>0){if($this->dbQuery( implode('',$sq_query) )) { $out = count($sq_query); }  }
			
		}
		return $out;
	}














/******************************************************************
@begin :: CA STATS CATS
********************************************************************/		
	
	function selectStatsCats($crit = '', $cat_parent = '', $cat_main = 1){ 
		//$this->connect() or trigger_error('SQL', E_USER_ERROR);
		
		$out = '';
		$sq_more = "";
		
		if($cat_main == 1) { $sq_more = " and `child_cat` = '0' "; }
		if($cat_main == 0) { $sq_more = " and `child_cat` = '1' "; }
		//if($cat_parent == '_eqp') { $sq_more = " and `cat_equipment` = '1' "; }
		//if($cat_parent == '_crp') { $sq_more = " and `cat_crop` = '1' "; }
		
		$sq_qry = "SELECT `id`, `title` FROM `oc_stats_cats` WHERE `published` = 1 " . $sq_more;
		
		$result = $this->dbQuery($sq_qry);
			
		$out .=  '<option value=""> </option>';
			while($qry_data = $this->fetchRow($result))
			{
				$selected="";
				if(is_array($crit)){
					if(in_array($qry_data[0], $crit)) { $selected = " selected";} 						
				}
				elseif($crit <> "") { 
					if($qry_data[0] == $crit) { $selected=" selected "; }
				} 
				
				$out .=  '<option value="'.$qry_data[0].'" '.$selected.'>'.$qry_data[1].'</option>';
			}
			
		return $out;
	}		
	

/******************************************************************
@begin :: CA DIRECTORY CATS DROP DOWN
********************************************************************/		
	
	function selectDirCategory($crit = '', $cat_parent = ''){ //, $cat_dir = '', $cat_equip = ''
		//$this->connect() or trigger_error('SQL', E_USER_ERROR);
		
		$out = '';
		$sq_more = "";
		
		if($cat_parent == '_dir') { $sq_more = " and `oc_reg_directory_category`.`cat_directory` = '1' "; }
		if($cat_parent == '_eqp') { $sq_more = " and `oc_reg_directory_category`.`cat_equipment` = '1' "; }
		if($cat_parent == '_crp') { $sq_more = " and `oc_reg_directory_category`.`cat_crop` = '1' "; }
		
		//$sq_qry = "SELECT `id`, `title`, `id_menu`, `cat_directory`, `cat_equipment`, `description`, `published`, `seq` FROM `oc_reg_directory_category`  WHERE `published` = 1 " . $sq_more;
		
		$sq_qry = "SELECT `oc_reg_directory_category`.`id`, `oc_reg_directory_category`.`title`, `oc_dt_menu`.`title` AS `menu` FROM `oc_reg_directory_category` LEFT JOIN `oc_dt_menu` ON (`oc_reg_directory_category`.`id_menu` = `oc_dt_menu`.`id`)  WHERE `oc_reg_directory_category`.`published` = 1 " . $sq_more;
		
		$result=$this->dbQuery($sq_qry);
			
		$out .=  '<option value=""> </option>';
			while($qry_data = $this->fetchRow($result))
			{
				$parent="";
				if($qry_data[2] <> '') { $parent = "(". $qry_data[2] .") "; } 
				
				$selected="";
				if($qry_data[0] == $crit) { $selected=" selected "; } 
				$out .=  '<option value="'.$qry_data[0].'" '.$selected.'>'.$parent.$qry_data[1].'</option>';
			}
		return $out;
	}	
	
	
	
	
	
	
	function selectConfTypes($cat=1, $crit = "", $multiple = 0, $title = '')
	{ 
		$out = "";
		//$this->connect() or trigger_error('SQL', E_USER_ERROR);
		
		if($multiple == 0) {
		$out = "<option value=''>$title</option>";
		}
		/*if($crit == "" and $firstDefault <> "blank"){
		//$out = "<option value='' selected></option>";	//selected
		}*/
		
		$sq = "SELECT `conf_data_id` , `conf_data_title` FROM `oc_conf_types_data` WHERE (`published` =1 AND `conf_type_id` = ".quote_smart($cat).") ORDER BY `conf_data_title` ASC, `seq` ASC;";
		
		$result=$this->dbQuery($sq);
			
			while($qry_data = $this->fetchRow($result))
			{
				
				if(strlen($qry_data[1])>=1){
					$selected="";
					if(is_array($crit)){
						if(in_array($qry_data[0], $crit)) { $selected = " selected";} 						
					}
					elseif($crit <> "") { 
						if($qry_data[0] == $crit) { $selected=" selected "; }
					} 
				}
				
				$out .= "<option value='".$qry_data[0]."' ".$selected.">$qry_data[1]</option>";
			}
			
			return $out;
	}
	
	
	
	function getContentImage($id_cont){ 	
		
		$pic_ref  = '';
		$image_id = @current(master::$listGallery['cont'][$id_cont]);
		$image_ar = @master::$listGallery['full'][$image_id];
		
		//displayArray($image_ar);
		$filename = trim($image_ar['filename']);
		
		if($image_ar['filetype'] == 'v') 
		{
			$vid_insert	  = strrpos($filename , '/')+1;
			$vid_code		= substr($filename, $vid_insert);
			$pic_ref		 = 'http://img.youtube.com/vi/'.$vid_code.'/hqdefault.jpg';
		}
		elseif($image_ar['filetype'] == 'p') 
		{
			$pic_ref		 = DISP_GALLERY.$filename;
		}
			
		return $pic_ref;
	}
	
	
	
	function selectDirRegion($crit = ""){ 
		//$this->connect() or trigger_error('SQL', E_USER_ERROR);
		$result=$this->dbQuery("SELECT `ac_country` FROM `oc_reg_directory` GROUP BY `ac_country`");
			
		echo "<option value=''>- Country -</option>";
			while($qry_data = $this->fetchRow($result))
			{
				$selected="";
				if($qry_data[0] == $crit) { $selected=" selected "; } 
				echo "<option value='$qry_data[0]' $selected>$qry_data[0]</option>";
			}
	}	
	
	
	
	
	
	/* ****************************************
	 @Automation  - GET /ADD USER ACCOUNT
	****************************************** */ 
	
	function getAddUserAccount($account_email, $account_arr=array(), $mailing = 0) 
	{
		//$this->connect() or trigger_error('SQL', E_USER_ERROR);
		
		$auth_id	= '';
		$auth_code  = strtoupper(uniqid(time()));	
			
		if($account_email <> '')
		{
			//`oc_reg_users`
			$sq_check = "SELECT `account_id`, `email` FROM `oc_reg_account` WHERE (`email` = ".quote_smart($account_email).")";
			$rs_check = $this->dbQuery($sq_check);
		
			if($this->recordCount($rs_check)>=1)
			{ 
				$cn_check = $this->fetchRow($rs_check);
				$auth_id  = $cn_check[0];		
				
				if($mailing == 1) { $GLOBALS['EXISTS_MAILING_ACCOUNT'] = true; }
			}
			else
			{	
			
			
			/* ----------------------------------------- */	
				$field_title = "";
				$field_value = "";
			
				if(is_array($account_arr))
				{
					foreach($account_arr as $col=>$value)
					{	
						$field_title .= " `$col`, ";
						$field_value .= " ".quote_smart($value).", ";
					}
				}
			/* ----------------------------------------- */
			
			
				$sqpost = "insert ignore into `oc_reg_account` ($field_title `email`, `ipaddress`, `published`) values 
				($field_value ".quote_smart($account_email).", ".quote_smart($_SERVER['REMOTE_ADDR']).", '1' ) ";				
				//echo $sqpost ; exit;
				$result = $this->dbQuery($sqpost);
				$auth_id = $this->insertId();				
			}
		
		}
		return $auth_id;	
	}
	
	
	
	
	/* ****************************************
	 @Automation  - GET /ADD USER ACTIVITIES / MODULES
	****************************************** */ 
	
	function getAddUserModule($user_id, $user_module) 
	{
		//$this->connect() or trigger_error('SQL', E_USER_ERROR);
		
		$sqpost = "insert IGNORE INTO `afp_conf_person_modules` (`id_account`, `id_module`) VALUES (".quote_smart($user_id).", ".quote_smart($user_module)."); ";	
		$result = $this->dbQuery($sqpost); //
	}
	
	
	
	
	/* ****************************************
	 @Automation  - GET /ADD ACCOUNT PARTNERS
	****************************************** */ 
	function getAddPartner($partner_domain, $partner_arr = array()) 
	{
		//$this->connect() or trigger_error('SQL', E_USER_ERROR);
		
		$country_id  	   = $partner_arr['country_id'];
		$ac_partner_id	= '';
			
		if($partner_domain <> '')
		{
			$sq_check = "SELECT `id_partner` FROM `afp_projects_partners` WHERE `partner_domain`=".quote_smart($partner_domain)." and `country_id`=".quote_smart($country_id).";";
			$rs_check = $this->dbQuery($sq_check); //
		
			if($this->recordCount($rs_check)>=1)
			{   $cn_check = $this->fetchRow($rs_check);
				$ac_partner_id = $cn_check[0];		
			} else 
			{	
				/* ----------------------------------------- */	
				$field_title = ""; $field_value = "";			
				if(is_array($partner_arr))
				{   foreach($partner_arr as $col=>$value)
					{   $field_title .= " `$col`, ";
						$field_value .= " ".quote_smart($value).", ";
					}
				}
				/* ----------------------------------------- */			
			
				$sqpost = "insert into `afp_projects_partners` ($field_title `partner_domain`) values 
				($field_value ".quote_smart($partner_domain)." ) ";				
				$result = $this->dbQuery($sqpost);	//
				$ac_partner_id = $this->insertId();					
			}
		}
		
		return $ac_partner_id;	
	}
	
	
	
	
	
	
	function getAddUserPartner($ac_domain, $ac_organization = '') {
		//$this->connect() or trigger_error('SQL', E_USER_ERROR);
		
		if($ac_organization == '') { $ac_organization = $ac_domain; }
		
		$ac_partner_id	= '';
			
		if($ac_domain <> '')
		{
		$sq_check = "SELECT `id_partner` FROM `afp_projects_partners` WHERE `partner_domain`=".quote_smart($ac_domain)." and `partner_title`=".quote_smart($ac_organization).";";
		$rs_check = $this->dbQuery($sq_check);
		
			if($this->recordCount($rs_check)>=1)
			{ 
				$cn_check = $this->fetchRow($rs_check);
				$ac_partner_id = $cn_check[0];		
			}
			else
			{	
				
				$sqpost = "insert into `afp_projects_partners` (`partner_domain`, `partner_title`) values 
				(".quote_smart($ac_domain)." ,
				".quote_smart($ac_organization).") ";
			
				$result = $this->dbQuery($sqpost);
				$ac_partner_id = $this->insertId();				
			}
		
		}
		return $ac_partner_id;	
	}
	
	
	
	
	/* ****************************************
	 @Automation  - GET /ADD USER CATEGORY
	****************************************** */ 
	
	function getAddUserCat($account_cat) {
		//$this->connect() or trigger_error('SQL', E_USER_ERROR);
		
		$ac_cat_id	= '';
			
		if($account_cat <> '')
		{
			$ac_cat_clean = generate_seo_title($account_cat);
			$sq_check = "SELECT `id_category` FROM `oc_reg_cats` WHERE `title_url` = ".quote_smart($ac_cat_clean)."; ";
			$rs_check = $this->dbQuery($sq_check);
		
			if($this->recordCount($rs_check)>=1)
			{ 
				$cn_check = $this->fetchRow($rs_check);
				$ac_cat_id = $cn_check[0];		
			}
			else
			{	
				$sqpost = "insert into `oc_reg_cats` (`title`, `title_url`) values 
				(".quote_smart($account_cat)." ,
				".quote_smart($ac_cat_clean).") ";
			
				$result = $this->dbQuery($sqpost);
				$ac_cat_id = $this->insertId();				
			}
		
		}
		return $ac_cat_id;	
	}
	
	
	
	/* ****************************************
	 @Automation  - ADD USER TO CATEGORY
	****************************************** */ 
	
	function addUserToCategory($cat_id, $account_id, $pref_arr = array()) {
		//$this->connect() or trigger_error('SQL', E_USER_ERROR);
		
		/* ----------------------------------------- */	
			$pref_title = ""; $pref_value = "";
			if(is_array($pref_arr)) {
				foreach($pref_arr as $col=>$value) 
				{ $pref_title .= " `$col`, "; $pref_value .= " ".quote_smart($value).", "; }
			}
		/* ----------------------------------------- */
		
		if($cat_id <> '' and $account_id <> '')
		{
			$sqpost = "replace into `oc_reg_cats_links` ($pref_title `id_category`, `account_id`) values 
			($pref_value ".quote_smart($cat_id)." , ".quote_smart($account_id).") ";	//echo $sqpost ; exit;	
			$result = $this->dbQuery($sqpost);		
		}	
	}
	
	
	
	
	function selectUserCat($multi = "y", $crit = "") { 
		
		//$this->connect() or trigger_error('SQL', E_USER_ERROR);
		
		$out = '';	
		$qry_links ="SELECT `id_category`, `title`, `published` FROM `oc_reg_cats` WHERE  `published` =1 ORDER BY   `title` ASC ";
		
		$i = 0;
		$con_links2=$this->dbQuery($qry_links);
			
			while($res_links2 = $this->fetchRow($con_links2))
			{
				$st='';
				$link_id2	   = $res_links2['id_category'];
				$link_name2	 = html_entity_decode(stripslashes($res_links2['title']));				
				
				$selected = "";
				if(is_array($crit)){
					if(in_array($link_id2, $crit)) { $selected = " selected checked ";} 						
				}
				elseif($crit <> "") { 
					if($link_id2 == $crit) { $selected = " selected checked "; }
				} 
				
				if($multi == "y") 
				{
				$out .= '<label><input type="checkbox" name="user_cat[]" id="user_cat_'.$link_id2.'" '.$selected.' value="'.$link_id2.'" />&nbsp; '.$link_name2.' </label>';
				}
				else
				{
				$out .= '<option value="'.$link_id2.'" '.$selected.'>'.$link_name2.'</option>';
				}
				
			}
			
		return $out;
	}
	
	
	/* ****************************************
	 @Select Country
	****************************************** */ 
	
	function selectCountry($crit) {
		$country = '';
		//$this->connect() or trigger_error('SQL', E_USER_ERROR);
		$rs_data= $this->dbQuery("SELECT `id`, `country` FROM `oc_reg_countries` WHERE `id`=".quote_smart($crit)." or `iso_code_2`=".quote_smart($crit)."  or `iso_code_1`=".quote_smart($crit)." "); //
		if($this->recordCount($rs_data) ==1 ){
			$cn_data = $this->fetchRow($rs_data);
			$country = $cn_data[1];
		}
	
		return $country;
	}
	
	
	
	/* ****************************************
	 @GET MARKET PLACE ITEM OWNER
	****************************************** */ 
	
	function getMarketItemOwner($id) { 
	
		$account = "";
		//$this->connect() or trigger_error('SQL', E_USER_ERROR);
				
		$rs_data=$this->dbQuery("SELECT concat_ws(' ',`firstname`, `lastname`) as `name`, `email` FROM `afp_conf_person_list` WHERE (`id` = ".quote_smart($id).") ");
		if($this->recordCount($rs_data) ==1 ){
			$account = $this->fetchRow($rs_data, 'assoc');
		}
			
		return $account;			
	}	
	
	
	
	
	/* ****************************************
	 @Dropper Select - ProfileCats
	****************************************** */ 
	
	function select_directoryCatsMenu($sel_array = "") { 
	
		$out = '';
		
		$arr_directoryCatsMenu 		= master::$directoryCatsMenu; 
		
		asort($arr_directoryCatsMenu);
		
		foreach ($arr_directoryCatsMenu  as $key => $value) 						
		{
			$selCrit  = trim($value);
			$selected = "";
			
			if(is_array($sel_array)){
				if(in_array($selCrit, $sel_array)) { $selected = " selected";} 						
			}
			elseif($sel_array <> "") { 
				if($selCrit == $sel_array) { $selected=" selected "; }
			}
			
			$out .= '<option value="'.$value.'" '.$selected.'>'.$value.'</option>';				
		}
		
		return $out;			
	}	
	
	
	
	
	/* ****************************************
	 @Dropper Select - PROFILES
	****************************************** */ 
	
	function selectProfiles($sel_array = ""){ 
	
		$out = "<option value=''> - Select -</option>";
		
		$arr_Profiles 		= master::$listProfiles; 		
		asort($arr_Profiles);
		
		foreach ($arr_Profiles  as $key=>$value) 						
		{	
			if(is_array($sel_array)){ if(in_array($key, $sel_array)) { $selected = " selected";} else { $selected = ""; } }
			$title = $value['title'];	
			//if($key == $crit) { $selected=" selected "; } else {$selected="";}
			$out .= "<option value='".$key."' ".$selected.">$title</option>";				
		}
		
		return $out;			
	}	
	
	
	
	
	
	/* ****************************************
	 @Dropper Select - COMMITTEES
	****************************************** */ 
	
	function selectDownloads($crit = "") { 
	
		$out = "";
		//$this->connect() or trigger_error('SQL', E_USER_ERROR);
		$out .= "<option value='' selected>- Any - </option>";
		
		$sqList = "SELECT
    `oc_dt_downloads`.`id`
    , `oc_dt_downloads`.`title`
    , `oc_dt_downloads`.`link`
    , `oc_dt_downloads`.`published`
FROM
    `oc_dt_downloads` WHERE `oc_dt_downloads`.`published` = 1
ORDER BY `oc_dt_downloads`.`title`;";
		
		$result=$this->dbQuery($sqList);
			
		while($qry_data = $this->fetchRow($result))
		{
			if(strlen($qry_data[1])>=1){
				if($qry_data[0] == $crit) { $selected=" selected "; } else {$selected="";}
				$out .= "<option value='".$qry_data[0]."' ".$selected.">$qry_data[1]</option>";
			}
		}
			
		return $out;			
	}	
	
	
	/* ****************************************
	 @Dropper Select - THEMATIC AREAS
	****************************************** */ 
	
	function selectThematicAreas($crit) { 
	
		$out = "";
		//$this->connect() or trigger_error('SQL', E_USER_ERROR);
		$out .= "<option value='' selected>- Any - </option>";
				
		$result=$this->dbQuery("SELECT `id`, `title` FROM `oc_dt_menu` WHERE `published`= 1 and `id_section` = 7  order by `title`; ");
			
		while($qry_data = $this->fetchRow($result))
		{
			if(strlen($qry_data[1])>=1){
				if($qry_data[0] == $crit) { $selected=" selected "; } else {$selected="";}
				$out .= "<option value='".$qry_data[0]."' ".$selected.">$qry_data[1]</option>";
			}
		}
			
		return $out;			
	}	
	
	
	/* ****************************************
	 @Dropper Select - THEMATIC TABS
	****************************************** */ 
	
	function selectThemeTabs($crit){ 
	
		$out = "";
		//$this->connect() or trigger_error('SQL', E_USER_ERROR);
		$out .= "<option value='' selected> </option>";
				
		$result=$this->dbQuery("SELECT `id`, `title` FROM `oc_dt_menu` WHERE `published`= 1 and `id_type_menu` = 7  order by `seq`; ");
			
		while($qry_data = $this->fetchRow($result))
		{
			if(strlen($qry_data[1])>=1){
				if($qry_data[0] == $crit) { $selected=" selected "; } else {$selected="";}
				$out .= "<option value='".$qry_data[0]."' ".$selected.">$qry_data[1]</option>";
			}
		}
			
		return $out;			
	}		
	
	

/*-----------------------------------------------------------------------------------*/
/*	CONFIGS::  Directory Contacts
/*-----------------------------------------------------------------------------------*/	
	
	function getDirectoryContact($supplier_id) 
	{	
		$dirContact = array();
		
		$rs_qry = $this->dbQuery("SELECT `ac_organization`, `ac_email`,  `ac_contact_name`, `ac_contact_email` FROM `oc_reg_directory` WHERE `id` = ".quote_smart($supplier_id)."; ");
		if($this->recordCount($rs_qry)) 
		{	
			$cn_qry = $this->fetchRow($rs_qry);
			$supplier_name  = clean_output($cn_qry['ac_organization']);
			$supplier_email  = clean_output($cn_qry['ac_email']);
			$supplier_contact_email  = clean_output($cn_qry['ac_contact_email']);
			if($supplier_email == '') { $supplier_email = $supplier_contact_email;}
			
			$dirContact['name'] = $supplier_name;
			$dirContact['email'] = $supplier_email;
			
			/*$dirContact[$cn_qry['id']] = array(
					'name'  => ''.$supplier_name.'',
					'email' => ''.$supplier_email.''
				);*/
		}
		return $dirContact;
	}	
	
		
	
	
}

		$ddSelect=new drop_downs;
?>