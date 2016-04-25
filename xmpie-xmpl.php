<?php
/*
Plugin Name: XMPie XMPL
Plugin URI: http://xmpie.com/
Description: XMPie XMPL for WordPress
Version: 1.1 (1.0.9)
Author: Galit Zwickel
Author URI: http://www.xmpie.com/
License: MIT
*/
function xmpie_xm_activation() {
}
register_activation_hook(__FILE__, 'xmpie_xm_activation');

function xmpie_xm_deactivation() {
}
register_deactivation_hook(__FILE__, 'xmpie_xm_deactivation');

add_action('wp_enqueue_scripts', 'xmpie_xm_scripts');
function xmpie_xm_scripts() {
	wp_register_script('xmpcfg', plugins_url('xmpcfg.js', __FILE__));
	wp_enqueue_script('xmpcfg');

	$access_token = (get_option('xmpie_access_token') != '') ? get_option('xmpie_access_token') : '';
	$xmpurl = (get_option('xmpie_url') != '') ? get_option('xmpie_url') : '';
	$circle_project_id = (get_option('xmpie_circle_project_id') != '') ? get_option('xmpie_circle_project_id') : '';
	$circle_project_name = (get_option('xmpie_circle_project_name') != '') ? get_option('xmpie_circle_project_name') : '';

	$config_array = array(
		'access_token' => $access_token,
		'xmpurl' => $xmpurl,
		'circle_project_id' => $circle_project_id,
		'circle_project_name' => $circle_project_name
	);
	
	wp_register_script('jqueryxmp', 'https://ajax.xmcircle.com/ajax/libs/xmpl/1.0.9/jquery/jquery-1.10.2.min.js');
	wp_enqueue_script('jqueryxmp');
	wp_localize_script('xmpcfg', 'setting', $config_array);

	wp_register_script('xmpjs', 'https://ajax.xmcircle.com/ajax/libs/xmpl/1.0.9/xmp/js/xmp.min.js');
	wp_enqueue_script('xmpjs');

	wp_register_script('ucreate_xm_designjs', 'https://ajax.xmcircle.com/ajax/libs/xmpl/1.0.9/xmp/js/ucreateXMDesign.js');
	wp_enqueue_script('ucreate_xm_designjs');
}

add_action('wp_enqueue_scripts', 'xmpie_xm_styles');
function xmpie_xm_styles() {
  wp_register_style('xmpie_styles', 'https://ajax.xmcircle.com/ajax/libs/xmpl/1.0.9/xmp/css/xmp.css');
  wp_enqueue_style('xmpie_styles');
  wp_register_style('xmpie_ucreateXMDesign', 'https://ajax.xmcircle.com/ajax/libs/xmpl/1.0.9/xmp/css/ucreateXMDesign.css');
  wp_enqueue_style('xmpie_ucreateXMDesign');  
}

add_shortcode("xmpie_xm", "xmpie_xm_display_logo");
function xmpie_xm_display_logo() {
  $plugins_url = plugins_url();
  echo '<img src="'.plugins_url( 'img/XMPIE_Logo.png' , __FILE__ ).'" />';
}

/* Save XMPie Options to database */
add_action('save_post', 'xmpie_save_info');
function xmpie_save_info($post_id) {
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
}
remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );
remove_filter('the_content', 'wptexturize');

/* stop tinyMCE messing html code */
add_filter('tiny_mce_before_init', 'xmp_filter_tiny_mce_before_init');
function xmp_filter_tiny_mce_before_init($initArray) {
    $opts = '*[*]';
    $initArray['valid_elements'] = $opts;
    $initArray['extended_valid_elements'] = $opts;
    return $initArray;
}
?>
