    
    <style>
    	input.pagetitle {
    		font-weight:bold;
    		width:200px;
    	}
    	input.mediasrc {
    		
    		width:500px;
    		font-family:book antiqua;
    	}
    	
    	th {
    		text-align:left;
    		font-size:110%
    	}
   
        #header_image {
        	margin:50px 0px 0px 50px;
        	padding:10px;
        	border:1px black solid;
        	background:#EBEBEB;
        	width:800px;
        	height:auto;
        	
        }
        #page_style_sheets,#page_js_file,#add-jquery-ui-theme {
        	margin:50px 0px 0px 50px;
        	
        	padding:10px 5px 10px 10px;
        	border:1px black solid;
        	background:#EBEBEB;
        	width:400px;
        	height:auto;
        	
        	
        }
        .green {
        	background:#00FF00;
        	width:250px;
        	background:#006505;
        	font-weight:bold;
        	padding:10px;
        	color:white;
        	border:1px #669900 solid;
        	text-align:center;
        	font-size:120%;
        	margin-left:50px;
        	 border-radius: 5px;

-moz-border-radius: 5px;
        }
        
 #page_style_sheets,#header_image {
        border-radius: 7px;

-moz-border-radius: 7px;


	
        }
        
        .save {
        	
        	margin-top:10px;
        	padding:4px 9px 5px 10px;
        	font-family:bookman;
        	font-size:150%;
        	

        	
        }
   #header_image_table input {
   	padding:5px ;
   }
   
   #respons {
   	position:relative;
   	left:530px;
   	top:-560px;
   	width:350px;
   	display:none;
   }
   .jq_st_theme {
   	margin-right:7px;
   	font-family:Georgia;
   	/*font-style:italic;*/
   	cursor:pointer;
   	font-size:90%;
   	color:#515151;
   	float:left;
   }
   .jq_st_theme:hover {
   		color:#000000
   }
   .jq_st_theme:nth-child(odd){
   		color:#4D0000

   }
   .jq_st_theme:nth-child(odd):hover{
   		color:#000000
   }
    </style>
    
    
     
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/trontastic/jquery-ui.css" type="text/css" media="all" />

    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

		<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>

        <script>
        $(document).ready(function(){
        	
        	
        	$.ajaxSetup({async:false});
        	$('table input,#add_page,#remove_page,.jq_st_theme').bind('mousedown keydown',function(){
        		$('#respons').hide('fade',700);
        	})
        	
        	$('#add_page,#remove_page').button().css('padding','2px 7px 5px 7px');
        	$('#add_page,#remove_page,#save_header_image,#save_style_settings').css('cursor','pointer');
        	$('#add_page').click(function(){
        		
        		     		var new_page='<tr><td><input class=pagetitle value="" >  </td><td><input class=mediasrc value="" > </td></tr>'
        	
        	$('#header_image_table').append(new_page);
        	})
        	$('#remove_page').click(function(){
        		
        		     		$('#header_image_table tr').last().remove();
        	})
        	
        	
        	$('.save').click(function(e){
        	
        		$('#header_image_table input.pagetitle').each(function(){
        			$(this).parent().siblings('td').children('.mediasrc').attr('name',$(this).val())
        		
        		
        		})
        		jaip_media_src=$('#header_image_table input.mediasrc').serialize();
        		  		add_sheet_default=$('.page_style_sheets_table input').serialize();
        		  		jaip_jq_theme=$('#jaip_jq_theme').val();
        		
        		
        		
        	
        		
        		
        		
        		
        		jaip_update_url="<?php echo WP_PLUGIN_URL?>/jaip-page-style/jaip-update-style-settings.php" 
       		
   $.post(jaip_update_url, {mediasrc: jaip_media_src, addsheetdefault: add_sheet_default, jqtheme:jaip_jq_theme},  function(data) {
    
  
    $("#respons").css('top',-900-$('#header_image').height()+e.pageY)
    $("#respons").html(data);
    $("#respons").show('fade',700)
   
    
   
  })
             		
        	})
        	
        	
        $('.jq_st_theme').click(function(){
        	$('#jaip_jq_theme').val($(this).text())
        	jq_theme_image='http://jqueryui.com/themeroller/images/themeGallery/theme_90_'+$(this).text().replace(/-/,'_').replace(/ui_darkness/,'ui_dark').replace(/ui_lightness/,'ui_light').replace(/vader/,'black_matte').replace(/mint_choc/,'mint_choco').replace(/start/,'start_menu').replace(/redmond/,'windoze')+'.png'
        	$('#jq_theme_image').attr('src',jq_theme_image)
        })
        
       var jq_theme_image='http://jqueryui.com/themeroller/images/themeGallery/theme_90_'+$('#jaip_jq_theme').val().replace(/-/,'_').replace(/ui_darkness/,'ui_dark').replace(/ui_lightness/,'ui_light').replace(/vader/,'black_matte').replace(/mint_choc/,'mint_choco').replace(/start/,'start_menu').replace(/redmond/,'windoze')+'.png'
        	$('#jq_theme_image').attr('src',jq_theme_image)
        })
   </script>
		
		<div class='wrap'>
		<?php  screen_icon('plugins'); ?>
		<h2>Jaip Page style</h2>
		
		<div id=header_image>
		<h3>Header Image or Flash</h3>
		<button id=add_page>Add page</button><button id=remove_page>Remove page</button>
		</br></br>
		<form method=post action="" >
			<table id=header_image_table>
				<tr><th>Page/post Title</th><th>Media URL</th></tr>
		<?php 
		include(WP_PLUGIN_DIR.'/jaip-page-style/jaip-header-image-array.php');
		
		foreach($jaip_image_array as $jaip_title=>$jaip_src){
		
		?>	
		<tr><td><input class=pagetitle value="<?php echo trim($jaip_title) ?> " >  </td><td><input class=mediasrc value="<?php echo trim($jaip_src) ?> " > </td></tr>
		
		<?php } ?>
		    
		</table>	
		</form>
		
		<button class='save' id=save_header_image>Save</button>
		<p style="font-size:90%;font-style:italic">All pages without key will use value of <b>'default'</b> key </p>	
		<p style="font-size:90%;font-style:italic">The <b>'Home'</b> key always refers to frontpage no matter the title. Can be replaced by actual title</p>	
		</div>
		<div id=page_style_sheets> 
			<h3>Individual Page style Sheets</h3>
			<table class=page_style_sheets_table>
			<form method=post action="" >
				<?php $jaip_checkbox_checked=explode("\n",file_get_contents(WP_PLUGIN_DIR.'/jaip-page-style/jaip-style-default-settings.php')); ?>
			<tr><td><input <?php echo $jaip_checkbox_checked[0] ?> type="checkbox" name="page_default" value="true" /> Make a stylesheet for pages *)</td></tr>
           <tr><td>  <input <?php echo $jaip_checkbox_checked[1] ?> type="checkbox" name="post_default" value="true" /> Make a stylesheet for posts *)</td></tr>
				
		</table>	
		</form>
		<button  class='save' id=save_style_settings>Save</button>
		<p style="font-size:90%;font-style:italic">*) A stylesheet will be made when updating the page or post</p>	
		</div>
		<div id=page_js_file> 
			<h3>Individual Page javascript</h3>
			<table class=page_style_sheets_table>
			<form method=post action="" >
				<?php $jaip_checkbox_checked=explode("\n",file_get_contents(WP_PLUGIN_DIR.'/jaip-page-style/jaip-style-default-settings.php')); ?>
			<tr><td><input <?php echo $jaip_checkbox_checked[2] ?> type="checkbox" name="js_page_default" value="true" /> Make a javascript file for pages *)</td></tr>
           <tr><td>  <input <?php echo $jaip_checkbox_checked[3] ?> type="checkbox" name="js_post_default" value="true" /> Make a javascript file for posts *)</td></tr>
			 	
		</table>	
		</form>
		<button  class='save' id=save_style_settings>Save</button>
		<p style="font-size:90%;font-style:italic">*) A javascript file will be made when updating the page or post</p>	
		</div>
		<div id=add-jquery-ui-theme> 
			<h3>jQuery-ui Theme</h3>
			<table >
			<form method=post action="" >
			 <?php $jaip_checkbox_checked=explode("\n",file_get_contents(WP_PLUGIN_DIR.'/jaip-page-style/jaip-style-default-settings.php')); ?>
			 <tr><td>  <input  id=jaip_jq_theme type=text name="jaip_jq_theme" <?php echo 'value='.$jaip_checkbox_checked[4] ?> /> </td><td  ><img id=jq_theme_image img src='' width=60 height=60 /></td></tr>
			
			<tr><td>  <span class=jq_st_theme>notheme</span>  <span class=jq_st_theme>black-tie</span><span class=jq_st_theme>blitzer</span><span class=jq_st_theme>cupertino</span><span class=jq_st_theme>dark-hive</span>
				<span class=jq_st_theme>eggplant</span><span class=jq_st_theme>dot-luv</span><span class=jq_st_theme>excite-bike</span><span class=jq_st_theme>flick</span>
				<span class=jq_st_theme>hot-sneaks</span><span class=jq_st_theme>humanity</span><span class=jq_st_theme>le-frog</span><span class=jq_st_theme>mint-choc</span>
				<span class=jq_st_theme>pepper-grinder</span><span class=jq_st_theme>overcast</span><span class=jq_st_theme>redmond</span><span class=jq_st_theme>smoothness</span>
				<span class=jq_st_theme>start</span><span class=jq_st_theme>sunny</span><span class=jq_st_theme>trontastic</span><span class=jq_st_theme>swanky-purse</span>
				<span class=jq_st_theme>south-street</span><span class=jq_st_theme>ui-darkness</span><span class=jq_st_theme>ui-lightness</span><span class=jq_st_theme>vader</span>
				
				</td></tr>	
		   
		</table>	
		</form>
		<button  class='save' id=save_style_settings>Save</button>
		<p style="font-size:90%;font-style:italic"></p>	
		</div>
        </div>
        
        <div id=respons  >oi ih ih </div>
        
        
        
