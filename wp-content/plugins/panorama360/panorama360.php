<?php
/*
Plugin Name: 360&deg; Panoramic Viewer
Plugin URI: http://codecanyon.net/user/liviu_cerchez/
Version: 1.1.1
Description: Embed 360&deg; panoramic images to your website and view them on any device.
Author: Liviu Cerchez
Author URI: http://codecanyon.net/user/liviu_cerchez/
Text Domain: panorama360
*/

if ( ! defined('PANORAMA360_PLUGIN_URL') ) define( 'PANORAMA360_PLUGIN_URL', trailingslashit( plugins_url( '', __FILE__ ) ) );

/* extract boolean attribute values from shortcodes */
function panorama360_string_to_bool( $value ) {
	return filter_var( $value, FILTER_VALIDATE_BOOLEAN );
}

/* process shortcode atrributes and output panorama */
function panorama360_shortcode( $atts, $content = null ) {

	$args = shortcode_atts( array(
		'src' => '',
		'src_width' => '',
		'src_height' => '',
		'src_alt' => '',
		'id' => '',
		'title' => '',
		'title_link' => '',
		'title_target' => '',
		'style' => '',
		'mousewheel' => false,
		'mousewheel_multiplier' => 10,
		'bind_resize' => true,
		'is360' => true,
		'start_position' => '',
		'sliding_controls' => true,
		'sliding_direction' => 0,
		'sliding_interval' => 8,
		'map' => '',
		'block_contextmenu' => false,
	), $atts, 'panorama360' );

	// use general notice variable for any warnings/errors
	$notice = '';

	// check if source image is defined
	if ( $args['src'] ) {
		// obtain upload dir
		$upload_info = wp_upload_dir();
		$upload_dir = $upload_info['basedir'];
		$upload_url = $upload_info['baseurl'];
		$http_prefix = "http://";
		$https_prefix = "https://";
		/* if the $src scheme differs from $upload_url scheme, make them match; if the schemes differ, images don't show up. */
		if( !strncmp($args['src'], $https_prefix,strlen($https_prefix)) ) {
			// if src begins with https:// make $upload_url begin with https:// as well
			$upload_url = str_replace($http_prefix,$https_prefix,$upload_url);
		} elseif( !strncmp($args['src'],$http_prefix,strlen($http_prefix)) ){
			// if src begins with http:// make $upload_url begin with http:// as well
			$upload_url = str_replace($https_prefix,$http_prefix,$upload_url);
		}
		// check if defined image is local
		$is_remote_image = (strpos( $args['src'], $upload_url ) === false);
		if ( $is_remote_image && ( ! is_numeric($args['src_width']) || ! is_numeric($args['src_height']) ) ) {
			$notice = __('Please define valid width and height attributes for remote images. This will also optimize the loading time of the remote panorama.', 'panorama360');
		} else {
			$rel_path = str_replace( $upload_url, '', $args['src']);
			$img_path = $upload_dir . $rel_path;
			if ( file_exists($img_path) && (! is_numeric($args['src_width']) || ! is_numeric($args['src_height'])) ) {
				list( $orig_w, $orig_h ) = getimagesize($args['src']);
				$args['src_width'] = $orig_w;
				$args['src_height'] = $orig_h;
			}
			if ( $args['map'] ) {
				$usemap = ' usemap="#' . esc_attr($args['map']) . '"';
			} else {
				$usemap = '';
			}

			$img = '<img src="' . esc_url($args['src']) . '" data-width="' . esc_attr($args['src_width']) . '" data-height="' . esc_attr($args['src_height']) . '"'. $usemap .' alt="' . esc_attr($args['src_alt']) . '" />';
		}
	} else {
		$notice = __('Please define a valid source image (<em>src</em> attribute).', 'panorama360');
	}

	if ($notice) {
		return '<strong>' . $notice . '</strong>';
	} else {

		// check if title attribute exists and add link+target attributes as well
		if ( $args['title'] ) {
			if( $args['title_link'] ) {
				$title_link = ' href="' . esc_url( $args['title_link'] ) . '"';
			} else {
				$title_link = '';
			}
			if( $args['title_target'] ) {
				$title_target = ' target="' . esc_attr( $args['title_target'] ) . '"';
			} else {
				$title_target = '';
			}
			$title =  '<a class="title"' . $title_link . $title_target . '>' . esc_attr($args['title']) . '</a>';
		} else {
			$title = '';
		}

		if ( $args['id'] ) {
			$id = ' id="' . esc_attr( $args['id'] ) . '"';
		} else {
			$id = '';
		}
		if ( $args['style'] ) {
			$style = ' style="' . esc_attr( $args['style'] ) . '"';
		} else {
			$style = '';
		}
		$data_atrribs = '';
		if ($args['start_position']) {
			$data_atrribs .= ' data-start-position="' . esc_attr( $args['start_position'] ) . '"';
		}
		if ( ! panorama360_string_to_bool($args['mousewheel']) ) {
			$data_atrribs .= ' data-mousewheel="false"';
		}
		if ($args['mousewheel_multiplier'] && $args['mousewheel_multiplier'] != 10) {
			$data_atrribs .= ' data-mousewheel-multiplier="' . esc_attr( $args['mousewheel_multiplier'] ) . '"';
		}
		if ( ! panorama360_string_to_bool($args['bind_resize'])) {
			$data_atrribs .= ' data-bind-resize="false"';
		}
		if ( ! panorama360_string_to_bool($args['is360'])) {
			$data_atrribs .= ' data-is360="false"';
		}
		if ( ! panorama360_string_to_bool($args['sliding_controls'])) {
			$data_atrribs .= ' data-sliding-controls="false"';
		}
		if ($args['sliding_direction']) {
			$data_atrribs .= ' data-sliding-direction="' . esc_attr( $args['sliding_direction'] ) . '"';
		}
		if ($args['sliding_interval'] && $args['sliding_interval'] != 8) {
			$data_atrribs .= ' data-sliding-interval="' . esc_attr( $args['sliding_interval'] ) . '"';
		}
		if ( panorama360_string_to_bool($args['block_contextmenu'])) {
			$data_atrribs .= ' data-block-contextmenu="true"';
		}

		wp_enqueue_style('panorama360', PANORAMA360_PLUGIN_URL . 'css/panorama360.css');
		if ( panorama360_string_to_bool($args['mousewheel']) ) {
			wp_enqueue_script('panorama360-mousewheel', PANORAMA360_PLUGIN_URL . 'js/jquery.mousewheel.js', array('jquery'));
		}
		wp_enqueue_script('panorama360', PANORAMA360_PLUGIN_URL . 'js/jquery.panorama360.js', array('jquery'));

		return '<div class="panorama360"' . $id . $style . '><div class="panorama-view"' . $data_atrribs . '><div class="panorama-container">' . $img . do_shortcode($content) . '</div></div>' . $title . '</div>';
	}
}
add_shortcode('panorama360', 'panorama360_shortcode');

function panorama360_admin_enqueue_scripts($hook){
	if ('post.php' != $hook && 'post-new.php' != $hook) return;

	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) return;

	if ( get_user_option('rich_editing') == 'true' ) {
		wp_enqueue_style('panorama360-shortcodes-style', PANORAMA360_PLUGIN_URL . 'css/panorama360-popup-style.css');
		wp_enqueue_script('media-upload');
	}
}
add_action('admin_enqueue_scripts', 'panorama360_admin_enqueue_scripts');

function panorama360_add_tinymce_button() {
	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) return;

	if ( get_user_option('rich_editing') == 'true' ) {
		add_filter('mce_external_plugins', 'panorama360_add_plugin');
		add_filter('mce_external_languages', 'panorama360_mce_localisation');
		add_filter('mce_buttons', 'panorama360_register_button');
	}
}
add_action('init', 'panorama360_add_tinymce_button');

function panorama360_add_plugin( $plugin_array ) {
	$plugin_array['panorama360'] = PANORAMA360_PLUGIN_URL . 'tinymce/tinymce.panorama360.js';
	return $plugin_array;
}

function panorama360_mce_localisation( $mce_external_languages ) {
	$mce_external_languages['panorama360'] = plugin_dir_path( __FILE__ ) . 'tinymce/localisation.php';
	return $mce_external_languages;
}

function panorama360_register_button( $buttons ) {
	array_push($buttons, '|', 'panorama360');
	return $buttons;
}

add_action('plugins_loaded', 'panorama360_load_textdomain');
function panorama360_load_textdomain() {
	load_plugin_textdomain('panorama360', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 
}
