 <?php 
 if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) 			exit();
 //register_deactivation_hook($file, $function); 
 //register_deactivation_hook(plugin_dir_url(__FILE__), $function);  
 
 // Uninstall code goes here
 delete_post_meta_by_key( '_ecs_owp_wfl_referer' ); 
 delete_post_meta_by_key( '_ecs_owp_wfl_btnsays' ); 
 delete_post_meta_by_key( '_ecs_owp_wfl_btn_color' ); 
 delete_post_meta_by_key( '_ecs_owp_wfl_btn_text_color' ); 
 delete_post_meta_by_key( '_ecs_owp_wfl_lead_capture_header' ); 
 delete_post_meta_by_key( '_ecs_owp_wfl_lcemail' ); 
 delete_post_meta_by_key( '_ecs_owp_wfl_show_lc' ); 
 delete_post_meta_by_key( '_ecs_owp_wfl_cta_color' ); 
 delete_post_meta_by_key( '_ecs_owp_wfl_cta_size' ); 
 delete_post_meta_by_key( '_ecs_owp_wfl_cta_weight' ); 
 delete_post_meta_by_key( '_ecs_owp_wfl_cta_height' ); 

 ?> 