<?php

	ini_set('display_error' , 'on');
	error_reporting(E_ALL);
	include 'admin/connect.php';

	$sessionUser = '';

	if(isset($_SESSION['user'])){
		$sessionUser = $_SESSION['user'];
	}

	// Routes

	$tpl 	= 'includes/templetes/'; // Template Directory
	$lang = 'includes/languages/'; // Language Directory
	$func	= 'includes/functions/'; // Functions Directory
	$css 	= 'layout/css/'; // Css Directory
	$js 	= 'layout/js/'; // Js Directory

	// Include The Important Files

	include $func . 'functions.php';
	include $lang . 'english.php';
	include $tpl  . 'header.php';
	

	