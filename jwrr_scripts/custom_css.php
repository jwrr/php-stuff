<?php

function custom_css()
{
$css = "<style>
img:-moz-loading {visibility:hidden}
#css-outer {position:relative;width:100%;max-width:1200px;margin:0 auto 0 auto;padding:0;font-family:Estrangelo Edessa;color:#333333}
.css-the-post {background-color:#fff;margin:0 0 1em 0;padding:0 1% 0em 1%;border:solid;border-width:1px;border-radius:15px}
.css-the-title {font-size:2.1em;margin:0.2em 0 0.2em 0.4em;padding:0}
h2.css-the-title {font-size:2.1em;margin:0em 0 0.2em 0.4em;padding:0}
.css-the-date {margin:0 0 0 0.5em;padding:0 0 0 0.5em}
.css-the-content > p {font-size:1.7em;padding:0 0.5em 0 0.5em;margin:0.5em 0 0 0}
.css-the-content > p > img {padding:0em 0.5em 3.5em 0.5em};
.css-the-excerpt {float:right;font-size:2em;padding:0;margin:0}
.css-the-excerpt > p {font-size:1.5em;padding:0;margin:0}
.css-the-thumbnail img {display:inline;padding:0;margin:0.5em 1em 0.5em 0.2em;border-radius:15px}
#css-copyright {text-align:center;color:#444444;padding:0 0 1em 0}
#css-main {position:static}
#css-content {width:100%;float:none}
#css-banner {margin:0 0 1em 0;padding:0;width:100%;height:420px;overflow:clip;overflow-clip-margin:0px;transition:transform 1s;border-radius:15px}
#css-banner:hover {height:auto}
#css-banner img {max-width:98%}
#css-h1 {text-align:center;padding:0 0 0.3em 0;margin:0}
input.css-search-form-file {color:white;background-color:green;padding:0.5em;font-size:1.5em;border-radius:10px;width:75%}
input.css-search-form-submit {color:white;background-color:green;padding:0.6em;font-size:1.5em;border-radius:10px}
div.css-search-form {margin-left:auto;margin-right:auto;text-align:center}
div.css-search-form h2 {margin:0;padding:0}
div.css-search-form-please-log-in {font-size:2.0em;font-weight:bold;margin:1em}
div.css-show-images-main {max-width:1024px;margin:0 auto}
div.css-copyright {text-align:center;font-size:1.2em;margin:0.5em}
div.css-pod-item {display:block;margin-left:auto;margin-right:auto;text-align:center}
div.css-pod-item img {display:block;margin-left:auto;margin-right:auto}
div.css-pod-item div {display:block;margin-left:auto;margin-right:auto}
img.css-main-image {display:block;margin-left:auto;margin-right:auto;max-width:100%;height:auto;cursor:url('/catartists-images/paw.png') 4 12, auto}
div.css-gallery {text-align:center}
div.css-gallery img {display:inline;padding:0;margin:0.5em 1em 0.5em 0.2em;border-radius:15px;height:200px;transition:transform 1s;max-width:100%}
div.css-gallery img:hover {transform:scale(1.5);cursor:url(/catartists-images/paw.png) 4 12, auto}
.css-small {transition:transform 1s;padding:0;margin:0.5em 1em 0.5em 0.2em;border-radius:15px}
.css-small:hover {transform:scale(1.5)}
h1 {text-align:center}
.css-button-bar {position:static;width:100%;min-height:3.3em;background-color:black;color:white;max-width:100%;text-align:center}
.css-button-bar span {margin:0;padding:0;font-size:1.6em}
.css-button {font-size:1.3em;border-radius:10px;padding:0.5em 0.2em 0.5em 0.2em;margin:3px 0.15em 0 3px;background-color:green;color:white;text-decoration:none;width:3.4em;overflow:hidden;white-space:nowrap}
a.css-button:link {color:white;text-decoration:none}
a.css-button:visited {color:white;text-decoration:none}
.css-right {float:right}
.css-left {float:left}
.css-button-bar span {white-space:nowrap}
input.css-upload-form_file {color:white;background-color:green;padding:0.5em;font-size:1.5em;border-radius:10px;width:75%}
div.css-upload-form h2 {margin:0;padding:0}
div.css-upload-form-please-log-in {font-size:2.0em;font-weight:bold;margin:1em}
.whoops {color:red}
div.css-user-name-wrap {margin:1em}
div.css-user-pass-wrap {margin:1em}
div.css-oneliner {margin:2.5em 0; width:92%;max-width:650px}
div.css-oneliner label {display:block;position:relative;left:0.5em;font-size:1.5em}
div.css-oneliner input {display:block;font-size:1.5em;border-color:gray;border-radius:10px;padding:0.3em;margin:0.5em;width:100%}
div.css-oneliner input[checkbox] {display:inline;border-color:auto;border-radius:auto;padding:0;margin:0;width:auto;text-align:left}
div.css-oneliner input[type=submit] {background-color:green;color:white}
div.css-oneliner textarea {font-size:1.5em;border-color:gray;border-radius:10px;padding:0.3em;width:68%}
#css-input-password {background-image:url('/catartists-images/eye.svg'); background-repeat:no-repeat;background-position:right; background-size:contain}
#css-password-eye {position:relative;height:30px;left:90%;top:80px;visibility:hidden}
div.css-checkboxes {display:block;margin-left:1.5em;font-size:1.5em;border-color:gray;border-radius:10px;padding:0.3em}
div.css-checkbox {display:inline;margin-left:1%;font-size:1.5em}
div.css-checkbox input {height:2em;width:2em;border-color:gray;border-radius:10px}
.css-error {color:red;font-size:2em;margin-left:0.5em}
.css-success {color:green;font-size:2em;margin-left:0.5em}
body {animation: fadein 0.6s; -moz-animation: fadein 0.6s; -webkit-animation: fadein 0.6s; -o-animation: fadein 0.6s}
@keyframes fadein {from {opacity:0} to {opacity:1}}
@-moz-keyframes fadein {from {opacity:0} to {opacity:1}}
@-webkit-keyframes fadein {from {opacity:0} to {opacity:1}}
@-o-keyframes fadein {from {opacity:0} to {opacity: 1}}

#css-contentx {display: none}
#css-showx:target #css-contentx {display: inline-block}
#css-showx:target #css-openx {display: none}
</style>
";
return $css;
}

