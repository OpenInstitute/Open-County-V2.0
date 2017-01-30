<?php include("sec_head.php"); ?>
	
		
<section>
<!-- section - STARTS -->



<!-- Left Section -->
<?php include("includes/nav_left.php"); ?>	
<!-- Left Section - ENDS -->		
		
		
		
		
		
		
<!-- mainpanel -->	
<div class="mainpanel ">

	<!-- headerbar -->
	<div class="headerbar ">
		<a class="menutoggle"><i class="fa fa-bars"></i></a>				
		<div class="header-right">
			<ul class="headermenu">
			<li>
				<div class="btn-group">
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<img src="../images/avatars/munene.murage@gmail.com.jpg" alt="" /> Murage <span style="font-size:12px; font-weight:normal; color:#C4CCDF">(Superuser)</span>
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu dropdown-menu-usermenu pull-right">							
						<li><a href="javascript:;" data-toggle="modal" data-target="#logout_mdl"><i class="glyphicon glyphicon-log-out"></i> Logout</a></li>
					</ul>
				</div>
			</li>
			</ul>
		</div>		
	</div>
	<!-- headerbar - END -->
	
	
	
	<!-- content-title -->
	<div class="pageheader ">
		<h2><i class="fa fa-tachometer"></i> <?php echo clean_title(ucwords($dir)); ?> &raquo; </h2>
		<div class="breadcrumb-wrapper"> {breadcrumbs} </div>
	</div>
	<!-- content-title - END -->		
	
				
	<!-- PageContent -->			
	<div class="contentpanel ">
		<!--{content}-->
		
		
		
<?php
		
switch($dir)
{ 
	
	case "menus":
		include("includes/adm_frm_menus.php");
		break;
	
	case "articles":
		include("includes/adm_frm_articles.php");
		break;
	
	case "events":
		include("includes/adm_events_list.php");
		break;
	
	
	// RESOURCES	
	case "resources":
		include("includes/adm_frm_resources.php");
		break;
		
	case "shared stories":
		include("includes/adm_stories_list.php");
		break;
		
	case "circuit profiles":
		include("includes/adm_profiles_list.php");
		break;
	
	case "events registrations":
		include("includes/adm_list_event_register.php");
		break;
	
	// GALLERIES	
	case "content galleries":
		include("includes/adm_gallery_cats.php");
		break;
			
	case "image and video uploads":
		include("includes/adm_gallery_pics.php");
		break;
	
	case "video gallery":
		include("includes/adm_gallery_vids.php");
		break;
	
	
	
		
	
	
}

//$dirListOne = trim(substr($dir,0,15));


?>



	</div>
	<!-- PageContent - ENDS -->	
			
					
</div>
<!-- mainpanel - ENDS -->	
		



	
<!-- rightpanel - STARTS -->
<div class="rightpanel "></div>
<!-- rightpanel - ENDS -->




<!-- BEGIN BACK TO TOP BUTTON -->
<div id="back-top">
	<a href="#top"><i class="fa fa-chevron-up"></i></a>
</div>
<!-- END BACK TO TOP -->
		
		
		
<!-- section - ENDS -->			
</section>

					
<?php include("sec_foot.php"); ?>					
