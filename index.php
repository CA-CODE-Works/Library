<?php

include("core/init.php");

?>
<!doctype html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8">
	<title>California Archives</title>
	<!--#include virtual="ssi/head.html" -->
</head>
<body class="primary">
	<?php include("ssi/header.html"); ?>
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
					<form id="archivesearchform" method="GET">
						<div class="full-width">
							<p>Search: <input type="text" name="keywords" value="<?= $keyword  ?>"> <input type="submit"><span class="ca-gov-icon-search"></span></p>
							<p><label><input type="radio" name="sin" value="metadata" <?= 'metadata' == $sin ? 'checked="checked"' : '' ?>> Search Metadata</label>
								<label><input type="radio" name="sin" value="tv" <?= 'tv' == $sin ? 'checked="checked"' : '' ?>> Search TV News Captions</label>
							</p>
						</div>
						<?php if( ! empty($output) ): ?>
							<h4><?= $result_count ?> Results Found</h4>
							<div class="quarter filters">
								<?php if( ! empty($years) ) : ?>
									<h5>Year</h5>
									<ul>
								<?php foreach($years as $y => $year): ?>
									<li><label><input name="year[]" type="checkbox" value="<?= $y ?>"<?= in_array($y, $filter_years) ? ' checked="checked"' : ''?>> <?= $y ?></label><i class="pull-right"><?= $year ?></i></li>
								<?php endforeach; ?>
								</ul>
							<?php endif; ?>
							<div class="text-center"><input class="filter btn btn-primary " type="submit" value="Apply Filters"></div>
							</div>
						<?php elseif(empty($output) && ! empty($keyword) ): ?>
							<h4>No Results Found</h4>
						<?php endif; ?>
					</form>
					<!-- End of Search Archive Form -->
					<?php if( ! empty($output) ): ?>
						<!-- Search Results -->
						<div class="three-quarters">
							<?= $output ?>
						</div>
						<!-- End of Search Results -->
					<?php endif; ?>
					
					
				</div>
			</div>
			<!-- End Main Content -->
		</main>
	</div>

	<?php include("ssi/global-footer.html") ?>

</body>
</html>
