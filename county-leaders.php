<?php include 'zhead.php'; ?>



<!-- Document Wrapper
============================================= -->
<div id="wrapper" class="clearfix">

	<!-- Header
	============================================= -->
	<?php include 'include/header.php'; ?>
	<!-- #header end -->
	<!-- Content
	============================================= -->
	<section id="content">
		<div class="container clearfix">
		<?php include 'include/county-nav.php'; ?>



		<div class="clearfix"></div>
		
		<!-- county-side-nav
		============================================= -->
		<?php include 'includes/nav_county_side.php'; ?>
		<!-- county-side-nav :: END -->
		
		
		<div class="col-md-9">
		
			<div class="clearfix">
				<div><h3><?php echo $cProfile['county']; ?> County Leadership</h3></div>
				
				<div>
<?php 
					
$cLeaders = $dispOc->get_countyLeaders($cid); //displayArray($cLeaders['_Mp']);
						
$cont_display = '';
$cont_profiles = array();

foreach($cLeaders as $ldcode => $ldArr)	
{	
	if($ldcode <> '_Mca' and $ldcode <> '_Mp' and $ldcode <> 'ward' and $ldcode <> 'constituency')
	{
		$contArr = current($ldArr);
		$cont_id 	    = $contArr['leader_id'];
		$cont_name 	 	= $contArr['leader_name'];
		$cont_role 	 	= $contArr['type_title'];
		$cont_role_code	= $contArr['type_code'];
		$cont_seo 	   	= trim($cont_name);
		$cont_avatar_name = $cProfile['county'].$contArr['avatar'];	
		$cont_avatar	= DISP_AVATARS.$cont_avatar_name;	
		
		if (!file_exists(UPL_AVATARS.$cont_avatar_name)) { $cont_avatar = ERR_NO_AVATAR; }
		
		$cont_link	  	= ''; //' data-href="ajforms.php?d=vprofile&item='.$cont_id.'"  rel="modal:open" ';


		$image_disp		= "<img src=\"".$cont_avatar."\" style=\"max-width:300px; max-height:300px;\" >";
		$cont_pic_disp  = '<span class="carChopa profile_pic"><span class="bitChopaWrap">'.$image_disp.'</span></span>';

		$submenu_display = '<span>'.$cont_role.'</span>';

		$cont_profiles[] = '<li><div class="block equalized"><a '.$cont_link.' class="menu-column-main">'.$cont_pic_disp.' '.$cont_name.'</a><br /><div class="menu-column-subs">'.$submenu_display.'</div></div></li>';
	}
}
	
	echo '<div class="wrap_gallery padd20_0"><ul id="" class="column menu-column">';
	echo implode('',$cont_profiles); 
	echo '</ul></div>';
					?>
					<div class="clearfix"></div>
				</div>
			</div>

			<div class="clearfix">
				<div class="padd20"></div> 
				<div><h4><?php //echo $cProfile['county']; ?> County Assembly Members</h4></div>
				
				<div>
				<div class="tab-pane active" id="wrap_mcas">
                   
                    <div class="row">                       
                      <div class="col-md-3 columns">
                        <nav class="nav-sidebar">
                          <ul class="nav tabs">
                          	<?php
							  if(count($cLeaders['constituency']) > 0){
								  foreach($cLeaders['constituency'] as $cConst){
									  echo '<li class="level2" cid="'.$cid.'" Cons="'.$cConst.'" id="'.clean_alphanum($cConst).'"><i class="pointer"></i>'.$cConst.'</li>';
								  }								  
							  }
							  ?>
                            	<li class="level2" cid="<?php echo $cid; ?>" Cons="Nominated" id="Nominated"><i class="pointer"></i>Nominated</li>
								
                          </ul>
                        </nav>
                      </div>
                      <div class="col-md-9 columns">
                        <div class="tab-content">
                          	<div class="tab-pane active text-style" id="mcaData"></div>
                        </div>
                      </div>
                    </div>
                    
                    
                  </div>					
				</div>
				
			</div>
			
				
			<div class="clearfix">
				<div class="padd20"></div> 
				<div><h4><?php //echo $cProfile['county']; ?> Members of Parliament</h4></div>
				<div>
						
						<table class="table table-condensed table-hover">
							<thead>
							  <th>Name</th>
							  <th>Constituency</th>
							  <th>Party</th>
							</thead>
							<tbody>
							<?php
							foreach($cLeaders['_Mp'] as $cLmp){

								echo '<tr>
									  <td>'. $cLmp['leader_name'] .'</td>
									  <td>'. $cLmp['constituency'] .'</td>
									  <td>'. $cLmp['party'] .'</td>
									</tr>';
								 } 
							?>
							</tbody>
						</table>
							
				</div>				
			</div>
						
			<div class="clearfix"><div class="padd10"></div> </div>

		</div>



		</div>
	</section><!-- #content end -->

	<!-- Footer
	============================================= -->
	<?php include 'include/footer.php'; ?>
	<!-- #footer end -->

</div><!-- #wrapper end -->

	<!-- Go To Top


<?php include 'zfoot.php'; ?>

	
</body>
</html>