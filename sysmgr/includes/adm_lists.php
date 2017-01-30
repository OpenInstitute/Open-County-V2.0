<div style="padding:5px; text-align:right; font-size:14px; font-weight:bold;"> <a href="hforms.php?d=<?php echo $dir; ?>&op=new" style="color:#FF0000">[ ADD NEW ]</a> </div>
<?php
//echo $dir;

if($dir == 'menus')
{	  
	 $sqList = "SELECT
    `oc_dt_menu`.`menu_id` as `id`
    , `oc_dt_menu`.`menu_title` AS `title`
    , `oc_dt_conf_sections`.`section_title` AS `section`
    , `oc_dt_conf_menu_type`.`menutype` AS `menu_type`
    , `oc_dt_menu`.`menu_href` as `menu_link`
    , `oc_dt_conf_sections`.`section_link`
    , `oc_dt_menu`.`seq` AS `pos.`
    , `oc_dt_menu`.`published` AS `active`
FROM
    `oc_dt_menu`
    LEFT JOIN `oc_dt_conf_sections` 
        ON (`oc_dt_menu`.`id_section` = `oc_dt_conf_sections`.`section_id`)
    LEFT JOIN `oc_dt_conf_menu_type` 
        ON (`oc_dt_menu`.`id_type_menu` = `oc_dt_conf_menu_type`.`menutype_id`)
ORDER BY `oc_dt_menu`.`id_type_menu` ASC, `oc_dt_menu`.`seq` ASC;"; 
	  echo $m2_data->getData($sqList,"hforms.php?d=$dir&");
}

elseif($dir == 'articles')
{	  
	$sqList = "SELECT
    `oc_dt_content`.`content_id` as `id`
    , `oc_dt_content`.`content_created` AS `item_date`
    , `oc_dt_content`.`content_title` AS `title`
    , `oc_dt_menu`.`menu_title` AS `parent`
    , `oc_dt_conf_sections`.`section_title` AS `section`
    , `oc_dt_content`.`seq` AS `pos.`
    , `oc_dt_content`.`published` AS `active`
FROM
    `oc_dt_content`
    LEFT JOIN `oc_dt_content_parent` 
        ON (`oc_dt_content`.`content_id` = `oc_dt_content_parent`.`content_id`)
    INNER JOIN `oc_dt_conf_sections` 
        ON (`oc_dt_content`.`id_section` = `oc_dt_conf_sections`.`section_id`)
    LEFT JOIN `oc_dt_menu` 
        ON (`oc_dt_content_parent`.`menu_id` = `oc_dt_menu`.`menu_id`)
ORDER BY `item_date` DESC, `title` ASC;";
	  
		 echo $m2_data->getData($sqList,"hforms.php?d=$dir&");
}

elseif($dir == 'resources')
{	  
	 $sqList = "SELECT
    `oc_dt_resources`.`resource_id` AS `id`
    , `oc_dt_resources`.`date_created` AS `posted`
    , `oc_dt_resources`.`resource_title` AS `title`
    , `oc_dt_resources`.`resource_file` AS `filename`
    , `oc_dt_menu`.`menu_title` AS `parent`
    , `oc_county`.`county`
    , `oc_dt_resources`.`published` AS `active`
    , `oc_dt_resources`.`resource_type`
FROM
    `oc_dt_resources`
    LEFT JOIN `oc_dt_resources_parent` 
        ON (`oc_dt_resources`.`resource_id` = `oc_dt_resources_parent`.`resource_id`)
    LEFT JOIN `oc_dt_menu` 
        ON (`oc_dt_resources_parent`.`menu_id` = `oc_dt_menu`.`menu_id`)
    LEFT JOIN `oc_county` 
        ON (`oc_dt_resources_parent`.`county_id` = `oc_county`.`county_id`)
ORDER BY `id` DESC;";
	  
	  
		 echo $m2_data->getData($sqList,"hforms.php?d=$dir&");
}














elseif($dir == 'sectors')
{	  
	 $sqList = "SELECT
    `oc_app_sector`.`sector_id`
    , `oc_app_sector`.`title`
	, `oc_app_sector`.`description`
    , COUNT(DISTINCT `oc_app_project`.`project_id`) AS `num_projects`
	, `oc_app_sector`.`published` as `visible`
FROM
    `oc_app_sector`
    LEFT JOIN `oc_app_project` 
        ON (`oc_app_sector`.`sector_id` = `oc_app_project`.`sector_id`)
GROUP BY `oc_app_sector`.`sector_id`
ORDER BY `oc_app_sector`.`seq`, `oc_app_sector`.`title` ASC;"; 
	  
	  
		 echo $m2_data->getData($sqList,"hforms.php?d=$dir&");
}



elseif($dir == 'locations')
{	  
	 $sqList = "SELECT
    `location_id`
    , `name` AS `location_name`
    , `lon` AS `longitude`
    , `lat` AS `latitude`
	, `published` as `visible`
FROM
    `oc_app_location`;"; 
	  
	  
		 echo $m2_data->getData($sqList,"hforms.php?d=$dir&");
}



elseif($dir == 'ministries')
{	  
	 $sqList = "SELECT
    `oc_app_ministry`.`ministry_id`
    , `oc_app_ministry`.`name`
    , COUNT(`oc_app_project`.`project_id`) AS `num_projects`
FROM
    `oc_app_ministry`
    LEFT JOIN `oc_app_project` 
        ON (`oc_app_ministry`.`ministry_id` = `oc_app_project`.`ministry_id`)
GROUP BY `oc_app_ministry`.`ministry_id`;"; 
	  
	  
		 echo $m2_data->getData($sqList,"hforms.php?d=$dir&");
}



?>
