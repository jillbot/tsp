
$j(document).ready(function() {
	"use strict";

    $j('.price_slider_wrapper').parents('.widget').addClass('widget_price_filter');
    initSelect2();
    initAddToCartPlusMinus();
    initProductHeight();
});

$j(window).resize(function() {
   initProductHeight();
});

function initSelect2() {
    $j('.woocommerce-ordering .orderby, #calc_shipping_country, #dropdown_product_cat').select2({
        minimumResultsForSearch: -1
    });
    $j('.woocommerce-account .country_select').select2();
}

function initProductHeight(){
    "use strict";

    if($j('ul.products.type4.article_no_space').length) {
        var max_height = 0 ;
        $j('li.product').each(function() {
                      
            var product_info_init_height =  $j(this).find('.product_info_box').height();
            var product_info_padding_top =  parseFloat($j(this).find('.product_info_box').css('padding-top'));
            var product_info_padding_bottom =  parseFloat($j(this).find('.product_info_box').css('padding-bottom'));
            
            var product_info_height = product_info_init_height + product_info_padding_top + product_info_padding_bottom;
            
            if(product_info_height > max_height){
                max_height = product_info_height;
            }
        });
        $j('li.product').each(function() {
            $j(this).find('.product_info_box').css('height', max_height+'px');
        });
    }
}

function initAddToCartPlusMinus(){
 "use strict";
    $j(document).on( 'click', '.quantity .plus, .quantity .minus', function() {

        // Get values
        var $qty		= $j(this).closest('.quantity').find('.qty'),
            currentVal	= parseFloat( $qty.val() ),
            max			= parseFloat( $qty.attr( 'max' ) ),
            min			= parseFloat( $qty.attr( 'min' ) ),
            step		= $qty.attr( 'step' );

        // Format values
        if ( ! currentVal || currentVal === '' || currentVal === 'NaN' ) currentVal = 0;
        if ( max === '' || max === 'NaN' ) max = '';
        if ( min === '' || min === 'NaN' ) min = 0;
        if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) step = 1;

        // Change the value
        if ( $j( this ).is( '.plus' ) ) {

            if ( max && ( max == currentVal || currentVal > max ) ) {
                $qty.val( max );
            } else {
                $qty.val( currentVal + parseFloat( step ) );
            }

        } else {

            if ( min && ( min == currentVal || currentVal < min ) ) {
                $qty.val( min );
            } else if ( currentVal > 0 ) {
                $qty.val( currentVal - parseFloat( step ) );
            }
        }

        // Trigger change event
        $qty.trigger( 'change' );
    });
}
