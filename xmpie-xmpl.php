<?php
/*
Plugin Name: XMPie XMPL
Plugin URI: http://xmpie.com/
Description: XMPie XMPL for WordPress
Version: 1.0 (1.0.8)
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
  wp_register_script('jqueryxmp', 'https://ajax.xmcircle.com/ajax/libs/xmpl/1.0.8/jquery/jquery-1.10.2.min.js');
  wp_enqueue_script('jqueryxmp');
  wp_localize_script('xmpcfg', 'setting', $config_array);

  wp_register_script('xmpjs', 'https://ajax.xmcircle.com/ajax/libs/xmpl/1.0.8/xmp/js/xmp.min.js');
  wp_enqueue_script('xmpjs');
  
  

    
  wp_register_script('ucreate_xm_designjs', 'https://ajax.xmcircle.com/ajax/libs/xmpl/1.0.8/xmp/js/ucreateXMDesign.js');
  wp_enqueue_script('ucreate_xm_designjs');

}


add_action('wp_enqueue_scripts', 'xmpie_xm_styles');
function xmpie_xm_styles() {

  wp_register_style('xmpie_styles', 'https://ajax.xmcircle.com/ajax/libs/xmpl/1.0.8/xmp/css/xmp.css');
  wp_enqueue_style('xmpie_styles');
  wp_register_style('xmpie_ucreateXMDesign', 'https://ajax.xmcircle.com/ajax/libs/xmpl/1.0.8/xmp/css/ucreateXMDesign.css');
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

add_filter('tiny_mce_before_init', 'xmp_filter_tiny_mce_before_init');
function xmp_filter_tiny_mce_before_init( $options ) {
 
    if ( ! isset( $options['extended_valid_elements'] ) ) {
        $options['extended_valid_elements'] = '';
    } else {
        $options['extended_valid_elements'] .= ',';
    }
 
    if ( ! isset( $options['custom_elements'] ) ) {
        $options['custom_elements'] = '';
    } else {
        $options['custom_elements'] .= ',';
    }
 
    $options['extended_valid_elements'] .= 'div[ng-*|xmp-*]';
    $options['custom_elements']         .= 'div[ng-*|xmp-*]';
    $options['extended_valid_elements'] .= ',h1[ng-*|xmp-*]';
    $options['custom_elements']         .= ',h1[ng-*|xmp-*]';
    $options['extended_valid_elements'] .= ',h2[ng-*|xmp-*]';
    $options['custom_elements']         .= ',h2[ng-*|xmp-*]';
    $options['extended_valid_elements'] .= ',h3[ng-*|xmp-*]';
    $options['custom_elements']         .= ',h3[ng-*|xmp-*]';
    $options['extended_valid_elements'] .= ',h4[ng-*|xmp-*]';
    $options['custom_elements']         .= ',h4[ng-*|xmp-*]';
    $options['extended_valid_elements'] .= ',h5[ng-*|xmp-*]';
    $options['custom_elements']         .= ',h5[ng-*|xmp-*]';
    $options['extended_valid_elements'] .= ',h6[ng-*|xmp-*]';
    $options['custom_elements']         .= ',h6[ng-*|xmp-*]';
    $options['extended_valid_elements'] .= ',a[ng-*|xmp-*]';
    $options['custom_elements']         .= ',a[ng-*|xmp-*]';
    $options['extended_valid_elements'] .= ',img[ng-*|xmp-*]';
    $options['custom_elements']         .= ',img[ng-*|xmp-*]';
    $options['extended_valid_elements'] .= ',input[ng-*|xmp-*]';
    $options['custom_elements']         .= ',input[ng-*|xmp-*]';
    $options['extended_valid_elements'] .= ',form[ng-*|xmp-*]';
    $options['custom_elements']         .= ',form[ng-*|xmp-*]';
    $options['extended_valid_elements'] .= ',span[ng-*|xmp-*]';
    $options['custom_elements']         .= ',span[ng-*|xmp-*]';
    $options['extended_valid_elements'] .= ',li[ng-*|xmp-*]';
    $options['custom_elements']         .= ',li[ng-*|xmp-*]';
    $options['extended_valid_elements'] .= ',select[ng-*|xmp-*]';
    $options['custom_elements']         .= ',select[ng-*|xmp-*]';
    $options['extended_valid_elements'] .= ',button[ng-*|xmp-*]';
    $options['custom_elements']         .= ',button[ng-*|xmp-*]';
    $options['extended_valid_elements'] .= ',table[ng-*|xmp-*]';
    $options['custom_elements']         .= ',table[ng-*|xmp-*]';
    $options['extended_valid_elements'] .= ',tr[ng-*|xmp-*]';
    $options['custom_elements']         .= ',tr[ng-*|xmp-*]';
    $options['extended_valid_elements'] .= ',td[ng-*|xmp-*]';
    $options['custom_elements']         .= ',td[ng-*|xmp-*]';
    return $options;
}


add_action('admin_menu', 'xmpie_plugin_settings');

function xmpie_plugin_settings() {
    //creecho ate new top-level menu
    add_menu_page('XMPie Settings', 'XMPie Settings', 'administrator', 'xmpie_settings', 'xmpie_display_settings');
}

function xmpie_display_settings() {

    $access_token = (get_option('xmpie_access_token') != '') ? get_option('xmpie_access_token') : '';
    $xmpurl = (get_option('xmpie_url') != '') ? get_option('xmpie_url') : '';
    $circle_project_id = (get_option('xmpie_circle_project_id') != '') ? get_option('xmpie_circle_project_id') : '';
    $circle_project_name = (get_option('xmpie_circle_project_name') != '') ? get_option('xmpie_circle_project_name') : '';

    $html = '<div class="wrap">

            <form method="post" name="options" action="options.php">

            <h2>Select Your Settings</h2>' . wp_nonce_field('update-options') . '
            <table width="100%" cellpadding="10" class="form-table">
                <tr>
                    <td align="left" scope="row">
                    <label>XMPie Access Token</label><input type="text" name="xmpie_access_token" 
                    value="' . $access_token . '" />
                    </td> 
                </tr>
                <tr>
                     <td align="left" scope="row">
                    <label>XMPie Url</label><input type="text" name="xmpie_url" 
                    value="' . $xmpurl . '" />
                    </td> 
                </tr>
                <tr>
                    <td align="left" scope="row">
                    <label>Circle Project ID</label><input type="text" name="xmpie_circle_project_id" 
                    value="' . $circle_project_id . '" />
                    </td> 
                </tr>
                <tr>
                    <td align="left" scope="row">
                    <label>Circle Project Name: </label><input type="text" name="xmpie_circle_project_name" 
                    value="' . $circle_project_name . '" />
                    </td> 
                </tr>
            </table>
            <p class="submit">
                <input type="hidden" name="action" value="update" />  
                <input type="hidden" name="page_options" value="xmpie_access_token,xmpie_url,xmpie_circle_project_id,xmpie_circle_project_name" /> 
                <input type="submit" name="Submit" value="Update" />
            </p>
            </form>

        </div>';
    echo $html;
}
?>
