<?php

	require 'vendor/autoload.php';
	session_start();
	if (isset($_SESSION['token'])) { 
		$api = new SpotifyWebAPI\SpotifyWebAPI();
		$accessToken = $_SESSION['token'];
		$me = $_SESSION['user'];
		$results = $_SESSION['results'];
		$api->setAccessToken($accessToken);
	}
	
	$id = $_REQUEST['id'];
	
	$song = $results->tracks->items[$id]->id;
	$title = $results->tracks->items[$id]->name;
	$artist = $results->tracks->items[$id]->artists[0]->name;
	$features = $api->getAudioFeatures([
		$song,
	]);
	unset($_SESSION['results']);
	
	$_SESSION['song'] = $song;
	$_SESSION['features'] = $features;
	$link = mysqli_connect("localhost", "root", "", "mysql");
	$sql = "INSERT INTO top (Artist, ID, Title) VALUES ('$artist', '$song', '$title')"; 
	
	$link->query($sql);
?>