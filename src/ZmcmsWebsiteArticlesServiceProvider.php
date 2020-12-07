<?php
namespace Zmcms\WebsiteArticles;
use Illuminate\Support\ServiceProvider;
class ZmcmsWebsiteArticlesServiceProvider extends ServiceProvider{

	public function register(){
		$this->app->make('Zmcms\WebsiteArticles\Backend\Controllers\ZmcmsWebsiteArticlesController');
		$this->app->make('Zmcms\WebsiteArticles\Frontend\Controllers\ZmcmsWebsiteArticlesController');
		require_once(__DIR__.'/helpers.php');
	}

	public function boot(){
		// $this->loadRoutesFrom(__DIR__.DIRECTORY_SEPARATOR.'backend'.DIRECTORY_SEPARATOR.'routes'.DIRECTORY_SEPARATOR.'website_articles.php');
		// $this->loadRoutesFrom(__DIR__.DIRECTORY_SEPARATOR.'backend'.DIRECTORY_SEPARATOR.'routes'.DIRECTORY_SEPARATOR.'website_articles_console.php');
		// $this->loadRoutesFrom(__DIR__.DIRECTORY_SEPARATOR.'frontend'.DIRECTORY_SEPARATOR.'routes'.DIRECTORY_SEPARATOR.'website_articles.php');
		$this->loadMigrationsFrom(__DIR__.'/migrations');
		$this->publishes([
			__DIR__.'/config' => base_path('config/'.Config('frontend.theme_name').'/zmcms/'),
			__DIR__.'/backend/css' => base_path('public/themes/zmcms/backend/css/'),
			__DIR__.'/backend/js' => base_path('public/themes/zmcms/backend/js/'),
			__DIR__.'/backend/views' => base_path('resources/views/themes/zmcms/backend'),
			__DIR__.'/frontend/css' => base_path('public/themes/zmcms/frontend/css/'),
			__DIR__.'/frontend/js' => base_path('public/themes/zmcms/frontend/js/'),
			__DIR__.'/frontend/views' => base_path('resources/views/themes/zmcms/frontend'),
		]);
		// View::addLocation(__DIR__.DIRECTORY_SEPARATOR.'/backend/views');
		// View::addLocation(__DIR__.DIRECTORY_SEPARATOR.'/frontend/views');
	}

}
