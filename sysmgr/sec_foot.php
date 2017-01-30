




<!-- JavaScript -->
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

<link rel="stylesheet" type="text/css" href="../scripts/js/jwysiwyg/jquery.wysiwyg.css" />
<script type="text/javascript" src="../scripts/js/jwysiwyg/jquery.wysiwyg.js"></script>

<link rel="stylesheet" type="text/css" href="../scripts/js/tagsinput/jquery.tagsinput.css" />
<script type="text/javascript" src="../scripts/js/tagsinput/jquery.tagsinput.js"></script>





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
	
	
	$.validator.addMethod("wysi_required", function (value, element) { return $('.wysi-required').val() !== ''; })
	
	
	if($('.hasDatePicker').length){ 
		$('.hasDatePicker').datepick();
	}
	
	if($('.tags-field').length){ 
		$('.tags-field').tagsInput({width:'auto'});
	}
	
	if($('.wysiwyg').length){ 
		$('.wysiwyg').wysiwyg(); 
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
					$('#wrap_staff_access_list').html('<img src="../images/loader.gif" alt="loading..."  />');
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

function urlTitle(text) {       
    text = text.replace(/[^a-zA-Z0-9]/g,"-").replace(/[-]+/g,"-").toLowerCase();
    return text;
}
</script>



<!--<script type="text/javascript" src="../scripts/js/datatable/stringMonthYear.js"></script>-->
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
			,"iDisplayLength": 25 
			,"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]
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