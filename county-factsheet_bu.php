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
		
			<div class="container clearfix">
			<div class="col-md-8">
			<?php
					$fsCards = $dispOc->get_factsheetSectorCards($cid);	
					//displayArray($cProfile);
					$fsrow = array();
				
				
					/*foreach($fsCards as $fsCat)
					{
						$fsDataArr = $fsCat['data'];
						$fsrow[] = '<tr><th>'.$fsCat['sector_name'].'</th><th></th></tr>';
						foreach($fsDataArr as $fsData){
							$fsrow[] = '<tr><td>'.$fsData['indicator'].' ('.$fsData['period'].')</td><td>'.$fsData['value'].'</td></tr>';
						}
					}
					echo '<table class="table">';
					echo '<tr><th>INDICATOR</th><th>VALUE</th></tr>';
					echo implode('', $fsrow);
					echo '</table>';*/
				
				
					foreach($fsCards as $fsCat)
					{
						$fsDataArr = $fsCat['data'];
						$fsDataRow = '';
						$secWrap = '<li><div class="block"><h4>'.$fsCat['sector_name'].'</h4>';
						foreach($fsDataArr as $fsData){
							$secWrap .= '<div class="col-md-12 nopadd border_bottom_grayX">
								<div class="col-md-9 padd0_l">'.$fsData['indicator'].' ('.$fsData['period'].')</div>
								<div class="col-md-3 nopadd txtcenter">'.$fsData['value'].'</div>
								</div>';
						}
						$secWrap .= '</div></li>';
						$fsrow[]  = $secWrap;
					}

					echo '<ul class="column menu-column">'.implode('', $fsrow).'</ul>';

			?>
			</div>
			
			<div class="col-md-4">
				<img class="image_fade" src="<?php echo $cProfile['map']; ?>" alt="County Map" style="opacity: 1;">
			</div>
			</div>
		
		
		
		
		
		
		
		
		
		
		
		
		
		
			<div class="container clearfix">
			<div class="col-md-2 padd0_l  column-sideX" role="complimentary">
			
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
			
			<div class="col-md-10">
				<div class="">
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

			</div>
		</section><!-- #content end -->

		<!-- Footer
		============================================= -->
		<?php include 'include/footer.php'; ?>
		<!-- #footer end -->

	</div><!-- #wrapper end -->




<?php include 'zfoot.php'; ?>

	
</body>
</html>