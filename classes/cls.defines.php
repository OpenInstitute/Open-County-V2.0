<?php
	@require('cls.locate.php');
	
	
	if(isset($_REQUEST['cid']) and is_numeric($_REQUEST['cid'])) {$cid=$_REQUEST['cid'];} else {$cid=47;}
	if(isset($_REQUEST['cta']) and is_numeric($_REQUEST['cta'])) {$cta=$_REQUEST['cta'];} else {$cta=47;}
	if(isset($_REQUEST['ctb']) and is_numeric($_REQUEST['ctb'])) {$ctb=$_REQUEST['ctb'];} else {$ctb=1;}

	if(isset($_REQUEST['cdept'])) {$cdept=clean_request($_REQUEST['cdept']);} else {$cdept='';}
	if(isset($_REQUEST['cperiod'])) {$cperiod=clean_request($_REQUEST['cperiod']);} else {$cperiod='';}
	if(isset($_REQUEST['ind'])) {$ind=clean_request($_REQUEST['ind']);} else {$ind='';}

	if(isset($_REQUEST['com'])) { $com=clean_request($_REQUEST['com']);}  else {$com = NULL;}
	//if(isset($_REQUEST['com']) and is_numeric($_REQUEST['com'])) { $com=$_REQUEST['com'];} else { $com=1; }
	if(isset($_REQUEST['com2']) and is_numeric($_REQUEST['com2'])) {$com2=$_REQUEST['com2'];} else {$com2=NULL;}
	if(isset($_REQUEST['com3']) and is_numeric($_REQUEST['com3'])) {$com3=$_REQUEST['com3'];} else {$com3=NULL;}
	if(isset($_REQUEST['com4']) and is_numeric($_REQUEST['com4'])) {$com4=$_REQUEST['com4'];} else {$com4=NULL;}
	if(isset($_REQUEST['item']) and is_numeric($_REQUEST['item'])) {$item=$_REQUEST['item'];} else {$item=NULL;}
	
	if(isset($_REQUEST['pj']) and is_numeric($_REQUEST['pj'])) {$pj=$_REQUEST['pj'];} else {$pj=NULL;}
	if(isset($_REQUEST['pl']) and is_numeric($_REQUEST['pl'])) {$pl=$_REQUEST['pl'];} else {$pl=NULL;}
	if(isset($_REQUEST['sc']) and is_numeric($_REQUEST['sc'])) {$sc=$_REQUEST['sc'];} else {$sc=NULL;}
	
	if(isset($_REQUEST['fcall'])) {$fcall=clean_request($_REQUEST['fcall']);} else {$fcall= NULL;}
	if(isset($_REQUEST['fc'])) {$fc=clean_request($_REQUEST['fc']);} else {$fc= NULL;}
	
	if(isset($_REQUEST['page']) and is_numeric($_REQUEST['page'])) {$page=$_REQUEST['page'];} else {$page=1;}	
	if(isset($_REQUEST['qst']) and is_numeric($_REQUEST['qst']))	{$qst=$_REQUEST['qst'];} else {$qst=NULL;}
	if(isset($_REQUEST['gal']) and is_numeric($_REQUEST['gal'])) {$gal=$_REQUEST['gal'];} else {$gal=NULL;}
	if(isset($_REQUEST['id']) and is_numeric($_REQUEST['id'])) {$id=$_REQUEST['id'];} else {$id=NULL;}
	if(isset($_REQUEST['parent']) and is_numeric($_REQUEST['parent'])) {$parent=$_REQUEST['parent'];} else {$parent=NULL;}
	
	if(isset($_REQUEST['event'])) {$event=clean_request($_REQUEST['event']);} else {$event=NULL;}
	
	if(isset($_REQUEST['call'])) {$call=clean_request($_REQUEST['call']);} else {$call='';}
	
	if(isset($_REQUEST['ptab'])) {$ptab=clean_request($_REQUEST['ptab']);} else {$ptab= 'profile';}
	if(isset($_REQUEST['ureg'])) {$ureg = clean_request($_GET['ureg']);} else { $ureg= NULL;}
	if(isset($_REQUEST['uac'])) {$uac = clean_request($_GET['uac']);} else { $uac= NULL;}
	if(isset($_REQUEST['op'])) { $op=clean_request($_REQUEST['op']); } else { $op='new'; }
	if(isset($_REQUEST['dc'])) { $dc=clean_request($_REQUEST['dc']); } else { $dc=NULL; }
	
	if(isset($_REQUEST['pay'])) { $pay=clean_request($_REQUEST['pay']); } else { $pay=NULL; }
	
	/*-----------XXXXXXXXXXXXXXXXXXXXXX*/
	if(isset($_REQUEST['eqp']) and is_numeric($_REQUEST['eqp'])) {$eqp=$_REQUEST['eqp'];} else {$eqp=NULL;}
	if (isset($_REQUEST['d'])){$dir = strtolower($_REQUEST['d']); } else {$dir='dashboard';}	
	
	$token = time();
	
	$com_base_arr['com'] = @$com;
	
	 if($com2)		{ $com_base_arr['com2'] = $com2; }
	 if($com3)		{ $com_base_arr['com3'] = $com3; }
	 if($com4)		{ $com_base_arr['com4'] = $com4; }
	 if($item)		{ $com_base_arr['item'] = $item; }
	 
	
	$com_base = '?'; $com_baseb = ''; 
	foreach ($com_base_arr as $key => $value) 
	{			//echo $key.' - ';
		if($key <> 'item'){
		$com_base .= $key .'='. $value .'&'; 
		}
		//echo $com_base.' - ';
	}
	
	define('RDR_REF_BASE', $com_base);
	//define('RDR_REF_BASE', "?com=".$com."&com2=".$com2."&com3=".$com3."&com4=".$com4);
	//define('RDR_REF_PAGE', $this_page);
	//define('RDR_REF_PATH', $this_page."?".$_SERVER['QUERY_STRING']);
	define('RDR_REF_SIDE', "?".$_SERVER['QUERY_STRING']);
	

			

?>