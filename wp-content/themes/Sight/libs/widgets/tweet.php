<?php
add_action('widgets_init', 'tweets_load_widgets');

function tweets_load_widgets()
{
	register_widget('Tweets_Widget');
}

class Tweets_Widget extends WP_Widget {
	
	function Tweets_Widget()
	{
		$widget_ops = array('classname' => 'twitter_widget', 'description' => 'Tweets widget let you display Twitter updates.');

		$control_ops = array('id_base' => 'tweets-widget');

		$this->WP_Widget('tweets-widget', '&rArr; PressLayer: Tweets', $widget_ops, $control_ops);
	}
	
	function widget($args, $instance)
	{
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$twitter_id = $instance['twitter_id'];
		$consumer_key = $instance['consumer_key'];
		$consumer_secret = $instance['consumer_secret'];
		$user_token = $instance['user_token'];
		$user_secret = $instance['user_secret'];
		$number = $instance['number'];
		$follow = $instance['follow'];
		$tweet_count = $instance['tweet_count'];
		
		echo $before_widget;

		if($title) echo $before_title.$title.$after_title;
		
		
		if ($twitter_id){						
				
			$new_tweets = $this->fetch_tweets($twitter_id, $number, $consumer_key,$consumer_secret, $user_token,$user_secret);	
			
			if (!empty($new_tweets)){
				$user_tweets = $new_tweets;
			}else{
				$user_tweets = '';
			}
			
			if ($user_tweets){
			
				echo "<ul>";				
				foreach ($user_tweets as $tweet) {					
					echo "<li>";
					$filter_tweet =  make_clickable( $tweet->text );
					echo "<div class='tweet'>" . $filter_tweet ;
					$created_time = $tweet->created_at;
					$time_ago = sprintf(__('%s ago', 'presslayer'), human_time_diff(strtotime($created_time)));	
					echo " <em>(" . $time_ago .")</em></div>";
					echo "</li>";
				}
				echo "</ul>";				
			}
		}
		

		if($twitter_id) { ?>
		
		   <?php if($follow == 'yes'){?> 
			<div class="tw_btn">
			<a href="https://twitter.com/<?php echo $twitter_id; ?>" class="twitter-follow-button" data-show-count="<?php echo $tweet_count;?>" >Follow @<?php echo $twitter_id; ?></a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
			 </div>
		  <?php } ?>	
			
			<?php
		}
		
		echo $after_widget;
	}
	
	function fetch_tweets($twitter_id, $number,$consumer_key,$consumer_secret, $user_token,$user_secret){
		$transName = 'tweetData';
		$cacheTime = 10;
		if(false === ($twitterData = get_transient($transName) ) ){
			 require_once 'twitteroauth/twitteroauth.php';
			 $twitterConnection = new TwitterOAuth($consumer_key,$consumer_secret, $user_token,$user_secret);
			 $twitterData = $twitterConnection->get(
							  'statuses/user_timeline',
							  array(
								'screen_name'     => $twitter_id,
								'count'           => $number,
								'exclude_replies' => false
							  )
							);
			
			 if($twitterConnection->http_code != 200)
			 {
				  $twitterData = get_transient($transName);
			 }
			
			// Save our new transient.
			set_transient($transName, $twitterData, 60 * $cacheTime);
		}
		
		return $twitterData;
	}
	
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['twitter_id'] = $new_instance['twitter_id'];
		$instance['consumer_key'] = $new_instance['consumer_key'];
		$instance['consumer_secret'] = $new_instance['consumer_secret'];
		$instance['user_token'] = $new_instance['user_token'];
		$instance['user_secret'] = $new_instance['user_secret'];
		$instance['number'] = $new_instance['number'];
		$instance['follow'] = $new_instance['follow'];
		$instance['tweet_count'] = $new_instance['tweet_count'];
		
		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => 'Recent Tweets', 'twitter_id' => 'presslayer', 'consumer_key' => '','consumer_secret' => '','user_token' => '','user_secret' => '', 'number' => 5, 'follow' => 'yes', 'tweet_count'=>'false');
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" type="text" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('twitter_id'); ?>">Twitter ID:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('twitter_id'); ?>" name="<?php echo $this->get_field_name('twitter_id'); ?>" value="<?php echo $instance['twitter_id']; ?>" type="text" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('consumer_key'); ?>">Consumer key:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('consumer_key'); ?>" name="<?php echo $this->get_field_name('consumer_key'); ?>" value="<?php echo $instance['consumer_key']; ?>" type="text" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('consumer_secret'); ?>">Consumer secret:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('consumer_key'); ?>" name="<?php echo $this->get_field_name('consumer_secret'); ?>" value="<?php echo $instance['consumer_secret']; ?>" type="text" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('user_token'); ?>">Access token:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('user_token'); ?>" name="<?php echo $this->get_field_name('user_token'); ?>" value="<?php echo $instance['user_token']; ?>" type="text" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('user_secret'); ?>">Access token secret:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('user_secret'); ?>" name="<?php echo $this->get_field_name('user_secret'); ?>" value="<?php echo $instance['user_secret']; ?>" type="text" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>">Number of tweets to show:</label>
			<input class="widefat" style="width: 30px;" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" value="<?php echo $instance['number']; ?>" type="text" />
		</p>
		
		<p>
			
			<label for="<?php echo $this->get_field_id('follow'); ?>">Follow button:</label> 
			<select id="<?php echo $this->get_field_id('follow'); ?>" name="<?php echo $this->get_field_name('follow'); ?>" class="widefat follow" style="width:100%;">
				<option value='yes' <?php if ('yes' == $instance['follow']) echo 'selected="selected"'; ?>>Yes</option>
				<option value='no' <?php if ('no' == $instance['follow']) echo 'selected="selected"'; ?>>No</option>
			</select>
		</p>
		
		<p>
			
			<label for="<?php echo $this->get_field_id('tweet_count'); ?>">Tweets count:</label> 
			<select id="<?php echo $this->get_field_id('tweet_count'); ?>" name="<?php echo $this->get_field_name('tweet_count'); ?>" class="widefat follow" style="width:100%;">
				<option value='true' <?php if ('true' == $instance['tweet_count']) echo 'selected="selected"'; ?>>Yes</option>
				<option value='false' <?php if ('false' == $instance['tweet_count']) echo 'selected="selected"'; ?>>No</option>
			</select>
		</p>
		
	<?php
	}
}
?>