<?php 
/*------------------------------------------------------------------------
# mod_jo_k2_slideshow - JO k2 slide show item for Joomla 1.6, 1.7, 2.5 Module
# -----------------------------------------------------------------------
# author: http://www.joomcore.com
# copyright Copyright (C) 2011 Joomcore.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomcore.com
# Technical Support:  Forum - http://www.joomcore.com/Support
-------------------------------------------------------------------------*/
defined('_JEXEC') or die('Restricted access'); 
JHtml::_('behavior.framework', true);
$js_jquery=JUri::root()."modules/mod_jo_k2_slideshow/js/jquery.js";
$js_easing=JUri::root()."modules/mod_jo_k2_slideshow/js/jquery.easing.js";
$js_script=JUri::root()."modules/mod_jo_k2_slideshow/js/script.js";
?>
<?php 
if($params->get("loadjquery")==1){
?>
	<script type="text/javascript" src="<?php echo $js_jquery?>"></script>
<?php 
}
?>
<script type="text/javascript" src="<?php echo $js_easing?>"></script>
<script type="text/javascript" src="<?php echo $js_script?>"></script>

<script type="text/javascript">
JoK2Slide = jQuery.noConflict();
JoK2Slide(document).ready( function($){	
		$('#jo-k2-slide45').JoK2Slideshow( {
			mainWidth			: <?php echo intval($params->get('modwidth'))?>, 
			interval	  	 	: <?php echo $params->get('interval'); ?>,
			maxItemDisplay	 	: <?php echo $params->get('maxitem'); ?>,
			navigatorHeight		: <?php echo intval($params->get('modheight')/$params->get('maxitem')); ?>,
			navigatorWidth		: <?php echo $params->get('itemwidth'); ?>,
		 	easing:'<?php echo $params->get("easing_type");?>',
			duration:1200,
			auto:<?php echo $params->get('auto_start');?> } );				
			
			$('.jo_slider_title').css('color', '#<?php echo $params->get("overlay_link_color"); ?>');
			$('.jo-k2-navigator li td p').css('color', '#<?php echo $params->get("overlay_introtext_color"); ?>');
			
			$('.jo-k2-main-item-desc h3 a').css('color', '#<?php echo $params->get("overlay_heading_color"); ?>');
			$('.jo-k2-main-item-desc h3 span').css({
				color: '#<?php echo $params->get("overlay_heading_color"); ?>',
				marginleft: '5px'
			});
			
			$('.jo-k2-readmore').css('color', '#<?php echo $params->get("overlay_heading_color"); ?>')	;
			
			$('.jo-k2-main-item-desc p').css({
				color: '#<?php echo $params->get("overlay_text_color"); ?>',
				fontsize: '<?php echo $params->get("overlay_font_size"); ?>'
			})	;
			
			$('.jo-k2-main-item-desc').css({
				width: '<?php echo $params->get("overlay_width"); ?>px', 
				background: '#<?php echo $params->get("overlay_color"); ?>',
				height: '<?php echo $params->get("overlay_height"); ?>px',
				opacity:  '<?php echo $params->get("overlay_opacity"); ?>',
				<?php echo $params->get("overlay_position"); ?>:  '0px'

			});
			
			
			position = '<?php echo $params->get("left_right"); ?>';
			if (position == 'left'){
				$('.jo-k2-main-wapper li img').css('float',  'right');
				$('.jo-k2-main-item-desc').css('right', '0px');
			} else {
				$('.jo-k2-main-item-desc').css('left', '0px');
				$('.jo-k2-main-wapper li img').css('float',  'left');
			}
		});

</script>

<div id="jo-k2-slide45" class="jo-k2-slidecontent  jo-k2-snleft <?php echo $params->get('moduleclass_sfx');?>" style="width:<?php echo $params->get('modwidth')?>px ; height:<?php echo $params->get('modheight')?>px ;">
<div class="preload"><div></div></div>
 <!-- MAIN CONTENT --> 
  <div class="jo-k2-main-outer" style="width:<?php echo intval($params->get('modwidth'))?>px ; height:<?php echo $params->get('modheight')-1;?>px ;">
  	<ul class="jo-k2-main-wapper" style="height:<?php echo $params->get('modheight')-1;?>px ;">
  		<?php foreach ($list as $item) :  ?>
  		<li style="width:<?php echo intval($params->get('modwidth'))?>px; overflow:hidden; position:relative;">
        		<?php if(!empty($item->im)){?>
					<img src="<?php echo $item->im;?>" alt="I<?php echo $item->title; ?>" > 
				<?php }else{?>
					<img src="<?php echo $params->get('imagedefault');?>" title="Image default" >
				<?php }?>
						      
                 <div class="jo-k2-main-item-desc">
	                <h3 class="jo-slider_color_title">
      			<?php if($params->get('showlink')==1){?>
						<a href="<?php echo $item->link?>" ><?php echo $item->title?></a><br/>
					<?php }else{?>
						<span><?php echo $item->title;?></span><br/>
					<?php }?>	
	                </h3>
	                <p><?php echo $item->detailshort;?>...<?php echo $item->readmore;?></p>
	            </div>
        	</li> 
     	<?php endforeach ?>
      </ul>  	
  </div>
 
  <!-- END MAIN CONTENT --> 
    <!-- NAVIGATOR -->

  <div class="jo-k2-navigator-outer">
  		<ul class="jo-k2-navigator">
  			<?php foreach ($list as $item1) :  ?>
            <li>
            	<div>
				   		<table style="border: 0 none; padding: 0; margin:0;" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%"><tr><td>
						<?php 
								echo $item1->images
		   					?>
					   		   	
							<h3 class="jo_slider_title"> <?php echo $item1->title;	?> </h3>
					         <?php echo '<p>'.$item1->introtext.'</p>';?>
					      </td></tr></table>
					   </div>   
            </li>	
              <?php endforeach ?> 			
        </ul>
  </div>
 </div> 
  