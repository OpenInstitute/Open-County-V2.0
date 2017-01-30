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
					<div><h3><?php echo $cProfile['county']; ?> County News</h3></div>
					<!-- content
					============================================= -->
					<div>
					<fieldset class="rsslib">
						<?php 
							if ($cid == '') { $news='kenya'; } 
							else { $news = 'county+'.$cProfile['county']; }

					  		$url = "http://news.google.com/news?cf=all&ned=us&hl=en&q=".$news."&output=rss";
							//echobr($url);
							require_once("includes/rss/rsslib.php");
							$cache = RSS_Display($url, 15, false, true);
							//file_put_contents($cachename, $cache);
							echo $cache;
						?>
					</fieldset>
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



<link href="includes/rss/rss-style.css" rel="stylesheet">

<?php include 'zfoot.php'; ?>

	
</body>
</html>