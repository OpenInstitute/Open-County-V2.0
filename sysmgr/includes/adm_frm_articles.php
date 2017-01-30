<div>


<?php

	$article = '';
$url_title_article = '';

	$ths_page="?d=$dir&op=$op";

	$formname = "fm_articles";
	
if($op=="edit"){ $title_new	= "Edit "; } 
elseif($op=="new") { $title_new	= "New "; }

	$county_id = '';
	
if($op=="edit"){

	if($id)
	{
	
	$sqdata="SELECT  *  FROM `oc_dt_content`  WHERE  (`content_id` = ".quote_smart($id).")";
	$rsdata = $cndb->dbQueryFetch($sqdata);
	$fData = current($rsdata);
	
		$content_id = $fData['content_id'];
		
		$sq_item_parent = "SELECT * FROM `oc_dt_content_parent` WHERE (`content_id` = ".q_si($content_id)."); "; 
		$rs_item_parent = $cndb->dbQuery($sq_item_parent);
		if( $cndb->recordCount($rs_item_parent)) {
			while($cn_item_parent = $cndb->fetchRow($rs_item_parent)) { 
				if($cn_item_parent['menu_id'] <> 0) { $parent[] = $cn_item_parent['menu_id']; }  
				if($cn_item_parent['county_id'] <> 0) { $parent_county[] = $cn_item_parent['county_id']; }  
			 	//$county_id = $cn_item_parent['county_id']; 
			}
		}
	
		$article	= str_replace(SITE_PATH, '', $fData['content_article']);
		$article	= str_replace(SITE_DOMAIN_LIVE, '', $article);		
		$article 	= str_replace('"images/', '"'.SITE_DOMAIN_LIVE.'images/', $article);
		$article	= remove_special_chars(stripslashes($article));
		
		
		$pgtitle				="<h2 class='nopadd nomargin'>Edit Content</h2>";
		$formaction			   = "_edit";		
	}


} 
elseif($op=="new")
	{
	
		$pgtitle ="<h2 class='nopadd nomargin'>Add New Content</h2>";
		
		$sqdata = "SELECT * FROM `oc_dt_content`";
		$rsdata = $cndb->dbQuery($sqdata);
		$res_fields = (array) mysqli_fetch_fields($rsdata); 
		$fData = getTableFields($res_fields);
		
		$fData['content_created'] = date('Y-m-d', time());
		$fData['published'] = 1;
		
		
		//$formname			= "article_basic_new";
		$formaction			   = "_new";
	}

	
 
$created = date('Y-m-d', strtotime($fData['content_created']));
$published = yesNoChecked($fData['published']);	

	//displayArray($fData);
 //echo getcwd().DIRECTORY_SEPARATOR;
 ?>

<div style="width:100%; ">
	
<div style="padding:10px;">
<form class="rwdform rwdfull" id="cont_basic" name="rage" method="post" action="sys_posts.php" onsubmit="javascript:return valid_article()"   enctype="multipart/form-data">

	
<input type="hidden" name="approved" value="on" />
<input type="hidden" name="formtab" value="articles" />
<input type="hidden" name="formaction" value="<?php echo $formaction; ?>" />
<input type="hidden" name="formname" value="fm_articles" />
<input type="hidden" name="id" value="<?php echo @$fData['content_id']; ?>" />
<input type="hidden" name="redirect" value="home.php?d=articles" />
<input type="hidden" name="post_by" value="<?php echo @$fData['post_by']; ?>" />
<input type="hidden" name="id_access" id="id_access" class="form-control " value="1"  />


<?php echo '<h3>'.clean_title($formaction).' Entry</h3>';	 //echo $pgtitle;  ?>



<div class="form-group form-row">
	<label for="id_parent" class="col-md-3">Parent Menu: </label>
	<div class="col-md-3 nopadd">
	
	<select name="id_parent1[]" id="id_parent" multiple="multiple" class="form-control multiple">
		<?php echo $dispData->build_MenuSelectRage(@$fData['menu_id'], $parent); ?>
	</select>
	</div>
	
	<label for="county_id" class="col-md-3">Parent County: </label>
	<div class="col-md-3 nopadd">
	<select name="county_id[]" id="county_id" multiple="multiple" class="form-control multiple">
		<?php echo $ddSelect->dropperCounties($parent_county); ?>
	</select>
	</div>
</div>

<div class="form-group form-row">
	<label for="content_title" class="col-md-3">Title: </label>
	<input type="text" name="content_title" id="content_title" class="form-control col-md-9 required" value="<?php echo @$fData['content_title']; ?>"  />
</div>

<?php if($op=="edit"){ ?>
<div class="form-group form-row">
	<label for="" class="col-md-3">&nbsp; </label>
	<div class="col-md-9">
	<?php echo 'Page Link: <a href="'.SITE_DOMAIN_LIVE.$content_id.'/'.@$fData['content_seo'].'" target="_blank">'.$content_id.'/'.@$fData['content_seo'].'</a>';  ?>		
	</div>
</div>
<?php } ?>


<div class="form-group form-row">
	<label for="id_section" class="col-md-3">Template: </label>
	<select name="id_section" id="id_section" class="form-control col-md-3">
	<?php echo $ddSelect->dropperSection(@$fData['id_section']); ?>
  	</select>
  	
  	<label for="content_created" class="col-md-3">Date: </label>
  	<input type="text" name="content_created" id="content_created" value="<?php echo $created; ?>" class="form-control hasDatePicker required col-md-3" >
</div>






<div class="form-group form-row">
	<label for="article" class="col-md-3">Content: </label>
	<div class="col-md-9 nopadd">
	<textarea name="content_article" id="content_article" class="form-control wysiwyg col-md-12 wysi_requiredX"><?php echo @$fData['content_article']; ?></textarea>
	<?php //include("fck_rage/article.php"); ?>
	</div>
</div>



<div class="form-group form-row">
	<label for="content_tags" class="col-md-3">Content Tags: </label>
	<input type="text" id="content_tags" name="content_tags"  value="<?php echo @$fData['content_tags']; ?>" class="form-control col-md-9 tags-field" />
</div>


<div class="form-group form-row">
	<label for="published" class="col-md-3">Published: </label>
	<div class="col-md-9 nopadd">
<label><input type="checkbox" name="published" id="published" class="form-control radio "  <?php echo $published; ?>   /> <small>(Yes / No)</small></label>
</div></div>

<div class="form-group form-row">
<label for="file_type" class="col-md-3">Gallery:</label>
	<div class="radio_group col-md-9">
		
	<label><input type="radio" name="file_type" id="no_gallery" class="radio" checked="checked"  /> No Action</label>	&nbsp;	
	<label><input type="radio" name="file_type" id="add_photo" value="p" class="radio"  /> Upload Image (Browse)</label>	&nbsp;
	<label><input type="radio" name="file_type" id="add_photo_url" value="u" class="radio"  /> Attach Image (Enter Name)</label>	&nbsp;
	<label><input type="radio" name="file_type" id="add_video" value="v" class="radio" />Link Video </label>  	
	</div>
</div>

<div class="form-group form-row">
	<label for="" class="col-md-3">&nbsp;</label>
	<div class="col-md-9">

		<div id="file_box_video" style="display: none; ">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
			<td style="width:130px;"> <label for="video_name"><strong>Video URL:</strong></label> </td>
			<td><input type="text" name="video_name" id="video_name" value="" class="form-control" > &nbsp; <span class="hint">e.g. http://www.youtube.com/watch?v=10101010101</span></td>
			</tr>

			<tr>
			<td><label for="video_caption"><strong>Video Caption:</strong></label> </td>
			<td><textarea name="video_caption" id="video_caption" class="text_full form-control" ></textarea> </td>
			</tr>

			</table>
		</div>


		<div id="file_box_photo_url" style="display: none; ">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
			<td style="width:130px;"> <label for="photo_url_name"><strong>Image URL:</strong></label> </td>
			<td><input type="text" name="photo_url_name" id="photo_url_name" value=""  class="text_full form-control"> </td>
			</tr>

			<tr>
			<td><label for="photo_url_caption"><strong>Image Caption:</strong></label> </td>
			<td><textarea name="photo_url_caption" id="photo_url_caption" class="text_full form-control"></textarea> </td>
			</tr>
			<tr>
			<td><label for="id_gallery_cat"><strong>Category:</strong></label></td>
				<td><select name="id_gallery_cat_u" id="id_gallery_cat_u" class="form-control" style="width:300px;">
					<?php //echo $ddSelect->dropper_select("olnt_dt_gallery_category", "id", "title", 2) ?>
					</select></td>
			</tr>
			</table>
		</div>


		<div id="file_box_photo" style="display: none;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
			<td style="width:130px;"> <label for="photo_name"><strong>Select Image:</strong>: </label> </td>
			<td><input type="file" name="myfile" id="photo_name" size="57"   /></td>
			<td><label for="id_gallery_cat"><strong>Category:</strong></label></td>
				<td><select name="id_gallery_cat" id="id_gallery_cat" class="form-control" style="width:300px;">
					<?php //echo $ddSelect->dropper_select("olnt_dt_gallery_category", "id", "title", 2) ?>
					</select></td>
			</tr>
			<tr>
			<td><label for="photo_caption"> <strong>Image Caption:</strong> </label></td>
			<td colspan="3"><textarea name="photo_caption" id="photo_caption" class="form-control" ></textarea> </td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>	

	</div>
</div>


<div class="form-group form-row">
	<label class="col-md-3">&nbsp;</label>
	<div class="col-md-9">
		<button type="input" name="submit" id="submit" value="submit" class="btn btn-success btn-icon">Submit </button>
	</div>
</div>

<div class="form-group">
	<ul id="files" ></ul>
</div>




</form>	

</div>
</div>
	
	
<p>&nbsp;</p><p>&nbsp;</p>
</div>


<iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
		
		
<script type="text/javascript">
jQuery(document).ready(function($)
{ 
	
	$("#no_gallery").click(function () { 
		$("#file_box_video").hide(); $("#file_box_photo").hide(); $("#file_box_photo_url").hide();   
	});
	$("#add_video").click(function () { 
		$("#file_box_video").show(); $("#file_box_photo").hide(); $("#file_box_photo_url").hide();  
		$("#video_caption").text($("input#content_title").val());    
	});
	$("#add_photo").click(function () { 
		$("#file_box_video").hide(); $("#file_box_photo").show(); $("#file_box_photo_url").hide(); 
		$("#photo_caption").text($("input#content_title").val());    
	});
	$("#add_photo_url").click(function () { 
		$("#file_box_video").hide(); $("#file_box_photo").hide(); $("#file_box_photo_url").show(); 
		$("#photo_url_caption").text($("input#content_title").val());    
	});
	
	
	$("select#id_parent").change(function () {
	  var valTitle = $("input#article_title").val();
	  var valSlash = /(.+)(\/)/g; 
	  var valClean, str = "";
	  $("select#id_parent option:selected").each(function () { str += $(this).text() + " ";  });	  
	  if(str.search(valSlash) == 0) { valClean = str.replace(valSlash,""); } else { valClean = str; }	  
	  if(valTitle == "") { $("input#article_title").attr("value", valClean); }
	});	
	
	
	$("#content_title").blur(function () {
	  var valTitlek 	= $("#content_title").val().toLowerCase();
	  var valKeywords = $("#content_tags").val(); 
	  var valSlashk 	= /(the)/g; //(and)(for)
	  var valCleank, valStr = "";
	  valStr = valTitlek; //$(this).text();
	 
	 valCleank =  valStr.replace(/\bthe\b/g, "").replace(/\band\b/g, '').replace(/\bfor\b/g, '').replace(/\bfrom\b/g, ''); 
	 $("#content_tags").attr("value", valCleank);
	  
	});
	
	
});

</script>