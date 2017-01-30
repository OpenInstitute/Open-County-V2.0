<?php require '../classes/cls.constants.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<link href="<?php echo SITE_LOGO; ?>" rel="shortcut icon" type="image/png" />
	<title>Admin:: </title>
	
	<link href="css/style.default.css" rel="stylesheet">
	<link href="css/style.katniss.css" rel="stylesheet">	
	<?php if($this_page=="index.php"){ echo '<link href="css/login.css" rel="stylesheet">'; }	 ?>	
	
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->


<link rel="stylesheet" type="text/css" href="../scripts/js/multiselect/jquery.multiselect.css" />
<link rel="stylesheet" type="text/css" href="../scripts/js/multiselect/jquery.multiselect.filter.css" />
<link rel="stylesheet" type="text/css" href="../scripts/js/datatable/jquery.dataTables.css" />

<!--<link rel="stylesheet" type="text/css" href="styles/data_table.css" />-->
<link rel="stylesheet" type="text/css" href="../scripts/js/datepick/jquery.datepick.css" id="theme">

<link rel="stylesheet" type="text/css" href="../scripts/css/smoothness/jquery-ui-1.10.2.css" />
<link rel="stylesheet" type="text/css" href="../scripts/css/smoothness/jquery-ui-1.8.4.custom.css" />
<link rel="stylesheet" type="text/css" href="../scripts/js/datatable/jquery.dataTables.override.css" />
<link rel="stylesheet" type="text/css" href="../scripts/css/fonts/font-awesome/font-awesome.css" />

<style type="text/css" media="all">
/*@import url('../scripts/css/custom/base_styles.css');*/
@import url('../scripts/css/custom/base_forms.css');
@import url('../scripts/css/custom/base_grid.css');
@import url('../scripts/css/custom/base_overrides.css');/**/
</style>	


<script src="../scripts/js/jquery-1.12.3.js"></script>
	
</head>

<?php echo $this_page;
if($op=="edit"){ $title_new	= "Edit "; } elseif($op=="new") { $title_new	= "New "; }	
?>
<body class="tooltips has-top-notification stickyheader ">