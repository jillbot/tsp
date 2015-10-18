<?php


function getRemoteFilesize($url)
{
    $head = array_change_key_case(get_headers($url, 1));

    // content-length of download (in bytes), read from Content-Length: field
    $clen = isset($head['content-length']) ? $head['content-length'] : 0;

	$value = max($clen);

	$key = array_search($value, $clen);


    // cannot retrieve file size, return "-1"
    if (!$clen) {
        return -1;
    }

    
        return $clen[$key]; // return size in bytes
}


$fullPath = $_GET['file'];

if($fullPath) {

	 $fsize = getRemoteFilesize($fullPath); 
    $path_parts = pathinfo($fullPath);
	$path_parts["basename"]; 
	     header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
	    if($fsize) {//checking if file size exist
	      header("Content-length: $fsize");
	    }
	    header("Content-type: application/octet-stream"); 
        header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\"");
   
	
    readfile($fullPath);
    exit;
}
?>