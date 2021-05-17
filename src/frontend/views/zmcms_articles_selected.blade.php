@extends('themes.'.(Config('zmcms.frontend.theme_name') ?? 'zmcms').'.frontend.main')
@section('content')
	<div class="article_grid">
	<header>
		<h1>{{$data['article']->title}}</h1>
		@if(isset((json_decode($data['article']->images_resized, true)['ilustration'])))
			<img src="{{ (json_decode($data['article']->images_resized, true)['ilustration']['1400']) }}" alt="{{$data['navigation']['data']->name}}">
		@endif
	</header>
	<content>
		@if(count($data['content'])>1)
		<nav class="summary">
			<ul>
			@foreach($data['content'] as $r)
				<li><a href="#part_{{$loop->iteration}}">{{$r->subtitle}}</a></li>
			@endforeach
			</ul>
		</nav>
		@endif
			{!! $data['article']->intro !!}
			@foreach($data['content'] as $r)
				@if(count($data['content'])>1)
					<a class="anhor" id="part_{{$loop->iteration}}"></a>
					<h2>{{$r->subtitle}}</h2>
				@endif
				{!! $r->content !!}
			@endforeach
	</content>
	<aside>
		<ul class="articles_list">
		@if(count($data['articles'])>0)
		@foreach($data['articles'] as $r)
			<li>
				<a href="{{$data['navigation']['data']->link.'/'.$r->slug}}">
					@if(isset((json_decode($r->images_resized, true)['ilustration'])))
						<img src="{{ (json_decode($r->images_resized, true)['ilustration']['1400']) }}" alt="{{$r->title}}">
					@else
						<img src="{{Config((Config('zmcms.frontend.theme_name') ?? 'zmcms').'.media.placeholder')}}" alt="{{$r->title}}">
					@endif
					<h2>{{$r->title}}</h2>
					<div>{!!$r->intro!!}</div>					
				</a>
			</li>
		@endforeach
		@endif
		</ul>
	</aside>
	</div>
@endsection
