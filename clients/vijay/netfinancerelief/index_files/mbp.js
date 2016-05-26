jQuery(document).ready(function($){
	
	MB_BUTTON_STYLES = [];
	
	MB_BASIC_STYLES = JSON.parse(mbp_button_styles.basic);
	MB_PREMIUM_STYLES = JSON.parse(mbp_button_styles.premium);
	MB_CUSTOM_STYLES = JSON.parse((mbp_button_styles.custom && mbp_button_styles.custom != 'null') ? mbp_button_styles.custom : '[]');
	
	MB_BUTTON_STYLES = MB_BASIC_STYLES.concat(MB_PREMIUM_STYLES).concat(MB_CUSTOM_STYLES);
	
	
	MBRenderer = function(){
		
		var self = this;
		
		self.getPresetSettingsByName = function(preset){
			var buttonStyle = $.grep(MB_BUTTON_STYLES, function(buttonStyle){
				return buttonStyle.name.toLowerCase() == preset.toLowerCase();
			});
			
			if(buttonStyle && buttonStyle[0]){
				return buttonStyle[0].settings
			}
			else{
				return false;
			}
		}
		
		self.renderButtonStylesOnPage = function(){
			
			var buttonElements = $('.mb-button');
			
			var styleBlock = self.getStyleBlockForButtonElements(buttonElements, 'mb-styles');
			var fontBlock = self.getFontBlockForButtonElements(buttonElements, 'mb-fonts');
			
			//remove current style block if already exists
			if($('#mb-styles')){
				$('#mb-styles').remove();
			}
			//remove current font block if already exists
			if($('#mb-fonts')){
				$('#mb-fonts').remove();
			}
			
			//Entire Page
			$('head').append(styleBlock);
			$('head').append(fontBlock);
		}
		
		self.renderButtonStylesInTinyMCE = function(){
			
			var buttonElements = $('iframe').contents().find('.mb-button');
			
			var styleBlock = self.getStyleBlockForButtonElements(buttonElements, 'mb-tiny-mce-styles');
			var fontBlock = self.getFontBlockForButtonElements(buttonElements, 'mb-tiny-mce-fonts');
			
			//remove current style block if already exists
			if($('iframe').contents().find('#mb-tiny-mce-styles')){
				$('iframe').contents().find('#mb-tiny-mce-styles').remove();
			}
			//remove current font block if already exists
			if($('iframe').contents().find('#mb-tiny-mce-styles')){
				$('iframe').contents().find('#mb-tiny-mce-fonts').remove();
			}
			
			//IFrame
			$('iframe').contents().find('head').append(styleBlock);
			$('iframe').contents().find('head').append(fontBlock);
			
		}
		
		self.renderButtonStylesInContainer = function(containerName){
			var buttonElements = $("#" + containerName + ' .mb-button');
			
			var styleBlock = self.getStyleBlockForButtonElements(buttonElements, containerName + '-styles');
			var fontBlock = self.getFontBlockForButtonElements(buttonElements, containerName + '-fonts');
			
			//remove current style block if already exists
			if($('#' + containerName + '-styles')){
				$('#' + containerName + '-styles').remove();
			}
			//remove current font block if already exists
			if($('#' + containerName + '-fonts')){
				$('#' + containerName + '-fonts').remove();
			}
			
			//MBModal
			$('head').append(styleBlock);
			$('head').append(fontBlock);
		}
		
		self.getFontBlockForButtonElements = function(buttonElements, fontBlockId){
			
			var buttonFonts = '';
			
			$.each(buttonElements, function(index, buttonElement){
				
				var font;
				var weight;
				
				//if button is preset style
				if($(buttonElement).attr('mb-data-preset')){
					var presetStyles = self.getPresetSettingsByName($(buttonElement).attr('mb-data-preset'));
					
					font = presetStyles.textFont;
					weight = presetStyles.textFontWeight;
				}
				else{
					/*If font or weight isn't specified, return*/
					if(!$(buttonElement).attr('mb-data-text-font') || !$(buttonElement).attr('mb-data-text-font-weight')){
						return true;
					}
					
					font = $(buttonElement).attr('mb-data-text-font');
					weight = $(buttonElement).attr('mb-data-text-font-weight');
				}
				
				if(!font || !weight){
					return true;
				}
				
				//replace spaces with "+" to format correctly for google fonts script
				font = font.replace(' ', '+');
				
				buttonFonts += font + ':' + weight + '|';
			});
			
			//if button fonts is blank, add Open+Sans to prevent throwing error on page
			if(buttonFonts == ''){
				buttonFonts += 'Open+Sans:400|';
			}
			
			return "<link id=" + (fontBlockId ? fontBlockId : 'mb-fonts') + " href='//fonts.googleapis.com/css?family=" + buttonFonts + "' rel='stylesheet' type='text/css'>";
		}
		self.getStyleBlockForButtonElements = function(buttonElements, styleBlockId){
			
			var buttons = [];
			
			$.each(buttonElements, function(index, button){
				
				var jQueryButton = $(button);
				
				var newButton = {};
				
				newButton.id = jQueryButton.attr('id');
				newButton.element = button;
				
				/*If loading from preset, use the preset's styles*/
				if(jQueryButton.attr('mb-data-preset')){
					
					newButton.preset = jQueryButton.attr('mb-data-preset');
					
					var presetStyles = self.getPresetSettingsByName(jQueryButton.attr('mb-data-preset'));
					
					newButton.primaryColor = presetStyles.primaryColor;
					newButton.secondaryColor = presetStyles.secondaryColor;
					newButton.backgroundStyle = presetStyles.backgroundStyle;
					newButton.borderStyle = presetStyles.borderStyle;
					newButton.textFont = presetStyles.textFont;
					newButton.textFontWeight = presetStyles.textFontWeight;
					newButton.lineHeight = presetStyles.lineHeight;
					newButton.letterSpacing = presetStyles.letterSpacing;
				}
				else{
					newButton.primaryColor = jQueryButton.attr('mb-data-primary-color');
					newButton.secondaryColor = jQueryButton.attr('mb-data-secondary-color');
					newButton.backgroundStyle = jQueryButton.attr('mb-data-background-style');
					newButton.borderStyle = jQueryButton.attr('mb-data-border-style');
					newButton.textFont = jQueryButton.attr('mb-data-text-font');
					newButton.textFontWeight = jQueryButton.attr('mb-data-text-font-weight');
					newButton.lineHeight = jQueryButton.attr('mb-data-line-height');
					newButton.letterSpacing = jQueryButton.attr('mb-data-letter-spacing');
				}
				
				buttons.push(newButton);
				
			});
			
			var styleBlock = '<style id="' + (styleBlockId ? styleBlockId : 'mb-styles') + '">';
			
			$.each(buttons, function(index, button){
				/*Default Styles*/
				
				/*If button doesn't have ID, we have no way off associating the styles w/ this button. return before adding anything to style block.*/
				if(!button.id){
					return;
				}
				
				/*Normal Styles*/
				styleBlock += '#' + button.id + '{';
					styleBlock += self.getStylesForButon(button, 'normal');
				styleBlock += '}'
				
				/*Hovered Styles*/
				styleBlock += '#' + button.id + ':hover{';
					styleBlock += self.getStylesForButon(button, 'hover');
				styleBlock += '}';
			});
			
			styleBlock += '</style>';
			
			return styleBlock;
		}
		
		/*Get the normal state style block text for a button*/
		self.getStylesForButon = function(button, state){
			
			var styles = '';
			
			if(button.backgroundStyle || true){//ALWAYS APPLY BACKGROUND STYLE
				styles += self.getCSSForBackgroundStyle(button.backgroundStyle, state, button.primaryColor, button.secondaryColor);
			}
			if(button.borderStyle){
				styles += self.getCSSForBorderStyle(button.borderStyle, button.primaryColor, button.secondaryColor);
			}
			if(button.textFont){
				styles += self.getCSSForTextFont(button.textFont);
			}
			if(button.textFontWeight){
				styles += self.getCSSForTextFontWeight(button.textFontWeight);
			}
			if(button.shadowStyle){
				styles += self.getCSSForShadowStyle(button.shadowStyle);
			}
			if(button.lineHeight){
				styles += self.getCSSForLineHeight(button.lineHeight);
			}
			if(button.letterSpacing){
				styles += self.getCSSForLetterSpacing(button.letterSpacing);
			}
			
			return styles;
		}
		
		/*Get the hover state style block text for a button*/
		self.getHoverStateStylesForButon = function(button){
			if(button.preset){
				//get all modifications from JS, then apply
			}
			else{
				//apply all modifications individually
				if(button.backgroundStyle){
					return self.getHoverCSSForBackgroundStyle(button.backgroundStyle, button.primaryColor, button.secondaryColor);
				}
			}
		}
		
		self.getCSSForTextFont = function(textFont){
			return 'font-family: "' + textFont + '";';
		}
		self.getCSSForTextFontWeight = function(textFontWeight){
			return 'font-weight:' + parseInt(textFontWeight) + ';';
		}
		self.getCSSForLineHeight = function(lineHeight){
			return 'line-height: ' + lineHeight + ';';
		}
		self.getCSSForLetterSpacing = function(letterSpacing){
			return 'letter-spacing: ' + letterSpacing + 'em;';
		}
		
		//Available Styles: traditional, minimal, raised
		self.getCSSForBorderStyle = function(borderStyle){
			if(borderStyle == 'thick'){
				return self.getCSSForBorderStyleThick();
			}
			else if(borderStyle == 'thin'){
				return self.getCSSForBorderStyleThin();
			}
			else if(borderStyle == 'bottom'){
				return self.getCSSForBorderStyleBottom();
			}
			else{
				return ''
			}
		}

		self.getCSSForBorderStyleThick = function(){
			var css = '';
			
			css += 'border:.20em solid rgba(0,0,0,.05);';
			css += 'border-top:.10em solid rgba(255,255,255,.10);';
			
			return css;
		}
		self.getCSSForBorderStyleThin = function(){
			var css = '';
			
			css += 'border:.10em solid rgba(0,0,0,.20);';
			
			return css;
		}
		self.getCSSForBorderStyleBottom = function(){
			var css = '';
			
			css += 'border-bottom:.20em solid rgba(0,0,0,.25);';
			
			//can't do this because it messes up the "to bottom right" angled gradient
			//css += 'border-top:.20em solid transparent;';//to offset bottom padding for border
			
			return css;
		}
		
		
		//Available Styles: traditional, under, minimal, uniform
		self.getCSSForShadowStyle = function(shadowStyle){
			if(shadowStyle == 'traditional'){
				return self.getCSSForShadowStyleTraditional();
			}
			else if(shadowStyle == 'under'){
				return self.getCSSForShadowStyleUnder();
			}
			else if(shadowStyle == 'minimal'){
				return self.getCSSForShadowStyleMinimal();
			}
			else if(shadowStyle == 'uniform'){
				return self.getCSSForShadowStyleUniform();
			}
			else{
				return ''
			}
		}
		
		self.getCSSForShadowStyleTraditional = function(){
			return 'box-shadow: .1em .1em .5em .1em rgba(0,0,0,.25);';
		}
		self.getCSSForShadowStyleUnder = function(){
			return 'box-shadow: 0 .4em .4em -.2em rgba(0,0,0,.25);';
		}
		self.getCSSForShadowStyleMinimal = function(){
			return 'box-shadow: 0 .1em #FFFFFF inset, 0 .1em .3em rgba(34, 25, 25, 0.4);';
			//return 'box-shadow: .1em .1em .5em .1em rgba(0,0,0,.25);';
		}
		self.getCSSForShadowStyleUniform = function(){
			return 'box-shadow: 0 0 .2em 0 #B3B3B3;';
			return 'box-shadow: .1em .1em .5em .1em rgba(0,0,0,.25);';
		}
		
		//Available Styles: solid, lineargradient, topheavygradient, angledgradient, radialgradient
		self.getCSSForBackgroundStyle = function(backgroundStyle, state, primaryColor, secondaryColor){
			if(backgroundStyle == 'solid' || backgroundStyle == '' || !backgroundStyle){
				return self.getCSSForBackgroundStylePlain(state, primaryColor);
			}
			else if(backgroundStyle == 'lineargradient'){
				return self.getCSSForBackgroundStyleLinearGradient(state, primaryColor, secondaryColor);
			}
			else if(backgroundStyle == 'lineargloss'){
				return self.getCSSForBackgroundStyleLinearGloss(state, primaryColor, secondaryColor);
			}
			else if(backgroundStyle == 'topheavygradient'){
				return self.getCSSForBackgroundStyleTopHeavyGradient(state, primaryColor, secondaryColor);
			}
			else if(backgroundStyle == 'angledgradient'){
				return self.getCSSForBackgroundStyleAngledGradient(state, primaryColor, secondaryColor);
			}
			else if(backgroundStyle == 'angledgloss'){
				return self.getCSSForBackgroundStyleAngledGloss(state, primaryColor, secondaryColor);
			}
			else if(backgroundStyle == 'outline'){
				return self.getCSSForBackgroundStyleOutline(state, primaryColor);
			}
			else{
				return '';
			}
		}
		
		self.getCSSForBackgroundStylePlain = function(state, primaryColor){
			var css = '';
			
			if(state == 'normal'){
				css += 'background: linear-gradient(to bottom,' + primaryColor + ', ' + primaryColor + ');';
			}
			else if(state == 'hover'){
				css += 'background: linear-gradient(to bottom,' + self.adjustColor(primaryColor, -5) + ', ' + self.adjustColor(primaryColor, -5) + ');';
			}
			
			return css;
		}
		
		self.getCSSForBackgroundStyleAngledGradient = function(state, primaryColor, secondaryColor){
			
			var css = '';
			
			if(state == 'normal'){
				css += 'background: -webkit-linear-gradient(to bottom right,' + primaryColor + ',' + secondaryColor + ');';
				css += 'background: linear-gradient(to bottom right,' + primaryColor + ', ' + secondaryColor + ');';
			}
			else if(state == 'hover'){
				css += 'background: -webkit-linear-gradient(to bottom right,' + self.adjustColor(primaryColor, -5) + ',' + self.adjustColor(secondaryColor, -5) + ');';
				css += 'background: linear-gradient(to bottom right,' + self.adjustColor(primaryColor, -5) + ', ' + self.adjustColor(secondaryColor, -5) + ');';
			}
			
			return css;
		}
		
		self.getCSSForBackgroundStyleAngledGloss = function(state, primaryColor, secondaryColor){
			
			var css = '';
			
			if(state == 'normal'){
				css += 'background: linear-gradient(to bottom right,' + primaryColor + ' 0%, ' + self.adjustColor(primaryColor, 20) + ' 50%, ' + self.adjustColor(primaryColor, 15) + ' 51%, ' + secondaryColor + ' 100%);';
			}
			else if(state == 'hover'){
				css += 'background: linear-gradient(to bottom right,' + self.adjustColor(primaryColor, -5) + ' 0%, ' + self.adjustColor(primaryColor, 15) + ' 50%, ' + self.adjustColor(primaryColor, 10) + ' 51%, ' + self.adjustColor(secondaryColor, -5) + ' 100%);';
			}
			
			return css;
		}
		
		self.getCSSForBackgroundStyleLinearGradient = function(state, primaryColor, secondaryColor){
			var css = '';
			
			if(state == 'normal'){
				css += 'background: -webkit-linear-gradient(' + primaryColor + ',' + secondaryColor + ');' /* Chrome10+,Safari5.1+ */
				css += 'background: linear-gradient(' + primaryColor + ', ' + secondaryColor + ');';
			}
			else if(state == 'hover'){
				css += 'background: -webkit-linear-gradient(' + self.adjustColor(primaryColor, -5) + ',' + self.adjustColor(secondaryColor, -5) + ');' /* Chrome10+,Safari5.1+ */
				css += 'background: linear-gradient(' + self.adjustColor(primaryColor, -5) + ', ' + self.adjustColor(secondaryColor, -5) + ');';
			}
			
			return css;
		}
		
		self.getCSSForBackgroundStyleLinearGloss = function(state, primaryColor, secondaryColor){
			
			var css = '';
			
			if(state == 'normal'){
				css += 'background: linear-gradient(to bottom,' + self.adjustColor(primaryColor, 10) + ' 0%, ' + self.adjustColor(primaryColor, 0) + ' 50%, ' + self.adjustColor(primaryColor, -5) + ' 51%, ' + secondaryColor + ' 100%);';
			}
			else if(state == 'hover'){
				css += 'background: linear-gradient(to bottom,' + self.adjustColor(primaryColor, 5) + ' 0%, ' + self.adjustColor(primaryColor, -5) + ' 50%, ' + self.adjustColor(primaryColor, -10) + ' 51%, ' + self.adjustColor(secondaryColor, -5) + ' 100%);';
			}
			
			return css;
		}
		
		self.getCSSForBackgroundStyleTopHeavyGradient = function(state, primaryColor, secondaryColor){
			var css = '';
			
			if(state == 'normal'){
				css += 'background: -webkit-linear-gradient(top,' + primaryColor + ' 50%,' + secondaryColor + ' 100%);'; /* W3C */
			}
			else if(state == 'hover'){
				css += 'background: -webkit-linear-gradient(top,' + self.adjustColor(primaryColor, -5) + ' 50%,' + self.adjustColor(secondaryColor, -5) + ' 100%);'; /* W3C */
			}
			
			
			return css;
		}
		
		self.getHoverCSSForAngledGradient = function(primaryColor, secondaryColor){
			
			var css = '';
			
			css += 'background: -webkit-linear-gradient(160deg,' + self.adjustColor(primaryColor, -5) + ',' + self.adjustColor(secondaryColor, -5) + ');' /* Chrome10+,Safari5.1+ */
			css += 'background: linear-gradient(160deg,' + self.adjustColor(primaryColor, -5) + ', ' + self.adjustColor(secondaryColor, -5) + ');';
			
			return css;
		}
		
		self.getCSSForBackgroundStyleOutline = function(state, primaryColor){
			var css = '';
			
			if(state == 'normal'){
				css += 'background:transparent !important;';
				css += 'color: ' + primaryColor + ' !important;';
				css += 'border:.15em solid ' + primaryColor + ';';
			}
			else if(state == 'hover'){
				css += 'background:transparent !important;';
				css += 'color: ' + self.adjustColor(primaryColor, 10) + ' !important;';
				css += 'border:.15em solid ' + self.adjustColor(primaryColor, 10) + ';';
			}
			
			return css;
		}
		
		/*http://www.sitepoint.com/javascript-generate-lighter-darker-color/*/
		self.adjustColor = function(hex, percentage){
			// validate hex string
			hex = String(hex).replace(/[^0-9a-f]/gi, '');
			if (hex.length < 6) {
				hex = hex[0]+hex[0]+hex[1]+hex[1]+hex[2]+hex[2];
			}
			percentage = percentage || 0;

			// convert to decimal and change luminosity
			var rgb = "#", c, i;
			for (i = 0; i < 3; i++) {
				c = parseInt(hex.substr(i*2,2), 16);
				c = Math.round(Math.min(Math.max(0, c + (c * (percentage / 100))), 255)).toString(16);
				rgb += ("00"+c).substr(c.length);
			}

			return rgb;
		}
		
		return self;
	}
	
	mbr = new MBRenderer();
	
	mbr.renderButtonStylesOnPage();
	
	//This is called by TinyMCE afterRender function
	//mbr.renderButtonStylesInTinyMCE();
	
	//This is called when needed
	//mbr.renderButtonStylesInModal();
	
});