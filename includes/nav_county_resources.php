<?php
//displayArray(master::$listResources);	
if(!array_key_exists($cid,master::$listResources)){ $dispOc->get_countyResources($cid); }
$section_items  = master::$listResources[$cid];
//echobr(DOMAIN_DEVHUB);
//displayArray($section_items);	


$page_recs_count 	  = count($section_items);	

/* =================== @@ beg :: PAGINATOR @@ ====== */

$items_per_page = 10;

$pages = new Paginator;
$pages->items_total = $page_recs_count;
$pages->mid_range = 7; 
$pages->custom_ipp = $items_per_page;	
$pages->paginate();


$page_current 	  = $pages->current_page;
$page_recs_start   = 1;
$page_recs_end     = $page_current * $items_per_page;

if($page_current > 1) { 
	$page_recs_start = (($page_current - 1) * $items_per_page) + 1; }
if($page_recs_end > $page_recs_count) { 
	$page_recs_end = $page_recs_count; }

$dir_result = '<div class="txtright padd10X">Results: '.$page_recs_start.' - '.$page_recs_end.' of '.$page_recs_count.'</div>';


if($page_recs_count == 0) {
	$dir_result = 'No items found!'; //'<div class="note txtcenter padd10">No items found!</div>';
}

$pages_head="<div class='padd10'></div><div class=\"paginator\">".$pages->display_pages()."<span class=\"pagejump\">".$pages->display_jump_menu()."</span></div>";

if(isset($_GET['isec']))  { $pages_head= '<div class="padd5_t box-more"><a href="library.php?com='.$com_active.'" class="postDate read_more_right">VIEW MORE </a></div>'; }

/* =================== @@ end :: PAGINATOR @@ ====== */


/* #Display Form */
if(count($section_items))
{
?>

<div class="subcolumns info" style="display:">

<?php //include("includes/nav_downloads-search.php"); ?>

</div>

<?php	
}
/* END#Display Form */




$page_to_display  = $pages->current_page - 1;
$section_pages 	= array_chunk($section_items, $items_per_page, true);

$fcontent 	     = '';
//displayArray($section_pages); exit;
if(count($section_pages))
{
	$contPages 		= $section_pages[$page_to_display];
	$loopNum 		= 1;
	
	//displayArray(current(master::$listResources['full']));
	foreach ($contPages as $contKey => $contArray) 						
	{
		
		$item_id			= $contArray['resource_id'];
		$item_title		 = clean_output($contArray['resource_title']);
		$item_brief		 = clean_output($contArray['resource_description']);
		$item_brief	   	 = string_truncate(strip_tags_clean($item_brief), 20); 
		$item_author	    = clean_output($contArray['publisher']);
		$item_lang	      = clean_output($contArray['language']);
		$item_category		  = $contArray['content_type']; 
		$item_pub_year	      = clean_output($contArray['year_published']);
		
		$item_parent	      = clean_output($item_category);
		$item_parent_label = '<span class="txtgreen txt12" title="Section">'. $item_parent . '</span> &nbsp; | &nbsp;';
		
		$item_cat 	  = ' &nbsp;<span class="postDate nocaps txt12">('.@$parent_name.')</span> ';
		
		
		$item_date		  = date("Y, M d", strtotime($contArray['date_updated']));
		
		$item_name		  = $contArray['resource_file']; 
		$item_protocol   = substr($item_name,0,3);
		$item_ext        = strtolower(substr(strrchr($item_name,"."),1));
		
		$link = ' href="'.DOMAIN_DEVHUB.'resource.php?com=resources&id='.$item_id.'" ';	
		$highlite_cls = $highlite_img = $file_video = '';
		$item_link = '<a '.$link.' class="'.$item_ext . $highlite_cls.'">'.$highlite_img . $item_title .'</a> '.$file_video;
		
		
		
		if($item_author <> '') 
		{ $item_author = "<span class='txt12 txtorange' title='Publisher'><strong></strong> ".$item_author." </span>"; }
		
		if($item_lang <> '') 
		{ $item_lang = "&nbsp; | &nbsp;<span class='txt12 txtgraylight' title='language'><strong></strong> ".$item_lang."</span>"; }
		
		if($item_pub_year <> '') 
		{ $item_pub_year = "&nbsp; | &nbsp;<span class='txt12 txtgraylight' title='Published'><strong></strong> ".$item_pub_year."</span>"; }
		
		
		$item_desc = "<div class=\"trunc1200X\"><em>".$item_parent_label.$item_author . $item_lang . $item_pub_year ."</em><br>". $item_brief."</div>";
		
		
		$item_cover = '';
			
		$upload_icon_disp = ''; //'<span class="carChopa no-image" style="width:70px; max-height:70px;"></span>';
		$icon_box = '';
		$icon_spacer = '';
		if($item_cover <> '' and (file_exists(UPL_COVERS.$item_cover)))
		{
			$icon_box = ' width:70px;';
			$icon_spacer = 'margin-left:80px;';
			$upload_icon_disp	  = '<span class="carChopa" style="width:70px;max-height:70px;"><img src="'.DISP_COVERS.$item_cover.'" alt="" /></span>';
		}
		
		$fcontent .=  '<li><div class="block equalizedX" style=""><div style="float:left;'.$icon_box.'">'.$upload_icon_disp.'</div>
		<div style="width:auto;'.$icon_spacer.'"><div class="padd5">'.$item_link.'' . $item_desc . ' </div></div></div></li>';
		
	
	}
	
}
	//exit;
	
	
	//echo $dir_result;
$dir_resultb = '';

if (isset($_REQUEST['formname']) and $_REQUEST['formname'] =='fm_dir_search')
{ 
	$sResult = '';
	if($sRequest['keyword'] <> '') { $sResult .= '<b>'.$sRequest['keyword'].'</b> &nbsp; '; }
	if($sRequest['county'] <> '') { $sResult .= '<em>county: </em><b>'.$sRequest['county'].'</b> &nbsp; '; }
	if($sRequest['dir_year'] <> '') { $sResult .= '<em>year: </em><b>'.$sRequest['dir_year'].'</b> &nbsp; '; }
	if($sRequest['dir_type'] <> '') { $sResult .= '<em>Category: </em><b>'.$sRequest['dir_type'].'</b> &nbsp; '; }
	
	$dir_resultb = '<div class="subcolumns note noborder"><div class="col-md-9">Search for: '.$sResult.'</div><div class="col-md-3 txtright">'.$dir_result.'</div></div>';
}
	echo $dir_resultb;
	
	echo '<div><ul id="" class="column column_full cont_dloads">';
	echo $fcontent;
	echo '</ul></div>';
	
	//echo $pages_head;
/* ======== @@ PAGINATOR @@ ====== */	
if($page_recs_count > $pages->custom_ipp) {
	echo $pages_head;
}
/* =============================== */

	echo '<!--<div class="padd10"></div><div class="note">Didnt find what you were looking for? Click here</div>-->';
	
?>