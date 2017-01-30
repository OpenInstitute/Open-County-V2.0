<?php //require('Includefiles/conn.inc');
//ini_set("display_errors", "on");
require_once('classes/cls.formats.php');
require_once('classes/cls.config.php');	

$cons=$_POST['cons'];
$cid=$_POST['cid'];

$dat = '<table class="table table-condensed table-hover">
	<thead>
	  <th>MCA Name</th>
	  <th>Ward</th>
	  <th>Political Party</th>
	</thead>';
	if($cons!='Nominated'){
		$query_Contents_4 = $cndb->dbQuery("SELECT * FROM oc_county_profiles WHERE leader_type_id = '4' and constituency = ".q_si($cons)." AND county_id = ".q_si($cid)." ");
	} else {
		$query_Contents_4 = $cndb->dbQuery("SELECT * FROM oc_county_profiles WHERE leader_type_id = '4' and constituency IS NULL AND county_id = ".q_si($cid)." ");
	}
		while($row_Contents_4 = $cndb->fetchRow($query_Contents_4))
		{

	$dat .= '<tr>
			  <td>'. $row_Contents_4['leader_name'] .'</td>
			  <td>'. $row_Contents_4['ward'] .'</td>
			  <td>'. $row_Contents_4['party'] .'</td>
			</tr>';
		 } 
$dat .= '</table>';

echo $dat;
