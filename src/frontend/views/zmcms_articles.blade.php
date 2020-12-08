@extends('themes.'.(Config('zmcms.frontend.theme_name') ?? 'zmcms').'.frontend.main')
@section('content')
<content>
	<h1>ARTYKUŁ</h1>
	{{$str}}<br><br>
	<pre>
		{{print_r($data, true)}}
	</pre>
</content>
@endsection
