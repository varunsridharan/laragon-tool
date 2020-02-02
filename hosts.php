<?php
require __DIR__ . '/config.php';

if ( isset( $_POST['action'] ) ) {
	$instance = \VSP\Laragon\Modules\Hosts\Parse::instance();
	if ( 'update-status' === $_POST['action'] && isset( $_POST['host_id'] ) && isset( $_POST['status'] ) ) {
		$new_id = $instance->update_hosts_data( $_POST['host_id'], array(
			'is_disabled' => ( 'false' === $_POST['status'] ),
		) );

		if ( false !== $new_id ) {
			$instance->save();
			echo json_encode( array( 'host_id' => $new_id ) );
		}
		exit;
	}
}

echo hosts_file_checks();

if ( is_hosts_file_readable() ) {
	$instance = \VSP\Laragon\Modules\Hosts\Parse::instance();
	?>
	<table id="hostslisting" class="table table-striped">
		<thead class="thead-dark">
		<tr>
			<th scope="col" style="width:50px;">Status</th>
			<th scope="col">Host</th>
			<th scope="col">Domains</th>
			<th scope="col">Comments</th>
			<th scope="col">Action</th>
		</tr>
		</thead>
		<tbody>
		<?php
		foreach ( $instance->get_list() as $id => $host ) {
			$is_enabled = ( true === $host['is_disabled'] ) ? false : true;
			$enh        = ( true === $is_enabled ) ? 'checked' : '';
			?>
			<tr>
				<td>
					<div class="custom-control custom-switch">
						<input type="checkbox" class="custom-control-input" id="<?php echo $id; ?>" <?php echo $enh; ?>>
						<label class="custom-control-label" for="<?php echo $id; ?>"></label>
					</div>
				</td>
				<td><?php echo $host['ip']; ?></td>
				<td><?php echo implode( '<br/>', $host['domain'] ); ?></td>
				<td><?php echo trim( ltrim( $host['comment'], '#' ) ); ?></td>
				<td> Edit / Delete</td>
			</tr>
			<?php
		}
		?>
		</tbody>
	</table>

	<?php
}

template( 'footer' );
?>

<script>
	$( function() {
		var allcheckbox = $( 'input[type=checkbox]' );
		allcheckbox.on( 'click', function() {
			var btn = $( this );
			allcheckbox.attr( 'disabled', 'disabled' );
			jQuery.ajax( {
				url: location.href,
				method: 'POST',
				data: {
					host_id: $( this ).attr( 'id' ),
					action: "update-status",
					status: $( this ).prop( 'checked' ),
				}
			} ).done( function( res ) {
				var host = JSON.parse( res );
				if( typeof host.host_id !== 'undefined' ) {
					btn.attr( 'id', host.host_id );
					btn.parent().find( 'label' ).attr( 'for', host.host_id );
				}
			} ).always( function() {
				allcheckbox.removeAttr( 'disabled' );
			} );
		} );
	} )

</script>
