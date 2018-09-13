<?php

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
            <p>Search: <input type="text" name="keywords" value="<?= $keyword  ?>"> <input type="submit"><span class="ca-gov-icon-search"></span></p>
            <p><label><input type="radio" name="sin" value="" <?= empty($sin) ? 'checked="checked"' : '' ?>> Search Metadata</label>
              <label><input type="radio" name="sin" value="tv" <?= 'tv' == $sin ? 'checked="checked"' : '' ?>> Search TV News Captions</label>
            </p>
            </form>
					</div>
					<!-- End of Search Archive Form -->
					<!-- Search Results -->
					<div class="full-width">
						<?= $output ?>
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
.third{
	max-height: 180px;
	min-height: 180px;
}
label{
	cursor: pointer;
	padding-right: 15px;
}
</style>
