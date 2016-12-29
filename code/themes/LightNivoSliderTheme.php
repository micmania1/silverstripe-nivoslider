<?php

/**
 * Light Nivo theme.
 *
 * @package silverstripe
 * @subpackage nivoslider
**/
class LightNivoSliderTheme extends NivoSliderTheme
{

    protected $title = "Light Theme";
    
    protected $cssClass = "theme-light";
    
    public function beforeRender()
    {
        parent::beforeRender();
        Requirements::css(NivoSlider::get_module_folder() . '/themes/light/light.css');
    }
}
