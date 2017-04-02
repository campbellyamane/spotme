<?php

	require 'vendor/autoload.php';
	session_start();
	if (isset($_SESSION['token'])) { 
		$api = new SpotifyWebAPI\SpotifyWebAPI();
		$accessToken = $_SESSION['token'];
		$me = $_SESSION['user'];
		$api->setAccessToken($accessToken);
	}
	$term = $_REQUEST['term'];
	
	$results = $api->search($term, 'track', [
		'limit' => 5,
	]);
	$j=0;
	foreach ($results->tracks->items as $track) {
		echo "<a target='_blank' id='".$j."'>" . "<b>" . $track->name . "</b>"." by " . "<b>" . $track->artists[0]->name . "</b>". " - ". $track->album->name."</a>" . '<br>';
		$j++;		
	}
	$_SESSION['results'] = $results;
    echo "
		<script type='text/javascript' src='/spotme/js/jquery.js'></script>
		<script type='text/javascript'>
		    $(document).ready(function () {
				$('a').click(function (e) {
					$.get('add.php',{id: this.id}).done(function(data){
					});
					$('#search').fadeOut(1000);
					$('#playlist').fadeIn(2000);
				});
		    });
        </script>
    ";
	
?>