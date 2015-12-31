<?php

/**
 * The default theme for the Nivo Slider
 *
 * @package silverstripe
 * @subpackage nivoslider
**/
class DefaultNivoSliderTheme extends NivoSliderTheme
{
    
    /** 
     * Set the default title
     *
     * @var string
    **/
    protected $title = "Default Theme";
    
    /**
     * Default CSS Class
     *
     * @var string CSS Class
    **/
    protected $cssClass = "theme-default";
    
    
    public function beforeRender()
    {
        parent::beforeRender();
        Requirements::css(NivoSlider::get_module_folder() . "/themes/default/default.css");
    }
}
