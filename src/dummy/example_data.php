<?php
namespace Zmcms\WebsiteNavigations;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades;
$articles =[
	['token' => '1', 'sort' => NULL, 'access' => '*', 'frontend_access' => '*', 'active' => '1', 'ilustration' => NULL, 'images_resized' => NULL, 'date_from' => date('Y-m-d'), 'date_to' => NULL,],
	['token' => '2', 'sort' => NULL, 'access' => '*', 'frontend_access' => '*', 'active' => '1', 'ilustration' => NULL, 'images_resized' => NULL, 'date_from' => date('Y-m-d'), 'date_to' => NULL,],
];

$articles_names = [
	[
		'token'=>'1',
		'langs_id'=>'pl',
		'title'=>'To jest tytuł artykułu jakiegoś pierwszego',
		'slug'=>str_slug('To jest tytuł artykułu jakiegoś pierwszego'),
		'intro'=>'<p>Intro dla tokenu 1.</p><p>Lorem Ipsum jest tekstem stosowanym jako przykładowy wypełniacz w przemyśle poligraficznym. Został po raz pierwszy użyty w XV w. przez nieznanego drukarza do wypełnienia tekstem próbnej książki.</p>',
	],
	[
		'token'=>'2',
		'langs_id'=>'pl',
		'title'=>'To jest tytuł artykułu jakiegoś drugiego',
		'slug'=>str_slug('To jest tytuł artykułu jakiegoś pierwszego'),
		'intro'=>'<p>Intro dla tokenu 2.</p><p>Pięć wieków później zaczął być używany przemyśle elektronicznym, pozostając praktycznie niezmienionym.</p>',
	],
];
$articles_content = [
	[ // ARTYKUŁ JEDNOSTRONICOWY. Kolumna subtitle jest NULL, nie trzeba jej w tym wypadku wypełniać.
		'token'=>'1',
		'langs_id'=>'pl',
		'page'=>1,
		'subtitle'=>NULL,
		'content'=>'<p>Jest dostępnych wiele różnych wersji Lorem Ipsum, ale większość zmieniła się pod wpływem dodanego humoru czy przypadkowych słów, które nawet w najmniejszym stopniu nie przypominają istniejących. Jeśli masz zamiar użyć fragmentu Lorem Ipsum, lepiej mieć pewność, że nie ma niczego „dziwnego” w środku tekstu. Wszystkie Internetowe generatory Lorem Ipsum mają tendencje do kopiowania już istniejących bloków, co czyni nasz pierwszym prawdziwym generatorem w Internecie. Używamy zawierającego ponad 200 łacińskich słów słownika, w kontekście wielu znanych sentencji, by wygenerować tekst wyglądający odpowiednio. To wszystko czyni „nasz” Lorem Ipsum wolnym od powtórzeń, humorystycznych wstawek czy niecharakterystycznych słów.</p>',
		'meta_keywords'=>'lorem, ipsum, wersie lorem ipsum',
		'meta_description'=>'Artykuł opisuje ciekawe treści o lorem ipsum',
		'og_title'=>'O lorem ipsum nieco inaczej',
		'og_type'=>'website',
		'og_url'=>null,
		'og_image'=>null,
		'og_description'=>'Ciekawe treści o lorem ipsum',
	],
	[ // ARTYKUŁ JEDNOSTRONICOWY. Kolumna page jest NULL
		'token'=>'2',
		'langs_id'=>'pl',
		'page'=>1,
		'subtitle'=>'Podtytuł pierwszej strony artykułu wielostronicowego',
		'content'=>'<p>Jest dostępnych wiele różnych wersji Lorem Ipsum, ale większość zmieniła się pod wpływem dodanego humoru czy przypadkowych słów, które nawet w najmniejszym stopniu nie przypominają istniejących. Jeśli masz zamiar użyć fragmentu Lorem Ipsum, lepiej mieć pewność, że nie ma niczego „dziwnego” w środku tekstu. Wszystkie Internetowe generatory Lorem Ipsum mają tendencje do kopiowania już istniejących bloków, co czyni nasz pierwszym prawdziwym generatorem w Internecie. Używamy zawierającego ponad 200 łacińskich słów słownika, w kontekście wielu znanych sentencji, by wygenerować tekst wyglądający odpowiednio. To wszystko czyni „nasz” Lorem Ipsum wolnym od powtórzeń, humorystycznych wstawek czy niecharakterystycznych słów.</p>',
		'meta_keywords'=>'lorem, ipsum, wersie lorem ipsum',
		'meta_description'=>'Artykuł opisuje ciekawe treści o lorem ipsum',
		'og_title'=>'O lorem ipsum nieco inaczej',
		'og_type'=>'website',
		'og_url'=>null,
		'og_image'=>null,
		'og_description'=>'Ciekawe treści o lorem ipsum',
	],
	[ // ARTYKUŁ JEDNOSTRONICOWY. Kolumna page jest NULL
		'token'=>'2',
		'langs_id'=>'pl',
		'page'=>2,
		'subtitle'=>'A to jest Podtytuł pierwszej strony artykułu wielostronicowego',
		'content'=>'<p>Jest dostępnych wiele różnych wersji Lorem Ipsum, ale większość zmieniła się pod wpływem dodanego humoru czy przypadkowych słów, które nawet w najmniejszym stopniu nie przypominają istniejących. Jeśli masz zamiar użyć fragmentu Lorem Ipsum, lepiej mieć pewność, że nie ma niczego „dziwnego” w środku tekstu. Wszystkie Internetowe generatory Lorem Ipsum mają tendencje do kopiowania już istniejących bloków, co czyni nasz pierwszym prawdziwym generatorem w Internecie. Używamy zawierającego ponad 200 łacińskich słów słownika, w kontekście wielu znanych sentencji, by wygenerować tekst wyglądający odpowiednio. To wszystko czyni „nasz” Lorem Ipsum wolnym od powtórzeń, humorystycznych wstawek czy niecharakterystycznych słów.</p>',
		'meta_keywords'=>'lorem, ipsum, wersie lorem ipsum',
		'meta_description'=>'Artykuł opisuje ciekawe treści o lorem ipsum',
		'og_title'=>'O lorem ipsum nieco inaczej',
		'og_type'=>'website',
		'og_url'=>null,
		'og_image'=>null,
		'og_description'=>'Ciekawe treści o lorem ipsum',
	],
];


$tblNamePrefix=(Config('database.prefix')??'');
$tblName=$tblNamePrefix.'website_articles';
foreach($articles as $a){
	DB::table($tblName)->insert([
		'token'=>$a['token'],
		'sort'=>$a['sort'],
		'access'=>$a['access'],
		'frontend_access'=>$a['frontend_access'],
		'active'=>$a['active'],
		'ilustration'=>$a['ilustration'],
		'images_resized'=>$a['images_resized'],
		'date_from'=>$a['date_from'],
		'date_to'=>$a['date_to'],
	]);
}

$tblName=$tblNamePrefix.'website_articles_names';
foreach($articles_names as $a){
	DB::table($tblName)->insert([
		'token'=>$a['token'],
		'langs_id'=>$a['langs_id'],
		'title'=>$a['title'],
		'slug'=>$a['slug'],
		'intro'=>$a['intro'],
	]);
}

$tblName=$tblNamePrefix.'website_articles_content';
foreach($articles_content as $a){
	DB::table($tblName)->insert([
		'token'=>$a['token'],
		'langs_id'=>$a['langs_id'],
		'page'=>$a['page'],
		'subtitle'=>$a['subtitle'],
		'content'=>$a['content'],
		'meta_keywords'=>$a['meta_keywords'],
		'meta_description'=>$a['meta_description'],
		'og_title'=>$a['og_title'],
		'og_type'=>$a['og_type'],
		'og_url'=>$a['og_url'],
		'og_image'=>$a['og_image'],
		'og_description'=>$a['og_description'],
	]);
}
