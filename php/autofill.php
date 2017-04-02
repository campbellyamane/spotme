<?php

	require 'vendor/autoload.php';
	session_start();
	if (isset($_SESSION['token'])) { 
		$api = new SpotifyWebAPI\SpotifyWebAPI();
		$accessToken = $_SESSION['token'];
		$me = $_SESSION['user'];
		$features = $_SESSION['features'];
		$api->setAccessToken($accessToken);
	}
	
	$danceability = ($features->audio_features[0]->danceability);
	$energy = ($features->audio_features[0]->energy);
	$loudness = ($features->audio_features[0]->loudness);
	
	$arr = array ('danceability' => $danceability, 'energy' => $energy, 
		'loudness' => $loudness);
	echo json_encode($arr);
?>