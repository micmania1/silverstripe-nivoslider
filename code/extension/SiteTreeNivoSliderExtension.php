<?php

/**
 * Recipricate a has one relationship from NivoSlider to SiteTree
 *
 * @package silverstripe
 * @subpackage nivoslider
**/
class SiteTreeNivoSliderExtension extends DataExtension {
	
	static $has_one = array(
		"Page" => "SiteTree"
	);
}