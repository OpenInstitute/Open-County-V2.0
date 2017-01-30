<?php


$parent = array();
	
if($op=="edit"){ $title_new	= "Edit "; } elseif($op=="new") { $title_new	= "New "; }

$upload_icon_disp = '';
$upload_icon_id   = '';

$access[1] = '';
$access[2] = '';

$id_owner  = '';

$file_box_link	= ' style="display: none"';
$file_box_upload  = '';

$fData = array();


if($op=="edit"){

	if($id)
	{
	
	//oi_dt_resources
		$sqdata = "SELECT * FROM `oc_dt_menu` WHERE  (`menu_id` = ".quote_smart($id).")";
		$rsdata = $cndb->dbQueryFetch($sqdata);
		$fData = current($rsdata);
		
		$res_attr = @unserialize($fData['resource_attributes']); 
		
		$sq_pero = "SELECT `menu_parent_id` FROM `oc_dt_menu_parent` WHERE (`menu_id` = ".q_si($fData['menu_id'])."); ";	
		$rs_pero = $cndb->dbQuery($sq_pero);
		if( $cndb->recordCount($rs_pero)) 
		{
			while($cn_pero = $cndb->fetchRow($rs_pero))
			{ $parent[] = $cn_pero['menu_parent_id']; }
		}
		
		
		$formaction			   = "_edit";		
		$upload_picy			= " ";
		$upload_picn			= " checked ";
		
		$file_box_link	= '';
		$file_box_upload  = ' style="display: none"';
		
	}
} else
	{
		$sqdata = "SELECT * FROM `oc_dt_menu`";
		$rsdata = $cndb->dbQuery($sqdata);
		$res_fields = (array) mysqli_fetch_fields($rsdata); 
		$fData = getTableFields($res_fields);
		$fData['published'] = 1;
		$fData['seq']	= 9;
		
		$formaction			   = "_new";
		
		$upload_picy			= " checked ";
		$upload_picn			= "";
		
		
	}
$article = '';
echo '<h3>'.clean_title($formaction).' Entry</h3>';		

$published = yesNoChecked($fData['published']);
//displayArray($parent);
@$access[$fData['id_access']] = ' selected ';	
?>

<form class="rwdform rwdfull rwdstripes rwdvalid " name="fm_vds" id="fm_vds" method="post" action="sys_posts.php" enctype="multipart/form-data" >
<input type="hidden" name="formtab" value="menus" />
<input type="hidden" name="formaction" value="<?php echo $formaction; ?>" />
<input type="hidden" name="formname" value="fm_menu" />
<input type="hidden" name="id" value="<?php echo @$fData['menu_id']; ?>" />
<input type="hidden" name="redirect" value="home.php?d=menus" />
<input type="hidden" name="post_by" value="<?php echo @$fData['post_by']; ?>" />
<input type="hidden" name="id_access" id="id_access" class="form-control " value="1"  />
<div class=""></div>

<div class="form-group form-row"><label for="menu_title" class="col-md-3">Title: </label>
<input type="text" name="menu_title" id="menu_title" class="form-control col-md-9 required" value="<?php echo @$fData['menu_title']; ?>"  />
</div>

<div class="form-group form-row"><label for="menu_seo" class="col-md-3">Menu Reference: </label>
<input type="text" name="menu_seo" id="menu_seo" class="form-control col-md-9 " value="<?php echo @$fData['menu_seo']; ?>"  />
</div>

<div class="form-group form-row">
	<label for="id_type_menu" class="col-md-3">Menu Type: </label>
	<select name="id_type_menu" id="id_type_menu" class="form-control col-md-3">
	   <?php echo $ddSelect->dropper_select("oc_dt_conf_menu_type", "menutype_id", "menutype", @$fData['id_type_menu']) ?>
	   </select> 
	
	<label for="id_section" class="col-md-3">Section: </label>
	<select name="id_section" id="id_section" class="form-control col-md-3">
	<?php echo $ddSelect->dropperSection(@$fData['id_section']); ?>
  </select>
</div>

<div class="form-group form-row">
	<label for="id_parent" class="col-md-3">Menu Parent: </label>
	<div class="col-md-3 nopadd">
	<select name="id_parent1[]" id="id_parent" multiple="multiple" class="form-control multiple">
		<?php echo $dispData->build_MenuSelectRage(@$fData['menu_id'], $parent); ?>
	</select>
	</div>
	<label for="menu_href" class="col-md-3">Manual Link: </label>
	<input type="text" name="menu_href" id="menu_href" class="form-control col-md-3" value="<?php echo @$fData['menu_href']; ?>"  />
</div>



<div class="form-group form-row"><label for="menu_tags" class="col-md-3">Menu Tags: </label>
<input type="text" name="menu_tags" id="menu_tags" class="form-control col-md-9 required tags-field" value="<?php echo @$fData['menu_tags']; ?>"  />
</div>



<div class="form-group form-row">
	<label for="id_access" class="col-md-3">Access Level: </label>
	<select name="id_access" id="id_access" class="form-control col-md-3">
		 <option value='1' <?php echo $access[1]; ?>>Public Access</option> 
		<option value='2' <?php echo $access[2]; ?> >Private (Members Only) Access</option>
	</select>
	
	<label for="seq" class="col-md-3">Position: </label>
	<input type="number" name="seq" id="seq" class="form-control col-md-1" maxlength="2" value="<?php echo @$fData['seq']; ?>"  />
</div>


<div class="form-group form-row"><label for="published" class="col-md-3">Published: </label><div class="col-md-9">
<label><input type="checkbox" name="published" id="published" class="form-control radio "  <?php echo $published; ?>   /> <small>(Yes / No)</small></label>
</div></div>

<?php if($op=="new") { ?>
<div class="form-group form-row">
	
<label for="add_content" class="col-md-3">Add Menu Content: </label>
<div class="col-md-9"><input type="checkbox" id="add_content" name="add_content" class="radio"/> Yes / No</div>
</div>

<div id="tr_menu_content" style="display: none">
	<div class="form-group form-row">
	<label for="article_title" class="col-md-3">Content Title</label>
	<input type="text" name="article_title" id="article_title" class="form-control col-md-9">
	</div>

	<div class="form-group form-row">
	<label for="article" class="col-md-3">Content</label>
	<div class="col-md-9 nopadd"><?php include("fck_rage/article.php"); ?></div>
	</div>
</div>	
<?php } ?>


<div class="form-group form-row">
<label class="col-md-3">&nbsp;</label>
<button type="input" name="submit" id="submit" value="submit" class="btn btn-success btn-icon col-md-3">Submit </button>

</div>

</form>

<script type="text/javascript">
jQuery(document).ready(function($) { 
	$("#add_content").click(function () { 
		if($("#add_content").is(':checked')) {
			$("#tr_menu_content").show();  
			$("#article_title").attr('value', $("input#menu_title").val());  }
		else {
			$("#tr_menu_content").hide(); }
	});	
	
	$("#menu_title").blur(function () {
	  var valTitle 	= $(this).val();
	  var hyphenated  = urlTitle(valTitle);             
	  $('#menu_seo').val(hyphenated);       
	  
	  var valKeywords = $("#menu_tags").val();
	  var valMeta 	  = valTitle.replace(/[^a-zA-Z0-9]/g,",").replace(/[,]+/g,",").toLowerCase();
	  if(valKeywords == "") {  $("#menu_tags").val(valMeta); }
	});
});


</script>
