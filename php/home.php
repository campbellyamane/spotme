<html>
	<head>
		<title>Spot Me</title>
		<link href="/spotme/css/home.css?v=<?=time();?>" type="text/css" rel="stylesheet"/>
		<link rel="icon" type="image/ico" href="/spotme/favicon.ico"/>
		<script type="text/javascript" src="/spotme/js/jquery.js"></script>
		<script type="text/javascript">				
			$(document).ready(function(){
				$('#search input[type="text"]').on("keyup input", function(){
					/* Get input value on change */
					var inputVal = $(this).val(); //search term
					var resultDropdown = $(this).siblings(".result");
					var keycode = (event.keyCode ? event.keyCode : event.which);
					if(keycode == '13'){ //sends to php on enter
						$.get("search.php", {term: inputVal}).done(function(data){
							// Display the returned data in browser
							resultDropdown.html(data);
						});
					} else{
						resultDropdown.empty();
					}
				});
				$('#autofill').click (function(){
					$.post('autofill.php', function( result ){ 
						var features = JSON.parse(result);
						$('#danceability').val(features.danceability);
						$('#energy').val(features.energy);
						$('#loudness').val(features.loudness);
					});
				});
			});
		</script>
	</head>
	<body>
		<div id="home">
		</div>
		<div id="header">
			<h1>Spot Me</h1>
			<?php	
				
				require 'vendor/autoload.php';

				$session = new SpotifyWebAPI\Session('bafab0def2814af48f3cadf80c42ae17', 'd5c6f92f78704bb8abbe7f82a8ff3fc1', 'http://localhost/spotme/php/home.php');
				$api = new SpotifyWebAPI\SpotifyWebAPI();

				// Request a access token using the code from Spotify
				$session->requestAccessToken($_GET['code']);
				$accessToken = $session->getAccessToken();

				// Set the access token on the API wrapper
				$api->setAccessToken($accessToken);

				// Start using the API!
				$me = $api->me(); //stores user data

				$me = $me->uri; //extracts user id info
				$me = ltrim($me,"spotify:user:"); //extracts only user id
				
				session_start();
				$_SESSION['token'] = $session->getAccessToken(); //saves authorization token in session
				$_SESSION['user'] = $me; //saves user id in session
				
			?>	
			
		</div>
		<div id="top">
			<h1><u> Most Searched Tracks </u></h1>
			<div id="topResults">
				<?php //returns top searched (clicked) tracks from sql database
					$link = mysqli_connect("localhost", "root", "", "mysql");
					$topTracks = "SELECT ID, Title, Artist, COUNT(*) as c FROM top GROUP BY ID, Title, Artist ORDER BY c DESC LIMIT 5";
					$sql = $link->query($topTracks);
					
					$i = 0;
					while($row = mysqli_fetch_assoc($sql)) {
						$i++;
						//$topID = $row["ID"];
						echo $i.". <a class='topTracks'>".$row["Title"]. "</a> <br>";
					}
				?>
			</div>
		</div>
		<div id="playlist">
			<button id="autofill"> Autofill Fields </button>
			<form action="playlist.php" method="post">
				<input class="qualities" name="name" type="text" autofocus ="autofocus" placeholder="Enter Playlist Name" required/> </p> </br>
				<input id="danceability" class="qualities" name="danceability" type="number" placeholder="Danceability (0-1)" min="0" max="1" step="any" required/> </p> </br>
				<input id="energy" class="qualities" name="energy" type="number" placeholder="Energy (0-1)" min="0" max="1" step="any" required/> </p> </br>
				<input id="loudness" class="qualities" name="loudness" type="number" placeholder="Loudness (-60-0)" min="-60" max="0" step="any" required/> </p> </br>
				<input id="makePlaylist" type="submit" value="Spot me, bro!"/>
			</form>	
		</div>
		<div id="search">
			<input class="searchbox" name="input" autofocus="autofocus" type="text" placeholder="Enter Song Name"/>
			<div class="result"></div>
		</div>
	</body>
</html>