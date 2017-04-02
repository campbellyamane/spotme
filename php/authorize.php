<?php

	require 'vendor/autoload.php';

	$session = new SpotifyWebAPI\Session('bafab0def2814af48f3cadf80c42ae17', 'd5c6f92f78704bb8abbe7f82a8ff3fc1', 'http://localhost/spotme/php/home.php');

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