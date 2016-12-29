<?php

/**
 * Bar Nivo theme.
 *
 * @package silverstripe
 * @subpackage nivoslider
**/
class BarNivoSliderTheme extends NivoSliderTheme
{

    protected $title = "Bar Theme";
    
    protected $cssClass = "theme-bar";
    
    public function beforeRender()
    {
        parent::beforeRender();
        Requirements::css(NivoSlider::get_module_folder() . '/themes/bar/bar.css');
    }
}
