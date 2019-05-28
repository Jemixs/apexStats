$('#xsHeaderOpen').click(function() {
	$(".xsHeader").fadeToggle(300);
	var body = $('body').css('overflow');

	if (body == 'hidden') {
		$('body').css('overflow','auto');
	}else{
		$('body').css('overflow','hidden');
	}
});

$('#xsHeaderClose').click(function(e) {
	e.preventDefault();
	$(".xsHeader").fadeToggle(300);

	var body = $('body').css('overflow');

	if (body == 'hidden') {
		$('body').css('overflow','auto');
	}else{
		$('body').css('overflow','hidden');
	}
});

selPlatform = 'pc';
$('i[id="pc"]').css("color","red");

$(document).click(function(e) {
	var targ = $(e.target).attr('id');

	if (targ == 'pc' || targ == 'xbox' || targ == 'ps4') {
		selPlatform = targ;
		if (selPlatform == 'pc') {
			$(`i[id="${selPlatform}"]`).css("color","red");
			$('i[id="xbox"]').css("color","#fff");
			$('i[id="ps4"]').css("color","#fff");
		}else if (selPlatform == 'xbox') {
			$(`i[id="${selPlatform}"]`).css("color","red");
			$('i[id="pc"]').css("color","#fff");
			$('i[id="ps4"]').css("color","#fff");
		}else if (selPlatform == 'ps4') {
			$(`i[id="${selPlatform}"]`).css("color","red");
			$('i[id="pc"]').css("color","#fff");
			$('i[id="xbox"]').css("color","#fff");
		}
		//console.log(selPlatform);
	}else if(targ == 'searchPlayer') {
		var nick = $('#headerNick').val();
		nick = nick.replace("\\", "");
		if (nick != '') {
			window.location.replace('/profile/'+selPlatform+'/'+nick);
		}
	}
});

$('#slct').change(function(e) {
	//console.log(this.value);
	var url = window.location.href;
	var objParseUrl = url.split('/');

	//console.log(objParseUrl);

	if (this.value != objParseUrl[4]) {
		if (objParseUrl[6]) {
			var sort = objParseUrl[6];
		}else{
			var sort = 'kill';
		}

		var newUrl = objParseUrl[0]+'//'+objParseUrl[2]+'/leaderbord/'+this.value+'/1/'+sort;
		//window.location.replace('/leaderbord/'+this.value+'/1');

		//console.log(newUrl);

		$.ajax({
			url: newUrl,
			dataType: 'html',
			beforeSend: function() {
				$('.spinner').css("display","flex");
			},
			success: function(data){
				var new_html = $(data).find('.tableList').html();
				var newPageList = $(data).find('.pagesList').html();
				$('.tableList').html(new_html);
				$('.pagesList').html(newPageList);
				window.history.pushState({href: newUrl}, '', newUrl);
				$('.spinner').css("display","none");
				//console.log(new_html);
			}
		});
	}
});

$('#sortSelc').change(function(e) {
	//console.log(this.value);
	var url = window.location.href;
	var objParseUrl = url.split('/');

	//console.log(objParseUrl);

	if (this.value != objParseUrl[4]) {
		var newUrl = objParseUrl[0]+'//'+objParseUrl[2]+'/leaderbord/'+objParseUrl[4]+'/'+objParseUrl[5]+'/'+this.value;
		//window.location.replace('/leaderbord/'+this.value+'/1');

		//console.log(newUrl);

		$.ajax({
			url: newUrl,
			dataType: 'html',
			beforeSend: function() {
				$('.spinner').css("display","flex");
			},
			success: function(data){
				var new_html = $(data).find('.tableList').html();
				var newPageList = $(data).find('.pagesList').html();
				$('.tableList').html(new_html);
				$('.pagesList').html(newPageList);
				window.history.pushState({href: newUrl}, '', newUrl);
				$('.spinner').css("display","none");
				//console.log(new_html);
			}
		});
	}
});

$('#xssearchPlayer').click(function() {
	var nick = $('#xsheaderNick').val();
	nick = nick.replace("\\", "");
	if (nick != '') {
		window.location.replace('/profile/'+selPlatform+'/'+nick);
	}
});

$(".tableBord").on("click", "#playerLeadbord", function(e){
	e.preventDefault();
	
	var url = e.target;

	//alert(url);

	if (url != '') {
		$.ajax({
			url: url,
			async: true,
			beforeSend: function (){
				$('.spinner').css("display","flex");
			},
			complete: function(html){
				redirect(url);
				$('.spinner').css("display","none");
			}
		});
	}
});

function redirect (url) {
	var ua        = navigator.userAgent.toLowerCase(),
	isIE      = ua.indexOf('msie') !== -1,
	version   = parseInt(ua.substr(4, 2), 10);

    // Internet Explorer 8 and lower
    if (isIE && version < 9) {
    	var link = document.createElement('a');
    	link.href = url;
    	document.body.appendChild(link);
    	link.click();
    }

    // All other browsers can use the standard window.location.href (they don't lose HTTP_REFERER like Internet Explorer 8 & lower does)
    else { 
    	window.location.href = url; 
    }
}

$('#hideSidebarMap').click(function(e) {
	e.preventDefault();
	$(".mapSidebar").fadeToggle(300);
	if ($(this).attr('data-target') == 'active') {
		$("#hideSidebarMap span").html('Открыть панель');
		$(this).attr('data-target','deactive');
	}else{
		$("#hideSidebarMap span").html('Скрыть панель');
		$(this).attr('data-target','active');
	}
});

$('#sendFormCont').click(function(e) {
	e.preventDefault();

	//console.log($('.formFeed').serialize()+'&ajax=1');

	$.ajax({
		type: "POST",
      	url: "/contact", //Change
      	data: $('.formFeed').serialize()+'&ajax',
      	success: function(data){
      		var dec = JSON.parse(data);
      		//console.log(dec);
      		if (dec.type == 'send') {
      			alert('Сообщение отправлено');
      		}else{
      			alert('Nont send');
      		}
      	}
      });
	return false;
});

pages = 2;
$('.match:first').on("click","#showMore", function(e) {
	e.preventDefault();

	var url = window.location.href;
	var objParseUrl = url.split('/');

	$.ajax({
		type: 'GET',
		url: '/profile/'+objParseUrl[4]+'/'+objParseUrl[5]+'/match/'+pages,
		beforeSend: function() {
			$('.spinner').css("display","flex");
		},
		success: function(html) {
			pages+=1;
			var dataHtml = $(html).find('.match').html();
			$('.match:first').html($(dataHtml).remove('.title'));
			$('.spinner').css("display","none");
		}
	});
});