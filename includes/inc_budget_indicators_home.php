<div class="col_full">
<div class="padd20"></div>

	<?php
	$selectPeriod 		= $dispOc->get_countyBudgetPeriod($cid, '', 1);	
	$selectPeriodData   = $dispOc->get_countyBudgetPeriodIndicators($cid, $selectPeriod);

	$bi_cards = array();

	foreach($selectPeriodData as $arrBI){
		$bi_department = $arrBI['department'];
		$bi_allocated = niceNumber($arrBI['allocated']);
		$bi_source = $arrBI['source'];
		$bi_projects = $arrBI['num_projects'];

		$bi_btn_table = '<a class="disabled"><i class="fa fa-table"></i></a> &nbsp;';
		$bi_btn_pie = '<a class="disabled"><i class="fa fa-pie-chart"></i></a> &nbsp;';
		$bi_btn_bar = '<a class="disabled"><i class="fa fa-bar-chart"></i></a>';
		$bi_projects_label = '';
		
		if(intval($bi_allocated) > 1) { 
			$bi_btn_table = '<a '.$deptref .'><i class="fa fa-table"></i></a> &nbsp;';
			$bi_btn_pie = '<a '.$deptref .'><i class="fa fa-pie-chart"></i></a> &nbsp;';
			$bi_btn_bar = '<a '.$deptref .'><i class="fa fa-bar-chart"></i></a>';
			$bi_projects_label = '<br><span class="txt11"><em>Project #: '.$bi_projects.'</em></span>';
		}
			/* $bi_btn_table = '&nbsp;';
			$bi_btn_pie = '<a '.$deptref .' class="txtgray">[ More ]</a>';
			$bi_btn_bar = '&nbsp;';*/

		$deptref  = ' href="budget.php?com=10&cid='.$cid.'&cperiod='.$selectPeriod.'&cdept='.$bi_department.'" ';
		
		
		$bi_cards[]  = '<li><div class="block equalized txtcenter">
			<div class="padd10 txt11 border_bottom_gray">ALLOCATION</div> 
			<a '.$deptref .' class="txtgray"><div class="padd20_t padd15_b txticon">'.$bi_allocated.'</div>
			<div class="padd10_0 txt18">'.$bi_department.' '.$bi_projects_label.'</div> </a> 
			<div class="padd15_b txt12">SOURCE: '.$bi_source.'</div> 
			<div class="padd10 txt11 txtcenter border_top_gray"> &nbsp
				'.$bi_btn_table.'
				'.$bi_btn_pie.'
				'.$bi_btn_bar.'
			</div>
			</div></li>';
	}
	?>
	<h4>BUDGET INDICATORS - <span class="txtred txt21"><?php echo $selectPeriod; ?></span> </h4>
	<div id="" class="wrap_gallery notransform">
		  <ul class="bxslider bxcarousel column col25 ">
		  <?php echo implode('', $bi_cards); ?>         
		  </ul>
	</div>
</div>
