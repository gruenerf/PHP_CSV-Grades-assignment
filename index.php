<?php
	require("config.php");

	$baseController = new RouteController();

	// Include head
	require_once("view/layout/head.php");
	// Include rendered header
	require_once("view/layout/header.php");
	// include rendered container inc. content
	require_once("view/layout/container.php");
	// include footer
	require_once("view/layout/footer.php");
?>