<?php
/*
 Name: JWRR Nav
 URI: http://jwrr.com/wp/plugins/jwrr_nav
 Description: a plugin to contain navigation table.
 Version: 0.1
 Author: jwrr
 Author URI: http://jwrr.com
 License: GPL3
*/

add_shortcode('jwrr-nav', 'jwrr_nav');
function jwrr_nav()
{

$html = <<<HEREDOC

<!-- jwrr-nav -->
<ul id="jwrr-nav">
HEREDOC;
echo $html;

$my_stuff = <<<HEREDOC

<li>My Books
 <ul>
   <li><a href="https://www.amazon.com/Rachel-Armington/e/B015GRMR8O/ref=dp_byline_cont_book_1">On Amazon</a></li>
   <li><a href="https://www.amazon.com/Rachel-Armington/e/B015GRMR8O/ref=dp_byline_cont_book_1">On B&N</a></li>
 </ul>
</li>
<li>Gifts
 <ul>
  <li><a href="https://www.zazzle.com/rachel_armington_art">Watercolors</a></li>
  <li><a href="https://www.zazzle.com/fairy_paintings">Fairies</a></li>
 </ul>
</li>
HEREDOC;

 if (!wp_is_mobile()) {
   echo $my_stuff;
 }
 jwrr_my_topics(); 
 jwrr_my_tags();

$html = <<<HEREDOC
<li>Follow Me (Social)
 <ul>
  <li><a href="https://www.facebook.com/Rachel-Paints-1396112717307475/">Facebook</a></li>
  <li><a href="https://www.instagram.com/rachelarmington6052/?hl=en">Instagram</a></li>
  <li><a href="https://www.youtube.com/channel/UCQ7Eosyn2nYbNbkokKrmPcw">Youtube</a></li>
  <li><a href="https://www.pinterest.com/CatPaintings/">Pinterest</a></li>
  <li><a href="https://twitter.com/rachelarmington">Twitter</a></li>
 </ul>
</li>
<li>My Other Websites
 <ul>
  <li><a href="https://cat-paintings.com">Cat Paintings</a></li>
  <li><a href="http://dog-paintings.com">Dog Paintings</a></li>
  <li><a href="http://fairy-paintings.com">Fairy Paintings</a></li>
  <li><a href="http://childrensart.info">Childrens Art</a></li>
  <li><a href="http://thepaintedgourd.com">Painted Gourd</a></li>
  <li><a href="http://woollyfelter.com">Woolly Felter</a></li>
 </ul>
</li>
</ul>	
HEREDOC;
echo $html;

if (wp_is_mobile()) {
   echo $my_stuff;
 }

return; // $html;
}


function jwrr_my_topics()
{
 ob_start();
 wp_list_categories( array('orderby' => 'name') ); 
 $list = ob_get_contents();
 ob_end_clean();
 $list = preg_replace("/Categories/","Topics",$list);
 echo $list;
} 


function jwrr_my_tags()
{
 $indent = str_repeat(' ', 2);
 $tags = get_tags();
 $html = $indent . '<li class="theme_tags">Tags <span class="theme_hidden">(+)</span><ul>' . "\n";
 foreach ( $tags as $tag ) {
  $tag_link = get_tag_link( $tag->term_id );			
  $html .= $indent . "<li><a href='{$tag_link}' title='{$tag->name} Tag' class='{$tag->slug}'>{$tag->name} ({$tag->count})</a></li>\n";
 }
 $html .= $indent . '</ul></li>' . "\n";
 echo $html;
}

// function register_shortcodes(){
// add_shortcode('youtube', 'jwrr_youtube_function');
//}

// add_action( 'init', 'register_shortcodes');

/*
 Name: JWRR Post Tags
 URI: http://jwrr.com/wp/plugins/jwrr-post-tags
 Description: a plugin to display the tags for a post.
 Version: 0.1
 Author: jwrr
 Author URI: http://jwrr.com
 License: GPL3
*/

add_shortcode('jwrr-post-tags', 'jwrr_post_tags');
function jwrr_post_tags()
{
	$indent = str_repeat(' ', 4);
	$html = '';
	$post_tags = get_the_tags();
	if  ($post_tags) {
		$t = count($post_tags) > 1 ? 'Tags:' : 'Tag:'; 
		$html =	"\n$indent<!-- plugin: jwrr-post-tags -->\n" . "
<style>
ul.jwrr_post_tags {margin:0.4em 0 0.4em 0.3em;padding:0 0 0 0;}
ul.jwrr_post_tags li {
display: inline;
line-height: 2.2em;
font-size: 1.1em;
list-style: none;
padding: 0.2em 1.5% 0.2em 1.5%;
margin: 0.3em 0.5em 0.3em 0;
border-radius: 15px;
background-color: #f2c7cd;
white-space: nowrap;
border-style:none;
border-width:3px;
border-color:black;
box-shadow: 5px 5px 5px #aaa;
-moz-box-shadow: 5px 5px 5px #aaa;
-webkit-box-shadow: 5px 5px 5px #aaa;
}
ul.jwrr_post_tags li:hover {
    background-color: lavender;
}
 
ul.jwrr_post_tags li:first-child {background-color:lightgray;}
a.jwrr_button {
    -webkit-appearance: button;
    -moz-appearance: button;
    appearance: button;
    text-decoration: none;
    color: initial;}
</style>" .
		"$indent<ul class='jwrr_post_tags'>\n$indent <li>$t</li>\n"; 
		foreach( $post_tags as $tag ) {
			$tag_name = $tag->name;
			$tag_count = $tag->count;
			$href = "/tag/$tag_name";
			$a_text = ucwords($tag_name) . " ($tag_count)";
			$html .= "$indent <li><a href='$href'>$a_text</a></li>\n"; 
		}
		$html .= "$indent</ul>\n\n";
	}
	return $html;
}

