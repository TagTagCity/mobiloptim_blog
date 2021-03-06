<?php
/*
Plugin Name: Resize Image After Upload
Plugin URI: https://wordpress.org/plugins/resize-image-after-upload/
Description: Simple plugin to automatically resize uploaded images to within specified maximum width and height. Also has option to force recompression of JPEGs. Configuration options found under <a href="options-general.php?page=resize-after-upload">Settings > Resize Image Upload</a>
Author: iamphilrae
Version: 1.6.1
Author URI: http://www.philr.ae/

Copyright (C) 2014 JEPSONRAE Ltd
  

Includes hints and code by:
	Huiz.net (www.huiz.net)
  Jacob Wyke (www.redvodkajelly.com)
  Paolo Tresso / Pixline (http://pixline.net)  

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

$PLUGIN_VERSION = '1.6.1';
$DEBUG_LOGGER = false;


// Default plugin values
if(get_option('jr_resizeupload_version') != $PLUGIN_VERSION) {

  add_option('jr_resizeupload_version', 			$PLUGIN_VERSION, '','yes');
  add_option('jr_resizeupload_width', 				'1200', '', 'yes');
  add_option('jr_resizeupload_height',				'1200', '', 'yes');
  add_option('jr_resizeupload_quality',				'90', '', 'yes');
  add_option('jr_resizeupload_resize_yesno', 		'yes', '','yes');
  add_option('jr_resizeupload_recompress_yesno', 	'no', '','yes');
  add_option('jr_resizeupload_convertbmp_yesno', 	'no', '', 'yes');
  add_option('jr_resizeupload_convertpng_yesno', 	'no', '', 'yes');
  add_option('jr_resizeupload_convertgif_yesno', 	'no', '', 'yes');
}



// Hook in the options page
add_action('admin_menu', 'jr_uploadresize_options_page');  

// Hook the function to the upload handler
add_action('wp_handle_upload', 'jr_uploadresize_resize');



  
/**
* Add the options page
*/
function jr_uploadresize_options_page(){
	if(function_exists('add_options_page')){
		add_options_page(
			'Resize Image After Upload', 
			'Resize Image Upload', 
			'manage_options', 
			'resize-after-upload', 
			'jr_uploadresize_options'
		);
	} 
} // function jr_uploadresize_options_page(){ 



/** 
* Define the Options page for the plugin
*/
function jr_uploadresize_options(){

  if(isset($_POST['jr_options_update'])) {
  
    $resizing_enabled = trim(esc_sql($_POST['yesno']));
    $force_jpeg_recompression   = trim(esc_sql($_POST['recompress_yesno']));
    
    $max_width   = trim(esc_sql($_POST['maxwidth']));
    $max_height  = trim(esc_sql($_POST['maxheight']));
    $compression_level    = trim(esc_sql($_POST['quality']));
    
    $convert_png_to_jpg = trim(esc_sql($_POST['convertpng']));
    $convert_gif_to_jpg = trim(esc_sql($_POST['convertgif']));
    $convert_bmp_to_jpg = trim(esc_sql($_POST['convertbmp']));
    
    
    // If input is not an integer, use previous setting
    $max_width = ($max_width == '') ? 0 : $max_width;
    $max_width = (ctype_digit(strval($max_width)) == false) ? get_option('jr_resizeupload_width') : $max_width;
    update_option('jr_resizeupload_width',$max_width);


    $max_height = ($max_height == '') ? 0 : $max_height;
    $max_height = (ctype_digit(strval($max_height)) == false) ? get_option('jr_resizeupload_height') : $max_height;
    update_option('jr_resizeupload_height',$max_height);
        

    $compression_level = ($compression_level == '') ? 1 : $compression_level;
    $compression_level = (ctype_digit(strval($compression_level)) == false) ? get_option('jr_resizeupload_quality') : $compression_level;
        
    if($compression_level <= 0) {
    	$compression_level = 1; 
    }
    else if($compression_level >= 100) {
    	$compression_level = 99; 
    }
    
    update_option('jr_resizeupload_quality',$compression_level);

  
    
    
    if ($resizing_enabled == 'yes') {
      update_option('jr_resizeupload_resize_yesno','yes'); } 
    else {
      update_option('jr_resizeupload_resize_yesno','no'); }
    
    
    if ($force_jpeg_recompression == 'yes') {
      update_option('jr_resizeupload_recompress_yesno','yes'); }
    else {
      update_option('jr_resizeupload_recompress_yesno','no'); }
    
    
    if ($convert_png_to_jpg == 'yes') {
      update_option('jr_resizeupload_convertpng_yesno','yes'); }
    else {
      update_option('jr_resizeupload_convertpng_yesno','no'); }
      
    if ($convert_gif_to_jpg == 'yes') {
      update_option('jr_resizeupload_convertgif_yesno','yes'); }
    else {
      update_option('jr_resizeupload_convertgif_yesno','no'); }
    
    if ($convert_bmp_to_jpg == 'yes') {
      update_option('jr_resizeupload_convertbmp_yesno','yes'); }
    else {
      update_option('jr_resizeupload_convertbmp_yesno','no'); }
    
    

    echo('<div id="message" class="updated fade"><p><strong>Options have been updated.</strong></p></div>');
  } // if



  // get options and show settings form
  $resizing_enabled = get_option('jr_resizeupload_resize_yesno');
  $force_jpeg_recompression = get_option('jr_resizeupload_recompress_yesno');
  $compression_level  = intval(get_option('jr_resizeupload_quality'));
  
  $max_width     = get_option('jr_resizeupload_width');
  $max_height    = get_option('jr_resizeupload_height');
  
  $convert_png_to_jpg = get_option('jr_resizeupload_convertpng_yesno');
  $convert_gif_to_jpg = get_option('jr_resizeupload_convertgif_yesno');
  $convert_bmp_to_jpg = get_option('jr_resizeupload_convertbmp_yesno');
?>
<style type="text/css">
.resizeimage-button {
  color: #FFF;
  background: none repeat scroll 0% 0% #FC9A24;
  border-radius: 3px;
  display: inline-block;
  border-bottom: 4px solid #EC8A14;
  margin-right:5px;
  line-height:1.05em;
  text-align: center;
  text-decoration: none;
  padding: 9px 20px 8px;
  font-size: 15px;
  font-weight: bold;
  text-shadow: 0 -1px 1px rgba(0,0,0,0.2);
}

.resizeimage-button:active,
.resizeimage-button:hover,
.resizeimage-button:focus {
  background-color: #EC8A14;
  color: #FFF;
}

.media-upload-form div.error, .wrap div.error, .wrap div.updated {
  margin: 25px 0px 25px;
}

</style>

<div class="wrap">
	<form method="post" accept-charset="utf-8">

		<h2><img src="<?php echo plugins_url('icon-128x128.png', __FILE__ ); ?>" style="float:right; border:1px solid #ddd;margin:0 0 15px 15px;width:100px; height:100px;" />Resize Image After Upload</h2>
		
		<div style="max-width:700px">
  		<p>This plugin automatically resizes uploaded images (JPEG, GIF, and PNG) to within a given maximum width and/or height to reduce server space usage. This may be necessary due to the fact that images from digital cameras and smartphones can now be over 10MB each due to higher megapixel counts.</p>
  
  		<p>In addition, the plugin can force re-compression of uploaded JPEG images, regardless of whether they are resized or not; and convert uploaded GIF and PNG images into JPEG format.</p>
  
  		<p><strong>Note:</strong> the resizing/recompression process will discard the original uploaded file including EXIF data.</p>
  
  		<p>This plugin is not intended to replace the WordPress <em>add_image_size()</em> function, but rather complement it. Use this plugin to ensure that no excessively large images are stored on your server, then use <em>add_image_size()</em> to create versions of the images suitable for positioning in your website theme.</p>
  
  		<p>This plugin uses standard PHP image resizing functions and will require a high amount of memory (RAM) to be allocated to PHP in your php.ini file (e.g 512MB).</p>
  		
  		<h4 style="font-size: 15px;font-weight: bold;margin: 2em 0 0;">Like the plugin?</h4>
  		
  		<p>This plugin was written and is maintained for free (as in free beer) by me, <a href="http://philr.ae" target="_blank">Phil Rae</a>. If you find it useful please consider donating some small change or bitcoins to my beer fund because beer is very seldom free. Thanks!</p>
  		
  		<p style="padding-bottom:2em;" class="resizeimage-button-wrapper">
  		
  		  <a class="resizeimage-button" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=3W4M254AA3KZG" target="_blank">Donate cash</a>
  				
        <a class="resizeimage-button coinbase-button" data-code="9584265cb76df0b1e99979163de143f5" data-button-style="custom_small" target="_blank" href="https://coinbase.com/checkouts/9584265cb76df0b1e99979163de143f5">Donate bitcoins</a>

  		</p>
 		</div>

		<hr style="margin-top:20px; margin-bottom:0;">
		<hr style="margin-top:1px; margin-bottom:40px;">

		<h3>Re-sizing options</h3>
		<table class="form-table">
			<tr>
				<th scope="row">Enable re-sizing</th>
				<td valign="top">
					<select name="yesno" id="yesno">  
						<option value="no" label="no" <?php echo ($resizing_enabled == 'no') ? 'selected="selected"' : ''; ?>>NO - do not resize images</option>
						<option value="yes" label="yes" <?php echo ($resizing_enabled == 'yes') ? 'selected="selected"' : ''; ?>>YES - resize large images</option>
					</select>
				</td>
			</tr>

			<tr>
				<th scope="row">Max image dimensions</th>
				
				<td>
					<fieldset><legend class="screen-reader-text"><span>Maximum width and height</span></legend>
						<label for="maxwidth">Max width</label>
						<input name="maxwidth" step="1" min="0" id="maxwidth" class="small-text" type="number" value="<?php echo $max_width; ?>">
						&nbsp;&nbsp;&nbsp;<label for="maxheight">Max height</label>
						<input name="maxheight" step="1" min="0" id="maxheight" class="small-text" type="number" value="<?php echo $max_height; ?>">
						<p class="description">Set to zero or very high value to prevent resizing in that dimension.
						<br />Recommended values: <code>1200</code></p>
					</fieldset>
				</td>

			
			</tr>

		</table>
		
		<hr style="margin-top:20px; margin-bottom:30px;">
		
		<h3>Compression options</h3>
		<p style="max-width:700px">The following settings will only apply to uploaded JPEG images and images converted to JPEG format.</p>
		
		<table class="form-table">
			
			<tr>
				<th scope="row">JPEG compression level</th>
				<td valign="top">
					<select id="quality" name="quality">
					<?php for($i=1; $i<=99; $i++) : ?>
						<option value="<?php echo $i; ?>" <?php if($compression_level == $i) : ?>selected<?php endif; ?>><?php echo $i; ?></option>
					<?php endfor; ?>
					</select>
					<p class="description"><code>1</code> = low quality (smallest files)
					<br><code>99</code> = best quality (largest files)
					<br>Recommended value: <code>90</code></p>
				</td>
			</tr>
			
			<tr>
				<th scope="row">Force JPEG re-compression</th>
				<td>
					<select name="recompress_yesno" id="yesno">  
						<option value="no" label="no" <?php echo ($force_jpeg_recompression == 'no') ? 'selected="selected"' : ''; ?>>NO - only re-compress resized jpeg images</option>
						<option value="yes" label="yes" <?php echo ($force_jpeg_recompression == 'yes') ? 'selected="selected"' : ''; ?>>YES - re-compress all uploaded jpeg images</option>
					</select>
				</td>
			</tr>
			
		</table>
		
		<?php /* DEFINED HERE FOR FUTURE RELEASE
		<hr style="margin-top:20px; margin-bottom:20px;">
		
		<h3>Image conversion options</h3>
		<p style="max-width:700px">Photos saved as PNG and GIF images can be extremely large in file size due to their compression methods not being suited for photos. Enable these options below to automatically convert GIF and/or PNG images to JPEG.</p>
		
		<p>When enabled, conversion will happen to all uploaded GIF/PNG images, not just ones that require resizing.</p>
		
		<table class="form-table">
			
			<tr>
				<th scope="row">Convert GIF to JPEG</th>
				<td>
					<select id="convert-gif" name="convertgif">
						<option value="no" <?php if($convert_gif_to_jpg == 'no') : ?>selected<?php endif; ?>>NO - just resize uploaded gif images as normal</option>
						<option value="yes" <?php if($convert_gif_to_jpg == 'yes') : ?>selected<?php endif; ?>>YES - convert all uploaded gif images to jpeg</option>
					</select>
				</td>
			</tr>
			   
			<tr>
				<th scope="row">Convert PNG to JPEG</th>
				<td>
					<select id="convert-png" name="convertpng">
						<option value="no" <?php if($convert_png_to_jpg == 'no') : ?>selected<?php endif; ?>>NO - just resize uploaded png images as normal</option>
						<option value="yes" <?php if($convert_png_to_jpg == 'yes') : ?>selected<?php endif; ?>>YES - convert all uploaded png images to jpeg</option>
					</select>
				</td>
			</tr>
			
		</table>
		*/ ?>
		
		<hr style="margin-top:30px;">

		<p class="submit" style="margin-top:10px;border-top:1px solid #eee;padding-top:20px;">
		  <input type="hidden" id="convert-bmp" name="convertbmp" value="no" />
		  <input type="hidden" name="action" value="update" />  
		  <input id="submit" name="jr_options_update" class="button button-primary" type="submit" value="Update Options">
		</p>
	</form>

</div>
<?php
} // function jr_uploadresize_options(){





/**
* This function will apply changes to the uploaded file 
* @param $image_data - contains file, url, type
*/
function jr_uploadresize_resize($image_data){ 

  global $DEBUG_LOGGER;

  if(
  	$image_data['type'] == 'image/jpeg' || 
  	$image_data['type'] == 'image/jpg' || 
  	$image_data['type'] == 'image/gif' || 
  	$image_data['type'] == 'image/png' || 
   	$image_data['type'] == 'image/bmp'
  )	
  {

    // Include the file to carry out the resizing
    require_once('class.resize.php');

    
    $resizing_enabled = get_option('jr_resizeupload_resize_yesno');
		$resizing_enabled = ($resizing_enabled=='yes') ? true : false;

    $force_jpeg_recompression = get_option('jr_resizeupload_recompress_yesno');
		$force_jpeg_recompression = ($force_jpeg_recompression=='yes') ? true : false;    
    
    $compression_level = get_option('jr_resizeupload_quality');
		
		
    $max_width  = get_option('jr_resizeupload_width')==0 
      ? false : get_option('jr_resizeupload_width');
      
    $max_height = get_option('jr_resizeupload_height')==0 
      ? false : get_option('jr_resizeupload_height');

		    
    $convert_png_to_jpg = get_option('jr_resizeupload_convertpng_yesno');
		$convert_png_to_jpg = ($convert_png_to_jpg=='yes') ? true : false;
		
    $convert_gif_to_jpg = get_option('jr_resizeupload_convertgif_yesno');
		$convert_gif_to_jpg = ($convert_gif_to_jpg=='yes') ? true : false;
    
    $convert_bmp_to_jpg = get_option('jr_resizeupload_convertbmp_yesno');
		$convert_bmp_to_jpg = ($convert_bmp_to_jpg=='yes') ? true : false;


		// Get original image sizes
    $original_info = getimagesize($image_data['file']);
    $original_width = $original_info[0];
    $original_height = $original_info[1];
    
    $original_is_jpg = false;
    $original_is_png = false;
    $original_is_gif = false;
    $original_is_bmp = false;
    
    switch($image_data['type']) {
      
      case 'image/jpg'  :
      case 'image/jpeg' : $original_is_jpg = true; break;
      
      case 'image/png'  : $original_is_png = true; break;
      
      case 'image/gif'  : $original_is_gif = true; break;
      
      case 'image/bmp'  : $original_is_bmp = true; break;
      
    }
    

if($DEBUG_LOGGER) error_log('LOG: '.print_r('upload-start', true));				


		// 
		// Perform resizing operations if reduction is required
		if(
		  $resizing_enabled 
		  && ($max_width || $max_height) // resize in at least one dimension
		  && (
		    ($max_width && ($original_width > $max_width)) // width possibly needs resizing
		    || 
		    ($max_height && ($original_height > $max_height)) // height possibly needs resizing
		  )
		  && !$original_is_bmp) // plugin does not work with bitmaps
		{

      if($DEBUG_LOGGER) error_log('LOG: '.print_r('--resizing', true));
		  
		  $protect_image = true;
		  $resize_direction = null;
		  $resize_max = null;


      // Width is unlimited, limit by height
      if((!$max_width && $max_height) 
        && ($original_height > $max_height)) { 
        
        $resize_direction = 'H';
        $resize_max = $max_height;
        if($DEBUG_LOGGER) error_log('LOG: '.print_r(' >--by-height (width-unlimited)', true));
      }
      
      // Height is unlimited, limit by width
      else if((!$max_height && $max_width) 
        && ($original_width > $max_width)) {
        
        $resize_direction = 'W';
        $resize_max = $max_width;
        
        if($DEBUG_LOGGER) error_log('LOG: '.print_r(' >--by-width (height-unlimited)', true));
      }
      
      // Both dimensions require limiting, figure out which
      else {
        
        if(($original_height/$max_height) > ($original_width/$max_width)) {
          $resize_direction = 'H';
          $resize_max = $max_height;
          if($DEBUG_LOGGER) error_log('LOG: '.print_r(' >--by-height', true));
        }
        
        else {
          $resize_direction = 'W';
          $resize_max = $max_width;
          if($DEBUG_LOGGER) error_log('LOG: '.print_r(' >--by-width', true));
        }
      }

		  if(!is_null($resize_direction) && !is_null($resize_max)) {
		  
        $objResize = new RVJ_ImageResize(
          $image_data['file'], $image_data['file'], 
          $resize_direction, $resize_max, 
          $protect_image, $compression_level
        );
        
        
        if($DEBUG_LOGGER) error_log('LOG: '.print_r(' >--resize-done', true));
      }
    }  
		
		
		//
		// Resizing is not required, but still need to re-compress to desired quality and filetype
		else if(($original_is_jpg && $force_jpeg_recompression)
		  || ($original_is_png && $convert_png_to_jpg)
		  || ($original_is_gif && $convert_gif_to_jpg) 
		  || ($original_is_bmp && $convert_bmp_to_jpg)) {
		  
		  $protect_image = false;
		  
			$objResize = new RVJ_ImageResize($image_data['file'], $image_data['file'], 'P', 100, $protect_image, $compression_level);
			
			if($DEBUG_LOGGER) error_log('LOG: '.print_r('--recompression/conversion', true));
		}
		
		
		//
		// No resizing, recompression, or conversion required
		else {
      if($DEBUG_LOGGER) error_log('LOG: '.print_r('--no-action-required', true));
		}

    if($DEBUG_LOGGER) error_log('LOG: '.print_r("end\n", true));
		
  } // if(...) 
  
  return $image_data;
} // function jr_uploadresize_resize($image_data){ 