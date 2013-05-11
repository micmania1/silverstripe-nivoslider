<% if SlideImage %>
	<img src="$SlideImage.URL" alt="$Title"<% if Caption %> title="#NivoSlideCaption-$ID"<% end_if %><% if ControlNavThumbs %> data-thumb="$SlideImage.URL"<% end_if %> />
<% end_if %>
