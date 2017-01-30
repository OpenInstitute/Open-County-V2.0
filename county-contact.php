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
	<section id="content">
		<div class="container clearfix">
		<?php include 'include/county-nav.php'; ?>



		<div class="clearfix"></div>
		
		<!-- county-side-nav
		============================================= -->
		<?php include 'includes/nav_county_side.php'; ?>
		<!-- county-side-nav :: END -->
		
		
		<div class="col-md-10">
		
			<div class="clearfix">
				
				
				<div class="col-md-7">
					<div><h3><?php echo $cProfile['county']; ?> County Contacts</h3></div>
					<p>
		<?php if(!empty($cProfile['website'])) { ?><i class="fa fa-link"></i> <a href="<?php echo $cProfile['website']; ?>"><?php echo $cProfile['website']; ?></a><br /><?php } ?>
		<?php if(!empty($cProfile['email'])) { ?><i class="icon-envelope2"></i> <a href="mailto:<?php echo $cProfile['email']; ?>"><?php echo $cProfile['email']; ?></a><br /><?php } ?>
		<?php if(!empty($cProfile['twitter'])) { ?><i class="fa fa-twitter"></i> <a href="<?php echo $cProfile['twitter']; ?>">@<?php echo $cProfile['twitter']; ?></a><br /><?php } ?>
		<?php if(!empty($cProfile['telephone'])) { ?><i class="fa fa-phone"></i> <?php echo $cProfile['telephone']; ?><br /><?php } ?>
		<?php if(!empty($cProfile['postaladdress'])) { ?><i class="fa fa-envelope-square"></i>  <?php echo $cProfile['postaladdress']; ?><br /><?php } ?>
	  </p>
				</div>
				
				<div class="col-md-5"><?php include('includes/form.feedback.php'); ?></div>
				
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

	<!-- Go To Top


<?php include 'zfoot.php'; ?>

	
</body>
</html>