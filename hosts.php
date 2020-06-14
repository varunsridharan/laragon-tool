<?php
require __DIR__ . '/config.php';
$alert = new \VSP\Laragon\Modules\Alert();
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
	}

	if ( 'delete' === $_POST['action'] && isset( $_POST['host_id'] ) ) {
		$status = $instance->remove_host( $_POST['host_id'] );
		echo json_encode( array( 'status' => $status ) );
	}
	exit;
}

if ( isset( $_POST['addnewhost'] ) ) {
	$instance = \VSP\Laragon\Modules\Hosts\Parse::instance();
	$issue    = false;

	if ( ! isset( $_POST['host_ip'] ) || isset( $_POST['host_ip'] ) && empty( $_POST['host_ip'] ) ) {
		$alert->danger( 'Host IP Required.' );
		$issue = true;
	}
	if ( ! isset( $_POST['domains'] ) || isset( $_POST['domains'] ) && empty( $_POST['domains'] ) ) {
		$alert->danger( 'Domains Required.' );
		$issue = true;
	}

	if ( false === $issue ) {
		$domain   = $_POST['domains'];
		$host_ip  = $_POST['host_ip'];
		$comments = $_POST['comments'];
		$status   = ( isset( $_POST['new_hosts_status'] ) ) ? true : false;
		$is_added = $instance->add( array(
			'is_disabled' => ( false === $status ) ? true : false,
			'ip'          => $host_ip,
			'domain'      => explode( ',', $domain ),
			'comment'     => trim( $comments ),
			'by_tool'     => true,
		) );
		if ( $is_added ) {
			$alert->success( 'Host Entry Added.' );
			$instance->save();
		}
	}
}

echo $alert->alerts();
echo hosts_file_checks();
template( 'add-new-hosts' );

if ( is_hosts_file_readable() ) {
	$instance = \VSP\Laragon\Modules\Hosts\Parse::instance();
	?>
	<div class="col-xs-12 mb-4 text-right">
		<button type="button" class="btn btn-success" data-toggle="modal" data-target="#add_new_hosts">Add (+)</button>
	</div>

	<table id="hostslisting" class="table table-striped">
		<thead class="thead-dark">
		<tr>
			<th scope="col" style="width:50px;">Status</th>
			<th scope="col" style="width:100px;">Host</th>
			<th scope="col">Domains</th>
			<th scope="col">Comments</th>
			<th scope="col" style="width:50px;">Action</th>
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
				<td>
					<button type="button" class="btn btn-danger host-delete btn-sm" id="<?php echo $id; ?>">Delete
					</button>
				</td>
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