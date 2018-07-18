<?php

// Start a session
session_start();
include("core/init.php");

if (isset($_GET['appID'])) {
    retrieveApp($_GET['appID']);
}
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
					<div class="full-width">
						<?php include('data/search.php'); ?>
						<div>
							<?php print_r($_POST); ?>
						</div>
					</div>
				</div>
				<!-- End Main Content -->
			</div>
		</main>
	</div>

	<?php include("ssi/global-footer.html") ?>

</body>
</html>
