<?php

//Carousels

$mkdCarousels = new MikadoMetaBox("carousels", "Carousels");
$mkdFramework->mkdMetaBoxes->addMetaBox("carousels",$mkdCarousels);

	$mkd_carousel_image = new MikadoMetaField("image","mkd_carousel-image","","Carousel Image","Choose carousel image (min width needs to be 215px)");
	$mkdCarousels->addChild("mkd_carousel-image",$mkd_carousel_image);

	$mkd_carousel_hover_image = new MikadoMetaField("image","mkd_carousel-hover-image","","Carousel Hover Image","Choose carousel hover image (min width needs to be 215px)");
	$mkdCarousels->addChild("mkd_carousel-hover-image",$mkd_carousel_hover_image);

	$mkd_carousel_item_link = new MikadoMetaField("text","mkd_carousel-item-link","","Link","Enter the URL to which you want the image to link to (e.g. http://www.example.com)");
	$mkdCarousels->addChild("mkd_carousel-item-link",$mkd_carousel_item_link);

	$mkd_carousel_item_target = new MikadoMetaField("selectblank","mkd_carousel-item-target","","Target","Specify where to open the linked document", array(
        "_self" => "Self",
        "_blank" => "Blank"
    ));
	$mkdCarousels->addChild("mkd_carousel-item-target",$mkd_carousel_item_target);