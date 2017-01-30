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
		
		
		<div class="col-md-9">
		
			<div class="clearfix">	
				
				<div>
					<div><h3><?php echo $cProfile['county']; ?> County - Resources</h3></div>
					<!-- content
					============================================= -->
					<div id="jdata">
					<?php include 'includes/nav_county_resources.php'; ?>
					</div>
					<!-- content :: END -->				
				</div>
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

<script language="javascript">

jQuery(document).ready(function($)
{
	/*$.ajax({
				url: 'http://localhost/devhub/_api.php?cid=<?php echo $cid; ?>',
				type: 'GET',
				beforeSend: function() {
					$('#jdata').html('loading....');
				},
				success: function(response) {
					$('#jdata').html(response);
				}            
			});*/
});
</script>
	
</body>
</html>