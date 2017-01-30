<?php
require_once('../classes/cls.constants.php');
require_once('../classes/cls.functions_misc.php');
require_once('includes/sys_gal_functions.php');
//require("includes/adm_functions.php");


//ini_set('display_errors', 'off');
//ini_set('error_reporting', 'off');


/* ============================================================================== 
/*	SPAM BLOCK! 
/* ------------------------------------------------------------------------------ */
if($_SERVER['REQUEST_METHOD'] !== 'POST') { 
echo "<script language='javascript'>location.href=\"index.php?qst=401&token=".$conf_token."\"; </script>"; exit; }

if (isset($_POST['nah_snd'])){$nah_snd=$_POST['nah_snd'];} else {$nah_snd='';}
if(strlen($nah_snd)>0) {echo "<script language='javascript'>location.href=\"index.php\"; </script>"; exit; }

/* ============================================================================== */




/* ============================================================================== 
/*	FORM FUNCTIONS
/* ------------------------------------------------------------------------------ */

$debugmail = $GLOBALS['NOTIFY_DEBUG'];
//echobr($GLOBALS['EMAIL_TEMPLATE']);

$post	 	= array_map("filter_data", $_POST);
$postb 		= array_map("q_si", $post);

$formname    = (isset($post['formname']))  ? $post['formname'] : '';
$formaction  = (isset($post['formaction']))  ? $post['formaction'] : '';
$redirect    = (isset($post['redirect'])) ? $post['redirect'] : 'home.php';
$formtab     = (isset($post['formtab']))  ? $post['formtab'] : '';
$post_by     = (isset($post['post_by'])) ? $post['post_by'] : @$us_id;

$log_desc	= ($formaction <> '') ? clean_title($formaction): 'User action: ';
$log_notify  = 1;

$published 	= yesNoPost(@$post['published']); $post['published'] = $published;
$approved  	= yesNoPost(@$post['approved']);
$mailing    = yesNoPost(@$post['mailing']);

if(strripos($redirect,"?")){ $redstr="&"; } else {$redstr="?";}

$post_by = @$sys_us_admin['admin_id'];
$post_by =1;
$field_names = array_keys($post);


$type 	= new posts;
$formLog = new hitsLog;
$sq_files   = array();

$fields_ignore = array("formname","formaction","formtab","id","redirect","saveform","publishval","date_post","submit","resource_attr", "change_image", "petitioner_id", "representative_id", "menu_date", "add_content", "id_parent1", "article", "file_type", "video_name", "video_caption", "photo_url_name", "photo_url_caption", "photo_caption");
//"post_by",

//displayArray($_SESSION['sess_pom_pet']);	
//displayArray($post); 
//displayArray($_FILES); 
//exit;


if (!isset($sys_us_admin['adminname']) and $formname<>"admin_log") { ?> <!--<script language="javascript">location.href="index.php";</script>--> <?php }
	



/* ============================================================================== 
/*	RESOURCES
/* ------------------------------------------------------------------------------ */

if($formname=="fm_resources")
{
	$fields_ignore[] = "res_attr";
	$fields_ignore[] = "county_id";
	$menu_parent 	 = @$post['id_parent1'];
	$county_parent 	 = @$post['county_id'];
	
	$file_seo 	 = generate_seo_title($post['resource_title'], '-');	
	$file_key 	 = hash("crc32", $file_seo);
	
	
	if($post['post_by'] == ''){ $post['post_by']  = $post_by; }
	
if($post['resource_title'] == '')
{	
	echo '<script>location.href="hforms.php?d=resources&op=new";</script>'; exit;
}
else
{
	$post['resource_attributes'] = $post['res_attr']; 
	
	if(isset($_FILES['fupload']) and strlen($_FILES['fupload']['name']) > 4) 
	{
		$res_upload   = $_FILES['fupload'];	
		$dfile 		= $res_upload['name'];
		$doc_ext      = ".".strtolower(substr(strrchr($dfile,"."),1));
		
		$doc_newname  = substr($file_key.'-'.$file_seo,0,45).$doc_ext;
		$doc_temp     = $res_upload['tmp_name'];		
		$doc_target   = UPL_FILES . $doc_newname;
		
		if(move_uploaded_file($doc_temp, $doc_target)) { 
			$post['resource_file'] = $doc_newname; 
			$post['resource_mime'] = $res_upload['type'];
			$post['resource_size'] = $res_upload['size'];
		}
			
	}
	
	$col_names = array(); $col_values = array();
		
	foreach($post as $b_key => $b_val)  {
		$field = strtolower($b_key);		
		if(!in_array($field, $fields_ignore)) {
			if($formaction=="_new") 
			{
				$col_names[] = "`$field`";	
				$col_values[] = "".q_si($b_val)."";
			} 
			elseif($formaction=="_edit") 
			{
				$col_names[] = " `$field` = ".q_si($b_val).""; 
			}
		}			
	}
	
	
	if($formaction=="_new")  { 
		$sq_post = "INSERT IGNORE INTO `oc_dt_resources` (".implode($col_names, ', ').") values (".implode($col_values, ', ')."); "; 
	} 
	elseif($formaction=="_edit")  { 
		$post_id = $post['id'];
		$sq_post = "UPDATE `oc_dt_resources` set  ".implode($col_names, ', ')." where (`resource_id` = ".q_si($post_id)." )" ;
	}
	
	//echobr($sq_post); exit;		
	$rs_post = $cndb->dbQuery($sq_post);
	
	if($formaction=="_new") { 
		$post_id = $cndb->insertId($rs_post);  
	} 
	
/* ************************************************************** 
@ update resource-to-parent 
****************************************************************/	
	$seq_update_parent = array();
	
	if(is_array($menu_parent) and count($menu_parent) > 0) {	
		foreach($menu_parent as $mval) {   if($mval <> '') {				
			$seq_update_parent[]  = " insert IGNORE into `oc_dt_resources_parent` ( `resource_id`, `menu_id`, `county_id` ) values "
			." (".q_si($post_id).", ".q_si($mval).", ".q_si($county_parent).");  ";	
		} } 		
	}

	if(count($seq_update_parent)) {
		$sq_par_clean = " delete from `oc_dt_resources_parent` where `resource_id` = ".q_si($post_id)."; ";
		$rs_par_clean = $cndb->dbQuery($sq_par_clean);
		
		$cndb->dbQueryMulti($seq_update_parent);
		unset($seq_update_parent);
	}
/* ************************************************************** 
@ update resource-to-parent :: END
****************************************************************/
	
	/* --------- @@ Activity Logger --------------- */	
	$log_detail = 'Name: ' . $post['resource_file']. '';
	$formLog->formsUserLogs('resource', $formaction, $post_id, $log_detail, $post_by);
	/* =============================================== */	
	
	
	/* --------- @@ Populate Tags --------------- */	
	//$tag_names 	= explode("," , $post['resource_tags']);
	//$formLog->tagsPopulate($tag_names, 'resource' , $post_id );
	/* =============================================== */	
	
	//exit;
	//$redirect 	= '_docs.php?tab=_docs&qst=242';
		
}
	?><script>location.href="<?php echo $redirect; ?>";</script> <?php exit;
}




/* ============================================================================== 
/*	ARTICLES
/* ------------------------------------------------------------------------------ */

if ($formname=="fm_articles") 
{
	//exit;
	$fields_ignore[] = "county_id";
	
	$article = $post['content_article']; 
	if($article == '') { $article = cleanSimplex($_POST['content_article']); }	
	
	$url_title_article = generate_seo_title($post['content_title'], '-');	
	$article_keywords  = generate_seo_title($post['content_tags'], ',');
	//$array_keywords 	= explode(',',$article_keywords);
	
	
	if(is_array($post['id_parent1']))
	{	$arr_parent 	= serialize($post['id_parent1']); } else 
	{	$arr_parent		= NULL;	}	
	
	if(isset($_POST['id_section'])) {$id_section=$_POST['id_section']; } else { $id_section=NULL; }
	
	
	if($post["content_created"] == '') { $post["content_created"] = date("Y-m-d",time()); }
	
	if($post['id_section']=='') { $post['id_section'] = 1; }
	
	$post['approved'] = $approved;
	$post['content_article'] = $article;
	$post['content_seo'] = $url_title_article;
	$post['content_tags'] = $article_keywords;
	$post['post_by'] = $post_by;
		
	$col_names = array(); $col_values = array();
		
	foreach($post as $b_key => $b_val)  {
		$field = strtolower($b_key);		
		if(!in_array($field, $fields_ignore)) {
			if($formaction=="_new")  {
				$col_names[] = "`$field`";	
				$col_values[] = "".q_si($b_val)."";
			} 
			elseif($formaction=="_edit")  {
				$col_names[] = " `$field` = ".q_si($b_val).""; 
			}
		}			
	}
		
	if($formaction=="_new")  
	{ 
		$sq_post = "INSERT IGNORE INTO `oc_dt_content` (".implode($col_names, ', ').") values (".implode($col_values, ', ')."); "; 
	} 
	elseif($formaction=="_edit") 
	{ 
		$post_id = $post['id'];
		$sq_post = "UPDATE `oc_dt_content` set  ".implode($col_names, ', ')." where (`content_id` = ".q_si($post_id)." )" ;
	}
	
	//echo $sq_post; //exit;
	$rs_post = $cndb->dbQuery($sq_post);
	
	
	if 		( $formaction=="_new") 	{ $id_content = $cndb->insertId($rs_post); }
	elseif 	( $formaction=="_edit") { $id_content = $post_id; }
	
	
	

/* ************************************************************** 
@ update content-to-parent 
****************************************************************/
	$parent_menu 	= $post['id_parent1'];
	$parent_county 	= $post['county_id'];
	$ddSelect->populateContentParent($id_content, $parent_menu, $parent_county); 
	//$ddSelect->populateKeywords('id_content',$id_content, $array_keywords );
	//saveJsonContent();
	
	
/* ************************************************************** 
@ ADD GALLERY ITEM 
****************************************************************/

	//displayArray($_FILES['myfile']);
	$id_gall_item = '';
	
	if($post['file_type'] == 'v')
	{
		if(strlen($post['video_name']) > 5) 
		{	
			$video_name 	   = $post['video_name'];
			$pos 		      = strrpos($video_name,"="); 		
			if ($pos === false) { $myvidname = $video_name; }  
			else { $myvidname     = "http://www.youtube.com/embed/".substr($video_name,($pos+1)); }
		
		//`id_content` ,".quote_smart($id_content).", 
			$seq_post_a = "insert into `olnt_dt_gallery_photos`  "
			."( `title`, `filename`, `filetype`, `id_gallery_cat`, `date_posted`)  values "
			."(".$postb["video_caption"].", ".quote_smart($myvidname).", ".$postb['file_type'].", '2',".$dateCreated.")";
			
			$type->inserter_plain($seq_post_a);
			$id_gall_item = $type->qLastInsert;
			
		}
	}
	
	
	if($post['file_type'] == 'u')
	{
		if(strlen($post['photo_url_name']) > 3) 
		{	
			$prefix 		  = str_pad($id_content, 5, "0", STR_PAD_LEFT);
			$imageURL 		= $post['photo_url_name'];	
			//echo $imageURL;
			
						
			$sq_pic_rec = " select id from `olnt_dt_gallery_photos` where `filename` = ".quote_smart($post['photo_url_name'])."   limit 0, 1  ";
			
			$rs_pic_rec = $cndb->dbQuery($sq_pic_rec);
			if( $cndb->recordCount($rs_pic_rec) == 1)
			{
				$cn_pic_rec = $cndb->fetchRow($rs_pic_rec);
				$id_gall_item   = $cn_pic_rec[0];
			}
			else
			{
				$sqpost="insert into `olnt_dt_gallery_photos`  "
				."( `title`, `filename`,  `description`, `id_gallery_cat`, `date_posted`) "
				." values "
				."(".quote_smart($post['photo_url_caption']).", ".quote_smart($post['photo_url_name']).",  ".quote_smart($post['photo_url_caption']).",  ".$postb["id_gallery_cat_u"].", ".$dateCreated.")";
				//echo $sqpost; exit;
				$type->inserter_plain($sqpost);	
				$id_gall_item = $type->qLastInsert;
			}
			

			
		}
	}
	
	
	if($post['file_type'] == 'p')
	{
		
		$file_id 		=  str_pad($id_content, 4, "0", STR_PAD_LEFT); 
		$newTitle 	   = $file_id.'_'.uniqid();
		$result         = 0;
		
		
		$the_file       = basename($_FILES['myfile']['name']);
		
		if(trim($_FILES['myfile']['name']) <> '') 
		{
			$prefix 		= str_pad($id_content, 5, "0", STR_PAD_LEFT);
			$myfilename 	= trim($_FILES['myfile']['name']);
			
			$checksum1 = getChecksum($prefix);	
			$checksum2 = getChecksum($the_file);
			

			$pos 		   = strrpos($myfilename,"."); 
			if ($pos === false) { $pos = strlen($myfilename); }  
			
			
			if($post["id_gallery_cat"] == 3){} /* @member */
			
			$img_cry_name = strtotime(date('d F Y')). '_'.$checksum1 . '_'.$checksum2;
						
			$the_image 	= imageUpload($_FILES['myfile'], $img_cry_name, UPL_GALLERY, 1 );	
			$result 	   = $the_image['result'];
			$the_file 	 = $the_image['thumb'];
			
					
			if($the_image['result'] == 1)
			{
				$seq_post_a = "insert into `olnt_dt_gallery_photos`  "
				."(`title`, `filename`,  `id_gallery_cat`, `date_posted`, `filesize`) values "
				."(".$postb["photo_caption"].", '".$the_image['name']."', ".$postb["id_gallery_cat"].", ".$dateCreated.", '".$the_image['size']."'); ";
				
				$type->inserter_plain($seq_post_a);
				$id_gall_item = $type->qLastInsert;
			}	
			
		}
		
	}
	
	
	if($id_gall_item <> '')
	{
		$record_stamp	 = time();
			
		$seq_pic_parent[]  = " insert IGNORE into `olnt_dt_gallery_photos_parent` ( `id_photo`,`id_content`,`rec_stamp` ) values (".$id_gall_item.", ".quote_smart($id_content).", CURRENT_TIMESTAMP() );  ";			
		$type->inserter_multi($seq_pic_parent);
		
		/* ============================================================================================= */
		/* POPULATE -- PROJECT >>> LINKS */
		//$ddSelect->populateProjectLinks('id_gallery', $id_gall_item, $post['sector_id'], $post['project_id']);
		/* --------------------------------------------------------------------------------------------- */
		saveJsonGallery();
	}
	
/* ************************************************************** 
@ end ::: ADD GALLERY ITEM 
****************************************************************/	

	
	?><script language="javascript">location.href = "<?php echo $redirect; ?>"; </script><?php
	
} 
	
	
	

/* ============================================================================== 
/*	MENUS
/* ------------------------------------------------------------------------------ */


if($formname=="fm_menu")
{
	
	if(isset($post['menu_seo'])) 
	{ $title_seo = generate_seo_title($post['menu_seo']); } else
	{ $title_seo = generate_seo_title($post['menu_title'], '-'); }
	
	$metawords   = generate_seo_title($post['menu_tags'], ',');
	
	$fields_ignore[] = "article_title"; $fields_ignore[] = "article";
	
	if(isset($post['id_parent1']) and is_array($post['id_parent1']))
	{	$arr_parent 	= serialize($post['id_parent1']); } else 
	{	$arr_parent		= NULL;	}	
	
	if(isset($post['article'])) {	$article=$post['article']; } else { $article=NULL; }
	
	
	$col_names = array(); $col_values = array();
		
	foreach($post as $b_key => $b_val)  {
		$field = strtolower($b_key);		
		if(!in_array($field, $fields_ignore)) {
			if($formaction=="_new") 
			{
				$col_names[] = "`$field`";	
				$col_values[] = "".q_si($b_val)."";
			} 
			elseif($formaction=="_edit") 
			{
				$col_names[] = " `$field` = ".q_si($b_val).""; 
			}
		}			
	}
		
	if($formaction=="_new")  
	{ 
		$sq_post = "INSERT IGNORE INTO `oc_dt_menu` (".implode($col_names, ', ').") values (".implode($col_values, ', ')."); "; 
	} 
	elseif($formaction=="_edit") 
	{ 
		$post_id = $post['id'];
		$sq_post = "UPDATE `oc_dt_menu` set  ".implode($col_names, ', ')." where (`menu_id` = ".q_si($post_id)." )" ;
	}
	
	//echobr($sq_post); exit;		
	$rs_post = $cndb->dbQuery($sq_post);
	
	if($formaction=="_new") { 
		$post_id = $cndb->insertId($rs_post);  
	} 


/* ************************************************************** 
@ update menu-to-parent 
****************************************************************/
$sq_par_clean = " delete from `oc_dt_menu_parent` where `menu_id` = ".q_si($post_id)." ";
$type->inserter_plain($sq_par_clean);

if(isset($post['id_parent1']) and is_array($post['id_parent1']))
{	
	$menu_parent 	= $post['id_parent1'];
	if(count($menu_parent)>0) {
		for($i=0; $i <= (count($menu_parent)-1); $i++) {  
			$seq_update_menu[]  = " insert ignore into `oc_dt_menu_parent` (`menu_id`, `menu_parent_id` ) values "
			." (".q_si($post_id).", ".q_si($menu_parent[$i])." )  ";
		} 

		$cndb->dbQueryMulti($seq_update_menu);
	}
}	
	
	
/* ************************************************************** 
@ add menu-content 
****************************************************************/
if(isset($post['add_content']) and $post['add_content'] == 'on') 
{
	$url_article_link = generate_seo_title($post['article_title'], '-');

	$article = $post['article']; 
	if($article == '') { $article = cleanSimplex($_POST['article']); }

	$sqpost_cont = "insert into `oc_dt_content`  
	(`id_section`, `content_title`, `content_article`, `published`, `content_created`, `approved`, `content_seo`) values 
	(".q_si($post['id_section']).", ".q_si($post['article_title']).", ".q_si($article).", ".q_si($published).", CURRENT_TIMESTAMP(), '1',  ".quote_smart($url_article_link)." )";

	
	$rs_cont = $cndb->dbQuery($sqpost_cont);
	$id_content = $cndb->insertId($rs_cont);  
	
	
	$sqpost_cont_parent = " insert IGNORE into `oc_dt_content_parent` ( `content_id`, `menu_id` ) values "
			." (".q_si($id_content).", ".q_si($post_id).")  ";
	$rs_cont_p = $cndb->dbQuery($sqpost_cont_parent);
		
}
	
	/* --------- @@ Activity Logger --------------- */	
	//$log_detail = 'Name: ' . $post['resource_file']. '';
	//$formLog->formsUserLogs('resource', $formaction, $post_id, $log_detail );
	/* =============================================== */	
	
	
	/* --------- @@ Populate Tags --------------- */	
	//$tag_names 	= explode("," , $post['resource_tags']);
	//$formLog->tagsPopulate($tag_names, 'resource' , $post_id );
	/* =============================================== */	
	
	//exit;
	//$redirect 	= '_docs.php?tab=_docs&qst=242';
	?><script>location.href="<?php echo $redirect; ?>";</script> <?php exit;
}



$adTabProps['pillars'] = array('tbn' => 'olnt_app_pillar', 'tbk' => 'pillar_id');
$adTabProps['sectors'] = array('tbn' => 'olnt_app_sector', 'tbk' => 'sector_id');
$adTabProps['locations'] = array('tbn' => 'olnt_app_location', 'tbk' => 'location_id');
$adTabProps['ministries'] = array('tbn' => 'olnt_app_ministry', 'tbk' => 'ministry_id');
$adTabProps['projects'] = array('tbn' => 'olnt_app_project', 'tbk' => 'project_id');




if($formname=="vds_profiles")
{		
	
	$article = $post['article']; 
	if($article == '') { $article = cleanSimplex($_POST['article']); }	
	
	$seo_title  = generate_seo_title($post['title'], '-');
	$arr_extras 	= serialize($post['profile']);
	$dateCreated = "CURRENT_TIMESTAMP()";
	
	
	/******************************************************************
	@begin :: IMAGE UPLOAD
	********************************************************************/	
	$change_image = $post['change_image']; 
	$image_old    = $post['image_old']; $the_image_name = "";
		
	if( $change_image== "Yes") 
	{
		$newTitle    = 'ppl-'.strtolower($seo_title); //strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $post['title']));
			
		if(isset($_FILES['reg_photo'])) 
		{   $the_image = imageUpload($_FILES['reg_photo'], $newTitle, UPL_AVATARS, 0 );	
			$the_image_name = $the_image['name'];				
		}			
	}
	else
	{
		//if($image_old == '') { $image_old = "no_image.png"; }
		$the_image_name = $image_old; 
	}
	
	$myCols[] = " `arr_images` = ".quote_smart($the_image_name).""; 
		
	if($formact=="_add")
	{
	$sqpost = "insert into `".$pdb_prefix."dt_content`  (`id_section`, `title`, `article`, `published`,`arr_extras`, `date_created`, `url_title_article`, `arr_images`, `seq`) values (".$postb['id_section'].", ".$postb['title'].", ".quote_smart($article).",  ".quote_smart($published).",  ".quote_smart($arr_extras).",  $dateCreated,  ".quote_smart($seo_title).",  ".quote_smart($the_image_name).", ".$postb['seq']." )";
	}
	elseif($formact=="_edit")
	{
		
	$sqpost="update `".$pdb_prefix."dt_content`   set `id_section`=".$postb['id_section'].", `title`=".$postb['title'].", `article`=".quote_smart($article).", `published`='".$published."', `url_title_article` = ".quote_smart($seo_title).", `arr_extras` = ".quote_smart($arr_extras).", `arr_images` = ".quote_smart($the_image_name).", `seq`=".$postb['seq']." WHERE `id` = ".$postb['id']." ";
	// `article_keywords`=".quote_smart($article_keywords).",	
	}
	
	$rspost = $cndb->dbQuery($sqpost);
				
	//echobr($sqpost); exit;	
	//$type = new posts;
	//$type->inserter_plain($sqpost);
	
	
	if 		( $formact=="_add") 	 { $id_content = $cndb->insertId(); /*$type->qLastInsert;*/ }
	elseif 	( $formact=="_edit") 	{ $id_content = $post['id']; }
	
	
	
//exit;
/* ====================================== 
@ update content-to-parent 
****************************************/
	$content_parent 	= $post['id_parent'];
	$ddSelect->populateContentParent($id_content, $content_parent);
	//$ddSelect->populateKeywords('id_content',$id_content, $array_keywords );
	saveJsonContent();
/* ====================================== */
//$redirect = 'hforms.php?d=profiles&op=new'; //&id='.$id_content

//include('../classes/inc_pageload_ft.php');
//echobr(time()); 
//exit;
?><script language="javascript">location.href = "<?php echo $redirect; ?>"; </script><?php
exit;	

	
}





if ($formname=="fm_vds" ) 
{
	$tabDir 		= $post['formtab'];
	$formtable 	 = $adTabProps[$tabDir]['tbn'];
	$formpkey 	  = $adTabProps[$tabDir]['tbk'];
	
	
	if(!isset($_POST['published']) and isset($_POST['publishval'])) {
		$pub = array("published" => "off");
		$post = array_merge_recursive($post, $pub );	
	}/**/
	
	$field_names = array_keys($post); 
	$mySql  = "";	
	$myCols = array();
	$myDats = array();
	
	//displayArray($post); //exit;
	
	$fields_ignore = array("formname","formaction","formtab","id","redirect","submit","publishval");
	
	foreach($field_names as $field)
	{
		$field = strtolower($field);
		
		if(!in_array($field, $fields_ignore))
		{
			$fieldNam	= $field;
			$fieldVal	= $post[''.$field.''];
			
			if( $field == "published") { 
				$fieldVal = yesNoPost($post[''.$field.'']); 
			} 
			
			if ($formaction == "_edit" ) { 
				$myCols[] = " `$fieldNam` = ".quote_smart($fieldVal).""; 
			}		
				
			elseif ($formaction == "_new" ) {
				$myCols[] = "`$fieldNam`";	
				$myDats[] = "".quote_smart($fieldVal)."";
			}
			
		}
	}
	
	if ($formaction == "_edit" ) {	
		$sqpost = "UPDATE `$formtable` set  ".implode($myCols, ', ')." where (`$formpkey` = ".quote_smart($post['id'])." )" ;		
	}
	
	if ($formaction == "_new" ) {	
		$sqpost = "insert into `$formtable` (".implode($myCols, ', ').") values (".implode($myDats, ', ')."); ";		
	}
	
	echobr($sqpost); exit;
	//$type = new posts;
	//$type->inserter_plain($sqpost);
	$rspost = $cndb->dbQuery($sqpost);
	
	if 		( $formaction=="_new")  { $post_id = $cndb->insertId(); /*$type->qLastInsert;*/ }
	elseif 	( $formaction=="_edit") { $post_id = $post['id']; }
	
		
	//exit;	
	?> <script language='javascript'>location.href="<?php echo $redirect; ?>"; </script> <?php exit;
}




/******************************************************************
@begin :: MULTI-CONTENT ADDER
********************************************************************/	

if($formname=="article_multi_new")
{		
	
	$postTitle 	  = $post["title"];
	$postTitleSub   = $post["title_sub"];
	$postDate       = $post["created"];
	$postPub        = $post["published"];
	$postArticle    = $post["article"];
	$postImage      = $post["image"];
	
	//displayArray($post); //exit;
	
	$docUpData  	  = array();
	$sqpost_pics    = array();
	$datePublish 	= "CURRENT_DATE()";
	$timePublish 	= "CURRENT_TIMESTAMP()";
	
	if(is_array($postTitle)) 
	{
		
		foreach($postTitle as $aKey => $aVal) 
		{
            if($aVal <> '') 
			{
	
				if($postDate[$aKey] <> '') {
					$datePublish = "'".date("Y-m-d", strtotime($postDate[$aKey]))."'";  } 			
				
				$article    = $postArticle[$aKey];
				if($article == '') { 
					$article = cleanSimplex($_POST['article'][$aKey]);  }
	
				$title 	  = $postTitle[$aKey];
				$title_sub  = $postTitleSub[$aKey];				
				$title_seo  = generate_seo_title($title, '-');
				$cont_pub   = yesNoPost($postPub[$aKey]);
				
				
				
				/* =============================================
				@@ content to table
				================================================ */
				
				$sqpost = "insert into `".$pdb_prefix."dt_content`  (`id_section`, `title`, `article`, `published`,`title_sub`, `date_created`, `url_title_article`) values (".$postb['id_section'].", ".quote_smart($title).", ".quote_smart($article).",  ".quote_smart($cont_pub).",  ".quote_smart($title_sub).",  $datePublish,  ".quote_smart($title_seo)." )";
				
				$rspost = $cndb->dbQuery($sqpost);
				$id_content = $cndb->insertId(); 
				
				
				$sqpost_menus = "insert IGNORE into `olnt_dt_content_parent` (`id_content`,`id_parent`) values "
				." ('".$id_content."', '".$post['id_parent'][0]."')  ";
				
				//echobr($sqpost_menus);
				$cndb->dbQuery($sqpost_menus);
				
				
				if($postImage[$aKey] <> '') 
				{
					$filename 	  = $postImage[$aKey];
					$sqpost_image  = "insert ignore into `olnt_dt_gallery_photos`  "
					."( `title`, `filename`, `id_gallery_cat`, `date_posted`) values "
					."(".quote_smart($title).", ".quote_smart($filename).", '2', ".$timePublish.")";
					
					$rspost_image = $cndb->dbQuery($sqpost_image);
					$id_image = $cndb->insertId(); 
					
					$sqpost_pics[] = " insert IGNORE into `olnt_dt_gallery_photos_parent` ( `id_photo`,`id_content`,`rec_stamp` ) values (".quote_smart($id_image).", ".quote_smart($id_content).", ".$timePublish." );  ";			
		
				}
	
			}	// if title <> ''
		}	// for each
		
		saveJsonContent();
		
		if(count($sqpost_pics) > 0){
			$type->inserter_multi($sqpost_pics);
			saveJsonGallery();	
		}
	}
//exit;
	
?><script language="javascript">location.href = "<?php echo $redirect; ?>"; </script><?php
exit;
}






/******************************************************************
@begin :: CA DIRECTORY CATS
********************************************************************/	
if ($formname=="fm_directory_products") 
{
	$seq_content	 = array();
	$equipmentArr 	= $post['id_equipment'];
	
	if(is_array($equipmentArr) and count($equipmentArr) > 0)
	{	
		
		foreach($equipmentArr as $k => $id_equipment) 
		{  
			$seq_content[]  = " insert IGNORE into `olnt_reg_equipment_supplier` ( `id_equipment`, `id_directory` ) values "
			." (".quote_smart($id_equipment).", ".quote_smart($post['id_supplier']).")  ";
		} 

		if(count($seq_content)>0) { 
			//$type = new posts;
			//$type->inserter_multi($seq_content); 
			$cndb->dbQuery_multi($seq_content); 
		}
	}
	?><script language="javascript">location.href = "<?php echo $redirect; ?>"; </script><?php
	exit;
}


if ($formname=="fm_directory_cat" or $formname=="fm_directory" or $formname=="fm_equipment" ) 
{
	if(!isset($_POST['published'])) {
		$pub = array("published" => "off");
		$post = array_merge_recursive($post, $pub );	
	}
	$field_names = array_keys($post); 
	$mySql  = "";	
	$myCols = array();
	$myDats = array();
	
	//displayArray($post); //exit;
	
	foreach($field_names as $field)
	{
		$field = strtolower($field);
		if(	 $field == "formname"     or $field == "formaction"  or $field == "change_image" or 
				$field == "id"           or $field == "redirect" 	or $field == "submit"    or 
				$field == "upload_cat"   or $field == "upload_name" or 
				$field == "reference"    or $field == "id_supplier" or $field == "eq_otherX")
		{	$mySql .= "";	}
		else
		{
			$fieldNam	= $field;
			$fieldVal	= $post[''.$field.''];
			
			if( $field == "published") { 
				$fieldVal = yesNoPost($post[''.$field.'']); 
			} 
			
			/*if( $field == "eq_other") { 
				$eq_other_details = @serialize($post["eq_other"]);
				
				$fieldVal = yesNoPost($post[''.$field.'']); 
			}*/ 			
			
			if ($formaction == "_edit" ) { 
				$myCols[] = " `$fieldNam` = ".quote_smart($fieldVal).""; 
			}		
				
			elseif ($formaction == "_new" ) {
				$myCols[] = "`$fieldNam`";	
				$myDats[] = "".quote_smart($fieldVal)."";
			}
			
		}
	}
	
	$formprimary = " `id` ";
	if($formname == "fm_directory_cat") { $formtable = " `olnt_reg_directory_category` "; }
	if($formname == "fm_directory")     { $formtable = " `olnt_reg_directory` "; }
	if($formname == "fm_equipment")     { $formtable = " `olnt_reg_equipment` "; $formprimary = " `id_equipment` "; }
	
	
	if ($formaction == "_edit" ) {	
		$sqpost = "UPDATE $formtable set  ".implode($myCols, ', ')." where ($formprimary = ".quote_smart($post['id'])." )" ;		
	}
	
	if ($formaction == "_new" ) {	
		$sqpost="insert into $formtable (".implode($myCols, ', ').") values (".implode($myDats, ', ')."); ";
		
	}
	
	//echobr($sqpost); exit;
	//$type = new posts;
	$type->inserter_plain($sqpost);
	
	if 		( $formaction=="_new")  { $post_id = $type->qLastInsert; }
	elseif 	( $formaction=="_edit") { $post_id = $post['id']; }
	
	
	if($formname == "fm_directory")
	{
		$redirect = 'hforms.php?d=directory entries&op=edit&id='.$post_id;
	}
	
	
	if($formname == "fm_equipment")
	{
		
		$post_title = $post['eq_title'];
		
	/* ************************************************************** 
	@ update suppliers
	****************************************************************/

		if(is_array($post['id_supplier']))
		{	
			$sq_par_clean = " delete from `olnt_reg_equipment_supplier` where `id_equipment` = '".$post_id."' ";
			$type->inserter_plain($sq_par_clean);
			
			$content_parent 	= $post['id_supplier'];
			if(count($content_parent)>0)
			{
				foreach($content_parent as $k => $supplier) 
				{  
					$seq_update_content[]  = " insert IGNORE into `olnt_reg_equipment_supplier` ( `id_equipment`, `id_directory` ) values "
					." ('".$post_id."', '".$supplier."')  ";
				} 
				//displayArray($seq_update_content); exit;
				if(count($seq_update_content)>0) { $type->inserter_multi($seq_update_content); }
			}
		}

	
	/* ************************************************************** 
	@ update image
	****************************************************************/
	$status_image_update = 0;
		
		if($post['eq_image'] <> '')
		{
			$sq_upload = "insert IGNORE  into `olnt_dt_gallery_photos`  "
			."( `title`, `filename`,  `id_gallery_cat`, `date_posted`)   values "
			."(".quote_smart($post_title).", ".$postb['eq_image'].", ".$postb['upload_cat'].", CURRENT_TIMESTAMP())";
			$type->inserter_plain($sq_upload);
			$id_photo = $type->qLastInsert;
			
			$sq_upload_parent = " insert IGNORE into `olnt_dt_gallery_photos_parent` " 
			."(`id_photo`,`id_equipment`,`rec_stamp`) values "
			."(".quote_smart($id_photo).", ".quote_smart($post_id).", '".time()."')  ";		
			$type->inserter_plain($sq_upload_parent);	
			
			$status_image_update = 1;
		}
		
		if(trim($_FILES['upload_name']['name']) <> '') 
		{
			$checksum1 	 = crc32(trim($_FILES['upload_name']['name']));
			
			$prefix 		= str_pad($post['id'], 5, "0", STR_PAD_LEFT);
			
			$myfilename 	= trim($_FILES['upload_name']['name']);
			$pos 		   = strrpos($myfilename,"."); 
			if ($pos === false) { $pos = strlen($myfilename); }  
			
			$myfilename    = substr($myfilename,0,$pos);  
			$img_cry_name  = $prefix.'_'.$checksum1;
			
			$the_image 	= imageUpload($_FILES['upload_name'], $img_cry_name, UPL_CA_GALLERY, 1 );	
			$result 	   = $the_image['result'];
			$the_file 	 = $the_image['thumb'];
			
			if($the_image['result'] == 1)
			{
				$sq_upload = "insert IGNORE  into `olnt_dt_gallery_photos`  "
				."( `title`, `filename`,  `id_gallery_cat`, `date_posted`)   values "
				."(".quote_smart($post_title).", '".$the_image['name']."', ".$postb['upload_cat'].", CURRENT_TIMESTAMP())";
				$type->inserter_plain($sq_upload);
				$id_photo = $type->qLastInsert;
				
				$sq_upload_parent = " insert IGNORE into `olnt_dt_gallery_photos_parent` " 
				."(`id_photo`,`id_equipment`,`rec_stamp`) values "
				."(".quote_smart($id_photo).", ".quote_smart($post_id).", '".time()."')  ";		
				$type->inserter_plain($sq_upload_parent);
				
				$sq_update_parent = " update `olnt_reg_equipment` set `eq_image` =  '".$the_image['name']."' where " 
				." `id_equipment` =  ".quote_smart($post['id'])."; ";		
				$type->inserter_plain($sq_update_parent);
		
				$status_image_update = 1;
			}	
		}
	
		
		if($status_image_update == 1) { saveJsonGallery(); }
	}
		
	//exit;	
	?> <script language='javascript'>location.href="<?php echo $redirect; ?>"; </script> <?php exit;
}


if ($formname=="fm_equipment_gallery") 
{
	//exit;
	$status_image_update = 0;
	$result 	 = 0;
	$post_title = $post['photo_title'];
	$post_id	= $post['id'];
	
	if(trim($_FILES['upload_name']['name']) <> '') 
	{
		$checksum1 	 = crc32(trim($_FILES['upload_name']['name']));		
		$prefix 		= str_pad($post_id, 5, "0", STR_PAD_LEFT);
		
		$myfilename 	= trim($_FILES['upload_name']['name']);
		$pos 		   = strrpos($myfilename,"."); 
		
		if ($pos === false) { $pos = strlen($myfilename); }  
		
		$myfilename    = substr($myfilename,0,$pos);  
		$img_cry_name  = $prefix.'_'.$checksum1;
		
		$the_image 	= imageUpload($_FILES['upload_name'], $img_cry_name, UPL_CA_GALLERY, 1 ); 
		//displayArray($the_image);	exit;
		$result 	   = $the_image['result']; 
		$the_file 	 = $the_image['thumb'];
		
		if($result == 1)
		{
			//$type = new posts;
			
			$sq_upload = "insert IGNORE  into `olnt_dt_gallery_photos`  "
			."( `title`, `filename`,  `id_gallery_cat`, `date_posted`)   values "
			."(".quote_smart($post_title).", '".$the_image['name']."', '7', CURRENT_TIMESTAMP())"; 
			$type->inserter_plain($sq_upload);
			$id_photo = $type->qLastInsert;
			
			$sq_upload_parent = " insert IGNORE into `olnt_dt_gallery_photos_parent` " 
			."(`id_photo`,`id_equipment`,`rec_stamp`) values "
			."(".quote_smart($id_photo).", ".quote_smart($post_id).", '".time()."')  ";		
			$type->inserter_plain($sq_upload_parent);
			
			//$sq_update_parent = " update `olnt_reg_equipment` set `eq_image` =  '".$the_image['name']."' where " 
			//." `id_equipment` =  ".quote_smart($post['id'])."; ";		
			//$type->inserter_plain($sq_update_parent);
			
			$status_image_update = 1;
		}	
		
		if($status_image_update == 1) { saveJsonGallery(); }
		
	}
	//echo 'rage'; exit;
	?> 
	<script language="javascript" type="text/javascript">window.top.window.stopEqUpload(<?php echo $result; ?>);</script>  	
	<?php exit;
}

/******************************************************************
@begin :: EVENTS MANAGE
********************************************************************/	

if ($formname=="adm_event_new" or $formname=="adm_event_edit" or 
    $formname=="adm_event_new_training" or $formname=="adm_event_edit_training") 
{
	
	$article = $post['article']; 
	if($article == '') { $article = cleanSimplex($_POST['article']); }
	
	
	$url_title_article = generate_seo_title($post['title'], '-');
	
	if(is_array($post['id_parent']))
	{	$arr_parent 	= serialize($post['id_parent']); } else 
	{	$arr_parent		= NULL;	}	
	
	$dateCreated = "CURRENT_TIMESTAMP()"; 
	
	$booking_post = yesNoPost($post['booking_form']);
	$approved = yesNoPost($post['approved']);
	
	$applicType = substr($formname,-9);
	
	if($applicType == "_training")
	{
		$arr_extras_raw = array(
			'location' => ''.$post['ev_location'].''
			,'training_cat' => ''.$post['training_cat'].''
			,'training_session' => ''.$post['training_session'].''
			,'training_duration' => ''.$post['training_duration'].''
			,'date_deadline' => $post['date_deadline']
			,'book_form' => ''.$booking_post.''
			,'book_amount' => ''.$post['booking_amount'].''
		);

	}
	else
	{
		$arr_extras_raw = array(
			'location' => ''.$post['ev_location'].''
			,'book_form' => ''.$booking_post.''
			,'book_amount' => ''.$post['booking_amount'].''
		);
	}
	$arr_extras = serialize($arr_extras_raw);
	//displayArray($arr_extras); //exit; 
	
	if ($formname=="adm_event_new" or $formname=="adm_event_new_training")
	{
	$sqpost="insert into `".$pdb_prefix."dt_content`  (`id_section`, `title`, `article`, `published`, `date_created`,   `parent`, `id_portal`, `approved`, `url_title_article`, `arr_extras`) values (".$postb['id_section'].", ".quote_smart($post['title']).", ".quote_smart($article).",  '".$published."',  ".$dateCreated.",  ".quote_smart($arr_parent).",".$postb['id_portal'].",  '".$approved."',  ".quote_smart($url_title_article).", ".quote_smart($arr_extras)." )";
	
	//$redirect = 'adm_events.php?d=events&op=new&tk='.time();
		
	}
	elseif ($formname=="adm_event_edit" or $formname=="adm_event_edit_training")
	{	
	$sqpost="update `".$pdb_prefix."dt_content`   set `id_section`=".$postb['id_section'].", `title`=".quote_smart($post['title']).", `article`=".quote_smart($article).", `published`='".$published."', `date_created` =".$dateCreated.", `parent`=".quote_smart($arr_parent).",  `approved` = '".$approved."', `url_title_article` = ".quote_smart($url_title_article).", `arr_extras`=".quote_smart($arr_extras)." WHERE `id` = '".$id."' ";
	}
	
	//echo $sqpost; exit;
	
	//$type = new posts;
	$type->inserter_plain($sqpost);
	$id_content = $type->qLastInsert;
	
	if($formname=="adm_event_edit"  or $formname=="adm_event_edit_training")
	{ $id_content = $post['id']; }
	
	//echo $id_content; exit;


/* ************************************************************** 
@BEG :: update-content-dates
****************************************************************/

	
	if(is_array($post['date_add']) and count($post['date_add']) > 0)
	{	
	
		$sqdatesclean = "delete from olnt_dt_content_dates where id_content = '".$id_content."'; ";
		$type->inserter_plain($sqdatesclean);
		
		$seq_cont_dates  = array();		
		$content_date 	= $post['date_add'];
		
		foreach($content_date as $k => $datev) 
		{  
		
			if($datev <> '') 
			{ 
			  $dateStart = "'".date("Y-m-d", strtotime($datev))." ".$post['time_start'][$k]."'"; 
			  $dateEnd   = "'".date("Y-m-d", strtotime($datev))." ".$post['time_end'][$k]."'"; 
			
			  $seq_cont_dates[]  = " insert IGNORE into olnt_dt_content_dates (id_content, date, end_date) values ('".$id_content."', ".$dateStart.", ".$dateEnd."); ";
			} 
	
		} 
		//displayArray($seq_cont_dates); //exit;
		if(count($seq_cont_dates)>0) { $type->inserter_multi($seq_cont_dates); }
		
	}
//exit;
/* ************************************************************** 
@END :: update-content-dates
****************************************************************/	
	
		
/* ************************************************************** 
@ update content-to-parent 
****************************************************************/
	
	$content_parent 	= $post['id_parent'];
	$ddSelect->populateContentParent($id_content, $content_parent);
	//$ddSelect->populateProjectLinks('id_content', $id_content, $post['sector_id'], $post['project_id']);
	saveJsonContent();	
	
//exit;	
?><script language="javascript">location.href = "<?php echo $redirect; ?>"; </script><?php
	
} 
	
	
	



if($formname=="fm_usercat_edit" or $formname=="fm_usercat_new")
{
	
	
	if($formname=="fm_usercat_new") 
	{
		$account_cat = $ddSelect->getAddUserCat($post['title']);
	
	} 
	elseif($formname=="fm_usercat_edit") 
	{	
		$account_cat = $post['id'];
	}
	
	$sqpost="UPDATE `olnt_reg_cats` SET "
		." `title`= ".$postb['title'].", `description`= ".$postb['description'].", "
		." `published`= '".$published."'  "
		." where (`id_category` = ".quote_smart($account_cat).")";
		
	//echo $sqpost; //exit;
	//$type = new posts;
	$type->inserter_plain($sqpost);
	
	?> <script language='javascript'>location.href="<?php echo $redirect; ?>"; </script> 
	<?php exit;
}






if($_POST['formname'] == 'forum_edit_posts')
{
		
		$post_id = $_POST['post_id'];
		
		$sq_post = "UPDATE `olnt_forum_posts` SET `post_content` = '" . sanitizor($_POST['post_content']) . "', `post_published` = '".$published."'  WHERE `post_id` = '" . sanitizor($_POST['post_id']) . "' "; 
		 //echo $sq_post; exit;
		$rs_post = $cndb->dbQuery($sq_post);
	
	
		if(!$rs_post)
		{
			echo 'An error occured while updating your post. Please try again later.<br /><br />' . mysql_error();
			$sql = "ROLLBACK;";
			$result = $cndb->dbQuery($sql);
		}
		else
		{
			$sql = "COMMIT;";
			$result = $cndb->dbQuery($sql);	
			$redirect = 'manager.php?fitm=posts&fopt=list&fpost='. $post_id . '';		
			echo 'You have succesfully updated the member post. <a href="'. $redirect . '">Back to list</a>.';
			
			
			?>
<script language="javascript">	
function resultRedirect(){ location.href="<?php echo $redirect; ?>"; } window.setTimeout("resultRedirect()", 3000);
</script>			
			<?php
		}
	
}	










/******************************************************************
@begin :: ONLINE SERVICES - MAILING & SMS SERVICES
********************************************************************/		

function extract_message( $data_item, $data_filter )
{
   $output = array();

	foreach ($data_filter as $key => $data) {
		if (array_key_exists($data, $data_item)) {
			$output[$data] = $data_item[$data];
		}
	}
	return  $output;
}





if($formname == 'adm_fm_oservices') 
{
	$fm_selection = $_GET['sel']; 
	if(!$_GET['sel']) { $fm_selection = $post['fm_selection'];} //echo $fm_selection;
	$fm_checked    = $post['check'];
	$fm_contacts   = $post['ac_contact'];
	$fm_emails     = $post['ac_email'];
	$fm_phones     = $post['ac_phone'];
	
	if($fm_selection == '')
	{
		echo "Action for selection made NOT specified.<br><br><a onclick='javascript:window.close()'>Go Back</a>"; exit;
	}
		
		
	if($fm_selection == 'export_excel')
	{
		$list_all_values = $_SESSION['report_values'];
		$list_filter     = array_keys($fm_checked);
		$list_sel_values = extract_message($list_all_values, $list_filter );
		
		$_SESSION['report_values'] = $list_sel_values;	

		$fn = "export_list_".date("Ymd_His");
		echo $fn;
		
		echo "<script> location.href='adm_os_export.php?fn=$fn&tk=".time()."'; document.close()</script>";
	}
	
	
	if($fm_selection == 'send_mail')
	{
		$_SESSION['report_emails'] = NULL;
		$send_to = '';
		$send_to_arr = array();
		
			foreach ($fm_checked as $key => $data) {
				if(strlen(trim($fm_emails[$key])) >= 7)
				{
				if(!array_key_exists($fm_emails[$key], $send_to_arr))
				{
				$send_to_arr[''.$fm_emails[$key].''] = $fm_contacts[$key].' <'.$fm_emails[$key].'>; ';
				}
				}
			}
			//displayArray($send_to_arr); exit;
		$send_to = implode($send_to_arr);	
		 
		$_SESSION['report_emails'] = $send_to;
		echo "<script> location.href='adm_oslist_mail.php?op=new&tk=".time()."'; </script>";
		exit;
	}
	
	
	if($fm_selection == 'send_sms')
	{
		$_SESSION['report_phones'] = NULL;
		$send_to_sms = array();
		//$send_to_arr = array();
		
			foreach ($fm_checked as $key => $data) 
			{
				if(strlen(trim($fm_phones[$key])) > 8 and !array_key_exists($fm_phones[$key], $send_to_sms))
				{
					$send_to_sms[''.$fm_phones[$key].''] = $fm_contacts[$key].' ('.$fm_phones[$key].')';
				}
			}
		//$send_to_sms = implode($send_to_arr);	
		
		$_SESSION['report_phones'] = $send_to_sms;
		echo "<script> location.href='adm_oslist_sms.php?op=new&tk=".time()."'; </script>";
		exit;
	}
}





if($formname=="adm_bulk_sms") 
{
	$log_sess   = time();
	$log_msg    = $post['message'];
	
	$sendto	 = $post['id_sendto']; 
	$recipients = implode(",", $sendto);
	$message    = $post['message'];
	
	//exit;
	require_once('../apps/sms/AfricasTalkingGateway.php');
	
	$username   = "ragemunene";
	$apikey     = "3f258e63c58a8244a5bd63b80245fa0f023dd27b032a8833ca4675d1e61b368c";
	$gateway    = new AfricasTalkingGateway($username, $apikey);
	
	$count_success = 0;
	$count_failed = 0;
	
	try 
	{ 
	  // Thats it, hit send and we'll take care of the rest. 
	  $results = $gateway->sendMessage($recipients, $message);
	  foreach($results as $result) {
		  
		$sq_sms_log[] ="INSERT INTO `olnt_log_sms` 
		(`log_sess`, `log_message`, `sms_to`, `sms_status`, `sms_cost`, `msg_id` )  VALUES "
		."('".$log_sess."', ".$postb['message'].", '".$result->number."', ".quote_smart($result->status).", ".quote_smart($result->cost).",".quote_smart($result->messageId)." )";	
		
		$count_success += 1;  
		// Note that only the Status "Success" means the message was sent
		/*echo " Number: " .$result->number;
		echo " Status: " .$result->status;
		echo " MessageId: " .$result->messageId;
		echo " Cost: "   .$result->cost."\n"."<br>";*/
	  }
	  
	}
	catch ( AfricasTalkingGatewayException $e )
	{
		
		$sq_sms_log[] ="INSERT INTO `olnt_log_sms` 
		(`log_sess`, `log_message`, `sms_status` )  VALUES "
		."('".$log_sess."', ".$postb['message'].", ".quote_smart($e->getMessage())." )";
		
		$count_failed += 1;
	    echo "Encountered an error while sending: ".$e->getMessage()."\n"."<br>";
	}
		if($count_success > 0) echo "<strong>Successful Posts:</strong> " .$count_success."\n"."<br>";
		if($count_failed > 0) echo "<strong>Failed Posts:</strong> " .$count_failed."\n"."<br>";
		
		
		//$type = new posts;
		$type->inserter_multi($sq_sms_log); 
		unset($sq_sms_log);
		//unset($_POST);	
	?><hr /><a onclick="javascript:window.close()">Click here to go back</a><?php 
}





if($formname=="adm_bulk_email") 
{
	//echobr($GLOBALS['EMAIL_TEMPLATE']);
	
	$subject 	    = $post['title'];
	$messagehead 	= '<div><font face="georgia,times,serif" size="4" color="#990000">'.$subject.'</font></div>';
	$message 		= $messagehead . trim(html_entity_decode(stripslashes($post['article'])));
	
	
	$sendto		 = $_POST['sendto']; //$post['sendto']; 
	$addresses 	  = explode(";", $sendto);
	
	
		$newsletter_mailer = new newsletter_mailer;
	
		$recipients = "";
		$content_guts = $mailer_2->messageLayout($message); //callMeruMail($message);
		//echo $content_guts; exit;
		
		foreach($addresses as $ad_email)
		{
			$email = trim($ad_email); 
			if(strlen($email) > 5)
			{
				if( $newsletter_mailer->news_alert($email, $subject, $content_guts, $sendfrom) )
				{ $recipients .= $email ." -> Sent <br>"; } else { $recipients .= $email ." -> Failed <br>"; }
			}
		}
		
		echo "<strong>Newsletter / Email Posts:</strong> <br/>" . $recipients;
	//compile_emails($addresses, $title, $title); //, $article
	
	//exit;
	
	?><hr /><a onclick="javascript:window.close()">Click here to go back</a><?php 
} 								// if newsletter







/******************************************************************
@begin :: GALLERIES - SINGLE FILE
********************************************************************/	

if ($formname=="edit_file_single") 
{
	//displayArray($post); 
	//exit;
	
	$status_image_update = 0;
	$id_photo 		 = $post['id_photo'];
	$record_stamp	 = time();
	$parent_menu 	  = $post['id_parent'];
	
	$parent_cont	  = array();
	$parent_title	 = '';
	
	
	
	
	$images = count($post['image']);
	
	$qry_delete = "";
	
	//$type = new posts;
	
		foreach ($post['image'] as $key => $value) 
		{
			//$id_link = $post['id_link'];
			//$id_content = $post['id_content'];
			
			$caption 		= $post['caption'][$key];
			$desc 		   = $post['desc'][$key];
			$id_gallery_cat = $post['id_gallery_cat'][$key];
			if($id_gallery_cat == '') {$id_gallery_cat=2;}
			
			$ca_section_tags   = '';
			//$ca_tags 		   = $post['tags'][$key];
			//if(count($ca_tags) > 0){ $ca_section_tags = serialize($ca_tags); }
			
			
			$image_name 	 = $post['image'][$key];
			
			if($post['video_name'] <> $image_name)
			{$image_name 	= $post['video_name']; }
			
			$pos 		   = strrpos($image_name,"="); 		
			if ($pos === false) {  }  
			else { $image_name     = "http://www.youtube.com/embed/".substr($image_name,($pos+1)); }
		
			if($post['show'][$key] == "on") { $published = 1; } else { $published = 0; }
			
			$seq_pic_update[] = "update `olnt_dt_gallery_photos` set "
				  . "`title` = ".quote_smart($caption).", "
				  . "`description` = ".quote_smart($desc).", "
				  . "`filename` = ".quote_smart($image_name).", "
				  . "`id_gallery_cat` = '".$id_gallery_cat."', "
				  . "`tags` = ".quote_smart($ca_section_tags).", "
				  . "`published` = '".$published."' "
				  . " where `id` = '".$key."'; ";
				  
				  //. "`id_content` = '".$id_content."', "
			//$id_photo   = $key;	  
		}
	
	
	/* ============================================================================================= */
	/* POPULATE -- PROJECT >>> LINKS */
	//$ddSelect->populateProjectLinks('id_gallery', $id_photo, $post['sector_id'], $post['project_id']);
	/* --------------------------------------------------------------------------------------------- */
		
	$seq_pic_clean = " delete from `olnt_dt_gallery_photos_parent` where `id_photo` = ".quote_smart($id_photo)." ";
	$type->inserter_plain($seq_pic_clean);
	
	
	if(is_array($parent_menu) and count($parent_menu)> 0 )
	{	
		for($i=0; $i <= (count($parent_menu)-1); $i++) 
		{  
	$seq_pic_update[]  = " insert IGNORE into `olnt_dt_gallery_photos_parent` ( `id_photo`, `id_link`, `rec_stamp` ) values  (".quote_smart($id_photo).", '".$parent_menu[$i]."', '".$record_stamp."'); ";
		} 
	}
	
	
	if(isset($post['id_content'])) { $parent_cont   = $post['id_content'][$id_photo]; $parent_title = '`id_content`'; }
	if(isset($post['id_equipment'])) { $parent_cont = $post['id_equipment'][$id_photo]; $parent_title = '`id_equipment`'; }
	if(isset($post['id_resource'])) { $parent_cont 	= $post['id_resource'][$id_photo]; $parent_title = '`id_resource`'; }
	
	
	if(is_array($parent_cont) and count($parent_cont)> 0 )
	{	
		foreach($parent_cont as $ckey => $cval) 
		{  
	$seq_pic_update[]  = " insert IGNORE into `olnt_dt_gallery_photos_parent` ( `id_photo`, ".$parent_title.", `rec_stamp` ) values  (".quote_smart($id_photo).", ".quote_smart($cval).", '".$record_stamp."'); ";
		} 
	}
			
		//displayArray($seq_pic_update); exit;
	if(count($seq_pic_update) > 0) {
		
		$type->inserter_multi($seq_pic_update); 
		saveJsonGallery();
	}
	
	?>
	<script type="text/javascript"> location.href = "<?php echo $redirect; ?>&qst=1"; </script>
	<?php
		

}



/******************************************************************
@begin :: POLLS
********************************************************************/	

if($formname == 'poll_edit' or $formname == 'poll_new') 
{

	//displayArray($post); //exit;
	
	$cur 		= ($_POST['current']=='on')? '1':'0';
	$pub 		= ($_POST['published']=='on')? '1':'0';
	
	$subject	= trim(htmlentities(addslashes($_POST['subject'])));
	$question	= trim(htmlentities(addslashes($_POST['question'])));
	
	if($cur>0) $cndb->dbQuery("UPDATE `olnt_poll_questions` SET `show`=0");
	if(mysql_errno>0) $err .= mysql_errno().": ".mysql_error()."<br />";
	
	
	if($formname == 'poll_new'){
		$query = "INSERT INTO `olnt_poll_questions` (`subject`,`question`,`date`,`show`,`published`) VALUES ('".$subject."','".$question."',NOW(),'".$cur."','".$pub."')";
		//echo $query; exit;
		$cndb->dbQuery($query);
		if($cndb->errorNo()>0) $err .= $cndb->errorNo().": ".$cndb->error()."<br />";
		$qid = $cndb->insertId();
		
		$n = $_POST['next'];	
		for($i=0;$i<$n;$i++) {
			$name = "ans$i";
			if(isset($_POST[$name]) && $_POST[$name]!='') {
				$query2 = "INSERT INTO `olnt_poll_responses` (`qid`,`response`) VALUES ('".$qid."','".$_POST[$name]."')";
				$cndb->dbQuery($query2);
				if($cndb->errorNo()>0) $err .= $cndb->errorNo().": ".$cndb->error()."<br />";
			}
		}
	}
	
	
	if($formname == 'poll_edit'){	
		$query = "UPDATE `olnt_poll_questions` SET `subject`='".$subject."',`question`='".$question."',`show`=".$cur.", `published`=".$pub." WHERE `qid`=".$_POST['qid'];
		//echo $query; exit;
		$cndb->dbQuery($query);
		if($cndb->errorNo()>0) $err .= $cndb->errorNo().": ".$cndb->error()."<br />";
			
		$n = $_POST['next'];	
		for($i=0;$i<$n;$i++) {
			$name = "ans$i";
			if(isset($_POST[$name]) && $_POST[$name]!='') {
				$query2 = "SELECT `rid` FROM `olnt_poll_responses` WHERE `rid`=".$i." AND `qid`=".$_POST['qid'];
				$result2 = $cndb->dbQuery($query2);
				if( $cndb->recordCount($result2)>0) {
					$query3 = "UPDATE `olnt_poll_responses` SET `response`='".$_POST[$name]."' WHERE `rid`=".$i;
					$cndb->dbQuery($query3);
					if($cndb->errorNo()>0) $err .= $cndb->errorNo().": ".$cndb->error()."<br />";
					
				} else {
					$query3 = "INSERT INTO `olnt_poll_responses` (`qid`,`response`) VALUES ('".$_POST['qid']."','".$_POST[$name]."')";
					$cndb->dbQuery($query3);
					if($cndb->errorNo()>0) $err .= $cndb->errorNo().": ".$cndb->error()."<br />";
				}
			}
		}
	}
	
	
	$redirect = "home.php?d=online polls";
	?><script language="javascript">location.href = "<?php echo $redirect; ?>"; </script><?php
}	




/******************************************************************
@begin :: ACCOUNTS
********************************************************************/	

if ($formname=="conf_account" or $formname=="account_edit" or $formname=="account_new") 
{
	//displayArray($post); 
	
	$post['newsletter'] = yesNoPost($post['newsletter']);
	$post['published']  = yesNoPost($post['published']);
	
	$account_user_id = $post['account_id'];
	
	$account_email   = $post['email'];
	$ac_email = filter_var($account_email, FILTER_SANITIZE_EMAIL);
	if (!filter_var($ac_email, FILTER_VALIDATE_EMAIL)) {
		echo "<script language='javascript'>alert('Invalid Email'); history.back(); </script>"; exit;
	}
	
	//echo $formact; exit;
	
	if ($formact == "_edit" )
	{
		foreach($field_names as $field)
		{
			if(	 $field == "formname"     or $field == "submit"      or $field == "formact" or $field == "id_category" or
					$field == "command"      or $field == "redirect"    or $field == "id"  or $field == "account_id" or
					$field == "image_old"    or $field == "change_image"   or $field == "email" )
			{ }
			else
			{
				
				$fieldVal	= $post[''.$field.''];			
				$myCols[] = " `$field` = ".quote_smart($fieldVal).""; 
			}
		}
		$sqpost = "UPDATE `olnt_reg_account` set  ".implode($myCols, ', ')." where (`account_id` = ".quote_smart($account_user_id)." )" ;
		//echo $sqpost; exit;
		//$type = new posts;
		$type->inserter_plain($sqpost);
		
	}
	elseif ($formact == "_new" )
	{
		
		/* =============================================== */
		$account_staff   = checkIfStaff($account_email);
		$account_user_arr = array("namefirst"      =>"".$post['namefirst']."",
								  "namelast"   	   =>"".$post['namelast']."",						  
								  "phone"    	  =>"".$post['phone']."",
								  "country"        =>"".$post['country']."",
								  "staff"    	  =>"".$account_staff."",
								  "newsletter"     =>"".$newsletter."",
								  );	 
		$account_user_id  = $ddSelect->getAddUserAccount($account_email, $account_user_arr);		
		/* =============================================== */
	}
	
	
	foreach ($post['id_category'] as $key => $value) {
		$ddSelect->addUserToCategory($value, $account_user_id);
	}
	//exit;
	?><script language="javascript">location.href = "<?php echo $redirect; ?>"; </script><?php
	
} // @end :: ACCOUNTS








if ($formname=="edit_photo") 
{
	
	
	//displayArray($post); exit;
	
	$images = count($post['image']);
	
	$qry_delete = "";
	
		foreach ($post['image'] as $key => $value) {
		//if(is_array($post['show']))
		//{
			
		
			$caption = $post['caption'][$key];
			$desc = $post['desc'][$key];
			$id_gallery_cat = $post['id_gallery_cat'][$key];
			
			if($post['show'][$key] == "on") { $published = 1; } else { $published = 0; }
			if($post['galtype'][$key] == "v") {
				$id_gallery_cat = $post['id_gallery_cat'];
				if($id_gallery_cat == $key) {$id_gallery_cat=1;} else { $id_gallery_cat = 0;}
			}
			
			$sqpost[] = "update `olnt_dt_gallery_photos` set "
				  . "`title` = ".quote_smart($caption).", "
				  . "`description` = ".quote_smart($desc).", "
				  . "`id_gallery_cat` = '".$id_gallery_cat."', "
				  . "`published` = '".$published."' "
				  . " where `id` = '".$key."'; ";
		//}
		
		//echo "Value: $value<br />\n";
		}
		
		//displayArray($sqpost); exit;
		if(count($sqpost) > 0) {
			//$type = new posts;
			$type->inserter_multi($sqpost); 
		}
			?>
			<script type="text/javascript"> location.href = "<?php echo $redirect; ?>&qst=1"; </script>
			<?php
		

}

	


/*********************************************************************************************
@begin :: DOWNLOADS
***********************************************************************************************/	
function itemUploadArr ($file, $uploadname, $uploadtarget, $loopNum) //, $fileoption = ""
{
	$do_upload		= NULL;
	$max_size 		= "3000000";
	
	$item_arr 		= array();
	$item_source 	= $file['tmp_name'][$loopNum];
	
	$item_type 		= $file['type'][$loopNum];
	$item_size 		= $file['size'][$loopNum];	
	
	$mimetypes = array("application/pdf","application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "image/jpeg", "image/jpe", "image/jpg", "image/pjpeg", "image/gif", "image/png", "image/x-png", "text/plain");
	
	if(in_array($item_type, $mimetypes))
	{
	
		$item_ext_a		= getFileExtension(strtolower($file['name'][$loopNum]));
		
		$item_ext 		= "." . $item_ext_a;
		$item_new 		=  $uploadname . $item_ext;  
		$item_target 	=  $uploadtarget . $item_new;
		
		$isUploaded = move_uploaded_file($item_source, $item_target);
		
		if($isUploaded)
		{
			echo ' <hr> File <strong>' . $item_new .'</strong> has been uploaded! <br>';
			$item_arr 	= array('name' => ''.$item_new.'', 'size' => ''.intval($item_size).'', 'type' => ''.$item_type.''); //
		}
		else
		{
			?> <script>alert("File NOT uploaded.\n\nEnsure destination folder exists and you are allowed access.");</script>  
			<?php 
			exit;  		
		}
	}
	else
	{
		?> <script>alert("Invalid File Type selected.");</script>  
			<?php 
	}	
	
	return $item_arr;
}


//print_r($_POST);  displayArray($_FILES); 
if($formname=="frm_download_multi")
{		
	
	//exit;
	
	$docUpData  	  = array();
	$datePublish 	= "CURRENT_DATE()";
	
	if(isset($_FILES['s_card']) and is_array($_FILES['s_card']['name'])) 
	{
		
		foreach($_FILES['s_card']['name'] as $doc_key => $val) 
		{
            if(strlen($_FILES['s_card']['name'][$doc_key]) > 4) 
			{
	
				if($post["created"][$doc_key] <> '') {
					$datePublish = "'".date("Y-m-d", strtotime($_POST["created"][$doc_key]))."'"; 
				} 			
				
				/* =============================================
				@@ downloads to table
				================================================ */
							
				$sqpost = "insert into `".$pdb_prefix."dt_downloads` (`title`, `description`, `date_posted`, `published`, `language`, `approved`, `id_portal`) values (".quote_smart($post['file_title'][$doc_key]).", ".quote_smart($post['file_desc'][$doc_key]).", $datePublish, ".quote_smart($post['published'][$doc_key]).", ".quote_smart($post['language'][$doc_key]).", '1', ".$postb['id_portal']." ) ";
				
				echo $sqpost . '<br>';exit;
				
				//$type = new posts;
				$type->inserter_plain($sqpost);
				
				$img_cry_name	= "";
				$rec_id_str	  = "";
				$seq_update_menu = array();
				
				$id_download 	 = $type->qLastInsert;	
				$rec_id_str 	  = str_pad($id_download, 4, "0", STR_PAD_LEFT); 
				
				if($post['id_portal'] <> 1) { $rec_id_str = $post['id_portal']."_".$rec_id_str; }
				
				$img_cry_name    = preg_replace('/[\'"]/', '', strtolower($_POST['file_title'][$doc_key])); // No quotes
				$img_cry_name    = substr(preg_replace('/[^a-zA-Z0-9]+/', '_', $img_cry_name),0,50);// No spaces
				$img_cry_name    = $rec_id_str."_".date("Ymd")."_".$img_cry_name; 
				
				
				$ufile_name 		= $_FILES['s_card']['name'][$doc_key];
				$ufile_size 		= $_FILES['s_card']['size'][$doc_key];
				$ufile_type 		= $_FILES['s_card']['type'][$doc_key];
				$ufile_temp 		= $_FILES['s_card']['tmp_name'][$doc_key];
				
				$ufile_ext    	 = ".".strtolower(substr(strrchr($ufile_name,"."),1));	
				$ufile_name_new	= $img_cry_name.$ufile_ext;		
				
				
				
				/* =============================================
				@@ downloads to menus
				================================================ */
				if(array_key_exists('id_parent', $post) and  is_array($post['id_parent']))
				{
					$menu_parent 	= $post['id_parent'];
					if(count($menu_parent)>0)
					{
						for($i=0; $i <= (count($menu_parent)-1); $i++) 
						{  
						  if($menu_parent[$i] <> '') {
							$seq_update_menu[]  = " insert IGNORE into `olnt_dt_downloads_to_menus` ( `id_portal`, `id_menu`, `id_download` ) values "
							." (".$postb['id_portal'].", '".$menu_parent[$i]."', '".$id_download."')  ";
						  }
						} 
						$type->inserter_multi($seq_update_menu);
						unset($seq_update_menu);
					}
				}
				
				
				/* =============================================
				@@ downloads to content
				================================================ */
				if(array_key_exists('id_content', $post) and  is_array($post['id_content']))
				{
					$content_parent 	= $post['id_content'];
					if(count($content_parent)>0)
					{
						for($i=0; $i <= (count($content_parent)-1); $i++) 
						{  
							if($content_parent[$i] <> '') {
							$seq_update_content[]  = " insert IGNORE into `olnt_dt_downloads_to_contents` (`id_portal`, `id_content`, `id_download` ) values "
							." (".$postb['id_portal'].", '".$content_parent[$i]."', '".$id_download."')  ";
							}
						} 
						$type->inserter_multi($seq_update_content);
						unset($seq_update_content);
					}						
				
				}
				
				
				/* =============================================
				@@ downloads uploads
				================================================ */
				$ufile_mimetypes = array("application/pdf","application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document");
				
				if(in_array($ufile_type, $ufile_mimetypes))
				{
					$ufile_target = UPL_FILES . $ufile_name_new;
					
					if(move_uploaded_file($ufile_temp, $ufile_target))
					{
						echo ' <hr> File <strong>' . $ufile_name .'</strong> has been uploaded! <br>';
							 
				$sq_update_file  = "update `".$pdb_prefix."dt_downloads`  set  `link` = ".quote_smart($ufile_name_new).", `dtype` = ".quote_smart($ufile_type).", `dsize` = ".quote_smart($ufile_size)." where `id` = '".$id_download."' ";
				//echo $sq_update_file . '<br>'; //exit;
				$type->inserter_plain($sq_update_file);
				
					}
					else
					{
						echo ' <hr> File <strong>' . $ufile_name .'</strong> NOT uploaded! <br>';		
					}
				}
	
	
	
	
	
	
			}	// if file-name
		}	// for each
	}
echo ' <br><br><br><hr> <a href="home.php?d=resource library" style="color:blue"> # Back to Resource List</a> <br> <a href="adm_downloads_multi.php?d=resource library&op=new" style="color:red"> # Upload More Resources</a><br>';	
exit;
}



if ($formname=="download_edit" or $formname=="download_new") 
{
	
	$trans = get_html_translation_table(HTML_ENTITIES);
	//displayArray($trans);
	//$rage = "L'évolution du conseil agricole au Nord Cameroun, source d'incertitudes pour les conseillers ";
	//echo '<hr>a - '.strtr($rage, $trans);
	//echo '<hr>x - '.strtr($_POST['title'], $trans);
	//echo '<hr>b - '.cleanInput($_POST['title']);
		
	if($post['title'] == '') {
		echo '<script>alert("Title is empty"); history.back();</script>'; exit;
	}
	
	if(isset($_POST['id_file'])) {$id_file=$_POST['id_file']; } else { $id_file=NULL; }
	if(isset($_POST['id_cat'])) {$id_cat=$_POST['id_cat']; } else { $id_cat=NULL; }
	if(isset($_POST['id_menu'])) {$id_menu=$_POST['id_menu']; } else { $id_menu=NULL; }
	if(isset($_POST['id_menu2'])) {$id_menu2=$_POST['id_menu2']; } else { $id_menu2=NULL; }
	if(isset($_POST['doc_id_owner'])) {$doc_id_owner=$_POST['doc_id_owner']; } else { $doc_id_owner=NULL; }	
	if(isset($_POST['position'])) {$position=intval($_POST['position']); } else { $position="9"; }
	if(isset($_POST['id_access'])) {$id_access=$_POST['id_access']; } else { $id_access=1; }
	
	
	$link_seo = generate_seo_title($post['title'], '-');
	
	if($post["created"] <> '') {
		$datePublish = "'".date("Y-m-d", strtotime($_POST["created"]))."'"; // ".date("H:i:s")."
	} else {
		$datePublish = "CURRENT_DATE()";
	}
	
	
	$arr_attach	= NULL;
	/*if(array_key_exists('id_content', $post) and  is_array($post['id_content']))
	{	$arr_attach 	= serialize($post['id_content']); } else 
	{		}	*/
	
	
	$filename = ""; $file_query = "";
	
	if (isset($_POST['change_image']))	{$change_image=$_POST['change_image'];} else {$change_image=NULL;}
	
	if($change_image <> 'Yes')
	{
		if($post['resource_name'] <> $post['filename']){
				$filename = $post['resource_name']; $file_query = ", `link` = ".quote_smart($filename)." ";
			}		
	}
	
	
	
	$userid=$sys_us_admin['admin_id'];
	
	if ($formname=="download_new") 
	{
		
	$sqpost = "insert into `".$pdb_prefix."dt_downloads` (`title`, `description`, `date_posted`, `published`, `posted_by`, `seq`, `hlight`, `language`, `author`,  `approved`, `id_access`, `link`, `link_seo`) values (".quote_smart($post['title']).", ".quote_smart($post['description']).", $datePublish, '".$published."', '".$userid."', '".$position."', '".$sidebar."',  ".quote_smart(@$post['language']).", ".quote_smart(@$post['author']).",  
	'".$approved."', ".$postb['id_access'].", ".quote_smart($filename).", ".quote_smart($link_seo)." ) ";
	
	$redirect = "adm_downloads.php?d=resource library&op=new";
	
	}
	elseif ($formname=="download_edit") 
	{
	
	$sqpost = "update `".$pdb_prefix."dt_downloads`  set  `title` = ".quote_smart($post['title']).", `description` = ".quote_smart($post['description']).", `posted_by` = '".$userid."', `published` = '".$published."', `seq` = '".$position."' , `hlight` = '".$sidebar."', `date_posted` = $datePublish,   `link_seo` = ".quote_smart($link_seo).", `approved` = '".$approved."', `id_access` = ".$postb['id_access']."  $file_query "
		." where `id` = '".$id_file."' ";
	//`language` = ".quote_smart($post['language']).", `author` = ".quote_smart($post['author']).",
	}
	//echobr($sqpost);  //exit;
	
	//$type = new posts;
	$type->inserter_plain($sqpost);
	
	if 		( $formname=="download_new") 		{ $id_download = $type->qLastInsert; }
	elseif 	( $formname=="download_edit") 		{ $id_download = $post['id_file']; }
	//echobr($id_download); 
	
	
		
	
	
/* ************************************************************** 
@ update download-to-parent 
****************************************************************/

	/* ==========  download-to-menu  =========== */	

	$seq_update_parent = array();
	
	if(array_key_exists('id_parent', $post) and  is_array($post['id_parent']))
	{	
	
		$menu_parent 	= $post['id_parent'];
		if(count($menu_parent)>0)
		{
			for($i=0; $i <= (count($menu_parent)-1); $i++) 
			{  
			  if($menu_parent[$i] <> '') {
				
	$seq_update_parent[]  = " insert IGNORE into `olnt_dt_downloads_parent` ( `id_download`, `id_menu` ) values "
	." ('".$id_download."', '".$menu_parent[$i]."');  ";
	
			  }
			} 
		}
	}

	/* ==========  download-to-content  =========== */	
	if(array_key_exists('id_content', $post) and  is_array($post['id_content']))
	{
		if(array_key_exists('id_content', $post) and  is_array($post['id_content']))
		{	
			$content_parent 	= $post['id_content'];
			if(count($content_parent)>0)
			{
				for($i=0; $i <= (count($content_parent)-1); $i++) 
				{  
					if($content_parent[$i] <> '') {
		 
		
		$seq_update_parent[]  = " insert IGNORE into `olnt_dt_downloads_parent` ( `id_download`, `id_content` ) values "
." ('".$id_download."', '".$content_parent[$i]."');  ";	
					}
				} 
			}
		}	
	}
	//displayArray($seq_update_parent); exit;
	
	
	if(count($seq_update_parent))
	{
		$sq_par_clean = " delete from `olnt_dt_downloads_parent` where `id_download` = '".$id_download."'; ";
		$type->inserter_plain($sq_par_clean);
		
		$type->inserter_multi($seq_update_parent);
		unset($seq_update_parent);
		
		
	}

/******************************************************************
@FILE UPLOAD
********************************************************************/
	
	
	$rec_id_str = str_pad($id_download, 4, "0", STR_PAD_LEFT); 
	
	if($post['id_portal'] <> 1) { $rec_id_str = $post['id_portal']."_".$rec_id_str; }
	
	$img_cry_name    = preg_replace('/[\'"]/', '', strtolower($_POST['title'])); // No quotes
	$img_cry_name    = substr(preg_replace('/[^a-zA-Z0-9]+/', '_', $img_cry_name),0,50);// No spaces
	$img_cry_name    = $rec_id_str."_".date("Ymd")."_".$img_cry_name; 
				
	$image_0="";
	$filename="";
	$max_size = "5000000";
	$file_query = "";
	$iml=0;
	
	$upload_error = 0;
	$upload_error_redirect = 'adm_downloads.php?d=resource library&op=edit&id='.$id_download.'';
		
	if($change_image=='Yes')
	{
		if(isset($_FILES['fupload']) and trim($_FILES['fupload']['name']) <> '') 
		{
	
			$img_mimetypes = array("application/pdf","application/msword","text/plain","application/vnd.ms-excel", "application/vnd.ms-powerpoint", "application/zip", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "application/vnd.openxmlformats-officedocument.presentationml.presentation");
			$file_size = $_FILES['fupload']['size'];
			$file_type = $_FILES['fupload']['type'];
			
			$img_ext = ".".getFileExtension(strtolower($_FILES['fupload']['name']));
			$img_new_name =  $img_cry_name.$img_ext;  
			
			
			if(in_array($file_type, $img_mimetypes))
			{
				$filename = $img_new_name; 
				
				$source = $_FILES['fupload']['tmp_name'];	
				$target = UPL_FILES . $filename;
				//echo $target; exit;
				if(move_uploaded_file($source, $target))
				{
					echo "<script>alert(\"File successfully uploaded.\"); </script>";
					$file_0 = $filename; 
					$do_file="'".$image_0."'";
					
		$sq_update_file  = "update `".$pdb_prefix."dt_downloads`  set  `link` = '".$filename."', `dtype` = '".$file_type."', `dsize` = '".$file_size."' where `id` = '".$id_download."' ";
		//echo $sq_update_file; exit;
		$type->inserter_plain($sq_update_file);
		
				}
				else
				{
					$upload_error = 310;
					/*echo "<script> alert(\"File Not uploaded.\");
							location.href = 'adm_downloads.php?d=resource library&op=edit&id=$id_download';
						  </script>";  
					exit;  */
				}
		
			}else{
					$upload_error = 311;
				/*echo "<script>alert(\"File selected for upload is not Valid.\");</script>";  exit; */  
				}
		}
	}
	
	
	
	/******************************************************************
	@END FILE UPLOAD
	********************************************************************/

	
	/* ************************************************************** 
	@ update image
	****************************************************************/
	
		
	if(trim($_FILES['upload_icon']['name']) <> '') 
	{
		$post_id		 = $id_download;
		$post_title   	  = $post['title'];
		
		$filename_cat	= 5;
		$filename_prefix = 'rs'.str_pad($post_id, 4, "0", STR_PAD_LEFT).'-';
		$filename_new  	= $filename_prefix.substr(clean_alphanum($post_title),0,30);
		
			
		$the_image 	= imageUpload($_FILES['upload_icon'], $filename_new, UPL_COVERS, 0 );	
		$result 	   = $the_image['result'];
		$the_file 	 = $the_image['thumb'];
		
		//displayArray($the_image); exit;
		
		if($the_image['result'] == 1)
		{
			/*$sq_upload = "insert into `olnt_dt_gallery_photos`  "
			."( `title`, `filename`,  `id_gallery_cat`, `date_posted`)   values "
			."(".quote_smart($post_title).", '".$the_image['name']."', 5, CURRENT_TIMESTAMP())";
			$type->inserter_plain($sq_upload);
			$id_photo = $type->qLastInsert;
			
			$sq_upload_parent = " REPLACE into `olnt_dt_gallery_photos_parent` " 
			."(`id_photo`,`id_resource`,`rec_stamp`) values "
			."(".quote_smart($id_photo).", ".quote_smart($post_id).", '".time()."')  ";		
			$type->inserter_plain($sq_upload_parent);*/
			
			$sq_update_parent = "update `".$pdb_prefix."dt_downloads` set `attachment`='".$the_image['name']."' where " 
			." `id` =  ".quote_smart($post_id)."; ";		
			$type->inserter_plain($sq_update_parent);/**/
	
		}	
	}
	
	
	saveJsonResources();
	
	if($upload_error <> 0) {
	  echo "<script>alert(\"".$msge_array[$upload_error]."\"); location.href = '".$upload_error_redirect."'; </script>";
	}
		
		
?><script language="javascript">location.href = "<?php echo $redirect; ?>"; </script><?php
exit;

} // @end :: downloads
	
	


/*********************************************************************************************
@begin :: ARTICLES
***********************************************************************************************/	

function process_table($match) {
		$out = str_replace('<br />', '', $match[0]);
		$out = preg_replace('/<p[^>]*?>/', '', $out);
		$out = str_replace('</p>', '', $out);
		$out = preg_replace('/<div[^>]*?>/', '', $out);
		$out = str_replace('</div>', '', $out);
        return $out;

}



if ($formname=="article_basic_edit" or $formname=="article_basic_new") 
{
	//exit;
	
	$article = $post['article']; 
	if($article == '') { $article = cleanSimplex($_POST['article']); }
	
	
	$url_title_article = generate_seo_title($post['title'], '-');
	$article_keywords  = generate_seo_title($post['article_keywords'], ',');
	$array_keywords = explode(',',$article_keywords);
	//echobr($article_keywords); displayArray($array_keywords); //exit;
	
	if(is_array($post['id_parent']))
	{	$arr_parent 	= serialize($post['id_parent']); } else 
	{	$arr_parent		= NULL;	}	
	
	if(isset($_POST['id_section'])) {$id_section=$_POST['id_section']; } else { $id_section=NULL; }
	
	
	
	if($post["created"] <> '') { $dateCreated = "'".date("Y-m-d", strtotime($_POST["created"]))." ".date("H:i:s")."'"; } 
	else { $dateCreated = "CURRENT_TIMESTAMP()"; }
	
	if($post['id_section']=='') { $id_section=1; }
	
	
	if ($formname=="article_basic_new")
	{
	$sqpost="insert into `".$pdb_prefix."dt_content`  (`id_section`, `title`, `article`, `published`, `frontpage`, `sidebar`, `intro_home`, `seq`, `title_sub`, `date_created`,   `parent`, `id_portal`, `approved`, `link_static`, `url_title_article`, `article_keywords`) values ('".$id_section."', ".quote_smart($post['title']).", ".quote_smart($article).",  '".$published."',  '".$frontpage."',  '".$sidebar."',  '".$intro_home."',  ".quote_smart($post['position']).", ".quote_smart($post['title_sub']).", ".$dateCreated.",  ".quote_smart($arr_parent).",".$postb['id_portal'].",  '".$approved."',  ".quote_smart($post['link_static']).", ".quote_smart($url_title_article).", ".quote_smart($article_keywords)." )";
	
	//$redirect = "adm_articles.php?d=contents&op=new";
	
	}
	elseif ($formname=="article_basic_edit" )
	{	
	$sqpost="update `".$pdb_prefix."dt_content`   set `id_section`=".quote_smart($post['id_section']).", `title`=".quote_smart($post['title']).", `article`=".quote_smart($article).", `published`='".$published."', `frontpage`='".$frontpage."', `sidebar`='".$sidebar."', `intro_home`='".$intro_home."', `seq`=".quote_smart($post['position']).", `title_sub`=".quote_smart($post['title_sub']).", `date_created` =".$dateCreated.", `parent`=".quote_smart($arr_parent).", `id_portal`= ".$postb['id_portal'].", `approved` = '".$approved."', `link_static` = ".quote_smart($post['link_static']).", `url_title_article` = ".quote_smart($url_title_article).", `article_keywords`=".quote_smart($article_keywords)." WHERE `id` = '".$id."' ";
	}
	
	//echo $sqpost; exit;
	
	//$type = new posts;
	$type->inserter_plain($sqpost);
	
	if 		( $formname=="article_basic_new") 		{ $id_content = $type->qLastInsert; }
	elseif 	( $formname=="article_basic_edit") 		{ $id_content = $post['id']; }
	
	
	

/* ************************************************************** 
@ update content-to-parent 
****************************************************************/
	$content_parent 	= $post['id_parent'];
	$ddSelect->populateContentParent($id_content, $content_parent);
	//$ddSelect->populateProjectLinks('id_content', $id_content, $post['sector_id'], $post['project_id']);
	$ddSelect->populateKeywords('id_content',$id_content, $array_keywords );
	saveJsonContent();
	
	
/* ************************************************************** 
@ ADD GALLERY ITEM 
****************************************************************/

	//displayArray($_FILES['myfile']);
	$id_gall_item = '';
	
	if($post['file_type'] == 'v')
	{
		if(strlen($post['video_name']) > 5) 
		{	
			$video_name 	   = $post['video_name'];
			$pos 		      = strrpos($video_name,"="); 		
			if ($pos === false) { $myvidname = $video_name; }  
			else { $myvidname     = "http://www.youtube.com/embed/".substr($video_name,($pos+1)); }
		
		//`id_content` ,".quote_smart($id_content).", 
			$seq_post_a = "insert into `olnt_dt_gallery_photos`  "
			."( `title`, `filename`, `filetype`, `id_gallery_cat`, `date_posted`)  values "
			."(".$postb["video_caption"].", ".quote_smart($myvidname).", ".$postb['file_type'].", '2',".$dateCreated.")";
			
			$type->inserter_plain($seq_post_a);
			$id_gall_item = $type->qLastInsert;
			
		}
	}
	
	
	if($post['file_type'] == 'u')
	{
		if(strlen($post['photo_url_name']) > 3) 
		{	
			$prefix 		  = str_pad($id_content, 5, "0", STR_PAD_LEFT);
			$imageURL 		= $post['photo_url_name'];	
			//echo $imageURL;
			
						
			$sq_pic_rec = " select id from `olnt_dt_gallery_photos` where `filename` = ".quote_smart($post['photo_url_name'])."   limit 0, 1  ";
			
			$rs_pic_rec = $cndb->dbQuery($sq_pic_rec);
			if( $cndb->recordCount($rs_pic_rec) == 1)
			{
				$cn_pic_rec = $cndb->fetchRow($rs_pic_rec);
				$id_gall_item   = $cn_pic_rec[0];
			}
			else
			{
				$sqpost="insert into `olnt_dt_gallery_photos`  "
				."( `title`, `filename`,  `description`, `id_gallery_cat`, `date_posted`) "
				." values "
				."(".quote_smart($post['photo_url_caption']).", ".quote_smart($post['photo_url_name']).",  ".quote_smart($post['photo_url_caption']).",  ".$postb["id_gallery_cat_u"].", ".$dateCreated.")";
				//echo $sqpost; exit;
				$type->inserter_plain($sqpost);	
				$id_gall_item = $type->qLastInsert;
			}
			

			
		}
	}
	
	
	if($post['file_type'] == 'p')
	{
		
		$file_id 		=  str_pad($id_content, 4, "0", STR_PAD_LEFT); 
		$newTitle 	   = $file_id.'_'.uniqid();
		$result         = 0;
		
		
		$the_file       = basename($_FILES['myfile']['name']);
		
		if(trim($_FILES['myfile']['name']) <> '') 
		{
			$prefix 		= str_pad($id_content, 5, "0", STR_PAD_LEFT);
			$myfilename 	= trim($_FILES['myfile']['name']);
			
			$checksum1 = getChecksum($prefix);	
			$checksum2 = getChecksum($the_file);
			

			$pos 		   = strrpos($myfilename,"."); 
			if ($pos === false) { $pos = strlen($myfilename); }  
			
			
			if($post["id_gallery_cat"] == 3){} /* @member */
			
			$img_cry_name = strtotime(date('d F Y')). '_'.$checksum1 . '_'.$checksum2;
						
			$the_image 	= imageUpload($_FILES['myfile'], $img_cry_name, UPL_GALLERY, 1 );	
			$result 	   = $the_image['result'];
			$the_file 	 = $the_image['thumb'];
			
					
			if($the_image['result'] == 1)
			{
				$seq_post_a = "insert into `olnt_dt_gallery_photos`  "
				."(`title`, `filename`,  `id_gallery_cat`, `date_posted`, `filesize`) values "
				."(".$postb["photo_caption"].", '".$the_image['name']."', ".$postb["id_gallery_cat"].", ".$dateCreated.", '".$the_image['size']."'); ";
				
				$type->inserter_plain($seq_post_a);
				$id_gall_item = $type->qLastInsert;
			}	
			
		}
		
	}
	
	
	if($id_gall_item <> '')
	{
		$record_stamp	 = time();
			
		$seq_pic_parent[]  = " insert IGNORE into `olnt_dt_gallery_photos_parent` ( `id_photo`,`id_content`,`rec_stamp` ) values (".$id_gall_item.", ".quote_smart($id_content).", CURRENT_TIMESTAMP() );  ";			
		$type->inserter_multi($seq_pic_parent);
		
		/* ============================================================================================= */
		/* POPULATE -- PROJECT >>> LINKS */
		//$ddSelect->populateProjectLinks('id_gallery', $id_gall_item, $post['sector_id'], $post['project_id']);
		/* --------------------------------------------------------------------------------------------- */
		saveJsonGallery();
	}
	
/* ************************************************************** 
@ end ::: ADD GALLERY ITEM 
****************************************************************/	

	
	?><script language="javascript">location.href = "<?php echo $redirect; ?>"; </script><?php
	
} 
	
	
	
	
	
	
	





/*********************************************************************************************
@begin :: MENUS
***********************************************************************************************/	


if ($formname=="menu_edit" or $formname=="menu_new") 
{
	
	//displayArray($_FILES); 
	
	if(isset($post['title_seo'])) 
	{ $title_seo = generate_seo_title($post['title_seo']); } else
	{ $title_seo = generate_seo_title($post['title'], '-'); }
	
	$metawords = generate_seo_title($post['metawords'], ',');
	
	
	if(isset($post['id_parent1']) and is_array($post['id_parent1']))
	{	$arr_parent 	= serialize($post['id_parent1']); } else 
	{	$arr_parent		= NULL;	}	
	
	if(isset($post['article'])) {	$article=$post['article']; } else { $article=NULL; }
	
	
	
	if(isset($_POST['title'])) {$title=trim(htmlentities(addslashes($_POST['title']))); } else { $title=NULL; }
	if(isset($_POST['title_alias'])) {$title_alias=trim(htmlentities(addslashes($_POST['title_alias']))); } else { $title_alias=NULL; }
	
	if(isset($_POST['id_type_menu'])) {$id_type_menu=$_POST['id_type_menu']; } else { $id_type_menu=NULL; }
	if(isset($_POST['id_section'])) {$id_section=$_POST['id_section']; } else { $id_section=NULL; }
	if(isset($_POST['id_parent1'])) {$id_parent1=$_POST['id_parent1']; } else { $id_parent1=NULL; }
	if(isset($_POST['id_parent2'])) {$id_parent2=$_POST['id_parent2']; } else { $id_parent2=NULL; }
	if(isset($_POST['id_access'])) {$id_access=$_POST['id_access']; } else { $id_access=1; }
	
	
		
	if(isset($_POST['link'])) {$link=trim(htmlentities(addslashes($_POST['link']))); } else { $link=NULL; }
	if(isset($_POST['target'])) {$target=$_POST['target']; } else { $target="_self"; }
	if(isset($_POST['position'])) {$position=intval($_POST['position']); } else { $position="1"; }
			
			if(count($id_parent1)==0) { $id_parent1 = NULL; }
			if($id_access=="") { $id_access =1; }
			if($target=="") { $target ="_self"; }
	
	$title_options = '';
	if(array_key_exists('title_icon', $post))
	{ $title_options_arr = array('title_icon' => ''.$post['title_icon'].''); $title_options = serialize($title_options_arr); }
	
	$pagebanner = ""; $image_query = ""; 
	
	if ($formname=="menu_edit")
	{
		//if($pagebanner <> "") {$image_query = " `image` = '".$pagebanner."', "; }
		
		
	$sqpost="update `".$pdb_prefix."dt_menu`  set `title`=".quote_smart($post['title']).", `title_alias`= ".quote_smart($post['title_alias']).", `id_type_menu`= '".$id_type_menu."', `id_section`='".$id_section."', `parent`=".quote_smart($arr_parent).", `id_parent2`='".$id_parent2."', `description`=".quote_smart($article).", `link`='".$link."', `target`='".$target."', `published`='".$published."',  `id_access`='".$id_access."', `seq`='".$position."', `static`='".$yn_static."', `metawords`=".quote_smart($metawords).", `quicklink`='".$yn_quicklink."', `title_seo` = ".quote_smart($title_seo)." , $image_query  `image_show`='".$image_show."', `id_portal`= ".$postb['id_portal'].", `date_update`= '".time()."' where `id`= $id";
	
	}
	elseif ($formname=="menu_new")
	{
		$pagebanner = "";
		//, `description` - ".quote_smart($post['article'])."
	$sqpost="insert ignore into `".$pdb_prefix."dt_menu`  (`title`, `title_alias`, `id_type_menu`, `id_section`,  `link`, `image`, `target`, `published`, `id_access`, `seq`, `static`, `metawords`, `quicklink`, `image_show`, `id_portal`, `title_seo`, `title_options`, `date_update`, `title_brief`, `hits`) values (".quote_smart($post['title']).",  ".quote_smart($post['title_alias']).", '".$id_type_menu."', '".$id_section."', '".$link."', '".$pagebanner."',  '".$target."',  '".$published."',  '".$id_access."',  '".$position."', '".$yn_static."', ".quote_smart($metawords).", '".$yn_quicklink."' , '".$image_show."', ".$postb['id_portal'].", ".quote_smart($title_seo).", ".quote_smart($title_options).", '".time()."', ".quote_smart($post['title']).", '0')";
	
	$redirect = "adm_menus.php?d=menus&op=new";
	
	}
	
	//echo $sqpost; exit;
	
	//$type = new posts;
	$type->inserter_plain($sqpost);
	
	if 		( $formname=="menu_new") 		{ $id_menu = $type->qLastInsert; }
	elseif 	( $formname=="menu_edit") 		{ $id_menu = $post['id']; }
		

/* ************************************************************** 
@ update menu-to-parent 
****************************************************************/
	$sq_par_clean = " delete from `".$pdb_prefix."dt_menu_parent` where `id_menu` = '".$id_menu."' and `id_portal` = ".$postb['id_portal']." ";
	$type->inserter_plain($sq_par_clean);
	
	if(isset($post['id_parent1']) and is_array($post['id_parent1']))
	{	
		$menu_parent 	= $post['id_parent1'];
		if(count($menu_parent)>0)
		{
			for($i=0; $i <= (count($menu_parent)-1); $i++) 
			{  
				$seq_update_menu[]  = " insert ignore into `".$pdb_prefix."dt_menu_parent` ( `id_portal`, `id_menu`, `id_parent` ) values "
				." (".$postb['id_portal'].", '".$id_menu."', '".$menu_parent[$i]."')  ";
			} 
			
			//displayArray($seq_update_menu); exit;
			$type->inserter_multi($seq_update_menu);
		}
	}	

	saveJsonMenu();


/* ************************************************************** 
@ add menu-content 
****************************************************************/
	if(isset($post['add_content']) and $post['add_content'] == 'on') 
	{
		$url_article_link = generate_seo_title($post['article_title'], '-');
		
		$article = $post['article']; 
		if($article == '') { $article = cleanSimplex($_POST['article']); }
	
		$sqpost_cont = "insert into `".$pdb_prefix."dt_content`  
		(`id_section`, `title`, `article`, `published`, `date_created`, `approved`, `url_title_article`) values 
		('".$id_section."', ".quote_smart($post['article_title']).", ".quote_smart($article).", '".$published."', CURRENT_TIMESTAMP(), '1',  ".quote_smart($url_article_link)." )";
		
		//$type_c = new posts;
		$type->inserter_plain($sqpost_cont);
		$id_content = $type->qLastInsert;
		
		$sqpost_cont_parent = " insert IGNORE into `".$pdb_prefix."dt_content_parent` ( `id_content`, `id_parent` ) values "
				." ('".$id_content."', '".$id_menu."')  ";
		$type->inserter_plain($sqpost_cont_parent);
		
		saveJsonContent();	
	}
	
	
	
	//exit;
	$redirect .= "&token=".uniqid();
	?><script language="javascript">location.href = "<?php echo $redirect; ?>"; </script><?php
	
} // @end :: menus








/*
@begin: Photo Galleries
*******************************************************************************************/

if ($formname=="gal_category_new" or $formname=="gal_category_edit") 
{
	
	if(isset($_POST['id_type'])) {$id_type=$_POST['id_type']; } else { $id_type=1; }
	if(isset($_POST['id_parent1'])) {$id_parent1=$_POST['id_parent1']; } else { $id_parent1=NULL; }
	if(isset($_POST['id_parent2'])) {$id_parent2=$_POST['id_parent2']; } else { $id_parent2=NULL; }
	if(isset($_POST['title'])) {$title=htmlentities(addslashes($_POST['title'])); } else { $title=NULL; }
	if(isset($_POST['description'])) {$description=htmlentities(addslashes($_POST['description'])); } else { $description=NULL; }
	
	
	if ($formname=="gal_category_new")
	{
		$sqpost="insert into `olnt_dt_gallery_albums`  (`id_type`,`id_parent1`, `id_parent2`, `title`, `description`, `published`) values
		 ('".$id_type."', '".$id_parent1."', '".$id_parent2."', '".$title."', '".$description."', '".$published."')";
	}
	elseif ($formname=="gal_category_edit") 
	{
		$sqpost="update `olnt_dt_gallery_albums` set  `id_type` ='".$id_type."', `id_parent1` ='".$id_parent1."', `id_parent2` ='".$id_parent2."', `title` ='".$title."', `description` ='".$description."', `published` ='".$published."'  where `id`='".$id."'"; 
	}
	//echo $sqpost; exit;
	
	//$type = new posts;
	$type->inserter_plain($sqpost);
		?><script language="javascript">location.href = "<?php echo $redirect; ?>"; </script><?php
}



/******************************************************************
@begin :: ADMIN ACCOUNTS
********************************************************************/	


if ($formname=="admins_edit" or $formname=="admins_new") 
{
	//displayArray($post);
	
	if(isset($_POST['admintype_id'])) {$admintype_id=$_POST['admintype_id']; } else { $admintype_id=NULL; }
	if(isset($_POST['admin_fname'])) {$admin_fname=trim(htmlentities(addslashes($_POST['admin_fname']))); } else { $admin_fname=NULL; }
	if(isset($_POST['admin_email'])) {$admin_email=trim(htmlentities(addslashes($_POST['admin_email']))); } else { $admin_email=NULL; }
	if(isset($_POST['admin_uname'])) {$admin_uname=trim(htmlentities(addslashes($_POST['admin_uname']))); } else { $admin_uname=NULL; }
	if(isset($_POST['admin_pass'])) {$admin_pass=$_POST['admin_pass']; } else { $admin_pass=NULL; }
	if(isset($_POST['admin_pass_c'])) {$admin_pass_c=$_POST['admin_pass_c']; } else { $admin_pass_c=NULL; }
	
	
	
	if($admin_pass) {$md5_pword = md5($admin_pass); }
	
	
	if ($formname=="admins_new")
	{
		$sqpost="insert into `olnt_admin_accounts`  (`admin_uname`, `admin_email`, `admin_fname`, `admin_pword`, `admintype_id`, `published`) values
		 ('".$admin_uname."', '".$admin_email."', '".$admin_fname."', '".$md5_pword."', '".$admintype_id."', '".$published."')";
	}
	elseif ($formname=="admins_edit") 
	{
		if($admin_pass_c) {$change_pass = " , `admin_pword` ='".$md5_pword."'"; } else { $change_pass = ""; }
		
		$sqpost="update `olnt_admin_accounts` set  `admintype_id` ='".$admintype_id."', `admin_uname` ='".$admin_uname."', `admin_email` ='".$admin_email."', `admin_fname` ='".$admin_fname."',  `published` ='".$published."' $change_pass  where `admin_id`='".$id."'"; 
	}
	//echo $sqpost; exit;
	
	//$type = new posts;
	$type->inserter_nomsg($sqpost, $redirect);

}


	
if ($formname=="admin_log") 
{
	
	if(isset($_POST['admin_fname'])) {$admin_fname=$_POST['admin_fname']; } else { $admin_fname=NULL; }
	if(isset($_POST['admin_email'])) {$admin_email=$_POST['admin_email']; } else { $admin_email=NULL; }
	if(isset($_POST['admin_uname'])) {$admin_uname=$_POST['admin_uname']; } else { $admin_uname=NULL; }
	if(isset($_POST['admin_pword'])) {$admin_pword=$_POST['admin_pword']; } else { $admin_pword=NULL; }
	
	if(isset($_POST['admin_pword'])) {$md5_pword=md5($_POST['admin_pword']); }
	
	//echo $md5_pword; exit;
	
	$sqpost= "SELECT olnt_admin_accounts.admin_uname, olnt_admin_accounts.admin_pword, olnt_admin_accounts.admin_fname,  "; 
	$sqpost.= "olnt_admin_accounts.admintype_id, olnt_admin_accounts.admin_id, olnt_admin_types.title, "
		." olnt_admin_accounts.admin_email  FROM olnt_admin_accounts  "; 
	$sqpost.= "INNER JOIN olnt_admin_types ON olnt_admin_types.admintype_id=olnt_admin_accounts.admintype_id  "; 
	$sqpost.= " where  olnt_admin_accounts.admin_uname=".quote_smart($admin_uname)." and olnt_admin_accounts.admin_pword='".$md5_pword."' and olnt_admin_accounts.published = 1";
	
	//echo $sqpost; exit;
	
	$cncheck= $cndb->dbQuery($sqpost);
	$cnCnt= $cndb->recordCount($cncheck);
	
	if ($cnCnt==1) {//$username= substr($rscheck['email'], 0, stripos($rscheck['email'],"@"));
		$rscheck = $cndb->fetchRow($cncheck);
		
		$adminname = $rscheck['admin_fname'];
		$adminuser = $rscheck['admin_uname'];
		$actype = $rscheck['title'];
		$actype_id = $rscheck['admintype_id'];
		
		
		
		
		$adm_sess['adminname'] = $adminname;
		$adm_sess['adminemail'] = $rscheck['admin_email'];
		$adm_sess['adminuser'] = $adminuser;
		$adm_sess['actype_id'] = $actype_id;
		$adm_sess['actype'] = $actype;
		$adm_sess['admin_id'] = $rscheck['admin_id'];
		
		$_SESSION['sess_olnt_admin'] = $adm_sess;
		//displayArray($_SESSION['sess_olnt_admin']); exit;
		//$portalId = $_POST["portal_id"];
		//$admPortal = $ddSelect->getActivePortal($portalId);
		//$_SESSION['sess_olnt_adm_portal'] = $admPortal;

		echo "<script language=\"javascript\">location.href=\"home.php\"; </script>";
		
	} else {
		echo "<script language=\"javascript\">history.back(-1); alert(\"Please confirm your login details.\");</script>";
	}
}
	
	
	
	
if (isset($_REQUEST['signout'])){$signout=$_REQUEST['signout'];} else {$signout='';}
if ($signout=="on") 
	{
		unset($_SESSION['sess_olnt_admin']);
		
		?> <script language='javascript'> location.href="index.php"; </script> <?php exit;
	}
	
?>
