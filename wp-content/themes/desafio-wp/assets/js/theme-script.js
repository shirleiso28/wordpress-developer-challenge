jQuery(document).ready(function($){
	'use strict';

	/*Adicionar ícones ao menu mobile*/
	$(".menu-mobile ul.navbar-nav li.filmes a").prepend('<i class="fa fa-films"></i>');
	$(".menu-mobile ul.navbar-nav li.documentarios a").prepend('<i class="fa fa-documentary"></i>');
	$(".menu-mobile ul.navbar-nav li.series a").prepend('<i class="fa fa-series"></i>');

	/*Alterar texto botão do banner na versão mobile*/
	let txt_btn_banner = $(".banner .content-banner a.btn-red").html();
	var width = $(window).width(); 

	if(width < 768){
		$('.banner .content-banner a.btn-red').html('Assistir');
	}else{
		$('.banner .content-banner a.btn-red').html(txt_btn_banner);
	}

});

function reproduzirVideo(url, title){
    jQuery('.play-video').css('display','none');
    jQuery('.reproduzirVideo').html('<iframe style="width: 100%; height: 100vh;" src="https://www.youtube.com/embed/'+url+'?autoplay=1" title="'+title+'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
}


