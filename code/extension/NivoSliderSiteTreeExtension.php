<?php

/**
 * Basic Site Tree extension to add a single nivo slider to any page.
 *
 * @package silverstripe
 * @subpackage nivoslider
**/
class NivoSliderSiteTreeExtension extends DataExtension {
	
	private static $has_one = array(
		"NivoSlider" => "NivoSlider"
	);
	
	public function updateCMSFields(FieldList $fields) {
		$fields->insertBefore(DropdownField::create("NivoSliderID", "Nivo Slider", NivoSlider::get()->map()), 
			"Content");
	}

}