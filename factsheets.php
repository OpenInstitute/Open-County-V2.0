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
			<?php include("includes/nav_crumbs.php"); ?>

			<div class="container clearfix">
			<div class="col-md-3 padd0_l padd20_t column-sideX" role="complimentary">
			
			<div class="cfs">
			  <div class="cfs-head"><h3>Categories</h3></div>
			  <div class="cfs-bodyX">
				<nav class="bs-docs-sidebar hidden-print hidden-sm hidden-xs affixX">
					<ul id="nav_side" class="nav_side">
						<li class="active"> <a href="#health">Health</a></li>
						<li> <a href="#security">Security</a></li>
						<li> <a href="#finance">Finance</a></li>
						<li> <a href="#agriculture">Agriculture</a></li>
					</ul>
				</nav>
				</div>
			</div>
			</div>
			
			<div class="col-md-9">
				<div class="padd20_t">
				<h3 id="health">Health</h3>
				<table class="table table-bordered table-striped">
						  <thead>
							<tr>
							  <th>Period</th>
							  <th>Indicator</th>
							  <th>Numbers</th>
							  <th>Source</th>
							</tr>
						  </thead>
						  <tbody>
							<tr>
							  <td>2012 - 2013</td>
							  <td>Hospital Equipment Purchase</td>
							  <td>512B</td>
							  <td>MOH</td>
							</tr>
							<tr>
							  <td>2013-2015</td>
							  <td>Doctors and nurses salaries</td>
							  <td>128B</td>
							  <td>WB</td>
							</tr>
							<tr>
							  <td>2013-2016</td>
							  <td>Medicine (HIV)</td>
							  <td>230M</td>
							  <td>KNBS</td>
							</tr>
							<tr>
							  <td>2016 - 2017</td>
							  <td>Makueni Referral Hosp. Construction</td>
							  <td>500M</td>
							  <td>County Gov.t</td>
							</tr>
						  </tbody>
						</table>
				</div>
			</div>
			</div>

		<div class="padd20"></div>
		</section><!-- #content end -->

		<!-- Footer
		============================================= -->
		<?php include 'include/footer.php'; ?>
		<!-- #footer end -->

	</div><!-- #wrapper end -->



<?php include 'zfoot.php'; ?>

	
</body>
</html>