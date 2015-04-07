$(document).ready(function() {
	$('.catList li').click(function(e) {
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: BASE_URL+"welcome/getProject",
			dataType: 'text',
			data: {	cid: $(this).attr('id')},
			success:function(data) {
				$('.projectContent').empty();
				var arr = $.parseJSON(data);
				for(i = 0; i < arr.length; i++) {
					out = '';
					out += "<div class='project'>";
					var num=1;
					if(arr[i].pname.substring(0,1)<="K"&&arr[i].pname.substring(0,1)>="A") {
						num=1;
					} else if(arr[i].pname.substring(0,1)<="Z"&&arr[i].pname.substring(0,1)>="L") {
						num=2;
					} else {
						num=3;
					}
					out += "<img src='"+BASE_URL+"assets/images/p"+num+".jpg'>";
					out += "<div class='desc'>";
					out += "<h1 class='title'>";
					out += "<a href='"+BASE_URL+"project/index/"+arr[i].pid+"'>"+arr[i].pname+"</a>";
					out += "</h1>";
					out += "<p>"+arr[i].description+"</p>";
					out += "<div id='progress_bar_container'>";
					out += "<div name='hi' id='progress_bar'>";
					var percent = Math.floor((arr[i].currentFund/arr[i].fundsNeeded)*100);
					if(percent>=100) {
						percent=100;
					}
					out += "<div style='width:"+percent+"%;'>"+percent+"%</div>";
					out += "</div></div></div></div>";
					$(out).hide().appendTo('.projectContent').delay(800*i).fadeIn(1000);
				}
			}
			});
	});
});
