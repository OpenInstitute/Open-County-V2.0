	<div class="col_full">
			<h4><a href="#"><i class="icon-bar-chart"></i></a> &nbsp; COUNTY COMPARISON</h4>
		</div>
	<div class="col_one_third">
			<h5>Indicators</h5>
<?php
$compIndicators = $dispOc->get_comparisonIndicator($com_active, $ind);	
$compIndicatorsData = $dispOc->get_comparisonIndicatorData($ind);	displayArray($compIndicatorsData);		
?>
				<table class="table table-bordered table-hover">
				  <tbody class="legends">
				    
				    <?php
					  echo implode('', $compIndicators);
					  ?>
				    <!-- <tr>
				      <td class="active level2 legend a" fld="Population2009"><i class="pointer"></i>Population (2009) </td>
				    </tr>
				    
				    <tr>
				      <td class="level2 legend b" fld="Population1999"><i class="pointer"></i>Population (1999) </td>
				    </tr>
				    
				    <tr>
				      <td class="level2 legend c" fld="APopGrowthRate19992009"><i class="pointer"></i>Annual population growth rate, 1999-2009(%) </td>
				    </tr>
				    
				    <tr>
				      <td class="level2 legend d" fld="SurAreaSqKm)"><i class="pointer"></i>Surface area (sq Km) </td>
				    </tr>
				    
				    <tr>
				      <td class="level2 legend e" fld="PopDen2009"><i class="pointer"></i>Population Density 2009 (people per sq Km) </td>
				    </tr>
				    
				    <tr>
				      <td class="level2 legend f" fld="PovertyGap200506"><i class="pointer"></i>Poverty gap, based on KIHBS (2005/06) </td>
				    </tr>
				    
				    <tr>
				      <td class="level2 legend g" fld="ShareUrbanPop2009"><i class="pointer"></i>Share of urban population, 2009 (%) </td>
				    </tr>
				    
				    <tr>
				      <td class="level2 legend h" fld="ImmPopLess1yr201213"><i class="pointer"></i>Fully immunized pop <1yr (%, 2012/13) </td>
				    </tr>
				    
				    <tr>
				      <td class="level2 legend j" fld="MalariaBurden2012"><i class="pointer"></i>Malaria burden (%, 2012) </td>
				    </tr>
				    
				    <tr>
				      <td class="level2 legend k" fld="TB100000Pple2012"><i class="pointer"></i>TB cases in every 100,000 people (2012) </td>
				    </tr>
				    
				    <tr>
				      <td class="level2 legend l" fld="HIVPrevalence2011"><i class="pointer"></i>HIV Prevalence in 2011 (%) </td>
				    </tr>
				    
				    <tr>
				      <td class="level2 legend m" fld="PplelivingHIV2011"><i class="pointer"></i>People living with HIV (2011) </td>
				    </tr>
				    
				    <tr>
				      <td class="level2 legend n" fld="NewHIVInfections2011"><i class="pointer"></i>New HIV infections (2011) </td>
				    </tr>
				    
				    <tr>
				      <td class="level2 legend o" fld="PopPriEdu"><i class="pointer"></i>Population with primary education (%) </td>
				    </tr>
				    
				    <tr>
				      <td class="level2 legend p" fld="PopSecEdu"><i class="pointer"></i>Population with secondary education (%) </td>
				    </tr>
				    
				    <tr>
				      <td class="level2 legend q" fld="CDF"><i class="pointer"></i>Constituency Development Fund (CDF) </td>
				    </tr>
				    
				    <tr>
				      <td class="level2 legend r" fld="LATF"><i class="pointer"></i>Local Authority Transfer Fund (LATF) </td>
				    </tr>
				    
				    <tr>
				      <td class="level2 legend s" fld="SingleBusPermitRevLAs"><i class="pointer"></i>Single business permit revenues by LAs </td>
				    </tr>
				    
				    <tr>
				      <td class="level2 legend t" fld="PropertyTaxRevLAs"><i class="pointer"></i>Property tax revenues by LAs </td>
				    </tr>
				    
				    <tr>
				      <td class="level2 legend u" fld="RuralElecProgFund"><i class="pointer"></i>Rural Electrification Programme Fund </td>
				    </tr>
				    
				    <tr>
				      <td class="level2 legend v" fld="ImprovedWaterHH2009"><i class="pointer"></i>Improved water (% households 2009) </td>
				    </tr>
				    
				    <tr>
				      <td class="level2 legend w" fld="ImprovedSanitationHH2009"><i class="pointer"></i>Improved sanitation (% households 2009) </td>
				    </tr>
				    
				    <tr>
				      <td class="level2 legend x" fld="ElectHH2009"><i class="pointer"></i>Electricity (% households 2009) </td>
				    </tr>
				    
				    <tr>
				      <td class="level2 legend y" fld="PavedRoads2012"><i class="pointer"></i>Paved roads (% of total roads 2012) </td>
				    </tr>
				    
				    <tr>
				      <td class="level2 legend z" fld="DeliveredHealthCentre"><i class="pointer"></i>Delivered in a health centre </td>
				    </tr>
				    
				    <tr>
				      <td class="level2 legend aa" fld="QualifiedMedDuringBirth"><i class="pointer"></i>Qualified medical assistant during birth </td>
				    </tr>
				    
				    <tr>
				      <td class="level2 legend ab" fld="HadVaccinations"><i class="pointer"></i>Had all vaccinations </td>
				    </tr>
				    
				    <tr>
				      <td class="level2 legend ac" fld="AdequateHeightAge"><i class="pointer"></i>Adequate height for age </td>
				    </tr>
				    
				    <tr>
				      <td class="level2 legend ad" fld="ReadWrite"><i class="pointer"></i>Can read and write </td>
				    </tr>
				    
				    <tr>
				      <td class="level2 legend ae" fld="AttendSchool1518yrs"><i class="pointer"></i>Attending school, 15-18 years </td>
				    </tr>-->
				   </tbody>
				</table>

		
	</div>

	<div class="col_two_third col_last">
		<center><h5>County Comparison (47 Counties)</h5></center>
		<div id="generalC" style="width: 100%; height: 1000px !important; margin: 0 auto"></div>	
	</div>