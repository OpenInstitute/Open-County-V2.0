
<div class="col-md-2 padd0_l column-side" role="complimentary">
	<div class="clearfix">
	<div class="affixX">

	<?php if(array_key_exists($comParent, @master::$menuBundle['child'])) { ?>
	<div class="cfs">
	  <div class="cfs-head"><h3>Quick Links</h3></div>
	  <div class="cfs-bodyX">
		<nav class="bs-docs-sidebar hidden-print hidden-sm hidden-xs affixX">
			<?php //echobr($comParent);
			  $nav_county_side = $dispData->buildMenu_Main($com_active, 2, $comParent, 'nav_side', $cid); 
			  echo $nav_county_side;
			?>
		</nav>
		</div>
	</div>
	<?php } ?>

	<?php if($my_redirect <> 'county-contact.php'){ ?>
	<div class="cfs">
	  <div class="cfs-head"><h3>Contacts</h3></div>
	  <div class="cfs-body">
	  <p>
		<?php if(!empty($cProfile['website'])) { ?><i class="fa fa-link"></i> <a href="<?php echo $cProfile['website']; ?>"><?php echo $cProfile['website']; ?></a><br /><?php } ?>
		<?php if(!empty($cProfile['email'])) { ?><i class="icon-envelope2"></i> <a href="mailto:<?php echo $cProfile['email']; ?>"><?php echo $cProfile['email']; ?></a><br /><?php } ?>
		<?php if(!empty($cProfile['twitter'])) { ?><i class="fa fa-twitter"></i> <a href="<?php echo $cProfile['twitter']; ?>">@<?php echo $cProfile['twitter']; ?></a><br /><?php } ?>
		<?php if(!empty($cProfile['telephone'])) { ?><i class="fa fa-phone"></i> <?php echo $cProfile['telephone']; ?><br /><?php } ?>
		<?php if(!empty($cProfile['postaladdress'])) { ?><i class="fa fa-envelope-square"></i>  <?php echo $cProfile['postaladdress']; ?><br /><?php } ?>
	  </p>
	  </div>
	</div>
	<?php } ?>

	<div class="cfs">
	  <div class="cfs-head"><h3>Other Links</h3></div>
	  <div class="cfs-bodyX">
	  <ul id="nav_side" class="nav_side">
		<li id="m14" class=""><a target="blank" href="http://devolutionhub.or.ke/resources/47-counties/<?php echo str_replace(' ','-',trim($cProfile['county'])); ?>">Explore <?php echo $cProfile['county']; ?> County on DevolutionHub.or.ke </a></li>
	  </ul>

	  </div>
	</div>


	</div>
	</div>

</div>
