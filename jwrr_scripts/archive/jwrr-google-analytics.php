<?php
/*
 Name: JWRR Google Analytics
 URI: http://jwrr.com/wp/plugins/jwrr_google_analytics
 Description: a plugin to add the Google Analytics to the page footer.
 Version: 0.1
 Author: jwrr
 Author URI: http://jwrr.com
 License: GPL3
*/


/**
 * Add Google Analytics snippet to the page footer.
 *
 * Example: echo do_shortcode( "[ga id='5uRu14RVHAU']" );
 *
 * @param string $id Your Google Analytics ID
 * @return string html that embeds Google Analytics script into footer
 */
function jwrr_google_analytics_function($atts = array(), $content = null, $tag = '')
{
	extract( shortcode_atts( array('id' => 'undefined'), $atts ) );

	$html = <<<HEREDOC

 <!-- Google Analytics -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', '$id', 'auto');
  ga('send', 'pageview');
</script>

HEREDOC;

	return $html;
}
add_shortcode('ga', 'jwrr_google_analytics_function');


