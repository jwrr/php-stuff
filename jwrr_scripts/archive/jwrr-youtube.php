<?php
/*
 Name: JWRR YouTube
 URI: http://jwrr.com/wp/plugins/jwrr_youtube
 Description: a plugin to include a full-size youtube link.
 Version: 0.1
 Author: jwrr
 Author URI: http://jwrr.com
 License: GPL3
*/


/**
 * Embed youtube video into post.
 *
 * Example: [jwrr_youtube id='5uRu14RVHAU']
 *
 * @param string $youtube_id The YouTube video's id, for example: 'u14RVHAU'
 * @param bool $enable_echo Echo breadcrumbs when True.
 * @param string $css_id The CSS id for the div
 * @return string html that embeds youtube video into post.
 */
function jwrr_youtube_function($atts = array(), $content = null, $tag = '')
{

        // $id = '5uRu14RVHAU';
	// $id = $atts['id'];
	extract( shortcode_atts( array('id' => 'undefined'), $atts ) );

	$enable_echo = False;
	$css_id = "jwrr_youtube";
	$indent_level = 5;
	$indent = str_repeat(' ', $indent_level);
	$html = <<<HEREDOC

$indent<!-- plugin: jwrr_youtube -->
<div style="clear:both"></div>
$indent<div class="$css_id">
$indent <img src="/wp-content/plugins/jwrr-youtube/images/transparent16x9.gif">
$indent <iframe src="//www.youtube.com/embed/$id" allowfullscreen></iframe>
$indent</div>

HEREDOC;

	if ($enable_echo) echo $html;
	return $html;
}

add_shortcode('youtube', 'jwrr_youtube_function');

