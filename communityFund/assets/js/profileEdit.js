$(document).ready(function() {
	$('edit').click(function() {
		var names = ["fn", "ln"];
		$('.user li').each(function(index) {
			if(index==2) {
				$('.dob select').prop('disabled', false);
			} else {
				$(this).children('a').replaceWith("<input name=\""+names[index]+"\" type='text' value='"+$(this).children('a').text()+"'>");	
			}
		});
		$('.user ').append("<li name=\"pass\"> Password: "+"<input name=\"pswd\" type='password' >"+"</li>");
		$('.user ').append("<li name=\"pass\"> Reconfirm: "+"<input name=\"cpswd\"type='password' >"+"</li>");
		$('edit').hide();
		$('.left-side #done').css('display', 'block');
	});
	$('.left-side #done').click(function(e) {
		 e.preventDefault();
		$.ajax({
			type: 'POST',
			url: BASE_URL+"profile/profile_update_validition",
			dataType: 'json',
			data: {	fn: $("input[name='fn']").val(),
					ln: $("input[name='ln']").val(),
					year: $("select[name='year']").val(),
					month: $("select[name='month']").val(),
					day: $("select[name='day']").val(),
					pswd: $("input[name='pswd']").val(),
					cpswd: $("input[name='cpswd']").val()},
			success:function(data) {
				//console.log(data.msg);
			}
			});
		$('.profile h1').text($("input[name='fn']").val()+"'s Profile");
		$('.user li').each(function(index) {
			if(index==2) {
				$('.dob select').prop('disabled', true);
			} else {
				$(this).children('input').replaceWith("<a>"+$(this).children('input').val()+"</a>");
			}
		});
		$(".user li[name='pass']").remove();
		$('.left-side #done').hide();
		$('edit').css('display', 'block');

	});
});
