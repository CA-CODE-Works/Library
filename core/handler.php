<?php

// GET Request Handler
function getRequestHandler($data) {
    switch ($data['action']) {
		case 'newProject':
		  include('data/dashboard/views/project/project.php');
      break;

    case 'viewApplicants':
        include('data/dashboard/views/applicant/applicant.php');
        break;
				
		case 'newOfficial':
		  include('data/dashboard/views/official/form.php');
      break;

		case 'viewOfficials':
		  include('data/dashboard/views/official/official.php');
      break;
		
		case 'viewAppSettings':
			include('data/dashboard/views/settings.php');
			break;

		case 'getCongressionalDistrict':
		$google_geocode_API_KEY = $_SESSION['appOptions']['geocode'];
		// Google Geocoding API
		// https://developers.google.com/maps/documentation/geocoding/intro
		$http = curl_init(sprintf('https://maps.googleapis.com/maps/api/geocode/json?address=%1$s&key=%2$s', $data['address'], $google_geocode_API_KEY));
		
		curl_setopt($http, CURLOPT_RETURNTRANSFER, true);
		 
		$result = curl_exec($http);
	
		
		if( ! $result ){
			curl_close($http);
			return false; 
		}else{
			$geometry = json_decode( $result )->results[0]->geometry->location;
			
			// Congression District API endpoint
			//https://sunlightlabs.github.io/congress/districts.html
			$congressAPI = sprintf('https://congress.api.sunlightfoundation.com/districts/locate?latitude=%1$s&longitude=%2$s', $geometry->lat, $geometry->lng);
			return $congressAPI;
			
			curl_setopt($http, CURLOPT_URL, $congressAPI);
			
			$result = curl_exec($http);
					
			curl_close($http);
			
			if( ! $result ){
				return false;
			}else{
				print_r(  $result );
				
			}
		}

			break;
	}
}

// POST Request Handler
function postRequestHandler($data) {
    switch ($data['action']) {
		case 'addOfficial':
			$response = addOfficial($data['email']);
			if (is_null($response)) {
			    return sprintf('<div class="panel panel-overstated"><div class="panel-heading"><h2>Error Adding New Elected Official</h2></div><div class="panel-body"><h2>An error occurred when connecting to the database</h2><form id="newOfficial"><p>Email: <input type="text" name="email" placeholder="username@state.ca.gov" value="%1$s"></p><div class="text-right"><a class="btn btn-primary add-official">Add Official</a></div></form></div></div>', $data['email']);
			} elseif ( ! $response) {
			    return sprintf('<div class="panel panel-overstated"><div class="panel-heading"><h2>New Elected Official</h2></div><div class="panel-body"><h2>Email address already exists.</h2><form id="newOfficial"><p>Email: <input type="text" name="email" placeholder="username@state.ca.gov" value="%1$s"></p><div class="text-right"><a class="btn btn-primary add-official">Add Official</a></div></form></div></div>', $data['email']);
			} elseif ($response) {
			    return '<div class="panel panel-overstated"><div class="panel-heading"><h2>Elected Official Added.</h2></div><div class="panel-body"><h2>Email address added successfully.</h2></div></div>';
			}

			break;
		case 'saveAppSettings':		
			$response = updateAppSettings($data);
			
			if (is_null($response)) {
					print '<div class="alert alert-danger"><strong>Database Error!</strong> Options could not be saved.</div>' ;

			} elseif ( ! $response) {
					print '<div class="alert alert-warning"><strong>Error!</strong> Options could not be saved successfully!</div>' ;
					
			} elseif ($response) {
				print '<div class="alert alert-success"><strong>Success!</strong> Options were saved successfully!</div>' ;
			}
			include('data/dashboard/views/settings.php');
			
			break;
	}
}

?>
