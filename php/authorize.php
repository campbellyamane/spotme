<?php

	require 'vendor/autoload.php';

	$session = new SpotifyWebAPI\Session(id, password, 'http://www.campbellyamane.com/spotme/php/home.php');

	$options = [
            'scope' => [
                //'playlist-read-private',
                //'playlist-read-public',
                //'user-read-private',
                'playlist-modify-public',
                //'user-library-modify',
                //'playlist-modify-private',
                //'user-read-email',
            ],
        ];
        

	header('Location: ' . $session->getAuthorizeUrl($options));
	die();

?>