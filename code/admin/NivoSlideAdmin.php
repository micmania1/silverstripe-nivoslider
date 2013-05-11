<?php

class NivoSlideAdmin extends ModelAdmin {

	public static $url_segment = "nivo-slides";
	
	public static $menu_title = "Nivo Slides";
	
	public static $managed_models = array(
		"NivoSlider",
	);
}
