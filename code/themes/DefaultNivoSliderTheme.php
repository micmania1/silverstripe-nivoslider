<?php

/**
 * The default theme for the Nivo Slider
 *
 * @package silverstripe
 * @subpackage nivoslider
**/
class DefaultNivoSliderTheme extends NivoSliderTheme {
	
	/** 
	 * Set the default title
	 *
	 * @var string
	**/
	public $title = "Default Theme";
	
	/**
	 * Default CSS Class
	 *
	 * @var string CSS Class
	**/
	public $cssClass = "theme-default";
	
	
	public function beforeRender() {
		Requirements::css(NivoSlider::get_module_folder() . "/themes/default/default.css");
	}
	
}
