<?php session_start() ?>
<?php
 
 if(!preg_match('/page_default/',$_POST['addsheetdefault']))
 $page_default='-';
 else 
 $page_default='checked=true';
 if(!preg_match('/post_default/',$_POST['addsheetdefault']))
 $post_default='-';
 else 
 $post_default='checked=true';
 if(!preg_match('/js_page_default/',$_POST['addsheetdefault']))
 $js_page_default='-';
 else 
 $js_page_default='checked=true';
 if(!preg_match('/js_post_default/',$_POST['addsheetdefault']))
 $js_post_default='-';
 else 
 $js_post_default='checked=true';
 if(!$_POST['jqtheme'])
 $jq_theme_default='-';
 else 
 $jq_theme_default=$_POST['jqtheme'];
 if( file_put_contents(dirname(__FILE__).'/jaip-style-default-settings.php',$page_default."\n".$post_default."\n".$js_page_default."\n".$js_post_default."\n".$jq_theme_default)){
  
  }
  else {
  	echo 'something went wrong in style default';
  }
 
    

  

  $media_src_array=explode("&", urldecode($_POST['mediasrc']));
   
   
    
   foreach($media_src_array as $media_src_pair){
  
   	$media_src_pair=explode('=',$media_src_pair);	
   	
	$array_build.="'".trim(preg_replace('/(\'|\")/','',$media_src_pair[0]))."'".' => '."'".trim($media_src_pair[1])."',\n";
   }
    
   $array_build="<?php\n".'$jaip_image_array=array('."\n".$array_build.")?>";
   
   
  if( file_put_contents(dirname(__FILE__).'/jaip-header-image-array.php',$array_build)){
  	echo '<div class=green >succesfully updated</div>';
  }
  else {
  	echo '<p style="background:#FF0000" >something went wrong with imagearray</p>';
  }
  
?> 