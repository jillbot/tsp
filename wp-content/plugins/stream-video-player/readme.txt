=== Stream Video Player ===
Contributors: Rodrigo Polo
Donate link: http://rodrigopolo.com/about/wp-stream-video/donate
Tags: stream, video, flv, mp4, flash, swf, iphone, ios, player, wordpress, plugin, media
Requires at least: 2.8.0
Tested up to: 4.1
Stable tag: 1.4.1
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Stream Video Player for WordPress its one stop solution for high quality video publishing for web or iOS.

== Description ==

Stream Video Player for WordPress is by far the best and most complete video-audio player plug-in for WordPress with XML Playlist support and subtitles, Easy to use with a tag generator in the editor, support for viewing on iOS and Android, support for YouTube and Pseudo-Streaming so you can randomly seek any place of your videos without having to load the entire video before.

= Features =
* iOS, Android, WPTouch, MobilePress, YouTube and feeds compatible.
* HTML5 video tag for mobile devices
* 100% Responsive and Retina Ready!
* Embed code generator for any video.
* Captions (subtitles) capable.
* XML Playlist.
* Social sharing and video URL sharing.
* Random access to any position on the video thanks to the pseudo streaming technique
* Skins capable thanks to JW Media Player it can load SWF and XML-PNG custom skins.
* Based on a very fine tuned custom build (fork) of the JW Media Player Version 5.3.
* Only open source software needed for video encoding.
* JW Media Player plug-ins supported.
* 100% Standard XHTML code.
* Check [this demo](http://youtu.be/NShb8pR_dIc).

= Important Links =

* <a href="http://rodrigopolo.com/about/wp-stream-video" title="Demonstration and Info">Live Demo</a>
* <a href="http://youtu.be/NShb8pR_dIc" title="Demonstration and Info">Video Tutorial - Setup and Configuration</a>
* <a href="http://rodrigopolo.com/about/wp-stream-video/faq" title="Stream Video Player FAQ">FAQ</a>
* <a href="http://rodrigopolo.com/about/wp-stream-video/how-to" title="Full guide on how to use the plug-in and encode video">How to use the plug-in and encode video</a>
* <a href="http://rodrigopolo.com/about/wp-stream-video/ffmpeg-binary-installers-for-win-mac-and-linux" title="Video Encoder Installer">Video Encoder for Mac, Win, Linux</a>
* <a href="http://rodrigopolo.com/about/wp-stream-video/known-issues-and-to-do-list" title="Known issues and To-do list">Known issues and To-do list</a>


= Translators =
* Afrikaans (af_AF) - [Schalk Burger](http://schalkburger.za.net)
* Brazilian Portuguese (pt_BR) - [Caciano Gabriel](http://gn10.com.br)
* Chinese, Traditional (zh_TW) - [James Wu](http://jameswublog.com)
* Danish (da_DK) - [GeorgWP](http://wordpress.blogos.dk)
* Dutch (nl_NL) - [Martin Hein](http://split-a-pixel.nl)
* French (fr_FR) - [Maître Mô](http://maitremo.fr), [Stéphane Benoit](http://caracteremultimedia.com)
* Georgian (ka_GE) - [Nodar Rocko Davituri](http://omedia.ge)
* German (de_DE) - Michael Helfberend
* Hebrew (he_IL) - [Yaron Ofer - GadgetGuru.co.il](http://gadgetguru.co.il)
* Italian (it_IT) - [Bruno Salzano](http://brunosalzano.com)
* Lithuanian (lt_LT) - [Ernestas Kardzys](http://ernestas.info)
* Polish (pl_PL) - [Zbigniew Czernik](http://zibik.jogger.pl)
* Russian (ru_RU) - [Andrey K.](http://andrey.eto-ya.com), Roman Kireev
* Spanish (es_ES) - [Jordi Sancho](http://qasolutions.net)
* Spanish (es_MX) - [Rodrigo Polo](http://rodrigopolo.com)
* Turkish (tr_TR) - [Emin Buğra SARAL](http://www.rahmetli.info)
* Ukrainian (uk_UA) - [Andrey K.](http://andrey.eto-ya.com)
* Portuguese (pt_PT) - [PedroDM](http://development.mowster.net)

= Special note =

If the player doesn't show, [download the SWF files](http://www.sendspace.com/file/qzwn8m) and put them on the plugin directory.
`http://example.com/wp-content/plugins/stream-video-player/
      |-- player.swf
      |-- yt.swf
      +-- plugins
      |   |-- captions.swf
      |   |-- gapro.swf
      |   |-- hd.swf
      |   |-- ltas.swf
      |   |-- qualitymonitor.swf
      |   +-- sharing.swf
      +-- skins
	  |-- beelden.zip
	  |-- dangdang.swf
	  |-- imeo.swf
	  |-- lulu.zip
	  |-- modieus.zip
	  +-- stormtrooper.zip`

Because many many users ask for more capabilities I decided to use (instead of the original swf video player I made) a custom build of the JW Player which uses license CC-NC-SA 3.0 which is a non-GPL compatible license and because that It can't be included on the WordPress directory. The first workaround to fix this was to host the SWF files in other site, but this leads to cross-domain issues and an excessive bandwidth use of my hosting account, so I decided to make the plug-in download the download the SWF files for you on the first run, if you run into troubles check your plug-in directory permissions.

Also notice that the version of JW Player (5.7.1896) used in this plug-in is licensed as Creative Commons: Attribution-NonCommercial-ShareAlike 3.0 Unported (CC BY-NC-SA 3.0) http://creativecommons.org/licenses/by-nc-sa/3.0/ - You can use their player freely for personal or non-commercial use. Put it on your personal blog, non-profit, or government website and let the video role. But if you advertise on your site or it's owned by a business, then you have to purchase a commercial license.

Read more about JW Player License: http://www.longtailvideo.com/jw-player/license/


== Credits ==

Copyright 2014 by RodrigoPolo.com

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

== Installation ==
1. Download and unzip the current version of the Stream Video Player plugin.
2. Transfer the entire 'stream-video-player' directory to your '/wp-content/plugins/' directory.
3. Activate the plugin through the 'Plugins' menu in WordPress.
4. That's it! You're done. You can now generate the "stream video tag" by using the quick tag generator from the post editor.
5. RECOMMENDED, copy the included "crossdomain.xml" to your site root (http://example.com/crossdomain.xml) in order to share video in other sites.
6. If you need more assistance [watch how to use it](http://youtu.be/NShb8pR_dIc).

If the player doesn't show, [download the SWF files](http://www.sendspace.com/file/qzwn8m) and put them on the plugin directory.
`http://example.com/wp-content/plugins/stream-video-player/
      |-- player.swf
      |-- yt.swf
      +-- plugins
      |   |-- captions.swf
      |   |-- gapro.swf
      |   |-- hd.swf
      |   |-- ltas.swf
      |   |-- qualitymonitor.swf
      |   +-- sharing.swf
      +-- skins
	  |-- beelden.zip
	  |-- dangdang.swf
	  |-- imeo.swf
	  |-- lulu.zip
	  |-- modieus.zip
	  +-- stormtrooper.zip`

== Frequently Asked Questions ==

= What's new in the latest version? =
* Longtime bugs fixed.
* 100% Responsive and Retina Ready!
* Youtube embed code for mobile devices updated to iframe tag.
* Internet Explorer SWF Embed code fixed.
* SWF Auto Download to host.
* 100% tested and working on WordPress 4.1 using IE 9, 10 and 11, Chrome, FireFox, and Safari on OS X.
* [Tutorial and test](http://youtu.be/NShb8pR_dIc).


= Where I can get help and support? =
* [On WordPress Plug-in Directory](http://wordpress.org/support/plugin/stream-video-player)
* [READ How to use the plug-in and encode video](http://rodrigopolo.com/about/wp-stream-video/how-to)
* [CHECK the Frequently Asked Questions (F.A.Q.)](http://rodrigopolo.com/about/wp-stream-video/faq)
* [Watch how to use it](http://youtu.be/NShb8pR_dIc)

== Changelog ==  

= 1.4.1 =
* Small media library working
* Quick tag buttons working
* I want to rewrite this plug-in from scratch, I first published this plug-in on June 13, 2009 based in two or tree other plug-ins, at that time things were completely different, YouTube use to have time limitations, there was no HTML5, Flash use to be the king of the interactive web content, now, reviewing the code I think I can do it better using less code, I want to get rid of Flash and use native HTML5 tags, I want to use some regex to parse the tags, I want to do many things, but wanting to do something is one thing, having the incentive is other, It saddens me to invest so much time on this project and realize how little support from the community I had reflected on donations over the past 5 years and a half, and, in the other hand, realizing that the plug-in is serving at last 17.5 million videos per month, that’s crazy, just imagine that I could get $0.0001 per view per month, that could be $1,750. For that reason I believe this will be the latest time I fix any bug, I think I’ll make a new Stream Video Player but not for free, I really love the free software movement, but sometimes it doesn’t pay enough (or at all) to keep you wanting to support a project… P.D. Merry Christmas.

= 1.4.0 =
* Android mobile devices supported with MP4
* HTML5 video tag implemented only for mobile devices
* OGV option added for some mobile devices that doesn't support MP4
* Added the responsive option on the tag generator

= 1.3.8 =
* 100% Responsive and Retina Ready!
* Youtube embed code for mobile devices updated to iframe tag

= 1.3.7 =
* Internet Explorer SWF Embed code fixed
* SWF Auto Download to host
* 100% tested and working on WordPress 3.5.1 using IE 7, 8, 9 and 10, Chrome, FireFox, and Safari on OS X and Windows.

= 1.3.0 =
* NEW! Playlist support out of the box.
* NEW! Possibility to use a custom config.xml with all JW Player options so you can have a shorter embed code.
* NEW! Skins for the player.
* UPDATE! JW Player (player.swf) updated to 5.3.1397 version, custom build.
* Better look with custom design.
* Display HH:MM:SS on time instead of MMM:SS
* Load local plug-ins first, if not found then load the JW Player repository plug-ins.
* Can load any JW Player Plug-in.
* Fixed bug to handle well anamorphic video on streaming and on video mode.
* Fixed bug to handle playlist thumbnails.
* Fixed bug to handle playlist next item when using pseudo-streaming.
* Can load custom logo (original JW Player version can't).
* Custom Sharing Plug-in build to handle "self-share" always, modified design.
* Custom HD Plug-in build to fit the players design.
* Custom Captions Plug-in build to have the margin flashvar param.
* FIX! Character encoding on media library.


== Upgrade Notice ==

= 1.4.1 =
All bugs are fixed.

= 1.4.0 =
After receiving zero donations and being downloaded 307,757 times I decided to fix some bugs just for the sake of it.
* Small media library is now working
* The quick tag button is now woking

= 1.4.0 =
* Android mobile devices supported with MP4
* HTML5 video tag implemented only for mobile devices
* OGV option added for some mobile devices that doesn't support MP4
* Added the responsive option on the tag generator

= 1.3.8 =
* 100% Responsive and Retina Ready!
* Youtube embed code for mobile devices updated to iframe tag.

= 1.3.7 =
* Internet Explorer SWF Embed code fixed
* SWF Auto Download to host
* 100% tested and working on WordPress 3.5.1 using IE 7, 8, 9 and 10, Chrome, FireFox, Safari, on OS X and Windows

= 1.3.0 =
New JW Player version fixing many bugs, XML Playlist support with options in the tag generator, custom config.xml file support, some bugs fixed.

TESTED and working on WordPress 3.2.1!


== Screenshots ==

1. Stream Video Player Default Skin.
2. Tag Generator Button on Editor.
3. Tag Generator Panel showing a warning.
4. Media Library File Selection.
5. Stream Video Player Widget.
6. Plug-in Settings.
7. Stream Video Player Using Playlists.
8. Player on iPhone 3 using WPtouch.
9. Player on iPhone 5 Retina and Android using a Responsive Website.
