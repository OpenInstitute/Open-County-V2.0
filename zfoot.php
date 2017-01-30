
	<!-- Go To Top
	============================================= -->
	<div id="gotoTop" class="icon-angle-up"></div>



	<!-- External JavaScripts
	============================================= -->	
	<script type="text/javascript" src="scripts/js/plugins.js"></script>
	


	<!-- Bootstrap Select Plugin -->
	<script type="text/javascript" src="scripts/js/components/bs-select.js"></script>
	<link rel="stylesheet" href="scripts/css/components/bs-select.css" type="text/css" />
	
	
	<!-- Footer Scripts
	============================================= -->
	<script type="text/javascript" src="scripts/js/functions.js"></script>
	
	
	<!-- @@Murage Scripts
	============================================= -->
	<script type="text/javascript" src="scripts/captchajx/ajax_captcha.js"></script>
	<script type="text/javascript" src="scripts/js/validate/jquery.validate-1.14.min.js"></script>
	<script type="text/javascript" src="scripts/js/validate/jquery.validate-1.14.additional.min.js"></script>
	<script type="text/javascript" src="scripts/js/modal/jquery.modal.js" charset="utf-8"></script>
	<div class="modal fade" style="display:none;"></div>
	<div id="dynaScript"></div>
	
	<?php //if($this_page == 'budget.php'){ ?>
	<script src="scripts/js/highcharts/highcharts.js"></script>
	<script src="scripts/js/highcharts/highcharts_data.js"></script>
	<script src="scripts/js/highcharts/highcharts_drilldown.js"></script>
	<script src="scripts/js/highcharts/highcharts_exporting.js"></script>
	<script src="scripts/js/highcharts/rgbcolor.js"></script>
	<?php //} ?>
	
	<script src="zscript.js" type="text/javascript"></script>
	

<script type="text/javascript">
jQuery(document).ready(function($){
	$(".selectpicker-county").change(function() {
		 var element = $('option:selected',this);
		 var countyid = element.attr('value');
		 window.location.href = 'county.php?cid='+countyid;
	});
	
	if($("#wrap_mcas").length)
	{
		var liCons = $("li.level2",this).attr('Cons');
		var liCID = $("li.level2",this).attr('cid');
		var liID = $("li.level2",this).attr('id');
		$("#"+liID).addClass('active');
		mcaAJAX(liCID,liCons);

		$("li.level2").click(function(){

		  $("li.level2").removeClass('active');
		  $(this).addClass('active');
		  var cid = $(this).attr('cid');
		  var mcaCons = $(this).attr('Cons');
		  var divto = $(this).attr('divto');
		  mcaAJAX(cid,mcaCons);
		});


		function mcaAJAX(c,d) {
		  $.ajax({
			url: "mca_list.php",
			type: "post",
			async: false, 
			data: { cid : c, cons : d},
			success: function(dat){
			  // alert(dat);
			  $("#mcaData").html(dat);
			},
			error:function(d){
			  alert("failure"+d);
			  $("#mcaData").html('there is error while submit');
			}
		  }); 
		}
	}
	
	
});
</script>	