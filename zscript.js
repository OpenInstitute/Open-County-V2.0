jQuery.noConflict();
jQuery(document).ready(function ($) {
	var token = Math.random();
	
	/* ============= @@ general ======================== */
	$('a[href^="out.php"], a[href^="http://"], a[href^="https://"], a[href^="mailto:"], a[href^="tel:"], a[href*="lib.php"]').attr({ target: "_blank" });	
	/* ============= @@ forms ======================== */
	
	jQuery.validator.addMethod("notDefault", function(value, element) { return value != element.defaultValue;	}, "Required");
	
	if( $('#feedback').length ) {  
		$("#feedback").validate({errorContainer: ".errorBox" , errorPlacement: function(error, element) { }, rules: { txtCaptcha: {required: true, remote: "apps/captchajx/ajax_process.php"}}, messages: { txtCaptcha: "Correct captcha is required." }});
	}
	doFormsValidate();
	
	
	
});	
function hc_pieChartDrill(cElement, cLabel, cData, cDrillData){  
    jQuery(document).ready(function($) {
		
		 var piechart = new Highcharts.chart(cElement, {
            chart: { 
					plotBackgroundColor: null, 
					plotBorderWidth: null, plotShadow: false, 
					type: 'pie'
					,events: {
						drilldown: function(e) {
							piechart.setTitle({ text: cLabel + ' >> ' + e.point.name });
						},
						drillup: function(e) {
							piechart.setTitle({ text: cLabel });
						}
					}
			},
            title: { text: cLabel },
			colors: ['red', 'orange', 'green', 'blue', 'purple', 'brown', 'black', 'gray', 'maroon', 'orchid', 'burlywood', 'darkblue', 'magenta', 'olivegreen', 'yellow', 'orchid', 'seagreen', 'cyan', 'slategray', 'violet', 'pink'],
            tooltip: { pointFormat: '{series.name}: {point.y}, <br/>Percentage: <b>{point.percentage:.1f}%</b> ' },
            plotOptions: {
                pie: {  allowPointSelect: true, cursor: 'pointer',
                        dataLabels: { enabled: true, format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                            style: { color: (Highcharts.theme &&  Highcharts.theme.contrastTextColor) || 'black' }
                        }
                }
            },
            series: [{
                name: cLabel, colorByPoint: true,
                data: cData 
            }]
			, drilldown: {
				series: cDrillData
			}
            , credits : { enabled : false}
            , exporting : { enabled : false}
        });
    });
}


function hc_pieChart(cElement, cLabel, cData, cLegend = false){  
    jQuery(document).ready(function($) {
		var cDataLabel = (cLegend) ? false : true;
        Highcharts.chart(cElement, {
            chart: { plotBackgroundColor: null, plotBorderWidth: null, plotShadow: false, type: 'pie' },
            title: { text: cLabel },
			colors: ['red', 'orange', 'green', 'blue', 'purple', 'brown', 'black', 'gray', 'maroon', 'orchid', 'burlywood', 'darkblue', 'magenta', 'olivegreen', 'yellow', 'orchid', 'seagreen', 'cyan', 'slategray', 'violet', 'pink'],
            tooltip: { pointFormat: '{series.name}: {point.y}, <br/>Percentage: <b>{point.percentage:.1f}%</b> ' },
			legend: {
                enabled: cLegend,
				useHTML: true,
				labelFormatter: function() {
					return '<span style="color:' + this.color + '">' + this.name + ': ' + this.percentage.toFixed(2) + '%</span><br/>';
				},
                borderWidth: 0,
                itemStyle: {
                fontWeight: 'normal !important',
                 fontSize: '12px'
              }
            },
            plotOptions: {
                pie: {  allowPointSelect: true, cursor: 'pointer', showInLegend: cLegend,
                        dataLabels: { enabled: cDataLabel, format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                            style: { color: (Highcharts.theme &&  Highcharts.theme.contrastTextColor) || 'black' }
                        }
                }
            },
            series: [{
                name: 'Total', colorByPoint: true,
                data: cData 
            }]
            , credits : { enabled : false}
            , exporting : { enabled : false}
        });
    });
}



function hc_barChartDrill(cElement, cLabel, cCategory, cData, cDrillData){  
    jQuery(document).ready(function($) {
		
		var defaultTitle = cLabel;
		var drilldownTitle = "More about ";
		// Create the chart
		var chart = new Highcharts.chart(cElement, {
			chart: {
				type: 'bar'
				, height: 500
				,events: {
					drilldown: function(e) {
						chart.setTitle({ text: defaultTitle + ' >> ' + e.point.name });
					},
					drillup: function(e) {
						chart.setTitle({ text: defaultTitle });
					}
				}
			},
			title: {
				text: cLabel
			},
			subtitle: {
				text: 'Click columns or categories to drill down.'
			},
			colors: ['red', 'orange', 'green', 'blue', 'purple', 'brown', 'black', 'gray', 'maroon', 'orchid', 'burlywood', 'darkblue', 'magenta', 'olivegreen', 'yellow', 'orchid', 'seagreen', 'cyan', 'slategray', 'violet', 'pink'],
			xAxis: {
				type: 'category'
			},

			plotOptions: {
				series: {
					borderWidth: 0,
					dataLabels: {
						enabled: true
					}
				}
			},

			series: cData,
			
			drilldown: {
				drillUpButton: {
                position: {
                    y: -50,
                    x: -80
                	}
            	},
				series: cDrillData
			},
			credits : { enabled : false},
			exporting : { enabled : false},
			// Legend edit
			legend: {
				itemStyle: {
                	fontWeight: 'normal',
                 	fontSize: '14px'
              		}
				}
			
		});
		
	});
}


function hc_barChart(cElement, cLabel, cCategory, cData){  
    jQuery(document).ready(function($) {
		Highcharts.chart(cElement, {
			chart: { type: 'bar' },
			title: { text: cLabel },
			subtitle: { text: '' },
			colors: ['red', 'orange', 'green', 'blue', 'purple', 'brown', 'black', 'gray', 'maroon', 'orchid', 'burlywood', 'darkblue', 'magenta', 'olivegreen', 'yellow', 'orchid', 'seagreen', 'cyan', 'slategray', 'violet', 'pink'],
			xAxis: {
				categories: cCategory,
				title: { text: '' }
			},
			yAxis: {
				min: 0,
				title: { text: 'Amount in KES (millions)', align: 'high' },
				labels: { overflow: 'justify' }
			},
			tooltip: { valueSuffix: ' M' },
			plotOptions: { bar: { dataLabels: { enabled: true } } },
			legend: {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'top',
				x: -40,
				y: 80,
				floating: true,
				borderWidth: 1,
				backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
				shadow: true
			},
			series: cData
			, credits : { enabled : false}
			, exporting : { enabled : false}
		});	
		
	});
}



function doFormsValidate() { 
	jQuery(document).ready(function($) {		
				
		if($('.rwdvalid').length) 
		{   /* Multiselect - require one*/
			$.validator.addMethod("needsSelection", function (value, element) { var count = $(element).find('option:selected').length; return count > 0; });
			
			/* Multicheckbox - require one*/
			$.validator.addMethod("require-one", function (value, element) { return $('.require-one:checked').size() > 0; })
			
			/* WYSIWYG - required */
			$.validator.addMethod("wysi_required", function (value, element) { return $('.wysi-required').val() !== ''; })
			
			$(".rwdvalid").validate({errorContainer: ".errorBox" , errorPlacement: function(error, element) { } });
		}
	});
}
