$( function() {

	/**
	 * Hosts Module Related Javascript.
	 * @type {jQuery|HTMLElement}
	 */

	var allcheckbox = $( 'table#hostslisting input[type=checkbox]' );
	var hostdelete  = $( 'table#hostslisting button.host-delete' );

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

	hostdelete.on( 'click', function() {
		var btn = $( this );
		hostdelete.attr( 'disabled', 'disabled' );
		jQuery.ajax( {
			url: location.href,
			method: 'POST',
			data: {
				action: "delete",
				host_id: $( this ).attr( 'id' )
			}
		} ).done( function( res ) {
			var host = JSON.parse( res );
			if( typeof host.status !== 'undefined' ) {
				if( true === host.status ) {
					btn.parent().parent().remove();
				}
			}
		} ).always( function() {
			hostdelete.removeAttr( 'disabled' );
		} );
	} );

	$( '.modal' ).on( 'click', '.addnew-hosts-entry', function() {
		var $data = {
			action: "addnew",
			ip: $( '.modal' ).find( '#host_ip' ).val(),
			domains: $( '.modal' ).find( '#domains' ).val(),
			comments: $( '.modal' ).find( '#comments' ).val(),
			status: $( '.modal' ).find( '#new_hosts_status' ).prop( 'checked' ),
		};

	} );


	/**
	 * Add VHosts
	 */
	var vhostdomains = $( "#vhostdomains" );
	var x            = 0;
	$( '.vhostdomains_add' ).click( function( e ) {
		e.preventDefault();
		if( x < 30 ) {
			x++; //input field increment
			var apacheFields = '<div class="input-group col-md-12 mb-2">' +
				'<div class="input-group-prepend">' +
				'<span class="input-group-text">Alias</span>' +
				'</div>' +
				'<input type="text" class="form-control" name="vhosts[vhostdomains][' + x + ']" id="vhostdomains_' + x + '" placeholder="Enter Domain" required>' +
				'<div class="input-group-append"><span class="input-group-text"><a class="vhostdomains_remove" href="javascript:void(0);">Remove</a></span>' +
				'</div></div>';
			$( vhostdomains ).append( apacheFields );
		}
	} );
	$( vhostdomains ).on( "click", ".vhostdomains_remove", function( e ) {
		e.preventDefault();
		$( this ).parent().parent().parent().remove();
		x--;
	} );

	/**
	 * V Host Lists.
	 */

	$( 'body' ).on( 'click', '.change-vhost-status', function() {
		var $id     = $( this ).attr( 'data-hostid' ),
			$type   = $( this ).attr( 'data-type' ),
			$status = $( this ).prop( 'checked' );

		var $data = {
			action: "vhost-update-status",
			id: $id,
			type: $type,
			status: $status,
		};

		jQuery.ajax( {
			url: 'vhost-actions.php',
			method: "POST",
			data: {
				action: "vhost-update-status",
				id: $id,
				type: $type,
				status: $status,
			},
		} );
		//$( '.change-vhost-status' ).attr( 'disabled', 'disabled' );
	} );

	$( 'body' ).on( 'click', '.restore-vhost-config', function( e ) {
		e.preventDefault();
		var status = window.confirm( 'Are you sure want to restore config ? \n\r' +
			'any custom changes will be deleted' );
		if( status ) {
			location.href = $( this ).attr( 'href' );
		}
	} );
	$( 'body' ).on( 'click', '.delete-vhost', function( e ) {
		e.preventDefault();
		var status = window.confirm( 'Are you sure want to delete Vhost ?' );
		if( status ) {
			location.href = $( this ).attr( 'href' );
		}
	} );

	$( '[data-toggle="tooltip"]' ).tooltip();
} );