<?php //if(@$dir == ''){ } else { $redirect = 'product.php?pd='.$_REQUEST['product']; }
$redirect = $_SERVER['REQUEST_URI']; //REF_ACTIVE_URL; ?>
<a id="fm-feedback"></a>
<h4 class="txtgray">Send Feedback or Enquiries</h4>
<p>To make an Enquiry and/or Suggestion, please fill in the Form below:-</p>
<?php  ?>




<div >
<form class="rwdform rwdfull rwdvalid"  action="posts.php" method="post" name="feedback" id="feedback">

  <div class="col_full">
    <label class="col-md-3 label-control padd0_r" for="fullname">Full Name</label>
    <input name="fullname" id="fullname" type="text" class="sm-form-control  col-md-9 required" value="" size="8" tabindex="1" placeholder="Full Name" >
   
  </div>
  
  <div class="col_full">
    <label class="col-md-3 label-control" for="email" >Email</label>
    <input id="email" name="email" type="email" spellcheck="false" maxlength="50" tabindex="2" class="sm-form-control col-md-9 required" placeholder="Email" > 
    
  </div>
  
  <div class="col_full">
    <label class="col-md-3 label-control" for="phone">Phone</label>
    <input id="phone" name="phone" type="text"  class="sm-form-control col-md-9 mask_phoneX" maxlength="50" tabindex="3" placeholder="e.g. +254 777 123456">
  </div>
  

  <div class="col_full">
    <label class="col-md-3 label-control" for="details">Message</label>
    <textarea id="details" name="details"  class="sm-form-control col-md-9 required" spellcheck="true" tabindex="4" placeholder="Message"></textarea>
  </div>

   <div class="col_full">
   	<label class="col-md-3 label-control">&nbsp;</label>
    <div class=" col-md-9 padd10_0">
    <?php include("includes/form.captchajx.php"); ?>
    </div>
  </div>
  
  <div class="col_full">
    <label class="col-md-3 label-control">&nbsp;</label>
    <div class="col-md-9 nopadd">
    	<button type="input" name="submit" value="Submit" class="btn btn-success btn-icon" tabindex="7" style="width:120px"> Submit</button>
		<input name="formname" type="hidden" value="feedback" />
		<input name="formtype" type="hidden" value="Feedback Post" />
		<input name="nah_snd" id="nah_snd" type="text" />  
		<input name="redirect" type="hidden" value="<?php echo $redirect; ?>" />
    </div>
  </div>
  
<div>
	
</div>
</form>


</div>
  <p>&nbsp;</p>