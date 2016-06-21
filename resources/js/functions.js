var folder = '/';
var server = get_server_path() + folder
//var server = 'http://labs.mintitmedia.com/optima/';
$(window).load(function() {
	var page = get_currentpage();
	var params = page.split('/');
	var element = params.pop();
	
	if(element.indexOf('#') === -1)
		if($('#panel_' + element).doesExist())
			gotoTop('panel_' + element)

	if(element.indexOf('contact') !== -1)
		load_gmaps()

	$('.goto').click(function(){
		tag = getLastItem($(this).attr('href'))
		page = 'services'
		update_url(page, tag)
		gotoTop('panel_' + tag)
		return false
	})

	$('#form_talent_search').submit(function(){
		url_path = '';
		search = $('#search').val()		
		tmp = page.split('/')		
		len = tmp.length		
		if(!tmp[len-1].length)
			tmp.pop()				
		for(i=0; i<tmp.length; i++){		
			url_path += tmp[i] + "/"
			if(i + 1 == tmp.length && !isNumber(tmp[i]) && search.length)
				url_path += "0/"
		}
		url_path = server + url_path + search		
		window.location = url_path
		return false
	})

	$('#contact_form').submit(function(){
		$('#msg').text('');
		flag = isFormReady();		
		if(!flag){
			$('#msg').text('Please fill in required fields');
		}else{
			if( !isValidEmailAddress( $('#email').val() ) ) { 
				$('#msg').html('Please fill a valid email address');
				$('#lab_email').addClass('required');
			}else{
 				$('#msg').text('Sending message, please wait...');
				$.post(server + 'resources/php/send_mail.php', $(this).serialize(), function(data) {
					if($.trim(data) == 'TRUE'){
						$('#msg').html('<span class="success">thank you, your message has been sent</span>');	
					} 
					else $('#msg').html('Error, we could not send your message, send us an email to: info@optima-os.com');
					clearForm();
				 });
			}
		}
		return false;
	})


	$('#filtro_ocasion').click(function(){
		var clase = $(this).attr('class')
		if( $(this).attr('class').indexOf('closed') !== -1 ){
			$('#filtro_ocasion').animate({
				'height': 160
			})
			$(this).removeClass('closed')
			$(this).addClass('opened')
		}
		else{
			$('#filtro_ocasion').animate({
				'height': 26
			})
			$(this).removeClass('opened')
			$(this).addClass('closed')
		}
		return false
	})
	
	$('#wrapper').animate({
		'opacity': '1'
		}, 'slow', 	
		function(){
			if(page.indexOf('/') != -1 ){
				params = page.split('/');
				flag = params.pop();
				if(element.indexOf('#') === -1)
					if($('#panel_'+flag).doesExist()) 
						gotoTop('panel_'+flag);
			}
		}
	);

	// *********************** Our clients ***********************************
	$('#nav_our_clients a').click(function(){
		return false;
	})
		
	//$('.customSelectBox').customSelect({customClass:'customSelectstyle'});
	$('.home_scroller').click(function(){ 
		var item = $(this).attr('href');
		id = getLastItem(item)
		gotoTop(id)
		return false;
	})
	// *********************** Slider simple ***********************************
	$('#slideshow_why').bjqs({
	    height      : 130,
	    width       : 470,
	    responsive  : true
	  });
	$('#common_phrases_slider_wrapp').bjqs({
	    height      : 140,
	    width       : 935,
	    responsive  : true
	  });

	$('#slideshow_experience').bjqs({
	    height      : 230,
	    width       : 935,
	    responsive  : true
	  });
	
	$('#slideshow_experience2').bjqs({
	    height      : 230,
	    width       : 935,
	    responsive  : true
	  });
	
	$('#slideshow_experience3').bjqs({
	    height      : 230,
	    width       : 935,
	    responsive  : true
	  });
	
	// *********************** Nuestro Proceso *********************************
	$('a.abrirproceso').click(function(){
		var clase = $(this).attr('class')
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
	});
	
	// *********************** Acordeón de contacto *********************************
	
	$("#accordion_contact > li > h3").click(function(){
		
	    if(false == $(this).next().is(':visible')) {
	    	$(this).css({'background-position':"420px -495px"});
	        $('#accordion div').slideUp(300);
	    }
		if($(this).next().is(':visible')) {
			$(this).css({'background-position':"420px -221px"});
		}
	    $(this).next().slideToggle(300);
	});

	$('#accordion_contact div:eq(0)').show();
	
	
	// *********************** Servicios de inicio *********************************
	$('.home_services_thumb').click(function(){
			var thumb_id = $(this).attr('id');
			showDivServices(thumb_id);
		}
	);


	// ********************** Servicios Balanza ************************************


	$('.balance_operating, .balance_organizational ').click(function(){
			if($(this).hasClass('balance_operating')){
				showBalanceItem('balance_operating');
			}
			else{
				showBalanceItem('balance_organizational');
			}
			return false
		}
	);

	// *********************** Menú escondido **************************************	
	$('.radioBtn').click(showDivServices());

	$('.upload_file_button').change(function (e) {
	    $('#upload_file').val($('#upload_file_route').val())
	});
	
	//num = getLastItem(page)	
	//if(!Number(num)) num = 0

	//if(page == 'home') catsapi.get_joborders_fe();
	
	//else if(page.indexOf('talent') !== -1)
	//	catsapi.get_joborders_talent('', num);	

	$(function() {

	    // grab the initial top offset of the navigation
	    if($('#hidden_header').offset())
	    	var sticky_navigation_offset_top = $('#hidden_header').offset().top;

	    // our function that decides weather the navigation bar should have "fixed" css position or not.
	    var sticky_navigation = function(){
	        var scroll_top = $(window).scrollTop();  // our current vertical position from the top
			scroll_top+=300;
	        // if we've scrolled more than the navigation, change its position to fixed to stick to top,
	        // otherwise change it back to relative
	        if (scroll_top > sticky_navigation_offset_top) {
	            $('#hidden_header').css({ 'position': 'fixed', 'top':0, 'left':0, 'opacity': 1 });
	        } else {
	            $('#hidden_header').css({ 'position': 'fixed', 'top': 700, 'opacity': 0 });
	        }  
	    };

	    // run our function on load
	    sticky_navigation();

	    // and run it again every time you scroll
	    $(window).scroll(function() {
	         sticky_navigation();
	    });

	});

/* http://css-plus.com/examples/2010/09/jquery-image-slider/ */
	page = get_currentpage()
	h_banner = false
	if(page.indexOf('home') !== -1)
	{
		h_banner_wrapper = 'clients_slide'
		stopPosition = -500
		h_banner = true
	}
	else if(page.indexOf('experiencing_optima') !== -1)
	{
		h_banner_wrapper = 'our_clients_slide'
		stopPosition = -300
		h_banner = true
	}
		

	if(h_banner && $("#"+h_banner_wrapper).length){
        var totalImages = $("#"+h_banner_wrapper+" > li").length, 
            imageWidth = $("#"+h_banner_wrapper+" > li:first").outerWidth(true),
            totalWidth = parseInt($("#"+h_banner_wrapper).css('width'))
            visibleImages = Math.round($("#slider-wrap").width() / imageWidth),
            visibleWidth = visibleImages * imageWidth,
            stopLeft = $("#"+h_banner_wrapper).position().left
        
        $("#slider-prev").click(function(){
            if($("#"+h_banner_wrapper).position().left < stopLeft && !$("#"+h_banner_wrapper).is(":animated")){
                $("#"+h_banner_wrapper).animate({left : "+=" + imageWidth + "px"});
            }
            return false;
        });
        
        $("#slider-next").click(function(){
            if($("#"+h_banner_wrapper).position().left > stopPosition && !$("#"+h_banner_wrapper).is(":animated")){
                $("#"+h_banner_wrapper).animate({left : "-=" + imageWidth + "px"});
            }
            return false;
        });

        window.setInterval(function(){move_logo(h_banner_wrapper, 0)}, 5000);
    }

    $("#accordion > li > ul").click(function(){
	 
	    if(false == $(this).next().is(':visible')) {
	        $('#accordion ul').slideUp(300);
	    }
	    $(this).next().slideToggle(300);
	});
	 
    
});

function get_last_tweets()
{
	response = ''

	$.getJSON("https://api.twitter.com/1/statuses/user_timeline/optima_org_sol.json?count=3&include_rts=1&callback=?", function(data) {
		for(i=0; i<data.length; i++)
		{
			p = ''
			a = ''
			if (data[i].text.indexOf('http://'))
			{
				tmp = data[i].text.split('http://')
				p = '<p>' + tmp[0] + '</p>'
				a = '<a class="gray_link" title="Follow us on Twitter" href="http://' + tmp[1] + '" target="_blank">' + tmp[1] + '</a>'
			}
			else
				response += '<p>' + data[i].text + '</p>'
			response += p + a
		}
		$("#twitter").html(response);
	});
}

function move_logo(wrapper, stopLeft)
{
	$("#slider-next").click()
	if($("#"+wrapper).position().left < stopPosition)
		$("#"+wrapper).animate({left : stopLeft + "px"});
	//get_last_tweets()
}

function load_gmaps()
{	
	$('#gmaps').html('<iframe width="419" height="217" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Misi%C3%B3n+de+San+Javier+%2310643+Zona+Urbana+R%C3%ADo,+Tijuana,+B.+C+&amp;sll=37.0625,-95.677068&amp;sspn=58.425119,129.550781&amp;ie=UTF8&amp;hq=&amp;hnear=Misi%C3%B3n+de+San+Javier+10643,+Zona+Urbana+R%C3%ADo+Tijuana,+Baja+California,+Mexico&amp;t=m&amp;z=14&amp;ll=32.520988,-117.007921&amp;output=embed"></iframe><br /><p id="larger_gmaps"><a class="gmaps" href="https://maps.google.com/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=Misi%C3%B3n+de+San+Javier+%2310643+Zona+Urbana+R%C3%ADo,+Tijuana,+B.+C+&amp;sll=37.0625,-95.677068&amp;sspn=58.425119,129.550781&amp;ie=UTF8&amp;hq=&amp;hnear=Misi%C3%B3n+de+San+Javier+10643,+Zona+Urbana+R%C3%ADo+Tijuana,+Baja+California,+Mexico&amp;t=m&amp;z=14&amp;ll=32.520988,-117.007921" target="_blank">View Larger Map</a></p>');
}

$.fn.doesExist = function(){
    return jQuery(this).length > 0;
};

function isNumber (o) {
  return ! isNaN (o-0) && o !== null && o !== "";
}

function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    return pattern.test(emailAddress);
};

function get_currentpage(){
	var loc = window.location;
	p = loc.href.substring(loc.href.indexOf(loc.host) + loc.host.length + folder.length );
	if(p == '') p = 'home';
	return p;
}

function gotoTop(id)
{
	if(id.length)
		$('html, body').animate({
			scrollTop: $('#'+id).offset().top - 120
		}, 1250);
}

function update_url(page, tag)
{
	current_url = get_currentpage()
	history.pushState('', '', server + page + '/' + tag);
	//window.location.hash = '/' + tag;
}

function isFormReady() {
	var formChildren = $("form :input[type=text]"); // verificar inputs
	var flag = true;
	for (i = 0; i < (formChildren.length); i++) {
		if (formChildren[i].lang == 'en' && formChildren[i].value == '') {
				flag = false;
			$('#lab_'+formChildren[i].name).addClass('required');
		} else
			$('#lab_'+formChildren[i].name).removeClass('required');
	}

	var formChildren = $("form :input[type=email]"); // verificar inputs
	var flag = true;
	for (i = 0; i < (formChildren.length); i++) {
		if (formChildren[i].lang == 'en' && formChildren[i].value == '') {
				flag = false;
			$('#lab_'+formChildren[i].name).addClass('required');
		} else
			$('#lab_'+formChildren[i].name).removeClass('required');
	}

	var formChildren = $("form :input[type=date]"); // verificar inputs
	var flag = true;
	for (i = 0; i < (formChildren.length); i++) {
		if (formChildren[i].lang == 'en' && formChildren[i].value == '') {
				flag = false;
			$('#lab_'+formChildren[i].name).addClass('required');
		} else
			$('#lab_'+formChildren[i].name).removeClass('required');
	}

	var formChildren = $("form :input[type=tel]"); // verificar inputs
	var flag = true;
	for (i = 0; i < (formChildren.length); i++) {
		if (formChildren[i].lang == 'en' && formChildren[i].value == '') {
				flag = false;
			$('#lab_'+formChildren[i].name).addClass('required');
		} else
			$('#lab_'+formChildren[i].name).removeClass('required');
	}

	var formChildren = $("form :input[type=password]"); // verificar inputs
	var flag = true;
	for (i = 0; i < (formChildren.length); i++) {
		if (formChildren[i].lang == 'en' && formChildren[i].value == '') {
				flag = false;
			$('#lab_'+formChildren[i].name).addClass('required');
		} else
			$('#lab_'+formChildren[i].name).removeClass('required');
	}

	var formChildren = $('select'); // selects
	for (i = 0; i < (formChildren.length); i++) {
		if ($(formChildren[i]).attr('lang') == 'en' && $(formChildren[i]).val() == 0) {
			if (flag) flag = false;
			$('#lab_'+formChildren[i].name).addClass('required');
		} else
			$('#lab_'+formChildren[i].name).removeClass('required');
	}

	var formChildren = $('textarea'); // textarea
	for (i = 0; i < (formChildren.length); i++) {
		if (formChildren[i].lang == 'en' && formChildren[i].value == '') {
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

	var formChildren = $("form :input[type=email]");
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

function show_loading(id)
{
	$('#'+id).html('<img src="resources/images/fe/loader.gif" alt="loading" />')
}

function showDivServices(id)
{	
	if(id){	
		$('.service_description_slide').hide();
    	$('.service_description_slide').stop().animate({ opacity: 0 }, 300);
		$('#c_'+id).show();	
    	$('#c_'+id).stop().animate({ opacity: 1 }, 300);	
	}
	
}

function showBalanceItem(class_name)
{	
	if(class_name=="balance_operating"){
		$('#s_balance_operating').removeClass('inactive').addClass('visible');
		$('.balance_operating').removeClass('inactive').addClass('current');
	
		$('#s_balance_organizational').removeClass('visible').addClass('inactive');
		$('.balance_organizational').removeClass('current').addClass('inactive');
	}
	else{
		$('#s_balance_organizational').removeClass('inactive').addClass('visible');
		$('.balance_organizational').removeClass('inactive').addClass('current');
		
		$('#s_balance_operating').removeClass('visible').addClass('inactive');
		$('.balance_operating').removeClass('current').addClass('inactive');
	}
	return false	
}

function get_server_path(){
	var loc = window.location;
	return "http://" + loc.hostname;
}

if (!Array.prototype.indexOf) {
    Array.prototype.indexOf = function (searchElement /*, fromIndex */ ) {
        "use strict";
        if (this == null) {
            throw new TypeError();
        }
        var t = Object(this);
        var len = t.length >>> 0;
        if (len === 0) {
            return -1;
        }
        var n = 0;
        if (arguments.length > 1) {
            n = Number(arguments[1]);
            if (n != n) { // shortcut for verifying if it's NaN
                n = 0;
            } else if (n != 0 && n != Infinity && n != -Infinity) {
                n = (n > 0 || -1) * Math.floor(Math.abs(n));
            }
        }
        if (n >= len) {
            return -1;
        }
        var k = n >= 0 ? n : Math.max(len - Math.abs(n), 0);
        for (; k < len; k++) {
            if (k in t && t[k] === searchElement) {
                return k;
            }
        }
        return -1;
    }
}


