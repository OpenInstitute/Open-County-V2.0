<?php /*?>
<hr />
<h1>Duis autem vel eum iriure dolor in hendrerit vel eum iriure</h1>
<h2>Duis autem vel eum iriure dolor in hendrerit vel eum iriure</h2>
<h3>Duis autem vel eum iriure dolor in hendrerit vel eum iriure</h3>
<h4>Duis autem vel eum iriure dolor in hendrerit vel eum iriure</h4>
<h5>Duis autem vel eum iriure dolor in hendrerit vel eum iriure</h5>
<h6>Duis autem vel eum iriure dolor in hendrerit vel eum iriure</h6>
<hr />

<p>Duis autem vel eum iriure dolor in hendrerit vel eum iriure</p>
<p style="font-weight:500">Duis autem vel eum iriure dolor in hendrerit vel eum iriure</p>
<p style="font-weight:bold">Duis autem vel eum iriure dolor in hendrerit vel eum iriure</p>
<div class="font-mpc txt17">
<p>Duis autem vel eum iriure dolor in hendrerit vel eum iriure</p>
<p><strong>Duis autem vel eum iriure dolor in hendrerit vel eum iriure</strong></p>
<p><em>Duis autem vel eum iriure dolor in hendrerit vel eum iriure</em></p>
<p><em><strong>Duis autem vel eum iriure dolor in hendrerit vel eum iriure</strong></em></p>

</div>
<hr />
<?php */?>



<?php
//echobr($com_active);
//$dispData->buildContent_Arr($com_active);
$contArr = array();
$gutsArr = array();

$contNumber = count(master::$contMain['parent'][$com_active]); //displayArray(master::$contMain); //exit;

if($contNumber == 0)
{
	echo display_PageTitle($my_page_head . '');
}
else
{
	if($item) 	{	$contArr[$item] 	= master::$contMain['parent'][$com_active][$item]; }
	else 		{	 $contArr 	=  master::$contMain['parent'][$com_active]; }



if(count($contArr) == 1) {
	$contKey 		= current($contArr); 	
	
	$gutsArr 		= master::$contMain['full'][$contKey];
	//displayArray( $gutsArr);
	$item 		   = $gutsArr['content_id'];	
	$artSection 	 = $gutsArr['id_section'];
	$artTitle 	   = $gutsArr['content_title'];
	$artTitleSub 	= ''; //$gutsArr['title_sub'];
	$artArticle	 = $gutsArr['content_article'];
	$artStamp	   = $gutsArr['date_modified'];
	$artLocation	= $gutsArr['menu_title'];
	$artBooking	 = ''; //$gutsArr['booking'];
	$artBooking_amount = ''; //$gutsArr['booking_amount'];
	
	$nicedate       = array();
	$artEventData   = '';
	
	if($artSection == 6) 
	{
		$artDates	   = $gutsArr['event_dates'];
		if(is_array($artDates) and count($artDates)) {
			foreach($artDates as $dateArr) {
				$nicedate[] = '&nbsp; &bull; &nbsp; '. date('l M d, Y',$dateArr['ev_date']).' '.$dateArr['ev_time_start'].' - '.$dateArr['ev_time_end'] . '';
			}
		}
		
		$artEventData   .= '<h4><u>When:</u></h4><div class="bold">'. implode('<br>', $nicedate) .'</div><br>';
		$artEventData   .= '<h4><u>Where:</u></h4><div><strong>&nbsp; &bull; &nbsp; '.$artLocation.'</strong></div><br>';
		$artEventData   .= '<h4><u>Details:</u></h4>';
		
		if($artBooking == 1 and $artBooking_amount > 0) {
			$artEventData   .= '<h6>Charges:</h6><div><strong>'.$artBooking_amount.'</strong><p>&nbsp;</p></div>';	
		}
			
	}
	
	
	if(preg_match('/<img[^>]+\>/i',$artArticle,$regs)) { 
		if(count($regs) > 0)
		{
			$artArticle 	  = str_replace('"image/', '"'.SITE_DOMAIN_LIVE.'image/', $artArticle);
		}
	} 
	
	$breakStart 	     = 200;
	$string	     = $artArticle;
	$pageLoops	  = ceil((strlen($string) / $breakStart)); 
	$start = 0;
	
	$title_sub	  = '';
	$title_date	 = '';
	
	echo '<div class="article-area"><div id="articleContent">';
	echo display_PageTitle($artTitle);
	
	//include("includes/inc.gallery.cont.php");
	
	
	if($artSection == 2 or $artSection == 12)  
	{	//NEWS
		$title_date = '<div class="info noborder padd2 padd15_l"><span class="postDate nocaps txt11">Updated: '.$artStamp.'</span></div>';}
	
	
	echo '<div class="main-guts">'. $title_date . $artEventData . $artArticle.'</div>';	//$title_sub .
	
	
	
	echo '</div></div>';	
	
	//include("includes/nav_downloads_cont.php");
	
	//include("includes/form_comment.php");
	
}
else
{
	include("includes/inc.cont.main.list.php");
}



if(count($contArr) == 1 and $this_page <> "contacc.php" and $this_page <> "contact.php")
{ include("includes/nav_social_share.php"); }

}
?>
