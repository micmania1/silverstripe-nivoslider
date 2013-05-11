<?php

/**
 * A single Nivo Slide.
 *
 * @package silverstripe
 * @subpackage nivoslider
**/
class NivoSliderSlide extends DataObject {
	public static $db = array(
		"Title" => "Varchar(255)",
		"Caption" => "HTMLText",
	);
	
	public static $has_one = array(
		"NivoSlider" => "NivoSlider",
		"SlideImage" => "Image",
	);
	
	public static $summary_fields = array(
		"SlideImage.CMSThumbnail" => "Slide Image",
		"Title" => "Title",
	);
	
	public static $searchable_fields = array(
		"Title",
		"Caption",
		"SlideImage",
	);
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		
		// Remove unneccesary fields.
		$fields->removeByName("NivoSliderID");
		
		$fields->push(TextField::create("Title", "Title"));
		$fields->push(HTMLEditorField::create("Caption", "Caption"));
		
		$fields->insertBefore($slideImage = UploadField::create("SlideImage", "Slide Image"), "Caption");
		$slideImage->getValidator()->setAllowedExtensions(array('jpg', 'jpeg', 'png', 'gif'));
		$slideImage->setConfig('allowedMaxFileNumber', 1);
		
		return $fields;
	}
}
