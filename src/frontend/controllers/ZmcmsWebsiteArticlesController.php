<?php
namespace Zmcms\WebsiteArticles\Frontend\Controllers;
use Illuminate\Http\Request;
use Zmcms\WebsiteArticles\Frontend\Db\Queries as Q;
use Zmcms\WebsiteNavigations\Frontend\Model\WebsiteNavigationJoined as QN;
use Session;
class ZmcmsWebsiteArticlesController extends \App\Http\Controllers\Controller
{
	public function run($token_nav, $token_obj, $type){
		$str='';
		$data = [];
		$data['navigation']['data'] = QN::get_navigation($token_nav);
		$data['articles'] = Q::get_articles_list($token_nav, $paginate = 0, $order=[], $filter=[]);
		// GDY NAWIGACJA PROWADZI DO TRYBU LISTY
		if($token_nav == $token_obj){
			$head = [
			'title' => $data['navigation']['data']->name.' - '.Config((Config('zmcms.frontend.theme_name') ?? 'zmcms').'.contact_data.headquarters.business_name'),
			'keywords' => $data['navigation']['data']->meta_keywords,
			'description' => $data['navigation']['data']->meta_description,
			'canonical' => $data['navigation']['data']->canonical ?? null,
			'og:title' => $data['navigation']['data']->og_title,
			'og:type' => $data['navigation']['data']->og_type,
			'og:url' => $data['navigation']['data']->og_url,
			'og:image' => $data['navigation']['data']->og_image,
			'og:description' => $data['navigation']['data']->og_description,
			'og:locale' => $data['navigation']['data']->langs_id,
			'language' => $data['navigation']['data']->langs_id,
			];
			return view('themes.'.(Config('zmcms.frontend.theme_name') ?? 'zmcms').'.frontend.zmcms_articles_list', compact('head', 'data', 'str'));
		}else{
			foreach ($data['articles'] as $d) {
				if($d->token == $token_obj) $data['article'] = $d;
				$data['content'] = Q::get_article_content($token_obj, Session::get('language'));
			}
			$meta_keywords = $meta_description = [];
			foreach($data['content'] as $r){
				$meta_keywords[] = $r->meta_keywords;
				$meta_description[] = $r->meta_description;
			}
			$k = implode(', ', $meta_keywords);
			$d = implode(', ', $meta_description);
			$head = [
			'title' => $data['article']->title.' - '.Config((Config('zmcms.frontend.theme_name') ?? 'zmcms').'.contact_data.headquarters.business_name'),

			'keywords' => $k,
			'description' => $d,
			'canonical' => $data['navigation']['data']->canonical ?? null,
			'og:title' => $data['article']->title,
			'og:type' => 'website',
			'og:url' => $data['navigation']['data']->link.'/'.$data['article']->slug,
			'og:image' => $data['article']->og_image ?? null,
			'og:description' => $data['content'][0]->og_description,
			'og:locale' => $data['navigation']['data']->langs_id,
			'language' => $data['navigation']['data']->langs_id,
			];
			return view('themes.'.(Config('zmcms.frontend.theme_name') ?? 'zmcms').'.frontend.zmcms_articles_selected', compact('head', 'data', 'str'));
		}


		$str = 'token_nav: '.$token_nav.', token_obj: '.$token_obj.', type: '.$type;
		return view('themes.'.(Config('zmcms.frontend.theme_name') ?? 'zmcms').'.frontend.zmcms_articles', compact('data', 'str'));
		return 'artykuł /y '.$type;
	}
}
