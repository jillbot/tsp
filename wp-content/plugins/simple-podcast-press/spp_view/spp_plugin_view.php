<script type="text/javascript">
function htmlspecialchars_decode (string, quote_style) {
  // http://kevin.vanzonneveld.net
  // +   original by: Mirek Slugen
  // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +   bugfixed by: Mateusz "loonquawl" Zalega
  // +      input by: ReverseSyntax
  // +      input by: Slawomir Kaniecki
  // +      input by: Scott Cariss
  // +      input by: Francois
  // +   bugfixed by: Onno Marsman
  // +    revised by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
  // +      input by: Ratheous
  // +      input by: Mailfaker (http://www.weedem.fr/)
  // +      reimplemented by: Brett Zamir (http://brett-zamir.me)
  // +    bugfixed by: Brett Zamir (http://brett-zamir.me)
  // *     example 1: htmlspecialchars_decode("<p>this -&gt; &quot;</p>", 'ENT_NOQUOTES');
  // *     returns 1: '<p>this -> &quot;</p>'
  // *     example 2: htmlspecialchars_decode("&amp;quot;");
  // *     returns 2: '&quot;'
  var optTemp = 0,
    i = 0,
    noquotes = false;
  if (typeof quote_style === 'undefined') {
    quote_style = 2;
  }
  string = string.toString().replace(/&lt;/g, '<').replace(/&gt;/g, '>');
  var OPTS = {
    'ENT_NOQUOTES': 0,
    'ENT_HTML_QUOTE_SINGLE': 1,
    'ENT_HTML_QUOTE_DOUBLE': 2,
    'ENT_COMPAT': 2,
    'ENT_QUOTES': 3,
    'ENT_IGNORE': 4
  };
  if (quote_style === 0) {
    noquotes = true;
  }
  if (typeof quote_style !== 'number') { // Allow for a single string or an array of string flags
    quote_style = [].concat(quote_style);
    for (i = 0; i < quote_style.length; i++) {
      // Resolve string input to bitwise e.g. 'PATHINFO_EXTENSION' becomes 4
      if (OPTS[quote_style[i]] === 0) {
        noquotes = true;
      } else if (OPTS[quote_style[i]]) {
        optTemp = optTemp | OPTS[quote_style[i]];
      }
    }
    quote_style = optTemp;
  }
  if (quote_style & OPTS.ENT_HTML_QUOTE_SINGLE) {
    string = string.replace(/&#0*39;/g, "'"); // PHP doesn't currently escape if more than one 0, but it should
    // string = string.replace(/&apos;|&#x0*27;/g, "'"); // This would also be useful here, but not a part of PHP
  }
  if (!noquotes) {
    string = string.replace(/&quot;/g, '"');
  }
  // Put this in last place to avoid escape being double-decoded
  string = string.replace(/&amp;/g, '&');

  return string;
}
function htmlspecialchars (string, quote_style, charset, double_encode) {
  // From: http://phpjs.org/functions
  // +   original by: Mirek Slugen
  // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +   bugfixed by: Nathan
  // +   bugfixed by: Arno
  // +    revised by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +    bugfixed by: Brett Zamir (http://brett-zamir.me)
  // +      input by: Ratheous
  // +      input by: Mailfaker (http://www.weedem.fr/)
  // +      reimplemented by: Brett Zamir (http://brett-zamir.me)
  // +      input by: felix
  // +    bugfixed by: Brett Zamir (http://brett-zamir.me)
  // %        note 1: charset argument not supported
  // *     example 1: htmlspecialchars("<a href='test'>Test</a>", 'ENT_QUOTES');
  // *     returns 1: '&lt;a href=&#039;test&#039;&gt;Test&lt;/a&gt;'
  // *     example 2: htmlspecialchars("ab\"c'd", ['ENT_NOQUOTES', 'ENT_QUOTES']);
  // *     returns 2: 'ab"c&#039;d'
  // *     example 3: htmlspecialchars('my "&entity;" is still here', null, null, false);
  // *     returns 3: 'my &quot;&entity;&quot; is still here'

  var optTemp = 0,
    i = 0,
    noquotes = false;
  if (typeof quote_style === 'undefined' || quote_style === null) {
    quote_style = 2;
  }
  string = string.toString();
  if (double_encode !== false) { // Put this first to avoid double-encoding
    string = string.replace(/&/g, '&amp;');
  }
  string = string.replace(/</g, '&lt;').replace(/>/g, '&gt;');

  var OPTS = {
    'ENT_NOQUOTES': 0,
    'ENT_HTML_QUOTE_SINGLE': 1,
    'ENT_HTML_QUOTE_DOUBLE': 2,
    'ENT_COMPAT': 2,
    'ENT_QUOTES': 3,
    'ENT_IGNORE': 4
  };
  if (quote_style === 0) {
    noquotes = true;
  }
  if (typeof quote_style !== 'number') { // Allow for a single string or an array of string flags
    quote_style = [].concat(quote_style);
    for (i = 0; i < quote_style.length; i++) {
      // Resolve string input to bitwise e.g. 'ENT_IGNORE' becomes 4
      if (OPTS[quote_style[i]] === 0) {
        noquotes = true;
      }
      else if (OPTS[quote_style[i]]) {
        optTemp = optTemp | OPTS[quote_style[i]];
      }
    }
    quote_style = optTemp;
  }
  if (quote_style & OPTS.ENT_HTML_QUOTE_SINGLE) {
    string = string.replace(/'/g, '&#039;');
  }
  if (!noquotes) {
    string = string.replace(/"/g, '&quot;');
  }

  return string;
}

function valid(f) {
var str = jQuery("#jwsqz_autocode").val();
str = htmlspecialchars_decode(str);
jQuery("#jwsqz_autocode").val(str.replace(/&#?[a-z0-9]+;/g, ""));

} 
	jQuery(document).ready(function($) {
		setTimeout(function (){ jQuery(".spp_icon-auto-publish").popover({'placement': 'right', trigger: "hover"});},4000);
		setTimeout(function (){ jQuery(".spp_icon-draft-post").popover({'placement': 'right', trigger: "hover"});},4000);
		setTimeout(function (){ jQuery(".icon-spp-description").popover({'placement': 'right', trigger: "hover"});},4000);
		setTimeout(function (){ jQuery(".icon-spp-auto-play").popover({'placement': 'right', trigger: "hover"});},4000);
		setTimeout(function (){ jQuery(".spp_icon-sync-description").popover({'placement': 'right', trigger: "hover"});},4000);


		

	

		jQuery('#spp_auto_publish').change(function(event){
		
		if (jQuery(this).is(':checked')) {
			jQuery("#spp_email_on_draft").prop('checked', false); 
			 jQuery(".spp_emaildraft").slideUp('fast');
		  } else {
			jQuery(".spp_emaildraft").slideDown('fast');
		  }
		});
		
      
      		jQuery('#spp_insert_feat_image').change(function(event){
		
		if (jQuery(this).is(':checked')) {
			
			 jQuery(".spp_player_over_image_section").slideDown('fast');
		  } else {
			jQuery(".spp_player_over_image_section").slideUp('fast');
		  }
		});
      
       //	jQuery('#spp_optin_box').change(function(event){
		
		//if (jQuery(this).is(':checked')) {
		//	 jQuery(".optsettings").slideDown('fast');
		//  } else {
		//	jQuery(".optsettings").slideUp('fast');
		//  }
		//});
      
        jQuery('#replace_pp_with_spp').change(function(event){
		
		if (jQuery(this).is(':checked')) {
			 jQuery(".sppress_donotreplace_player").slideDown('fast');
		  } else {
			jQuery(".sppress_donotreplace_player").slideUp('fast');
		  }
		});
        
      
      


		  $("#spp_import_select").bind("change", function () {
		        if ($(this).val() == 2) {
		            $(".date_textbox").slideDown('slow');
		        }
		        else {
		            $(".date_textbox").slideUp('fast');
		        }
		    });
      
      		  $("#select_audio_player").bind("change", function () {
		        if ($(this).val() == "simplepodcastpresscustomcolor") {
                  $(".sppress_customplayer_settings").slideDown('slow');
		        }
		        else {
		            $(".sppress_customplayer_settings").slideUp('fast');
		        }
		    });



		 jQuery("#spp_chk_new_vids, #podcast_url, #fetch_comments, #spp_cbsn_save").click(function() {
		var btn = $(this).attr("value");

		var thehtml = "<div>" + $( '#jwsqz_autocode' ).val() + "</div>";
        var arcode = $( thehtml );
        
        $('#jwsqz_autoformurl').val( arcode.find('form').attr('action') );
        $('#jwsqz_arnameinput').val(
            arcode.find('[type="text"]').filter(function(){return /name/i.test(this.name);}).attr('name') );
		$('#jwsqz_aremailinput').val(
             arcode.find('[type="text"]').filter(function(){return /email/i.test(this.name);}).attr('name')  ); 
       if ($('#jwsqz_aremailinput').val() =='')
       {
        $('#jwsqz_aremailinput').val(
             arcode.find('[type="email"]').filter(function(){return /email/i.test(this.name);}).attr('name')  ); 
        }
              
        var hiddens = "";
         
        arcode.find( '[type="hidden"]' ).each( function() {
           hiddens += jQuery( this ).prop( 'outerHTML' ) + "\n";
        });
            
        $( '#jwsqz_autohidden' ).val( hiddens );

		  var data = jQuery('#spp_setting_form').serialize();

  		  var autoform_url = $("#jwsqz_autoformurl").attr('value');
		  autoform_url = encodeURIComponent(autoform_url);
  		  var autoform_hidden = $("#jwsqz_autohidden").attr('value');
		  autoform_hidden = encodeURIComponent(autoform_hidden);
  		  var autoform_name = $("#jwsqz_arnameinput").attr('value');
  		  var autoform_email = $("#jwsqz_aremailinput").attr('value');


			<?php  $nonce = wp_create_nonce( 'settings' ); ?>

		  data += '&yourpostname=' + btn + '&auto_resp_url=' + autoform_url + '&auto_resp_hidden=' + autoform_hidden + '&auto_resp_name=' + autoform_name + '&auto_resp_email=' + autoform_email + '&wpnonce=<?php echo $nonce ?>' ;


		//alert (data); 

		  var plug_url = "<?php echo SPPRESS_PLUGIN_URL; ?>";
		


	  if(btn == 'Import New Podcasts Now') {

		$('#fetchresults').html('<img src="'+plug_url+'/spp_view/img/loading1.gif" title="loading" style="padding-left: 15px;">');
		

		}else if (btn == 'Save Changes'){

       


		$('.saved').html('<img src="'+plug_url+'/spp_view/img/loading1.gif" title="loading" style="padding-left: 15px;">'); 

		}else if (btn == 'Reset Plugin'){


		$('.reset').html('<img src="'+plug_url+'/spp_view/img/loading1.gif" title="loading" style="padding-left: 15px;">'); 

		}else if (btn == 'Continue'){


		$('.save_access_spinning').html('<img src="'+plug_url+'/spp_view/img/loading1.gif" title="loading" style="padding-left: 15px;">'); 

		}

		  $.post(ajaxurl, data, function(response) {
			

			  if(btn == 'Import New Podcasts Now') {
					$('#fetchresults').html('');

					if(response == 0){
					$('.fetchresults').show();
					$('.fetchresults').html('<button type="button" class="btn close">x</button>No new podcast posts added.</div>');			  
					$('.fetchresults').fadeIn('fast');
					} else {
					$('.fetchresults').show();
					$('.fetchresults').html('<button type="button" class="btn close">x</button>' + response + ' new podcasts posts added.</div>');			  
					$('.fetchresults').fadeIn('fast');
	
					} 

			  }else if (btn == 'Reset Plugin') {

					jQuery('body').load(window.location.href);

			  }else if (btn == 'Continue') {

					if(response == 1){

						$('.save_access_spinning').html('');
						alert('Error Processing iTunes Url.  Please check your URL and try clicking Save again.');

					}else{

					$('body').load(window.location.href);

					}

					//$('.wrap').html(response);			  
			
			
			  }
            else {

                    $('.saved').html('');
					$('#saved').show();	
                    show_message(1);
				  
		}
	
		  });
		
		  return false;
	  }); 
	  
	});
	
	function show_message(n) {
		if(n == 1) {
			jQuery('#saved').html('<button type="button" class="btn close">x</button> <strong>Success!</strong>&nbsp;Settings saved successfully.');
			jQuery('#saved').fadeIn('fast');
		} else {
			jQuery('#saved').html('<button type="button" class="btn close">x</button> <strong>Failed!</strong>&nbsp;Settings saved not successful.');
			jQuery('#saved').fadeIn('fast');
		}
	}
	
	</script>

<form action="<?php echo get_bloginfo('wpurl'); ?>/wp-admin/admin.php?page=spp-podcast-settings" method="post" id="spp_setting_form">
<input type="hidden" name="action" value="save_spp_settings" />
<div class="wrap">
<?php echo $this->spp_pannel(); ?>
</div>
</form>