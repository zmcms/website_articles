<!DOCTYPE html>
<html lang="pl-PL">
<?php (!isset($head))?$head = zmcms_get_initial_head_data($theme = Config('frontend.theme_name')):null; ?>
	<head>	
	@include('themes.'.Config('zmcms.frontend.theme_name').'.frontend.zmcms_html_header')
	@includeIf('themes.'.Config('frontend.theme_name').'.seo.google_script')
	</head>
<body>
<a href="/">
<div class="logo">	
<img src="{{ Config(Config('zmcms.frontend.theme_name').'.media.logo') }}" alt="{{ Config(Config('zmcms.frontend.theme_name').'.contact_data.headquarters.business_name') }}" >
</div>
</a>
<nav id="main">
		<div class="mobile_control">
			<a href="" id="btn_phone" title="{{___('Zadzwoń')}}"><span class="fas fa-phone-square"></span></a>
			<a href="" id="btn_bars" title="{{___('Otwórz menu')}}"><span class="fas fa-bars"></span></a>
			<a href="" id="btn_times" class="hidden" title="{{___('Zamknij menu')}}"><span class="fas fa-times"></span></a>
		</div>
</nav>
<nav id="main_positions" class="mobile_hide">
		<ul id="mnu_main">{{zmcms_website_navigations_frontend($position = 'main', $parent = null, $to_file=false)}}</ul>
</nav>
	<header style="background-image: url({{(json_decode($data['navigation']['data']->images_resized, true)['og_image']['1400'])}})">

	<div class="color_filter">
		<h1>{{$data['navigation']['data']->name}}</h1>
		@if(strlen($data['navigation']['data']->og_description)>3)
			<div class="og_description">{{$data['navigation']['data']->og_description}}</div>
		@endif
	</div>
	</header>
	<content>
		{{-- <pre>{{print_r($data, true)}}</pre> --}}
		{!! $data['navigation']['data']->content !!}
		<div class="items_lst">
		@foreach($data['articles'] as $r)
		<a href="{{$data['navigation']['data']->link.'/'.$r->slug}}">
		<div class="item">
			<div class="imgcontainer">
				<img src="{{json_decode($r->images_resized, true)['ilustration']['300']}}" alt="{{$r->title}}" />
			</div>
			<h2>{{$r->title}}</h2>
		</div>
		</a>
		@endforeach
		</div>
		{{-- <h1>SELF</h1> --}}
		{{-- <pre>{{print_r($data, true)}}</pre> --}}

		{{-- {{print_r($data['articles'], true)}} --}}
	</content>
	@include('themes.'.(Config('zmcms.frontend.theme_name').'.frontend.zmcms_google_map'))
	@include('themes.'.(Config('zmcms.frontend.theme_name').'.frontend.footer'))

{!! zmcms_html_js('themes/'.Config('zmcms.frontend.theme_name').'/frontend/js', false) !!}
@stack('custom_js')
@include('themes.'.Config('zmcms.frontend.theme_name').'.frontend.zmcms_main_ajax_dialog_box')
</body>
</html>