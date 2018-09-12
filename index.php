<?php

// Start a session
session_start();
include("core/init.php");

?>
<!doctype html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8">
	<title>California Archives</title>
	<?php include("ssi/head.html"); ?>
	<link rel="stylesheet" href="style.css" />
</head>
<body class="primary">
	<?php include('header.php'); ?>

	<div id="main-content" class="main-content">
		<main class="main-primary">
			<!-- Begin Page Title -->
			<div class="section section-standout">
				<div class="container">
					<h1 class="page-title">California Archives</h1>
				</div>
			</div>
			<!-- End of Page Title -->
			<!-- Begin Main Content -->
			<div class="section">
				<div class="container">
					<!-- Search Archive Form -->
					<div class="full-width">
            <form id="archivesearchform" method="GET">
            <p>Search: <input type="text" name="keywords"> <input type="submit"><span class="ca-gov-icon-search"></span></p>
            <p><label><input type="radio" name="sin" value="" <?= ! isset($_GET['sin']) || empty($_GET['sin']) ? 'checked="checked"' : '' ?>> Search Metadata</label>
              <label><input type="radio" name="sin" value="TXT" <?= isset($_GET['sin']) && 'TXT' == $_GET['sin'] ? 'checked="checked"' : '' ?>> Search text contents</label>
              <label><input type="radio" name="sin" value="web" <?= isset($_GET['sin']) && 'web' == $_GET['sin'] ? 'checked="checked"' : '' ?>> Search archived web sites</label>
            </p>
            </form>
					</div>
					<!-- End of Search Archive Form -->
					<!-- Search Results -->
					<div class="full-width">
						<?php 
						
							if(isset($_GET['keywords']) && ! empty(trim($_GET['keywords']))){
								$q = strtolower(trim($_GET['keywords']));
								$q = -1 < strpos($q, 'california') ? $q : "$q California";
								
								$sin = $_GET['sin'];
								
								if('TXT' !== $sin ){
									$wayback_url = sprintf('https://archive.org/advancedsearch.php?q=%1$s&output=json', $q );
									
								}else{
									$wayback_url = sprintf('services/search/v1/scrape?fields=title&q=%1$s&output=json', $q );
									
								}
								
								$wayback_img_url = "https://archive.org/services/img/";
								$wayback_detail_url = "https://archive.org/details/";
								
								$ch = curl_init();
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
								curl_setopt($ch, CURLOPT_URL, $wayback_url);
								curl_exec($ch);

								// if no errors using the Google Geocoding API
								if ( ! curl_errno($ch)) {
									$response = json_decode( curl_multi_getcontent($ch))->response->docs;
									print_r( get_object_vars( $response[1] ) );
									
									foreach( $response as $r => $res):
										$title = $res->title;
										$identifier = $res->identifier;
										$date = (new DateTime($res->date) )->format('M j, Y');
										
										$img = $wayback_img_url . $identifier;
										$detail_link = $wayback_detail_url . $identifier;
										?>
										<div class="third text-center">
											<div><img src="<?= $img ?>" alt="<?= $res->title ?>" style="max-height:120px;"/></div>
											<a href="<?= $detail_link ?>"><?= $title ?></a>
											<p class="published"><?= $date ?></p>
										</div>
									<?php endforeach; 
							}else{
								print_r( curl_error($ch) );
							}
								
							}
						?>
					</div>
					<!-- Search Results -->
					
				</div>
			</div>
			<!-- End Main Content -->
		</main>
	</div>

	<?php include("ssi/global-footer.html") ?>

</body>
</html>
<style>
#archivesearchform span{
	font-size:32px;
	vertical-align:middle;
	margin-left:-32px;
}
#archivesearchform input[name="keywords"]{
	width:90%;
}
#archivesearchform input[type="submit"]{
	width:32px;
	opacity:0;
}
label{
	cursor: pointer;
	padding-right: 15px;
}
</style>
