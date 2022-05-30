<?php
/*
 Name: JWRR Dropdown Menubar (DDMB)
 URI: http://jwrr.com/wp/plugins/jwrr_ddmb
 Description: a plugin to add a dropdown menu bar.
 Version: 0.1
 Author: jwrr
 Author URI: http://jwrr.com
 License: GPL3
*/

add_shortcode('jwrr-ddmb', 'jwrr_ddmb');
function jwrr_ddmb()
{
$ddmb_col = 4;
$ddmb_col_width = 100/$ddmb_col;
for ($i = 0; $i < $ddmb_col; $i++) {
	$ddmb_left[$i] = $i * $ddmb_col_width;
	$ddmb_width[$i] = $ddmb_col_width;
}

function ddmb_menu($class='ddmb', $style='')
{
$c = ($class == '') ? '' : " class='$class'";
$s = ($style == '') ? '' : " style='$style'";
$html = <<<HEREDOC
<!-- START DROP DOWN MENUBAR HTML -->
<ul$c$s>
HEREDOC;
return $html;
}

function ddmb_category($name='', $style='', $href='')
{
$s = ($style == '') ? '' : " style='$style'";
$html = <<<HEREDOC
 <li$s><a href='$href'>$name</a>
HEREDOC;
}

function add_link($link)
{
}

function add_text($text)
{
}

$html = '';
$html .= ddmb_menu('ddmb',
                   'width:100%;margin:0 0 0 0;padding:0 0 0 0;');
$html .= ddmb_category('My Books',
                       'left:{$ddmb_left[0]}%;width:{$ddmb_width[0]}%');

add_link("https://www.amazon.com/Rachel-Armington/e/B015GRMR8O/ref=dp_byline_cont_book_1");
add_text("See My Books on Amazon");

add_link("https://www.amazon.com/Rachel-Armington/e/B015GRMR8O/ref=dp_byline_cont_book_1");
add_text("See My Books at Barnes and Noble");

$html .= ddmb_category( "Gift Ideas");

add_link("https://www.zazzle.com/rachel_armington_art");
add_text("See my art on gifts at Zazzle");

add_link("https://www.zazzle.com/fairy_paintings");
add_text("See my Fairies");

$html .= ddmb_category( "Follow Me");

add_link("https://www.facebook.com/Rachel-Paints-1396112717307475/");
add_text("Facebook");

add_link("https://www.instagram.com/rachelarmington6052/?hl=en");
add_text("Instagram");

add_link("https://www.youtube.com/channel/UCQ7Eosyn2nYbNbkokKrmPcw");
add_text("YouTube");

add_link("https://www.pinterest.com/CatPaintings/");
add_text("Pinterest");

add_link("https://twitter.com/rachelarmington");
add_text("Twitter");

$html .= ddmb_category( "My Other Sites");

add_link("https://cat-paintings.com");
add_text("Cat Paintings");

add_link("http://dog-paintings.com");
add_text("Dog Paintings");

add_link("http://fairy-paintings.com");
add_text("Fairy Paintings");

add_link("http://childrensart.info");
add_text("Childrens Art");

add_link("http://thepaintedgourd.com");
add_text("The Painted Gourd");

add_link("http://woollyfelter.com");
add_text("Wooly Felter");


$gift_ideas = "Gift Ideas";
$my_other_sites = "My Other Sites";
if (wp_is_mobile()) {
   $gift_ideas = "Gift<br>Ideas";
   $my_other_sites = "My<br>Sites";
}

$html = <<<HEREDOC
<!-- START DROP DOWN MENUBAR HTML -->
<style>
.ddmb {position:relative;
left: 0px;
top: 0px;
width:100%;margin:0 0 0 0;padding:0 0 0 0;}

.ddmb a {color:white;}

.ddmb > li {
    position: absolute;
    top: 0px;
    list-style-type: none;
    background-color: rgba(51,102,153,0.5);font-size: 1.5em;
    display: block;
    border-style: none;
    border-right-style: solid;
    border-width: 1px;
    border-color: white;
    text-align: center;
    font-size: 1.3em;
    padding: 9px 0px 10px 0px;
    margin: 0 0 0 0;
    z-index: 999;
}

.ddmb > li > ul {
    display: none;
    background-color: gray;
    font-weight: normal;
    white-space: nowrap;
    border-style: none;
    text-align: left;
    margin: 0px;
    margin-top: 10px;
    padding: 5px 0px 5px 0px;
    background-image: url('/images/ddmb_background.gif');
    background-size: 60%;
    background-repeat: no-repeat;
    background-position: top right;
    font-size: 0.7em;
    transition-timing-function: ease;
}

.ddmb > li > ul > li {
    font-size: 1.5em;
    padding: 0.5em 0 0.5em 0.5em;
    margin: 0.5em 0 0.5em 0;
}

.ddmb > li:hover {padding-bottom:0px;background-color:maroon;}
.ddmb > li:hover > ul {display:block;}
.ddmb > li > ul > li:hover {background-color:maroon;}

</style> 

<ul class="ddmb">
 <li style="left:{$ddmb_left[0]}%;width:{$ddmb_width[0]}%">
 <a href="https://www.amazon.com/Rachel-Armington/e/B015GRMR8O/ref=dp_byline_cont_book_1">My Books</a>
 <ul style="width:200%;">
  <li><a href="https://www.amazon.com/Rachel-Armington/e/B015GRMR8O/ref=dp_byline_cont_book_1">See my books on Amazon</a>
  <li><a href="https://www.amazon.com/Rachel-Armington/e/B015GRMR8O/ref=dp_byline_cont_book_1">See my books on Barnes and Noble</a>
 </ul>
 <li style="left:{$ddmb_left[1]}%;width:{$ddmb_width[1]}%">
 <a href="https://www.zazzle.com/rachel_armington_art">$gift_ideas</a>
 <ul style="width:200%;">
  <li><a href="https://www.zazzle.com/rachel_armington_art">See my art on gifts at Zazzle</a>
  <li><a href="https://www.zazzle.com/fairy_paintings">See my fairies</a>
 </ul>
 <li style="left:{$ddmb_left[2]}%;width:{$ddmb_width[2]}%">
 <a href="https://www.facebook.com/Rachel-Paints-1396112717307475/">Follow Me</a>
 <ul style="width:200%;">
  <li><a href="https://www.facebook.com/Rachel-Paints-1396112717307475/">Facebook</a></li>
  <li><a href="https://www.instagram.com/rachelarmington6052/?hl=en">Instagram</a></li>
  <li><a href="https://www.youtube.com/channel/UCQ7Eosyn2nYbNbkokKrmPcw">Youtube</a></li>
  <li><a href="https://www.pinterest.com/CatPaintings/">Pinterest</a></li>
  <li><a href="https://twitter.com/rachelarmington">Twitter</a></li>
 </ul>
 <li style="left:{$ddmb_left[3]}%;width:{$ddmb_width[3]}%">
 <a href="https://cat-paintings.com">$my_other_sites</a>
 <ul>
  <li><a href="https://cat-paintings.com">Cat Paintings</a></li>
  <li><a href="http://dog-paintings.com">Dog Paintings</a></li>
  <li><a href="http://fairy-paintings.com">Fairy Paintings</a></li>
  <li><a href="http://childrensart.info">Childrens Art</a></li>
  <li><a href="http://thepaintedgourd.com">Painted Gourd</a></li>
  <li><a href="http://woollyfelter.com">Woolly Felter</a></li>
 </ul>
</ul>
<!-- END MENUBAR HTML -->

HEREDOC;

return $html;
}

