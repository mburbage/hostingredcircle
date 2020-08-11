<?php global $wpdb;
if ( isset( $_GET["clear_logs"] ) ) {
	$Q = "DELETE FROM `" . whmp_get_logs_table_name() . "`";
	$wpdb->Query( $Q );
}
?>
<div class="wrap">
	<button onclick="ClearLogs()" style="float: right;" type="button" class="button">Clear Logs</button>
	<h2>Domain Search Logs</h2>
	<?php
	$paged = isset( $_GET["paged"] ) ? $_GET["paged"] : "1";
	if ( ! is_numeric( $paged ) || $paged < 1 ) {
		$paged = "1";
	}
	$Q         = "SELECT SQL_CALC_FOUND_ROWS * FROM `" . whmp_get_logs_table_name() . "` ORDER BY `id` DESC";
	$page_size = "30";
	$range     = "3";
	$offset    = ( $paged - 1 ) * $page_size;
	$Q .= " LIMIT $offset, $page_size";
	$rows          = $wpdb->get_results( $Q );
	$total_records = $wpdb->get_var( "SELECT FOUND_ROWS()" );
	$pages         = ceil( $total_records / $page_size );
	
	if ( $paged <= $range ) {
		$start = 1;
	} else {
		$start = $paged - $range;
	}
	$end = $start + $range + $range;
	if ( $pages < $end ) {
		$end = $pages;
	}
	
	$from = ( ( $paged * $page_size ) - $page_size ) + 1;
	if ( $total_records == 0 ) {
		$from = 0;
	}
	$to = $page_size * $paged;
	if ( $to > $total_records ) {
		$to = $total_records;
	}
	?>
	
	<table class="fancy" style="width: 100%;">
		<thead>
		<tr>
			<td colspan="4">
                    <span style="float: right;"><?php echo esc_html_x( 'Page','admin', 'whmpress' ) . $paged; ?> of <?php echo $pages ?>
	                    -
	                    <?php for ( $x = $start; $x <= $end; $x ++ ): ?>
		                    <a class="button" href="?page=whmp-search-logs&paged=<?php echo $x ?>"><?php echo $x ?></a>
	                    <?php endfor; ?>
                    </span>
				<?php echo esc_html_x( 'Total Records:','admin', 'whmpress' ) . $total_records; ?>
			</td>
		</tr>
		<tr>
			<th><?php echo esc_html_x( 'Search Term','admin', 'whmpress' ); ?></th>
			<th><?php echo esc_html_x( 'Domain Available','admin', 'whmpress' ); ?></th>
			<th><?php echo esc_html_x( 'Search Time','admin', 'whmpress' ); ?></th>
			<th><?php echo esc_html_x( 'From IP','admin', 'whmpress' ); ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ( $rows as $row ): ?>
			<tr>
				<td><?php echo $row->search_term ?></td>
				<td><?php echo $row->domain_available ? "Yes" : "No" ?></td>
				<td><?php echo date( get_option( "date_format" ) . " " . get_option( "time_format" ), strtotime( $row->search_time ) ) ?></td>
				<td><a target="_blank"
				       href="https://geoiptool.com/en/?IP=<?php echo $row->search_ip; ?>"><?php echo $row->search_ip; ?></a>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>

<script>
	function ClearLogs ()
	{
		if (!confirm("Are you sure you want to remove all search logs?\n\nCaution! This action is not undoable.")) return;
		window.location.replace("admin.php?page=whmp-search-logs&clear_logs");
	}
</script>