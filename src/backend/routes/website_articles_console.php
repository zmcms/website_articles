<?php
Artisan::command('zmcms_website_articles_load', function () {
	require(getcwd().'/vendor/zmcms/website_articles/src/dummy/example_data.php');
});