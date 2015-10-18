<?php
add_shortcode('spp-reviews','spp_reviews_shortcode');
add_action('widgets_init','spp_reviews_load');

function spp_reviews_shortcode($atts){
  extract( shortcode_atts( array(
		'max' => 999,
		'style' => 'slideshow'
	), $atts ) );

	return show_reviews($max,$style);
}

					
function show_reviews($limit,$format){
			$reviews = get_reviews($limit,$format);
			$html = '<div class="reviews_view"><ul  class="reviews_view" style="'.$format.'" current="0">';
			foreach($reviews as $review){
				$html.='<li style="list-style:none !important">';
				$html.='<strong>'.$review['title'].'</strong>';
				$html.='<img src="'.SPPRESS_PLUGIN_URL.'/icons/rating_stars/'.$review['ratings'].'star.png">';
			
				
				$published_date = $review['published_date'];
				$html.='<div>'.date("F j, Y", strtotime($published_date)).' by '.'<b>'.$review['author'].'</b>'.' from '.get_full_country_name($review['country']).'</div>';	
				$html.='<p>'.$review['text'].'</p>';
				$html.='</li>';
			}
			$html.='</ul></div>';
			return $html;
}
function get_reviews($limit,$format){
 
	
	$ret = array();
	$item = array();
  global $wpdb;
	$table_name = $wpdb->prefix.'spp_reviews';
	if($format == 'list')
	  	$reviews = $wpdb->get_results("select * from $table_name  where rw_ratings='5' OR rw_ratings='4' ORDER BY rw_published_date DESC limit $limit");
	else
	   $reviews = $wpdb->get_results("select * from $table_name  where rw_ratings='5' OR rw_ratings='4' ORDER BY rw_published_date DESC");
		 
	foreach($reviews as $review){
		$item['title'] = $review->rw_title;
		$item['text'] = $review->rw_text;
		$item['ratings']  = $review->rw_ratings;
		$item['author'] = $reviews->rw_author;
		$item['published_date'] =$review->rw_published_date;
		$item['author'] = $review->rw_author;
		$item['country'] = $review->rw_coutry;
		$ret[]  = $item;
	}
	return $ret;
}

class SppReviewsWidget extends WP_Widget{
	function __construct(){
	   parent::__construct('sppreviews_widget','Podcast Reviews',array('description'=>'Showcase Your Podcast Reviews'));
	}
	
	public function widget($args,$instance){
		$title = 'Podcast Reviews';
				
		$limit = apply_filters( 5, $instance['max'] );
		$format = apply_filters( 'list', $instance['style'] );
		echo $args['before_widget'];		
		if ( ! empty( $limit ) )
   			echo $args['before_title'].$title.$args['after_title'];
    
		echo show_reviews($limit,$format);
		echo $args['after_widget'];
	}
	
	public function form($instance){
	   if(isset($instance['max'])){
		   $limit = $instance['max'];
		 }else{
		   $limit = 5;
		 }
		 if(isset($instance['style'])){
		   $format = $instance['style'];
		 }else{
		   $format = 'list';
		 }
		 ?>

		  <table>
				<tr>
				  <td>Number of Reviews:</td>
					<td><input style="width: 75px;" type="text" value="<?php echo esc_attr($limit)?>" name="<?php echo $this->get_field_name('max') ?>" id="<?php echo $this->get_field_id('max')?>"></td>
				</tr>
				<tr>
				  <td>Style:</td>						
					<td><input type="radio" value="list" id="<?php echo $this->get_field_id('style')?>" name="<?php echo $this->get_field_name('style') ?>" <?php if($format == 'list') { echo 'checked'; }; ?>>List</td>
				 	<td><input type="radio" value="slideshow" id="<?php echo $this->get_field_id('style')?>" name="<?php echo $this->get_field_name('style') ?>" <?php if($format != 'list') { echo 'checked'; }; ?>>Slideshow</td>
				</tr>
			</table><br>
		 <?php
	}
	
	public function update($newInstance,$oldInstance){
		$instance = array();
		$instance['max'] = ( ! empty( $newInstance['max'] ) ) ? strip_tags( $newInstance['max'] ) : 5;
		$instance['style'] = ( ! empty( $newInstance['style'] ) ) ? strip_tags( $newInstance['style'] ) : 'list';
		return $instance;
	}
}

function spp_reviews_load(){
	register_widget('SppReviewsWidget');
}





function get_full_country_name($short){
		switch($short){
			case 'us':
				$fullname = 'United States';
			break;
			case 'ca':
				$fullname = 'Canada';
			break;
			case 'la':
				$fullname = 'Puerto Rico"';
			break;
			case 'mx':
				$fullname = 'Mexico';
			break;
			case 'gb':
				$fullname = 'United Kingdom';
			break;
			case 'br':
				$fullname = 'Brazil';
			break;
			case 'tr':
				$fullname = 'Turkey';
			break;
			case 'se':
				$fullname = 'Sweden';
			break;
			case 'fi':
				$fullname = 'Finland';
			break;
			case 'ch':
				$fullname = 'Switzerland';
			break;
			case 'si':
				$fullname = 'Slovenia';
			break;
			case 'at':
				$fullname = 'Austria';
			break;
			case 'pl':
				$fullname = 'Poland';
			break;
			case 'pt':
				$fullname = 'Portugal';
			break;
			case 'ro':
				$fullname = 'Romania';
			break;
			case 'ru':
				$fullname = 'Russia';
			break;
			case 'sk':
				$fullname = 'Slovak Republic';
			break;
			case 'no':
				$fullname = 'Norway';
			break;
			case 'nl':
				$fullname = 'Netherlands';
			break;
			case 'md':
				$fullname = 'Moldova';
			break;
			case 'mt':
				$fullname = 'Malta';
			break;
			case 'hu':
				$fullname = 'Hungary';
			break;
			case 'mk':
				$fullname = 'Macedonia';
			break;		
			case 'lu':
				$fullname = 'Luxembourg';
			break;		
			case 'lt':
				$fullname = 'Lithuania';
			break;		
			case 'lv':
				$fullname = 'Latvia';
			break;		
			case 'it':
				$fullname = 'Italy';
			break;		
			case 'ie':
				$fullname = 'Ireland';
			break;		
			case 'hr':
				$fullname = 'Croatia';
			break;		
			case 'gr':
				$fullname = 'Greece';
			break;		
			case 'fr':
				$fullname = 'France';
			break;		
			case 'es':
				$fullname = 'Spain';
			break;		
			case 'ee':
				$fullname = 'Estonia';
			break;		
			case 'de':
				$fullname = 'Germany';
			break;		
			case 'dk':
				$fullname = 'Denmark';
			break;		
			case 'cz':
				$fullname = 'Czech Republic';
			break;		
			case 'bg':
				$fullname = 'Bulgaria';
			break;		
			case 'be':
				$fullname = 'Belgium';
			break;		
			case 'vn':
				$fullname = 'Vietnam';
			break;		
			case 'th':
				$fullname = 'Thailand';
			break;		
			case 'tw':
				$fullname = 'Taiwan';
			break;		
			case 'sg':
				$fullname = 'Singapore';
			break;		
			case 'ph':
				$fullname = 'Philippines';
			break;		
			case 'nz':
				$fullname = 'New Zealand';
			break;		
			case 'my':
				$fullname = 'Malaysia';
			break;		
			case 'kr':
				$fullname = 'South Korea';
			break;		
			case 'jp':
				$fullname = 'Japan';
			break;		
			case 'id':
				$fullname = 'Indonesia';
			break;		
			case 'hk':
				$fullname = 'Hong Kong';
			break;		
			case 'cn':
				$fullname = 'China';
			break;		
			case 'au':
				$fullname = 'Australia';
			break;		
			case 'ae':
				$fullname = 'United Arab Emirates';
			break;		
			case 'ug':
				$fullname = 'Uganda';
			break;		
			case 'tn':
				$fullname = 'Tunisia';
			break;		
			case 'za':
				$fullname = 'South Africa';
			break;		
			case 'sn':
				$fullname = 'Senegal';
			break;		
			case 'sa':
				$fullname = 'Saudi Arabia';
			break;		
			case 'om':
				$fullname = 'Oman';
			break;		
			case 'ng':
				$fullname = 'Nigeria';
			break;		
			case 'ne':
				$fullname = 'Niger';
			break;		
			case 'mz':
				$fullname = 'Mozambique';
			break;		
			case 'mu':
				$fullname = 'Mauritius';
			break;		
			case 'ml':
				$fullname = 'Mali';
			break;		
			case 'mg':
				$fullname = 'Madagascar';
			break;		
			case 'kw':
				$fullname = 'Kuwait';
			break;		
			case 'ke':
				$fullname = 'Kenya';
			break;		
			case 'jo':
				$fullname = 'Jordan';
			break;		
			case 'il':
				$fullname = 'Israel';
			break;		
			case 'in':
				$fullname = 'India';
			break;		
			case 'gw':
				$fullname = 'Guinea Bissau';
			break;		
			case 'eg':
				$fullname = 'Egypt';
			break;		
			case 'bw':
				$fullname = 'Botswana';
			break;		
			case 'bh':
				$fullname = 'Bahrain';
			break;	
			case 'am':
				$fullname = 'Armenia';
			break;	
	
		}//end switch
	return $fullname;
	}
