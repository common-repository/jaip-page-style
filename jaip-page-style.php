<?php
/*
 Plugin Name: Jaip Page Style
 Plugin URI: http://resieat.dk/wordpres
 Description: Flash or image as header image plus individual stylesheets for pages.  <strong> Only use a fresh installation of (twentyten or) twenty eleven.</strong> Eventually create childtheme in jaip-child-theme folder afterwards.  <strong>Uses:</strong> wp-admin   >  Appearance > Editor <strong>and</strong> wp-admin   > Settings > Jaip Page Style
 Version:1.0
 Author: Jaip
 */

     
     header('Content-Type: text/html; charset=utf-8');
     
     add_action('save_post','jaip_create_page_style_sheet');
	 add_action('wp_head','jaip_load_page_style_sheet');
	 add_action('save_post','jaip_create_page_javascript');
	 add_action('wp_head','jaip_load_page_javascript');
	 
	 add_action('switch_theme','jaip_deactivate_on_theme_switch');
	 add_action('admin_menu','jaip_create_menu');
	 add_action('admin_menu','jaip_create_js');
	 add_action('delete_post','jaip_delete_sheet');
	 add_action('init', 'jaip_wp_register');
	add_action('wp_head', 'jaip_jquery_ui_theme');
	    register_activation_hook(__FILE__,'jaip_create_child_theme');
		register_deactivation_hook(__FILE__,'jaip_delete_child_theme');
		 add_action( 'wp_ajax_nopriv_jaip_get_post', 'jaip_get_post' );
            add_action( 'wp_ajax_jaip_get_post', 'jaip_get_post' );
	
	
	
	
	function jaip_get_post(){
		



if(!empty($_POST['jaip_id'])){
$jaip_id=$_POST['jaip_id'];
$result = mysql_query("SELECT  post_content FROM wp_posts WHERE id = '$jaip_id' ");

while($row = mysql_fetch_array($result))
  {
  $output.='<p>'.$row['post_content'].'</p>';
 
  }
}
else{
	global $post;
	
$args = array( 'post_type' => 'post', 'orderby'=> 'post_date', 'order' => 'DESC','numberposts' => 100, );
$myposts = get_posts( $args );
foreach( $myposts as $post ) {
setup_postdata($post);
if($i<5){
$output.='<p class=jaip_posts jaip_id='.get_the_ID().'>'.get_the_title().'</p><p class=jaip_date>'.get_the_date().get_the_time().'</p>';	
if($i==4)
	$output.='<p class=show_all>show all</p>';
	}
else{
	$hidden_output.='<p class="jaip_posts hidden" jaip_id='.get_the_ID().'>'.get_the_title().'</p><p class="jaip_date hidden" >'.get_the_date().get_the_time().'</p>';	
	 }
	$i++;
}
	

}	
 
	echo $output.$hidden_output;
 

   
		die();
	}	 
	function jaip_create_child_theme(){
		
		
		
		
		if(get_option('template')!='twentyten'&&get_option('template')!='twentyeleven'){
			deactivate_plugins( __FILE__);
			exit;
		}
		else {
		if(get_option('template')==get_option('stylesheet')){
				
				
			$template=get_option('template');	
			$jaip_style_content=file_get_contents(WP_PLUGIN_DIR.'/jaip-page-style/jaip-child-theme/'.$template.'-style.css');
            $jaip_javascript_content=file_get_contents(WP_PLUGIN_DIR.'/jaip-page-style/jaip-child-theme/js-javascript-jquery-'.$template.'.js');
            $jaip_header=file_get_contents(WP_PLUGIN_DIR.'/jaip-page-style/jaip-child-theme/'.$template.'-header.php');
			$jaip_home_css=file_get_contents(WP_PLUGIN_DIR.'/jaip-page-style/jaip-child-theme/'.$template.'-css_HOME_pageid.css');
		    $jaip_home_js='Javascript for the frontpage - a file created for actual pagetitle overrides this';
		    if(!file_exists(WP_CONTENT_DIR .'/themes/jaip-child-theme'))
				mkdir(WP_CONTENT_DIR .'/themes/jaip-child-theme');	
			 
	        file_put_contents(WP_CONTENT_DIR .'/themes/jaip-child-theme/style.css',$jaip_style_content);
	        if(!file_exists(WP_CONTENT_DIR .'/themes/jaip-child-theme/js-javascript-jquery.php'))
		    file_put_contents(WP_CONTENT_DIR .'/themes/jaip-child-theme/js-javascript-jquery.php',$jaip_javascript_content);
	        file_put_contents(WP_CONTENT_DIR .'/themes/jaip-child-theme/header.php',$jaip_header);		
			 if(!file_exists(WP_CONTENT_DIR .'/themes/jaip-child-theme/css_HOME_pageid.css'))
			file_put_contents(WP_CONTENT_DIR .'/themes/jaip-child-theme/css_HOME_pageid.css',$jaip_home_css);
			if(!file_exists(WP_CONTENT_DIR .'/themes/jaip-child-theme/js_HOME_pageid.php'))
			file_put_contents(WP_CONTENT_DIR .'/themes/jaip-child-theme/js_HOME_pageid.php',$jaip_home_js);
	       
	        
	        update_option('stylesheet', 'jaip-child-theme');
            update_option('current_theme', $template.' jaip-child-theme');		
		file_put_contents(WP_PLUGIN_DIR.'/jaip-page-style/jaip-child-theme/active-tempate.txt',$template);
		}

		
		}
	}
	function jaip_delete_child_theme(){
		$jaip_template_new=get_option('template');
		$jaip_template=file_get_contents(WP_PLUGIN_DIR.'/jaip-page-style/jaip-child-theme/active-tempate.txt');
		
		if($jaip_template_new==$jaip_template){
		update_option('stylesheet', $jaip_template);
        update_option('current_theme', $jaip_template);
        }		
        $jaip_backup_dir=WP_PLUGIN_DIR.'/jaip-page-style/jaip-child-theme/jaip-page-style-backup-'.$jaip_template.'t';
      
        if(!file_exists($jaip_backup_dir))
				mkdir($jaip_backup_dir);	
	            
	   $jaip_theme_files=scandir(WP_CONTENT_DIR .'/themes/jaip-child-theme');
	   foreach($jaip_theme_files as $jaip_theme_file){
	   	file_put_contents($jaip_backup_dir.'/'.$jaip_theme_file,file_get_contents(WP_CONTENT_DIR .'/themes/jaip-child-theme/'.$jaip_theme_file));
		//unlink(WP_CONTENT_DIR .'/themes/jaip-child-theme/'.$jaip_theme_file);
		
	   }
   
		
        unlink(WP_PLUGIN_DIR.'/jaip-page-style/jaip-child-theme/active-tempate.txt');
		//rmdir(WP_CONTENT_DIR .'/themes/jaip-child-theme');
	}
	 

	
	 function jaip_create_menu(){
	 	
		
	 	
		add_options_page('Jaip Page Style Settings','Jaip Page Style','manage_options',__FILE__,'jaip_page_style_options');
	 }
	function jaip_page_style_options(){
		
		
		load_template(WP_PLUGIN_DIR.'/jaip-page-style/jaip-page-style-settings.php');
		
		
		
	}
	 
	
		 
	 
	
	
	function jaip_delete_sheet(){
		
		$jaip_theme_files=scandir(WP_CONTENT_DIR .'/themes/jaip-child-theme');
		$jaip_page_id='_pageid'.get_the_ID();
		foreach($jaip_theme_files as $jaip_theme_file){
			
			$jaip_regex='/^(css|js)_.*'.$jaip_page_id.'\.(css|js|php)$/';
			if(preg_match($jaip_regex,$jaip_theme_file)){
				unlink(WP_CONTENT_DIR .'/themes/jaip-child-theme/'.$jaip_theme_file);
			}
		}
	  }

	 function  jaip_deactivate_on_theme_switch(){
	// jaip_delete_child_theme();
		deactivate_plugins( __FILE__);
		
		
	 }
	  
	 
	
	
	function jaip_create_page_style_sheet(){
		
		if(empty($_POST['post_title']))
		return false;
		$jaip_default_style_set=explode("\n",file_get_contents(WP_PLUGIN_DIR.'/jaip-page-style/jaip-style-default-settings.php'));
		
		if((get_post_type()=='page'&&$jaip_default_style_set[0]=='checked=true')||(get_post_type()=='post'&&$jaip_default_style_set[1]=='checked=true')){
		
		$jaip_page_id='_pageid'.get_the_ID();
		$jaip_filename='css_'.preg_replace('/[^¨\w-_]+/','-',strtolower($_POST['post_title'])).$jaip_page_id.'.css';
			
		$jaip_content=<<<HERE
		/*
		body {
			background: #000 url('') center top repeat-y !important;
		}
		#header_image {
			width:200px !important;
			height:100px !important;
			max-width:200px !important;
			max-height:100px !important;
			position:relative !important;
            margin-left:25% !important;
			margin-top:-75px !important;
			margin-bottom:-30px !important;
            z-index:-100 !important;
            
		}
		
		Style any Wordpress or your own selectors here
		
              */
HERE;
		
		
		if(file_exists(get_stylesheet_directory().'/'.$jaip_filename)){
				
			//do nothing	
				
			}
		else {
		$theme_files=scandir(get_stylesheet_directory());
		
		$jaip_regex='/^css_.*'.$jaip_page_id.'\.css/';
		
		foreach($theme_files as $theme_file){
			
			
			if(preg_match($jaip_regex,$theme_file)){
				
				$jaip_content=file_get_contents(get_stylesheet_directory().'/'.$theme_file);
				
				
				
					//rename($old_name,$new_name);
				unlink(get_stylesheet_directory().'/'.$theme_file);
				
			}
			 
		}
		
		
		
			
		
		
				
	      file_put_contents(get_stylesheet_directory().'/'.$jaip_filename,$jaip_content);
				
		
		
		}
		
		}
		
		$jaip_header_image_array=file_get_contents(WP_PLUGIN_DIR.'/jaip-page-style/jaip-header-image-array.php');
	$jaip_new_title=preg_replace('/(\'|\"|\\\)/','',$_POST['post_title']);
    $jaip_old_title=preg_replace('/(\'|\")/','',get_the_title());
	//echo $jaip_new_title.'ll'.$jaip_old_title;exit;
	$jaip_regex='/\''.$jaip_old_title.'\'\s\=>/';
	$jaip_replace="'".$jaip_new_title."' =>";
	//echo $jaip_header_image_array;exit;
	$jaip_header_image_array=preg_replace($jaip_regex,$jaip_replace,$jaip_header_image_array);
	//echo $jaip_header_image_array;exit;
	file_put_contents(WP_PLUGIN_DIR.'/jaip-page-style/jaip-header-image-array.php',$jaip_header_image_array);
	
    }




     function jaip_load_page_style_sheet(){
     	
		$jaip_page_id='pageid'.get_the_ID();
		
		$jaip_filename='css_'.preg_replace('/[^\w-_]+/','-',strtolower(get_the_title())).'_'.$jaip_page_id.'.css';
		
		if(file_exists(get_stylesheet_directory().'/'.$jaip_filename)){
			$jaip_page_style_sheet=WP_CONTENT_URL.'/themes/jaip-child-theme/'.$jaip_filename;
		
		}
		else {
			if(is_front_page()){
			$jaip_filename='css_HOME_pageid.css';
			if(file_exists(get_stylesheet_directory().'/'.$jaip_filename)){
			$jaip_page_style_sheet=WP_CONTENT_URL.'/themes/jaip-child-theme/'.$jaip_filename;
			}
		}	
			}
			if(!empty($jaip_page_style_sheet))
			echo <<<HERE
			<link rel="stylesheet" href=$jaip_page_style_sheet type="text/css" media="all" />
			
HERE;
		
		$jaip_filename='js_'.preg_replace('/[^\w-_]+/','-',strtolower(get_the_title())).'_'.$jaip_page_id.'.js';
		
		if(file_exists(get_stylesheet_directory().'/'.$jaip_filename)){
			$jaip_page_javascript=WP_CONTENT_URL.'/themes/jaip-child-theme/'.$jaip_filename;
		
		} 
		else {
			if(is_front_page()){
			$jaip_filename='js_HOME_pageid.js';
			if(file_exists(get_stylesheet_directory().'/'.$jaip_filename)){
			$jaip_page_javascript=WP_CONTENT_URL.'/themes/jaip-child-theme/'.$jaip_filename;
			}
		}	
			}
		if(!empty($jaip_page_javascript))
			echo <<<HERE
			<script src=$jaip_page_javascript></script>
HERE;
    	
		
 }
	 
	 
	 
	function jaip_create_js(){
		$jaip_javascript_content=file_get_contents(WP_CONTENT_DIR .'/themes/jaip-child-theme/js-javascript-jquery.php');
		file_put_contents(WP_CONTENT_DIR.'/themes/jaip-child-theme/js-javascript-jquery.js',$jaip_javascript_content);
	
	
	    $theme_files=scandir(get_stylesheet_directory());
		
		$jaip_regex='/^js_.*_pageid[\d]*\.php/';
		
		foreach($theme_files as $theme_file){
			
			 
			if(preg_match($jaip_regex,$theme_file)){
				
				$jaip_javascript_content=file_get_contents(get_stylesheet_directory().'/'.$theme_file);
				$jaip_js_file=preg_replace('/\.php$/','.js',$theme_file);
				file_put_contents(get_stylesheet_directory().'/'.$jaip_js_file,$jaip_javascript_content);
				
			}
			 
		}
	}
	
	
	
	
	
	function jaip_wp_register() {
		if(is_admin())
            return false;
	wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js');
    wp_enqueue_script( 'jquery' );
wp_deregister_script( 'jquery-ui' );
    wp_register_script( 'jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js');
    wp_enqueue_script( 'jquery-ui' );


	wp_register_script( 'jaip-javascript-jquery', WP_CONTENT_URL.'/themes/jaip-child-theme/js-javascript-jquery.js');
	wp_enqueue_script( 'jaip-javascript-jquery');
	
}    
  
	 
	function jaip_create_page_javascript(){
		
		if(empty($_POST['post_title']))
		return false;
		$jaip_default_style_set=explode("\n",file_get_contents(WP_PLUGIN_DIR.'/jaip-page-style/jaip-style-default-settings.php'));
		
		if((get_post_type()=='page'&&$jaip_default_style_set[2]=='checked=true')||(get_post_type()=='post'&&$jaip_default_style_set[3]=='checked=true')){
		
		$jaip_page_id='_pageid'.get_the_ID();
		$jaip_filename='js_'.preg_replace('/[^¨\w-_]+/','-',strtolower($_POST['post_title'])).$jaip_page_id.'.php';
			
		$jaip_content=<<<HERE
				/* suggestion to improve page in small browsers. Adapt to actual flash and page dimensions
		$(document).ready(function(){
 $('#header_image').css('max-height','200px').css('height','200px')
  $(window).bind('resize load',function(){
		
		if($(window).width()<500){
		$('#header_image').css('margin-bottom','-70px').css('margin-top','-90px')

}
                else
                 $('#header_image').css('margin-bottom','0px').css('margin-top','0px')
		
                })
                
		})


	*/
HERE;
		
		
		if(file_exists(get_stylesheet_directory().'/'.$jaip_filename)){
				
			//do nothing	
				
			}
		else {
		$theme_files=scandir(get_stylesheet_directory());
		
		$jaip_regex='/^js_.*'.$jaip_page_id.'\.(php|js)/';
		
		foreach($theme_files as $theme_file){
			
			
			if(preg_match($jaip_regex,$theme_file)){
				
				$jaip_content=file_get_contents(get_stylesheet_directory().'/'.$theme_file);
				
				
				
					//rename($old_name,$new_name);
				unlink(get_stylesheet_directory().'/'.$theme_file);
				
			}
			 
		}
		
		
		
			
		
		
				
	      file_put_contents(get_stylesheet_directory().'/'.$jaip_filename,$jaip_content);
				
		
		
		}
		
		}
		
		
	}

	 
function jaip_jquery_ui_theme(){
	$jaip_default_style_set=explode("\n",file_get_contents(WP_PLUGIN_DIR.'/jaip-page-style/jaip-style-default-settings.php'));
		$jaip_jq_theme=$jaip_default_style_set[4];
		
		if($jaip_jq_theme=='notheme')
		return false;
        else {
        	$jaip_jq_link='<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/'.$jaip_jq_theme.'/jquery-ui.css" type="text/css" media="all" />';
			echo $jaip_jq_link;
			
        }
	
}
	 
	 

?>