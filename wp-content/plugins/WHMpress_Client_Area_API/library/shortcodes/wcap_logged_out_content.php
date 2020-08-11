<?php
$content = (empty($content)) ? '' : $content;
if (!whcom_is_client_logged_in()) {
	echo $content;
}

