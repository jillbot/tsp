function sppClammrIt(starttime,endtime, audio_file, chnale_image, post_title, post_content) {
    var sppCurrentTime = document.getElementsByClassName("audioplayer-time audioplayer-time-current");
    var sppCurStartTime = starttime;
    var sppCurEndTime = endtime;
    var sppReferralName = 'SimplePodcastPress';
    
    var p = sppCurStartTime.split(':'),
        s = 0, m = 1;
    while (p.length > 0) {
        s += m * parseInt(p.pop(), 10);
        m *= 60;
    }

	 var p1 = sppCurEndTime.split(':'),
			s1 = 0, m1 = 1;
		while (p1.length > 0) {
			s1 += m1 * parseInt(p1.pop(), 10);
			m1 *= 60;
		}
   var sppCurStartTimeMs = s * 1000;
   var sppCurEndTimeMs = s1 * 1000;
  // var sppCurEndTimeMs = sppCurStartTimeMs + 24000;
  var clammrUrlEncoded = "https://www.clammr.com/app/clammr/crop";
  clammrUrlEncoded += "?audioUrl=" + encodeURIComponent(audio_file);
  clammrUrlEncoded += "&imageUrl=" + encodeURIComponent(chnale_image);
  clammrUrlEncoded += "&audioStartTime=" + encodeURIComponent(sppCurStartTimeMs);
  clammrUrlEncoded += "&audioEndTime=" + encodeURIComponent(sppCurEndTimeMs);
  clammrUrlEncoded += "&title=" + post_title;
  clammrUrlEncoded += "&description=" + encodeURIComponent(post_content);
  clammrUrlEncoded += "&referralName=" + encodeURIComponent("SimplePodcastPress");
                  
  if (document.getElementsByClassName("sppaudioplayer").item(0) != null)
          jQuery('.sppaudioplayer').trigger("pause");
  // SM players
  else if (window.soundManager) {
    var soundId = window.soundManager.soundIDs[0];
    if (soundId != null) {
      soundManager.getSoundById(soundId).pause();
      jQuery("div.smart-track-player").removeClass("spp-playing");
    }
  }

                       
    window.open(clammrUrlEncoded, 'cropPlugin', 'width=1000, height=750, top=50, left=200');
}