<% if Slides %>
<div class="slider-wrapper $ThemeCSSClass">
    <div id="{$ClassName}-{$ID}" class="$ClassName nivoSlider">
    	<% loop Slides %>
    		<% include NivoSliderSlide %>
    	<% end_loop %>
    </div>
	<% include NivoSlideCaptions %>
</div>
<% end_if %>
