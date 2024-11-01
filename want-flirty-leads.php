<?php

/* 
Plugin Name: Want Flirty Leads Plugin 
URI: http://www.orcawebperformance.com/want-flirty-leads-a-wordpress-plugin/
Description: Tags: lead capture, call to action, email campaigns, direct dashboard media editing, image lead capture
Version: 1.0
Author: sageshilling
License: GPL2
*/

/*  Copyright 2017  Elizabeth Shilling - Orca Web Performance  
(email : eshilling@orcawebperformance.com)
This program is free software; you can redistribute it and/or modifyit under the terms of the GNU General Public License, 
version 2, aspublished by the Free Software Foundation.This program is distributed in the hope that it will be useful,but 
WITHOUT ANY WARRANTY; without even the implied warranty ofMERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
See theGNU General Public License for more details.
You should have received a copy of the GNU General Public Licensealong with this program; if not, 
rite to the Free SoftwareFoundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/



//hook in all the important things

function ecs_owp_wfl_wantflirtyleads_scripts() {

		//single post and main query or Default homepage or static homepage or blog page

	//if ( (is_single() && is_main_query()) || (is_front_page() && is_home()) || is_front_page() || is_home() ) {

	//Get plugin stylesheet

	wp_enqueue_style( 'wantflirtyleads-style', plugin_dir_url(__FILE__) . 'css/style.css', '0.1', 'all');

	

	wp_enqueue_script( 'wantflirty-script', plugin_dir_url(__FILE__) . 'js/wantflirty.ajax.js', array('jquery'), '0.1', true );	

	

	      // Get the protocol of the current page

        $protocol = isset( $_SERVER['HTTPS'] ) ? 'https://' : 'http://';

 

        // Set the ajaxurl Parameter which will be output right before

        // our ajax-like-image.js file so we can use ajaxurl

        $params = array(

            // Get the url to the admin-ajax.php file using admin_url()

            'ajaxurl' => admin_url( 'admin-ajax.php', $protocol ),
			'phone' => '555 555 5555'

        );

	  // Print the script to our page

	wp_localize_script( 'wantflirty-script', 'postdata',  $params );
	//} if blog, page...
}

add_action( 'wp_enqueue_scripts', 'ecs_owp_wfl_wantflirtyleads_scripts');


											//data for the image likes and counts

											//second try

											function ecs_owp_wfl_wantflirtyleads_content($content) { 

											//single post and main query or Default homepage or static homepage or blog page

											if ( (is_single() && is_main_query()) || (is_front_page() && is_home()) || is_front_page() || is_home() || ! is_admin() || ! has_excerpt()  ) {

													//$pos = strpos($newstring, 'a', 1);  skip first a

												$postimagecount = substr_count( $content, 'wp-image-' );

												if ($postimagecount == 0) return $content; //no images in post

												

														else

												{//find img 

																	//for unique form id

																	$uniq_id = 0;

																	$finalstring = "";

													while($postimagecount != 0)

														{

															$checkstring =strstr( $content, 'img' );  //remaining string inc img

															//Returns part of haystack string starting from and including the first occurrence of needle to the end of haystack.

															$imgpos = strpos( $content, 'img' );  //where i is at

															

															//get info

															//get image id

													$pos3 = strpos($content, 'wp-image-');

													//string substr ( string $string , int $start [, int $length ] )

													$contentedit2 = substr($content, $pos3);  //wp-image...

													$pos4 = strpos($contentedit2, '"');

													$imagenumlen = $pos4 - 9;

													$imagechunk = 10 + $imagenumlen;

													$imageinfopart = substr($contentedit2, 0, $imagechunk);

													$imagenumlen1 = $imagenumlen + 1; 

													//imgnumlennlaspiece

													$imageid = (int) substr($imageinfopart, -$imagenumlen1, $imagenumlen);

													

													

										//show lc default no

									$key_value = get_post_meta( $imageid, '_ecs_owp_wfl_show_lc', true );

									if ($key_value == "") $key_value = "no";

									if ($key_value == "no"){

															$firstcontent = substr( $content, 0, ($imgpos)); //beg to img(wo img or)

															$finalstring .= $firstcontent;	

													//*****************

															//reset content to remaining string

																				

																				$content = $checkstring;

																			//	if (key_value == "yes"){

																			//find end of image, the next >

																$midstring = strstr( $content, '>' ); //remaining string from >

																//check next position for </a> 1-4

																$isimg = substr($midstring, 1, 4);

																if($isimg == "</a>"){ //it's a linked image

																//find end of image, the next </a>

																$checkstring =strstr( $content, '</a>' );  //remaining string inc </a>

																$endimgpos = strpos( $content, '</a>' );  //where < is at

																$firstcontent = substr( $content, 0, ($endimgpos+4)); //beg to </a>(w</a>

																

																

																

																//if (key_value == "yes"){

																$finalstring .= $firstcontent;

																 

																$checkstring =substr( $content, ($endimgpos + 4)); //beg </a>(wo </a>

																

																$content = $checkstring;

																}

																	else {//no link

																	//find end of image, the next >

																$checkstring =strstr( $content, '>' );  //remaining string inc >

																$endimgpos = strpos( $content, '>' );  //where > is at

																$firstcontent = substr( $content, 0, ($endimgpos + 1) ); //beg to >(w>

																$finalstring .= $firstcontent;

															

																

																$checkstring =substr( $content, ($endimgpos + 1)); //beg >(wo >

																$content = $checkstring;

																}

									}	

									 //$key_value = "yes";

									else {

													$content = str_replace('<img', '<div class="elizabethknowscode"><img', $content);

													$content = str_replace('img class="', 'img class="item1_wfl ', $content);

													$checkstring =strstr( $content, 'img' );  //remaining string inc img

															//Returns part of haystack string starting from and including the first occurrence of needle to the end of haystack.

															$imgpos = strpos( $content, 'img' );  //where i is at

													

													

													//get image width in the post from php string functions

													$widthcontentedit3 = strstr($checkstring, 'width' );  //width...

													$firstquotes = strstr( $widthcontentedit3, '"' );  //first "...

													$firstquotespos = strpos( $firstquotes, '"' );  //pos first " is at 0

													//$placekeeper = $firstquotepos + 1; //1

													$firstquoteslen = strlen($firstquotes); //894

													$widthcontentedit3 = substr($firstquotes, 1, ($firstquoteslen -2)); //snippet caught

													$secondquotespos = strpos( $widthcontentedit3, '"' );  //pos second ...3

													$clipimagewidth = substr($firstquotes, 1, $secondquotespos); //gives image width

													

													

													//get image alignment in the post from php string functions

													$aligncontentedit3 = strstr($checkstring, 'align' );  //align...

													$alignspacepos = strpos( $aligncontentedit3, ' ' );  //pos first " " 

													$clipimagealignment = substr($aligncontentedit3, 0, $alignspacepos); //gives image alignment

													

													//get image width

													//$attachment_meta = wp_get_attachment_metadata( $imageid, $unfiltered );  //this works mainly except thumbnails 150px

													//$meta_width = $attachment_meta['width'];

													//$attachment_meta = wp_get_attachment_image_src( $imageid );

													//$meta_width = $attachment_meta[1];

													

													//get field values

												

													

													$key_1_value = get_post_meta( $imageid, '_ecs_owp_wfl_cta_color', true );

													$key_7_value = get_post_meta( $imageid, '_ecs_owp_wfl_cta_size', true );

													$key_8_value = get_post_meta( $imageid, '_ecs_owp_wfl_cta_weight', true );

													$key_9_value = get_post_meta( $imageid, '_ecs_owp_wfl_cta_height', true );

													$key_2_value = get_post_meta( $imageid, '_ecs_owp_wfl_lead_capture_header', true );

													if ($key_2_value == "") $key_2_value = "Find out more!";

													$key_3_value = get_post_meta( $imageid, '_ecs_owp_wfl_referer', true );

													if ($key_3_value == "") $key_3_value = get_bloginfo();

													$key_4_value = get_post_meta( $imageid, '_ecs_owp_wfl_btnsays', true );

													if ($key_4_value == "") $key_4_value = "send";

													$key_5_value = get_post_meta( $imageid, '_ecs_owp_wfl_lcemail', true );

													if ($key_5_value == "") $key_5_value = get_option( 'admin_email' );  

													$key_6_value = get_post_meta( $imageid, '_ecs_owp_wfl_btn_text_color', true );

													$key_10_value = get_post_meta( $imageid, '_ecs_owp_wfl_btn_color', true );

													

													
													
													

													//if ($key_6_value == "") $key_6_value = "left";

												

													

													$firstcontent = substr( $content, 0, ($imgpos)); //beg to img(wo img or)

													//$firstcontent = str_replace('elizabethknowscode', 'elizabethknowscode' . $key_6_value, $firstcontent);

													$firstcontent = str_replace('elizabethknowscode"', 'elizabethknowscode' . $clipimagealignment . '" width="' . $clipimagewidth . 'px"> <div class="col"', $firstcontent);

													//$firstcontent = str_replace('elizabethknowscode', 'elizabethknowscode' . $clipimagealignment, $firstcontent);

															$finalstring .= $firstcontent;

													

													

													$email_jq = 'onblur="if (this.value == \'\') {this.value = \'carroll@yourteam.com\';}" onfocus="if (this.value == \'carroll@yourteam.com\') {this.value = \'\';}"';

													

													if ($key_value == "no")

													{ $ShowLC = 'style="display:none;"';} else { $ShowLC = '';} //else { $ShowLC = '';}  causes edit

													

													$str1 = '';

													// background color $bg_color']

													//$str2 = '<div class="item2_wfl"><div class"wantflirty"><div class="flirt1_wfl"><div class="lead_capture_header_' . $uniq_id . '" ' . $ShowLC . '>';

													$str2 = '<div class="item2_wfl' . $clipimagealignment . '" style="height: ' . $key_9_value . 'px;';

													$str2a = '"><div class"wantflirty"><div class="flirt1_wfl" style="font-size: ' . $key_7_value . 'px; font-weight: ' . $key_8_value . '; color: #' . $key_1_value . '; "><div class="lead_capture_header_' . $uniq_id . '" ' . $ShowLC . '>';

													// $lead_capture_header

													$str3= '</div></div><div id="thanks_' . $imageid .'" style="display:none">Thank you!<br />********</div><div class="flirt2_wfl"><form  action="';
													
									
															$str3b ='" method="post" id ="lcform_' . $uniq_id . '" name="ContactForm" class="form_wfl form_wfl--complex flecs_get-post"' . $ShowLC . '> 
															<input id="invitation_id_' . $imageid . '" name="form_id" type="hidden" value="' . $imageid . '" />
															<input id="uniq_id_' . $uniq_id . '" name="uniq_id" type="hidden" value="' . $uniq_id . '" />' . 
					                                       wp_nonce_field('wantflirty_gin-lead-' . $imageid , 'nonce') . '
															<input id="invitation_referer_' . $imageid . '" name="referer" type="hidden" value="' ;
													
													// $referer
													$str4='" /><input id="invitation_name_' . $imageid . '" name="lcemail" type="hidden" value="' . $key_5_value . '"><input id="invitation_phone_' . $imageid . '" name="telephone" type="hidden" value="555 555 5555">
															  <input class="form__text_input form_wfl__object--fillspace" id="invitation_email_' . $imageid . '" name="email" placeholder="carroll@example.com"';

															  $str4a='type="email" required>';// if ($key_4_value == "") $key_4_value = "send";

															$str4b='<button name="submit" class="form_wfl__object--fillspace-gap btn ecs_form" type="submit" style="background-color:#' . $key_10_value . '; color:#' . $key_6_value . ';">' . $key_4_value . '</button>';

															$str5='</form></div></div></div></div></div>';

															//$btnsays



															

															

													//*****************

															//reset content to remaining string

																				

																				$content = $checkstring;

																			//	if (key_value == "yes"){

																			//find end of image, the next >

																$midstring = strstr( $content, '>' ); //remaining string from >

																//check next position for </a> 1-4

																$isimg = substr($midstring, 1, 4);

																if($isimg == "</a>"){ //it's a linked image

																//find end of image, the next </a>

																$checkstring =strstr( $content, '</a>' );  //remaining string inc </a>

																$endimgpos = strpos( $content, '</a>' );  //where < is at

																$firstcontent = substr( $content, 0, ($endimgpos+4)); //beg to </a>(w</a>

																

																

																

																//if (key_value == "yes"){

																$finalstring .= ($firstcontent.$str2.$key_6_value.$str2a.$key_2_value.$str3.$str3b.$key_3_value.$str4.$str4a.$str4b.$str5);

																 

																$checkstring =substr( $content, ($endimgpos + 4)); //beg </a>(wo </a>

																

																//remove elizabethknowscode

																$checkstring = str_replace('<div class="elizabethknowscode"><img', '<img', $checkstring);

																$checkstring = str_replace('img class="item1_wfl ', 'img class="',  $checkstring);

																

																$content = $checkstring;

																}

																	else {//no link

																	//find end of image, the next >

																$checkstring =strstr( $content, '>' );  //remaining string inc >

																$endimgpos = strpos( $content, '>' );  //where > is at

																$firstcontent = substr( $content, 0, ($endimgpos + 1) ); //beg to >(w>

																$finalstring .= ($firstcontent.$str2.$key_6_value.$str2a.$key_2_value.$str3.$str3b.$key_3_value.$str4.$str4a.$str4b.$str5);

															

																

																$checkstring =substr( $content, ($endimgpos + 1)); //beg >(wo >

																

																//remove elizabethknowscode

																$checkstring = str_replace('<div class="elizabethknowscode"><img', '<img', $checkstring);

																$checkstring = str_replace('img class="item1_wfl ', 'img class="',  $checkstring);

																

																$content = $checkstring;

																}

									}							

																$postimagecount = substr_count( $content, 'wp-image-' );

																$uniq_id++;

														}

												}

												if (has_excerpt() ) {$checkstring = str_replace("Thank you!<br />********", "", $checkstring);

																	 $finalstring = str_replace("Thank you!<br />********", "", $finalstring);}

												return $finalstring.$checkstring;

												}//for if front page, blog...

												else return $content;

											}



												

													

													add_filter( 'the_content', 'ecs_owp_wfl_wantflirtyleads_content' );

													

													function ecs_owp_wfl_referer_value () { $ecs_owp_wfl_referer_value = get_post_meta( $imageid, _ecs_owp_wfl_referer, true ); return $ecs_owp_wfl_referer_value; }

													/** * Adding a "Copyright" field to the media uploader $form_fields array 

													* 

													* ref http://bavotasan.com/2012/add-a-copyright-field-to-the-media-uploader-in-wordpress/ 

													* @param array $form_fields * @param object $post 

													* 

													* @return array 

													*/

													/** * Adding a "show lc" field to the media uploader $form_fields array * @param array $form_fields * @param object $post * * @return array */

													function wantflirtyleads_add_ecs_owp_wfl_show_lc_field_to_media_uploader($form_fields, $post){

													if((get_post_meta($post->ID, '_ecs_owp_wfl_show_lc', true)) == "") $ecs_owp_wfl_show_lc_value = 'no';      

													else $ecs_owp_wfl_show_lc_value = get_post_meta( $post->ID, '_ecs_owp_wfl_show_lc', true );	

													$form_fields['ecs_owp_wfl_show_lc_field'] = array(		'label' => __('Show lead capture form (yes or no, default set to not show form)'),		'value' => $ecs_owp_wfl_show_lc_value,		'helps' => 'Set a field to add show_lc to show_activate lc'	);	

													return $form_fields;

													}

													add_filter('attachment_fields_to_edit', 'wantflirtyleads_add_ecs_owp_wfl_show_lc_field_to_media_uploader', null, 2);

													/** * Save our new "show lc" field * * @param object $post * @param object $attachment * * @return array */

													function wantflirtyleads_add_ecs_owp_wfl_show_lc_field_to_media_uploader_save($post, $attachment){	

													if(!empty($attachment['ecs_owp_wfl_show_lc_field'])) update_post_meta($post['ID'], '_ecs_owp_wfl_show_lc', sanitize_text_field($attachment['ecs_owp_wfl_show_lc_field']));	

													else delete_post_meta($post['ID'], '_ecs_owp_wfl_show_lc');	

													return $post;

													}

													add_filter( 'attachment_fields_to_save', 'wantflirtyleads_add_ecs_owp_wfl_show_lc_field_to_media_uploader_save', null, 2);

													/** * Display our new "show lc" field * * @param int $attachment_id * * @return array */

													function wantflirtyleads_get_featured_image_ecs_owp_wfl_show_lc($attachment_id = null){	

													$attachment_id = (empty($attachment_id)) ? get_post_thumbnail_id() : (int)$attachment_id;	

													if($attachment_id) return get_post_meta($attachment_id, '_ecs_owp_wfl_show_lc', true);

													}

													

													/** * Adding a "lead_capture_header" field to the media uploader $form_fields array * @param array $form_fields * @param object $post * * @return array */

													function wantflirtyleads_add_ecs_owp_wfl_lead_capture_header_field_to_media_uploader($form_fields, $post){

													if((get_post_meta($post->ID, '_ecs_owp_wfl_lead_capture_header', true)) == "") $ecs_owp_wfl_lead_capture_header_value = 'Find out more!';      

													else $ecs_owp_wfl_lead_capture_header_value = get_post_meta( $post->ID, '_ecs_owp_wfl_lead_capture_header', true );	

													$form_fields['ecs_owp_wfl_lead_capture_header_field'] = array(		'label' => __('Call to action'),		'value' => $ecs_owp_wfl_lead_capture_header_value,		'helps' => 'Set a field to add call to action to the image attachment'	);	

													return $form_fields;

													}

													add_filter('attachment_fields_to_edit', 'wantflirtyleads_add_ecs_owp_wfl_lead_capture_header_field_to_media_uploader', null, 2);

													/** * Save our new "lead capture header" field * * @param object $post * @param object $attachment * * @return array */

													function wantflirtyleads_add_ecs_owp_wfl_lead_capture_header_field_to_media_uploader_save($post, $attachment){	

													if(!empty($attachment['ecs_owp_wfl_lead_capture_header_field'])) update_post_meta($post['ID'], '_ecs_owp_wfl_lead_capture_header', sanitize_text_field($attachment['ecs_owp_wfl_lead_capture_header_field']));	

													else delete_post_meta($post['ID'], '_ecs_owp_wfl_lead_capture_header');	

													return $post;

													}

													add_filter( 'attachment_fields_to_save', 'wantflirtyleads_add_ecs_owp_wfl_lead_capture_header_field_to_media_uploader_save', null, 2);

													/** * Display our new "lead capture header" field * * @param int $attachment_id * * @return array */

													function wantflirtyleads_get_featured_image_ecs_owp_wfl_lead_capture_header($attachment_id = null){	

													$attachment_id = (empty($attachment_id)) ? get_post_thumbnail_id() : (int)$attachment_id;	

													if($attachment_id) return get_post_meta($attachment_id, '_ecs_owp_wfl_lead_capture_header', true);

													}

													

													

													function wantflirtyleads_add_ecs_owp_wfl_btnsays_field_to_media_uploader($form_fields, $post){	

													if((get_post_meta($post->ID, '_ecs_owp_wfl_btnsays', true)) == "") $ecs_owp_wfl_btnsays_value ='send';      

													else $ecs_owp_wfl_btnsays_value = get_post_meta( $post->ID, '_ecs_owp_wfl_btnsays', true );	

													$form_fields['ecs_owp_wfl_btnsays_field'] = array(		'label' => __('Button text'),		'value' => $ecs_owp_wfl_btnsays_value,		'helps' => 'Set text to the button'	);	

													return $form_fields;

													}

													add_filter('attachment_fields_to_edit', 'wantflirtyleads_add_ecs_owp_wfl_btnsays_field_to_media_uploader', null, 2);

													/** * Save our new "Button text" field * * @param object $post * @param object $attachment * * @return array */

													function wantflirtyleads_add_ecs_owp_wfl_btnsays_field_to_media_uploader_save($post, $attachment) {	

													if(!empty($attachment['ecs_owp_wfl_btnsays_field'])) update_post_meta($post['ID'], '_ecs_owp_wfl_btnsays', sanitize_text_field($attachment['ecs_owp_wfl_btnsays_field']));	

													else delete_post_meta($post['ID'], '_ecs_owp_wfl_btnsays');	

													return $post;

													} 

													add_filter( 'attachment_fields_to_save', 'wantflirtyleads_add_ecs_owp_wfl_btnsays_field_to_media_uploader_save', null, 2);

													/** * Display our new "Button text" field * * @param int $attachment_id * * @return array */

													function wantflirtyleads_get_featured_image_ecs_owp_wfl_btnsays($attachment_id = null){	

													$attachment_id = (empty( $attachment_id)) ? get_post_thumbnail_id() : (int)$attachment_id;	

													if($attachment_id) return get_post_meta($attachment_id, '_ecs_owp_wfl_btnsays', true);

													}

													

													

													

													/** * Adding a "referer" field to the media uploader $form_fields array * @param array $form_fields * @param object $post * * @return array */

													function wantflirtyleads_add_ecs_owp_wfl_referer_field_to_media_uploader($form_fields, $post){

													if((get_post_meta($post->ID, '_ecs_owp_wfl_referer', true)) == "") $ecs_owp_wfl_referer_value = get_bloginfo();      

													else $ecs_owp_wfl_referer_value = get_post_meta( $post->ID, '_ecs_owp_wfl_referer', true );	

													$form_fields['ecs_owp_wfl_referer_field'] = array(		'label' => __('Referer image (where the lead came from)'),		'value' => $ecs_owp_wfl_referer_value,		'helps' => 'Set a field to add referrer image to the image attachment'	);	

													return $form_fields;

													}

													add_filter('attachment_fields_to_edit', 'wantflirtyleads_add_ecs_owp_wfl_referer_field_to_media_uploader', null, 2);

													/** * Save our new "referer" field * * @param object $post * @param object $attachment * * @return array */

													function wantflirtyleads_add_ecs_owp_wfl_referer_field_to_media_uploader_save($post, $attachment){	

													if(!empty($attachment['ecs_owp_wfl_referer_field'])) update_post_meta($post['ID'], '_ecs_owp_wfl_referer', sanitize_text_field($attachment['ecs_owp_wfl_referer_field']));	

													else delete_post_meta($post['ID'], '_ecs_owp_wfl_referer');	

													return $post;

													}

													add_filter( 'attachment_fields_to_save', 'wantflirtyleads_add_ecs_owp_wfl_referer_field_to_media_uploader_save', null, 2);

													/** * Display our new "referer" field * * @param int $attachment_id * * @return array */

													function wantflirtyleads_get_featured_image_ecs_owp_wfl_referer($attachment_id = null){	

													$attachment_id = (empty($attachment_id)) ? get_post_thumbnail_id() : (int)$attachment_id;	

													if($attachment_id) return get_post_meta($attachment_id, '_ecs_owp_wfl_referer', true);

													}

													

													

													function wantflirtyleads_add_ecs_owp_wfl_lcemail_field_to_media_uploader($form_fields, $post){	

													if((get_post_meta($post->ID, '_ecs_owp_wfl_lcemail', true)) == "") $ecs_owp_wfl_lcemail_value = get_option( 'admin_email' );      

													else $ecs_owp_wfl_lcemail_value = get_post_meta( $post->ID, '_ecs_owp_wfl_lcemail', true );	

													$form_fields['ecs_owp_wfl_lcemail_field'] = array(		'label' => __('Email the lead is sent to '),		'value' => $ecs_owp_wfl_lcemail_value,		'helps' => 'Set where the lead is sent to'	);	

													return $form_fields;

													}

													add_filter('attachment_fields_to_edit', 'wantflirtyleads_add_ecs_owp_wfl_lcemail_field_to_media_uploader', null, 2);

													/** * Save our new "lead capture email sent to" field * * @param object $post * @param object $attachment * * @return array */

													function wantflirtyleads_add_ecs_owp_wfl_lcemail_field_to_media_uploader_save($post, $attachment) {	

													if(!empty($attachment['ecs_owp_wfl_lcemail_field'])) update_post_meta($post['ID'], '_ecs_owp_wfl_lcemail', sanitize_text_field($attachment['ecs_owp_wfl_lcemail_field']));	

													else delete_post_meta($post['ID'], '_ecs_owp_wfl_lcemail');	

													return $post;

													} 

													add_filter( 'attachment_fields_to_save', 'wantflirtyleads_add_ecs_owp_wfl_lcemail_field_to_media_uploader_save', null, 2);

													/** * Display our new "lead capture email sent to" field * * @param int $attachment_id * * @return array */

													function wantflirtyleads_get_featured_image_ecs_owp_wfl_lcemail($attachment_id = null){	

													$attachment_id = (empty( $attachment_id)) ? get_post_thumbnail_id() : (int)$attachment_id;	

													if($attachment_id) return get_post_meta($attachment_id, '_ecs_owp_wfl_lcemail ', true);

													}


													function wantflirtyleads_add_ecs_owp_wfl_subject_line_field_to_media_uploader($form_fields, $post){	

													if((get_post_meta($post->ID, '_ecs_owp_wfl_subject_line', true)) == "") $ecs_owp_wfl_subject_line_value = "More info from " . (get_bloginfo( $url, $filter ));      

													else $ecs_owp_wfl_subject_line_value = get_post_meta( $post->ID, '_ecs_owp_wfl_subject_line', true );	

													$form_fields['ecs_owp_wfl_subject_line_field'] = array(		'label' => __('Email subject line '),		'value' => $ecs_owp_wfl_subject_line_value,		'helps' => 'Set the email subject line'	);	

													return $form_fields;

													}

													add_filter('attachment_fields_to_edit', 'wantflirtyleads_add_ecs_owp_wfl_subject_line_field_to_media_uploader', null, 2);

													/** * Save our new "lead capture email sent to" field * * @param object $post * @param object $attachment * * @return array */

													function wantflirtyleads_add_ecs_owp_wfl_subject_line_field_to_media_uploader_save($post, $attachment) {	

													if(!empty($attachment['ecs_owp_wfl_subject_line_field'])) update_post_meta($post['ID'], '_ecs_owp_wfl_subject_line', sanitize_text_field($attachment['ecs_owp_wfl_subject_line_field']));	

													else delete_post_meta($post['ID'], '_ecs_owp_wfl_subject_line');	

													return $post;

													} 

													add_filter( 'attachment_fields_to_save', 'wantflirtyleads_add_ecs_owp_wfl_subject_line_field_to_media_uploader_save', null, 2);

													/** * Display our new "lead capture email sent to" field * * @param int $attachment_id * * @return array */

													function wantflirtyleads_get_featured_image_ecs_owp_wfl_subject_line($attachment_id = null){	

													$attachment_id = (empty( $attachment_id)) ? get_post_thumbnail_id() : (int)$attachment_id;	

													if($attachment_id) return get_post_meta($attachment_id, '_ecs_owp_wfl_subject_line ', true);

													}
													
													
													function wantflirtyleads_add_ecs_owp_wfl_message_field_to_media_uploader($form_fields, $post){	

													if((get_post_meta($post->ID, '_ecs_owp_wfl_message', true)) == "") $ecs_owp_wfl_message_value = "";      

													else $ecs_owp_wfl_message_value = get_post_meta( $post->ID, '_ecs_owp_wfl_message', true );	

													$form_fields['ecs_owp_wfl_message_field'] = array(		'label' => __('message in the email sent '),		'value' => $ecs_owp_wfl_message_value,		'helps' => 'Set email message sent'	);	

													return $form_fields;

													}

													add_filter('attachment_fields_to_edit', 'wantflirtyleads_add_ecs_owp_wfl_message_field_to_media_uploader', null, 2);

													/** * Save our new "lead capture email sent to" field * * @param object $post * @param object $attachment * * @return array */

													function wantflirtyleads_add_ecs_owp_wfl_message_field_to_media_uploader_save($post, $attachment) {	

													if(!empty($attachment['ecs_owp_wfl_message_field'])) update_post_meta($post['ID'], '_ecs_owp_wfl_message', wp_kses_post($attachment['ecs_owp_wfl_message_field']));	

													else delete_post_meta($post['ID'], '_ecs_owp_wfl_message');	

													return $post;

													} 

													add_filter( 'attachment_fields_to_save', 'wantflirtyleads_add_ecs_owp_wfl_message_field_to_media_uploader_save', null, 2);

													/** * Display our new "lead capture email sent to" field * * @param int $attachment_id * * @return array */

													function wantflirtyleads_get_featured_image_ecs_owp_wfl_message($attachment_id = null){	

													$attachment_id = (empty( $attachment_id)) ? get_post_thumbnail_id() : (int)$attachment_id;	

													if($attachment_id) return get_post_meta($attachment_id, '_ecs_owp_wfl_message ', true);

													}
													

													/** * Adding a "cta text color" field to the media uploader $form_fields array * @param array $form_fields * @param object $post * * @return array */

													function wantflirtyleads_add_ecs_owp_wfl_cta_color_field_to_media_uploader($form_fields, $post){	

													if((get_post_meta($post->ID, '_ecs_owp_wfl_cta_color', true)) == "") $ecs_owp_wfl_cta_color_value = '';      

													else $ecs_owp_wfl_cta_color_value = get_post_meta( $post->ID, '_ecs_owp_wfl_cta_color', true );	

													$form_fields['ecs_owp_wfl_cta_color_field'] = array(		'label' => __('optional: Call to Action text color, default your theme styling, takes hexidecimal like FFFFFF , no # needed  '),		'value' => $ecs_owp_wfl_cta_color_value,		'helps' => 'Set call to action font color'	);	

													return $form_fields;

													}

													add_filter('attachment_fields_to_edit', 'wantflirtyleads_add_ecs_owp_wfl_cta_color_field_to_media_uploader', null, 2);

													/** * Save our new "cta text color* * @param object $post * @param object $attachment * * @return array */

													function wantflirtyleads_add_ecs_owp_wfl_cta_color_field_to_media_uploader_save($post, $attachment) {	

													if(!empty($attachment['ecs_owp_wfl_cta_color_field'])) update_post_meta($post['ID'], '_ecs_owp_wfl_cta_color', sanitize_text_field($attachment['ecs_owp_wfl_cta_color_field']));	

													else delete_post_meta($post['ID'], '_ecs_owp_wfl_cta_color');	

													return $post;

													} 

													add_filter( 'attachment_fields_to_save', 'wantflirtyleads_add_ecs_owp_wfl_cta_color_field_to_media_uploader_save', null, 2);

													/** * Display our new "cta text color" field * * @param int $attachment_id * * @return array */

													function wantflirtyleads_get_featured_image_ecs_owp_wfl_cta_color($attachment_id = null){	

													$attachment_id = (empty( $attachment_id)) ? get_post_thumbnail_id() : (int)$attachment_id;	

													if($attachment_id) return get_post_meta($attachment_id, '_ecs_owp_wfl_cta_color ', true);

													}

													

													/** * Adding a "cta text size" field to the media uploader $form_fields array * @param array $form_fields * @param object $post * * @return array */

													function wantflirtyleads_add_ecs_owp_wfl_cta_size_field_to_media_uploader($form_fields, $post){	

													if((get_post_meta($post->ID, '_ecs_owp_wfl_cta_size', true)) == "") $ecs_owp_wfl_cta_size_value = '';      

													else $ecs_owp_wfl_cta_size_value = get_post_meta( $post->ID, '_ecs_owp_wfl_cta_size', true );	

													$form_fields['ecs_owp_wfl_cta_size_field'] = array(		'label' => __('optional: Call to Action font size, default your theme styling, takes number like 12 '),		'value' => $ecs_owp_wfl_cta_size_value,		'helps' => 'Set call to action font size'	);	

													return $form_fields;

													}

													add_filter('attachment_fields_to_edit', 'wantflirtyleads_add_ecs_owp_wfl_cta_size_field_to_media_uploader', null, 2);

													/** * Save our new "cta text size* * @param object $post * @param object $attachment * * @return array */

													function wantflirtyleads_add_ecs_owp_wfl_cta_size_field_to_media_uploader_save($post, $attachment) {	

													if(!empty($attachment['ecs_owp_wfl_cta_size_field'])) update_post_meta($post['ID'], '_ecs_owp_wfl_cta_size', sanitize_text_field($attachment['ecs_owp_wfl_cta_size_field']));	

													else delete_post_meta($post['ID'], '_ecs_owp_wfl_cta_size');	

													return $post;

													} 

													add_filter( 'attachment_fields_to_save', 'wantflirtyleads_add_ecs_owp_wfl_cta_size_field_to_media_uploader_save', null, 2);

													/** * Display our new "cta text size" field * * @param int $attachment_id * * @return array */

													function wantflirtyleads_get_featured_image_ecs_owp_wfl_cta_size($attachment_id = null){	

													$attachment_id = (empty( $attachment_id)) ? get_post_thumbnail_id() : (int)$attachment_id;	

													if($attachment_id) return get_post_meta($attachment_id, '_ecs_owp_wfl_cta_size ', true);

													}

													

													/** * Adding a "cta text weight" field to the media uploader $form_fields array * @param array $form_fields * @param object $post * * @return array */

													function wantflirtyleads_add_ecs_owp_wfl_cta_weight_field_to_media_uploader($form_fields, $post){	

													if((get_post_meta($post->ID, '_ecs_owp_wfl_cta_weight', true)) == "") $ecs_owp_wfl_cta_weight_value = '';      

													else $ecs_owp_wfl_cta_weight_value = get_post_meta( $post->ID, '_ecs_owp_wfl_cta_weight', true );	

													$form_fields['ecs_owp_wfl_cta_weight_field'] = array(		'label' => __('optional: Call to Action font weight, default your theme styling; options: light, normal, bold, or bolder '),		'value' => $ecs_owp_wfl_cta_weight_value,		'helps' => 'Set call to action to bolden text'	);	

													return $form_fields;

													}

													add_filter('attachment_fields_to_edit', 'wantflirtyleads_add_ecs_owp_wfl_cta_weight_field_to_media_uploader', null, 2);

													/** * Save our new "cta text weight* * @param object $post * @param object $attachment * * @return array */

													function wantflirtyleads_add_ecs_owp_wfl_cta_weight_field_to_media_uploader_save($post, $attachment) {	

													if(!empty($attachment['ecs_owp_wfl_cta_weight_field'])) update_post_meta($post['ID'], '_ecs_owp_wfl_cta_weight', sanitize_text_field($attachment['ecs_owp_wfl_cta_weight_field']));	

													else delete_post_meta($post['ID'], '_ecs_owp_wfl_cta_weight');	

													return $post;

													} 

													add_filter( 'attachment_fields_to_save', 'wantflirtyleads_add_ecs_owp_wfl_cta_weight_field_to_media_uploader_save', null, 2);

													/** * Display our new "cta text weight" field * * @param int $attachment_id * * @return array */

													function wantflirtyleads_get_featured_image_ecs_owp_wfl_cta_weight($attachment_id = null){	

													$attachment_id = (empty( $attachment_id)) ? get_post_thumbnail_id() : (int)$attachment_id;	

													if($attachment_id) return get_post_meta($attachment_id, '_ecs_owp_wfl_cta_weight ', true);

													}

													

													/** * Adding a "cta text height" field to the media uploader $form_fields array * @param array $form_fields * @param object $post * * @return array */

													function wantflirtyleads_add_ecs_owp_wfl_cta_height_field_to_media_uploader($form_fields, $post){	

													if((get_post_meta($post->ID, '_ecs_owp_wfl_cta_height', true)) == "") $ecs_owp_wfl_cta_height_value = '';      

													else $ecs_owp_wfl_cta_height_value = get_post_meta( $post->ID, '_ecs_owp_wfl_cta_height', true );	

													$form_fields['ecs_owp_wfl_cta_height_field'] = array(		'label' => __('optional: Call to Action bottom padding beneath lead capture form, default your theme styling, takes number like 70 '),		'value' => $ecs_owp_wfl_cta_height_value,		'helps' => 'Set call to action bottom padding, if needed'	);	

													return $form_fields;

													}

													add_filter('attachment_fields_to_edit', 'wantflirtyleads_add_ecs_owp_wfl_cta_height_field_to_media_uploader', null, 2);

													/** * Save our new "cta text height* * @param object $post * @param object $attachment * * @return array */

													function wantflirtyleads_add_ecs_owp_wfl_cta_height_field_to_media_uploader_save($post, $attachment) {	

													if(!empty($attachment['ecs_owp_wfl_cta_height_field'])) update_post_meta($post['ID'], '_ecs_owp_wfl_cta_height', sanitize_text_field($attachment['ecs_owp_wfl_cta_height_field']));	

													else delete_post_meta($post['ID'], '_ecs_owp_wfl_cta_height');	

													return $post;

													} 

													add_filter( 'attachment_fields_to_save', 'wantflirtyleads_add_ecs_owp_wfl_cta_height_field_to_media_uploader_save', null, 2);

													/** * Display our new "cta text height" field * * @param int $attachment_id * * @return array */

													function wantflirtyleads_get_featured_image_ecs_owp_wfl_cta_height($attachment_id = null){	

													$attachment_id = (empty( $attachment_id)) ? get_post_thumbnail_id() : (int)$attachment_id;	

													if($attachment_id) return get_post_meta($attachment_id, '_ecs_owp_wfl_cta_height ', true);

													}

													

													function wantflirtyleads_add_ecs_owp_wfl_btn_color_field_to_media_uploader($form_fields, $post){	

													if((get_post_meta($post->ID, '_ecs_owp_wfl_btn_color', true)) == "") $ecs_owp_wfl_btn_color_value ='';      

													else $ecs_owp_wfl_btn_color_value = get_post_meta( $post->ID, '_ecs_owp_wfl_btn_color', true );	

													$form_fields['ecs_owp_wfl_btn_color_field'] = array(		'label' => __('optional: Button color, takes hexidecimal like FFFFFF , no # needed  '),		'value' => $ecs_owp_wfl_btn_color_value,		'helps' => 'Set color of the button'	);	

													return $form_fields;

													}

													add_filter('attachment_fields_to_edit', 'wantflirtyleads_add_ecs_owp_wfl_btn_color_field_to_media_uploader', null, 2);

													/** * Save our new "Button color" field * * @param object $post * @param object $attachment * * @return array */

													function wantflirtyleads_add_ecs_owp_wfl_btn_color_field_to_media_uploader_save($post, $attachment) {	

													if(!empty($attachment['ecs_owp_wfl_btn_color_field'])) update_post_meta($post['ID'], '_ecs_owp_wfl_btn_color', sanitize_text_field($attachment['ecs_owp_wfl_btn_color_field']));	

													else delete_post_meta($post['ID'], '_ecs_owp_wfl_btn_color');	

													return $post;

													} 

													add_filter( 'attachment_fields_to_save', 'wantflirtyleads_add_ecs_owp_wfl_btn_color_field_to_media_uploader_save', null, 2);

													/** * Display our new "Button color" field * * @param int $attachment_id * * @return array */

													function wantflirtyleads_get_featured_image_ecs_owp_wfl_btn_color($attachment_id = null){	

													$attachment_id = (empty( $attachment_id)) ? get_post_thumbnail_id() : (int)$attachment_id;	

													if($attachment_id) return get_post_meta($attachment_id, '_ecs_owp_wfl_btn_color', true);

													}

													

													function wantflirtyleads_add_ecs_owp_wfl_btn_text_color_field_to_media_uploader($form_fields, $post){	

													if((get_post_meta($post->ID, '_ecs_owp_wfl_btn_text_color', true)) == "") $ecs_owp_wfl_btn_text_color_value ='';      

													else $ecs_owp_wfl_btn_text_color_value = get_post_meta( $post->ID, '_ecs_owp_wfl_btn_text_color', true );	

													$form_fields['ecs_owp_wfl_btn_text_color_field'] = array(		'label' => __('optional: Button text color, takes hexidecimal like FFFFFF , no # needed  '),		'value' => $ecs_owp_wfl_btn_text_color_value,		'helps' => 'Set color of the button text'	);	

													return $form_fields;

													}

													add_filter('attachment_fields_to_edit', 'wantflirtyleads_add_ecs_owp_wfl_btn_text_color_field_to_media_uploader', null, 2);

													/** * Save our new "Button text color" field * * @param object $post * @param object $attachment * * @return array */

													function wantflirtyleads_add_ecs_owp_wfl_btn_text_color_field_to_media_uploader_save($post, $attachment) {	

													if(!empty($attachment['ecs_owp_wfl_btn_text_color_field'])) update_post_meta($post['ID'], '_ecs_owp_wfl_btn_text_color', sanitize_text_field($attachment['ecs_owp_wfl_btn_text_color_field']));	

													else delete_post_meta($post['ID'], '_ecs_owp_wfl_btn_text_color');	

													return $post;

													} 

													add_filter( 'attachment_fields_to_save', 'wantflirtyleads_add_ecs_owp_wfl_btn_text_color_field_to_media_uploader_save', null, 2);

													/** * Display our new "Button text color" field * * @param int $attachment_id * * @return array */

													function wantflirtyleads_get_featured_image_ecs_owp_wfl_btn_text_color($attachment_id = null){	
													$attachment_id = (empty( $attachment_id)) ? get_post_thumbnail_id() : (int)$attachment_id;	
													if($attachment_id) return get_post_meta($attachment_id, '_ecs_owp_wfl_btn_text_color', true);

													}

													

															

													

													function ecs_wfl_generate_show_excerpt( $output ) {

														// if ( has_excerpt() && ! is_attachment() ) {

													$output = str_replace("Find out more!Thank you!", " ", $output); 

													$output = str_replace("********", " ", $output); 

														// }

													return $output;

														}

													add_filter( 'get_the_excerpt', 'ecs_wfl_generate_show_excerpt' );

												

													

		  // Ajax Handler
add_action( 'wp_ajax_wantflirtyleads', 'wantflirtyleads' );
add_action( 'wp_ajax_nopriv_wantflirtyleads', 'wantflirtyleads' );
function wantflirtyleads() {
 // Get the Image ID, & stuff from the URL
$referer =  sanitize_text_field($_POST['referer']); 
$referer = isset($referer) ? $referer : '';

$email =  sanitize_text_field($_POST['email']); 

$email = isset($email) ? $email : '';

$lcemail =  sanitize_text_field($_POST['lcemail']); 

$lcemail = isset($lcemail) ? $lcemail : '';

$image_id = sanitize_text_field($_REQUEST['image_id']); 

$image_id = intval($image_id);

$subject_line = get_post_meta( $image_id, '_ecs_owp_wfl_subject_line', true );

if ($subject_line == "") $subject_line = "Another Lead from wantflirty Leads"; 

$message = get_post_meta( $image_id, '_ecs_owp_wfl_message', true );

if ($message == "") $message = "Well this is embarrasing.  No immediate results.  Try ...";




$nonce = sanitize_text_field($_REQUEST['nonce']);



		 // Instantiate WP_Ajax_Response

    $response = new WP_Ajax_Response;

	$gin = wp_verify_nonce( $nonce, 'wantflirty_gin-lead-' . $image_id );

    // Proceed, again we are checking for permissions

    if( 
           // Verify Nonces

        wp_verify_nonce( $nonce, 'wantflirty_gin-lead-' . $image_id ) 

      ){

		  $to = $email; 

			$subject = $subject_line; 

			$email = $email; 

			$message = $message . 
			" " //message this line out if activate code snippet (of approx 20 lines) directly below
			//add hook for future devs
			//edit/add below for info that stays the same for the email to be sent.
			//"<html>
//<head>
 // <title>Birthday Reminders for August</title>
//</head>
//<body>
 // <p>Here are the birthdays upcoming in August!</p>
 // <table>
  //  <tr>
   //   <th>Person</th><th>Day</th><th>Month</th><th>Year</th>
   // </tr>
   // <tr>
   //   <td>Johny</td><td>10th</td><td>August</td><td>1970</td>
   // </tr>
   // <tr>
   //   <td>Sally</td><td>17th</td><td>August</td><td>1973</td>
  //  </tr>
 // </table>
//</body>
//</html>

		//	Here's another lead from flirtyleads.com...

		//	Email: " .$email. "

		//	Referrer: " .$referer 
		; 

			

			$headers = array('From: ' . $email, 'Bcc: ' . $lcemail, 'Content-Type: text/html; charset=UTF-8', 'MIME-Version: 1.0');			

			$attachments = "";

			wp_mail( $to, $subject, $message, implode("\r\n", $headers) );

       

       

		  	// Build the response if successful

        $response->add( array(
            'data'  => 'success',
            'supplemental' => array(
                'image_id' => $image_id,
                'message' => 'Success verifying nonce for this image ('. $image_id . ')',
            ),
        ) );

    } else {

        // Build the response if an error occurred

        $response->add( array(
            'data'  => 'error',
            'supplemental' => array(
                'image_id' => $image_id,
                'message' => 'Error sending email for this image ('. $image_id .')',
            ),
        ) );

    }

    // Whatever the outcome, send the Response back

    $response->send();

 

    // Always exit when doing Ajax

    exit();

}