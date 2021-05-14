    <?php if($settings['action']=='create') $page = 1; else $page = $data['content']->total(); ?>
    <h3 class="micro12">Treść</h3>
    @if($settings['action']=='edit')
        <div class="pager">
        <input type="hidden" id="content_page" name="content[page]" value="{{$data['content'][0]->page ?? 1}}">
        <div class="micro6 mini8 medium10">
            <input id="content_subtitle" id="content_subtitle" type="text" name="content[subtitle]" value="{{$data['content'][0]->subtitle ?? null}}" placeholder=" ">
            <label class="micro1">Podtytuł</label>
        </div>
        <div class="micro3 mini2 medium1">
            <button id="zcwa_btn_create_page" data-pagecount="{{ $page ?? null }}" data-token="{{$data['data']->token ?? null }}"><span class="fas fa-plus"></span> Nowa</button>
        </div>
        <div class="micro3 mini2 medium1">
        <button id="zcwa_btn_delete_page"  data-page="{{ $data['content'][0]->page ?? null}}" data-token="{{$data['data']->token ?? null }}" data-langs_id="{{ $data['data']->langs_id ?? null }}"><span class="fas fa-trash"></span> Usuń</button>
        </div>
        <div class="micro12">
            {!! (isset($data['content']))?$data['content']->onEachSide(1)->links('themes.'.Config('zmcms.frontend.theme_name').'.backend.paginator'):null !!}
        </div>
    </div>
    @else
        <input id="content_subtitle" type="hidden" name="content[subtitle]" value="{{$data['content'][0]->subtitle ?? null}}" placeholder=" ">
        <input type="hidden" id="content_page" name="content[page]" value="{{$data['content'][0]->page ?? 1}}">
    @endif

    <textarea class="richeditor micro12" type="text" cols="25" rows="40" id="content_content" name="content[content]" placeholder="Jeżeli pozycja jest samodzielna, tu dodajemy wpis" >
        {{$data['content'][0]->content ?? null}}
    </textarea>
    <h3>Dane nagłówkowe (SEO / SEM)</h3>
    <input id="wa_meta_keywords_txt" type="text" id="content_meta_keywords" name="content[meta_keywords]" value="{{$data->meta_keywords ?? null}}" placeholder=" ">
    <label for="wa_meta_keywords_txt">Słowa kluczowe</label>

    <input id="wa_meta_description_txt" type="text" id="content_meta_description" name="content[meta_description]" value="{{$data->meta_description ?? null}}" placeholder=" ">
    <label for="wa_meta_description_txt">Opis dokumentu</label>

    <input id="wa_meta_og_title_txt" type="text" id="content_og_title" name="content[og_title]" value="{{$data->og_title ?? null}}" placeholder=" ">
    <label for="wa_meta_og_title_txt">OPEN GRAPH - Tytuł</label>

    <input id="wa_meta_og_desc_txt" type="text" id="content_og_description" name="content[og_description]" value="{{$data->og_description ?? null}}" placeholder=" ">
    <label for="wa_meta_og_desc_txt">OPEN GRAPH - Opis</label>
    <div class="micro12 mini2">
        <input id="wa_meta_og_type_txt" type="text" id="content_og_type" name="content[og_type]" value="{{$data->og_type ?? null}}" placeholder=" ">
        <label for="wa_meta_og_type_txt">OPEN GRAPH - Rodzaj dokumentu</label>
    </div>
    <div class="micro12 mini4">
        <input id="wa_meta_og_url_txt" type="text" id="content_og_url" name="content[og_url]" value="{{$data->og_url ?? null}}" placeholder=" ">
        <label for="wa_meta_og_url_txt">OPEN GRAPH - Link do dokumentu</label>
    </div>
    <div class="micro12 mini6">
        <div class="micro8">
            <input id="wa_meta_og_image_txt" id="zcwn_btn_og_ilustration_fld" type="text" id="content_og_image" name="content[og_image]" value="{{$data->og_image ?? null}}" placeholder=" ">
            <label for="wa_meta_og_image_txt">OPEN GRAPH - Ilustracja</label>
        </div>
        <div class="micro2">
            <button id="zcwa_btn_create_og_ilustration" data-selectfld="zcwn_btn_og_ilustration_fld"><span class="fas fa-plus"></span></button>
        </div>
        <div class="micro2">
            <button id="zcwa_btn_delete_og_ilustration" data-selectfld="zcwn_btn_og_ilustration_fld"><span class="fas fa-trash"></span></button>
        </div>
    </div>
            <script src="/themes/{{Config('zmcms.frontend.theme_name')}}/backend/js/tinymce/tinymce.min.js"></script>
            <script>
                tinymce.init({
                    selector: '.richeditor',
                    skin: 'oxide',
                    content_css: 'default',
                    language: 'pl',
                    external_filemanager_path:"/themes/{{Config('zmcms.frontend.theme_name')}}/backend/js/filemanager/",
                    filemanager_title:"Manager plików" ,
                    paste_data_images: true,
                    relative_urls : true,
                    remove_script_host : false,
                    external_plugins: {
                            filemanager : "/themes/{{Config('zmcms.frontend.theme_name')}}/backend/js/filemanager/plugin.min.js"
                    },
                    plugins : 'code  link image lists charmap print preview fullscreen hr anchor pagebreak searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking table directionality emoticons paste codesample imagetools template',
                    toolbar: 'code image media | fullpage | bold italic underline strikethrough casechange| alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect | cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor | insertdatetime preview | forecolor backcolor | table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | visualchars visualblocks nonbreaking template pagebreak restoredraft',
                });
            </script>