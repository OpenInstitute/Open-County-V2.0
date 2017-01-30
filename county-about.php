<?php include 'zhead.php'; ?>


<!-- Document Wrapper
============================================= -->
<div id="wrapper" class="clearfix">

	<!-- Header
	============================================= -->
	<?php include 'include/header.php'; ?>
	
	<style type="text/css">
		/*.nano{
			position : relative;
  			width    : 95%;
  			margin: auto;
  			overflow : hidden;
			height:350px;
			z-index: 2;
		}
		.nano .cfs-head{
			width    : 100%;
			position:absolute;
			z-index: 1;
		}
		.nano .nano-content{
		 	position      : absolute;
  		 	overflow-y     : scroll;
  		 	top           : 35px;
  		 	right         : 0;
  		 	bottom        : 0;
  		 	left          : 0;
  		 	z-index: -1;
		}
		.nano .content::-webkit-scrollbar {
  			visibility: visible;
		}
		.has-scrollbar .content::-webkit-scrollbar {
  			visibility: visible;
		}*/
	</style>
	<!-- #header end -->
	<!-- Content
	============================================= -->
	<section id="content">
		<div class="container clearfix">
		<?php include 'include/county-nav.php'; ?>



		<div class="clearfix"></div>
		
		<!-- county-side-nav
		============================================= -->
		<?php include 'includes/nav_county_side.php'; ?>
		<!-- county-side-nav :: END -->
		
		
		<div class="col-md-9 txtjustify">
		
			<div class="clearfix">
				<div><h3>About <?php echo $cProfile['county']; ?> County</h3></div>
				
				<div class="col-md-3">
					<a href="<?php echo $cProfile['map']; ?>" data-lightbox="image"><img class="image_fade" src="<?php echo $cProfile['map']; ?>" alt="County Map" style="opacity: 1;"></a>
				</div>


				<div class="col-md-9">
					<?php 
						echo '<h4>General Information</h4>';
						echo $cProfile['blurb'];
						echo '<div class="padd10"></div>';
						echo '<h4>Constituencies</h4>';
						echo $cProfile['constituencies'];
					?>
					<div class="padd10"></div>
				</div>
			</div>

			<div class="clearfix">
				<div class="padd10"></div> 
				<div><h3><?php echo $cProfile['county']; ?> County Stats</h3></div>
				
				<div class="col-md-4 nopadd">
					<div class="cfs">
					  <div class="cfs-head">Economy</div>
					  <div class="nano">
						  <div class="nano-content">
						  	<div class="cfs-body"><?php echo formatter($cProfile['economy']); ?></div>
						  </div>	
					  </div>
					  
					</div>
				</div>
				
				<div class="col-md-4 nopadd">
					<div class="cfs">
					  <div class="cfs-head">Health</div>
					  <div class="nano">
						  <div class="nano-content">
						  	<div class="cfs-body"><?php echo formatter($cProfile['health']); ?></div>
						  </div>	
					  </div>
					</div>
				</div>
				
				<div class="col-md-4 nopadd">
					<div class="cfs">
					  <div class="cfs-head">Education</div>
					  <div class="nano">
						  <div class="nano-content">
						  	<div class="cfs-body"><?php echo formatter($cProfile['education']); ?></div>
						  </div>	
					  </div>
					</div>
				</div>
				
				<!--<div class="col-md-3 nopadd">
					<div class="cfs">
					  <div class="cfs-head">County Facts</div>
					  <div class="cfs-body"><?php echo $cProfile['economy']; ?></div>
					</div>
				</div>-->
			
					
			</div>
				
			<div class="clearfix"><div class="padd10"></div> </div>

		</div>



		</div>
	</section><!-- #content end -->

	<!-- Footer
	============================================= -->
	<?php include 'include/footer.php'; ?>
	<!-- #footer end -->

</div><!-- #wrapper end -->

	<!-- Go To Top -->


<?php include 'zfoot.php'; ?>
<link rel="stylesheet" type="text/css" href="scripts/js/nanoscroll/jquery.nanoscroller.css">
	<script type="text/javascript" src="scripts/js/nanoscroll/jquery.nanoscroller.min.js"></script>
<script>
jQuery(document).ready(function($){
	$(".nano").nanoScroller();
});
</script>	
</body>
</html>