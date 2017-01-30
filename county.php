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

//$cProfile = $dispOc->get_countyProfile($cid);		
$cLeadersArr = $dispOc->get_countyLeaders($cid, 2);  //displayArray($cLeadersArr);	
$cLeaderGov  = current($cLeadersArr['_Gov']);	
$govAvatar = 'images/profiles/'.$cProfile['county'].$cLeaderGov['avatar'];	
$govName	= $cLeaderGov['leader_name'];
$govStart   = date('Y',strtotime($cLeaderGov['date_start']));	
		
$cCards = $dispOc->get_countySectorCards($cid);		
//displayArray($cLeaderGov);		
//displayArray($cProfile);
		
		
?>
	
	
		<section id="content">
			<div class="container clearfix">
			<?php include 'include/county-nav.php'; ?>
			
				
				
			<div class="col_four_fifth norightmargin marg0_b">
				<div class="county-info countyImg clearfix" style="background-image: url(<?php echo $cProfile['banner']; ?>); ">
					<div class="entry-image"></div>
					<div class="links">
					<h3><?php echo $cProfile['county']; ?> County</h3>
		  <!--<a class="devhub" target="blank" href="http://devolutionhub.or.ke/resources/47-counties/<?php //echo $cProfile['county']; ?>">
			<img src="images/devhublogo.png" style="height:120px;margin-bottom: -60px;margin-left: 10px;margin-top: -15px;">
		  </a><br>-->
			
		 <?php if(!empty($cProfile['twitter'])) { ?>
			<span><a href="http://twitter.com/<?php echo $cProfile['twitter']; ?>"><i class="fa fa-twitter"></i> @<?php echo $cProfile['twitter']; ?></a></span><br>  
		 <?php } ?>
		 <?php if(!empty($cProfile['email'])) { ?>
		 	<span><a href="mailto:<?php echo $cProfile['email']; ?>" target="_blank"><i class="fa fa-envelope"></i> <?php echo $cProfile['email']; ?></a></span><br>  
		 <?php } ?>    
		 <?php if(!empty($cProfile['website'])) { ?>
		 	<span><a href="<?php echo $cProfile['website']; ?>" target="_blank"><i class="fa fa-link"></i> <?php echo $cProfile['website']; ?></a></span>
		 <?php } ?>    
		         
                   	</div>
                    
				</div>
			</div>
			<div class="col_one_fifth col_last govImg noleftmargin norightmargin pull-right">
				<a href="<?php echo $govAvatar; ?>" data-lightbox="image"><img class="image_fade" src="<?php echo $govAvatar; ?>" alt="Governor Image" style="opacity: 1;"></a>
				<div class="govDesc">
					<span><strong>Governor:</strong> <?php echo $govName; ?></span><br>
					<span><strong>Governor Since:</strong> <?php echo $govStart; ?></span><br>
					<span><strong>County HQs:</strong> <?php echo $cProfile['capital']; ?></span>
				</div>
			</div>
			
			<div class="clearfix"></div>

			<div class="col_full">
				<div class="padd10"></div>
				<h4>SECTOR INDICATORS</h4>
				<div class="sector-cards columns">         
				<?php //echo implode('', $cCards); ?>         	
				</div>
				<div id="" class="wrap_gallery notransform">
					  <ul class="bxslider bxcarousel columnX ">
					  <?php echo implode('', $cCards); ?>      
					  </ul>
				</div>
			
			
			<div>
				<?php include('includes/inc_budget_indicators_home.php'); ?>
			</div>
			
			
			
			<div>
				<?php include('includes/inc_budget_allocation_pie.php'); ?>
			</div>

			</div>
		</section><!-- #content end -->

		<!-- Footer
		============================================= -->
		<?php include 'include/footer.php'; ?>
		<!-- #footer end -->

	</div><!-- #wrapper end -->


<?php include 'zfoot.php'; ?>

<link rel="stylesheet" href="scripts/js/bxslider/jquery.bxslider.carousel.css" type="text/css" />
<script src="scripts/js/bxslider/jquery.bxslider.min.js"></script>

<script type="text/javascript">

jQuery(document).ready(function($) 
{
	var hash = window.location.hash.substr(1);
	

	$('.bxcarousel').bxSlider({
	  auto: true,pause: 10000,minSlides: 1,maxSlides: 4,slideWidth: 320,slideMargin: 10,moveSlides: 1, pager: false
	});
	
});

</script>

<script type="text/javascript">
    /* Pie chart */    
	
	var hpdta_alloc = <?php echo json_encode($pie_allocJson); ?>;
	var hpdta_expense = <?php echo json_encode($pie_expenseJson); ?>;
	/*var hpdta_drill = <?php //echo json_encode($drillSubs); ?>;*/
	var hpdta_total = <?php echo json_encode($selectPeriodTotal); ?>;
	
	hc_pieChart('chart1','Allocation Breakdown',hpdta_alloc, true);	//, hpdta_drill
	hc_pieChart('chart2','Expenditure Breakdown',hpdta_expense, true);
	hc_pieChart('chart3','Total Allocation Vs. Expenditure',hpdta_total, true);
	
	/* Bar chart */
	var hbcat = <?php echo json_encode($barJson['category']); ?>;
	var hbdta = <?php echo json_encode($barData); ?>;
	//hc_barChart('chart3','County Allocation and Expenditure', hbcat, hbdta);

	
	/* Bar chart Drill */
	var hbdcat = <?php echo json_encode($barJson['category']); ?>;
	var hbddtamain = <?php echo json_encode($drillMain); ?>;
	var hbddtadrill = <?php echo json_encode($drillSubs); ?>;
	//hc_barChartDrill('chart3','County Allocation and Expenditure', hbcat, hbddtamain, hbddtadrill);
</script>


</body>
</html>