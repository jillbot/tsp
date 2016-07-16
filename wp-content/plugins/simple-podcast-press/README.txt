=== Plugin Name ===
Requires at least: 3.3
Tested up to: 4.4

Simple Podcast Press will automatically publish your podcasts to your WordPress site and grow your audience with a new lead-generating podcast player.

== Description ==

1-Click Podcast Website Publishing.  Automatically publish your podcasts to your WordPress site and grow your audience with a new lead-generating podcast player.  No technical skills required.

Main Feature Include:

** For Third Party Feeds like Libsyn, SoundCloud, Spreaker etc: **
* This plugin will automatically creates new podcast blog post when a new episode is published on iTunes (checks every hour)
* Podcast blog post title, description, embedded audio, published date, and tags/keywords are taken directly from iTunes feed
* Option to choose Podcast Episode Art is used as the featured image for the podcast blog post
* Option to keep new podcast posts as DRAFT or AUTO PUBLISH
* Assign a default category for each new podcast blog post

** For Self hosted Feeds using Blubrry PowerPress: **
* Option to instantly update all your existing and future posts to replace the PowerPress player with a new player
* New player includes subscribe buttons, optin box, and is touch friendly 
* Your PowerPress feed is unaffected

** Everyone can benefit from these features: **
* International iTunes reviews inside your WP dash
* Option to add optin forms below your audio player
* 1-Click Tweetables - just highlight text in post to make them tweetable
* Automatic url shortener with episode detection
* Insert clutter-free transcripts or show notes in your posts
* Podcast Art appears when posts are shared on Facebook
* Sidebar widget to showcase your latest episode




== Installation ==

This section describes how to install the plugin and get it working.


1. Log in as an administrator into your WordPress site.
2. From the WordPress Dashboard choose Plugin->Add New
3. Choose Upload and select the simple-podcast-press.zip file.
4. Activate the plugin.
5. From the WordPress Dashboard, choose the Simple Podcast Press settings 
6. Enter Your License, Save, then Activate
7. Enter your podcast iTunes URL and click Save.
8. Enjoy!



== Changelog ==

= 1.610 =
* Fix: Blog Talk Radio player not showing up on posts


= 1.609 =
* Fix: iTunes reviews not automatically updating every 24 hours


= 1.606 =
* Fix: Subscribe on Android Button stopped working on some sites
* Fix: iTunes reviews not importing on some sites (may need to reconnect feed)


= 1.605 =
* Fix: Prevent SPP player from appearing on non-audio pages


= 1.604 =
* Fix: Player on some posts affecting the formatting of the entire page


= 1.603 =
* New: Player is now round when you choose round buttons
* Fix: Prevent featured image from appearing on non-audio pages
* Fix: Clammr button not working on some sites
* Fix: Formatting issue when video player is displayed on a pages


= 1.601 =
* Fix: Fixed issue with sites running PHP older than 5.3
* Fix: Prevent SPP player-related text from appearing in your PowerPress feed


= 1.600 =
* New: One click replacement of the default SPP player with 3rd party podcast players while maintaing the functionality of clickable timestamps, automatic post creation, email opt-in, subscribe and Clammr buttons, etc (requires add-on plugins)
* New: Episodes table now has links back to the individual show notes page
* New: Styled Clammr This text with pre-loaded times for easy sharing
* New: Clickable timestamps are now auto detected (no shortcode required)
* New: Option to set the opt-in box headline text color
* New: Now you can use the player without entering a podcast feed or iTunes URL
* Fix: Activation issues on some sites
* Fix: Better compatibility with older feeds
* Fix: Support for 24 second Clammrs
* Fix: Improved compatibility for https sites
* Fix: Better page load times by removing unnecessary scripts
* Fix: Compatibility with PowerPress video and audio enclosures on the same post


= 1.500 =
* New: SPP video player to support video podcast PowerPress feeds 
* New: Compatibility with upcoming SPP add-on plugins 
* Fix: Automatically add SPP player when using PodPress feeds
* Fix: Player now better supports the AudioBoom feed
* Fix: Podcast channel images and episode images not appearing with some feeds
* Fix: Correct post publish dates during import to match feed
* Fix: Import glitch with WP 4.4
* Fix: Compatibility fix for secure sites (using https)
* Fix: License not activating on some servers
* Fix: Sidebar widget wouldn't load when no podcasts found
* Fix: Warning cleanup in debug mode



= 1.423 =
* Fix: Clammr button reappearing after disabling it


= 1.422 =
* Fix: Warnings appearing in debug mode


= 1.421 =
* New: Clammr It Button!  Now your listeners can easily Clammr your episodes and share on FB and Twitter
* New: Subscribe on Android, Subscribe via RSS, Listen in a New Window, and Leave a Review Buttons
* New: Button that can now open a Leadpage's Leadbox.
* New: 3 additional Custom Buttons for a total of 6
* New: You can now set the minimum size of buttons
* New: Option to automatically insert featured image in the beginning of the post
* New: Option to always use the iTunes cover art as the featured image
* New: Color picker for Read Transcript text
* New: You can now control the Text Above Player and Powered By with shortcode parameters
* New: Support for podpress feeds 
* Fix: Resolved issue with slow WordPress dashboards
* Fix: Audio player no longer replays when it reaches the end
* Fix: Facebook meta tag now works correctly when you add a featured image after the initial save
* Fix: Added a title to the Podcast Reviews sidebar widget
* Fix: The styled Tweetable on your page can now be any length, but will truncate when shared on Twitter
* Fix: Double player when WP audio is used
* Fix: Security patches

= 1.419 =
* Fix: Player not working when Blubrry stats tracking URLs were enabled


= 1.418 =
* New: All players are now flat and have improved styling
* New: Option to automatically replace Smart Podcast Player's Single Track Player with SPP
* New: Support for pretty (redirected) iTunes URLs when setting up the plugin
* New: In the text above player you can hide the length of the episode
* New: Text above player can be completley removed by deleting the text in the settings
* Fix: Tighter padding around player
* Fix: Some optin box settings were hidden in the settings page
* Fix: Issues importing iTunes cover art images on some sites
* Fix: Save settings not working due to permissions on some sites
* Fix: CSS issue where bullet items where no longer indented
* Fix: Remove border style around transcripts on some themes
* Fix: Buttons and opt-in boxes not showing up on home page
* Fix: Default colors were not set when you initially install the plugin
* Fix: Text above player can now support apostrophes


= 1.416 =
* New: Ability to add clutter-free transcripts inside main post editor
* Fix: Removed underline of text in buttons on some themes
* Fix: Speed up loading of the SPP audio player on the page
* Fix: Save Settings continuous spinning wheel issue
* Fix: Clickable timestamp compatibility issue with newer PHP versions
* Fix: Player color selection only appears when custom player is selected
* Fix: Opt-in box now supports apostrophes
* Fix: Better compatibility with different WP database character sets


= 1.415 =
* Fix: SPP Tweet Compatibility with more drag and drop themes
* Fix: Import from Libsyn Website improved reliability
* Fix: Player buttons and colours not preserved after an update
* Fix: Full import of iTunes Description when advanced setting is enabled
* Fix: Compatibility fix for auto replacement of the audio player created by the WP Audio Player Plugin
* Fix: Renamed sidebar widget to Latest Episode
* Fix: Custom buttons are now same size or bigger than the standard buttons
* Fix: Background color of progress bar when custom player settings are selected
* Fix: Removed left margin from reviews listing


= 1.412 =
* Feature: Support for auto replacement of the audio player created by the WP Audio Player Plugin


= 1.411 =
* Fix: Download button now opens in a new window 


= 1.410 =
* Fix: Posts were not importing images from Libsyn Website 


= 1.409 =
* Fix: Post not importing due to large number of keywords in feed
* Fix: Download button not working when adding player with URL parameter


= 1.407 =
* Fix: Conflict with some themes that use same license system


= 1.406 =
* Fix: Improved support for Force SPP Player on Home Page
* Fix: Sorting issue with SPP Episodes table
* Fix: Sidebar player not appearing on some sites
* Fix: Removed background shadow when viewed on mobile 


= 1.405 =
* Fix: Incorrect SPP Tweetables URL


= 1.402 =
* Fix: Large spacing between player and buttons


= 1.401 =
* Fix: New reviews not appearing at the top of the reviews list
* Fix: Double player issue experienced by some PowerPress users
* New: Option to force player to appear on the home page


= 1.400 =
* New: showcase your iTunes Reviews on your page or sidebar
* New: clickable links to advance the player to a specific time.
* New: add a table of all podcast episodes with a download link
* New: option to make the player colors flat (no gradient)
* New: option to rename the "Listen to the Episode Below" text
* New: option to import full HTML description when necessary
* Fix: save settings for Multisite WP installations


= 1.329 =
* Fixed issue where our player was overlapping other players from other plugins or themes (Required for New Appendipity Pro Themes)
* Add option to disable automatically adding of the SPP audio player on posts.


= 1.321 =
* Add toolbar button to insert CTA buttons inside post editor
* Even better compatibility with all Appendipity Themes
* Improved method for finding RSS feed from iTunes URL
* Remove conflict with PowerPress playlists
* Cleaned up warnings when debug mode is enabled


= 1.316 =
* Add option to fix incorrect URL shorteners
* Fixed issue with feeds that contain missing audio url tags
* Fixed issue where SPP Tweet shortcodes where appearing in PowerPress feeds
* Better compatibility with all Appendipity Themes


= 1.309 =
* Fixed issue where posts still imported when setting was set to Disable Import
* Removed all uppercase from all buttons including custom buttons
* Custom buttons width adjust based on length of text
* Custom buttons now align with other buttons
* Fix for player overlapping some images on home page


= 1.306 =
* Fixed reviews not importing issue on some sites
* Fixed settings not applying after update
* Fixed missing player after update
* Fixed image from feed not importing
* Fixed issue where player appears on some themes home page even when option is set to disable
* Fixed issue where posts where imported when option was disabled
* Fixed issue on some themes where extra space was appearing in footer


= 1.301 =
* Fixed disabling of player on home page on some themes


= 1.300 =
* Added option to fully customize the pocdast player colors
* Added custom buttons below player that can link to anywhere you like
* Added option to set where the iTunes Button should link to
* Added option for Download Button to directly download MP3 file
* Added option to only create posts for episodes newer than a specific date
* Added ability for player to appear on some Themes that didn't show the player on the home page
* Added option to allow you to setup a two-step optin (button followed by pop up)
* Added ability to automatically replace the native WordPress audio player with our podcast player
* Fixed missing transcript and URL shortener boxes on custom post types
* Fixed optin box so input fields for First Name and Email are not all caps
* Fixed player conflict with Appendipity themes on home page
* Fixed optin box so it can be added without the player
* Fixed issue on some servers where iTunes URLs and reviews were reported as invalid
* Fixed issue where many warnings were reported in server error logs


= 1.292 =
* Minor update to fix SPP Tweet compatibility with WordPress 4.0.1


= 1.29 =
* Address issue where latest episode wasn’t always being loaded in the sidebar widget
* Added option to choose no image, podcast art, image in feed, or libsyn post image in the sidebar widget
* Fixed duplicate post content on some posts using the PowerPress shortcode 
* Fixed issue with Download button text being longer when using shortcode


= 1.28 =
* Fixed conflict with OptimizePress and PowerPress media uploader
* Resolved conflict with Appendipity Themes player on home page.
* Fixed issue where on some pages the Disable Powered By Link option was not working
* New option to Auto Play podcasts


= 1.27 =
* Added affiliate link below the player so you can earn a commission referring others
* Fixed issue with some browsers preloading audio files which affects download stats
* Fixed issue with misalignment of buttons on opt-in form on some themes
* Fixed issue where player appears on posts even when PowerPress setting was set to disabled


= 1.26 =
* Support for non iTunes URLs
* Option to hide player and corresponding text from home, blog, or archive pages
* Option to set custom width for all your players
* Opt-in box submit button hover now works
* Opt-in box improved support on more browsers
* Opt-in box submit button now on the same row as the name and email
* Round buttons are supported on the sidebar and on mobile
* Removed underline from Tweet This text on some themes


= 1.24 =
* After an upgrade, button colours are now updated to reflect your existing settings
* Fixed issue where audio player was not automatically showing up on some sites
* Faster import of podcast channels with many episodes


= 1.18 =
* Fixed issue with some sites where Import Now button wasn't working


= 1.16 =
* Added additional spacing between the audio player and the content around it
* Fixed issue where iTunes reviews were not being displayed on some sites


= 1.12 =
* Redesigned how the audio player is displayed on a page.  Improves compatibility on home, category, or archive pages.
* Fixed issue where button colors where not updated due to caching plugins
* Option to import Podcast Episode Art of Libsyn Site Image as the featured image
* Address issue where sidebar player widget wasn't working on some sites 
* Ability to disable Facebook Open Graph meta data
* Ability to disable URL shortener
* 1-Click Tweetables now uses shortened URLs
* You can now disable opt-in box or buttons on individual pages using shortcode options (see quick start guide for details)
* Rounded buttons now available as an option
* Remove shadow on volume button on white audio player
* Removed the ALL CAPS from the Optin Headline and Sub Headline


= 1.00 =
* First Official Release
