$(document).ready(function(){
	$(".hover_fun").mouseover(function(){
		var fancy_id	=	$(this).attr('id');			
		$("[tid="+fancy_id+"]").css("display","block");
	});
				
	$(".hover_fun").mouseout(function(){
		var fancy_id	=	$(this).attr('id');
		$("[tid="+fancy_id+"]").css("display","none");
	});
});