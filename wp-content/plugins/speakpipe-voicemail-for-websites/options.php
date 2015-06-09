<?php

$prefix = $this->plugin_slug . '_';
$options = array(

	array(
		'label' => 'Tab 1',
		'desc' => 'Desc',
		'id' => $prefix . 'tab1',
		'type' => 'tab',
		'content' => array(
			array(
				'label' => 'Enter your SpeakPipe account ID to activate the plugin',
				'desc' => 'You can find your SpeakPipe ID in <a href="https://www.speakpipe.com/account/settings" target="_blank">settings</a>. See <a href="https://www.speakpipe.com/help/wordpress" target="_blank">help</a> for details.',
				'id' => $prefix . 'id',
				'type' => 'text'
			),
			array(
				'label' => 'Don\'t show the SpeakPipe button on the home page',
				'desc' => '',
				'id' => $prefix . 'front',
				'type' => 'checkbox'
			)
		)
	)

);

?>