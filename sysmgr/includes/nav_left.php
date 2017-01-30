
<div class="leftpanel ">

<!-- Logo Panel -->
<div class="logopanel " style="cursor:pointer; height:53px;" id="header_logo_panel"> 
	<a href="./"><img src="<?php echo SITE_LOGO; ?>" style="" /></a>
</div>			
<!-- Logo Panel - ENDS -->


<div class="leftpanelinner ">


		<!-- Account Panel - small devices -->
		<div class="visible-xs hidden-sm hidden-md hidden-lg">
			<div class="media userlogged">
				<img alt="" src="../images/avatars/munene.murage@gmail.com.jpg" class="media-object">
				<div class="media-bodyX">
					<h4>Murage Munene</h4>
					<span>Level: Superuser</span>
				</div>
			</div>
			<h5 class="sidebartitle actitle">Account</h5>
			<ul class="nav nav-pills nav-stacked nav-bracket mb30">

				<li><a href="javascript:;" data-toggle="modal" data-target="#logout_mdl"><i class="fa fa-sign-out"></i> <span>Logout</span></a></li>
			</ul>
		</div>
		<!-- Account Panel - small devices - ENDS -->




	<!-- Left Menu -->
	<div>
			
	<h5 class="sidebartitle">Navigation</h5>
	<ul class="nav nav-pills nav-stacked nav-bracket">
	
		<li style="height:2px; background:#2A6FA8;"></li>
		<li class="nav-activeX activeX"><a href="index.php"><i class="fa fa-tachometer"></i> <span>Dashboard</span> </a></li>

		

		<!-- Categories -->
		<li class="nav-parent "><a href=""><i class="fa fa-folder-o"></i> <span>Menus</span></a>
		<ul class="children" >
			<li ><a href="hforms.php?d=menus&op=new"><i class="fa fa-plus-circle"></i> Add New</a></li>
			<li ><a href="home.php?d=menus"><i class="fa fa-folder-open-o"></i> Manage</a></li>
		</ul>
		</li>


		<!-- Articles -->
		<li class="nav-parent "><a href=""><i class="fa fa-edit"></i> <span>Articles</span></a>
		<ul class="children" >
			<li ><a href="hforms.php?d=articles&op=new"><i class="fa fa-plus-circle"></i> Add New (Basic/News)</a></li>			
			<li ><a href="home.php?d=articles"><i class="fa fa-files-o"></i> Manage </a></li>
			<li style="height:5px; background:#ddd;"></li>
			<li ><a href="hforms.php?d=events&op=new"><i class="fa fa-plus-circle"></i> Add New Event</a></li>
			<li ><a href="home.php?d=events"><i class="fa fa-file-text-o"></i> Manage Events</a></li>
		</ul>
		</li>



		<!-- News -->
		<!--<li class="nav-parent "><a href=""><i class="fa fa-file-text-o"></i> <span>News</span></a>
		<ul class="children" >
			<li ><a href="hforms.php?d=news&op=new"><i class="fa fa-plus-circle"></i> Add New</a></li>
			<li ><a href="home.php?d=news"><i class="fa fa-file-text-o"></i> Manage</a></li>
		</ul>
		</li>-->


		<!-- Events -->
		<!-- <li class="nav-parent "><a href=""><i class="fa fa-calendar-o"></i> <span>Events</span></a>
		<ul class="children" >
			<li ><a href="hforms.php?d=events&op=new"><i class="fa fa-plus-circle"></i> Add New</a></li>
			<li ><a href="home.php?d=events"><i class="fa fa-file-text-o"></i> Manage</a></li>
		</ul>
		</li>-->

		
		<!-- Resources -->
		<li class="nav-parent "><a href=""><i class="fa fa-book"></i> <span>Resources</span></a>
		<ul class="children" >
			<li ><a href="hforms.php?d=resources&op=new"><i class="fa fa-plus-circle"></i> Add New File</a></li>
			<li ><a href="home.php?d=resources"><i class="fa fa-flag"></i> Manage Files</a></li>
			<li style="height:5px; background:#ddd;"></li>
			<li ><a href="hforms.php?d=gallery&op=new"><i class="fa fa-plus-circle"></i> Add New Image/Video</a></li>
			<li ><a href="home.php?d=gallery"><i class="fa fa-flag"></i> Manage Image/Video</a></li>
		</ul>
		</li>
		
		


		<!-- Resources -->
		<!--<li class="nav-parent "><a href=""><i class="fa fa-book"></i> <span>Image and Video gallery</span></a>
		<ul class="children" >
			<li ><a href="hforms.php?d=image and video gallery&op=new"><i class="fa fa-plus-circle"></i> Add New</a></li>
			<li ><a href="home.php?d=image and video gallery"><i class="fa fa-flag"></i> Manage</a></li>
		</ul>
		</li>-->

		<li style="height:2px; background:#2A6FA8;"></li>
		<li style="background:#FFF;" class="padd5 txt15">COUNTY MANAGEMENT</li>
		<li style="height:2px; background:#2A6FA8;"></li>
		
		
		<!-- Counties -->
		<!--<li class="nav-parent "><a href=""><i class="fa fa-map-marker"></i> <span>County Management</span></a>
		<ul class="children" >-->
			<li ><a href="home.php?d=county"><i class="fa fa-map-marker"></i> Counties</a></li>
			<li ><a href="home.php?d=county leadership"><i class="fa fa-user"></i> County Leadership</a></li>
			<li ><a href="home.php?d=general indicators"><i class="fa fa-star"></i> General Indicators</a></li>
			<li ><a href="home.php?d=budget indicators"><i class="fa fa-briefcase"></i> Budget Indicators</a></li>
		<!--</ul>
		</li>-->
		
		<li style="height:2px; background:#2A6FA8;"></li>
		<li style="background:#FFF;" class="padd5 txt15">SYSTEM MANAGEMENT</li>
		<li style="height:2px; background:#2A6FA8;"></li>
		
		
		<!-- Comments //TODO -->
		<li class="nav-parent "><a href=""><i class="fa fa-comments-o"></i> <span>User Posts</span></a>
		<ul class="children" >
			<li ><a href="home.php?d=feedback posts"><i class="fa fa-envelope"></i> Feedback</a></li>
			<li ><a href="home.php?d=comments"><i class="fa fa-arrow-circle-up"></i> Comments</a></li>
			<!--<li ><a href="home.php?d=comments&op=pending"><i class="fa fa-flag"></i> Pending</a></li>-->			
		</ul>
		</li>
		
		
		
		<li class="nav-parent "><a href=""><i class="fa fa-wrench"></i> <span>Configurations</span> </a>
			<ul class="children" >
				<li ><a href="home.php?d=online polls"><i class="fa fa-flag"></i> County Leader Types</a></li>
				<li ><a href="home.php?d=feedback posts"><i class="fa fa-flag"></i> County Indicator Categories</a></li>
				<li ><a href="hforms.php?d=admin settings"><i class="fa fa-flag"></i> County Indicators</a></li>
			</ul>
		</li>
		
		<!-- Users -->
		<!--<li class="nav-parent "><a href=""><i class="fa fa-users"></i> <span>Staff</span></a>
		<ul class="children" >
			<li ><a href="hforms.php?d=staff&op=new"><i class="fa fa-plus-circle"></i> Add New</a></li>
			<li ><a href="home.php?d=staff"><i class="fa fa-users"></i> Manage</a></li>

		</ul>
		</li>-->

		<!-- Groups -->
		<!--<li class="nav-parent "><a href=""><i class="fa fa-sitemap"></i> <span>Groups</span></a>
		<ul class="children" >
			<li ><a href="hforms.php?d=groups&op=new"><i class="fa fa-plus-circle"></i> Add New</a></li>
			<li ><a href="home.php?d=groups"><i class="fa fa-joomla"></i> Manage</a></li>
		</ul>
		</li>-->



		<!-- Positions -->
		<!--<li class="nav-parent "><a href=""><i class="fa fa-sitemap"></i> <span>Positions</span></a>
		<ul class="children" >
			<li ><a href="hforms.php?d=positions&op=new"><i class="fa fa-plus-circle"></i> Add New</a></li>
			<li ><a href="home.php?d=positions"><i class="fa fa-sitemap"></i> Manage</a></li>
		</ul>
		</li>-->


		<!-- Statistics -->
		<!-- Tools -->



		<li class="nav-parent "><a href=""><i class="fa fa-gears"></i> <span>Advanced</span> </a>
		<ul class="children" >
			<!--<li ><a href="home.php?d=online polls"><i class="fa fa-star"></i> Online Polls</a></li>-->
			
			<li ><a href="adm_config.php?d=admin settings"><i class="fa fa-gear"></i> Admin Settings</a></li>
			<li ><a href="adm_arch.php?d=articles"><i class="fa fa-trash-o"></i> Delete Records</a></li>

					</ul>
		</li>


		</ul>

		</div>
		<!-- Left Menu - ENDS -->


</div>

</div>