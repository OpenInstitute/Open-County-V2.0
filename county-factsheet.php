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
		
			<div class="container clearfix" style="border:2px solid #ddd; padding:20px;">
			<div class="col-md-12 txtcenter marg5_b"><h2><span class="border_bottom_gray padd5"><?php echo strtoupper($cProfile['county']).' COUNTY'; ?></span></h2></div>
			<style type="text/css">
				.cal-strip div.col-md-1 {width:7.66% !important; padding: 0 !important; height: 10px; background: #ddd;border-left: 1px solid #fff; } .cal-strip div.current { background: #FF7599; }
			</style>
					
			<div class="col-md-12 nopadd cal-strip marg15_b">
				<?php 
				$cal_m = intval(date('m'))-1; for ($c=0; $c<=12; $c++){ $cal_curr = ($cal_m == $c)? ' current' : ''; 
				echo '<div class="col-md-1'.$cal_curr.'"></div>'; } ?>
			</div>
			
			
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

					echo '<div class="padd5"><h4><span>GENERAL INDICATORS</span></h4></div>';
					echo '<ul class="column menu-column">'.implode('', $fsrow).'</ul>';
					echo '<div class="clearfix padd20"></div>';
				
$cPeriodCurr = 	$cperiod;	
$cPeriods = $dispOc->get_countyBudgetPeriod($cid, $cperiod);			
if($cperiod == '') { $cPeriodCurr = $cPeriods['curr']; }
		
$fsBudgetData = $dispOc->get_factsheetBudget($cid, $cPeriodCurr); 
				//$fsBudgetData
//displayArray($fsBudgetData);				
				
					foreach($fsBudgetData as $fsBarr)
					{
						$allocated = displayFloat($fsBarr['allocated']);
						$expensed = displayFloat($fsBarr['expensed']);
						$fsb_row[] = '<tr><td>'.$fsBarr['category'].'</td><td class="txtright">'.$allocated.'</td><td class="txtright">'.$expensed.'</td></tr>';
					}
				
					echo '<div class="padd5"><h4><span>BUDGET INDICATORS</span></h4></div>';
					echo '<table class="table table-borderedX">';
					echo '<tr><th>BUDGET DATA ('.$cPeriodCurr.')</th><th class="txtright">ALLOCATION</th><th class="txtright">EXPENDITURE</th></tr>';
					echo implode('', $fsb_row);
					echo '</table>';

$compIndicatorList = $dispOc->get_comparisonIndicator($com_active, @$ind);	
$jsonIndiTitles	  = $compIndicatorList['indi_title'];					//displayArray($jsonIndiTitles);	
				
$dualCountyTwo = $dispOc->get_comparisonCountyData($cid);	//displayArray($dualCountyTwo);	

$bData = array();				
foreach($jsonIndiTitles as $tkey => $tname){
	$sData = array($tkey, $dualCountyTwo['data'][$tkey]);
	$bData[] = array( 'name'=> $tname, 'y'=> $dualCountyTwo['data'][$tkey]);
}				
	//displayArray($bData);
				//echobr(json_encode($bData));
				
				
				
$jsonCountyTwo = array('colorByPoint'=> 'true', 'name'=> $dualCountyTwo['county'].' County', 'data'=>$dualCountyTwo['data'], 'showInLegend' => 'true');				
			?>
			</div>
			
			<div class="col-md-4">
				<div class="txtcenter">
					<img class="image_fade" src="<?php echo $cProfile['map']; ?>" alt="County Map" style="opacity: 1; max-height:350px;">
				</div>
				
				<div class="padd10">&nbsp;</div>
				<div>
					<div class="padd5"><h4><span>STATISTICS</span></h4></div>
					<div id="compare" style=""></div>
				</div>
			</div>
			
			<div class="col-md-12 txtcenter padd20"><a class="btn btn-primary" onclick="javascript:window.print();">Print Factsheet</a></div>
			
			</div>
		
		
		
		
		
		
		
		
		
		
		
		
		
			</div>
		</section><!-- #content end -->

		<!-- Footer
		============================================= -->
		<?php include 'include/footer.php'; ?>
		<!-- #footer end -->

	</div><!-- #wrapper end -->




<?php include 'zfoot.php'; ?>
<style type="text/css">
g.highcharts-axis-labels.highcharts-xaxis-labels { height: 250px !important!}
</style>
<script type="text/javascript">
var dualIndicators = <?php echo json_encode($jsonIndiTitles); ?>;
var dualCountyTwo = <?php echo json_encode($jsonCountyTwo); ?>;

var chart;
jQuery(document).ready(function($){
	
	var categories = dualIndicators;
    
	Highcharts.Axis.prototype.log2lin = function (num) {
        return Math.log(num) / Math.LN2;
    };

    Highcharts.Axis.prototype.lin2log = function (num) {
        return Math.pow(2, num);
    };

	
	
	/*$('#compare').highcharts({
        chart       : { type    : 'column' },
        title       : { text: ''},
        subtitle    : { },
        legend      : { enabled : true },
        tooltip     : {
        	shared 		: false,
            crosshairs	: true
        },
        plotOptions : {
            series  	: {
            	grouping: false
                //pointRange: 0.2
            },
			column: {  allowPointSelect: true, cursor: 'pointer', showInLegend: true,  dataLabels: { enabled: false }},
			columnrange: {
                        grouping: false,
                        minPointLength: 1,
                        borderWidth: 0
                    }
        },
        xAxis      : { 
			type: 'category',
        	categories: categories,
			labels: {
				rotation:-90,
				style: {
                	font: '13px Lato, sans-serif'
            	}
			}
        },
        yAxis      : {  },
        series: [{
            colorByPoint: true,
            data:<?php //echo json_encode($bData); ?>, showInLegend: true }],
		exporting: { enabled: false },
		credits: { enabled: false },
		legend: { enabled: false }
    });	
    chart = $('#compare').highcharts();*/

	
	
	
	Highcharts.chart('compare', {
		chart: {type: 'column'},
		title: {text: ''},
		subtitle: {text: ''},
		xAxis: [{
			categories: categories,
			reversed: false,
			labels: {
				enabled: true,
				rotation: -90,
			},
			tickPositioner: function() {
				var result = [];
				for(i = 0; i < categories.length; i++)
				result.push(i);
				return result;
			}
		}, { // mirror axis on right side
			opposite: true,
			reversed: false,
			categories: '',
			labels: {
				step: 1
			}
		}],
		yAxis: {
			title: {
				text: null
			},
			labels: {
				rotation:-90,
				enabled: false,
				formatter: function () {
					return Math.abs(this.value);
				},
				style: {
                	font: '13px Lato, sans-serif'
            	}
			}
		},

		plotOptions: {
			series: {
				stacking: 'normal',
				dataLabels: { enabled: true 
							, formatter: function () {
									var vv = (Math.abs(this.point.y) < 0) ? (Math.abs(this.point.y) * -1) : Math.abs(this.point.y);
									return '' + Highcharts.numberFormat(Math.abs(Math.pow(10, vv)),2);
								}
							}
			}
		},

		tooltip: {
			formatter: function () {
				var vv = (Math.abs(this.point.y) < 0) ? (Math.abs(this.point.y) * -1) : Math.abs(this.point.y);
				return '<b>' + this.series.name +', ' + this.point.category + '</b><br/>' +
					'Value: ' + Highcharts.numberFormat(Math.pow(10, vv),2);
			}
		},

		series: [ <?php echo json_encode($jsonCountyTwo); ?>],
		exporting: { enabled: false },
		credits: { enabled: false },
		legend: { enabled: true }
	});
 
	

});
</script>
	
</body>
</html>