<?php
	session_start();

	require 'vendor/autoload.php';
	if (isset($_SESSION['token'])) { 
		$api = new SpotifyWebAPI\SpotifyWebAPI();
		$accessToken = $_SESSION['token'];
		$me = $_SESSION['user'];
		$api->setAccessToken($accessToken);
	}
	
	$id = $_REQUEST['id'];
	
        $track = $api->getTrack($id);
	$title = $track->name;
	$artist = $track->artists[0]->name;
	$features = $api->getAudioFeatures([
		$id,
	]);
	
	$_SESSION['song'] = $id;
        $_SESSION['title'] = $title;
	$_SESSION['features'] = $features;
	$link = mysqli_connect(url, username, password, database);
	$sql = "INSERT INTO top (Artist, ID, Title) VALUES ('$artist', '$id', '$title')"; 
	
	$link->query($sql);
?>