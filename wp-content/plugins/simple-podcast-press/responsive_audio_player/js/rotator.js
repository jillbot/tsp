jQuery(document).ready(function(){
   
   jQuery(".reviews_view").each(function(){
      var format = jQuery(this).attr("style");
      if(format == 'slideshow'){
         var obj = this;
         jQuery(this).find('li').css({"display":"none"});
         jQuery(this).find('li').eq(0).css({"display":"block"});      
         setInterval(function(){            
            var count = jQuery(obj).children('li').length;
            var rand = Math.floor(Math.random()*count);
            var current = parseInt(jQuery(obj).attr("current"),10);
            jQuery(obj).find("li").eq(current).fadeOut("slow","linear",function(){
               jQuery(obj).find("li").eq(rand).fadeIn("slow","linear",function(){
                      jQuery(obj).attr({"current":rand});
                  
                });
               
             });

         },10000);
      }
   });
});
