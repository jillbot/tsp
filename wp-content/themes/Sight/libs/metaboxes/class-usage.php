<?php
/*
Plugin Name: Demo MetaBox
Plugin URI: http://en.bainternet.info
Description: My Meta Box Class usage demo
Version: 3.0.1
Author: Bainternet, Ohad Raz
Author URI: http://en.bainternet.info
*/

//include the main class file
require_once("meta-box-class/meta-box-class.php");
if (is_admin()){
  /* 
   * prefix of meta keys, optional
   * use underscore (_) at the beginning to make keys hidden, for example $prefix = '_ba_';
   *  you also can make prefix empty to disable it
   * 
   */
  $prefix = 'pl_';
  
  if(get_option('sbg_sidebars')){
  /* 
   * SIDEBAR (for pages, posts)
   */
  $config_sidebar = array(
    'id' => 'sidebar_meta_box',
    'title' => 'Sidebar', 
    'pages' => array('page','post'),
    'context' => 'normal',
    'priority' => 'high', 
    'fields' => array()
  );
  
  $sidebar_meta =  new AT_Meta_Box($config_sidebar);
	$sidebar['sidebar'] = 'Default';

	foreach(get_option('sbg_sidebars') as $k=>$v){
		$sidebar[$k] = $v;
	}
	$sidebar_meta->addSelect($prefix.'sidebar',$sidebar,array('name'=> 'Select sidebar', 'std'=> array('sidebar')));
	
  
  $sidebar_meta->Finish();
  
  } // if($options['sidebar'])
  
   /* 
   * POST OPTIONS (for post)
   */
  $p_config = array(
    'id' => 'post_option_box',
    'title' => 'Post Options', 
    'pages' => array('post'),
    'context' => 'normal',
    'priority' => 'high', 
    'fields' => array()
  );
	$p_meta =  new AT_Meta_Box($p_config);
	$p_meta->addSelect($prefix.'lightbox',array('yes'=>'Yes','no' => 'No'),array('name'=> 'Image lightbox','desc'=>'Image lightbox for posts in listing'));
	$p_meta->addSelect($prefix.'related',array('default'=>'Default','yes'=>'Yes','no' => 'No'),array('name'=> 'Related posts'));
	$p_meta->Finish();
  
  
  /* 
   * MEDIA (for post, page)
   */
  $config = array(
    'id' => 'media_meta_box',
    'title' => 'Post Media', 
    'pages' => array('post', 'page'),
    'context' => 'normal',
    'priority' => 'high', 
    'fields' => array()
  );
  
  $my_meta =  new AT_Meta_Box($config);
  
	// Get gallery for slider
   $my_meta->addUpload($prefix.'audio',array('name'=> 'Audio','desc'=>'Upload audio file or type audio url'));   
   $my_meta->addTextarea($prefix.'audio_embed',array('name'=> 'Audio embed','desc'=>'Put audio embed (eg. <a href="https://soundcloud.com" target="_blank">Soundcloud</a>)'));
   $my_meta->addTextarea($prefix.'video_embed',array('name'=> 'Video embed'));
 

  $my_meta->Finish();
  
  
   /* 
   * SLIDER OPTION (for flexslider)
   */
  $s_config = array(
    'id' => 'slider_meta_box',
    'title' => 'Slider Options', 
    'pages' => array('slider'),
    'context' => 'normal',
    'priority' => 'high', 
    'fields' => array()
  );
  
   $s_meta =  new AT_Meta_Box($s_config);
   $s_meta->addText($prefix.'link',array('name'=> 'Link'));
   $s_meta->Finish();
  

  /* 
   * BACKGROUND (for post, page)
   */
  $config2 = array(
    'id' => 'background_meta_box',
    'title' => 'Background', 
    'pages' => array('post', 'page'), 
    'context' => 'normal', 
    'priority' => 'high', 
    'fields' => array()
  );
  
  
  /*
   * Initiate your 2nd meta box
   */
  $my_meta2 =  new AT_Meta_Box($config2);
  
  $my_meta2->addUpload($prefix.'background',array('name'=> 'Enter URL or Upload background','desc'=>'It only work with boxed layout'));
  $my_meta2->addSelect($prefix.'bg_align',array('top left' => 'Top Left','top right' => 'Top Right','top center' => 'Top Center','bottom left' => 'Bottom Left','bottom right' => 'Bottom Right', 'bottom center' => 'Bottom Center','center center'=>'Center Center'),array('name'=> 'Background align','group' => 'start'));
  $my_meta2->addSelect($prefix.'bg_attachment',array('scroll' => 'Scroll','fixed' => 'Fixed'),array('name'=> 'Background attachment'));
  $my_meta2->addSelect($prefix.'bg_repeat',array('repeat' => 'Repeat','repeat-x' => 'Repeat X','repeat-y' => 'Repeat Y','no-repeat' => 'No repeat'),array('name'=> 'Background repeat'));
  $my_meta2->addSelect($prefix.'bg_size',array('none'=>'No scale','100% auto' => '100% - Auto','auto 100%' => 'Auto - 100%','100% 100%' => '100% - 100%'),array('name'=> 'Background size','group' => 'end'));
  
  /*
   * Don't Forget to Close up the meta box decleration
   */
  //Finish Meta Box Decleration
  $my_meta2->Finish();
  
  
   /* 
   * PEOPLE INFO (for people)
   */
	$config_people = array(
		'id' => 'people_meta_box',
		'title' => 'People Options', 
		'pages' => array('people'),
		'context' => 'side',
		'priority' => 'low', 
		'fields' => array()
	);
	
	$people_meta =  new AT_Meta_Box($config_people);
	
	// Position
	$people_meta->addText($prefix.'position',array('name'=> 'Position','desc'=>'Ex: CEO & Founder, Vice President, HR Manager, ect.'));			
	$people_meta->Finish();
}