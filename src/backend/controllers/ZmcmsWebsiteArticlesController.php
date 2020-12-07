<?php
namespace Zmcms\WebsiteArticles\Backend\Controllers;
use Illuminate\Http\Request;
use Session;
use Zmcms\WebsiteArticles\Backend\Db\Queries as Q;

class ZmcmsWebsiteArticlesController extends \App\Http\Controllers\Controller
{
	public function articles_list(){
		$data= [];
		$art = (Config('database.prefix')??'').'website_articles';

		$resultset = Q::articles_list($paginate = 20, $order=[$art.'.created_at'=>'desc'], $filter=[]);
		return view('themes.milekcompl.backend.zmcms_website_articles_panel', compact('data', 'resultset'));
		return '<pre>'.print_r($resultset, true).'</pre>';
	}
	public function articles_save(Request $request){
		$data = $request->all();
		switch($data['action']){
			case 'article_page_create':{
				return $this->article_page_create($request);
			}
			case 'edit':{
				return $this->article_update($request);
			}
			case 'create':{
				return $this->article_create($request);	
			}
		}

		return json_encode([
				'result'	=>	'ok',
				'code'		=>	'ok',
				'msg' 		=>	'<pre>'.print_r($request->all(), true).'</pre>',
		]);
	}
	/**
	 * TWORZENIE NOWEGO ARTYKUŁU
	 */
	public function article_create(Request $request){

		$data = $request->all();
		$d['icon'] = $d['ilustration'] = $d['og_image'] = null;
		if(strlen($data['data']['ilustration']) > 4) $d['ilustration'] = zmcms_image_save(
				base_path().DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.$data['data']['ilustration'],
				base_path().DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.Config('zmcms.frontend.theme_name').DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'store'.DIRECTORY_SEPARATOR.'wa'.DIRECTORY_SEPARATOR.'ilustrations',
				str_slug(date('Y-m-d').'-'.$data['names']['title']).'.jpg'
		);
		if(strlen($data['content']['og_image']) > 4) $d['og_image'] = zmcms_image_save(
				base_path().DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.$data['content']['og_image'],
				base_path().DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.Config('zmcms.frontend.theme_name').DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'store'.DIRECTORY_SEPARATOR.'wa'.DIRECTORY_SEPARATOR.'og',
				str_slug(date('Y-m-d').'-'.$data['names']['title']).'.jpg'
		);
		$data['data']['images_resized'] = json_encode($d);
		return Q::article_create($data);
		return json_encode([
				'result'	=>	'ok',
				'code'		=>	'ok',
				'msg' 		=>	'<pre>'.print_r($request->all(), true).'</pre>',
		]);	
	}
	/**
	 * TWORZENIE NOWEJ STRONY ARTYKUŁU
	 */
	public function article_page_create(Request $request){
		$data = $request->all();
		$d['icon'] = $d['ilustration'] = $d['og_image'] = null;
		if(strlen($data['data']['ilustration']) > 4) $d['ilustration'] = zmcms_image_save(
				base_path().DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.$data['data']['ilustration'],
				base_path().DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.Config('zmcms.frontend.theme_name').DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'store'.DIRECTORY_SEPARATOR.'wa'.DIRECTORY_SEPARATOR.'ilustrations',
				str_slug(date('Y-m-d').'-'.$data['names']['title']).'.jpg'
		);
		if(strlen($data['content']['og_image']) > 4) $d['og_image'] = zmcms_image_save(
				base_path().DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.$data['content']['og_image'],
				base_path().DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.Config('zmcms.frontend.theme_name').DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'store'.DIRECTORY_SEPARATOR.'wa'.DIRECTORY_SEPARATOR.'og',
				str_slug(date('Y-m-d').'-'.$data['names']['title']).'.jpg'
		);
		$data['data']['images_resized'] = $d;
		// return json_encode([
				// 'result'	=>	'ok',
				// 'code'		=>	'ok',
				// 'msg' 		=>	'<pre>'.print_r($request->all(), true).'</pre>',
		// ]);	
		return Q::article_page_create($data);
	}
	/**
	 * ZAPISANIE ZMIAN W ARTYKULE
	 */
	public function article_update(Request $request){
		$data = $request->all();
		$data['data']['images_resized'] = null;
		$d['icon'] = $d['ilustration'] = $d['og_image'] = null;
		if(strlen($data['data']['ilustration']) > 4) $d['ilustration'] = zmcms_image_save(
				base_path().DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.$data['data']['ilustration'],
				base_path().DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.Config('zmcms.frontend.theme_name').DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'store'.DIRECTORY_SEPARATOR.'wa'.DIRECTORY_SEPARATOR.'ilustrations',
				str_slug(date('Y-m-d').'-'.$data['names']['title']).'.jpg'
		);
		if(strlen($data['content']['og_image']) > 4) $d['og_image']  = zmcms_image_save(
				base_path().DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.$data['content']['og_image'],
				base_path().DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.Config('zmcms.frontend.theme_name').DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'store'.DIRECTORY_SEPARATOR.'wa'.DIRECTORY_SEPARATOR.'og',
				str_slug(date('Y-m-d').'-'.$data['names']['title']).'.jpg'
		);
			$data['data']['images_resized'] = $d;
		// return json_encode([
				// 'result'	=>	'ok',
				// 'code'		=>	'ok',
				// 'msg' 		=>	'<pre>'.print_r($request->all(), true).'</pre>',
		// ]); 
		return Q::article_update($data);
	}
	/**
	 * FILTROWANIE ARTYKUŁÓW
	 */
	public function zmcms_website_articles_filter(Request $request){
		$art = (Config('database.prefix')??'').'website_articles';
		$art_names = (Config('database.prefix')??'').'website_articles_names';
		$filter = [
			['title', 'rlike', $request->all()['filter']],
		];
		$resultset = Q::articles_list($paginate = 20, $order=[$art.'.created_at'=>'desc'], $filter);
		return view('themes.'.Config('zmcms.frontend.theme_name').'.backend.zmcms_articles_list', compact('resultset'));
		return print_r($request->all(), true);
	}
	public function articles_edit($token){
		// $art = (Config('database.prefix')??'').'website_articles';
		$data = Q::article_get($token, 'pl');
		$settings=[
			'title'	=> 'Edycja artykułu "'.$data['data']->title.'"',
			'action' => 'edit',
			'btnsave' => 'Zapisz zmiany',
			'btnsave_and_publish' => 'Zapisz zmiany i opublikuj',
		];
		return view('themes.'.Config('zmcms.frontend.theme_name').'.backend.zmcms_website_articles_frm', compact('data', 'settings'));
		return 'token: '.$token;
	}

	public function zmcms_website_articles_paginator($token, $page){
		$data = Q::article_get($token, $langs_id = 'pl', $pageName = 'page', $pageNumber = $page);
		$settings=[
			'title'	=> 'Nowy artykuł',
			'action' => 'create',
			'btnsave' => 'Zapisz',
			'btnsave_and_publish' => 'Zapisz i opublikuj',
		];
		return view('themes.'.Config('zmcms.frontend.theme_name').'.backend.zmcms_website_articles_frm_content_section', compact('data', 'settings'));

	}
	public function zmcms_website_articles_page_delete($token, $langs_id, $page){
		if(Q::article_pages_count($token, $langs_id)>1)
			return Q::article_page_delete($token, $langs_id, $page);
		else 
			return json_encode([
				'result'	=>	'error',
				'code'		=>	'article_one_page_only',
				'msg' 		=>	___('Otwarty artykuł ma tylko jedną stronę. Nie można jej usunąć.'),
			]);
		// return print_r([$token, $langs_id, $page], true);
	}
	/**
	 * TWORZENIE NOWEGO ARTYKUŁU
	 */
	public function articles_create_frm(){
		$data = [];
		$settings=[
			'title'	=> 'Nowy artykuł',
			'action' => 'create',
			'btnsave' => 'Zapisz zmiany',
			'btnsave_and_publish' => 'Zapisz zmiany i opublikuj',
		];
		return view('themes.'.Config('zmcms.frontend.theme_name').'.backend.zmcms_website_articles_frm', compact('data', 'settings'));
	}

	public function zmcms_website_article_ajax_selector(Request $request, $offer_token, $type){
		$resultset = Q::articles_list($paginate = 0, $order=[], $filter=[]);
		$data = [];
		
		foreach ($resultset as $r) {
			$data[]=[
				'in_offer'=>$r->offers_token,
				'token'=>$r->token,
				'offer_token'=>$offer_token,
				'type'=>$type,
				'name'=>$r->title,
				'slug'=>$r->slug,
				'images_resized'=>$r->images_resized,
				'code'=>null,
				'ean13'=>null,
				'ean128'=>null,
			];
		}
		return $data;
	}

}
