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
$('#pc').css("color","red");

$(document).click(function(e) {
	var targ = $(e.target).attr('id');

	if (targ == 'pc' || targ == 'xbox' || targ == 'psn') {
		selPlatform = targ;
		if (selPlatform == 'pc') {
			$('#'+selPlatform).css("color","red");
			$('#xbox').css("color","#fff");
			$('#psn').css("color","#fff");
		}else if (selPlatform == 'xbox') {
			$('#'+selPlatform).css("color","red");
			$('#pc').css("color","#fff");
			$('#psn').css("color","#fff");
		}else if (selPlatform == 'psn') {
			$('#'+selPlatform).css("color","red");
			$('#pc').css("color","#fff");
			$('#xbox').css("color","#fff");
		}
		console.log(selPlatform);
	}else if (targ == 'searchPlayer') {
		var nick = $('#headerNick').val();
		nick = nick.replace("\\", "");
		if (nick != '') {
			href('/profile/'+selPlatform+'/'+nick);
		}
		//alert(nick);
	}


});

$(document).ready(function() {
	$('select').niceSelect();
});