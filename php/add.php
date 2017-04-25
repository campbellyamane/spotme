<?php
	session_start();

	require 'vendor/autoload.php';
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
	$link = mysqli_connect(url, username, password, database);
	$sql = "INSERT INTO top (Artist, ID, Title) VALUES ('$artist', '$song', '$title')"; 
	if (strlen($song) > 1){
                $link->query($sql);
        }
?>