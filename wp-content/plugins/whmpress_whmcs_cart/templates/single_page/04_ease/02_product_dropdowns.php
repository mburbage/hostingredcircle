<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );?>

<div style="display: none !important;">
	<?php echo wcop_sp_render_products_dropdown('', $pids, $gids, 'yes', '_domains'); ?>
</div>
<div style="display: none !important;">
	<?php echo wcop_sp_render_products_dropdown('', $pids, $gids, 'no', '_no_domains'); ?>
</div>
<div style="display: none !important;">
	<?php echo wcop_sp_render_products_dropdown('', $pids, $gids, '', '_full'); ?>
</div>



