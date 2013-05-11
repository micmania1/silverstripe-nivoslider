<?php

class NivoSlideAdmin extends ModelAdmin {

	public static $url_segment = "nivo-slides";
	
	public static $menu_title = "Nivo Slides";
	
	public static $menu_icon = "silverstripe-nivoslider/images/icons/slides-16x16.png";
	
	public static $managed_models = array(
		"NivoSlider",
	);
}
