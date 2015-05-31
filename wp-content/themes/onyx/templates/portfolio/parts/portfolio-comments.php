<?php
global $mkd_options;

//get portfolio comment value
$portfolio_hide_comments = "";
if(get_post_meta(get_the_ID(), "mkd_portfolio-hide-comments", true) == "yes"){
	$portfolio_hide_comments = "yes";
} elseif (isset($mkd_options['portfolio_hide_comments'])){
	$portfolio_hide_comments = $mkd_options['portfolio_hide_comments'];
}

if($portfolio_hide_comments != "yes"){
	comments_template('', true); 
}