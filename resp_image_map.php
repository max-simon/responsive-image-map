<?php
/*
Plugin Name: Responsive Image Map
Plugin URI:  https://github.com/max-simon
Description: This adds support for responsive image maps
Version:     20180310
Author:      Max Simon
Author URI:  https://facebook.com/maxsimon
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

function rim_creator($attr) {
  $param = shortcode_atts( array('id' => '', 'width' => 1920, 'height' => 1080, 'base' => '', 'coords' =>  '', 'pics' => ''), $attr);

  if(!$param['id']) {
    return '';
  }

  if(!$param['coords']) {
    return '';
  }
  $coords_without_ws = preg_replace('/s*\;\s*/', ';', filter_var($param['coords'], FILTER_SANITIZE_STRING));
  $coords = explode(';', $coords_without_ws);

  if(!$param['pics']) {
    return '';
  }
  $pics_without_ws = preg_replace('/s*\;\s*/', ';', filter_var($param['pics'], FILTER_SANITIZE_STRING));
  $pics = explode(';', $pics_without_ws);

  $overlays = "";
  foreach($pics as $key => $value) {
    $overlays .= "<div class='pic-container overlay' id='rim-".$param["id"]."-".$key."'>
      <img src='".$value."'/>
    </div>";
  }

  $map = "<map name='rim-".$param["id"]."-map' id='rim-".$param["id"]."-map'>";
  foreach($coords as $key => $value) {
    $map .= "<area data-rim-id='".$param["id"]."' data-pic-id='".$key."' shape='rect' coords='".$value."'>";
  }

  $padding = 100*$param["height"]/$param["width"];
  return "<div class='resp-img-map-container' data-rim-id='".$param["id"]."' style='padding-bottom: ".$padding."%'>
    <div class='pic-container'>
      <img src='".$param["base"]."'/>
    </div>
    ".$overlays."
    <div class='pic-container' style='opacity: 0'>
      <img width='".$param["width"]."' height='".$param["height"]."' src='".$param["base"]."' usemap='#rim-".$param["id"]."-map'/>
    </div>
    ".$map."
    </div>
  ";

}

add_shortcode( 'resp_image_map', 'rim_creator' );

function rim_init() {
  if (!is_admin()) {
     $base_url = plugins_url().'/responsive_image_map';
     wp_enqueue_style('rim_css', $base_url.'/styling.css');
     wp_enqueue_script('rim_resp_js', $base_url.'/jquery.rwdImageMaps.min.js', array('jquery'), true);
     wp_enqueue_script('rim_code_js', $base_url.'/code.js', array('rim_resp_js'), true);
   }
}
add_action('init', 'rim_init');


?>
