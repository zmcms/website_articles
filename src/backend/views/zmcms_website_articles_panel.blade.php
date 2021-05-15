@extends('themes.'.Config('zmcms.frontend.theme_name').'.backend.main')
@section('content')
<h1 class="">Zarządzanie artykułami w serwisie www</h1>
<div id="zmcms_website_articles_control_panel" class="control_subbelt_belt">
	<div class="micro12" style="text-align: right;">
		<div class="micro4 mini6 small8">
			<button id="btn_article_new"><span class="fas fa-plus"></span> Nowy artykuł</button>
		</div>
		<div class="micro6 mini4 small4">
			<div class="micro8">
				<input type="text" id="txt_filter" name="filter" placeholder="Szukaj">
			</div>
			<div class="micro4">
				<button class="micro12" id="btn_article_filter"><span class="fas fa-search"></span> Szukaj</button>
			</div>
		</div>
	</div>
</div>
<div id="zmcms_website_articles_control_panel_content">
	@include('themes.'.Config('zmcms.frontend.theme_name').'.backend.zmcms_website_articles_list')
</div>
@endsection
