<div class="col_full">
	<h4><a href="#"><i class="icon-bar-chart"></i></a> &nbsp; COUNTY COMPARISON</h4>

<?php
function negate($num){
	$val = -1 * abs($num);
	return $val;
}	
	
$dualCountyOne = $dispOc->get_comparisonCountyData($cta);	//displayArray($dualCountyOne);	
$dualCountyOneB = array_map("negate", $dualCountyOne['data']);	//displayArray($jsonCountyOne);	
$jsonCountyOne = array('name'=> $dualCountyOne['county'].' County', 'data'=>$dualCountyOneB);	
	
$dualCountyTwo = $dispOc->get_comparisonCountyData($ctb);	//displayArray($dualCountyTwo);	
$jsonCountyTwo = array('name'=> $dualCountyTwo['county'].' County', 'data'=>$dualCountyTwo['data']);		

	//$rrage = -344; //log10(100000);
	//echobr($rrage*-1);	
	/*<script> var v = 100000; var x = Math.log(v)/Math.log(10)  alert(x); var y = Math.pow(10, x); alert(y); </script>*/
?>
	
		<div class="col_one_thirdX col-md-3">
			
				<div>
					<form method="get" action="comparison.php">
						<input type="hidden" name="com" value="<?php echo $com_active; ?>">
						<p class="col-md-12">Compare two counties by selecting dropdown list</p>
						<select name="cta" id="selCountyOne" class="wd selectpicker col-md-12" data-com="<?php echo $com_active; ?>" cta="<?php echo $cta; ?>"  ctb="<?php echo $ctb; ?>">
							<?php echo $ddSelect->dropperCounties($cta); ?>
						</select><br/><br/>
						
					
						<select name="ctb" id="selCountyTwo" class="wd selectpicker col-md-12" data-com="<?php echo $com_active; ?>"  cta="<?php echo $cta; ?>"  ctb="<?php echo $ctb; ?>">
							<?php echo $ddSelect->dropperCounties($ctb); ?>
						</select><br/><br/>
						<div class="col-md-12">
							<input type="submit" class="subComp btn btn-success btn-md" name="submitCompare" value="Compare">
						</div>
						
						<div class="line"></div>
					</form>
				</div>

		
	</div>

	<div class="col_two_thirdX col-md-9 col_lastX pull-right">
		<div class="subcolumns clearfix">
		<center><h5>Comparison: <?php echo $dualCountyOne['county']; ?> County vs <?php echo $dualCountyTwo['county']; ?> County</h5></center>
		<div id="compare" class="col-md-12" style="width: 1000px ; height: 1000px; margin: 0 auto"></div>
		</div>
	</div>

	<div class="clear"></div>
</div>