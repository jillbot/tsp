<?php
/*************************************************************************************************************
file draft-notify.php is a part of Simple Podcast Press and contains proprietary code - simplepodcastpress.com
*************************************************************************************************************/

function spp_process($id) {

	global $wpdb;

	$prefix = $wpdb->prefix;
	
	
	$podcastid = get_post_meta( $id, '_audiourl', true);


	// emails anyone on or above this level, unless a specific email address is entered.



	$emailAddress =  get_option( 'admin_email' );

	

                    // Author's first and last name are found in the metadata table.

	$result = $wpdb->get_row("

		SELECT 	post_status, post_title, post_modified, 

                        user_login, display_name, user_email, 

                        {$prefix}usermeta.meta_value as fname, 

                        meta2.meta_value as lname

		FROM 	{$prefix}posts, {$prefix}users

                            LEFT JOIN ({$prefix}usermeta) ON

                                    ({$prefix}usermeta.user_id = {$prefix}users.ID AND 

                                     {$prefix}usermeta.meta_key = 'first_name' )

                            LEFT JOIN ({$prefix}usermeta as meta2) ON

                                    (meta2.user_id = {$prefix}users.ID AND 

                                     meta2.meta_key = 'last_name' )

		WHERE 	{$prefix}posts.post_author = {$prefix}users.ID AND {$prefix}posts.ID = '$id' ");



	if ( (($result->post_status == "draft") || ($result->post_status == "pending")) && $result->post_parent == 0 && !empty($podcastid)) {




            $canEmail = true;

           

                // only check if the setting says to ignore revisions.

                

                $revisionCheck = $wpdb->get_results("

                    SELECT 	* 

                    FROM 	{$prefix}posts

                    WHERE 	{$prefix}posts.post_parent = '$id' AND 

                            {$prefix}posts.post_name != '{$id}-autosave%' ");

                if(count($revisionCheck) > 0)

                {

                    $canEmail = false;

                }

                if (isset($_POST['post_type'])){


                    $canEmail = false;


				}

           

            

            // also do the manual check for the autosave of the first draft.  

            $alreadyEmailedList = get_option('draftnotifyemailedlist');

            $emailedEx = explode("|", $alreadyEmailedList);

            

            if(in_array($id, $emailedEx))

            {

                $canEmail = false;

            }

            

            if($canEmail)

            {
		$message = "Great News!<br /><br />Simple Podcast Press has created a new DRAFT podcast blog post from your latest podcast episode.\n<br /><br />";

		$message .= "Your new podcast blog post is called <a href='" . home_url('/') . "wp-admin/post.php?post=". $id ."&action=edit' target='_blank'>" . $result->post_title . "</a>\n<br /><br />";

		$message .= "Whenever you are ready, you can click here to <a href='" . home_url('/') . "wp-admin/post.php?post=". $id ."&action=edit' target='_blank'>" . "to edit and publish" . "</a> this podcast blog post and share it with the world.\n<br /><br />";

		//$message .= "Draft Blog Post Created On: " . $result->post_modified . "\n<br />";
		$message .= "Keep up the great work...\n<br />";
		$message .= "Your Simple Podcast Press Team\n<br />";



	

                

                $savedEmailPostLinkVal = get_option('draftnotifyemailpostlink');

                $savedEmailAuthorNameVal = get_option('draftnotifyemailauthorname');

                $savedEmailAuthorEmailAddressVal = get_option('draftnotifyemailauthoremail');

                

                if($savedEmailAuthorNameVal)

                {

                    $message .= "Author's Real Name: {$result->fname} {$result->lname }\n<br>";

                }

                

                

                if($savedEmailAuthorEmailAddressVal)

                {

                    $message .= "Author's Email Address: " . $result->user_email . "\n<br>";

                }

                

                if($savedEmailPostLinkVal)

                {

                    $message .= "\n<br>Link to Pending Posts: <a href='" . home_url('/') . "wp-admin/edit.php?post_status=pending&post_type=post' target='_blank'>here</a>\n<br>";                }

                

		$subject = "[Simple Podcast Press] A New Draft Podcast Post Is Ready On '" . get_bloginfo('name') . "'";



		

		$recipient = $emailAddress;

				

               $headers  = 'MIME-Version: 1.0' . "\r\n";

               $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                  wp_mail($recipient, $subject, $message, $headers);
				
            

                if(!in_array($id, $emailedEx))

                {

                    update_option('draftnotifyemailedlist', "{$alreadyEmailedList}|{$id}" );

                }

            }

	}

	

}

$spp_email_on_draft	=	get_option('spp_email_on_draft');

if ($spp_email_on_draft == 1) {


add_action('save_post', 'spp_process');

}

?>