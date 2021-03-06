var $j = jQuery.noConflict();

$j(document).ready(function() {
	"use strict";

	fitAudio();
});

$j(window).load(function() {
	"use strict";

	initBlog();
	initBlogMasonryFullWidth();
    initBlogMasonryGallery();    
});

$j(window).resize(function() {
	fitAudio();
	initBlog();
	initBlogMasonryFullWidth();
    initBlogMasonryGallery();
});

/*
 **	Init audio player for blog layout
 */
function fitAudio(){
	"use strict";

	$j('audio.blog_audio').mediaelementplayer({
		audioWidth: '100%'
	});
}
/*
 **	Init masonry layout for blog template
 */
function initBlog(){
	"use strict";

	if($j('.blog_holder.masonry').length){

		var $container = $j('.blog_holder.masonry');

		$container.isotope({
			itemSelector: 'article',
			resizable: false,
			masonry: {
				columnWidth: '.blog_holder_grid_sizer',
				gutter: '.blog_holder_grid_gutter'
			}
		});

		$j('.filter').click(function(){
			var selector = $j(this).attr('data-filter');
			$container.isotope({ filter: selector });
			return false;
		});

		if( $container.hasClass('masonry_infinite_scroll')){
			$container.infinitescroll({
					navSelector  : '.blog_infinite_scroll_button span',
					nextSelector : '.blog_infinite_scroll_button span a',
					itemSelector : 'article',
					loading: {
						finishedMsg: finished_text,
						msgText  : loading_text
					}
				},
				// call Isotope as a callback
				function( newElements ) {
					$container.append(newElements).isotope( 'appended', $j( newElements ) );
					fitVideo();
					fitAudio();
					initFlexSlider();
					setTimeout(function(){
						$j('.blog_holder.masonry').isotope( 'layout');
					},400);
				}
			);
		}else if($container.hasClass('masonry_load_more')){

			var i = 1;
			$j('.blog_load_more_button a').on('click', function(e)  {
				e.preventDefault();

				var link = $j(this).attr('href');
				var $content = '.masonry_load_more';
				var $anchor = '.blog_load_more_button a';
				var $next_href = $j($anchor).attr('href');
				$j.get(link+'', function(data){
					var $new_content = $j($content, data).wrapInner('').html();
					$next_href = $j($anchor, data).attr('href');
					$container.append( $j( $new_content) ).isotope( 'reloadItems' ).isotope({ sortBy: 'original-order' });
					fitVideo();
					fitAudio();
					initFlexSlider();
					setTimeout(function(){
						$j('.blog_holder.masonry').isotope( 'layout');
					},400);
					if($j('.blog_load_more_button span').data('rel') > i) {
						$j('.blog_load_more_button a').attr('href', $next_href); // Change the next URL
					} else {
						$j('.blog_load_more_button').remove();
					}
				});
				i++;
			});
		}

		$j('.blog_holder.masonry, .blog_load_more_button_holder').animate({opacity: "1"}, 400, function(){
			$j('.blog_holder.masonry').isotope( 'layout');
		});
	}
}


/**
 * Blog Masonry gallery, init masonry and resize pictures in grid
 */
function initBlogMasonryGallery(){
    "use strict";

    resizeBlogMasonryGallery($j('.blog_holder_grid_sizer').width());

    if($j('.blog_holder.blog_masonry_gallery').length){

        $j('.blog_holder.blog_masonry_gallery').each(function(){
            var $this = $j(this);
            $this.waitForImages(function(){
                $this.animate({opacity:1});
                $this.isotope({
                    itemSelector: 'article',
                    masonry: {
                        columnWidth: '.blog_holder_grid_sizer'
                    }
                });
            });
        });
        var $container = $j('.blog_holder.blog_masonry_gallery');
        if( $container.hasClass('masonry_infinite_scroll')){
			$container.infinitescroll({
					navSelector  : '.blog_infinite_scroll_button span',
					nextSelector : '.blog_infinite_scroll_button span a',
					itemSelector : 'article',
					loading: {
						finishedMsg: finished_text,
						msgText  : loading_text
					}
				},
				// call Isotope as a callback
				function( newElements ) {
					$container.isotope( 'appended', $j( newElements ) );
					fitVideo();
					fitAudio();
					initFlexSlider();
					setTimeout(function(){
						$j('.blog_holder.blog_masonry_gallery').isotope( 'layout');
					},400);
				}
			);
		}else if($container.hasClass('masonry_load_more')){

			var i = 1;
			$j('.blog_load_more_button a').on('click', function(e)  {
				e.preventDefault();

				var link = $j(this).attr('href');
				var $content = '.masonry_load_more';
				var $anchor = '.blog_load_more_button a';
				var $next_href = $j($anchor).attr('href');
				$j.get(link+'', function(data){
					var $new_content = $j($content, data).wrapInner('').html();
					$next_href = $j($anchor, data).attr('href');
					$container.append( $j( $new_content) ).isotope( 'reloadItems' ).isotope({ sortBy: 'original-order' });
					fitVideo();
					fitAudio();
					initFlexSlider();
					setTimeout(function(){
						$j('.blog_holder.blog_masonry_gallery').isotope( 'layout');
					},400);
					if($j('.blog_load_more_button span').data('rel') > i) {
						$j('.blog_load_more_button a').attr('href', $next_href); // Change the next URL
					} else {
						$j('.blog_load_more_button').remove();
					}
				});
				i++;
			});
		}
        $j(window).resize(function(){
            resizeBlogMasonryGallery($j('.blog_holder_grid_sizer').width());
            $j('.blog_holder.blog_masonry_gallery').isotope('reloadItems');
        });
    }
}

function resizeBlogMasonryGallery(size){
    "use strict";

    var rectangle_portrait = $j('.blog_holder.blog_masonry_gallery .rectangle_portrait');
    var rectangle_landscape = $j('.blog_holder.blog_masonry_gallery .rectangle_landscape');
    var square_big = $j('.blog_holder.blog_masonry_gallery .square_big');
    var square_small = $j('.blog_holder.blog_masonry_gallery .square_small');

    rectangle_portrait.css('height', 2*size);
    rectangle_landscape.css('height', size);
    square_big.css('height', 2*size);
    if (square_big.width() < 350) {
        square_big.css('height', square_big.width());
    }
    square_small.css('height', size);
}

/*
 **	Init full width masonry layout for blog template
 */
function initBlogMasonryFullWidth(){
	"use strict";

	if($j('.masonry_full_width').length){

		var $container = $j('.masonry_full_width');

		$j('.filter').click(function(){
			var selector = $j(this).attr('data-filter');
			$container.isotope({ filter: selector });
			return false;
		});

		if( $container.hasClass('masonry_infinite_scroll')){
			$container.infinitescroll({
					navSelector  : '.blog_infinite_scroll_button span',
					nextSelector : '.blog_infinite_scroll_button span a',
					itemSelector : 'article',
					loading: {
						finishedMsg: finished_text,
						msgText  : loading_text
					}
				},
				// call Isotope as a callback
				function( newElements ) {
					$container.isotope( 'appended', $j( newElements ) );
					fitVideo();
					fitAudio();
					initFlexSlider();
					setTimeout(function(){
						$j('.blog_holder.masonry_full_width').isotope( 'layout');
					},400);
				}
			);
		} else if($container.hasClass('masonry_load_more')){

			var i = 1;
			$j('.blog_load_more_button a').on('click', function(e)  {
				e.preventDefault();

				var link = $j(this).attr('href');
				var $content = '.masonry_load_more';
				var $anchor = '.blog_load_more_button a';
				var $next_href = $j($anchor).attr('href');
				$j.get(link+'', function(data){
					var $new_content = $j($content, data).wrapInner('').html();
					$next_href = $j($anchor, data).attr('href');
					$container.append( $j( $new_content) ).isotope( 'reloadItems' ).isotope({ sortBy: 'original-order' });
					fitVideo();
					fitAudio();
					initFlexSlider();
					setTimeout(function(){
						$j('.blog_holder.masonry_full_width').isotope( 'layout');
					},400);
					if($j('.blog_load_more_button span').data('rel') > i) {
						$j('.blog_load_more_button a').attr('href', $next_href); // Change the next URL
					} else {
						$j('.blog_load_more_button').remove();
					}
				});
				i++;
			});
		}

		$container.isotope({
			itemSelector: 'article',
			resizable: false,
			masonry: {
				columnWidth: '.blog_holder_grid_sizer',
				gutter: '.blog_holder_grid_gutter'
			}
		});

		$j('.masonry_full_width, .blog_load_more_button_holder').animate({opacity: "1"}, 400, function(){
			$j('.blog_holder.masonry_full_width').isotope( 'layout');
		});
	}
}

