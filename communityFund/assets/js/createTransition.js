$(document).ready(function() {
	$.fx.speeds.sslow = 800;
	$('html, body').animate({ scrollTop: $('.create').offset().top+300}, 'sslow');
	$('.start').click(function() {
		$('#first').fadeTo('slow', '0', function() {
			$('#first').hide();
			$('#second').show();
			$('#second').animate({ opacity: '0.9'});
			$('html, body').animate({ scrollTop: $('#second').offset().top-100}, 2000);
		});
	});

	$('.catList li').one('click',function() {
		$('.project').append($(this).clone());
		$('#second').fadeTo('slow', '0', function() {
			$('#second').hide();
			$('#third').show();
			$('#third').animate({ opacity: '0.9'});
			$('html, body').animate({ scrollTop: $('#third').offset().top-100}, 2000);
		});
	});
	$('#third input').focus(function() {
		$('#third confirm').fadeTo('slow', '1');
	});
	$('#third confirm').one('click', function() {
		$('#third').fadeTo('slow', '0', function() {
			$('#third').hide();
			$('.project').append(("<li><a>"+$('#third input').val()+"</a></li>"));
			$('#fourth').show();
			$('#fourth').animate({ opacity: '0.9'});
			$('html, body').animate({ scrollTop: $('#fourth').offset().top-100}, 2000);
		});
	});
	$('#fourth confirm').one('click',function() {
		$('#fourth').fadeTo('slow', '0', function() {
			$('#fourth').hide();
			$('select').prop('disabled', true);
			$('.project').append(("<li>"+$('#fourth .startDate').html()+"</br>"+$('#fourth .endDate').html()+"</li>"));
			$(".project li select[name='year']").val($("#fourth select[name='year']").val());
			$(".project li select[name='month']").val($("#fourth select[name='month']").val());
			$(".project li select[name='day']").val($("#fourth select[name='day']").val());
			$(".project li select[name='endYear']").val($("#fourth select[name='endYear']").val());
			$(".project li select[name='endMonth']").val($("#fourth select[name='endMonth']").val());
			$(".project li select[name='endDay']").val($("#fourth select[name='endDay']").val());
			$('#fifth').show();
			$('#fifth').animate({ opacity: '0.9'});
			$('html, body').animate({ scrollTop: $('#fifth').offset().top-100}, 2000);

		});
	});
	$('#fifth confirm').one('click',function() {
		$('#fifth').fadeTo('slow', '0', function() {
			$('#fifth').hide();
			if($("#fifth input[name='cents']").val()!="") {
				$('.project').append(("<li><a>$"+$("#fifth input[name='dollars']").val()+"."+$("#fifth input[name='cents']").val()+"</a></li>"));
			} else {
				$('.project').append(("<li><a>$"+$("#fifth input[name='dollars']").val()+".00"+"</a></li>"));
			}
			
			$('#sixth').show();
			$('#sixth').animate({ opacity: '0.9'});
			$('html, body').animate({ scrollTop: $('#sixth').offset().top-100}, 2000);
		});
	});

});
	
