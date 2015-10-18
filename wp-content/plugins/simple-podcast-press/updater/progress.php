<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/wp-config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/wp-includes/wp-db.php');

$postinserted = get_option('post_inserted');
die($postinserted);

 ?>