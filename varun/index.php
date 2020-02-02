<?php
/**
 * @author Karthik Kotha <karthik.kotha@gmail.com>
 * @copyright 2020 Karthik Kotha
 * @license GPLV3 Or Greater (https://www.gnu.org/licenses/gpl-3.0.txt)
 */
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="./assets/css/bootstrap.min.css">
	<title>Hello, world!</title>
</head>
<body>
<?php include './templates/navbar.php'; ?>
<div class="container mb-5 mt-5">
	<form id="rootForm" method="post" class="needs-validation" novalidate>
		<div class="form-row">
			<div class="input-group col-md-12 mb-2">
				<div class="input-group-prepend">
					<span class="input-group-text">Root</span>
				</div>
				<input type="text" class="form-control" name="rootPath" id="rootPath" placeholder="Laragon install path"
					   required>
			</div>
		</div>
		<div class="form-row">
			<div class="input-group col-md-12 mb-2">
				<div id="docRootPrepend" class="input-group-prepend">
					<span class="input-group-text">Document Root</span>
				</div>
				<input type="text" class="form-control" name="documentRoot" id="documentRoot"
					   placeholder="Location of PHP / HTML files" required>
			</div>
		</div>
		<div class="form-row">
			<div class="input-group col-md-12 mb-2">
				<div id="docRootPrepend" class="input-group-prepend">
					<span class="input-group-text">File Prefix</span>
				</div>
				<input type="text" class="form-control" name="filePrefix" id="filePrefix"
					   placeholder="V-Host File Prefix" required>
			</div>
		</div>
		<div class="form-row">
			<div class="col-md-12 mb-3">
				<div class="custom-control custom-switch">
					<input type="checkbox" class="custom-control-input" id="autoAddHost" name="autoAddHost" required>
					<label class="custom-control-label" for="autoAddHost">Auto-add Host</label>
				</div>
			</div>
		</div>
		<div class="jumbotron pb-4 pt-3 mb-2" style="background:none; border:1px solid #ccc;">
			<h3 class="mb-1 mt-1">Apache</h3>
			<hr class="my-2">
			<div class="form-row">
				<div class="input-group col-md-12 mb-2">
					<div class="input-group-prepend">
						<span class="input-group-text">Path</span>
					</div>
					<input type="text" class="form-control" name="apachePath" id="apachePath"
						   placeholder="Enter the path"
						   required>
				</div>
			</div>
			<div class="form-row">
				<div class="input-group col-md-12 mb-2">
					<div class="input-group-prepend">
						<span class="input-group-text">Site Enabled</span>
					</div>
					<input type="text" class="form-control" name="apacheSiteEnabled" id="apacheSiteEnabled"
						   placeholder="Enter the site enabled" required>
				</div>
			</div>
			<div class="form-row" id="apacheRepeating">
				<div class="input-group col-md-12 mb-2">
					<div class="input-group-prepend">
						<span class="input-group-text">Alias</span>
					</div>
					<input type="text" class="form-control" name="apacheAlias[0]" id="apacheAlias_0"
						   placeholder="Enter Alias" required>
					<div class="input-group-append">
						<span class="input-group-text"><a class="apache_add" href="javascript:void(0);">Add</a></span>
					</div>
				</div>
			</div>
			<h4 class="mb-1 mt-3">Ports</h4>
			<hr class="my-2">
			<div class="form-row">
				<div class="input-group col-md-6 mb-2">
					<div class="input-group-prepend">
						<span class="input-group-text">HTTP Port Number</span>
					</div>
					<input type="text" class="form-control" name="apacheHttpPort" id="apacheHttpPort"
						   placeholder="Enter the HTTP port number" required>
				</div>
				<div class="input-group col-md-6 mb-2">
					<div class="input-group-prepend">
						<span class="input-group-text">HTTPS Port Number</span>
					</div>
					<input type="text" class="form-control" name="apacheHttpsPort" id="apacheHttpsPort"
						   placeholder="Enter the HTTPS port number" required>
				</div>
			</div>
		</div>
		<div class="jumbotron pb-4 pt-3 mb-0" style="background:none; border:1px solid #ccc;">
			<h3 class="mb-1 mt-1">Nginx</h3>
			<hr class="my-2">
			<div class="form-row">
				<div class="input-group col-md-12 mb-2">
					<div class="input-group-prepend">
						<span class="input-group-text">Path</span>
					</div>
					<input type="text" class="form-control" name="nginxPath" id="nginxPath"
						   placeholder="Enter the path"
						   required>
				</div>
			</div>
			<div class="form-row">
				<div class="input-group col-md-12 mb-2">
					<div class="input-group-prepend">
						<span class="input-group-text">Site Enabled</span>
					</div>
					<input type="text" class="form-control" name="nginxSiteEnabled" id="nginxSiteEnabled"
						   placeholder="Enter the site enabled" required>
				</div>
			</div>
			<div class="form-row" id="nginxRepeating">
				<div class="input-group col-md-12 mb-2">
					<div class="input-group-prepend">
						<span class="input-group-text">Alias</span>
					</div>
					<input type="text" class="form-control" name="nginxAlias[0]" id="nginxAlias_0"
						   placeholder="Enter Alias" required>
					<div class="input-group-append">
						<span class="input-group-text"><a class="nginx_add" href="javascript:void(0);">Add</a></span>
					</div>
				</div>
			</div>
			<h4 class="mb-1 mt-3">Ports</h4>
			<hr class="my-2">
			<div class="form-row">
				<div class="input-group col-md-6 mb-2">
					<div class="input-group-prepend">
						<span class="input-group-text">HTTP Port Number</span>
					</div>
					<input type="text" class="form-control" name="nginxHttpPort" id="nginxHttpPort"
						   placeholder="Enter the HTTP port number" required>
				</div>
				<div class="input-group col-md-6 mb-2">
					<div class="input-group-prepend">
						<span class="input-group-text">HTTPS Port Number</span>
					</div>
					<input type="text" class="form-control" name="nginxHttpsPort" id="nginxHttpsPort"
						   placeholder="Enter the HTTPS port number" required>
				</div>
			</div>
		</div>
		<button type="submit" class="btn btn-primary mt-3" name="submit">Submit</button>
	</form>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
		integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
		crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
		integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
		crossorigin="anonymous"></script>
<script src="./assets/js/bootstrap.min.js"></script>
<script>
	$( document ).ready( function() {
		$( '#rootPath' ).on( 'blur', function() {
			if( $( this ).val() == '' ) {
				$( '#docRootPrepend' ).html( '<span class="input-group-text">Document Root</span>' );
			} else {
				$( '#docRootPrepend' )
					.html( '<span class="input-group-text">Document Root</span><span class="input-group-text" id="documentRoot">' + $( this )
						.val() + '</span>' );
			}
		} );

		var apacheMaxFields = 30;
		var apacheWrapper   = $( "#apacheRepeating" );
		var apache_add      = $( ".apache_add" );
		var x               = 0;
		$( apache_add ).click( function( e ) {
			e.preventDefault();
			//Check maximum allowed input fields
			if( x < apacheMaxFields ) {
				x++; //input field increment
				var apacheFields = '<div class="input-group col-md-12 mb-2"><div class="input-group-prepend"><span class="input-group-text">Alias</span></div><input type="text" class="form-control" name="apacheAlias[' + x + ']" id="apacheAlias_' + x + '" placeholder="Enter Alias" required><div class="input-group-append"><span class="input-group-text"><a class="apache_remove" href="javascript:void(0);">Remove</a></span></div></div>';
				$( apacheWrapper ).append( apacheFields );
				feather.replace();
			}
		} );
		$( apacheWrapper ).on( "click", ".apache_remove", function( e ) {
			e.preventDefault();
			$( this ).parent().parent().parent().remove();
			x--;
		} );

		var nginxMaxFields = 30;
		var nginxWrapper   = $( "#nginxRepeating" );
		var nginx_add      = $( ".nginx_add" );
		var x              = 0;
		$( nginx_add ).click( function( e ) {
			e.preventDefault();
			//Check maximum allowed input fields
			if( x < nginxMaxFields ) {
				x++; //input field increment
				var nginxFields = '<div class="input-group col-md-12 mb-2"><div class="input-group-prepend"><span class="input-group-text">Alias</span></div><input type="text" class="form-control" name="apacheAlias[' + x + ']" id="apacheAlias_' + x + '" placeholder="Enter Alias" required><div class="input-group-append"><span class="input-group-text"><a class="nginx_remove" href="javascript:void(0);">Remove</a></span></div></div>';
				$( nginxWrapper ).append( nginxFields );
				feather.replace();
			}
		} );
		$( nginxWrapper ).on( "click", ".nginx_remove", function( e ) {
			e.preventDefault();
			$( this ).parent().parent().parent().remove();
			x--;
		} );
	} );
	// Example starter JavaScript for disabling form submissions if there are invalid fields
	( function() {
		'use strict';
		window.addEventListener( 'load', function() {
			// Fetch all the forms we want to apply custom Bootstrap validation styles to
			var forms      = document.getElementsByClassName( 'needs-validation' );
			// Loop over them and prevent submission
			var validation = Array.prototype.filter.call( forms, function( form ) {
				form.addEventListener( 'submit', function( event ) {
					if( form.checkValidity() === false ) {
						event.preventDefault();
						event.stopPropagation();
					}
					form.classList.add( 'was-validated' );
				}, false );
			} );
		}, false );
	} )();
</script>
</body>
</html>
