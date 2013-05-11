<?php

/**
 * The base class for a Nivo Slider theme.
 *
 * @package silverstripe
 * @subpackage nivoslider
**/
class NivoSliderTheme extends Object {
	
	/**
	 * The title of your theme which will be shown in the CMS
	 *
	 * @var string
	**/
	public $title = "No Theme";
	
	/**
	 * This is the class that will be applied to the wrapper of the Nivo slider.
	 *
	 * @var string CSS Class
	**/
	public $cssClass = "no-theme";
	
	
	/**
	 * Any custom theme code to be executed before rendering
	**/
	public function beforeRender() {
		$this->extend("beforeRender");
	}
	
	
	/**
	 * Set the theme title.
	 *
	 * @param $title string
	**/
	public function setTitle($title) {
		$this->title = (string) $title;
	}
	
	
	/**
	 * Return the theme title.
	 *
	 * @return string
	**/
	public function getTitle() {
		return (string) $this->title;
	}
	
	
	/**
	 * Set the theme css class
	 *
	 * @param $class string
	**/
	public function setCssClass($class) {
		$this->cssClass = (string) $class;
	}
	
	
	/**
	 * Return the theme css class
	 *
	 * @return string
	**/
	public function getCssClass() {
		return (string) $this->cssClass;
	}
}
