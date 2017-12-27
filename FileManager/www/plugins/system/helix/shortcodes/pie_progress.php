<?php
/**
 * @package Helix Framework
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2013 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/
//no direct accees
defined ('_JEXEC') or die('resticted aceess');
//Add JS file


//[Animated Number]
if(!function_exists('sppie_progress_sc')) {
	function sppie_progress_sc( $atts, $content="" ){
		$pieprogressArray = array();
		extract(shortcode_atts(array(
					'percent' => '',
					'text' => '',
					'info' => '',
					'icon' => '',
					'fgcolor' => '#61a9dc',
					'bgcolor' => '#eee',
					'pie_type' => '', // Half or blank(full)
					
				), $atts));

			Helix::addJS('jquery.circliful.js')->addCSS('jquery.circliful.css');

		ob_start();
	?>
	
	
	<div class="sp_piechart" data-dimension="200" data-type="<?php echo $pie_type; ?>" data-icon="<?php echo $icon; ?>" data-text="&nbsp;<?php echo $text; ?>" data-info="<?php echo $info; ?>" data-width="8" data-fontsize="38" data-percent="<?php echo $percent; ?>" data-fgcolor="<?php echo $fgcolor; ?>" data-bgcolor="<?php echo $bgcolor; ?>" ></div>
	
	<style type="text/css">
	.sp_piechart{
		display: inline-block;
	}
	</style>
	<?php 

		return ob_get_clean();
	}
	add_shortcode( 'pie_progress', 'sppie_progress_sc' );
}