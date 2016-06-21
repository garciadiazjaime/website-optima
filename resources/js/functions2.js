var folder = '/trd/';
//var server = 'http://localhost/jt/';
var server = 'http://labs.mintitmedia.com/jt/';
$(window).load(function() {
	var page = get_currentpage();
	var params = page.split('/');
	var element = params.pop();
	if($('#panel_' + element).length){
		console.log('asd');
		gotoTop('panel_' + element)
	}
	$('form').submit(function(){
		$('#msg').text('');
		flag = isFormReady();
		if(!flag){
			$('#msg').text('Favor de llenar los campos marcados');
		}else{
			if( !isValidEmailAddress( $('#email').val() ) ) { 
				$('#msg').html('Favor de proporcionar un email v\xE1lido');
				$('#lab_email').addClass('required');
			}else{
 				$('#msg').text('Enviando mensaje, por favor espere...');
				$.post(server + 'resources/php/send_mail.php', $(this).serialize(), function(data) {
					if($.trim(data) == 'TRUE'){
						$('#msg').html('Gracias, su mensaje ha sido enviado');	
					} 
					else $('#msg').html('Error, no se pudo enviar su mensaje, por favor mande un correo a info@jt.com');
					clearForm();
				 });
			}
		}
		return false;
	})
	$('#wrapper').animate({
		'opacity': '1'
	},  'slow', function(){
	});
		
	//$('.customSelectBox').customSelect({customClass:'customSelectstyle'});
	$('.home_scroller').click(function(){ 
		var item = $(this).attr('href');
		id = getLastItem(item)
		gotoTop(id)
		return false;
	})
	// *********************** Nuestro Proceso *********************************
	$('a.abrirproceso').click(function(){
		var clase = $(this).attr('class')
		console.log(clase)
		if( $(this).attr('class').indexOf('closed') !== -1 ){
			$('#nuestro_proceso').animate({
				'height': 356
			})
			$('a.abrirproceso').removeClass('closed')
			$('a.abrirproceso').addClass('opened')
		}
		else{
			$('#nuestro_proceso').animate({
				'height': 0
			})
			$('a.abrirproceso').removeClass('opened')
			$('a.abrirproceso').addClass('closed')
		}
		return false
	})
});



function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    return pattern.test(emailAddress);
};

function get_currentpage(){
	var loc = window.location;
	p = loc.href.substring(loc.href.indexOf(loc.host) + loc.host.length + folder.length );
	if(p == '') p = 'inicio';
	return p;
}

function gotoTop(id){
	if(id.length)
		$('html, body').animate({
			scrollTop: $('#'+id).offset().top
		}, 1250);
}

function isFormReady() {
	var formChildren = $("form :input[type=text]"); // verificar inputs
	var flag = true;
	for (i = 0; i < (formChildren.length); i++) {
		if (formChildren[i].lang == 'es' && formChildren[i].value == '') {
				flag = false;
			$('#lab_'+formChildren[i].name).addClass('required');
		} else
			$('#lab_'+formChildren[i].name).removeClass('required');
	}

	var formChildren = $('select'); // selects
	for (i = 0; i < (formChildren.length); i++) {
		if ($(formChildren[i]).attr('lang') == 'es' && $(formChildren[i]).val() == 0) {
			if (flag) flag = false;
			$('#lab_'+formChildren[i].name).addClass('required');
		} else
			$('#lab_'+formChildren[i].name).removeClass('required');
	}

	var formChildren = $('textarea'); // textarea
	for (i = 0; i < (formChildren.length); i++) {
		if (formChildren[i].lang == 'es' && formChildren[i].value == '') {
			if (flag)
				flag = false;
			$('#lab_'+formChildren[i].name).addClass('required');
		} else
			$('#lab_'+formChildren[i].name).removeClass('required');
	}
	return flag;
}

function clearForm(){
	var formChildren = $("form :input[type=text]");
	for (i = 0; i < (formChildren.length); i++) {
		$(formChildren[i]).val('');
	}

	var formChildren = $("form :input[type=checkbox]");
	for (i = 0; i < (formChildren.length); i++) {
		$(formChildren[i]).attr('checked', false);
	}

	var formChildren = $('select'); // selects
	for (i = 0; i < (formChildren.length); i++) {
		$(formChildren[i]).val(0);
	}

	var formChildren = $('textarea'); // selects
	for (i = 0; i < (formChildren.length); i++) {
		$(formChildren[i]).val('');
	}
}
function getLastItem(cadena){
       var params = cadena.split('/');
       return params.pop();
}