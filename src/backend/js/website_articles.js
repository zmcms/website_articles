$(document).ready(function(){
	/**
	 * OTIERA Listę zapisanych artykułów.
	 **/
	var backend_prefix = $('meta[name="backend-prefix"]').attr('content');
	$("#btn_zwal").on('click', function(e, backend_prefix){
		location.href = "/"+backend_prefix+"/articles/list";
		return false;
	});	
	/**
	 * OTIERA Formularz w trybie dodawania nowego artykułu.
	 **/
	$("#btn_zwan").on('click', function(e, backend_prefix){
		location.href = "/"+backend_prefix+"/articles/new_frm";
		return false;
	});	
});



