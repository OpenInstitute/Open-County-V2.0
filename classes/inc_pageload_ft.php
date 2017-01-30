<?php 

/**********************************************************
@BEGIN:PAGE LOAD TIMING
***********************************************************/

$mtime = microtime(); 
$mtime = explode(" ", $mtime); 
$mtime = $mtime[1] + $mtime[0]; 
$endtime = $mtime; 

$totaltime = ($endtime - $starttime); 
echo '<div class="txt10 txtcenter" style="background:#F6F6F6;">Page created in <b>' .$totaltime. '</b> seconds.</div>'; 

/**********************************************************
@END:PAGE LOAD TIMING
***********************************************************/
?>
