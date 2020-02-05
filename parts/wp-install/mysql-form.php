<div class="jumbotron pb-4 pt-3 mb-0 mt-3" style="background:none; border:1px solid #ccc;">
	<h3 class="mb-1 mt-1">MySQL</h3>
	<hr class="my-2">

	<div class="form-row">
		<div class="input-group col-md-12 mb-2">
			<div class="input-group-prepend"><span class="input-group-text">Host</span></div>
			<input type="text" class="form-control" name="wpinstall[mysql][host]"
				   value="<?php echo get_option( 'mysql/host' ); ?>" placeholder="localhost">
		</div>
	</div>

	<div class="form-row">
		<div class="input-group col-md-12 mb-2">
			<div class="input-group-prepend"><span class="input-group-text">User</span></div>
			<input type="text" class="form-control" name="wpinstall[mysql][user]"
				   value="<?php echo get_option( 'mysql/username' ); ?>" placeholder="root">
		</div>
	</div>


	<div class="form-row">
		<div class="input-group col-md-12 mb-2">
			<div class="input-group-prepend"><span class="input-group-text">Password</span></div>
			<input type="text" class="form-control" name="wpinstall[mysql][password]"
				   value="<?php echo get_option( 'mysql/password' ); ?>">
		</div>
	</div>
</div>