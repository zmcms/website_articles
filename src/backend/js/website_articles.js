$(document).ready(function(){
	/**
	 * OTWIERA Listę zapisanych artykułów.
	 **/
	var backend_prefix = $('meta[name="backend-prefix"]').attr('content');
	$("#btn_zwal").on('click', function(e){
		location.href = "/"+backend_prefix+"/articles/list";
		return false;
	});	
	/**
	 * OTIERA Formularz w trybie dodawania nowego artykułu.
	 **/
	$("#btn_zwan").on('click', function(e){
		location.href = "/"+backend_prefix+"/articles/create/frm";
		return false;
	});	

	$('#zmcms_website_article_frm #btn_save').on('click', function (e){
		e.preventDefault();e.stopPropagation();
		var token = $('#article_token').val();
		$('#ajax_dialog_box').fadeIn( "slow", function() {});
		$('#ajax_dialog_box_content').html('<div class="msg ok"><div class="loader"></div></div>');
		tinymce.triggerSave();
		$.ajax({
			type: 'POST',
				url: "/"+backend_prefix+"/articles/save",
				data: new FormData(document.getElementById('zmcms_website_article_frm')),
				processData: false,
				contentType: false,
				success: function(data){
					var resultset = JSON.parse(data);
					// $('#ajax_dialog_box_content').html('<div class="msg '+resultset.result+'">'+resultset.code+': '+resultset.msg+'</div>');
					var resultset = JSON.parse(data);
					$('#ajax_dialog_box_content').html('<div class="msg '+resultset.result+'">'+resultset.code+': '+resultset.msg+'</div>');
					if(resultset.result == 'ok'){
						location.href = "/"+backend_prefix+"/articles/edit/"+d.dataset.token;
						return false;
					}
				},
				statusCode: {
					500: function(xhr) {$('#ajax_dialog_box_content').html('<div class="msg error">'+xhr.status+'<br>'+xhr.responseText+'</div>');},
					419: function(xhr){$('#ajax_dialog_box_content').html('<div class="msg error"><pre>'+xhr.responseText+'</pre></div>');},
					404: function(xhr){$('#ajax_dialog_box_content').html('<div class="msg error">Nie znaleziono skryptu</div>');},
					405: function(xhr){$('#ajax_dialog_box_content').html('<div class="msg error">'+xhr.status+'<br>'+xhr.responseText+'</div>');}
				}
		});
		return false;
	});
	$('#btn_article_filter').on('click', function (e){
		e.preventDefault();e.stopPropagation();
		v = $('#txt_filter').val();
		$('#ajax_dialog_box').fadeIn( "slow", function() {});
		$('#ajax_dialog_box_content').html('<div class="msg ok"><div class="loader"></div></div>');
		if (v == '') {
			$('#ajax_dialog_box_content').html('<div class="msg error">Wartość pola tekstowego filtra nie może być pusta.</div>');
			return false;
		}
		$.post(
			"/"+backend_prefix+"/zmcms_website_articles_filter",
			{
				'filter': v
			}, 
			function(data){
				$('#ajax_dialog_box_content').html('<div class="msg ok">Zafiltrowano</div>');
				$('#zmcms_website_articles_control_panel_content').html(data);
			}
		);
		return false;
	});
	$("#zmcms_website_articles_control_panel_content").on('click',"a[id^='article_edit_']", function(e){
		var d = document.getElementById($(this).attr('id'));
		location.href = "/"+backend_prefix+"/articles/edit/"+d.dataset.token;
		return false;
	});
	$('#zmcms_website_article_frm').on('click', '.pagination>.page-item>a', function(e){
		e.preventDefault();e.stopPropagation();
		var page = ($(this).attr('href').split('page=')[1]);
		var token = $('#article_token').val();
		$.get(
			"/"+backend_prefix+"/zmcms_website_articles_paginator/"+token+'/'+page,
			function (data){
				$('#zmcms_website_article_frm #articles_content_page').html(data);
			}
		);

		return false;
	});
	/**
	 *PRZYPINANIE I ODPINANIE ARTYKUŁU DO NAWIGACJI
	 **/
	$("#zmcms_website_articles_control_panel_content").on('click',"a[id^='article_link_']", function(e){
		e.preventDefault();e.stopPropagation();
		var d = document.getElementById($(this).attr('id'));
		$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
		$('#ajax_dialog_box').fadeIn( "slow", function() {});
		$('#ajax_dialog_box_content').html('<div class="msg ok><div class="loader"></div></div>"');
		$.get(
			"/"+backend_prefix+"/zmcms_website_navigations_linker_frm/"+d.dataset.token+'/'+d.dataset.type+'/'+d.dataset.objslug,
			function (data){
				$('#ajax_dialog_box_content').html(data);
			}
		);
		// alert(d.dataset.token+' '+d.dataset.type);
		return false;
	});
	
	$('#zmcms_website_article_frm').on('click', '#zcwa_btn_update_article_ilustration', function (e){
		e.preventDefault();e.stopPropagation();
			var o = $(this).attr('id'); 
			var d = document.getElementById(o);
			$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
			$('#ajax_dialog_box').fadeIn( "slow", function() {});
			$('#ajax_dialog_box_content').html('<iframe  width="'+(0.90*$(window).width())+'px" height="'+(0.85*$(window.top).height())+'px" frameborder="0" '+
					'src="/themes/zmcms/backend/js/filemanager/dialog.php?type=0&field_id='+d.dataset.selectfld+'&relative_url=0&multiple=false&callback=ccc"'+
					'></iframe>');
			return false;
	});


	$('#zmcms_website_article_frm').on('click', '#zcwa_btn_remove_article_ilustration', function (e){
		e.preventDefault();e.stopPropagation();
		alert('usunięcie ilustracji artykułu');
		return false;
	});
	/**
	 * NOWA STRONA ARTYKUŁU
	 **/
	$('#zmcms_website_article_frm').on('click', '#zcwa_btn_create_page', function (e){
		e.preventDefault();e.stopPropagation();
		var d = document.getElementById($(this).attr('id'));
		$('#content_page').val(Number(d.dataset.pagecount)+Number(1));
		$('#content_subtitle').val('');
		$('#content_content').val('');
		tinyMCE.activeEditor.setContent($('#content_content').val())
		$('#content_meta_keywords').val('');
		$('#content_meta_description').val('');
		$('#content_og_title').val('');
		$('#content_og_description').val('');
		$('#content_og_type').val('');
		$('#content_og_url').val('');
		$('#zcwn_btn_og_ilustration_fld').val('');
		$('#data_action').val('article_page_create');


		return false;
	});
	$('#zmcms_website_article_frm').on('click', '#zcwa_btn_delete_page', function (e){
		e.preventDefault();e.stopPropagation();
		var d = document.getElementById($(this).attr('id'));
		if(confirm('Czy usunąć tę stronę artykułu?')){
			$('#ajax_dialog_box').fadeIn( "slow", function() {});
			$('#ajax_dialog_box_content').html('<div class="msg ok"><div class="loader"></div></div>');
			$.get(
				"/"+backend_prefix+"/zmcms_website_articles_page_delete/"+d.dataset.token+'/'+d.dataset.langs_id+'/'+d.dataset.page,
				function (data){
					var resultset = JSON.parse(data);
					$('#ajax_dialog_box_content').html('<div class="msg '+resultset.result+'">'+resultset.code+': '+resultset.msg+'</div>');
					if(resultset.result == 'ok'){
						location.href = "/"+backend_prefix+"/articles/edit/"+d.dataset.token;
						return false;
					}
					
				}
			);

		}
		// alert('usunięcie strony artykułu');
		return false;
	});
	$('#zmcms_website_article_frm').on('click', '#zcwa_btn_create_og_ilustration', function (e){
		e.preventDefault();e.stopPropagation();
			var o = $(this).attr('id'); 
			var d = document.getElementById(o);
			$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
			$('#ajax_dialog_box').fadeIn( "slow", function() {});
			$('#ajax_dialog_box_content').html('<iframe  width="'+(0.90*$(window).width())+'px" height="'+(0.85*$(window.top).height())+'px" frameborder="0" '+
					'src="/themes/zmcms/backend/js/filemanager/dialog.php?type=0&field_id='+d.dataset.selectfld+'&relative_url=0&multiple=false&callback=ccc"'+
					'></iframe>');
			return false;
	});
	$('#zmcms_website_article_frm').on('click', '#zcwa_btn_delete_og_ilustration', function (e){
		e.preventDefault();e.stopPropagation();
		alert('usunięcie ilustracji OG artykułu');
		return false;
	});
	$('#btn_article_new').on('click', function(e){
		e.preventDefault();e.stopPropagation();
		location.href = "/"+backend_prefix+"/articles/create/frm";
		return false;
	});
	$('#wa_title_txt').on('keyup', function(e){
		$('#wa_slig_txt').val(str_slug($('#wa_title_txt').val()));
	});
	
	$("a[id^='article_del_']").on('click', function (e){
		e.preventDefault();e.stopPropagation();
		// alert (this.id);
		// alert(this.dataset.token);
		// alert(this.dataset.objslug);
		$('#ajax_dialog_box').fadeIn( "slow", function() {});
			$('#ajax_dialog_box_content').html('<div class="msg ok"><div class="loader"></div></div>');
			$.get(
				"/"+backend_prefix+"/zmcms_website_article_delete/"+this.dataset.token+'/'+this.dataset.objslug,
				function (data){
					// var resultset = JSON.parse(data);
					// $('#ajax_dialog_box_content').html('<div class="msg '+resultset.result+'">'+resultset.code+': '+resultset.msg+'</div>');
					alert(data);
					$('#ajax_dialog_box_content').html('<div class="msg">'+data+'</div>');
					// if(resultset.result == 'ok'){
						// location.href = "/"+backend_prefix+"/articles/edit/"+d.dataset.token;
						// return false;
					// }
					
				}
			);
	})
	
// a[id^='department_new_']"
});
