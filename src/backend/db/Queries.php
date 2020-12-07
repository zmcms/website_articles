<?php
namespace Zmcms\WebsiteArticles\Backend\Db;
use Illuminate\Support\Facades\DB;
use Session;
use Request;
class Queries{
	/**
	 * LISTA ARTYKUŁÓW W SERWISIE
	 * Formaty zmiannych:
	 * 	$paginate (stronicowanie): 
	 *		if==0, wyświetla wszystko, 
	 * 		if==X: wyświetla wynik podzielony na strony, X elementów każda
	 * 	$order (sortowanie), tablica o poniższym formacie: 
	 * 		['sort' => 'asc', 'name' => 'desc']
	 * 	$filter (filtrowanie wyników)
	 * 		[
	 *			['langs_id', 	'=',		'pl'	],
	 *			['name', 		'rlike',	'główne'],
	 *		]
	 */
	public static function articles_list($paginate = 0, $order=[], $filter=[]){
		$art = (Config('database.prefix')??'').'website_articles';
		$art_names = (Config('database.prefix')??'').'website_articles_names';
		$art_content = (Config('database.prefix')??'').'website_articles_content';
		$offers_relations = (Config('database.prefix')??'').'offers_relations';
		$offers = DB::table($offers_relations)
			->select([
				'offers_token',
				'object_token',
				'q',
			])
			->distinct();
		$resultset = DB::table($art)
			->join($art_names, $art.'.token', '=', $art_names.'.token')
			->leftJoinSub($offers, $as='d', $art.'.token', $operator = '=', $second = 'd.object_token');
		if($filter!=[])
			foreach($filter as $v) {
				$resultset->where($v[0], $v[1], $v[2]);
			}
			$resultset->select([
				'd.offers_token as offers_token',
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
	/**
	 * WYBIERANIE POJEDYNCZEGO ARTYKUŁU WG KRYTERIUM Z FILTRA
	 * Formaty zmiannych:
	 * 	$filter (filtrowanie wyników)
	 * 		[
	 *			['langs_id', 	'=',		'pl'	],
	 *			['name', 		'rlike',	'główne'],
	 *		]
	 * 	$order (sortowanie), tablica o poniższym formacie: 
	 * 		['sort' => 'asc', 'name' => 'desc']
	 */
	public static function article_get($token, $langs_id, $pageName = 'page', $pageNumber = null){
		$art = (Config('database.prefix')??'').'website_articles';
		$art_names = (Config('database.prefix')??'').'website_articles_names';
		$art_content = (Config('database.prefix')??'').'website_articles_content';
		$resultset['data'] = DB::table($art)
			->join($art_names, $art.'.token', '=', $art_names.'.token')
			->where($art.'.token', $token)
			->where($art_names.'.langs_id', $langs_id)
			->select([
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
				$art_names.'.langs_id as langs_id',
				$art_names.'.title as title',
				$art_names.'.slug as slug',
				$art_names.'.intro as intro',
				$art_names.'.created_at as names_created_at',
				$art_names.'.updated_at as names_updated_at',
			])
			->first();
		$resultset['content'] = DB::table($art_content)
			->where($art_content.'.token', $token)
			->where($art_content.'.langs_id', $langs_id)
			->select([
				$art_content.'.langs_id as langs_id',
				$art_content.'.page as page',
				$art_content.'.subtitle as subtitle',
				$art_content.'.content as content',
				$art_content.'.meta_keywords as meta_keywords',
				$art_content.'.meta_description as meta_description',
				$art_content.'.og_title as og_title',
				$art_content.'.og_type as og_type',
				$art_content.'.og_url as og_url',
				$art_content.'.og_image as og_image',
				$art_content.'.og_description as og_description',
				$art_content.'.created_at as content_created_at',
				$art_content.'.updated_at as content_updated_at',
			])
			->paginate($perPage = 1, $columns = ['*'], $pageName = 'page', $page = $pageNumber);
			// ->setBaseUrl('aaa');
			return $resultset;
	}

	public static function article_page_create($data){
		$art = (Config('database.prefix')??'').'website_articles';
		$art_names = (Config('database.prefix')??'').'website_articles_names';
		$art_content = (Config('database.prefix')??'').'website_articles_content';
		try{
			DB::beginTransaction();
			DB::table($art_content)->insert([
				'token'=>$data['data']['token'],
				'langs_id'=>$data['data']['langs_id'],
				'page'=>$data['content']['page'],
				'subtitle'=>$data['content']['subtitle'],
				'content'=>$data['content']['content'],
				'meta_keywords'=>$data['content']['meta_keywords'],
				'meta_description'=>$data['content']['meta_description'],
				'og_title'=>$data['content']['og_title'],
				'og_type'=>$data['content']['og_type'],
				'og_url'=>$data['content']['og_url'],
				'og_image'=>$data['content']['og_image'],
				'og_description'=>$data['content']['og_description'],
			]);
			DB::commit();
			return json_encode([
				'result'	=>	'ok',
				'code'		=>	'ok',
				'msg' 		=>	___('Dodano nową stronę do artykułu'.' "'.$data['names']['title'].'"'),
			]);
		}catch(\Illuminate\Database\QueryException $e){
			DB::rollBack();
			return json_encode([
				'result'	=>	'error',
				'code'		=>	$e->getCode(),
				'msg' 		=>	___('Nie można dodać strony artykułu'.' "'.$data['names']['title'].'"'),
			]);
		}
	}

	public static function article_page_delete($token, $langs_id, $page){
		$art_content = (Config('database.prefix')??'').'website_articles_content';
		try{
			DB::beginTransaction();
			DB::table($art_content)
				->where('token', $token)
				->where('langs_id', $langs_id)
				->where('page', $page)
				->delete();
			DB::commit();
			return json_encode([
				'result'	=>	'ok',
				'code'		=>	'ok',
				'msg' 		=>	___('Usunięto stronę do artykułu'),
			]);
		}catch(\Illuminate\Database\QueryException $e){
			DB::rollBack();
			return json_encode([
				'result'	=>	'error',
				'code'		=>	$e->getCode(),
				'msg' 		=>	___('Nie można usunąć strony artykułu'),
			]);
		}
	}
	public static function article_pages_count($token, $langs_id){
		$art_content = (Config('database.prefix')??'').'website_articles_content';
		return DB::table($art_content)
			->where('token', $token)
			->where('langs_id', $langs_id)
			->count();
	}
	public static function article_update($data){
		$art = (Config('database.prefix')??'').'website_articles';
		$art_names = (Config('database.prefix')??'').'website_articles_names';
		$art_content = (Config('database.prefix')??'').'website_articles_content';
		try{
			DB::beginTransaction();
			DB::table($art)
				->where('token', $data['data']['token'])
				->update([
					'token'=>$data['data']['token'],
					'sort'=>$data['data']['sort'],
					'access'=>$data['data']['access'],
					'frontend_access'=>$data['data']['frontend_access'],
					'active'=>$data['data']['active'],
					'ilustration'=>$data['data']['ilustration'],
					'images_resized'=>$data['data']['images_resized'],
					'date_from'=>$data['data']['date_from'],
					'date_to'=>$data['data']['date_to'],
				]);
			DB::table($art_names)
				->where('token', $data['data']['token'])
				->where('langs_id', $data['data']['langs_id'])
				->update([
					'token'=>$data['data']['token'],
					'langs_id'=>$data['data']['langs_id'],
					'title'=>$data['names']['title'],
					'slug'=>$data['names']['slug'],
					'intro'=>$data['names']['intro'],
				]);
			DB::table($art_content)
				->where('token', $data['data']['token'])
				->where('langs_id', $data['data']['langs_id'])
				->where('page', $data['content']['page'])
				->update([
				'token'=>$data['data']['token'],
				'langs_id'=>$data['data']['langs_id'],
				'page'=>$data['content']['page'],
				'subtitle'=>$data['content']['subtitle'],
				'content'=>$data['content']['content'],
				'meta_keywords'=>$data['content']['meta_keywords'],
				'meta_description'=>$data['content']['meta_description'],
				'og_title'=>$data['content']['og_title'],
				'og_type'=>$data['content']['og_type'],
				'og_url'=>$data['content']['og_url'],
				'og_image'=>$data['content']['og_image'],
				'og_description'=>$data['content']['og_description'],
			]);
			DB::commit();
			return json_encode([
				'result'	=>	'ok',
				'code'		=>	'ok',
				'msg' 		=>	___('Artykuł '.' "'.$data['names']['title'].'" został zaktualizowany.'),
			]);
		}catch(\Illuminate\Database\QueryException $e){
			DB::rollBack();
			return json_encode([
				'result'	=>	'error',
				'code'		=>	$e->getCode(),
				'msg' 		=>	___('Nie można dodać zaktualizować artykułu'.' "'.$data['names']['title'].'"'),
			]);
		}
	}
	public static function article_create($data){
		$art = (Config('database.prefix')??'').'website_articles';
		$art_names = (Config('database.prefix')??'').'website_articles_names';
		$art_content = (Config('database.prefix')??'').'website_articles_content';
		$token = hash ('sha256', date('Ymd').rand(0,1000));
		try{
			DB::beginTransaction();
			DB::table($art)
				->insert([
					'token'=>$token,
					'sort'=>$data['data']['sort'],
					'access'=>$data['data']['access'],
					'frontend_access'=>$data['data']['frontend_access'],
					'active'=>$data['data']['active'],
					'ilustration'=>$data['data']['ilustration'],
					'images_resized'=>$data['data']['images_resized'],
					'date_from'=>$data['data']['date_from'],
					'date_to'=>$data['data']['date_to'],
				]);
			DB::table($art_names)
				->insert([
					'token'=>$token,
					'langs_id'=>$data['data']['langs_id'],
					'title'=>$data['names']['title'],
					'slug'=>$data['names']['slug'],
					'intro'=>$data['names']['intro'],
				]);
			DB::table($art_content)
				->insert([
					'token'=>$token,
					'langs_id'=>$data['data']['langs_id'],
					'page'=>$data['content']['page'],
					'subtitle'=>$data['content']['subtitle'],
					'content'=>$data['content']['content'],
					'meta_keywords'=>$data['content']['meta_keywords'],
					'meta_description'=>$data['content']['meta_description'],
					'og_title'=>$data['content']['og_title'],
					'og_type'=>$data['content']['og_type'],
					'og_url'=>$data['content']['og_url'],
					'og_image'=>$data['content']['og_image'],
					'og_description'=>$data['content']['og_description'],
				]);
			DB::commit();
			return json_encode([
				'result'	=>	'ok',
				'code'		=>	'ok',
				'msg' 		=>	___('Dodano nowy artykuł.'),
			]);
		}catch(\Illuminate\Database\QueryException $e){
			DB::rollBack();
			return json_encode([
				'result'	=>	'error',
				'code'		=>	$e->getCode(),
				'msg' 		=>	___('Nie można dodać nowego artykułu.'),
			]);
		}
	}
}
