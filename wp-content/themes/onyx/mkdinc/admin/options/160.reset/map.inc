<?php

$resetPage = new MikadoAdminPage("21", "Reset", "icon_refresh");
$mkdFramework->mkdOptions->addAdminPage("Reset",$resetPage);

//Reset

$panel1 = new MikadoPanel("Reset to Defaults","reset_panel");
$resetPage->addChild("panel1",$panel1);

	$reset_to_defaults = new MikadoField("yesno","reset_to_defaults","no","Reset to Defaults","This option will reset all Mikado Options values to defaults");
	$panel1->addChild("reset_to_defaults",$reset_to_defaults);