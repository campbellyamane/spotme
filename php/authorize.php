<?php

	require 'vendor/autoload.php';

	$session = new SpotifyWebAPI\Session('id', 'password', 'http://localhost/spotme/php/home.php');

	$scopes = array(
			'playlist-read-private',
			'user-read-private',
			'playlist-modify-public',
			'playlist-modify-private'
	);

	$authorizeUrl = $session->getAuthorizeUrl(array(
		'scope' => $scopes
	));

	header('Location: ' . $authorizeUrl);
	die();

?>
