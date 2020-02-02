<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="../index.php">Home</a></li>
		<?php
		$uri          = $_SERVER['REQUEST_URI'];
		$uri          = explode( '/', $uri );
		$last_element = end( $uri );
		foreach ( explode( '/', $_SERVER['REQUEST_URI'] ) as $index => $page ) {
			if ( 0 === $index ) {
				continue;
			}
			$page_new = preg_replace( '/\b.php\b/', '', preg_replace( '/\b-\b/', ' ', $page ) );
			if ( $page === $last_element ) {
				$item = '<li class="breadcrumb-item active" aria-current="page">' . ucwords( $page_new ) . '</li>';
			} else {
				$url  = 'view-' . $page . '.php';
				$item = '<li class="breadcrumb-item"><a href="' . $url . '">' . ucwords( $page_new ) . '</a></li>';
			}
			echo $item;
		}
		?>
	</ol>
</nav>
