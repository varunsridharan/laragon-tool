<div class="jumbotron pb-4 pt-3 mb-0 mt-3" style="background:none; border:1px solid #ccc;">
	<h3 class="mb-1 mt-1">Database</h3>
	<hr class="my-2">

	<div class="form-row">
		<div class="input-group col-md-12 mb-2">
			<div class="input-group-prepend"><span class="input-group-text">Database Name</span></div>
			<input type="text" class="form-control" name="wpinstall[database][name]" placeholder="wp_<?php echo time(); ?>">
		</div>
	</div>

	<div class="form-row">
		<div class="input-group col-md-12 mb-2">
			<div class="input-group-prepend"><span class="input-group-text">Table Prefix</span></div>
			<input type="text" class="form-control" name="wpinstall[database][prefix]" value="wp_">
		</div>
	</div>

</div>