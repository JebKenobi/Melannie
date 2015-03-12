<?php

global $post;
if (!empty($post) && isset($post->ID)) {
	$custom_head_img = get_post_meta($post->ID, 'crum_headers_bg_img', true);
	$custom_head_color = get_post_meta($post->ID, 'crum_headers_bg_color', true);
	$custom_head_subtitle = get_post_meta($post->ID, 'crum_headers_subtitle', true);
} else {
	$custom_head_img = '';
	$custom_head_color = '';
	$custom_head_subtitle = '';
}


if (DfdThemeSettings::get('stan_header')) {
	echo '<div id="stuning-header">';
}
