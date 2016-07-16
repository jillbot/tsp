jQuery(document).ready(function () {     
   jQuery("a.spp-timestamp").click(function(){
	  
	   var time = jQuery(this).attr("time");
	   var audio = jQuery(document).find('audio').get(0);
	   
	   
		
	   if (audio.paused) {
         
         audio.play();
         setTimeout(function(){
                audio.currentTime = parseInt(time,10);
	       },1000);
       }
     else
        audio.currentTime = parseInt(time,10);
     
     
	});
});
