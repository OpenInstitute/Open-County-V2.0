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
			
			<div class="col-md-12">
				<div class="padd20_t">
				<h3 id="Comparisons">Comparison</h3>
				
				<!-- main tab -->
				<style type="text/css">
				input.subComp{
				padding: 7px 30px;
				width: 100%;
				}
				</style>
					<div style="width:100%;" class="toppad tabs tabs-bordered clearfix" id="tab-2">
						<ul class="tab-nav clearfix" id="myTab">
							<li id="general_nav"><a data-toggle="tab" data-href="general" href="#general">General Comparison</a></li>
							<li id="county_nav"><a data-toggle="tab" data-href="county" href="#county">County Comparison</a></li>
						</ul>
						<div class="tab-container">
							<div class="tab-content clearfix" id="general">
								<!-- General comparison tab -->
									<?php include 'include/general-comparison.php'; ?>
								<!-- End of general comparison tab -->
							</div>
							<div class="tab-content clearfix" id="county">
								<!-- County comparison tab -->
								<?php include 'include/county-comparison.php'; ?>
								<!-- End of county comparison tab -->

							</div>
						</div>
					</div>
					<!-- End of main tab -->
					
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

<script type="text/javascript">
jQuery(document).ready(function($){
    $('a[data-toggle="tab"]').on('click', function(e) { 
		var selTab = $(e.target).attr('data-href');
        localStorage.setItem('activeTab', selTab);
		$('.tab-content').hide(); 
		$('#' + selTab + '').show().attr('aria-hidden', 'false');
    });
    var activeTab = localStorage.getItem('activeTab'); 
    if(activeTab){
        $('#myTab li').removeClass('ui-tabs-active ui-state-active');
		$('#myTab li#' + activeTab + '_nav').tab('show');
		$('#myTab li#' + activeTab + '_nav').addClass('ui-tabs-active ui-state-active');
		
		$('.tab-content').hide(); 
		$('#' + activeTab + '').show().attr('aria-hidden', 'false');
    }
});
</script>

<script type="text/javascript">
var genCompareTitle  = '<?php echo $compIndiCurr; ?>';
var genCompareCounty = <?php echo json_encode($jsonCompareCounties); ?>;
var genCompareValues = <?php echo json_encode($jsonCompareValues); ?>;

var dualIndicators = <?php echo json_encode($jsonIndiTitles); ?>;
var dualCountyOne = <?php echo json_encode($jsonCountyOne); ?>;
var dualCountyTwo = <?php echo json_encode($jsonCountyTwo); ?>;

jQuery(document).ready(function($){
	
	/*$("#selCountyOne").change(function() {
		var element = $('option:selected',this);
		var com = $(this).attr('data-com');
	 	var cta = element.attr('value');		
	 	var ctb = $(this).attr('ctb');
	 	window.location.href = 'comparison.php?com='+com+'&cta='+cta+'&ctb='+ctb+'';
	});
	
	$("#selCountyTwo").change(function() {
		var element = $('option:selected',this);
		var com = $(this).attr('data-com');
	 	var ctb = element.attr('value');		
	 	var cta = $(this).attr('cta');
	 	window.location.href = 'comparison.php?com='+com+'&cta='+cta+'&ctb='+ctb+'';
	});*/
	
	var categories = dualIndicators;
    
	Highcharts.Axis.prototype.log2lin = function (num) {
        return Math.log(num) / Math.LN2;
    };

    Highcharts.Axis.prototype.lin2log = function (num) {
        return Math.pow(2, num);
    };

	
	
	
	
	Highcharts.chart('compare', {
		chart: {
			type: 'bar'
		},
		title: {
			text: ''
		},
		subtitle: {
			text: ''
		},
		colors: ['#47807B', '#A57C57'],
		xAxis: [{
			categories: categories,
			reversed: true,
			labels: {
				step: 1,
				style: {
                	font: '13px Lato, sans-serif'
            	}
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
				rotation:0,
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

		series: [ <?php echo json_encode($jsonCountyOne); ?> , <?php echo json_encode($jsonCountyTwo); ?> ],
		exporting: { enabled: false },
		credits: { enabled: false },
		legend: {
				verticalAlign: 'top',
				itemStyle: {
                	fontWeight: 'normal',
                 	fontSize: '14px'
              		}
				}
	});
 
	
	//General comparison	
    Highcharts.chart('generalC', {
        chart: {
            type: 'bar'
        },
        title: {
            text: genCompareTitle
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: genCompareCounty,
            title: {
                text: null
            },
            labels: {
            	style: {
                font: '13px Arial, sans-serif'
            		}
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: '',
                align: 'high'
            },
            labels: {
                overflow: 'justify',
                style: {
                	font: '13px Lato, sans-serif'
            		}
            }
        },
        tooltip: {
            valueSuffix: ' '
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'bottom',
            x: 0,
            y: -70,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true,
            itemStyle: {
                fontWeight: 'normal',
                 fontSize: '14px'
              }
        },
        credits: {
            enabled: false
        },
        series: [{
            name: genCompareTitle,
            data: genCompareValues
        }],
        exporting: { enabled: false }
    });
	
	
	

});

	</script>
		
</body>
</html>