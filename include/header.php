<header id="header" class="header floating-header Xno-sticky" data-sticky-class="not-dark">
	<div id="header-wrap" style="height:160px !important;">
		<div class="container clearfix">
			<div id="primary-menu-trigger"><i class="icon-reorder"></i></div>
			<!-- Logo
			============================================= -->
			<div id="logo" class="tpad">
				<a href="index.php" class="standard-logo" data-dark-logo="images/opencounty.png"><img src="images/opencounty.png" alt="Open County"></a>
				<a href="index.php" class="retina-logo" data-dark-logo="images/opencounty.png"><img src="images/opencounty.png" alt="Open Conty"></a>
			</div><!-- #logo end -->
			<!-- Primary Navigation
			============================================= -->
			<?php include 'include/menu.php'; ?>
			<!-- #primary-menu end -->

		</div>
		<?php //echobr($this_page); $comMenuType <> '1' and 
		if($this_page <> 'index.php' and $this_page <> 'about.php' and $this_page <> 'factsheets.php' and $this_page <> 'visualizations.php' and $this_page <> 'comparison.php'){
		?>
		<div class="container clearfix">
		<?php include 'include/county-nav.php'; ?>
		</div>
		<?php } ?>
	</div>

</header>
<div class="clearfix"></div>