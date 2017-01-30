<div class="col_two_third nobottommargin">
			
			 	<div class="toppadX">
						
				</div>
			</div>
<div class="col_full toppadX notopmargin nobottommargin">
	<nav class="navbar navbar-default nobottommargin" role="navigation">
			  <div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
				  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-9">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				  </button>
				  <!--<a class="navbar-brand" href="#">Makueni County</a>-->
				  <div class="dropdown">
				  <select id="selectpicker" class="selectpicker selectpicker-county show-tick dropdown-menu" data-live-search="true" style="display:none">
						<?php echo $ddSelect->dropperCounties($cid); ?>
						</select>
						</div>
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-9">
				  <ul class="nav navbar-nav sf-menu">
				  <?php
				  $nav_county = $dispData->buildMenu_Main($com_active, 10, 0, 'nav_top', $cid); 
				  echo $nav_county;
				  ?>
					
				  </ul>
				</div><!-- /.navbar-collapse -->
			  </div><!-- /.container-fluid -->
			</nav>
</div>
<!--<div class="clearfix"></div>
<div class="clearfix toppad"></div>-->


<?php if($this_page <> 'countyX.php'){ ?>
<div class="col_full toppadX noleftpaddingX noleftmarginX nobottommargin ">
<div class="breadcrumb linegraydot"><div class="padd10_0 padd15_l "><?php  echo $my_breadcrumb_county;  ?> </div></div>

</div>	
<div class="clearfix"></div>

<?php } ?>
<div class="clearfix toppad padd10X"></div>

