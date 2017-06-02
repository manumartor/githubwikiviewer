<?php 
	/**
	 * Github/Bitbucket Wiki Smarty HTML browser viewer
	 **/
	require_once('./autoload.php');

	//ini viewer
	$viewer = new Viewer();
	echo $viewer->parse_file('./data/Home.md');
