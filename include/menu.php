<nav id="primary-menu">
	<ul>
<?php
$nav_head_main = $dispData->buildMenu_Main($com_active, 1, 0, 'nav_top');
echo $nav_head_main;	
echo '<li class="dropdown dropdown-menu-full"><a href="#">Counties</a>';
echo '<ul class="dropdown-menu mega-menu"><li class="col-sm-4"><a href="county.php?cid=30" >Baringo</a> </li> <li class="col-sm-4"><a href="county.php?cid=36" >Bomet</a> </li> <li class="col-sm-4"><a href="county.php?cid=39" >Bungoma</a> </li> <li class="col-sm-4"><a href="county.php?cid=40" >Busia</a> </li> <li class="col-sm-4"><a href="county.php?cid=28" >Elgeyo-Marakwet</a> </li> <li class="col-sm-4"><a href="county.php?cid=14" >Embu</a> </li> <li class="col-sm-4"><a href="county.php?cid=7" >Garissa</a> </li> <li class="col-sm-4"><a href="county.php?cid=43" >Homa Bay</a> </li> <li class="col-sm-4"><a href="county.php?cid=11" >Isiolo</a> </li> <li class="col-sm-4"><a href="county.php?cid=34" >Kajiado</a> </li> <li class="col-sm-4"><a href="county.php?cid=37" >Kakamega</a> </li> <li class="col-sm-4"><a href="county.php?cid=35" >Kericho</a> </li> <li class="col-sm-4"><a href="county.php?cid=22" >Kiambu</a> </li> <li class="col-sm-4"><a href="county.php?cid=3" >Kilifi</a> </li> <li class="col-sm-4"><a href="county.php?cid=20" >Kirinyaga</a> </li> <li class="col-sm-4"><a href="county.php?cid=45" >Kisii</a> </li> <li class="col-sm-4"><a href="county.php?cid=42" >Kisumu</a> </li> <li class="col-sm-4"><a href="county.php?cid=15" >Kitui</a> </li> <li class="col-sm-4"><a href="county.php?cid=2" >Kwale</a> </li> <li class="col-sm-4"><a href="county.php?cid=31" >Laikipia</a> </li> <li class="col-sm-4"><a href="county.php?cid=5" >Lamu</a> </li> <li class="col-sm-4"><a href="county.php?cid=16" >Machakos</a> </li> <li class="col-sm-4"><a href="county.php?cid=17" >Makueni</a> </li> <li class="col-sm-4"><a href="county.php?cid=9" >Mandera</a> </li> <li class="col-sm-4"><a href="county.php?cid=10" >Marsabit</a> </li> <li class="col-sm-4"><a href="county.php?cid=12" >Meru</a> </li> <li class="col-sm-4"><a href="county.php?cid=44" >Migori</a> </li> <li class="col-sm-4"><a href="county.php?cid=1" >Mombasa</a> </li> <li class="col-sm-4"><a href="county.php?cid=21" >Murang\'a</a> </li> <li class="col-sm-4"><a href="county.php?cid=47" >Nairobi</a> </li> <li class="col-sm-4"><a href="county.php?cid=32" >Nakuru</a> </li> <li class="col-sm-4"><a href="county.php?cid=29" >Nandi</a> </li> <li class="col-sm-4"><a href="county.php?cid=33" >Narok</a> </li> <li class="col-sm-4"><a href="county.php?cid=46" >Nyamira</a> </li> <li class="col-sm-4"><a href="county.php?cid=18" >Nyandarua</a> </li> <li class="col-sm-4"><a href="county.php?cid=19" >Nyeri</a> </li> <li class="col-sm-4"><a href="county.php?cid=25" >Samburu</a> </li> <li class="col-sm-4"><a href="county.php?cid=41" >Siaya</a> </li> <li class="col-sm-4"><a href="county.php?cid=6" >Taita-Taveta</a> </li> <li class="col-sm-4"><a href="county.php?cid=4" >Tana River</a> </li> <li class="col-sm-4"><a href="county.php?cid=13" >Tharaka-Nithi</a> </li> <li class="col-sm-4"><a href="county.php?cid=26" >Trans-Nzoia</a> </li> <li class="col-sm-4"><a href="county.php?cid=23" >Turkana</a> </li> <li class="col-sm-4"><a href="county.php?cid=27" >Uasin Gishu</a> </li> <li class="col-sm-4"><a href="county.php?cid=38" >Vihiga</a> </li> <li class="col-sm-4"><a href="county.php?cid=8" >Wajir</a> </li> <li class="col-sm-4"><a href="county.php?cid=24" >West Pokot</a> </li></ul>';
echo '</li>';		
?>
	</ul>
	<!-- Top Search
	============================================= -->
	<div id="top-search">
		<a href="#" id="top-search-trigger"><i class="icon-search3"></i><i class="icon-line-cross"></i></a>
		<form action="search.html" method="get">
			<input type="text" name="q" class="form-control" value="" placeholder="Type &amp; Hit Enter..">
		</form>
	</div>
	<!-- #top-search end -->
</nav>