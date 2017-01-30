<?php

/******************************************************************
@begin :: SESSIONS
********************************************************************/	
$conf_token = time();

$contactLock = '';

$us_acc_current = '';
$us_id	   = '';
$us_name	 = '';
$us_fname	= '';
$us_lname	= '';
	
$us_email 	= '';
$us_type_id  = '';
$us_type  	 = '';
$us_level_id  = '';
$us_level  	 = '';
$us_dept_id  = '';
$us_post_id  = '';
$us_staff	= 0;
$us_photo    = 'no_avatar.png';
$us_login    = '';
$us_signed_in = false;
$us_access   = array();

$us_post     = '';
$us_dept     = '';

$us_first_name	= '';
$us_other_name	= '';
$us_type_label    = '';	

$member_is_admin = 0;

$sess_checker = time();
	
$sys_us_admin = array();	
	
/*
$log_session = array(
			'u_id' 			=> ''.$u_id.'',
			'u_fname' 		 => ''.$u_fname.'',
			'u_lname' 		 => ''.$u_lname.'',
			'u_type_id' 	   => ''.$u_type_id.'',
			'u_type' 		  => ''.$u_type.'',
			'u_email' 		 => ''.$u_email.'',
			'u_staff' 		 => ''.$u_staff.'',
			'expires'		 => time()+(45*60)
		);
*/

	
	//displayArray($_SESSION['sess_oc_member']);
if (!empty($_SESSION['sess_oc_member'])) 
{ 
	$sess_mbr	 = $_SESSION['sess_oc_member'];
	$sess_expire 	  = $sess_mbr['expires'];
	
	/*if($sess_checker >= $sess_expire)
	{
		if( $this_page <> "posts.php" ) {
		echo '<script type="text/javascript">location.href="'.SITE_DOMAIN_LIVE.'posts.php?signout=on";</script>'; exit;
		}
	}*/
		
	$us_id		 = $sess_mbr['u_id'];	
	$us_name	   = $sess_mbr['u_fname'];	
	$us_email 	  = $sess_mbr['u_email'];	
	$us_type_id  	= $sess_mbr['u_type_id'];	
	$us_level_id   = $sess_mbr['u_type_id'];	
	$us_photo 	  = @$sess_mbr['u_photo'];
	$id_user 	   = $us_id;
	
	//$us_name 	   = $us_fname; 
	
	$contactLock   = ' readonly="readonly" '; 
	
	$us_email_name  = explode(' ', $us_name); /*preg_split("/ /", $us_name);*/  
	//displayArray($us_email_name);
	
	$us_fname = $us_email_name[0];
	//if($us_name == '') { $us_name = $us_email_name[0]; }
	

	$us_lnk_home 	= 'client.php?op=list&order_lt=recent';	
	
	$us_acc_current = '<a href="hforms.php?d=member_accounts&op=edit&id='.$us_id.'" title="'.$us_name.'"><i class="fa fa-user"></i> '.$us_fname.'</a>'; 
	// <span id="nav_link_accX">&nbsp; '.$us_name.'</span>
	$us_acc_logout = '<a href="posts.php?signout=on">Log Out <i class="fa fa-sign-out"></i></a>';
	
} else { $sess_mbr	= ''; }


if (!empty($_SESSION['sess_oc_admin'])) 
{ 
	$sys_us_admin = $_SESSION['sess_oc_admin'];
}

	
/******************************************************************
@end :: SESSIONS
********************************************************************/		

/*
<li><a data-url="accounts_settings.php?ptab=profile" data-id="profile"><i class="fa fa-gear"></i> Account Profile </a></li>
	<li><a data-url="accounts_settings.php?ptab=password" data-id="login"><i class="fa fa-key"></i> Change Password </a></li>
	<li><a data-url="accounts_resources.php?ptab=resources" data-id="resources"><i class="fa fa-download"></i> Resource Center </a></li>
*/

function conf_usAccLinks($acc_link_pos, $acc_roles='')
{
	$acc_link_list = '';
	$conf_token = time();
	
	$us_staff = @$_SESSION['sess_oc_member']['u_staff'];
	
	if($acc_link_pos === 1) 
	{
/* @ MEMBER DROP DOWN BAR */		
		$acc_link_list = '
<li><a href="profile/?ptab=dashboard"><i class="fa fa-gear"></i> Dashboard </a></li>
<li><a href="profile/?ptab=password"><i class="fa fa-key"></i> Change Password  </a></li>
';
	$acc_link_list = '';
/*<li><a href="#events"><i class="fa fa-calendar-o"></i> Events Calendar  </a></li>
<li><a href="#resources"><i class="fa fa-download"></i> My Resources</a></li>*/
//<li><a href="accounts.php?tab=1&token='.$conf_token.'#dashboard"><i class="fa fa-files-o"></i> Dashboard </a></li>
//<li><a href="accounts.php?tab=5&tk='.$conf_token.'#forums"><i class="fa fa-pagelines"></i> Online Forum </a></li>
	}
	elseif($acc_link_pos === 2) 
	{

/* @ MEMBER SIDE BAR */
		
	$acc_link_list = '
<li><a href="profile/?ptab=dashboard" data-id="dashboard"><i class="fa fa-files-o"></i> Dashboard </a></li>
<li class="divider">&nbsp;</li>
<li><a href="profile/?ptab=resources" data-id="resources"><i class="fa fa-download"></i> My Resources </a></li>';

if($us_staff == 1)
{
	//<li><a href="profile/?ptab=calendar" data-id="calendar"><i class="fa fa-calendar"></i> My Calendar </a></li>
$acc_link_list .= '
<li class="divider">&nbsp;</li>
<li><a href="profile/?ptab=notices" data-id="notices"><i class="fa fa-envelope"></i> VDS Notices </a></li>
<li><a href="profile/?ptab=memos" data-id="memos"><i class="fa fa-files-o"></i> VDS Memos </a></li>
<li><a href="profile/?ptab=events" data-id="events"><i class="fa fa-calendar-o"></i> VDS Events </a></li>
<li class="divider">&nbsp;</li>
';

}	
		
		

$acc_link_list .= '<li><a href="profile/?ptab=profile" data-id="profile"><i class="fa fa-gear"></i> My Profile </a></li>';
$acc_link_list .= '<li><a href="profile/?ptab=password" data-id="password"><i class="fa fa-key"></i> Change Password </a></li>';
$acc_link_list .= '<li class="divider"></li>';
$acc_link_list .= '<li><a href="posts.php?signout=on"><i class="fa fa-sign-out"></i> Log Out</a></li>';
$acc_link_list .= '<li class="divider"></li>';


	}
	return $acc_link_list;
}







	
?>