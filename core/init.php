<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$output = '';
$keyword = isset($_GET['keywords']) ? trim($_GET['keywords']) : '';
$sin = isset($_GET['sin']) ? $_GET['sin'] : '';


if( ! empty($keyword) ){
	// Wayback params
	$q = strtolower($keyword);
	$q = -1 < strpos($q, 'california') ? $q : "$q California";

	$sortby = '&sort[]=publicdate+desc';
	
	$wayback_img_url = "https://archive.org/services/img/";
	$wayback_detail_url = "https://archive.org/details/";
	
	// Wayback urls
	if( 'tv' == $sin ){
		$wayback_url = sprintf('https://archive.org/details/tv?q=%1$s&output=json', $q );		
	}else{
		$wayback_url = sprintf('https://archive.org/advancedsearch.php?q=%1$s%2$s&output=json', $q, $sortby );
	}
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $wayback_url);
	curl_exec($ch);
	
	// if no errors using the Google Geocoding API
	if ( ! curl_errno($ch)) {
		$response = json_decode( curl_multi_getcontent($ch) );
		
		if( isset($response->response->docs) ){
			$response = $response->response->docs;
		}else{
			//print_r( get_object_vars($response[0]) );
		}
		
		foreach( $response as $r => $res){
			$title = $res->title;
			$identifier = $res->identifier;
			$date = isset($res->date)  ? sprintf('<p class="published">%1$s</p>', (new DateTime($res->date) )->format('M j, Y')) : '';
			
			$img = isset($res->thumb) ? $res->thumb : $wayback_img_url . $identifier;
			$detail_link = $wayback_detail_url . $identifier;
			
			$output .= sprintf('<div class="third text-center"><div><img src="%1$s" alt="%2$s" style="max-height:110px;"/></div><a href="%3$s">%2$s</a>%4$s</div>', $img, $title, $detail_link, $date);
			
		}
		
	}else{
		$output =  curl_error($ch);
	}
	
	curl_close($ch);
}


function adfa(){
	
}
?>
