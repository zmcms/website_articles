<?php
namespace Zmcms\WebsiteArticles\Frontend\Middleware;
use Closure;use Session;use URL;class ZmcmsWebsiteArticles
{
	public function handle($request, Closure $next){
		return $next($request);
	}
}
