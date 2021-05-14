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
		
		{{-- <pre> --}}
			{{-- {{print_r($data, true)}} --}}
		{{-- </pre> --}}
	</content>
	<aside>
		<ul class="articles_list">
		@if(count($data['articles'])>0)
		@foreach($data['articles'] as $r)
			<li>
				<a href="{{$data['navigation']['data']->link.'/'.$r->slug}}">
					<img src="{{ (json_decode($r->images_resized, true)['ilustration']['1400']) }}" alt="{{$r->title}}">
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



{{-- 
[article] => stdClass Object
        (
            [token] => 72fcee3c15a8b4cef53e7f88c1dbf01f7dc37e44fc4429e412961189b6b4e6a0
            [sort] => 
            [access] => *
            [frontend_access] => *
            [active] => 1
            [ilustration] => /themes/default/media/site/bkg_car.jpg
            [images_resized] => {
            "og_image":{"15":"\/themes\/default\/media\/store\/wa\/og\/15\/2021-04-21-morbi-interdum-mattis-diam-at-rutrum-nunc-aliquam-at.jpg","30":"\/themes\/default\/media\/store\/wa\/og\/30\/2021-04-21-morbi-interdum-mattis-diam-at-rutrum-nunc-aliquam-at.jpg","100":"\/themes\/default\/media\/store\/wa\/og\/100\/2021-04-21-morbi-interdum-mattis-diam-at-rutrum-nunc-aliquam-at.jpg","200":"\/themes\/default\/media\/store\/wa\/og\/200\/2021-04-21-morbi-interdum-mattis-diam-at-rutrum-nunc-aliquam-at.jpg","300":"\/themes\/default\/media\/store\/wa\/og\/300\/2021-04-21-morbi-interdum-mattis-diam-at-rutrum-nunc-aliquam-at.jpg","600":"\/themes\/default\/media\/store\/wa\/og\/600\/2021-04-21-morbi-interdum-mattis-diam-at-rutrum-nunc-aliquam-at.jpg","800":"\/themes\/default\/media\/store\/wa\/og\/800\/2021-04-21-morbi-interdum-mattis-diam-at-rutrum-nunc-aliquam-at.jpg","1024":"\/themes\/default\/media\/store\/wa\/og\/1024\/2021-04-21-morbi-interdum-mattis-diam-at-rutrum-nunc-aliquam-at.jpg","1400":"\/themes\/default\/media\/store\/wa\/og\/1400\/2021-04-21-morbi-interdum-mattis-diam-at-rutrum-nunc-aliquam-at.jpg","1980":"\/themes\/default\/media\/store\/wa\/og\/1980\/2021-04-21-morbi-interdum-mattis-diam-at-rutrum-nunc-aliquam-at.jpg"},
            "ilustration":{"15":"\/themes\/default\/media\/store\/wa\/ilustrations\/15\/2021-04-21-morbi-interdum-mattis-diam-at-rutrum-nunc-aliquam-at.jpg","30":"\/themes\/default\/media\/store\/wa\/ilustrations\/30\/2021-04-21-morbi-interdum-mattis-diam-at-rutrum-nunc-aliquam-at.jpg","100":"\/themes\/default\/media\/store\/wa\/ilustrations\/100\/2021-04-21-morbi-interdum-mattis-diam-at-rutrum-nunc-aliquam-at.jpg","200":"\/themes\/default\/media\/store\/wa\/ilustrations\/200\/2021-04-21-morbi-interdum-mattis-diam-at-rutrum-nunc-aliquam-at.jpg","300":"\/themes\/default\/media\/store\/wa\/ilustrations\/300\/2021-04-21-morbi-interdum-mattis-diam-at-rutrum-nunc-aliquam-at.jpg","600":"\/themes\/default\/media\/store\/wa\/ilustrations\/600\/2021-04-21-morbi-interdum-mattis-diam-at-rutrum-nunc-aliquam-at.jpg","800":"\/themes\/default\/media\/store\/wa\/ilustrations\/800\/2021-04-21-morbi-interdum-mattis-diam-at-rutrum-nunc-aliquam-at.jpg","1024":"\/themes\/default\/media\/store\/wa\/ilustrations\/1024\/2021-04-21-morbi-interdum-mattis-diam-at-rutrum-nunc-aliquam-at.jpg","1400":"\/themes\/default\/media\/store\/wa\/ilustrations\/1400\/2021-04-21-morbi-interdum-mattis-diam-at-rutrum-nunc-aliquam-at.jpg","1980":"\/themes\/default\/media\/store\/wa\/ilustrations\/1980\/2021-04-21-morbi-interdum-mattis-diam-at-rutrum-nunc-aliquam-at.jpg"},"icon":null}
            [date_from] => 2021-04-21
            [date_to] => 
            [created_at] => 2021-04-22 00:38:46
            [updated_at] => 2021-04-22 00:38:46
            [langs_id_names] => pl
            [title] => Morbi interdum mattis diam, at rutrum nunc aliquam at.
            [slug] => morbi-interdum-mattis-diam-at-rutrum-nunc-aliquam-at
            [intro] => <p>Nulla facilisi. Morbi sem risus, commodo dictum tortor id, sollicitudin interdum dolor. Quisque facilisis molestie quam nec euismod. Maecenas ante magna, ullamcorper vel lectus in, dignissim sodales mauris. Sed tempor nulla vel neque luctus feugiat. Mauris mollis interdum pretium. Phasellus nec nulla aliquet, tempus lectus eget, aliquam tellus. Mauris et vulputate dui. Duis sodales lacus mauris.</p>
            [names_created_at] => 2021-04-22 00:38:46
            [names_updated_at] => 2021-04-22 00:38:46
        )
 --}}