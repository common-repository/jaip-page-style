<?php
 include(WP_PLUGIN_DIR .'/jaip-page-style/jaip-header-image-array.php');


$jaip_page_title=get_the_title();


if(is_front_page())
if(array_key_exists('Home',$jaip_image_array))
$jaip_page_title='Home';


 



if(!array_key_exists($jaip_page_title,$jaip_image_array)){
if(array_key_exists('default',$jaip_image_array))
$jaip_src=$jaip_image_array['default'];
}
else {
		$jaip_src=$jaip_image_array[$jaip_page_title];
	}

$jaip_width=HEADER_IMAGE_WIDTH.'px';
$jaip_height=HEADER_IMAGE_HEIGHT.'px';
if($jaip_image_array[$jaip_page_title]=='none')
{}
else {
if( preg_match('/\.(png|gif|jpe?g)$/',$jaip_src))
$jaip_header_image=<<<HERE

 <img src=$jaip_src    style='max-width:$jaip_width;width:100%' id=header_image" />

HERE;
else 
if( preg_match('/swf$/',$jaip_src))
$jaip_header_image=<<<HERE
<div style='max-width:$jaip_width;max-height:$jaip_height' id=header_image>
<object  style="width:100%;height:100%" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0"><param name="allowScriptAccess"  value="sameDomain" /><param name="quality" value="medium" /><param name="wmode" value="transparent" /><param name="true" value="false" /><param name="allowFullScreen" value="true" /><param name="src" value=$jaip_src /><param name="allowscriptaccess" value="sameDomain" /><param name="pluginspage" value="http://www.macromedia.com/go/getflashplayer" /><embed style="width:100%;height:100%"  type="application/x-shockwave-flash" src=$jaip_src allowScriptAccess="sameDomain" quality="medium"  wmode="transparent" loop="true" allowFullScreen="true" allowscriptaccess="sameDomain" pluginspage="http://www.macromedia.com/go/getflashplayer" /></object>
</div>
HERE;

echo $jaip_header_image;
}
?>

			