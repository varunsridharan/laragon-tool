<?php
require __DIR__ . '/config.php';

echo hosts_file_checks();
if ( is_hosts_file_readable() ) {
	$instance = \VSP\Laragon\Modules\Hosts\Parse::instance();

	var_dump( $instance->add( array(
		'is_disabled' => true,
		'ip'          => '127.0.0.1',
		'domain'      => array( 'svarun.in', 'sva.run' ),
		'comment'     => 'Personal Comment',
		'by_tool'     => true,
	) ) );

	$instance->save();

	?>
	<table class="table table-striped">
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
