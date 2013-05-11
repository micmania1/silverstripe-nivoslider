Silverstripe Nivo Slider
============================

This Silverstripe module brings the Nivo Slider to your project with compelte flexibility.

Features
--------
* Manage multiple sliders and their content through Silverstripe CMS.
* Choose between 4 default themes or add your own.
* Completely customizable with all Nivo jQuery options editable through the CMS


Installation
--------
This module should be put into the root directory of your website.

**via Composer**

    composer require micmania1/silverstripe-nivoslider:1.0.*

**via Git**

    git clone https://github.com/micmania1/silverstripe-nivoslider.git
    cd silverstripe-nivoslider
    git checkout 1.0.0
    
Remember to run /dev/build?flush=1 on your site.

Usage
--------

To create a slider you can login to Silverstripe CMS and click 'Nivo Slides' in the left navigation pane.

Click the 'Add Nivo Slider' button which will take you through to a page where you can select a Title for your slider and add invididual slides.

On the advanced tab you can choose the theme and set many other options provided by the Nivo Slider. For more info on these options see the [Nivo Slider Documentation](http://dev7studios.com/nivo-slider/#/documentation).


Adding a Slide to a Page
--------
By default, sliders are stand-a-lone. To add them to a page the NivoSliderSiteTreeExtension and SiteTreeNivoSliderExtension are provided. These two extensions compliment each other by providing reciprical has_one links between the two DataObjects.

The following example shows how to add a slider to a HomePage class which extends Page.

**YAML Example:**

    ---
    Only:
      classexists: 'NivoSlider'
      classexists: 'HomePage'
    ---
    HomePage:
      extensions:
        - 'NivoSliderSiteTreeExtension'
    
    NivoSlider:
      extensions:
        - 'SiteTreeNivoSliderExtension'
    ---

**PHP Example:**

    Object::add_extension("HomePage", "NivoSliderSiteTreeExtension");
    Object::add_extension("NivoSlider", "SiteTreeNivoSliderExtension");

Once you have this connection (and ran a dev/build?flush=1) you can go to your home page and select a slider from the drop down menu.

You can of course create your own extensions to replace these and the link is not limited to pages. You can use any DataObject including widgets.


Template Usage
---------
For use in your template call the name of your has_one relationship. For example where a page has a has_one relationship of "NivoSlider" => "NivoSlider" you can use:

    $NivoSlider
    
This wil take care of rendering the whole slider.

Adding your own theme
---------
If you have your own Nivo Slider theme which you would like to apply you need to tell NivoSlider where to look for it.

To do this you need to extend the class NivoSliderTheme.

**Example:**

    <?php
    class MyNivoSliderTheme extends NivoSliderTheme {
        
        protected $title = "My Custom Theme";
        
        protected $cssClass = "MyCustomTheme";
        
        public function beforeRender() {
            // Require any js/css or do any other prep before rendering
            Require::css("mysite/css/myNivoStyle.css");
        }
    }
    ?>
    
You can then ?flush=1 and select your theme from the themes drop down menu within the advanced tab of each slider.