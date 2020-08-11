<?php
$this->whmcs_logout();
whcom_reset_cart();
whcom_client_log_out();
?>
<script>
	set_url_parameter_value( "whmpca", "logged_out" );
	LoadData();
</script>
