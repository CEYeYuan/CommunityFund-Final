$(document).ready(function() {
	$('#submit').one('click',function(e) {
		e.preventDefault();
		var cents = $("#fifth a input[name='cents']").val();
		if(cents=="") {
			cents="0";
		}
		$.ajax({
			type: 'POST',
			url: BASE_URL+"projectCreate/create",
			crossDomain: true,
			data: {	title: $(".project li a")[1].text,
					category: $(".project li a[name='category']").attr('value'),
					year: $(".project li select[name='year']").val(),
					month: $(".project li select[name='month']").val(),
					day: $(".project li select[name='day']").val(),
					endYear:$(".project li select[name='endYear']").val(),
					endMonth: $(".project li select[name='endMonth']").val(),
					endDay: $(".project li select[name='endDay']").val(),
					description: $("#sixth textarea").val(),
					dollars: $("#fifth a input[name='dollars']").val(),
					cents: cents},
			success:function(data) {
				var arr = $.parseJSON(data);
				if(arr.response>-1) {
					link = BASE_URL+'project/index/'+arr.response;
					$('html, body').fadeOut(1000).queue(function() {
						window.location.href = link;
					});
				}
			},
			error : function(xhr, status) {
				console.log(status);
			}
			});
	});

});
