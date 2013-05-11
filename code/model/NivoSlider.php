<?php

/**
 * Nivo Slider which which is the holder for the slide.
 *
 * @package silverstripe
 * @subpackagae niveslider
**/
class NivoSlider extends DataObject {
	
	public static $db = array(
		"Title" => "Varchar(255)",
		"Theme" => "Varchar(255)",
	);
	
	public static $has_many = array(
		"Slides" => "NivoSliderSlide",
	);
	
	public static $searchable_fields = array(
		"Title",
	);
	
	public static $summary_fields = array(
		"Title",
	);
	
	public static $defaults = array(
		"Theme" => "DefaultNivoSliderTheme",
	);
	
	/** 
	 * Fetches a list of all themes installed and returns map of
	 * ClassName => 'Theme Title'
	 *
	 * @return SS_Mmap
	**/
	public static function get_all_themes() {
		$themes = new ArrayList();
		$classes = ClassInfo::subclassesFor("NivoSliderTheme");
		if(count($classes) > 0) {
			foreach($classes as $theme) {
				$themes->push(new ArrayData(array(
					"ClassName" => $theme,
					"Title" => singleton($theme)->getTitle()
				)));
			}
		}
		return new SS_Map($themes, "ClassName", "Title");
	}
	
	
	/**
	 * Returns the nivo slider module folder
	 *
	 * @return string
	**/
	public static function get_module_folder() {
		$dir = explode("/", trim(Director::makeRelative(__FILE__), "/"));
		return $dir[0];
	}
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->push(TextField::create("Title", "Title"));
		$fields->push(DropdownField::create("Theme", "Theme", self::get_all_themes()));
		$fields->push(GridField::create(
			"Slides",
			"Nivo Slide",
			$this->Slides(),
			GridFieldConfig_RecordEditor::create()
		));
		return $fields;
	}
	
	public function validate() {
		$validation = parent::validate();
		if(!$this->validTheme($this->Theme)) {
			$validation->error("Invalid Theme: " . $this->Theme);
		}
		return $validation;
	}
	
	/** 
	 * Check that a theme is valid
	 *
	 * @param $theme string ClassName - subclass of NivoSliderTheme
	 * @return boolean
	**/
	public function validTheme($theme) {
		if(self::get_all_themes()->offsetGet($theme)) {
			return true;
		} else {
			return false;
		}
	}
	
	
	/**
	 * Render the Nivo Slider
	 *
	 * @return string HTML
	**/
	public function forTemplate() {
		$classes = array_reverse(ClassInfo::ancestry($this->ClassName));
		$baseClass = ClassInfo::baseDataClass($this->ClassName);
		
		$templates = array();
		foreach($classes as $class) {
			$templates[] = $class;
			if($class == $baseClass) break;
		}
		
		// Require nivo slider assets
		Requirements::css(NivoSlider::get_module_folder() . '/css/nivo-slider.css');
		Requirements::javascript(NivoSlider::get_module_folder() . '/javascript/jquery-1.9.0.min.js');
		Requirements::javascript(NivoSlider::get_module_folder() . '/javascript/jquery.nivo.slider.pack.js');
		Requirements::customScript
		(
			'$(window).ready(function() {
				$("#' . $this->ClassName . '-' . $this->ID . '").nivoSlider();
			});'
		);
		
		// Setup our theme
		$theme = new $this->Theme();
		$theme->beforeRender();
		
		return $this->customise(array(
			"ThemeTitle" => $theme->getTitle(),
			"ThemeCSSClass" => $theme->getCssClass()
		))->renderWith($templates);
	}
}
