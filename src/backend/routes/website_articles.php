<?php
// echo 'art<br />';
$prefix = Config('zmcms.main.backend_prefix');
Route::middleware(['BackendUser'])->group(function () use($prefix){
	Route::get($prefix.'/articles/list', 
		'Zmcms\WebsiteArticles\Backend\Controllers\ZmcmsWebsiteArticlesController@articles_list')
		->name('website_articles');
	Route::post($prefix.'/articles/save', 
		'Zmcms\WebsiteArticles\Backend\Controllers\ZmcmsWebsiteArticlesController@articles_save')
		->name('website_articles');
	Route::post($prefix.'/zmcms_website_articles_filter', 
		'Zmcms\WebsiteArticles\Backend\Controllers\ZmcmsWebsiteArticlesController@zmcms_website_articles_filter')
		->name('website_articles');
	Route::get($prefix.'/articles/edit/{token}', 
		'Zmcms\WebsiteArticles\Backend\Controllers\ZmcmsWebsiteArticlesController@articles_edit')
		->name('website_articles');
	Route::get($prefix.'/zmcms_website_articles_paginator/{token}/{page}',
		'Zmcms\WebsiteArticles\Backend\Controllers\ZmcmsWebsiteArticlesController@zmcms_website_articles_paginator')
		->name('website_articles');
	Route::get($prefix.'/zmcms_website_articles_page_delete/{token}/{langs_id}/{page}',
		'Zmcms\WebsiteArticles\Backend\Controllers\ZmcmsWebsiteArticlesController@zmcms_website_articles_page_delete')	
		->name('website_articles');
	Route::get($prefix.'/articles/create/frm',
		'Zmcms\WebsiteArticles\Backend\Controllers\ZmcmsWebsiteArticlesController@articles_create_frm')	
		->name('website_articles');
		
		
});



