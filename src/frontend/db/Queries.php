<?php
namespace Zmcms\WebsiteArticles\Frontend\Db;
use Illuminate\Support\Facades\DB;
use Session;
use Request;
class Queries{
	/**
	 * LISTA ARTYKUŁÓW NALEŻĄCYCH DO DANEJ KATEGORII
	 */
	public static function get_articles_list($token_nav, $paginate = 0, $order=[], $filter=[]){
		$art = (Config('database.prefix')??'').'website_articles';
		$art_names = (Config('database.prefix')??'').'website_articles_names';
		$art_content = (Config('database.prefix')??'').'website_articles_content';
		$linker = (Config('database.prefix')??'').'website_navigations_linker';
		$resultset = DB::table($art)
			->join($art_names, $art.'.token', '=', $art_names.'.token')
			->join($linker, $art.'.token', '=', $linker.'.obj_token');
		if($filter!=[])
			foreach($filter as $v) {
				$resultset->where($v[0], $v[1], $v[2]);
			}
			$resultset->where('nav_token', $token_nav);
			$resultset->select([
				$art.'.token as token',
				$art.'.sort as sort',
				$art.'.access as access',
				$art.'.frontend_access as frontend_access',
				$art.'.active as active',
				$art.'.ilustration as ilustration',
				$art.'.images_resized as images_resized',
				$art.'.date_from as date_from',
				$art.'.date_to as date_to',
				$art.'.created_at as created_at',
				$art.'.updated_at as updated_at',
				$art_names.'.token as token',
				$art_names.'.langs_id as langs_id_names',
				$art_names.'.title as title',
				$art_names.'.slug as slug',
				$art_names.'.intro as intro',
				$art_names.'.created_at as names_created_at',
				$art_names.'.updated_at as names_updated_at',
			]);
		if($order!=[])
			foreach ($order as $column => $direction) {
				$resultset->orderBy($column, $direction);
			}
		if($paginate==0)
			return $resultset->get();

		return $resultset->paginate($paginate);
	}
	public static function get_article_content($token_obj, $langs_id, $paginate = 0){
		$art_content = (Config('database.prefix')??'').'website_articles_content';
		$resultset = DB::table($art_content)
			->where('langs_id', $langs_id)
			->where('token', $token_obj);
		if($paginate==0)
			return $resultset->get();
		return $resultset->paginate($paginate);

	}
}