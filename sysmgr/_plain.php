<?php require '../classes/cls.constants.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<link href="../images/favicon-admin.png" rel="shortcut icon" type="image/png" />
	<title>Admin:: ICDC Knowledge Base Portal</title>
	
	<link href="css/style.default.css" rel="stylesheet">
	<link href="css/style.katniss.css" rel="stylesheet">
		
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->


<link rel="stylesheet" type="text/css" href="../scripts/js/multiselect/jquery.multiselect.css" />
<link rel="stylesheet" type="text/css" href="../scripts/js/multiselect/jquery.multiselect.filter.css" />
<link rel="stylesheet" type="text/css" href="../scripts/js/datatable/jquery.dataTables.css" />

<!--<link rel="stylesheet" type="text/css" href="styles/data_table.css" />-->
<link rel="stylesheet" type="text/css" href="../scripts/js/datepick/jquery.datepick.css" id="theme">

<link rel="stylesheet" type="text/css" href="../scripts/css/smoothness/jquery-ui-1.10.2.css" />
<link rel="stylesheet" type="text/css" href="../scripts/css/smoothness/jquery-ui-1.8.4.custom.css" />
<link rel="stylesheet" type="text/css" href="../scripts/js/datatable/jquery.dataTables.override.css" />
<link rel="stylesheet" type="text/css" href="../scripts/css/fonts/font-awesome/font-awesome.css" />

<style type="text/css">
/*th.ui-state-default div.DataTables_sort_wrapper { 
	position: relative; white-space: nowrap; text-overflow: '..' !important; overflow-x: hidden; box-sizing: content-box; padding-right:15px; text-transform:none; 
}
th.ui-state-default.small_col { padding-right: 1px !important; width: 50px !important; }
th.ui-state-default.small_col div.DataTables_sort_wrapper {  width: 50px !important; }
div.DataTables_sort_wrapper .DataTables_sort_icon {  position:absolute; right:0px; top:1px;}*/
</style>


<script src="../scripts/js/jquery-1.12.3.js"></script>



<!--<link rel="stylesheet" type="text/css" href="styles/style.css" />-->
</head>


<body class="tooltips has-top-notification stickyheader ">
	
		
<section>
<!-- section - STARTS -->



<!-- Left Section -->
<div class="leftpanel ">
		
	<!-- Logo Panel -->
	<div class="logopanel " style="cursor:pointer; height:53px;" id="header_logo_panel"> 
		<a href="./"><img src="<?php echo SITE_LOGO; ?>" style="" /></a>
	</div>			
	<!-- Logo Panel - ENDS -->


	<div class="leftpanelinner ">

		<!-- Account Panel - small devices -->
		<div class="visible-xs hidden-sm hidden-md hidden-lg">
			<div class="media userlogged">
				<img alt="" src="http://localhost/rage_htweb/bora_icdc_raw/image/avatars/munene.murage@gmail.com.jpg" class="media-object">
				<div class="media-bodyX">
					<h4>Murage Munene</h4>
					<span>Level: Superuser</span>
				</div>
			</div>
			<h5 class="sidebartitle actitle">Account</h5>
			<ul class="nav nav-pills nav-stacked nav-bracket mb30">

				<li><a href="javascript:;" data-toggle="modal" data-target="#logout_mdl"><i class="fa fa-sign-out"></i> <span>Logout</span></a></li>
			</ul>
		</div>
		<!-- Account Panel - small devices - ENDS -->

		<!-- Left Menu -->
		<div>
		<h5 class="sidebartitle">Navigation</h5>
		<ul class="nav nav-pills nav-stacked nav-bracket">
<li class="nav-active active"><a href="index.php"><i class="fa fa-tachometer"></i> <span>Dashboard</span> </a></li>


<!-- Categories -->
<li class="nav-parent "><a href=""><i class="fa fa-folder-o"></i> <span>Categories</span></a>
<ul class="children" >
	<li ><a href="adm_menus.php?d=categories&op=new"><i class="fa fa-plus-circle"></i> Add New</a></li>
	<li ><a href="home.php?d=categories"><i class="fa fa-folder-open-o"></i> Manage</a></li>
</ul>
</li>


<!-- Articles -->
<li class="nav-parent "><a href=""><i class="fa fa-edit"></i> <span>Articles</span></a>
<ul class="children" >
	<li ><a href="adm_config.php?d=all articles&op=new"><i class="fa fa-plus-circle"></i> Add New</a></li>			
	<li ><a href="home.php?d=all articles"><i class="fa fa-files-o"></i> Manage </a></li>


</ul>
</li>



<!-- News -->
<li class="nav-parent "><a href=""><i class="fa fa-file-text-o"></i> <span>News</span></a>
<ul class="children" >
	<li ><a href="adm_config.php?d=news&op=new"><i class="fa fa-plus-circle"></i> Add New</a></li>
	<li ><a href="home.php?d=news"><i class="fa fa-file-text-o"></i> Manage</a></li>
</ul>
</li>


<!-- Events -->
<li class="nav-parent "><a href=""><i class="fa fa-calendar-o"></i> <span>Events</span></a>
<ul class="children" >
	<li ><a href="adm_config.php?d=events&op=new"><i class="fa fa-plus-circle"></i> Add New</a></li>
	<li ><a href="home.php?d=events"><i class="fa fa-file-text-o"></i> Manage</a></li>
</ul>
</li>

	<!-- Comments -->
<li class="nav-parent "><a href=""><i class="fa fa-comments-o"></i> <span>Comments</span></a>
<ul class="children" >
	<li ><a href="home.php?d=comments"><i class="fa fa-arrow-circle-up"></i> Manage</a></li>
	<li ><a href="home.php?d=comments&op=pending"><i class="fa fa-flag"></i> Pending</a></li>			
</ul>
</li>


<!-- Forums -->
<li class="nav-parent "><a href=""><i class="fa fa-comments-o"></i> <span>Online Forums</span></a>
<ul class="children" >
	<li ><a href="adm_forum.php?d=online forums"><i class="fa fa-arrow-circle-up"></i> Manage</a></li>			
</ul>
</li>


<!-- Resources -->
<li class="nav-parent "><a href=""><i class="fa fa-book"></i> <span>Resource Library</span></a>
<ul class="children" >
	<li ><a href="adm_config.php?d=resource library&op=new"><i class="fa fa-plus-circle"></i> Add New</a></li>
	<li ><a href="home.php?d=resource library"><i class="fa fa-flag"></i> Manage</a></li>
</ul>
</li>



<!-- Resources -->
<li class="nav-parent "><a href=""><i class="fa fa-book"></i> <span>Image and Video gallery</span></a>
<ul class="children" >
	<li ><a href="adm_config.php?d=image and video gallery&op=new"><i class="fa fa-plus-circle"></i> Add New</a></li>
	<li ><a href="home.php?d=image and video gallery"><i class="fa fa-flag"></i> Manage</a></li>
</ul>
</li>


<!-- Tickets -->

<!-- Glossary -->


	<!-- Users -->
<li class="nav-parent "><a href=""><i class="fa fa-users"></i> <span>Staff</span></a>
<ul class="children" >
	<li ><a href="adm_config.php?d=staff&op=new"><i class="fa fa-plus-circle"></i> Add New</a></li>
	<li ><a href="home.php?d=staff"><i class="fa fa-users"></i> Manage</a></li>

</ul>
</li>

<!-- Groups -->
<li class="nav-parent "><a href=""><i class="fa fa-sitemap"></i> <span>Groups</span></a>
<ul class="children" >
	<li ><a href="adm_config.php?d=groups&op=new"><i class="fa fa-plus-circle"></i> Add New</a></li>
	<li ><a href="home.php?d=groups"><i class="fa fa-joomla"></i> Manage</a></li>
</ul>
</li>



<!-- Positions -->
<li class="nav-parent "><a href=""><i class="fa fa-sitemap"></i> <span>Positions</span></a>
<ul class="children" >
	<li ><a href="adm_config.php?d=positions&op=new"><i class="fa fa-plus-circle"></i> Add New</a></li>
	<li ><a href="home.php?d=positions"><i class="fa fa-sitemap"></i> Manage</a></li>
</ul>
</li>


<!-- Statistics -->
<!-- Tools -->



<li class="nav-parent "><a href=""><i class="fa fa-wrench"></i> <span>Tools</span> </a>
<ul class="children" >
	<li ><a href="home.php?d=online polls"><i class="fa fa-star"></i> Online Polls</a></li>
	<li ><a href="home.php?d=feedback posts"><i class="fa fa-envelope"></i> Staff Feedback</a></li>
				<li ><a href="adm_config.php?d=admin settings"><i class="fa fa-gears"></i> Admin Settings</a></li>
	<li ><a href="adm_arch.php?d=articles"><i class="fa fa-trash-o"></i> Delete Records</a></li>

			</ul>
</li>


</ul>
		</div>
		<!-- Left Menu - ENDS -->

	</div>

</div>
<!-- Left Section - ENDS -->		
		
		
		
		
		
		
<!-- mainpanel -->	
<div class="mainpanel ">

	<!-- headerbar -->
	<div class="headerbar ">
		<a class="menutoggle"><i class="fa fa-bars"></i></a>				
		<div class="header-right">
			<ul class="headermenu">
			
			
			<!--Home-->	
				<li>
					<div class="btn-group">
						<span id="kb-link">
							<a class="btn btn-default tp-icon" style="color:#FFC" title="Public Area" href="../" target="_blank">
								<i class="glyphicon glyphicon-home"></i> &nbsp; <?php echo SITE_TITLE_SHORT; ?> Home
							</a>
						</span>
					</div>
				</li>
				
			<!--Bell-->	
			<li>
				<div class="btn-group">
					<button class="btn btn-default dropdown-toggle tp-icon" data-toggle="dropdown">
						<i class="glyphicon glyphicon-bell"></i>
						
					</button>
					<div class="dropdown-menu dropdown-menu-head pull-right"><h5 class="title text-center"><i class="fa fa-exclamation-circle"></i> &nbsp;There are no records to show</h5>
					</div>
				</div>
			</li>
			
			<!--Envelope-->	
			<li>
				<div class="btn-group">
					<button class="btn btn-default dropdown-toggle tp-icon" data-toggle="dropdown">
						<i class="glyphicon glyphicon-envelope"></i>
						<span class="badge">0</span>
					</button>
					<div class="dropdown-menu dropdown-menu-head pull-right">
						<h5 class="title">You Have 0 Pending Article(s)</h5>
						<h5 class="title text-center"><a href="home.php?d=all articles">See All Articles</a></h5>
					</div>
				</div>
			</li>
			
			<!--Comments-->	
			<li>
				<div class="btn-group">
					<button class="btn btn-default dropdown-toggle tp-icon" data-toggle="dropdown">
						<i class="glyphicon glyphicon-comment"></i>
						<span class="badge">0</span>
					</button>
					<div class="dropdown-menu dropdown-menu-head pull-right">
						<h5 class="title">You Have 0 Pending Comment(s)</h5>
						<h5 class="title text-center"><a href="home.php?d=comments&op=pending">See All Pending Comments</a></h5>
					</div>
				</div>
			</li>				
			<?php /* ?>	<?php */ ?>
			
			<li>
				<div class="btn-group">
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<img src="http://localhost/rage_htweb/bora_icdc_raw/image/avatars/munene.murage@gmail.com.jpg" alt="" /> Murage <span style="font-size:12px; font-weight:normal; color:#C4CCDF">(Superuser)</span>
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu dropdown-menu-usermenu pull-right">							
						<li><a href="javascript:;" data-toggle="modal" data-target="#logout_mdl"><i class="glyphicon glyphicon-log-out"></i> Logout</a></li>
					</ul>
				</div>
			</li>
			</ul>
		</div>		
	</div>
	<!-- headerbar - END -->
	
	
	
	<!-- content-title -->
	<div class="pageheader ">
		<h2><i class="fa fa-tachometer"></i> Categories &raquo; </h2>
		<div class="breadcrumb-wrapper"> {breadcrumbs} </div>
	</div>
	<!-- content-title - END -->		
	
				
	<!-- PageContent -->			
	<div class="contentpanel ">
		{content}
		<?php 
			//include("includes/adm_articles_list.php"); 
			//include("includes/adm_form_articles.php");
		?>
	</div>
	<!-- PageContent - ENDS -->	
			
					
</div>
<!-- mainpanel - ENDS -->	
		



	
<!-- rightpanel - STARTS -->
<div class="rightpanel "></div>
<!-- rightpanel - ENDS -->




<!-- BEGIN BACK TO TOP BUTTON -->
<div id="back-top">
	<a href="#top"><i class="fa fa-chevron-up"></i></a>
</div>
<!-- END BACK TO TOP -->
		
		
		
<!-- section - ENDS -->			
</section>






<!-- KB JavaScript -->

<!-- Bracket JavaScript -->

<script type="text/javascript" src="../scripts/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="../scripts/js/jquery-ui-1.10.2.min.js"></script>
<script type="text/javascript" src="../scripts/js/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../scripts/js/modernizr-2.6.2.min.js"></script>
<script type="text/javascript" src="../scripts/js/misc/jquery.cookie.min.js"></script>

<script type="text/javascript" src="js/ajax.js"></script>
<script type="text/javascript" src="js/articles.js"></script>


<script type="text/javascript" src="../scripts/js/validate/jquery.validate-1.14.min.js"></script>	

	
<script type="text/javascript" src="../scripts/js/multiselect/jquery.multiselect.js"></script>
<script type="text/javascript" src="../scripts/js/multiselect/jquery.multiselect.filter.js"></script>

<script type="text/javascript" src="../scripts/js/datepick/jquery.plugin.js"></script>
<script type="text/javascript" src="../scripts/js/datepick/jquery.datepick.js"></script>
<script type="text/javascript" src="../scripts/js/misc/jquery.print.js"></script>

<link rel="stylesheet" type="text/css" href="../scripts/js/toggles/toggles.css" />
<script type="text/javascript" src="../scripts/js/toggles/toggles.min.js"></script>


<!-- page specific scripts -->
<script type="text/javascript" charset="utf-8">
	
jQuery(document).ready(function($) {	 

	if($('label.required').length) { $('label.required').append('&nbsp;<span class="rq">*</span>&nbsp;'); }
	if($('.hasDatePicker').length) { $('.hasDatePicker').datepick(); }  
	if($('select.multiple').length) { $("select.multiple").multiselect().multiselectfilter(); }
	
	if($('#adm_download_form').length) 
	{
		$("#upload_on").click(function () { $("#file_box_upload").show(); $("#file_box_link").hide(); });
		$("#upload_off").click(function () { $("#file_box_upload").hide(); $("#file_box_link").show(); });		
		$("#adm_download_form").validate();
	}
	
	
	
	
	if( $('.form_events').length ) 
	{ 
	//chgDate(); 
	/* ============= @@ additional toggles ======================== */
	
	var template_doc = jQuery.validator.format($.trim($("#date_filler").val()));
	function addRow_doc() { $(template_doc(j++)).appendTo("#event_dates_table tbody");  }
	function delRow_doc() { j= j-1; $(".tr_date_row_"+j).remove();  }
	
	var j = 1;  addRow_doc();  
	$("#add_date").click(addRow_doc);
	$("#del_date").click(delRow_doc);
	
	/* ============= @@ validations ======================== */
	
	var validator = $(".form_events").validate({ ignore: '' });
	
	$('input.date-pick').live('click', function() {
		$(this).datepick('destroy').datepick({showOn:'focus'}).focus();
	});
	
	}	
	
	
	if($('#wrap_staff_access_logs').length) 
	{
		$("#cat_docs").click(function () { $("#cat_docs_list").show(); $("#cat_cont_list").hide(); });
		$("#cat_cont").click(function () { $("#cat_cont_list").show(); $("#cat_docs_list").hide(); });
		
		$("a#access_list_print").click(function(){
		   $("#wrap_staff_access_box").print();
		   return( false );
		});
	}
	
	
});

function del_date_row(row_id) { 
	$(document).ready(function(){ 
		$(".tr_date_row_"+row_id).remove();
	});
}



function showStaffAccessLog(log_cat)
{ 	
	jQuery(document).ready(function($) {
		if(log_cat === 'cont') {
		   item_id = $('#id_log_cont option:selected').val(); 
		   item_val = 'Article Access Log: '+$("#id_log_cont option:selected").text()+'';
		}
		else {
		   item_id = $('#id_log_docs option:selected').val(); 
		   item_val = 'Document Access Log: '+$("#id_log_docs option:selected").text()+'';
		  // item_val = $("#id_log_docs option:selected").text();
		}
		
		
		if(item_id !== '')
		{
			$.ajax({
				type: 'GET',
				url: 'adm_operations.php', 
				data: 'log_cat=' + log_cat + '&log_item='+ item_id + '&tk=1482469758',
				dataType: 'html',
				beforeSend: function() {
					$('#wrap_staff_access_list').html('<img src="../image/loader.gif" alt="loading..."  />');
				},
				success: function(response) {
					$('#wrap_staff_access_list').html(response);
					$('#access_list_print').show();
				}
			});
			$('#access_list_label').html(item_val);
			
		}
			
	});
}

</script>



<script type="text/javascript" src="../scripts/js/datatable/stringMonthYear.js"></script>
<script type="text/javascript" src="../scripts/js/datatable/jquery.dataTables-1.10.12.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function()
{
	var current = $(".children").find("a").filter(function() { 
		return this.href.toLowerCase() == location.href.toLowerCase(); });
	
	if ( current.length ) {
		current.addClass("selected"); 
		$('ul.children li:has(a.selected)').addClass("active"); 
		$('ul.children:has(li.active)').css("display", "block"); 
	}
	
});



$(document).ready(function(){
	
	if( $('#frm_delete').length )
	{
	 	$('#frm_delete').submit( function() {
			var sData = oTable.$('input').serialize();
			//alert( "The following data would have been submitted to the server: \n\n"+sData );
			//return false;
     	});
		
	 	var oTable = $('#frm_delete_list').dataTable({
			"bJQueryUI": true 
			,"sPaginationType": "full_numbers"
			,"iDisplayLength": 50 
			,"aLengthMenu": [[50, 100, -1], [50, 100, "All"]]	
				 	});
	 
	}
	
	
	if( $('#example').length )
	{
		var oTable = $('#example').dataTable({
			"bProcessing": true
			,"bJQueryUI": true 
			,"sPaginationType": "full_numbers"			
			,"bStateSave": true
			,"iDisplayLength": 5 
			,"aLengthMenu": [[5, 25, 50, 100, -1], [5, 25, 50, 100, "All"]]
			/*,"bPaginate": true
			,*/
			 //, "sDom": '<"toolbar">lfrtip'
			
		});
	}
	
$("div.toolbar").html('<div class="bulk-action"> <div class="row"><div class="col-sm-7 col-md-7 col-lg-7 mb5 xs-width100p xs-center pull-right"><input type="hidden" name="action_for" id="action_for" value="articles" /><div class="pull-right"><div class="form-group xs-width100p"><div class="input-group"><select name="bulk_action_id" id="bulk_action_id" class="form-control"><option value="">Select Bulk Action</option><option value="Disapprove Selected">Disapprove Selected</option><option value="Mark Featured">Mark Featured</option><option value="Delete Revisions">Delete Revisions</option><option value="Show Selected">Show Selected</option><option value="Hide Selected">Hide Selected</option><option value="Enable Comments">Enable Comments</option><option value="Disable Comments">Disable Comments</option><option value="Enable Ratings">Enable Ratings</option><option value="Disable Ratings">Disable Ratings</option><option value="Reset Ratings">Reset Ratings</option><option value="Remove Comments">Remove Comments</option><option value="Reset Hits">Reset Hits</option><option value="Delete Selected">Delete Selected</option></select><span class="input-group-btn"><input type="submit" name="bulk_action" id="bulk_action" value="Apply" class="btn btn-danger bulkaction"><input type="hidden" name="bulk_action_alt" id="bulk_action_alt" value="Apply"></span></div></div></div></div>									</div></div>');
});
</script>					



	<script src="js/custom.js"></script>
	


					
	<!-- LOGOUT MODAL - STARTS -->
	<div class="modal fade" id="logout_mdl" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content modal-no-shadow modal-no-border">
				<div class="modal-header bg-warning no-border">
					<h4 class="modal-title">Are you sure?</h4>
				</div>
				<div class="modal-body">
					You want to log out now! Any unsaved changes will be lost.
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-warning" data-dismiss="modal" onclick="window.location='adm_posts.php?signout=on';">Yes, log me out!</button>
				</div>
			</div>
		</div>
	</div>
	<!-- LOGOUT MODAL - ENDS -->		

			

					
</body>
</html>										
					
