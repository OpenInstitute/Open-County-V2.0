<h4><a href="#"><i class="icon-bulb"></i></a> &nbsp; SUGGEST A DATASET</h4>
<p>Suggest a dataset that you would like to see featured in Open County platform</p>
<!-- Upload form -->
<form class="nobottommargin rwdvalid" id="template-contactform" name="template-contactform" action="posts.php" method="post" enctype="multipart/form-data">

	<div class="form-process"></div>

	<div class="col_full">
		<label for="template-contactform-name">Name <small>*</small></label>
		<input type="text" id="template-contactform-name" name="template-contactform-name" value="" class="sm-form-control required" />
	</div>

	<div class="col_full">
		<label for="template-contactform-email">Email <small>*</small></label>
		<input type="email" id="template-contactform-email" name="template-contactform-email" value="" class="required email sm-form-control" />
	</div>
	<!--ATTN: Removed the subject input we will prepend it on form send-->
	<div class="col_full">
		<label for="template-contactform-service">Type of Dataset</label>
		<select id="template-contactform-service" name="template-contactform-service" class="sm-form-control required">
			<option value="">-- Select One --</option>
			<option value="Text/CSV">Text/CSV</option>
			<option value="Excel (XLXS)">Excel (XLXS)</option>
			<option value="PDF">PDF</option>
			<option value="RDF">RDF</option>
		</select>
	</div>

	<div class="col_full">
		<label for="template-contactform-message">Upload Dataset <small>*</small></label>
		<input type="file" id="template-contactform-file" name="template-contactform-file" value="" class="required sm-form-control" />
	</div>

	<div class="col_full">
		<label for="template-contactform-message">Message/Comment/Suggestion <small>*</small></label>
		<textarea class="required sm-form-control" id="template-contactform-message" name="template-contactform-message" rows="6" cols="30"></textarea>
	</div>

	<div class="col_full hidden">
		<input type="text" id="template-contactform-botcheck" name="template-contactform-botcheck" value="" class="sm-form-control" />
	</div>

	<div class="col_full">
		<button name="submit" type="submit" id="submit-button" tabindex="5" value="Submit" class="button button-3d nomargin">Submit Suggestion</button>
	</div>

</form>
<!-- End of upload form -->