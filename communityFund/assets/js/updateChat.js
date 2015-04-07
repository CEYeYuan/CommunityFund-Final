$(document).ready(function() {
	$('#submit').click(function(e) {
		e.preventDefault();
		if($('textarea').val()=="") {
			return;
		}
		$.ajax({
			type: 'POST',
			url: BASE_URL + "friends/chat/" + WHOM,
			dataType: 'json',
			data: {	msg: $('textarea').val()}
			});

		if($('.chat p').length>0) {
			$('.chat p').hide(400, function() {
				$(this).remove();
			});
		}

		var currentdate = new Date(); 
		out = "<span class='left'>"+currentdate.getHours()+":"+(currentdate.getMinutes()<10?'0':'') + currentdate.getMinutes()+" Me: </span>";
		out += "<span class='right' style='font-family:Arial'>"+$('textarea').val()+"</span><br/>";
		$('textarea').val('');
		$(out).hide().appendTo('.chat').fadeIn(800);
		$(".chat").animate({ scrollTop: $(".chat")[0].scrollHeight}, 1000);
	});
	function update() {
		$.ajax({
			type: 'POST',
			url: BASE_URL + "friends/getNewMsg/"+WHOM,
			success:function(data) {
				var arr = $.parseJSON(data);
				if(arr.length==0) {
					return;
				}
				if($('.chat p').length>0) {
					$('.chat p').hide(400, function() {
						$(this).remove();
					});
				}
				for(i = 0; i < arr.length; i++) {
					out = "<span class='left'>"+arr[i].time.substring(11,16)+" "+name+": </span>";
					out += "<span class='right' style='font-family:Arial'>"+arr[i].msg+"</span><br/>";
					$(out).hide().appendTo('.chat').fadeIn(1000+(400*i));
					$(".chat").animate({ scrollTop: $(".chat")[0].scrollHeight}, 1000);
				}
			}
			});
	}
	setInterval(update, 500);
});