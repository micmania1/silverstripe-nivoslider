<?php

/**
 * Nivo Slider which is the holder for the slide.
 *
 * @package silverstripe
 * @subpackage nivoslider
**/
class NivoSlider extends DataObject {
	
	public static $db = array(
		"Title" => "Varchar(255)",
		"Theme" => "Varchar(255)",
		// Nive Slide Options
		"Effect" => "Enum('random, sliceDown, sliceUpm sliceUpLeft, sliceDown, sliceDownLeft, fold, face, slideInRight, slideInLeft, boxRandom, boxRain, boxRainReverse, boxRainGrow, boxRainGrowReverse', 'random')",
		"AnimationSpeed" => "Int",
		"PauseTime" => "Int",
		"StartSlide" => "Int",
		"RandomStart" => "Boolean",
		"Slices" => "Int", 
		"BoxCols" => "Int",
		"BoxRows" => "int", 
		"DirectionNav" => "Boolean",
		"ControlNav" => "Boolean",
		"ControlNavThumbs" => "Boolean",
		"PauseOnHover" => "Boolean",
		"ManualAdvance" => "Boolean",
		"PrevText" => "Varchar(255)",
		"NextText" => "Varchar(255)",
		
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
		"Effect" => "random",
		"AnimationSpeed" => 500,
		"PauseTime" => 3000,
		"startSlide" => 0,
		"RandomStart" => false,
		"Slices" => 15,
		"BoxCols" => 8,
		"BoxRows" => 4,
		"DirectionNav" => true,
		"ControlNav" => true,
		"ControlNavThumbs" => false,
		"PauseOnHover" => true,
		"ManualAdvance" => false,
		"PrevText" => "Prev",
		"NextText" => "Next",
		
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
		$dir = explode(DIRECTORY_SEPARATOR, trim(Director::makeRelative(__FILE__), DIRECTORY_SEPARATOR));
		return $dir[0];
	}
	


	public function getCMSFields() {
		$fields = new FieldList();
		$fields->push(
			new TabSet(
				"Root",
				new Tab(
					"Main",
					TextField::create("Title", "Title"),
					GridField::create(
						"Slides",
						"Nivo Slide",
						$this->Slides(),
						GridFieldConfig_RecordEditor::create()
					)
				),
				new Tab(
					"Advanced",
					DropdownField::create("Theme", "Theme", self::get_all_themes()),
					DropdownField::create("Effect", "Effect", $this->dbObject("Effect")->enumValues()),
					NumericField::create("AnimationSpeed", "Animation Speed")
						->setDescription("Animation speed in milliseconds."),
					NumericField::create("PauseTime", "Pause Time")
						->setDescription("Pause time on each frame in milliseconds."),
					TextField::create("PrevText", "Previous Text"),
					TextField::create("NextText", "Next Text"),
					NumericField::create("Slices", "Slices")
						->setDescription("Number of slices for slice animation effects."),
					NumericField::create("BoxCols", "Box Columns")
						->setDescription("Number of box columns for box animation effects."),
					NumericField::create("BoxRows", "Box Rows")
						->setDescription("Number of box rows for box animation effects."),
					NumericField::create("StartSlide", "Start Slide")
						->setDescription("Slide to start on (0 being the first)."),
					HeaderField::create("ControlHeading", "Control Options", 4),
					CompositeField::create(
						array(
							CheckboxField::create("DirectionNav", "Display Direction Navigation?"),
							CheckboxField::create("ControlNav", "Display Control Navigation?"),
							CheckboxField::create("ControlNavThumbs", "Use thumbnails for control nav?"),
							CheckboxField::create("PauseOnHover", "Stop the animation whilst hovering?"),
							CheckboxField::create("ManualAdvance", "Force manual transition?"),
							CheckboxField::create("RandomStart", "Random Start?")
						)
					)
				)
			)
		);
		$fields->extend("updateCMSFields", $fields);
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
				$("#' . $this->ClassName . '-' . $this->ID . '").nivoSlider({
					effect: "' . $this->Effect . '",
					animSpeed: ' . $this->AnimationSpeed . ',
					pauseTime: ' . $this->PauseTime . ',
					startSlide: ' . $this->StartSlide . ',
					slices: ' . $this->Slices . ',
					boxCols: ' . $this->BoxCols . ',
					boxRwos: ' . $this->BoxRows . ',
					directionNav: ' . $this->DirectionNav . ',
					controlNav: ' . $this->ControlNav . ',
					controlNavThumbs: ' . $this->ControlNavThumbs . ',
					pauseOnHover: ' . $this->PauseOnHover . ',
					manualAdvance: ' . $this->ManualAdvance . ',
					prevText: "' . $this->PrevText . '",
					nextText: "' . $this->NextText . '",
					randomStart: ' . $this->RandomStart . '
				});
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
