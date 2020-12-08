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
	<img src="{{ DIRECTORY_SEPARATOR.Config(Config('zmcms.frontend.theme_name').'.media.logo') }}" alt="{{ Config(Config('zmcms.frontend.theme_name').'.contact_data.headquarters.business_name') }}" >
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
<span id="summary"></span>
<header style="background-image: url({{(json_decode($data['article']->images_resized, true)['ilustration']['1024'])}})">
	<div class="color_filter">
		<h1>{{$data['article']->title}}</h1>
		@if(strlen($data['article']->intro)>0)<div class="og_description">{!!$data['article']->intro!!}</div>@endif
	</div>
</header>
<content>
	<article>
		@if(count($data['content'])>1)

			<div class="summary">
				<ul>
				@foreach($data['content'] as $d)
				<li><a href="#p{{$loop->iteration}}">{{$d->subtitle}}</a></li>
				@endforeach
				</ul>
			</div>
		@endif
		@foreach($data['content'] as $d)
			<span id="p{{$loop->iteration}}"></span>
			@if(count($data['content'])>1)<h2>{{$d->subtitle}}</h2>@endif
			{!! $d->content !!}
			@if(count($data['content'])>1)<a class="link_to_top" href="#summary">
				<span class="fas fa-arrow-up"></span> {{___('Wróć do początku')}}</a>
			@endif
		@endforeach
		{{-- <pre>{{print_r($data, true)}}</pre> --}}
	</article>
	<aside>
		@includeIf('themes.'.Config('zmcms.frontend.theme_name').'.frontend.zmcms_main_contact_box')
		{{-- <h2>{{$data['navigation']['data']->name}}</h2> --}}
		{{-- <h3>{{___('Zobacz także')}}</h3> --}}
		<div class="items_lst">
		@foreach($data['articles'] as $d)
			@if($d->token != $data['article']->token)
			<a href="{{$data['navigation']['data']->link}}/{{$d->slug}}">
			<div class="item">
				@if(isset(json_decode($d->images_resized, true)['ilustration']))
						<div class="imgcontainer">
							<img src="{{(json_decode($d->images_resized, true)['ilustration']['300'])}}" alt="{{$d->title}}">
						</div>
					<h2>{{$d->title}}</h2>	
				@else
						<div class="imgcontainer">
							<img src="{{Config(Config('zmcms.frontend.theme_name').'.media.placeholder')}}" alt="{{$d->title}}">
						</div>
					<h2>{{$d->title}}</h2>
				@endif
			</div>
			</a>
			@endif
		@endforeach
		</div>
	</aside>
	</content>
	@include('themes.'.(Config('zmcms.frontend.theme_name').'.frontend.zmcms_google_map'))
	@include('themes.'.(Config('zmcms.frontend.theme_name').'.frontend.footer'))

{!! zmcms_html_js('themes/'.Config('zmcms.frontend.theme_name').'/frontend/js', false) !!}
@stack('custom_js')
@include('themes.'.Config('zmcms.frontend.theme_name').'.frontend.zmcms_main_ajax_dialog_box')
</body>
</html>