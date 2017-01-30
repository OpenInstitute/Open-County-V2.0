<?php

class data_oc extends master
{

/* ============================================================================== 
/*	@BUILD: COMPARISON DATA
/* ------------------------------------------------------------------------------ */	
	
	function get_comparisonIndicator($com, $ind = '')
	{
		$result = array();
		
		$sq_secta = "SELECT
    `oc_county_indicator`.`indicator_id`
    , `oc_conf_indicators`.`indicator_title`
    , `oc_county_indicator`.`period`
FROM
    `oc_county_indicator`
    INNER JOIN `oc_conf_indicators` 
        ON (`oc_county_indicator`.`indicator_id` = `oc_conf_indicators`.`indicator_id`)
WHERE (`oc_conf_indicators`.`published` =1)
GROUP BY `oc_conf_indicators`.`indicator_title`, `oc_county_indicator`.`period`;";		
		$rs_secta = $this->dbQuery($sq_secta);		
		
		if($this->recordCount($rs_secta) > 0)
		{
			$currTitle = '';
			$currId = $ind;
			$letter = 'a';
			$row = 0;
			while($cn_secta_a = $this->fetchRow($rs_secta, 'assoc'))
			{
				$cn_secta  		= array_map("clean_output", $cn_secta_a);
				$indicator_id 	= $cn_secta['indicator_id'];
				$indicator_title 	= $cn_secta['indicator_title'];
				$period 	= $cn_secta['period'];
				$indicator_clean    = clean_alphanum($indicator_title);
				
				$active='';
				if($ind == $indicator_id) { $active=' active '; $currTitle = $indicator_title;  } 
				elseif($ind == '' and $row == 0) { $active=' active '; $currTitle = $indicator_title; $currId = $indicator_id; }
				
				
				$result['indi_title'][] = $indicator_title.' ('.$period.')';
					
				$result['indi_list'][] = '<tr>
				      <td class="level2 legend '.$letter.' '.$active.'" id="'.$indicator_clean.'"><a href="comparison.php?com='.$com.'&ind='.$indicator_id.'">'.$indicator_title.' ('.$period.')</a></td>
				    </tr>';
				
				$letter++;
				$row++;
			}
			$result['indi_curr'] = $currTitle;
			$result['indi_curr_id'] = $currId;
		}
					
		return $result;
	}
	
	
	
	
	function get_comparisonIndicatorData($ind)
	{
		$result = array();
		
		$sq_secta = "SELECT
    `oc_county_indicator`.`indicator_id`
    , `oc_county_indicator`.`period`
    , `oc_county`.`county`
    , CONVERT(`oc_county_indicator`.`value`, DECIMAL(25,2)) AS `value`
FROM
    `oc_county_indicator`
    INNER JOIN `oc_conf_indicators` 
        ON (`oc_county_indicator`.`indicator_id` = `oc_conf_indicators`.`indicator_id`)
    INNER JOIN `oc_county` 
        ON (`oc_county_indicator`.`county_id` = `oc_county`.`county_id`)
WHERE (`oc_county_indicator`.`indicator_id` = ".$this->quote_si($ind).")
ORDER BY CONVERT(`oc_county_indicator`.`value`, DECIMAL(25,2))  DESC;";		
		
		$rs_secta = $this->dbQuery($sq_secta);		
		
		if($this->recordCount($rs_secta) > 0)
		{
			$letter = 'a';
			$row = 0;
			while($cn_secta_a = $this->fetchRow($rs_secta, 'assoc'))
			{
				$cn_secta  		= array_map("clean_output", $cn_secta_a);
				$county 		= $cn_secta['county'];
				$value 			= (float) $cn_secta['value'];
				
				
				$data['county'][]	= ucwords($county); 
				$data['values'][] 	= $value;


				//$datab['allocated'][] = array('name'=>''.$department.'', 'y'=> $val_allocated, 'drilldown' => $department_seo.'a'); 
				//$datab['expenditure'][] = array('name'=>''.$department.'', 'y'=> $val_expensed, 'drilldown' => $department_seo.'e'); 
				
				
				
				
			}
			$result = $data;
		}
					
		return $result;
	}
	
	
	
	function get_comparisonCountyData($county_id)
	{
		$result = array();
		
		/* $sq_secta = "SELECT
    `oc_county_indicator`.`indicator_id`
    , `oc_county_indicator`.`period`
    , `oc_county`.`county`
    , CONVERT(`oc_county_indicator`.`value`, DECIMAL(25,2)) AS `value`
FROM
    `oc_county_indicator`
    INNER JOIN `oc_conf_indicators` 
        ON (`oc_county_indicator`.`indicator_id` = `oc_conf_indicators`.`indicator_id`)
    INNER JOIN `oc_county` 
        ON (`oc_county_indicator`.`county_id` = `oc_county`.`county_id`)
WHERE (`oc_county_indicator`.`indicator_id` = ".$this->quote_si($ind).")
ORDER BY CONVERT(`oc_county_indicator`.`value`, DECIMAL(25,2))  DESC;";	*/	
		
		$sq_secta = "SELECT
    `oc_county_indicator`.`indicator_id`
    , `oc_county_indicator`.`period`
    , `oc_county`.`county`
    , CONVERT(`oc_county_indicator`.`value`, DECIMAL(25,2))  AS `value`
    , `oc_county_indicator`.`county_id`
    , `oc_conf_indicators`.`indicator_title`
FROM
    `oc_county_indicator`
    INNER JOIN `oc_conf_indicators` 
        ON (`oc_county_indicator`.`indicator_id` = `oc_conf_indicators`.`indicator_id`)
    INNER JOIN `oc_county` 
        ON (`oc_county_indicator`.`county_id` = `oc_county`.`county_id`)
WHERE (`oc_county_indicator`.`county_id` = ".$this->quote_si($county_id).")
ORDER BY `oc_conf_indicators`.`indicator_title` ASC;";		
		
		$rs_secta = $this->dbQuery($sq_secta);		
		
		if($this->recordCount($rs_secta) > 0)
		{
			$letter = 'a';
			$row = 0;
			while($cn_secta_a = $this->fetchRow($rs_secta, 'assoc'))
			{
				$cn_secta  		= array_map("clean_output", $cn_secta_a);
				$county_id 		= $cn_secta['county_id'];
				$county  		= $cn_secta['county'];
				$indicator_title = $cn_secta['indicator_title'];
				$value 			= (float) $cn_secta['value'];
				$value 			= log10($value);
				
				
				//$data['county'][]	= ucwords($county); 
				//$data['values'][] 	= $value;

				//[$county_id]
				//$data[] = array('name'=>''.$indicator_title.'', 'y'=> $value); 
				$data[] = $value;
				
			}
			$result['county'] = $county;
			$result['data'] = $data;
		}
					
		return $result;
	}
	
	
	
	
	
	
	
	
	
	
	
	
/* ============================================================================== 
/*	@BUILD: COUNTY BUDGET
/* ------------------------------------------------------------------------------ */		

	function get_countyBudgetPeriod($id, $period = '', $latest='')
	{
		$result = array();
		$limit = "";
		
		if($latest == 1) { $limit = " LIMIT 1"; }
		if($id) 
		{
			$sq_qry = "SELECT `county_id`, `period` FROM `oc_county_budget`
WHERE (`county_id` = ".$this->quote_si($id).") GROUP BY `period` ORDER BY `period` DESC ".$limit.";";
			
			if($latest == 1) {
				$rs_qry = current($this->dbQueryFetch($sq_qry));
				$result = $rs_qry['period']; 
			}
			else 
			{
				$rs_qry = $this->dbQuery($sq_qry);		

				$rec = 0;
				if($this->recordCount($rs_qry) > 0)
				{
					while($cn_qry = $this->fetchRow($rs_qry, 'assoc'))
					{
						if($rec == 0) { $result['curr'] =  $cn_qry['period']; }
						
						$selected="";
						if($period <> '') { if($cn_qry['period'] == $period) { $result['curr'] =  $cn_qry['period']; $selected=" selected "; } } 
						
						//$cn_secta  = array_map("clean_output", $cn_secta_a);
						
						$result['ops'][] = '<option '.$selected.'>'.$cn_qry['period'] .'</option>';
						$rec += 1;
					}
				}
			}
		}
		return $result;
	}
	
	
	function get_countyBudgetPeriodIndicators($county_id, $period = '')
	{
		$result = array();
		
		if($county_id) 
		{  
			$sq_qry = "SELECT
    `oc_county_budget`.`county_id`
    , `oc_county_budget`.`period`
    , SUM(`oc_county_budget`.`allocated`) AS `allocated`
    , SUM(`oc_county_budget`.`expensed`) AS `expensed`
    , `oc_county_budget`.`department`
    , COUNT(`oc_county_budget`.`project`) AS `num_projects`
    , `oc_conf_sources`.`source`
FROM
    `oc_county_budget`
    LEFT JOIN `oc_conf_sources` 
        ON (`oc_county_budget`.`source_id` = `oc_conf_sources`.`source_id`)
WHERE (`oc_county_budget`.`county_id` = ".$this->quote_si($county_id)." AND `oc_county_budget`.`period` = ".$this->quote_si($period).")
GROUP BY `oc_county_budget`.`period`, `oc_county_budget`.`department`
ORDER BY `oc_county_budget`.`period` DESC, `allocated` DESC LIMIT 8;";
				
			$rs_qry = $this->dbQuery($sq_qry);		
			
			$rec = 0;
			if($this->recordCount($rs_qry) > 0)
			{
				while($cn_qry_a = $this->fetchRow($rs_qry, 'assoc'))
				{
					$cn_qry  	= array_map("clean_output", $cn_qry_a);
					$result[] 	= $cn_qry; 
					
				}
			}
		}
		return $result;
	}
	
	
	
	function get_countyBudgetPeriodTotal($county_id, $period = '')
	{
		$result = array();
		
		if($county_id) 
		{  
			$sq_qry = "SELECT `county_id` , `period` , SUM(`allocated`) AS `allocated` , SUM(`expensed`) AS `expensed` FROM `oc_county_budget` WHERE (`county_id` = ".$this->quote_si($county_id)."  AND `period` = ".$this->quote_si($period).") GROUP BY `period` limit 1;";
				
			$rs_qry   = current($this->dbQueryFetch($sq_qry));		
			
			$val_allocated	= intval($rs_qry['allocated']); 
			$val_expensed	= intval($rs_qry['expensed']); 
			
			$result[] = array('name'=>'Allocated', 'y'=> $val_allocated ); 
			$result[] = array('name'=>'Expenditure', 'y'=> $val_expensed); 
			
			
		}
		return $result;
	}
	
	
	
	function get_countyBudgetHome($id, $period = '', $cdept = '')
	{
		$result = array();
		$data	= array();
		$sums 	= array();
		
		if($id) 
		{
			$sq_qry = "SELECT
    `county_id`
    , `period`
    , SUM(`allocated`) AS `allocated`
    , SUM(`expensed`) AS `expensed`
    , `department`
FROM
    `oc_county_budget`
WHERE (`county_id` = ".$this->quote_si($id)."  AND `period` = ".$this->quote_si($period).")
GROUP BY `period`, `department`;";
			
			$sq_dept = "";
			if($cdept <> '')
			{
				$sq_dept = " AND `department` = ".$this->quote_si($cdept)." ";
				
				$sq_qry = "SELECT
				`county_id`
				, `period`
				, SUM(`allocated`) AS `allocated`
				, SUM(`expensed`) AS `expensed`
				, `department`, `project`
				FROM
				`oc_county_budget`
				WHERE (`county_id` = ".$this->quote_si($id)."  AND `period` = ".$this->quote_si($period)."  ".$sq_dept.")
				GROUP BY `period`, `department`, `project`;";
			}
			
			//echobr($sq_qry);	
			$rs_qry = $this->dbQuery($sq_qry);		
			
			$rec = 0;
			if($this->recordCount($rs_qry) > 0)
			{
				while($cn_qry_a = $this->fetchRow($rs_qry, 'assoc'))
				{
					$cn_qry  		= array_map("clean_output", $cn_qry_a);
					
					$department 	= ucwords($cn_qry['department']); 
					$department_seo	= clean_alphanum($cn_qry['department']).'-';
					
					if($cdept <> '')
					{
						$department 	= ucwords($cn_qry['project']); 
						$department_seo	= clean_alphanum($cn_qry['project']).'-';
					}
					
					//$project 		= $cn_qry['project']; 
					$val_allocated	= intval($cn_qry['allocated']); 
					$val_expensed	= intval($cn_qry['expensed']); 
					
					$data['category'][]		= ucwords($department); 
					$data['allocated'][] 	= $val_allocated;
					$data['expensed'][] 	= $val_expensed;
					
					
					$datab['allocated'][] = array('name'=>''.$department.'', 'y'=> $val_allocated, 'drilldown' => $department_seo.'a'); 
					$datab['expenditure'][] = array('name'=>''.$department.'', 'y'=> $val_expensed, 'drilldown' => $department_seo.'e'); 
					
					$result['pie_alloc'][] = array('name'=>''.$department.'', 'y'=> $val_allocated, 'drilldown' => $department_seo.'a'); 
					$result['pie_expense'][] = array('name'=>''.$department.'', 'y'=> $val_expensed, 'drilldown' => $department_seo.'e'); 
					
				}
				$result['bar'] = $data;
				$result['drill'] = $datab;
			}
		}
		return $result;
	}
	
	
	
	
	function get_countyBudgetHomeDrill($id, $period = '')
	{
		$result = array();
		$data	= array();
		$sums 	= array();
		
		if($id) 
		{
			$sq_qryXX = "SELECT
    `county_id`
    , `period`
    , SUM(`allocated`) AS `allocated`
    , SUM(`expensed`) AS `expensed`
    , `department`, `project`
FROM
    `oc_county_budget`
WHERE (`county_id` = ".$this->quote_si($id)."  AND `period` = ".$this->quote_si($period).")
GROUP BY `period`, `department`, `project`;";
			
			$sq_qry = "SELECT
    `county_id`
    , `period`
    , SUM(`allocated`) AS `allocated`
    , SUM(`expensed`) AS `expensed`
    , `department`, `department_b`
FROM
    `oc_county_budget`
WHERE (`county_id` = ".$this->quote_si($id)."  AND `period` = ".$this->quote_si($period).")
GROUP BY `period`, `department`, `department_b`;";
				
			$rs_qry = $this->dbQuery($sq_qry);		
			
			$rec = 0;
			if($this->recordCount($rs_qry) > 0)
			{
				while($cn_qry_a = $this->fetchRow($rs_qry, 'assoc'))
				{
					$cn_qry  		= array_map("clean_output", $cn_qry_a);
					
					$department 	= $cn_qry['department']; 
					$department_seo	= clean_alphanum($department).'-';
					
					$project 		= $cn_qry['department_b']; 
					$val_allocated	= intval($cn_qry['allocated']); 
					$val_expensed	= intval($cn_qry['expensed']); 
					
					//$datab[$department_seo.'a'][$project] = $val_allocated; // array(''.$project.''=> $val_allocated); 
					//$datab[$department_seo.'e'][$project] = $val_expensed; //array(''.$project.''=> $val_expensed); 		
					
					$data[$department_seo.'a'][] = [''.$project.'', $val_allocated];
					$data[$department_seo.'e'][] = [''.$project.'', $val_expensed];
					//$data[$department_seo.'e'][] = array('id'=>$department_seo.'e', 'data' => $datab[$department_seo.'e']);
					//$data[$department_seo.'e'][] = array('id'=> ''.$department_seo.'e', 'data' => $datab[$department_seo.'e']);
					
					//$data[$department_seo.'a']['id'] = $department_seo.'a';
					//$data[$department_seo.'a']['data'][$project] = $val_allocated;
					//$data[$department_seo.'e']['data'][$project] = $val_expensed;
					
					//$data['allocated'][$department_seo.'a'][] = array('name'=>''.$project.'', 'y'=> $val_allocated); 
					//$data['expenditure'][$department_seo.'e'][] = array('name'=>''.$project.'', 'y'=> $val_expensed); 
				}
				$result = $data;
				//$result['drill'] = $datab;
			}
		}
		//echo (json_encode($data)); exit;
		return $result;
	}
	

	
	function get_countyBudgetHomeDrill_L3($id, $period = '')
	{
		$result = array();
		$data	= array();
		$sums 	= array();
		
		if($id) 
		{
			
			$sq_qry = "SELECT
    `county_id`
    , `period`
    , SUM(`allocated`) AS `allocated`
    , SUM(`expensed`) AS `expensed`
    , `department_b`, `project`
FROM
    `oc_county_budget`
WHERE (`county_id` = ".$this->quote_si($id)."  AND `period` = ".$this->quote_si($period).")
GROUP BY `period`, `department`, `department_b`;";
				
			$rs_qry = $this->dbQuery($sq_qry);		
			
			$rec = 0;
			if($this->recordCount($rs_qry) > 0)
			{
				while($cn_qry_a = $this->fetchRow($rs_qry, 'assoc'))
				{
					$cn_qry  		= array_map("clean_output", $cn_qry_a);
					
					$department 	= $cn_qry['department']; 
					$department_seo	= clean_alphanum($department).'-';
					
					$project 		= $cn_qry['department_b']; 
					$val_allocated	= intval($cn_qry['allocated']); 
					$val_expensed	= intval($cn_qry['expensed']); 
					
					//$datab[$department_seo.'a'][$project] = $val_allocated; // array(''.$project.''=> $val_allocated); 
					//$datab[$department_seo.'e'][$project] = $val_expensed; //array(''.$project.''=> $val_expensed); 		
					
					$data[$department_seo.'a'][] = [''.$project.'', $val_allocated];
					$data[$department_seo.'e'][] = [''.$project.'', $val_expensed];
					//$data[$department_seo.'e'][] = array('id'=>$department_seo.'e', 'data' => $datab[$department_seo.'e']);
					//$data[$department_seo.'e'][] = array('id'=> ''.$department_seo.'e', 'data' => $datab[$department_seo.'e']);
					
					//$data[$department_seo.'a']['id'] = $department_seo.'a';
					//$data[$department_seo.'a']['data'][$project] = $val_allocated;
					//$data[$department_seo.'e']['data'][$project] = $val_expensed;
					
					//$data['allocated'][$department_seo.'a'][] = array('name'=>''.$project.'', 'y'=> $val_allocated); 
					//$data['expenditure'][$department_seo.'e'][] = array('name'=>''.$project.'', 'y'=> $val_expensed); 
				}
				$result = $data;
				//$result['drill'] = $datab;
			}
		}
		//echo (json_encode($data)); exit;
		return $result;
	}
	

	
	
/* ============================================================================== 
/*	@BUILD: COUNTY FILES
/* ------------------------------------------------------------------------------ */		
	
function get_countyResources($county_id)
{
	$url  		= DOMAIN_DEVHUB.'api/_api.php?c='.$county_id;
	$json 		= file_get_contents($url);	
	$dataFiles  = json_decode($json, true);
	
	$_SESSION['sess_oc_resources'][$county_id] = $dataFiles['resources'];
	master::$listResources = $_SESSION['sess_oc_resources'];
	
	return true;
}	
	
	
	
/* ============================================================================== 
/*	@BUILD: COUNTY 
/* ------------------------------------------------------------------------------ */		

	function get_countyProfile($id)
	{
		$result = array();
		
		if($id) 
		{
			$sq_qry = "SELECT * FROM `oc_county`  WHERE (`county_id` = ".$this->quote_si($id)."); ";		
			$result = current($this->dbQueryFetch($sq_qry));		
			
			$county_name   	= trim($result['county']);
			$county_banner 	= 'images/background/'.$county_name.'_Gen.jpg';
			$county_map 	= 'images/maps/'.$county_name.'_Map.jpg';
			$county_web   	= ($result['website'] == '') ? 'http://'.clean_alphanum($county_name).'.go.ke' : $result['website'];
			
			
			$result['banner'] = $county_banner;
			$result['map'] = $county_map;
			$result['website'] = $county_web;
		}
		return $result;
	}
	

/* ============================================================================== 
/*	@BUILD: COUNTY LEADERS
/* ------------------------------------------------------------------------------ */		

	function get_countyLeaders($id, $type_id = '')
	{
		$result = array();
		$arrConstituency = array();
		$arrWard = array();
		
		$sq_crit = "";
		
		if($id) 
		{
		
			if($type_id <> ''){
				$sq_crit = "   AND  `oc_county_profiles`.`leader_type_id` = ".$this->quote_si($type_id)." ";
			}
			
			$sq_qry = "SELECT
			`oc_county_profiles`.*
			, `oc_conf_types`.`type_category`
			, `oc_conf_types`.`type_title`
			, `oc_conf_types`.`type_code`
		FROM
			`oc_county_profiles`
			INNER JOIN `oc_conf_types` 
				ON (`oc_county_profiles`.`leader_type_id` = `oc_conf_types`.`type_id`)
		WHERE (`oc_county_profiles`.`county_id` = ".$this->quote_si($id)." ".$sq_crit.")
		ORDER BY `oc_conf_types`.`seq`; ";	
			
		//$result = $this->dbQueryFetch($sq_qry);	
			$rs_qry = $this->dbQuery($sq_qry);			
			$rs_count =  $this->recordCount($rs_qry);

			if($rs_count > 0)
			{
				while($cn_qry_a = $this->fetchRow($rs_qry, 'assoc'))
				{
					$cn_qry 			= array_map("clean_output", $cn_qry_a);
					$type_code 			= $cn_qry['type_code'];
					$county_name 		= ''; //trim($cn_qry['county']);
					$avatar 			= ($cn_qry['avatar']<>'') ? $cn_qry['avatar'] : $county_name.$type_code.'.jpg';					
					$cn_qry['avatar'] 	= $avatar;
					
					$constituency 		= ucwords(strtolower($cn_qry['constituency']));
					//$ward 				= ucwords(strtolower($cn_qry['ward']));
					
					$result[$type_code][] = $cn_qry; 
					
					if($type_code == '_Mca'){
						if($constituency <> '' and !array_key_exists($constituency, $arrConstituency))
						{ $arrConstituency[$constituency] = $constituency; }
					}
					
					//if($ward <> '' and !array_key_exists($ward, $arrWard))
					//{ $arrWard[$ward] = $ward; }
					
				}
				
				asort($arrConstituency); $result['constituency'] = $arrConstituency;
				//asort($arrWard); $result['ward'] = $arrWard;
			}
		
		}
		return $result;
	}


	
	
/* ============================================================================== 
/*	@BUILD: COUNTY CONSTITUENCIES
/* ------------------------------------------------------------------------------ */		

function get_countyConstituency($county_id)
{
	$result = array();

	$sq_secta = "SELECT `sector_id`, `sector_name`, `heading`, `fa_class` FROM `oc_conf_sectors` where `devolved`='1' ORDER BY `seq` ASC limit 0, 6; ";		
	$rs_secta = $this->dbQuery($sq_secta);		

	if($this->recordCount($rs_secta) > 0)
	{
		while($cn_secta_a = $this->fetchRow($rs_secta, 'assoc'))
		{
			$cn_secta  = array_map("clean_output", $cn_secta_a);
			$sector_id = $cn_secta['sector_id'];

			$card_data = $this->get_countyDataCards($county_id, $sector_id);

			$sector = '<div class="col-md-2 padd0_3"><div class="sector clearfix">
				  <div class="heading '.$cn_secta['heading'] .'">
				  <i class="fa '. $cn_secta['fa_class'] .'"></i>
				  <a href="#"><h3>'. $cn_secta['sector_name'] .'</h3></a>
				  </div>'.implode('', $card_data).'</div></div>';
			//$sector .= implode('', $card_data);
			$result[] = $sector;
		}
	}

	return $result;
}
	
	
	
/* ============================================================================== 
/*	@BUILD: COUNTY CARDS
/* ------------------------------------------------------------------------------ */		

	function get_countySectorCards($county_id)
	{
		$result = array();
		
		$sq_secta = "SELECT `sector_id`, `sector_name`, `heading`, `fa_class` FROM `oc_conf_sectors` where `devolved`='1' ORDER BY `seq` ASC limit 0, 6; ";		
		$rs_secta = $this->dbQuery($sq_secta);		
		
		if($this->recordCount($rs_secta) > 0)
		{
			while($cn_secta_a = $this->fetchRow($rs_secta, 'assoc'))
			{
				$cn_secta  = array_map("clean_output", $cn_secta_a);
				$sector_id = $cn_secta['sector_id'];
				
				$card_data = $this->get_countyDataCards($county_id, $sector_id);
				
				$sector = '<li><div class="Xcol-md-3X padd0_3"><div class="sector clearfix">
					  <div class="heading '.$cn_secta['heading'] .'">
					  <i class="fa '. $cn_secta['fa_class'] .'"></i>
					  <a href="#"><h3>'. $cn_secta['sector_name'] .'</h3></a>
					  </div>'.implode('', $card_data).'</div></div></li>';
				//$sector .= implode('', $card_data);
				$result[] = $sector;
			}
		}
					
		return $result;
	}
	
	
	function get_countyDataCards($county_id, $sector_id)
	{
		$card = array();
		
		$sq_qry = "SELECT
    `oc_county_sector_cards`.`id`
    , `oc_conf_sources`.`source`
    , `oc_county_sector_cards`.`indicator`
    , `oc_county_sector_cards`.`value`
    , `oc_county_sector_cards`.`dated` AS `period`
    , `oc_county_sector_cards`.`county_id`
    , `oc_county_sector_cards`.`sector_id`
FROM
    `oc_county_sector_cards`
    LEFT JOIN `oc_conf_sources` 
        ON (`oc_county_sector_cards`.`source_id` = `oc_conf_sources`.`source_id`)
WHERE (`oc_county_sector_cards`.`county_id` = ".$this->quote_si($county_id)."
    AND `oc_county_sector_cards`.`sector_id` = ".$this->quote_si($sector_id).")
ORDER BY `oc_county_sector_cards`.`inputdate` DESC LIMIT 2;";		// 
		$rs_qry = $this->dbQuery($sq_qry);		
		
		if($this->recordCount($rs_qry) > 0)
		{
			$c=1;
			while($cn_qry_a = $this->fetchRow($rs_qry, 'assoc'))
			{
				$cn_qry  = array_map("clean_output", $cn_qry_a);
				
				$card[] = '<div class="col-md-12 no'. $c .'">
							  <h5>'.$cn_qry['source'] .'</h5>
							  <h4>'.$cn_qry['value'] .'</h4> 
							  <h6>'.$cn_qry['indicator'] .'</h6>
							  <h5 class="date">As of '.$cn_qry['period'] .'</h5>
                          </div>';
				$c++;	
			}
		}
		else 
		{
			$card[] = '<div class="col-md-12 no-1"><p class="no-data"><i class="fa fa-exclamation-triangle"></i> No data available</p></div>';
		}
					
					
		return $card;
	}
	
	
	
	
	
/* ============================================================================== 
/*	@BUILD: FACTSHEETS
/* ------------------------------------------------------------------------------ */		
	
	
	function get_factsheetSectorCards($county_id)
	{
		$result = array();
		
		$sq_secta = "SELECT `sector_id`, `sector_name`, `heading`, `fa_class` FROM `oc_conf_sectors` where `devolved`='1' ORDER BY `seq` ASC limit 0, 6; ";		
		$rs_secta = $this->dbQuery($sq_secta);		
		
		if($this->recordCount($rs_secta) > 0)
		{
			while($cn_secta_a = $this->fetchRow($rs_secta, 'assoc'))
			{
				$cn_secta  = array_map("clean_output", $cn_secta_a);
				$sector_id = $cn_secta['sector_id'];
				
				$card_data = $this->get_factsheetDataCards($county_id, $sector_id);
				
				$result[$sector_id] = $cn_secta;
				$result[$sector_id]['data'] = $card_data;
			}
		}
					
		return $result;
	}
	
	
	function get_factsheetDataCards($county_id, $sector_id)
	{
		$card = array();
		
		$sq_qry = "SELECT
    `oc_county_sector_cards`.`id`
    , `oc_conf_sources`.`source`
    , `oc_county_sector_cards`.`indicator`
    , `oc_county_sector_cards`.`value`
    , `oc_county_sector_cards`.`dated` AS `period`
    , `oc_county_sector_cards`.`county_id`
    , `oc_county_sector_cards`.`sector_id`
FROM
    `oc_county_sector_cards`
    LEFT JOIN `oc_conf_sources` 
        ON (`oc_county_sector_cards`.`source_id` = `oc_conf_sources`.`source_id`)
WHERE (`oc_county_sector_cards`.`county_id` = ".$this->quote_si($county_id)."
    AND `oc_county_sector_cards`.`sector_id` = ".$this->quote_si($sector_id).")
ORDER BY `oc_county_sector_cards`.`inputdate` DESC LIMIT 3 ;";		//LIMIT 2 
		$rs_qry = $this->dbQuery($sq_qry);		
		
		if($this->recordCount($rs_qry) > 0)
		{
			while($cn_qry_a = $this->fetchRow($rs_qry, 'assoc'))
			{
				$cn_qry  = array_map("clean_output", $cn_qry_a);
				
				$card[] = $cn_qry;				
			}
		}
		return $card;
	}
	
	
	
	
	function get_factsheetBudget($id, $period = '', $cdept = '')
	{
		$result = array();
		$data	= array();
		$sums 	= array();
		
		if($id) 
		{
			$sq_qry = "SELECT
    `county_id`
    , `period`
    , SUM(`allocated`) AS `allocated`
    , SUM(`expensed`) AS `expensed`
    , `department`
FROM
    `oc_county_budget`
WHERE (`county_id` = ".$this->quote_si($id)."  AND `period` = ".$this->quote_si($period).")
GROUP BY `period`, `department`;";
			
			$sq_dept = "";
			
			//echobr($sq_qry);	
			$rs_qry = $this->dbQuery($sq_qry);		
			
			$rec = 0;
			if($this->recordCount($rs_qry) > 0)
			{
				while($cn_qry_a = $this->fetchRow($rs_qry, 'assoc'))
				{
					$cn_qry  		= array_map("clean_output", $cn_qry_a);
					
					$department 	= ucwords($cn_qry['department']); 
					$data['category'] = $department;
					$data['allocated'] = intval($cn_qry['allocated']); 
					$data['expensed'] = intval($cn_qry['expensed']); 
					
					
					$result[]	= $data;
					
					//$project 		= $cn_qry['project']; 
					/*$val_allocated	= intval($cn_qry['allocated']); 
					$val_expensed	= intval($cn_qry['expensed']); 
					
					$data['category'][]		= ucwords($department); 
					$data['allocated'][] 	= $val_allocated;
					$data['expensed'][] 	= $val_expensed;*/
					
					
					/*$datab['allocated'][] = array('name'=>''.$department.'', 'y'=> $val_allocated, 'drilldown' => $department_seo.'a'); 
					$datab['expenditure'][] = array('name'=>''.$department.'', 'y'=> $val_expensed, 'drilldown' => $department_seo.'e'); 
					
					$result['pie_alloc'][] = array('name'=>''.$department.'', 'y'=> $val_allocated, 'drilldown' => $department_seo.'a'); 
					$result['pie_expense'][] = array('name'=>''.$department.'', 'y'=> $val_expensed, 'drilldown' => $department_seo.'e');*/ 
					
				}
				//$result = $data;
				//$result['drill'] = $datab;
			}
		}
		return $result;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

/* ============================================================================== 
/*	MEMBER EXIST
/* ------------------------------------------------------------------------------ */	
	
	function account_checkExist($account_email)
	{
		$result = 0;
		$sq_check = "SELECT * FROM `olnt_reg_account` WHERE (`email` = ".$this->quote_si($account_email).")";
		$rs_check = $this->dbQuery($sq_check);
	
		if($this->recordCount($rs_check)>=1) { 
			$result = 1;
		}
		return $result;
	}

/* ============================================================================== 
/*	MEMBER LEVELS
/* ------------------------------------------------------------------------------ */	
	
	function account_saveLevel($account_id, $levels)
	{
		$sq_qry = array();
		$sq_del = "delete from `pom_reg_accounts_to_levels` WHERE `account_id`= ".$this->quote_si($account_id)." ; ";
		$this->dbQuery($sq_del);
		
		foreach($levels as $level_id)
		{
			$sq_qry[] = "INSERT INTO `pom_reg_accounts_to_levels` (`level_id`, `account_id`) values (".$this->quote_si($level_id).", ".$this->quote_si($account_id)."); ";	
		}
		//displayArray($sq_qry); exit;
		if(count($sq_qry)) { $this->dbQueryMulti($sq_qry); }
	}


/* ============================================================================== 
/*	@BUILD: BREADCRUMBS
/* ------------------------------------------------------------------------------ */	

	function get_breadcrumb($cat, $cat_id = '')
	{
		$parent = '';
		$parent_ref = '#';
		$current_ref = '';
		
		$refs['pet_list'] = array('lbl' => 'petitions', 'ref' => 'index.php?tab=petitions', 'pgt' => 'petition details');
		$refs['members'] = array('lbl' => 'member accounts', 'ref' => 'index.php?tab='.$cat.'', 'pgt' => 'account details');
		$refs['profile'] = array('lbl' => 'member accounts', 'ref' => 'index.php?tab='.$cat.'', 'pgt' => 'account details');
		$refs['courts'] = array('lbl' => 'court list', 'ref' => 'index.php?tab='.$cat.'', 'pgt' => 'court details');
		$refs['prisons'] = array('lbl' => 'prisons list', 'ref' => 'index.php?tab='.$cat.'', 'pgt' => 'prison details');
		
		$refs['tasks'] = array('lbl' => 'pending tasks', 'ref' => 'index.php?tab='.$cat.'', 'pgt' => '');
		$refs['notifications'] = array('lbl' => 'notification list', 'ref' => 'index.php?tab='.$cat.'', 'pgt' => '');
		
		switch($cat)
		{ 
			case "petitions":
			case "viewpetition":
			case "comments":
			$parent 	 = $refs['pet_list']['lbl'];
			$parent_ref = $refs['pet_list']['ref'];
			if($cat_id <> ''){
				$current_ref = $refs['pet_list']['pgt'] . '&nbsp; <b>&rsaquo;</b>';
			}
			break;
			
			case "members":
			case "courts":
			case "prisons":
			case "tasks":
			case "notifications":
			$parent 	 = $refs[$cat]['lbl'];
			$parent_ref = $refs[$cat]['ref'];
			if($cat_id <> ''){
				$current_ref = '<b>&rsaquo;</b> &nbsp;'. $refs[$cat]['pgt'] . '&nbsp; <b>&rsaquo;</b>';
			}
			break;
		}
		
		
		echo '<!-- @beg:: bcrumbs -->
<div class="breadcrumbs">
	<div class="subcolumnsX breadcrumbpadd"><a href="./">dashboard</a>&nbsp; <b>&rsaquo;</b> &nbsp;
		<a href="'.$parent_ref.'">'.$parent.'</a>&nbsp; 
		'.$current_ref.' 	
	</div>
</div>
<!-- @end:: bcrumbs -->	
';
	}
		
		
/* ============================================================================== 
/*	@BUILD: STATS
/* ------------------------------------------------------------------------------ */		

	function stat_records($tb, $crit = '')
	{
		$us_id	 	= $_SESSION['sess_pom_member']['u_id'];
		$us_level_id  = $_SESSION['sess_pom_member']['u_level_id'];
		
		$user_crit 	= ($us_level_id <> 1 and $us_level_id <> 3) ? " and `account_id` = ".$this->quote_si($us_id)." " : "";
		 
		$result  = 0;
		$tb_name = '';
		
		if($tb == 'pet_new'){
			$sq_qry = "SELECT count(*) FROM `pom_petition_details` WHERE (`published` = 1) and (`status_id` = 1) $user_crit;";		
			$rs_qry = $this->dbQuery($sq_qry);	
			$cn_qry = $this->fetchRow($rs_qry);			
			$result = $cn_qry[0];		
		}
		elseif($tb == 'pet_open'){
			$sq_qry = "SELECT count(*) FROM `pom_petition_details` WHERE (`published` = 1) and (`admissible` = 1) $user_crit;";		
			$rs_qry = $this->dbQuery($sq_qry);	
			$cn_qry = $this->fetchRow($rs_qry);			
			$result = $cn_qry[0];		
		}
		elseif($tb == 'pet_approved'){
			$sq_qry = "SELECT count(*) FROM `pom_petition_details` WHERE (`published` = 1) and (`approved` = 1) $user_crit;";		
			$rs_qry = $this->dbQuery($sq_qry);	
			$cn_qry = $this->fetchRow($rs_qry);			
			$result = $cn_qry[0];		
		}
		elseif($tb == 'pet_recommendXXX'){
			$sq_qry = "SELECT count(*) FROM `pom_petition_details` WHERE (`published` = 1) and (`approved` = 1) $user_crit;";		
			$rs_qry = $this->dbQuery($sq_qry);	
			$cn_qry = $this->fetchRow($rs_qry);			
			$result = $cn_qry[0];		
		}
		
		elseif($tb == 'pet_comments'){
			$sq_qry = "SELECT count(*) FROM `pom_petition_comments` WHERE (`petition_id` = ".$this->quote_si($crit).")  and `parent_id` = 0 ;";		
			$rs_qry = $this->dbQuery($sq_qry);	
			$cn_qry = $this->fetchRow($rs_qry);			
			$result = $cn_qry[0];		
		}
		
		
		
		elseif($tb == 'pet_votes')
		{
			$out = array();
			
			/*$sq_votes = "SELECT count(*) FROM `pom_petition_committee` WHERE (`petition_id` =".$this->quote_si($crit).") ; ";		
			$rs_votes = $this->dbQuery($sq_votes);	
			$cn_votes = $this->fetchRow($rs_votes);			
			$out['sum'] = $cn_votes[0];	*/
			
			$sq_qry = "SELECT `petition_id` , `vote` , COUNT(`vote`) AS `vote_num` FROM `pom_petition_committee` WHERE (`petition_id` =".$this->quote_si($crit).") GROUP BY `petition_id`, `vote`; ";		
			$rs_qry = $this->dbQuery($sq_qry);	
			
			$vnum = 0;
			if($this->recordCount($rs_qry) > 0) 
			{
				while($cn_qry = $this->fetchRow($rs_qry, 'assoc')) {
					$vnum = $vnum + $cn_qry['vote_num'];
					$out[$cn_qry['vote']] = $cn_qry['vote_num'];
				}
			}
			$out['sum'] = $vnum;
			$result = $out;
					
		}
		
		
		
		elseif($tb == 'pet_votes_yes'){
			$sq_qry = "SELECT count(*) FROM `pom_petition_comments` WHERE (`petition_id` = ".$this->quote_si($crit).")  and `vote` = 1 ;";		
			$rs_qry = $this->dbQuery($sq_qry);	
			$cn_qry = $this->fetchRow($rs_qry);			
			$result = $cn_qry[0];		
		}
		elseif($tb == 'pet_votes_no'){
			$sq_qry = "SELECT count(*) FROM `pom_petition_comments` WHERE (`petition_id` = ".$this->quote_si($crit).")  and `vote` = 2 ;";		
			$rs_qry = $this->dbQuery($sq_qry);	
			$cn_qry = $this->fetchRow($rs_qry);			
			$result = $cn_qry[0];		
		}
		
		
		elseif($tb == 'pet_rating'){
			//$sq_qry = "SELECT AVG(`rating`) AS `rating`, `petition_id` FROM `pom_petition_comments` WHERE (`petition_id` =".$this->quote_si($crit)." AND `parent_id` =0 AND `published` =1) GROUP BY `petition_id`;";
			$sq_qry = "SELECT AVG(`rating`) AS `rating`, `petition_id` FROM `pom_petition_committee` WHERE (`petition_id` =".$this->quote_si($crit)."  and rating <> '0') GROUP BY `petition_id`;";		
			$rs_qry = $this->dbQuery($sq_qry);	
			$cn_qry = $this->fetchRow($rs_qry);			
			$result = floor($cn_qry[0]).'/10';		
		}
		else
		{
			$crit = "";
			if($tb == 'members') { $tb_name = '`casft_member`'; }
			if($tb == 'committees') { $tb_name = '`casft_committee`'; }
			if($tb == 'imprests') { $tb_name = '`casft_imprest`'; $crit = " and `approved` = 0 "; }// and `submit_status` = 0
			
			
			
			if($tb_name <> '') {
				$sq_qry = "SELECT count(*) FROM $tb_name WHERE (`published` = 1 $crit) ;";		
				$rs_qry = $this->dbQuery($sq_qry);	
				$cn_qry = $this->fetchRow($rs_qry);
				
				$result = $cn_qry[0];
			}
		}
		return $result;
	}

	
	

/*
* END CLASS
*/	
}


$dispOc = new data_oc;
//$dispCa->build_committees();
?>