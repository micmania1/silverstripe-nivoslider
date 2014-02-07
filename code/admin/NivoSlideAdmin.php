<?php

/**
 * Admin interface to manage sliders
 *
 * @package silverstripe
 * @subpackage nivoslider
**/
class NivoSlideAdmin extends ModelAdmin {

	private static $url_segment = "nivo-slides";
	
	private static $menu_title = "Nivo Slides";
	
	private static $menu_icon = "silverstripe-nivoslider/images/icons/slides-16x16.png";
	
	private static $managed_models = array(
		"NivoSlider",
	);

}
