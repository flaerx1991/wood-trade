<?php

	// core configuration
	include_once $_SERVER['DOCUMENT_ROOT']."/config/core.php";
	 
	// set page header
	$page_title="Admin";

	include_once $_SERVER['DOCUMENT_ROOT']."/admin/layouts/header.php";

	var_dump(HOME_URL);
	// set page footer
	include_once $_SERVER['DOCUMENT_ROOT']."/admin/layouts/footer.php";
	
?>