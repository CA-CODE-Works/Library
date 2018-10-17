<?php

include("core/init.php");

?>
<!doctype html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8">
	<title>California Archives</title>
	<?php include_once("ssi/head.php"); ?>
</head>
<body class="primary">

    <script>
        //makes the browser wait to display the page until it's fully loaded.
        // Use it if page contains primary or slideshow banner to make sure page content loads smouthly
        $('body').css('opacity', 0);
        $(window).load(function () {
            $("body").fadeTo("slow", 1);
        });
    </script>
	    <header role="banner" id="header" class="global-header fixed">
        <div id="skip-to-content"><a href="#main-content">Skip to Main Content</a></div>
        
    
        <!-- Include Utility Header -->
        <?php include_once("ssi/utility-header.php"); ?>
        
        <!-- Settings Bar -->
        <?php include_once("ssi/settings-bar.php"); ?>

        <!-- Include Branding -->
        <?php include_once("ssi/branding.php"); ?>

        <!-- Include Mobile Controls -->
        <?php include_once("ssi/mobile-controls.php"); ?>
    
        <div class="navigation-search">
            <div id="head-search" class="search-container featured-search fade">
                <!-- Include Search -->
                <?php include_once("ssi/search.php"); ?>
            </div>
            <!-- Include Navigation -->
            <?php include_once("ssi/navigation.php"); ?>
        </div>

        <div class="header-decoration"></div>
    </header>


	<div id="main-content" class="main-content">
		<main class="main-primary">

		<!--BANNER-->
<div class="carousel owl-carousel carousel-content">
                                        <div class="item">
                                            <img src="/images/brown-banner3.jpg" alt="Governor Edmund G. Brown Jr">

                                        </div>
                                        <div class="item">
                                            <img src="/images/brown-banner2.jpg" alt="Governor Edmund G. Brown Jr">

                                        </div>
                                        <div class="item">
                                            <img src="/images/brown-banner1.jpg" alt="Governor Edmund G. Brown Jr">
                                        </div>
                                    </div>


			<!-- Begin Page Title -->
			
			<!-- End of Page Title -->
			<!-- Begin Main Content -->
			<div class="section">
				<div class="container">
				<h1>California Archives</h1>
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
	<?php include_once("ssi/global-footer.php"); ?>
	
</body>
</html>
