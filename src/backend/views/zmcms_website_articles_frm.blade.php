@extends('themes.'.Config('zmcms.frontend.theme_name').'.backend.main')
<?php
	$active= ($data['data']->active ?? null);
?>
@section('content')
<h1 class="">{{$settings['title'] ?? ___('Artykuł')}}</h1>
<form class="" id="zmcms_website_article_frm" method="post" enctype="multipart/form-data">
    <div class="micro12 medium6">
    <input id="wa_title_txt" class="micro12 mini10 required" type="text" name="names[title]" value="{{$data['data']->title ?? null}}" placeholder=" ">
    <label for="wa_title_txt" class="micro12">Tytuł</label>
    </div>
    <div class="micro12 mini2 medium1">
    <input id="wa_slig_txt" type="text" name="names[slug]" value="{{$data['data']->slug ?? null}}" placeholder=" ">
    <label for="wa_slig_txt" >Slug</label>
    </div>
    <div class="micro12 mini1 medium1">
    <input id="wa_sort_txt" type="text" name="data[sort]" value="{{$data['data']->sort ?? null}}" placeholder=" ">
    <label for="wa_sort_txt">Sort</label>
    </div>
    <div class="micro12 mini3 medium2">
    <select name="data[access]">
        @foreach(Config(Config('zmcms.frontend.theme_name').'.user_roles') as  $r => $v)
        <option value="{{$r}}">{{$v['name']}}</option>
        @endforeach
    </select>
    <label>Dostęp - backend</label>
    </div>
    <div class="micro12 mini3 medium2">
    <select id="wa_frontend_access_txt" name="data[frontend_access]">
        @foreach(Config(Config('zmcms.frontend.theme_name').'.frontend_user_roles') as  $r => $v)
        <option value="{{$r}}">{{$v['name']}}</option>
        @endforeach
    </select>
    <label for="wa_frontend_access_txt" >Dostęp-front</label>
    </div>
    <div class="micro6 mini3 medium1">
    <select id="wa_active_txt" name="data[active]">
        <option value="0" @if($active== '0') selected="selected"@endif>{{___('NIE')}}</option>
        <option value="1" @if($active== '1') selected="selected"@endif>{{___('TAK')}}</option>
    </select>
    <label for="wa_active_txt">Aktywny?</label>
    </div>
    <div class="micro6 mini2 medium1">
        <input id="wa_langs_id_txt" type="text" name="data[langs_id]" value="{{$data['data']->langs_id ?? Config(Config('zmcms.frontend.theme_name').'.main.lang_default')}}" placeholder=" ">
        <label for="wa_langs_id_txt">Język</label>
    </div>
    <div class="micro6 mini3">
        <input type="date" name="data[date_from]" value="{{$data['data']->date_from ?? date('Y-m-d')}}" placeholder=" ">
        <label>Data od</label>
    </div>
    <div class="micro6 mini3">
        <input type="date" name="data[date_to]" value="{{$data['data']->date_to ?? null}}" placeholder=" ">
        <label>Data do</label>
    </div>
    <div class="micro12 mini4">
        <div class="micro8 mini6">
        <input id="zcwa_btn_article_ilustration_fld" type="text" name="data[ilustration]" value="{{$data['data']->ilustration ?? null}}" placeholder=" ">
        <label>Ilustracja</label>
        </div>
        <div class="micro2 mini3">
            <button id="zcwa_btn_update_article_ilustration" data-selectfld="zcwa_btn_article_ilustration_fld"><span class="fas fa-plus"></span></button>
        </div>
        <div class="micro2 mini3">
            <button id="zcwa_btn_remove_article_ilustration" data-selectfld="zcwa_btn_article_ilustration_fld"><span class="fas fa-trash"></span></button>
        </div>
    </div>
    <h3 class="micro12">Intro</h3>
    <textarea class="richeditor micro12" type="text" cols="25" rows="40" name="names[intro]" placeholder=" " >
        {{$data['data']->intro ?? null}}
    </textarea>
    
    <div id="articles_content_page">
            @include('themes.'.Config('zmcms.frontend.theme_name').'.backend.zmcms_website_articles_frm_content_section')
    </div>
    <input type="text" id="data_action" name="action" value="{{$settings['action'] ?? null}}" placeholder=" ">
    <label>Akcja</label>
    <input type="text" name="data[token]" id="article_token" value="{{$data['data']->token ?? null}}" placeholder=" ">
    <label>Token</label>
    <input id="wa_old_slug_txt" type="text" name="names[old_slug]" value="{{$data['data']->slug ?? null}}" placeholder=" ">
    <label for="wa_old_slug_txt">Old Slug</label>
    <button id="btn_save">{{$settings['btnsave']}}</button>
    <button id="btnsave_and_publish">{{$settings['btnsave_and_publish']}}</button>
</form>

    {{-- <pre>{{print_r($data, true)}}</pre> --}}
@endsection