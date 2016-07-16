(function() {
    tinymce.create('tinymce.plugins.SPPClammrIt', {
        init: function(ed, url) {
            ed.addButton('clammrit', {
                title: 'SPP: Clammr This',
                image: url.replace("/js", "") + '/img/clammr-little-bird-button.png',
                onclick: function() {

				var re = /\b\d{1,2}:\d{2}\b/g; 
				var txt =  ed.selection.getContent();;
				var str = txt;
				var m;           
				var times = [];    
				while ((m = re.exec(str)) !== null) {
				 times.push(m[0]);
				}   
				var StartTime=times[0];
				tt=StartTime.split(":");
				var StartS = tt[0]*60+tt[1]*1;

				if (times[1] === undefined ){
						StartS = StartS + 24;
						var date = new Date(StartS * 1000);
						var mm = date.getUTCMinutes();
						var ss = date.getSeconds();
						times[1] =mm+":"+ss;

				}else{

						var EndTime = times[1]
						tt1=EndTime.split(":");
						var EndS=tt1[0]*60+tt1[1]*1;
						var Seconds = EndS - StartS;

						if (Seconds > 24){
								StartS = StartS + 24;
								var date = new Date(StartS * 1000);
								var mm = date.getUTCMinutes();
								var ss = date.getSeconds();
								txt = txt.replace(times[1], '');
								times[1] =mm+":"+ss;
						}
			
				}		
				var text = txt.replace(times[0], '');
				text = text.replace(times[1], '');
				text = jQuery.trim(text); 
                 ed.selection.setContent('[spp-clammr text="'+ text +'" start="' + times[0] + '" end="' + times[1] + '"]');;
                }
            });
        },
        createControl: function(n, cm) {
            return null;
        },
        getInfo: function() {
            return {
                longname: "Click To Clammrit by Simple Podcast Press",
                author: 'HaniMourra',
                authorurl: 'http://simplepodcastpress.com/',
                infourl: 'http://simplepodcastpress.com/',
                version: "1.0"
            };
        }
    });
    tinymce.PluginManager.add('clammrit', tinymce.plugins.SPPClammrIt);
})();