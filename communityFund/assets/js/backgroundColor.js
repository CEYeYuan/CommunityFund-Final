$(document).ready(function() {
	var colors = ["#FFE0FF", "#FFFFE0", "#E0FFE0", "#E0FFE0", "#E0FFFF", "#B2E6FF", "#DBDBFF"];
	var count =0;
	$.fx.speeds.sslow = 5000;
	function transition() {
		$('html, body').animate({backgroundColor: colors[Math.floor((Math.random()*colors.length))]}, 'sslow');
	}
	transition();
	setInterval(transition, 8000);

});