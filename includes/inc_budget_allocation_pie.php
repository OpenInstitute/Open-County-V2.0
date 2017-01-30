<?php
//$cPeriods = $dispOc->get_countyBudgetPeriod($cid);	
//$cPeriodCurr = $cPeriods['curr'];

$cPeriodData = $dispOc->get_countyBudgetHome($cid, $selectPeriod); 
$pie_allocJson = $cPeriodData['pie_alloc'];	
$pie_expenseJson = $cPeriodData['pie_expense'];	
$barJson = $cPeriodData['bar'];	
$drillJson = $cPeriodData['drill'];	

$cDrillData = $dispOc->get_countyBudgetHomeDrill($cid, $selectPeriod);


$drillMain = array();
$drillSubs = array();

foreach($drillJson as $k => $v){
	$drillMain[] = array('name'=>$k, 'data'=>$v);
}
//echobr(json_encode($drillMain));
foreach($cDrillData as $k => $v){
	$drillSubs[] = array('id'=>$k, 'data'=>$v);
}


$selectPeriodTotal  = $dispOc->get_countyBudgetPeriodTotal($cid, $selectPeriod);
//displayArray($selectPeriodTotal);
?>

<div class="col_full">
<div class="padd20"></div>
	<h4>BUDGET SUMMARY - <span class="txtred txt21"><?php echo $selectPeriod; ?></span></h4>

	<div class="subcolumns clearfix">
		
		<div class="col-md-4" id="chart3"></div>
		<div class="col-md-4" id="chart1"></div>
		<div class="col-md-4" id="chart2"></div>
		
		
	</div>
</div>


