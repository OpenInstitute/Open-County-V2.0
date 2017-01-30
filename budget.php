<?php include 'zhead.php'; ?>

	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper" class="clearfix">

		<!-- Header
		============================================= -->
		<?php include 'include/header.php'; ?>
		<!-- #header end -->
		
		
		
		<!-- Content
		============================================= -->
<?php 
$cPeriodCurr = 	$cperiod;	
$cPeriods = $dispOc->get_countyBudgetPeriod($cid, $cperiod);			
if($cperiod == '') {	
	$cPeriodCurr = $cPeriods['curr']; 
}
		
$cPeriodData = $dispOc->get_countyBudgetHome($cid, $cPeriodCurr, $cdept); displayArray($cPeriodData); 

$cDrillData = $dispOc->get_countyBudgetHomeDrill($cid, $cPeriodCurr); 	//displayArray($cDrillData); 
		
		
$pie_allocJson = $cPeriodData['pie_alloc'];	
$pie_expenseJson = $cPeriodData['pie_expense'];	
		
		
$barJson = $cPeriodData['bar'];		
$barAllocated = array('name'=>'Allocated', 'data'=>$barJson['allocated']);	
$barExpensed = array('name'=>'Expensed', 'data'=>$barJson['expensed']);		

$barData[] = array('name'=>'Allocated', 'data'=>$barJson['allocated']);	
$barData[] = array('name'=>'Expensed', 'data'=>$barJson['expensed']);	

		
$drillJson = $cPeriodData['drill'];	
		 //echobr(json_encode($barJson['category']));
		//echobr(json_encode($barData));
		/* echobr(json_encode($barAllocated));
		echobr(json_encode($barExpensed));*/
		
	//	echobr(json_encode($cDrillData));
		
		$drillMain = array();
		$drillSubs = array();
		
		foreach($drillJson as $k => $v){
			$drillMain[] = array('name'=>$k, 'data'=>$v);
		}
		//echobr(json_encode($drillMain));
		foreach($cDrillData as $k => $v){
			$drillSubs[] = array('id'=>$k, 'data'=>$v);
		}
		
		displayArray($drillMain); 
		//echobr(json_encode($drillSubs));

$cDeptCrumb = ($cdept <> '') ? ' <li> <a href="budget.php?com='.$com.'&cid='.$cid.'&cperiod='.$cPeriodCurr.'&cdept=" class="txt17">'.$cdept.'</a></li><li class="txt17">Projects</li>' : '';			
$cDeptLabel = ($cdept <> '') ? ' >> '.$cdept : '';		
?>
	
	
		<section id="content">
			<div class="container clearfix">
			<?php include 'include/county-nav.php'; ?>
			
				
			
			<div class="clearfix"></div>

			
				<!--<h4>BUDGET INDICATORS</h4>	-->			
			<div class="col_full">
				<div class="col-md-3 padd0_l nopadd">
					<div class="cfs">
					<div class="cfs-head "><h3 class="txtwhite">Departments</h3></div>
					<div class="cfs-body">
					<div class="clearfix">
					<span class="col-md-6 nopadd">Select Period</span>
					<select id="selectDeptpicker" class="col-md-6 nopadd" data-com="<?php echo $com_active; ?>" data-cid="<?php echo $cid; ?>" data-dept="<?php echo $cdept; ?>">
					<?php echo implode('', $cPeriods['ops']); ?>
					</select>
					</div>
					<div class="clearfix padd5"></div>
					<div>
					<ul id="left_nav" class="navX nav-pillsX nav_side">
					<?php 
					foreach($cPeriodData['pie_alloc'] as $cData){

					$deptname = $cData['name'];
					$deptref  = ' href="budget.php?com='.$com.'&cid='.$cid.'&cperiod='.$cPeriodCurr.'&cdept='.$deptname.'" ';

					if($cdept <> '') { $deptref = ''; }
					echo '<li class="padd5_0"><a '.$deptref.'>'.ucwords($deptname).'</a></li>'; // - '.niceNumber($cData['y']).'
					}
					?>
					</ul>
					</div>

					</div>
					</div>
				</div>
				
				<div class="col-md-9" style="border-left:1px solid #ddd;border-right:1px solid #ddd;">
				
					<div class="section-toggle row">
					  <div class="col-md-8">
						<ol class="breadcrumb">
						  <li><h3 class="section-title padd10_l">Allocations and Expenditures</h3></li><?php echo $cDeptCrumb; ?>
						  <!--<li>Departments</li>--> 
						  <!-- TO DO: activate this as a link for the department view as well -->   
						</ol>
					  </div>
					  
<div class="col-md-4 toggle-menu">
<div class="toggles txtright">
  <div class="btn-group">
	<button type="button" class="btn btn-default active pt-pie" cid="<?php echo $cid; ?>" did="0" dept="" mwaka="<?php echo $cPeriodCurr; ?>">
	  <i class="fa fa-pie-chart"></i>
	</button>

	<button type="button" class="btn btn-default pt-bars" cid="3" cid="<?php echo $cid; ?>" did="0" dept="" qt="" mwaka="<?php echo $cPeriodCurr; ?>">
	  <i class="icon-bars"></i>
	</button>

	<button type="button" class="btn btn-default pt-dataTable" cid="<?php echo $cid; ?>" did="0" dept="" qt="" mwaka="<?php echo $cPeriodCurr; ?>">
	  <i class="icon-table"></i>
	</button>
<!--
	<button type="button" class="btn btn-default atAglance" cid="3" did="0">
	  <i class="icon-info"></i>
	</button>
-->
  </div>
</div><!-- /.toggles -->
</div><!-- /.toggle-menu -->
				  </div>
					
				<div class="row">
					
					<div id="chart3" style="width:100%; max-width:1100px; display:none"></div>	
					
					<div id="chart1" style="height:auto"></div>		
					<div id="chart1_spacer" class="padd20"></div>
					<div id="chart2" style="height:auto"></div>		

							

					<div id="chart4" style="display:none">
						
						<div class="padd20_l padd20_r">
						<h4>Data For period <?php echo $cPeriodCurr; ?></h4>
						<table class="table table-hover">
							<thead>
								<tr>
									<th></th>
									<th class="txtright">Allocation</th>
									<th class="txtright">Expense</th>
								</tr>
							</thead>
							<tbody>
							<?php 
								foreach($cPeriodData['pie_alloc'] as $drek => $darr) { 
									$dname = $darr['name'];
									$dalloc = intval($darr['y']);
									$dexpen = intval($cPeriodData['pie_expense'][$drek]['y']);
							?>
								<tr>
									<td><?php echo $dname; ?></td>
									<td class="txtright"><?php echo displayFloat($dalloc); ?></td>
									<td class="txtright"><?php echo displayFloat($dexpen); ?></td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
						</div>
						
					</div>	

					<div id="chart5"></div>	
				</div>
					
																																													
				</div>
				
			</div>
			
			


		</section><!-- #content end -->

		<!-- Footer
		============================================= -->
		<?php include 'include/footer.php'; ?>
		<!-- #footer end -->

	</div><!-- #wrapper end -->


<?php include 'zfoot.php'; ?>



<script type="text/javascript">
    /* Pie chart */    
	var hpdta_alloc = <?php echo json_encode($pie_allocJson); ?>;
	var hpdta_expense = <?php echo json_encode($pie_expenseJson); ?>;
	var hpdta_drill = <?php echo json_encode($drillSubs); ?>;
	hc_pieChartDrill('chart1','Budget Allocation <?php echo $cDeptLabel; ?>',hpdta_alloc, hpdta_drill);
	hc_pieChartDrill('chart2','Budget Expenditure <?php echo $cDeptLabel; ?>',hpdta_expense, hpdta_drill);
	
	
	/* Bar chart */
	var hbcat = <?php echo json_encode($barJson['category']); ?>;
	var hbdta = <?php echo json_encode($barData); ?>;
	//hc_barChart('chart3','County Allocation and Expenditure', hbcat, hbdta);

	
	/* Bar chart Drill */
	var hbdcat = <?php echo json_encode($barJson['category']); ?>;
	var hbddtamain = <?php echo json_encode($drillMain); ?>;
	var hbddtadrill = <?php echo json_encode($drillSubs); ?>;
	hc_barChartDrill('chart3','Allocation vs. Expenditure  <?php echo $cDeptLabel; ?>', hbcat, hbddtamain, hbddtadrill);
	
	
//$(function () {
jQuery(document).ready(function ($) {	

	
});	
	

	
	
	
	
	
jQuery(document).ready(function ($) {

	$("#selectDeptpicker").change(function() {
		 
		var element = $('option:selected',this);
		 var cperiod = element.attr('value');
        // var cperiod = $('option:selected').val();	//,this
         var cid = $(this).attr('data-cid');
         var com = $(this).attr('data-com');
         var cdept = $(this).attr('data-dept');
		//alert(cperiod+' '+cid+' '+com+' '+cdept+'');
         window.location.href = 'budget.php?com='+com+'&cid='+cid+'&cperiod='+cperiod+'&cdept='+cdept;
       });
	
    $("button").click(function(){
      
      $("button").removeClass("active");

      if ($(this).hasClass('pt-pie')){
        $(this).addClass("active");
        $("#chart1").show("slow");
        $("#chart2").show("slow");
		$("#chart3").hide("slow");
		$("#chart4").hide("slow");  
        //$("#glance").hide("slow");
        //$("#dataTable").hide("slow");
        //$(".section-title").html('Allocation');
      }

      if ($(this).hasClass('pt-bars')){
        $(this).addClass("active");
        $("#chart1").hide("slow");
        $("#chart2").hide("slow");
		$("#chart3").show("slow");
		$("#chart4").hide("slow");  
        //$("#glance").hide("slow");
        //$("#dataTable").hide("slow");
        
          var cid = $(this).attr('cid');
          var did = $(this).attr('did');
          var dept = $(this).attr('dept');
          var qt = $(this).attr('QT');
          var mw = $(this).attr('mwaka');
          /*if (dept=="") {
			  $(".section-title").html('Performance');
		  } else {
			  $(".section-title a").html('Performance');
		  }*/
          
          //performanceAJAX(cid,did,dept,qt,mw);
          //$('.progress .progress-bar').progressbar({transition_delay: 2000});
         
      }
  	
	if ($(this).hasClass('pt-dataTable')){
        $(this).addClass("active");
        $("#chart1").hide("slow");
        $("#chart2").hide("slow");
		$("#chart3").hide("slow");
		$("#chart4").show("slow");  
        
          var cid = $(this).attr('cid');
          var did = $(this).attr('did');
          var dept = $(this).attr('dept');
          var qt = $(this).attr('QT');
          var mw = $(this).attr('mwaka');
          /*if (dept=="") {
			  $(".section-title").html('Data Table');
		  } else {
			  $(".section-title a").html('Data Table');
		  }
          tableAJAX(cid,did,dept,qt,mw);*/
      }
		
    if ($(this).hasClass('atAglance')){
        $(this).addClass("active");
        $("#pie").hide("slow");
        $("#bars").hide("slow");
        $("#glance").show("slow");
        $("#dataTable").hide("slow");
        
          var cid = $(this).attr('cid');
          var did = $(this).attr('did');
          var dept = $(this).attr('dept');
          var qt = $(this).attr('QT');
          var mw = $(this).attr('mwaka');
          overviewAJAX(cid,did,dept,qt,mw);
        $(".section-title").html('Information');
      }
      
      
      //window.location.href='performance.php?cid=' + cid +'&did=' + did;
    
    });
        
});	

</script>	

</body>
</html>