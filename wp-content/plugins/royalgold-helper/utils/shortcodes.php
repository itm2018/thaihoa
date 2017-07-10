<?php

// Allow shortcodes in widgets
add_filter('widget_text', 'do_shortcode');

/* remove empty p tags only for our custom shortcodes */
add_filter("the_content", "royalgold_shortcodes_content_filter");
function royalgold_shortcodes_content_filter( $content ) {
	// apply to our own shortcodes that require the fix 
	$block = "the-year|highlight|tooltip|alert|collapse|collapse-item|thumb|social-link|responsive-video|responsive-container|button|sep|clear|search-form";
	// opening tag
	$rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/", "[$2$3]", $content);
	// closing tag
	$rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/", "[/$2]", $rep);
	return $rep;
}

// Current Year
function royalgold_the_year_shortcode( $atts ) {
	return date('Y');
}
add_shortcode('the-year', 'royalgold_the_year_shortcode');

// Blog Title
function royalgold_blog_title_shortcode($atts, $content = null) {
	return get_bloginfo('name');
}
add_shortcode('blog-title', 'royalgold_blog_title_shortcode');

// Blog/site link
function royalgold_site_link_shortcode() {
	return '<a href="' . home_url() . '" title="' . esc_attr( get_bloginfo( 'name' ) ) . '" rel="home">' . get_bloginfo( 'name' ) . '</a>';
}
add_shortcode('site-link', 'royalgold_site_link_shortcode');
add_shortcode('blog-link', 'royalgold_site_link_shortcode');

// Email encode
function royalgold_email_encode_function( $atts, $content ){
	extract(shortcode_atts(array('address' => ''),$atts));
	return '<a href="' . antispambot("mailto:".$address) . '">' . $content . '</a>';
}
add_shortcode( 'email', 'royalgold_email_encode_function' );

// Highlight
function royalgold_highlight_shortcode($atts, $content = null) {
	return '<span class="highlight">'.$content.'</span>';
}
add_shortcode('highlight', 'royalgold_highlight_shortcode');

// Tooltip
function royalgold_tooltip_shortcode($atts, $content = null) {
	extract(shortcode_atts(array('text' => ''),$atts));
	$text = ($text) ? ' title="' . esc_attr($text) . '"' : '';
	return '<span class="tooltip"' . $text . '>' . $content . '</span>';
}
add_shortcode('tooltip', 'royalgold_tooltip_shortcode');

// Alert
function royalgold_alert_shortcode($atts, $content = null) {
	extract(shortcode_atts(array('type' => ''),$atts));
	return '<div class="alert ' . esc_attr($type) . '">'.$content.'</div>';
}
add_shortcode('alert', 'royalgold_alert_shortcode');

// Collapse
function royalgold_collapse_shortcode($atts, $content = null) {
	extract(shortcode_atts(array('type' => ''),$atts));
	return '<ul class="collapse ' . esc_attr($type) . '">' . do_shortcode($content) . '</ul>';
}
add_shortcode('collapse', 'royalgold_collapse_shortcode');

// Collapse Item
function royalgold_collapse_item_shortcode($atts, $content = null) {
	extract(shortcode_atts(array(
		'opened' => '',
		'title' => 'Collapse title'
	),$atts));
	$active = ($opened) ? ' class="active"' : '';
	return '<li' . $active .'><h5 class="collapse-title">' . esc_attr($title) . '</h5><div class="collapse-content">' . do_shortcode($content) . '</div></li>';
}
add_shortcode('collapse-item', 'royalgold_collapse_item_shortcode');

// Thumbnail image
function royalgold_thumb_shortcode( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'link' => '#',
		'title' => '',
		'rel' => '',
		'class' => '',
		'overlay' => true,
		'overlay_icon' => 'icon-fullsize'
	),$atts));
	if ($class) $class = ' ' . esc_attr( $class );
	if ($title) $title = ' title="' . esc_attr( $title ) . '"';
	if ($rel) $rel = ' rel="' . esc_attr( $rel ) . '"';
	if ($overlay) {
		$mask_overlay = '<span class="overlay"></span>';
		$mask_icon = '<span class="' . esc_attr( $overlay_icon ) . '"></span>';
	} else {
		$mask_overlay = $mask_icon = '';
	}
	return '<a href="' . esc_url($link) . '" class="thumb' . $class . '"'. $title . $rel .'>' . $mask_overlay . $content . $mask_icon . '</a>';
}
add_shortcode('thumb', 'royalgold_thumb_shortcode');

// Social Link
function royalgold_social_link_shortcode($atts) {
	extract(shortcode_atts(array(
		'type' => 'icon-twitter',
		'url' => '',
		'title' => '',
		'target' => 'blank',
	), $atts));

	switch ($target) {
		case "_blank":
		case "blank":
			$target = ' target="_blank" ';
			break;
		default:
			$target = '';
			break;
	}

	// Properly escape our data
	if ($url)
		$url = ' href="' . esc_url( $url ) . '"';
	else {
		$url = ' href="#"';
	}
	// Properly escape our data
	if ($title) {
		$title = ' title="' . esc_attr($title) . '"';
		$tooltip_class = ' tooltip';
	} else {
		$tooltip_class = '';
	}

	return '<a class="icon-social ' . esc_attr($type) . $tooltip_class . '"' . $url . $title . $target . '></a>';
}
add_shortcode('social-link', 'royalgold_social_link_shortcode');

// Responsive Video
function royalgold_responsive_video_shortcode($atts, $content = null) {
	return '<div class="video-container"><div class="video-wrapper">' . do_shortcode($content) . '</div></div>';
}
add_shortcode("responsive-video", "royalgold_responsive_video_shortcode");
add_shortcode("responsive-container", "royalgold_responsive_video_shortcode");

// Button
function royalgold_button_shortcode($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => '',
		"size" => '',
		"color" => '',
		'target' => '',
		'rel' => '',
		'id' => ''
	), $atts));

	switch ($target) {
		case "_blank":
		case "blank":
			$target = ' target="_blank" ';
			break;
		default:
			$target = '';
			break;
	}

	// Properly escape our data
	if ($rel)
		$rel = ' rel="' . esc_attr( $rel ) . '"';
	if ($size)
		$size = ' ' . esc_attr( $size );
	if ($color)
		$color = ' ' . esc_attr( $color );
	if ($id)
		$id = ' id="' . esc_attr( $id ) . '"';

	return '<a' . $id . ' class="button' . $size . $color . '" href="'.$url.'"'. $rel . $target .'>'.$content.'</a>';
}
add_shortcode('button', 'royalgold_button_shortcode');

// Separator
function royalgold_sep_shortcode($atts) {
	return '<div class="sep"><span></span></div>';
}
add_shortcode('sep', 'royalgold_sep_shortcode');

// Clear Float
function royalgold_clear_shortcode($atts) {
	return '<div class="clear"></div>';
}
add_shortcode('clear', 'royalgold_clear_shortcode');

// Search Form
function royalgold_search_form_shortcode( ) {
	get_search_form( );
}
add_shortcode('search-form', 'royalgold_search_form_shortcode');
