$(document).ready(function() {
	var proj=$('.mini').toArray();
	function start() {
		iniTop();
		initBot();
	}
	function iniTop() {
		if(proj.length==0) {
			return;
		}
		var e=proj[Math.floor(Math.random()*($('.mini').length))];
		proj.splice(proj.indexOf(e),1);
		$(e).css('left', '-20%');
		$(e).css('top', '15%');
		$(e).fadeIn(500).queue(aniR(e));
	}
	function initBot() {
		if(proj.length==0) {
			return;
		}
		e=$('.mini')[Math.floor(Math.random()*($('.mini').length))];
		proj.splice(proj.indexOf(e),1);
		$(e).css('right', '-20%');
		$(e).css('bottom', '15%');
		$(e).delay(3500).fadeIn(1000).queue(aniL(e));
	}

	function aniR(e) {
		if($(e).position().left>window.innerWidth) {
			$(e).hide();
			proj.push(e);
			iniTop();
			return;
		}
		$(e).animate({
			left: '+=5'}, 50, 'linear', 
			function() {
				aniR(e);
			});
	}
	function aniL(e) {
		if($(e).position().left<(-300)) {
			$(e).hide();
			proj.push(e);
			initBot();
			return;
		}
		$(e).animate({
			right: '+=5'}, 50, 'linear', 
			function() {
				aniL(e);
			});
	}
	$('.mini').mouseenter(function() {
			$(this).stop();
		}
	);
	$('.mini').mouseleave(function(){
		if($(this).position().top<(window.innerHeight/2)){
			$(this).animate({
				left: '+=5'}, 50, 'linear', 
				function() {
					aniR($(this));
			});
		} else {
			$(this).animate({
				right: '+=5'}, 50, 'linear', 
				function() {
					aniL($(this));
			});
		}	
	});
	$('.mini').one('click', function() {
		link = $(this).attr('link');
		$('html, body').fadeOut(1000).queue(function() {
			window.location.href = link;
		});
	});
	start();
});