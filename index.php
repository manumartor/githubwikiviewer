<?php 
	/**
	 * Github/Bitbucket Wiki Smarty HTML browser viewer
	 *
	 * @author: manu.martor@gmail.com
	 * @repository: https://github.com/manumartor/githubwikiviewer
	 * @version: 1.0.0
	 **/
	require_once('./autoload.php');

	//ini viewer
	$viewer = new Viewer();
	echo $viewer->parse_file('./data/Home.md');
