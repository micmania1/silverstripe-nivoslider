<?php

/**
 * Dark Nivo theme.
 *
 * @package silverstripe
 * @subpackage nivoslider
**/
class DarkNivoSliderTheme extends NivoSliderTheme {

	protected $title = "Dark Theme";
	
	protected $cssClass = "theme-dark";
	
	public function beforeRender() {
		Requirements::css(NivoSlider::get_module_folder() . '/themes/dark/dark.css');
	}
}