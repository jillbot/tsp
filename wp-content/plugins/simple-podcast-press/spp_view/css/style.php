<?php
global $wpdb;
$fancy_settings		=	$wpdb->get_results("SELECT * FROM fancy_settings");
//echo "<pre>"; print_r($wpdb); exit;
$fixed_position		=	$fancy_settings[0]->fixed_position;
$position			=	'';

if($fixed_position=='l'){
	$position		=	'left: 20px;';
}else if($fixed_position=='r'){
	$position		=	'right: 20px;';
}

echo '<style type="text/css">
imgA1 { position:absolute; top: 25px; left: 25px; z-index: 1; } 
.imgB1 { position:absolute; top: 25px; left: 25px; z-index: 3; } 
.containerdiv { float: left; position: relative;overflow:hidden }  
.cornerimage { position: absolute; top: -39px; '.$position.'}
.cornerimage:hover { position: absolute; top: 0px; '.$position.'} 
</style>';
//	.containerdiv { float: left; position: relative;overflow:hidden } 
?>


