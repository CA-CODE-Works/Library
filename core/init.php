<?php
/********************************************************************************************************
Remove this when used is production, this will allow to update test different branches from the browser
********************************************************************************************************/
if( isset($_GET['action']) && 'update' == $_GET['action']){
        $branch = isset($_GET['branch']) ? $_GET['branch'] : 'dev';

        // Check that the branch exists
        exec("git ls-remote --heads https://github.com/CA-CODE-Works/Library.git $branch | wc -l", $branch_check);

        if( $branch_check ){
                exec("git reset --hard");
                exec("git checkout $branch");
                exec("git pull origin $branch");
                exec("git reset --hard origin/$branch");
	        header("Location: ./index.php");
        }
}
/********************************************************************************************************
Remove this when used is production, this will allow to update test different branches from the browser
********************************************************************************************************/
/*
California Archive Library 2018

This application utilizes the search API endpoints provided by The Internet Archive. The Internet Archive uses the Apache Lucene open source search engine and the lucene query syntax.
https://archive.org/help/aboutsearch.htm

API Reference
https://archive.org/advancedsearch.php

Lucene Query syntax
http://lucene.apache.org/solr/resources.html#tutorials
*/

$result_count = 0;
$output = '';
$keyword = isset($_GET['keywords']) ? trim($_GET['keywords']) : '';
$sin = isset($_GET['sin']) ? $_GET['sin'] : 'metadata';
$filter_years = isset($_GET['year']) ? $_GET['year'] : array();

if( ! empty($keyword) ){
	// Wayback params
	$q = strtolower($keyword);
	
	// if search query doesn't contain california append it to the end
	//$q = -1 < strpos($q, 'california') ? $q : "$q California";
	// if search query doesn't contain 'governor' append it to the end
	//$q = -1 < strpos($q, 'edmund brown') ? $q : "$q Edmund G. Brown, Jr";

	// Append date range to search query
	$q .= '+date:[2011-01-03 TO 2018-12-31]';
	
	// Sort By paremeter 
	$sortby = '&sort[]=date+desc';
	
	$wayback_img_url = "https://archive.org/services/img/";
	$wayback_detail_url = "https://archive.org/details/";
	
	// Wayback urls
	if( 'tv' == $sin ){
		$wayback_url = sprintf('https://archive.org/details/tv?q=%1$s&rows=100&output=json', $q );		
	}else{
		$wayback_url = sprintf('https://archive.org/advancedsearch.php?q=%1$s%2$s&rows=100&output=json', $q, $sortby );
	}
	print_r( $wayback_url );
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $wayback_url);
	curl_exec($ch);
	
	// if no errors using the Wayback API
	if ( ! curl_errno($ch)) {
		$response = json_decode( curl_multi_getcontent($ch) );
		$years = array();
		
		if( isset($response->response->docs) ){
			$response = $response->response->docs;
		}
		
		if( ! empty( $response ) ){
			foreach( $response as $r => $res){
				$title = $res->title;
				$identifier = $res->identifier;
				$date = isset($res->date)  ? sprintf('<p class="published">%1$s</p>', (new DateTime($res->date) )->format('M j, Y')) : '';
				$year = (new DateTime($res->date) )->format('Y');
				
				if(! array_key_exists($year, $years)) {
					$years[$year] = 1;
				}else{
					$years[$year]++;
				}
				
				if( empty( $filter_years ) || in_array($year, $filter_years) ){
					$img = isset($res->thumb) ? $res->thumb : $wayback_img_url . $identifier;
					$detail_link = $wayback_detail_url . $identifier;
					
					$output .= sprintf('<div class="third text-center"><div><img src="%1$s" alt="%2$s" style="max-height:110px;"/></div><a href="%3$s">%2$s</a>%4$s</div>', $img, $title, $detail_link, $date);
					$result_count++;
				}
				
			}			
		}
		
	}else{
		$error =  curl_error($ch);
	}
	
	curl_close($ch);
}


?>
