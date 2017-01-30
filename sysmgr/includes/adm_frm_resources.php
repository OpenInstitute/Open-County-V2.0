<?php

$parent_menu = '';
$article = '';
$url_title_article = '';	
$language = '';
$res_attr = array();


$upload_icon_disp = '';
$upload_icon_id   = '';

$upload_picy	= " checked ";
$upload_picn	  = "";

$access[1] = '';
$access[2] = '';

$id_owner  = '';

$file_box_link	= ' style="display: none"';
$file_box_upload  = '';

$fData = array();

$ths_page="?d=$dir&op=$op";

$formname = "fm_resources";
	

$county_id = '';
	
if($op=="edit"){

	if($id)
	{
	
	$sqdata="SELECT  *  FROM `oc_dt_resources`  WHERE  (`resource_id` = ".quote_smart($id).")";
	$rsdata = $cndb->dbQueryFetch($sqdata);
	$fData = current($rsdata);
	
		$resource_id = $fData['resource_id'];
		$res_attr = @unserialize($fData['resource_attributes']); 
		$res_attr['resource_image'] = 'budget.jpg';
		if(@$res_attr['resource_image'] <> ''){
			$upload_icon_disp = '<div class="col-md-3" style="overflow:hidden"><img src="'.DISP_GALLERY.$res_attr['resource_image'].'" style="width:auto; max-height:150px;" /></div>';
		}
		
		$sq_item_parent = "SELECT * FROM `oc_dt_resources_parent` WHERE (`resource_id` = ".q_si($resource_id)."); "; 
		$rs_item_parent = $cndb->dbQuery($sq_item_parent);
		if( $cndb->recordCount($rs_item_parent)) {
			while($cn_item_parent = $cndb->fetchRow($rs_item_parent)) { 
				if($cn_item_parent['menu_id'] <> 0) { $parent[] = $cn_item_parent['menu_id']; }  
			 	$county_id = $cn_item_parent['county_id']; 
			}
		}
	
		$article	= str_replace(SITE_PATH, '', $fData['resource_description']);
		$article	= str_replace(SITE_DOMAIN_LIVE, '', $article);		
		$article 	= str_replace('"images/', '"'.SITE_DOMAIN_LIVE.'images/', $article);
		$article	= remove_special_chars(stripslashes($article));
		
		
		$formaction			   = "_edit";		
		$upload_picy			= " ";
		$upload_picn			= " checked ";
		
		$file_box_link	= '';
		$file_box_upload  = ' style="display: none"';
	}
	
	$upload_picy	="";
	$upload_picn	=" checked ";

} 
elseif($op=="new")
	{
	
		$sqdata = "SELECT * FROM `oc_dt_resources`";
		$rsdata = $cndb->dbQuery($sqdata);
		$res_fields = (array) mysqli_fetch_fields($rsdata); 
		$fData = getTableFields($res_fields);
		
		$fData['date_created'] = date('Y-m-d', time());
		$fData['published'] = 1;
		
		
		//$formname			= "article_basic_new";
		$formaction			   = "_new";
	}

	
 
$created = date('Y-m-d', strtotime($fData['date_created']));
$published = yesNoChecked($fData['published']);	

//displayArray($res_attr);
//displayArray($fData);
@$access[$fData['access_id']] = ' selected ';

echo '<h3>'.clean_title($formaction).' Entry</h3>';	
?>

<form class="rwdform rwdfull rwdstripes rwdvalid " name="fm_resources" id="fm_resources" method="post" action="sys_posts.php" enctype="multipart/form-data">
<input type="hidden" name="formtab" value="_resources" />
<input type="hidden" name="formaction" value="<?php echo $formaction; ?>" />
<input type="hidden" name="formname" value="fm_resources" />
<input type="hidden" name="id" value="<?php echo @$fData['resource_id']; ?>" />
<input type="hidden" name="redirect" value="home.php?d=resources" />
<input type="hidden" name="post_by" value="<?php echo @$fData['post_by']; ?>" />
<input type="hidden" name="resource_type" value="d" />
<input type="hidden" name="resource_image" value="<?php echo @$res_attr['resource_image']; ?>" />
<div class=""></div>


<div class="form-group form-row">
	<label for="id_parent" class="col-md-3">Parent Menu: </label>
	<div class="col-md-3 nopadd">
	<select name="id_parent1[]" id="id_parent" multiple="multiple" class="form-control multiple">
		<?php echo $dispData->build_MenuSelectRage(0, $parent); ?>
	</select>
	</div>
	
	<label for="county_id" class="col-md-3">Parent County: </label>
	<div class="col-md-3 nopadd">
	<select name="county_id" id="county_id" class="form-control">
		<?php echo $ddSelect->dropperCounties($county_id); ?>
	</select>
	</div>
</div>


<div class="form-group form-row"><label for="resource_title" class="col-md-3">Resource Title: </label>
<input type="text" name="resource_title" id="resource_title" class="form-control col-md-9 required" value="<?php echo @$fData['resource_title']; ?>"  />
</div>

<div class="form-group form-row"><label for="resource_slug" class="col-md-3">Resource Slug: </label>
<input type="text" name="resource_slug" id="resource_slug" class="form-control col-md-9 required" value="<?php echo @$fData['resource_slug']; ?>"  />
</div>

<div class="form-group form-row">
<label for="resource_file" class="col-md-3">Resource File: </label>
<div class="col-md-9">
	<table align="left" width="100%" border="0" class="table nopadd nomargin noborder">
	<tr>
		<td style="width:;" class="col-md-3">
		<label style="display:inline-block;"><input name="change_image" id="upload_on" type="radio" value="Yes" <?php echo $upload_picy; ?>  class="radio"/>&nbsp; Upload New</label>&nbsp;
		<label style="display:inline-block;"><input name="change_image" id="upload_off" type="radio" value="No" <?php echo $upload_picn; ?>  class="radio"/> Resource Name</label> 
		</td>
		<td class="col-md-6">
	<div id="file_box_upload" <?php echo $file_box_upload; ?>>
	<input type="file" name="fupload" id="fupload"  class="form-control required"  accept="<?php echo $uploadMime; ?>" />
	</div>
	
	<div id="file_box_link" <?php echo $file_box_link; ?>>
	<input type="text" name="resource_file" id="resource_file" value="<?php echo @$fData['resource_file']; ?>" class="form-control" placeholder="Enter File link:" />
	</div>
	</td>
	</tr>
	</table>
</div></div>

<div class="form-group form-row"><label for="resource_description" class="col-md-3">Resource Description: </label>
<div class="col-md-9 padd0_l padd0_r"><textarea name="resource_description" id="resource_description" class="form-control wysiwyg" ><?php echo @$fData['resource_description']; ?></textarea></div>
</div>


<div class="form-group form-row"><label for="resource_tags" class="col-md-3">Resource Topics/Tags: </label>
<input type="text" name="resource_tags" id="resource_tags" class="form-control col-md-9 required tags-field" value="<?php echo @$fData['resource_tags']; ?>"  />
</div>










<div class="form-group form-row">
<label for="year_published" class="col-md-3">Publication Year: </label>
<select name="res_attr[year_published]" id="year_published" class="form-control col-md-3">
	 <option selected><?php echo @$res_attr['year_published']; ?></option>
	 <?php for($d=date("Y"); $d>=(date("Y")-20); $d--) { ?>   <option><?php echo $d; ?></option><?php } ?> 
</select>

<label for="date_created" class="col-md-3">Date Posted: </label>
<input type="text" name="date_created" id="date_created" class="form-control col-md-3 hasDatePicker" value="<?php echo @$fData['date_created']; ?>"  />
</div>



<div class="form-group form-row">
<label for="publisher" class="col-md-3">Publisher: </label>
<select name="res_attr[publisher]" id="publisher" class="form-control col-md-3">
	  <?php echo $ddSelect->dropper_conf("publishers", @$res_attr['publisher'], 'i') ?>
</select>
<label for="language" class="col-md-3">Language: </label>
	<select name="res_attr[language]" id="language" class="form-control col-md-3">
		  <?php echo $ddSelect->dropper_conf("language", @$res_attr['language']) ?>
	</select>

</div>


<div class="form-group form-row">
	<label for="content_type" class="col-md-3">Content Type: </label>
	<select name="res_attr[content_type]" id="content_type" class="form-control col-md-3">
		  <?php echo $ddSelect->dropper_conf("content_type", @$res_attr['content_type']) ?>
	</select>
	<label for="devolved_functions" class="col-md-3">Other Function: </label>
	<select name="res_attr[devolved_functions]" id="devolved_functions" class="form-control col-md-3">
		  <?php echo $ddSelect->dropper_conf("devolved_functions", @$res_attr['devolved_functions']) ?>
	</select>	
</div>


<div class="form-group form-row">
	<label for="source_url" class="col-md-3">Original Source: </label>
	<input type="text" name="res_attr[source_url]" id="source_url" class="form-control col-md-9" value="<?php echo @$res_attr['source_url']; ?>"  />	
</div>




<div class="form-group form-row">
	<label for="resource_image" class="col-md-3">Resource Image: </label>
	<?php echo @$upload_icon_disp; ?>
	<div class="col-md-6 nopadd"><input type="file" name="resource_image" id="resource_image" class="form-control col-md-9" style=""  /></div>
	
</div>

<div class="form-group form-row">
	<label for="access_id" class="col-md-3">Access Level: </label>
	<select name="access_id" id="access_id" class="form-control col-md-3">
	 <option value='1' <?php echo $access[1]; ?>>Public Access</option> 
	<option value='2' <?php echo $access[2]; ?> >Private (Members Only) Access</option>
	</select>
	
	<label for="published" class="col-md-3">Published: </label>
	<div class="col-md-3 nopadd">
	<label><input type="checkbox" name="published" id="published" class="form-control radio "  <?php echo $published; ?>   /> <small>(Yes / No)</small></label>
	</div>
	
</div>



<div class="form-group form-row">
	<label class="col-md-3">&nbsp;</label>
	<button type="input" name="submit" id="submit" value="submit" class="btn btn-success btn-icon col-md-3">Submit </button>
</div>

</form>


<script type="text/javascript">
jQuery(document).ready(function($) 
{
	//$('textarea').autoResize({extraSpace : 10 });
	
	
	$("#upload_on").click(function () { $("#file_box_upload").show(); $("#file_box_link").hide(); });
	$("#upload_off").click(function () { $("#file_box_upload").hide(); $("#file_box_link").show(); });
	
	
	$("#resource_title").blur(function () {
	  var valTitle 	= $(this).val();
	  var hyphenated  = urlTitle(valTitle);             
	  $('#resource_slug').val(hyphenated);       
	  
	  /*var valKeywords = $("#resource_tags").val();
	  var valMeta 	  = valTitle.replace(/[^a-zA-Z0-9]/g,",").replace(/[,]+/g,",").toLowerCase();
	  if(valKeywords == "") {  $("#resource_tags").val(valMeta); }*/
	});
	
	$("#fm_resources").validate({errorPlacement: function(error, element) { }});
	
});
</script>	