<?php
require("classes/cls.constants.php"); 
include("classes/cls.paths.php");
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
	<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="SemiColonWeb" />
	<link rel="shortcut icon" href="images/favi.png">


	<!-- Stylesheets
	============================================= -->
	<?php if($_SERVER['HTTP_HOST'] <> "localhost") { ?>
	<link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" /><?php } ?>
	<link rel="stylesheet" href="scripts/css/bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="scripts/css/style.css" type="text/css" />
	<link rel="stylesheet" href="scripts/css/dark.css" type="text/css" />
	<link rel="stylesheet" href="scripts/css/font-icons.css" type="text/css" />
	<link rel="stylesheet" href="scripts/css/animate.css" type="text/css" />
	<link rel="stylesheet" href="scripts/css/magnific-popup.css" type="text/css" />

	<link rel="stylesheet" href="scripts/css/responsive.css" type="text/css" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<!-- SLIDER REVOLUTION 5.x CSS SETTINGS -->
	<link rel="stylesheet" type="text/css" href="include/rs-plugin/css/settings.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="include/rs-plugin/css/layers.css">
	<link rel="stylesheet" type="text/css" href="include/rs-plugin/css/navigation.css">

	<!-- Our CSS instead of rewriting inline -->
	<link rel="stylesheet" type="text/css" href="scripts/css/our.css">
	
	<style type="text/css" media="all">@import url('scripts/css/custom/base_nav.css');@import url('scripts/css/custom/base_overrides.css');</style>
	<link rel="stylesheet" type="text/css" href="scripts/css/fonts/font-awesome/font-awesome.css" />
	
	<!-- External JavaScripts
	============================================= -->
	<script type="text/javascript" src="scripts/js/jquery-1.12.3.js"></script>
	<script type="text/javascript" src="scripts/js/jquery-migrate-1.2.1.min.js"></script>

	<!-- Document Title
	============================================= -->
	<!--<title>Home | Open County</title>-->
	<title><?php echo $thisSite; ?></title>  

	

</head>


<body class="stretched">