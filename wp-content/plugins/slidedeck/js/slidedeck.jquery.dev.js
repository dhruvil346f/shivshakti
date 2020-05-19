/*!
 * More information on this project:
 * http://www.slidedeck.com/
 *
 * Requires: jQuery v1.3+
 *
 * Full Usage Documentation: http://www.slidedeck.com/usage-documentation
 * Usage:
 *     $(el).slidedeck(opts);
 *
 * @param {HTMLObject} el    The <DL> element to extend as a SlideDeck
 * @param {Object} opts      An object to pass custom override options to
 */

/*!
Copyright 2012 HBWSL  (email : support@hbwsl.com)

This file is part of SlideDeck.

SlideDeck is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

SlideDeck is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with SlideDeck.  If not, see <http://www.gnu.org/licenses/>.
*/

var SlideDeck;
var SlideDeckSkin = {};
var SlideDeckLens = {};
var flagSpineShowAlways = false;

/**
 * [slideDeckImagesLoaded] Changes to true after all the images are loaded
 * through jail lazy loading plugin.
 * @type {Boolean}
 * @since [3.2.5]
 */
var slideDeckImagesLoaded = false;

var CTAfunction= function(url)
{
	window.open(url, '_blank');
}

jQuery( window ).load( function(e){

	// adjust slidedeck height after page loads completely
	var slidedecks = jQuery('.slidedeck-frame .slidedeck').slidedeck();

    //check if images are loaded
    if( slideDeckImagesLoaded === true ){
        slideckAutoAdjustImagesOnLoad( slidedecks );

    }
    else //If images are not loaded wait for it.
    {

        if((jQuery('dd img.sd2-is-first-slide')))
        {

		jQuery('.slidedeck-frame .slidedeck .sd2-content-wrapper').show();
	}

        jQuery(window).on( 'slidedeckImagesLoaded' , function(){
            slideckAutoAdjustImagesOnLoad( slidedecks );

        });
    }
    if(typeof slidedecks!== "undefined")
    {

	    var $slides = jQuery(slidedecks.slides);

    	if( $slides.closest('lens-parfocal') ){
        	$slides.find('img').css( 'visibility', 'visible' );
    	}
    }
});

function slideckAutoAdjustImagesOnLoad( slidedecks )
{
    if( typeof slidedecks !== "undefined" )
    {
        for( var i=0;i<slidedecks.length;i++ ){
            slidedecks[i].autoAdjustAfterLoad();
        }
        if( typeof slidedecks.length === "undefined" ){
            slidedecks.autoAdjustAfterLoad();
        }
    }

    // show caption
    jQuery('.slidedeck-frame .slidedeck .sd2-content-wrapper').show();
}

function addEvent(evnt, elem, func) {
   if (elem.addEventListener)  // W3C DOM
      elem.addEventListener(evnt,func,false);
   else if (elem.attachEvent) { // IE DOM
      elem.attachEvent("on"+evnt, func);
   }
   else { // No much to do
      elem[evnt] = func;
   }
}

jQuery( document ).ready( function( e ) {



	// lazy load images using JAIL
	jQuery( 'img.slide-deck-lazy' ).jail( {
		timeout: 500,
		loadHiddenImages: true,
		loadAllHorizontal: true,
        callback : function(){
            slideDeckImagesLoaded = true;
            jQuery(window).trigger('slidedeckImagesLoaded');
        },
	} );

	// adjust slidedeck height after orientation change

	var supportsOrientationChange = "onorientationchange" in window,
    orientationEvent = supportsOrientationChange ? "orientationchange" : "resize";
        addEvent( orientationEvent, window, function() {
            var slidedecks = jQuery('.slidedeck-frame .slidedeck').slidedeck();
            if( typeof slidedecks !== "undefined" ){
                    for( var i=0;i<slidedecks.length;i++ ){
                            slidedecks[i].reloadSlidedeck();
                    }
                    if( typeof slidedecks.length === "undefined" ){
                            slidedecks.reloadSlidedeck();
                    }
            }
        });


// show spines on hover for classic lense

jQuery(".lens-classic dl").hover(
		function(e) {
			jQuery("dt.spine").stop( true, true ).fadeIn();
		},
		function(e) {

			if(jQuery(this).parent().is('.display-nav-hover'))
			{
			 jQuery("dt.spine").stop( true, true ).fadeOut();
		    }
		}
	);
} );

(function($){
    window.SlideDeck = function(el,opts){
        var self = this,
            el = $(el),
            versionPrefix = '',
            distribution = 'pro';

               if( typeof(window.slideDeck2Version) !== 'undefined' ){
            versionPrefix  = 'sd2-' + window.slideDeck2Version + '-';
        }

        if( typeof(window.slideDeck2Distribution) !== 'undefined' ){
            distribution  = window.slideDeck2Distribution;
        }

        var VERSION = versionPrefix + "1.4.4";

		var device_width = screen.width;

        this.options = {
            speed: 500,
            transition: 'swing',
            start: 1,
            activeCorner: true,
            index: true,
            scroll: true,
            keys: true,
            autoPlay: false,
            autoPlayInterval: 5000,
            hideSpines: false,
            cycle: false,
            slideTransition: 'slide',
            touchThreshold: { x: 50, y: 30 },
            touch: true,
            controlProgress: false,
			auto_height: false,
			device_width: device_width,
			fashion: false
        };

        this.classes = {
            slide: 'slide',
            spine: 'spine',
            label: 'label',
            index: 'index',
            active: 'active',
            indicator: 'indicator',
            activeCorner: 'activeCorner',
            disabled: 'disabled',
            vertical: 'slidesVertical',
            previous: 'previous',
            next: 'next'
        };

        this.current = 1;
        this.deck = el;

        this.former = -1;
        this.spines = el.children('dt');
		if( typeof opts !== "undefined" && opts.fashion )
			this.slides = el.children('li');
		else
			this.slides = el.children('dd');
		if( el.children('li').length > 0 ) {
                    this.options.cycle = true;
                    this.slides = el.children('li');
                }
        this.controlTo = 1;
        this.session = [];
        this.disabledSlides = [];
        this.pauseAutoPlay = false;
        this.isLoaded = false;

        var UA = navigator.userAgent.toLowerCase();
        this.browser = {
            chrome: UA.match(/chrome/) ? true : false,
            chromeFrame: (UA.match(/msie/) && UA.match(/chrome/)) ? true : false,
            chromeiOS: UA.match(/crios/) ? true : false, // CriOS (Chrome for iOS)
            firefox: UA.match(/firefox/) ? true : false,
            firefox2: UA.match(/firefox\/2\./) ? true : false,
            firefox30: UA.match(/firefox\/3\.0/) ? true : false,
            msie: UA.match(/msie/) ? true : false,
            msie6: (UA.match(/msie 6/) && !UA.match(/msie 7|8/)) ? true : false,
            msie7: UA.match(/msie 7/) ? true : false,
            msie8: UA.match(/msie 8/) ? true : false,
            msie9: UA.match(/msie 9/) ? true : false,
            msie10: UA.match(/msie 10/) ? true : false,
            opera: UA.match(/opera/) ? true : false,
            safari: (UA.match(/safari/) && !UA.match(/chrome|crios/)) ? true : false // Matches Safari and not "CriOS" (chrome for iOS)
        };

        for(var b in this.browser){
            if(this.browser[b] === true){
                this.browser._this = b;
            }
        }
        if(this.browser.chrome === true && !this.browser.chromeFrame) {
            this.browser.version = UA.match(/chrome\/([0-9\.]+)/)[1];
        }
        if(this.browser.firefox === true) {
            this.browser.version = UA.match(/firefox\/([0-9\.]+)/)[1];
        }
        if(this.browser.msie === true) {
            this.browser.version = UA.match(/msie ([0-9\.]+)/)[1];
        }
        if(this.browser.opera === true) {
            this.browser.version = UA.match(/version\/([0-9\.]+)/)[1];
        }
        if(this.browser.safari === true && !this.browser.chromeiOS) {
            this.browser.version = UA.match(/version\/([0-9\.]+)/)[1];
        }
        if(this.browser.chromeiOS === true) {
            this.browser.version = UA.match(/crios\/([0-9\.]+)/)[1];
        }

        var width;
        var height;

        var spine_inner_width,
            spine_outer_width,
            slide_width,
            spine_half_width;

        // Used by some slide transitions to lockout progress while the SlideDeck animates looping around
        this.looping = false;

        // Get the CSS3 browser prefix
        var prefix = "";
        switch(self.browser._this){
            case "firefox":
            case "firefox3":
                prefix = "-moz-";
            break;

            case "chrome":
            case "safari":
                prefix = "-webkit-";
            break;

            case "opera":
                prefix = "-o-";
            break;
        }

        var FixIEAA = function(spine){
            if(self.browser.msie && ( !self.browser.msie9 && !self.browser.msie10 )){
                var bgColor = spine.css('background-color');
                var sBgColor = bgColor;
                if(sBgColor === "transparent"){
                    bgColor = "#ffffff";
                } else {
                    if(sBgColor.match('#')){
                        // Hex, convert to RGB
                        if(sBgColor.length < 7){
                            var t = "#" + sBgColor.substr(1,1) + sBgColor.substr(1,1) + sBgColor.substr(2,1) + sBgColor.substr(2,1) + sBgColor.substr(3,1) + sBgColor.substr(3,1);
                            bgColor = t;
                        }
                    }
                }
                bgColor = bgColor.replace("#","");
                var cParts = {
                    r: bgColor.substr(0,2),
                    g: bgColor.substr(2,2),
                    b: bgColor.substr(4,2)
                };
                var bgRGB = "#";
                var hexVal = "01234567890ABCDEF";
                for(var k in cParts){
                    cParts[k] = Math.max(0,(parseInt(cParts[k],16) - 1));
                    cParts[k] = hexVal.charAt((cParts[k] - cParts[k]%16)/16) + hexVal.charAt(cParts[k]%16);

                    bgRGB += cParts[k];
                }

                spine.find('.' + self.classes.index).css({
                    'filter': 'progid:DXImageTransform.Microsoft.BasicImage(rotation=1) chroma(color=' + bgRGB + ')',
                    backgroundColor: bgRGB
                });
            }
        };

		// function to adjust image as background cover

		var slidedeckAdjustImage = function( slide ){
		    if(!$(slide).closest(".lens-pixel").length) {
                if( $(window).width() < 400 && window.self !== window.top ) return;
            }
            //Check if its IE 8
            var isIE = ( $( '.slidedeck-frame' ).hasClass('msie-8') ) ? true : false;

            $(slide).find('img').css('visibility', 'visible');
            if( !$( slide ).closest(".lens-prime").length && !$( slide ).closest(".lens-parfocal").length && !$( slide ).closest(".lens-parallax").length && !$( slide ).closest(".lens-layerpro").length ) {

            jQuery( slide ).ready(function(){
				var th = $(slide).height(),
				tw = $(slide).outerWidth(),
				im = $(slide).children('img.sd2-slide-background');
				if( im.length > 0 ){
				var ih = im[0].naturalHeight,
				iw = im[0].naturalWidth;
				// check if do not crop option is set

					if( jQuery( slide ).hasClass('sd2-image-scaling-none') ){
                        if( ! isIE ) return;

						im.css({maxWidth: 'none'});
						//set offset
						var hd = (ih-th)/2,
							wd = (iw-tw)/2;
						if (ih>th) {
							im.css({marginTop: '-'+hd+'px'});
						} else if(ih<th) {
							im.css({marginTop: Math.abs(hd)+'px'});
						}
						if(iw>tw){
							im.css({marginLeft: '-'+wd+'px'});
						} else {
							im.css({marginLeft: 'auto'});
							im.css({marginRight: 'auto'});
						}
					} else if( jQuery( slide ).hasClass('sd2-image-scaling-contain') ){
						var xh =parseInt((im.width()/im.height())*th+8);//niranjan  for absolute calculation of width if height is too big.

						if(!(jQuery(slide).parent().parent().is(".display-nav-always")) || !(jQuery(slide).parent().parent().is(".lens-classic"))){
							jQuery(slide).find('img.sd2-slide-background').css({"margin": "0 auto","width": +xh+"px"});

						}else if(jQuery(slide).parent().parent().is(".display-nav-always") && jQuery(slide).parent().parent().is(".lens-classic")) {
							jQuery(slide).find('img.sd2-slide-background').css({"width": +xh+"px"});
						}
                        if( ! isIE ) return;

						// If scale propotionatly and do not crop

						im.addClass('slidedeck-adjust-height').removeClass('slidedeck-adjust-width');

						//set offset
						var nh = im.height(),
							nw = im.width(),
							hd = (nh-th)/2,
							wd = (nw-tw)/2;

						if(nw>tw){
							// set image again propotionatly
							im.addClass('slidedeck-adjust-width').removeClass('slidedeck-adjust-height');
							// calculate offset again
							var nh = im.height(),
							nw = im.width(),
							hd = (nh-th)/2,
							wd = (nw-tw)/2;
							if (nh>th) {
							im.css({marginTop: '-'+hd+'px'});
							} else if(nh<th) {
								im.css({marginTop: Math.abs(hd)+'px'});
							}
						} else {
							im.css({marginLeft: 'auto'});
							im.css({marginRight: 'auto'});
						}
					} else if( jQuery( slide ).hasClass('sd2-image-scaling-cover') ) {
						if (ih>iw) {
							// portrait image so adjust width
							im.addClass('slidedeck-adjust-width').removeClass('slidedeck-adjust-height');
						} else {
							// landscape image so adjust height
							im.addClass('slidedeck-adjust-height').removeClass('slidedeck-adjust-width');
						}
						//set offset
						var nh = im.height(),
							nw = im.width(),
							hd = (nh-th)/2,
							wd = (nw-tw)/2;
						// set offset to adjust image in center
						if (nh>th) {
							im.css({marginTop: '-'+hd+'px'});
						} else if(nh<th) {
							im.css({marginTop: Math.abs(hd)+'px'});
						}
                        if(nw>=tw){
							im.css({marginLeft: '-'+wd+'px'});
						} else {
							// scale propotionatly
							im.addClass('slidedeck-adjust-width').removeClass('slidedeck-adjust-height');

							// again adjust offset

							var nh = im.height(),
								nw = im.width(),
								hd = (nh-th)/2,
								wd = (nw-tw)/2;
							// set offset to adjust image in center
							if (nh>th) {
								if(! im.closest(".sd2-fullwidth")){
								im.css({marginTop: '-'+hd+'px'});
								}
							}

						}

					}
				}
			});
                    }
		}


        var updateAddons = function(){
            // Handle Cufon
            if(typeof(Cufon) !== "undefined"){
                Cufon.DOM.ready(function(){
                    if(typeof(self.options.cufonRefresh) !== "undefined"){
                        var cufon_arr = [];
                        if(typeof(self.options.cufonRefresh) === "string"){
                            cufon_arr.push(self.options.cufonRefresh);
                        } else {
                            cufon_arr = self.options.cufonRefresh;
                        }

                        for(var i=0; i<cufon_arr.length; i++){
                            Cufon.refresh(cufon_arr[i]);
                        }
                    }

                    if(self.options.hideSpines === false){
                        var sPad = 0;
                        if(self.browser.msie8 && !self.browser.chromeFrame){
                            sPad = Math.floor(($(self.spines[0]).outerWidth() - $($(self.spines[0]).find('cufon')[0]).height())/2);
                        }
                        if(self.browser.safari || self.browser.chrome || self.browser.chromeFrame){
                            if(document.doctype.publicId.toLowerCase().match(/transitional/)){
                                sPad = Math.floor(($(self.spines[0]).outerHeight() - $($(self.spines[0]).find('cufon')[0]).height())/2);
                            }
                        }
                        self.spines.find('>cufon').css('margin-top',sPad);
                    }
                });
            }
        };


        var bugSet = false;
        var updateBug = function(){
            return false;
        };


        var updateControl = function(){
            if(self.options.controlProgress === true){
                for(var i=0; i<self.spines.length; i++){
                    if(i < self.controlTo){
                        $(self.spines[i]).removeClass(self.classes.disabled);
                    } else {
                        $(self.spines[i]).addClass(self.classes.disabled);
                    }
                }
            }
        };


        var hasVertical = function(event){
            var vertical = false;

            if(typeof(self.verticalSlides) !== 'undefined'){
                if(typeof(self.vertical().options) !== 'undefined'){
                    if(self.vertical().options.scroll === true && $(event.target).parents('.' + self.classes.vertical).length > 0){
                        vertical = true;
                    }
                }
            }

            return vertical;
        };

        var autoPlay = function(){
            // Assume no vertical slides in the current slide by default
            var vertical = false,
                // Assume we do not reset vertical slides by default
            resetVertical = false;

            // show Progress bar only if autoPlay is enabled


            var gotoNext = function(){

                // show Progress bar only if autoPlay is enabled


                //For Classic Lens AutoPlay and slide contents to not hide behind spine in case of slide control show always.
                if(self.options.device_width > 700 ){
                    var thisParent = $(self.spines).parent();
                    if($(thisParent).parent().is('.lens-classic')){

                        if($(thisParent).parent().is('.display-nav-always')){
                            var spinesWidthNow = self.spines.height();
                            var indexOfSpineNow = $('.lens-classic dt').index($('.active'));
                            var lenSpine = $('.lens-classic dt').length;
                            indexOfSpineNow = indexOfSpineNow + 2;

                            if(indexOfSpineNow === (lenSpine+1) && !flagSpineShowAlways)
                            {
                                indexOfSpineNow = 1;
				if(jQuery(".slidedeck-frame.lens-classic > .slidedeck > dt").hasClass("sd2-spinePosition-horizontal")){
                      			 $('.sd2-node-caption').css('left',indexOfSpineNow*spinesWidthNow+'px');
                               		 $('.slide-content').css('left',indexOfSpineNow*spinesWidthNow+'px');
				}
				else if(jQuery(".slidedeck-frame.lens-classic > .slidedeck > dt").hasClass("sd2-spinePosition-vertical")){
					 $('.sd2-node-caption').css('top',indexOfSpineNow*spinesWidthNow+'px');
                               		 $('.slide-content').css('top',indexOfSpineNow*spinesWidthNow+'px');
				}

                                indexOfSpineNow = lenSpine+1;

                            }else if(indexOfSpineNow < (lenSpine+1) && !flagSpineShowAlways){
                                //$('.sd2-node-caption').css('left',indexOfSpineNow*spinesWidthNow+'px');
                                //$('.slide-content').css('left',indexOfSpineNow*spinesWidthNow+'px');

                            }
                        }
                    }
                }


                // Assume no vertical slides in this slide
                vertical = false;

                // Only progress forward if we are not paused
                if(self.pauseAutoPlay === false && self.options.autoPlay === true){
                    // Check if we need to progress through a vertical slide
                    if(typeof(self.vertical()) !== 'undefined'){
                        if(self.vertical().navChildren){
                            // Only flag for vertical movement if we are not on the last vertical slide already
                            if(self.vertical().current + 1 !== self.vertical().slides.length){
                                vertical = true;
                            }
                        }
                    }

                    // Move forward by default
                    var moveForward = true;
                    // If cycle is boolean(false) and we are on the last slide set moveFoward to boolean(false)
                    if(self.options.cycle === false && self.current === self.slides.length){
                        // Check if we need to go through vertical slides on the last horizontal slide
                        if(vertical === true){
                            if(self.vertical().current + 1 === self.vertical().slides.length){
                                // Last horizontal, last vertical slide
                                moveForward = false;
                            }
                        } else {
                            // Last horizontal no vertical movement
                            moveForward = false;
                        }
                    }

                    if(moveForward === false){
                        // Stop auto-playing through SlideDeck
                        self.pauseAutoPlay = true;
                    } else {
                        // Move through vertical slides
                        if( vertical === true ){
                            if(self.vertical().current + 2 === self.vertical().slides.length){
                                vertical = false;
                                resetVertical = self.current;
                            }
                            self.vertical().next();
                        }
                        // Move through horizontal slides
                        else {
                            // Animate back to first vertical slide if this is a single horizontal slide SlideDeck
                            if(self.slides.length === 1 && self.current === self.slides.length){
                                if(resetVertical !== false){
                                    self.resetVertical(resetVertical, false);
                                    resetVertical = false;
                                }
                            }
                            // Snap to the first vertical slide in the last looped through vertical slide
                            else {
                                // Fall back to reset previous vertical slide (to accommodate for race condition)
                                if(self.former !== -1){
                                    if(typeof(self.verticalSlides[self.former]) !== 'undefined'){
                                        if(typeof(self.verticalSlides[self.former].navChildren) !== 'undefined'){
                                            self.resetVertical(self.former + 1);
                                        }
                                    }
                                }
                                // Animate and reset vertical slide in previous vertical slide
                                self.next(function(deck){
                                    if(resetVertical !== false){
                                        deck.resetVertical(resetVertical);
                                        resetVertical = false;
                                    }
                                });
                            }
                        }
                    }
                }
                if(self.options.autoPlay == true && self.options.progressBar == true && self.pauseAutoPlay == false ) {
                    animateTimeline();
                }
                setTimeout(gotoNext, self.options.autoPlayInterval);

            };
            if( self.options.progressBar == true) {
                animateTimeline();
            }
            setTimeout(gotoNext,self.options.autoPlayInterval);
        };
        var resetTimeline = function() {

            var timeline = $("#sd2-progress-container");
            timeline.css({width:'0'},0);
            timeline.stop().css({width:'0',opacity:1,height:'3px'},0);
        };
        var animateTimeline = function() {
            var barColor = self.options.progressBarColor;
            time = self.options.autoPlayInterval ;
            var timeline = $("#sd2-progress-container");
            timeline.stop().css({width:'0',opacity:1,height:'3px',background:barColor},0);
            timeline.stop().animate({width:'100%',height:'3px',background:barColor},time,'easeInOutQuint',function(){$(this).animate({opacity:0,width:0,height:'3px',background:barColor})});
        };

        /**
         * Modify the positioning and z-indexing for slides upon build
         *
         * @param string transition The slideTransition being used to determine how to build the slides
         * @param integer i The index of the slide to be modified
         */
        var buildSlideTransition = function(transition, i){

			if(self.options.hideSpines === true){
				var slideCSS = {
					display: 'block'
				};
			} else {
				// load blank object for classic lense as we are assigning it from css
				var slideCSS = {};
			}
            slideCSS[prefix + 'transform-origin'] = "50% 50%";
            slideCSS[prefix + 'transform'] = "";

            if(i < self.current) {
                var offset = i * spine_outer_width;
                if(self.options.hideSpines === true){
                    if(i === self.current - 1){
                        offset = 0;
                    } else {
                        offset = 0 - (self.options.start - i - 1) * el.width();
                    }
                }
            } else {
				slide_width = width - spine_outer_width*self.spines.length;
				if(self.options.hideSpines === true){
					// set full width to slide for classic lense
					slide_width = width;
				}
                if(jQuery(".slidedeck-frame.lens-classic > .slidedeck > dt").hasClass("sd2-spinePosition-horizontal")){
                	var offset = i * spine_outer_width + slide_width;//for horizontal
				}
               	else if(jQuery(".slidedeck-frame.lens-classic > .slidedeck > dt").hasClass("sd2-spinePosition-vertical")){
					var offset =  height -((self.slides.length-i) * spine_outer_width);//for vertical
	        	}

                if(self.options.hideSpines === true){
                    offset = (i + 1 - self.options.start) * el.width();
                }
		 		if(jQuery(".slidedeck-frame.lens-tool-kit.sd2-fullwidth").find("dd") && !jQuery(".slidedeck-frame").hasClass("lens-classic"))
				{
					offset = (i + 1 - self.options.start) * jQuery(window).width();
				}
				else if(jQuery(".slidedeck-frame.lens-vanilla.sd2-fullwidth").find("dd") && !jQuery(".slidedeck-frame").hasClass("lens-classic"))
				{
					offset = (i + 1 - self.options.start) * jQuery(window).width();
				}
				else if( jQuery(".slidedeck-frame.lens-infinity.sd2-fullwidth").find("dd") && !jQuery(".slidedeck-frame").hasClass("lens-classic") ) {
					offset = (i + 1 - self.options.start) * jQuery(window).width();
				}
                else if( jQuery(".slidedeck-frame.lens-testimonial.sd2-fullwidth").find("dd") && !jQuery(".slidedeck-frame").hasClass("lens-classic") ) {
                    offset = (i + 1 - self.options.start) * jQuery(window).width();
                }
        	}

            switch(transition){
                case "stack":
                    slideCSS.zIndex = self.slides.length - i;
                    slideCSS.left = 0;
                break;
                case "fade":
                    var $currentSlide = self.slides.eq(self.current - 1);
                    slideCSS.zIndex = self.slides.length - i;
                    slideCSS.left = 0;

                    // Fade out other slides
                    self.slides.not($currentSlide).css({
                        opacity: 0
                    });
                break;

                case "flip":
                    slideCSS.zIndex = self.slides.length - i;
                    slideCSS.left = 0;
                    if(i !== (self.current - 1)){
                        slideCSS[prefix + 'transform'] = "scaleY(0)";
                    }
                break;

                case "flipHorizontal":
                    slideCSS.zIndex = self.slides.length - i;
                    slideCSS.left = 0;
                    if(i !== (self.current - 1)){
                        slideCSS[prefix + 'transform'] = "scaleX(0)";
                    }
                break;

                case "slide":
                /* falls through */
                default:
                   slideCSS.left = offset;
                   slideCSS.zIndex = 1;
                    // Other things to modify the slideCSS specifically for default transitions
                break;
            }

            self.slides.eq(i).css(prefix + 'transition', "").css(slideCSS);

            return offset;
        };


		// function to adjust height of frame

		var autoAdjustHeight = function(){

			var slide = $(self.slides[self.current-1]);
			var vertical = false;
			// check if slide is verticle
			if(typeof(self.vertical()) !== 'undefined'){
                        if(self.vertical().navChildren){
                            // Only flag for vertical movement if we are not on the last vertical slide already
                            if(self.vertical().current + 1 !== self.vertical().slides.length){
                                vertical = true;
                    }
                }
            }

			// don't adjust height if slider is vertical and auto height option is off
			if( ( self.options.auto_height || screen.width < 700 ) && self.options.hideSpines === true && vertical === false ) {
						var image = slide.find('img.sd2-slide-background');

						// adjust the height after image is completely loaded

						if(image.length !== 0){
							image.on('load', function() {
								adjustSlideHeight( slide );
							  }).each(function() {
								if(this.complete) $(this).load();
							  });
						  } else {
							  // video slide
							  adjustSlideHeight( slide );
					}
				} else {
					if( vertical ){
						slide = self.vertical().slides[self.current-1];
					}
					slidedeckAdjustImage( slide );
				}
		}

		// adjust slide height

		var adjustSlideHeight = function( slide ){
			var slide_actual_height = 0;

			// loop through all childrens to calculate max height

			$(slide).children('img, div').each(function(){
				var pad_top = 0;
				var bottom = 0;
				if( $( this ).hasClass( 'slide-content' ) ){
					pad_top = jQuery( this ).css('padding-top');
					bottom = jQuery( this ).css('bottom');
				}
				// video slider
				var div_height = this.clientHeight;

				// add paddings of div

				if( $( this ).find('.slide-content').length ){
					div_height = $( this ).find('.slide-content').height();
					pad_top = $( this ).find('.slide-content').css('padding-top');
					bottom = $( this ).find('.slide-content').css('bottom');
				}
				if( div_height >  slide_actual_height){
					slide_actual_height = div_height + parseInt( pad_top ) + parseInt( bottom );
				}
			});
			// If calculated height is less then use default height
			if( parseInt(slide_actual_height) < 20 && self.options.device_width > 700 ){
				slide_actual_height = height;
			} else if( parseInt(slide_actual_height) < 20 && self.options.device_width < 700 ){
				// set min height 200 for mobile devices
				slide_actual_height = 200;
			}
			self.slides.context.style.height = slide_actual_height + "px";
			slide.css('height', slide_actual_height + "px");

			// adjust the height of backend iframe

			var preview_iframe = parent.document.getElementById('slidedeck-preview');
			if( preview_iframe !== null ){
				var nav_height = jQuery('.slidedeck-frame .sd-nav-wrapper').height();
				preview_iframe.style.height = slide_actual_height + nav_height + 100 + "px";
			}
		}

        var buildDeck = function(){
            if($.inArray(el.css('position'),['position','absolute','fixed'])){
                el.css('position', 'relative');
            }
            el.css('overflow', 'hidden');
            for(var i=0; i<self.slides.length; i++){
                var slide = $(self.slides[i]);
                if(self.spines.length > i){
                    var spine = $(self.spines[i]);
                }

                var sPad = {
                    top: parseInt(slide.css('padding-top'),10),
                    right: parseInt(slide.css('padding-right'),10),
                    bottom: parseInt(slide.css('padding-bottom'),10),
                    left: parseInt(slide.css('padding-left'),10)
                };

                var sBorder = {
                    top: parseInt(slide.css('border-top-width'),10),
                    right: parseInt(slide.css('border-right-width'),10),
                    bottom: parseInt(slide.css('border-bottom-width'),10),
                    left: parseInt(slide.css('border-left-width'),10)
                };
                for(var k in sBorder){
                    sBorder[k] = isNaN(sBorder[k]) ? 0 : sBorder[k];
                }
                if(i < self.current) {
                    if(i === self.current - 1){
                        if(self.options.hideSpines !== true){
                            spine.addClass(self.classes.active);
                        }
                        slide.addClass(self.classes.active);
                    }
                }

				if(self.options.hideSpines === false){
					// set full width to slide for classic lense
					slide_width = width;
				}

                self.slide_width = (slide_width - sPad.left - sPad.right - sBorder.left - sBorder.right);

		        if( jQuery(".lens-tool-kit").hasClass("sd2-fullwidth")){ //for fullwidth in toolkit.
		        	self.slide_width = (jQuery(window).width() - sPad.left - sPad.right - sBorder.left - sBorder.right);
		        }
                if( jQuery(".lens-vanilla").hasClass("sd2-fullwidth")){ //for fullwidth in vanilla.
		        	self.slide_width = (jQuery(window).width() - sPad.left - sPad.right - sBorder.left - sBorder.right);
		        }
				if( jQuery(".lens-infinity").hasClass("sd2-fullwidth")){ //for fullwidth in infinity.
		        	self.slide_width = (jQuery(window).width() - sPad.left - sPad.right - sBorder.left - sBorder.right);
		        }

				var slide_height = (height - sPad.top - sPad.bottom - sBorder.top - sBorder.bottom) + "px"
                if( jQuery(".lens-testimonial").hasClass("sd2-fullwidth")){ //for fullwidth in testimonial.
                    self.slide_width = (jQuery(window).width() - sPad.left - sPad.right - sBorder.left - sBorder.right);
                    slide_height = height + "px";
                }

                var slideCSS = {
                    position: 'absolute',
                    height: slide_height,
                    width: self.slide_width + "px",
                    margin: 0,
                    paddingLeft: sPad.left + "px",
                };

                var offset = buildSlideTransition(self.options.slideTransition, i);

                slide.css(slideCSS).addClass(self.classes.slide).addClass(self.classes.slide + "_" + (i + 1));

                if (self.options.hideSpines !== true) {
                    var spinePad = {
                        top: parseInt(spine.css('padding-top'),10),
                        right: parseInt(spine.css('padding-right'),10),
                        bottom: parseInt(spine.css('padding-bottom'),10),
                        left: parseInt(spine.css('padding-left'),10)
                    };
                    for(var l in spinePad) {
                        if(spinePad[l] < 10 && (l === "left" || l === "right")){
                            spinePad[l] = 10;
                        }
                    }
                    var spinePadString = spinePad.top + "px " + spinePad.right + "px " + spinePad.bottom + "px " + spinePad.left + "px";

//var spineStyles;

if(jQuery(".slidedeck-frame.lens-classic > .slidedeck > dt").hasClass("sd2-spinePosition-horizontal")){


                   var spineStyles = {
                        position: 'absolute',
                        zIndex: 3,
                        //display: 'block',
                        left: offset,
                        width: (height) + "px",
                        height: spine_inner_width + "px",
                        padding: spinePadString,
                        rotation: '270deg',
                        '-webkit-transform': 'rotate(270deg)',
                        '-webkit-transform-origin': spine_half_width + 'px 0px',
                        '-moz-transform': 'rotate(270deg)',
                        '-moz-transform-origin': spine_half_width + 'px 0px',
                        '-ms-transform': 'rotate(270deg)',
                        '-ms-transform-origin': spine_half_width + 'px 0px',
                        '-o-transform': 'rotate(270deg)',
                        '-o-transform-origin': spine_half_width + 'px 0px',
                        textAlign: 'right'
                    };
}
else if(jQuery(".slidedeck-frame.lens-classic > .slidedeck > dt").hasClass("sd2-spinePosition-vertical")){

	var spineStyles = {
                        position: 'absolute',
                        zIndex: 3,
                        //display: 'block',
                        left: 0+"px",
                        top: offset,
                        width: (self.slide_width) + "px",
                        height: spine_inner_width + "px",
                        padding: spinePadString,
                        rotation: '0deg',
                        '-webkit-transform': 'rotate(0deg)',
                        '-webkit-transform-origin': spine_half_width + 'px 0px',
                        '-moz-transform': 'rotate(0deg)',
                        '-moz-transform-origin': spine_half_width + 'px 0px',
                        '-ms-transform': 'rotate(0deg)',
                        '-ms-transform-origin': spine_half_width + 'px 0px',
                        '-o-transform': 'rotate(0deg)',
                        '-o-transform-origin': spine_half_width + 'px 0px',
                        textAlign: 'right'
                    };
	jQuery(".slidedeck-frame.lens-classic > .slidedeck > dd").css("left",0+"px");
}

                    if( !self.browser.msie9 && !self.browser.msie10 ){
			if(jQuery(".slidedeck-frame.lens-classic > .slidedeck > dt").hasClass("sd2-spinePosition-horizontal")){
                        spineStyles.top = (self.browser.msie) ? 0 : (height - spine_half_width) + "px";
			}
                        spineStyles.marginLeft = ((self.browser.msie) ? 0 : (0 - spine_half_width)) + "px";

                        // Make layout accommodations in IE8 for RTL support. Oddly enough this is not needed for IE7.
                        var dir = document.getElementsByTagName('html')[0].dir;
                        if(dir.toLowerCase() === "rtl" && self.browser.msie8 === true){
                            spineStyles.marginLeft = (0 - height + spine_half_width*2) + "px";
                        }

                        spineStyles.filter = 'progid:DXImageTransform.Microsoft.BasicImage(rotation=3)';
                    }

                    spine.css( spineStyles ).addClass(self.classes.spine).addClass(self.classes.spine + "_" + (i + 1));

                    if(self.browser.msie9 || self.browser.msie10){
                        spine[0].style.msTransform = 'rotate(270deg)';
                        spine[0].style.msTransformOrigin = Math.round(parseInt(el[0].style.height, 10) / 2) + 'px ' + Math.round(parseInt(el[0].style.height, 10) / 2) + 'px';
                    }

                } else {
                    if(typeof(spine) !== "undefined"){
                        spine.hide();
                    }
                }
                if(i === self.slides.length-1){
                    slide.addClass('last');
                    if(self.options.hideSpines !== true){
                        spine.addClass('last');
                    }
                }

                // Add slide active corners
                if(self.options.activeCorner === true && self.options.hideSpines === false){
                    var corner = document.createElement('DIV');
                        corner.className = self.classes.activeCorner + ' ' + (self.classes.spine + '_' + (i + 1));

                    spine.after(corner);
                    spine.next('.' + self.classes.activeCorner).css({
                        position: 'absolute',
                        top: '25px',
                        left: offset + spine_outer_width + "px",
                        overflow: "hidden",
                        zIndex: "20000"
                    }).hide();
                    if(spine.hasClass(self.classes.active)){
                        spine.next('.' + self.classes.activeCorner).show();
                    }
                }

                if (self.options.hideSpines !== true) {
                    // Add spine indexes, will always be numerical if unlicensed
                    var index = document.createElement('DIV');
                        index.className = self.classes.index;

                    if(self.options.index !== false){
                        var textNode;
                        if(typeof(self.options.index) !== 'boolean'){
                            textNode = self.options.index[i%self.options.index.length];
                        } else {
                            textNode = "" + (i + 1);
                        }
                        index.appendChild(document.createTextNode(textNode));
                    }

                    spine.append(index);
		    if(jQuery(".slidedeck-frame.lens-classic > .slidedeck > dt").hasClass("sd2-spinePosition-horizontal")){
                    		spine.find('.' + self.classes.index).css({
                        	position: 'absolute',
                        	zIndex: 2,
                        	display: 'block',
                        	width: spine_inner_width + "px",
                        	height: spine_inner_width + "px",
                        	textAlign: 'center',
                        	bottom: ((self.browser.msie) ? 0 : (0 - spine_half_width)) + "px",
                        	left: ((self.browser.msie) ? 5 : 20) + "px",
                        	rotation: "90deg",
                        	'-webkit-transform': 'rotate(90deg)',
                        	'-webkit-transform-origin': spine_half_width + 'px 0px',
                        	'-moz-transform': 'rotate(90deg)',
                        	'-moz-transform-origin': spine_half_width + 'px 0px',
                        	'-o-transform': 'rotate(90deg)',
                        	'-o-transform-origin': spine_half_width + 'px 0px'
                    		});

                    		if(self.browser.msie9 || self.browser.msie10){
                        		spine.find('.' + self.classes.index)[0].style.msTransform = 'rotate(90deg)';
                    		}

                    		if(!self.browser.msie){
                       	        	spine.find('.' + self.classes.index).css({
                            		'-ms-transform': 'rotate(90deg)',
                            		'-ms-transform-origin': spine_half_width + 'px 0px'
                        		});
                    		}

		    }
		    else if(jQuery(".slidedeck-frame.lens-classic > .slidedeck > dt").hasClass("sd2-spinePosition-vertical")){
		    		spine.find('.' + self.classes.index).css({
                        	position: 'absolute',
                        	zIndex: 2,
                        	display: 'block',
                        	width: spine_inner_width + "px",
                        	height: spine_inner_width + "px",
                        	textAlign: 'center',
                        	bottom: ((self.browser.msie) ? 0 : (0 - parseInt(spine_outer_width/3))) + "px",
                        	left: ((self.browser.msie) ? 5 : 20) + "px",
                        	rotation: "0deg",
                        	'-webkit-transform': 'rotate(0deg)',
                        	'-webkit-transform-origin': spine_half_width + 'px 0px',
                        	'-moz-transform': 'rotate(0deg)',
                        	'-moz-transform-origin': spine_half_width + 'px 0px',
                        	'-o-transform': 'rotate(0deg)',
                        	'-o-transform-origin': spine_half_width + 'px 0px'
                    		});

                    		if(self.browser.msie9 || self.browser.msie10){
                        		spine.find('.' + self.classes.index)[0].style.msTransform = 'rotate(0deg)';
                    		}

                    		if(!self.browser.msie){
                       	        	spine.find('.' + self.classes.index).css({
                            		'-ms-transform': 'rotate(0deg)',
                            		'-ms-transform-origin': spine_half_width + 'px 0px'
                        		});
                    		}

		   }



                    FixIEAA(spine);
                }
            }

            updateBug();



            if(self.options.hideSpines !== true){
                // Setup Click Interaction
                self.spines.bind('click', function(event){
                    event.preventDefault();

                    //For Classic Lens AutoPlay and slide contents to not hide behind spine.
                    if(self.options.device_width > 700 ){
                        var thisParent = $(this).parent();
                        if($(thisParent).parent().is('.lens-classic')){
                            if($(thisParent).parent().is('.display-nav-always')){
                                var spinesWidthsNow = self.spines.height();
				if(jQuery(".slidedeck-frame.lens-classic > .slidedeck > dt").hasClass("sd2-spinePosition-horizontal")){
                                	$('.sd2-node-caption').css('left',(self.spines.index(this)+1)*spinesWidthsNow+'px');
 					$('.slide-content').css('left',(self.spines.index(this)+1)*spinesWidthsNow+'px');
				}
				else if(jQuery(".slidedeck-frame.lens-classic > .slidedeck > dt").hasClass("sd2-spinePosition-vertical")){
					$('.sd2-node-caption').css('top',(self.spines.index(this)+1)*spinesWidthsNow+'px');
 					$('.slide-content').css('top',(self.spines.index(this)+1)*spinesWidthsNow+'px');
				}
                                //$('.lens-classic .slide img').css('left',(self.spines.index(this)+1)*spinesWidthsNow+'px');//testing
                                flagSpineShowAlways = true;
                            }
                        }
                    }

                    self.goTo(self.spines.index(this)+1);
                });
              }


            // Setup Keyboard Interaction
            $(document).bind('keydown', function(event){
                if( !$( self.deck ).closest(".lens-prime").length && !$( self.deck ).closest(".lens-parfocal").length && ! $( self.deck ).closest(".lens-parallax").length && ! $( self.deck ).closest(".lens-layerpro").length ) {
                    if(self.options.keys !== false){
                        if($(event.target).parents().index(self.deck) === -1){
                            if(event.keyCode === 39) {
                                self.pauseAutoPlay = true;

                                self.next();
                            } else if(event.keyCode === 37) {
                                self.pauseAutoPlay = true;

                                self.prev();
                            }
                        }
                    }
                }
            });

            if(typeof($.event.special.mousewheel) !== "undefined"){
                // Setup Mouse Wheel Interaction
                el.bind("mousewheel", function(event, mousewheeldelta){
                    if( !$( self.deck ).closest(".lens-prime").length && !$( self.deck ).closest(".lens-parfocal").length && !$( self.deck ).closest(".lens-parallax").length && !$( self.deck ).closest(".lens-layerpro").length ) {
                    if(self.options.scroll !== false){
                        if(!hasVertical(event)){
                            //Initial mousewheel assignment (legacy)
                            var delta = event.detail ? event.detail : event.wheelDelta;
                            // Try new mousewheel assignment:
                            if( typeof(delta) === 'undefined' ){
                                delta = 0 - mousewheeldelta;
                            }

                            var internal = false;
                            if($(event.originalTarget).parents(self.deck).length){
                                if($.inArray(event.originalTarget.nodeName.toLowerCase(),['input','select','option','textarea']) !== -1){
                                    internal = true;
                                }
                            }

                            if (internal !== true) {
                                if (delta > 0) {
                                    switch (self.options.scroll) {
                                        case "stop":
                                            event.preventDefault();
                                        break;
                                        case true:
                                        /* falls through */
                                        default:
                                            if (self.current < self.slides.length || self.options.cycle === true) {
                                                event.preventDefault();
                                            }
                                        break;
                                    }
                                    self.pauseAutoPlay = true;
                                    self.next();
                                }
                                else {
                                    switch (self.options.scroll) {
                                        case "stop":
                                            event.preventDefault();
                                        break;
                                        case true:
                                        /* falls through */
                                        default:
                                            if (self.current !== 1 || self.options.cycle === true) {
                                                event.preventDefault();
                                            }
                                        break;
                                    }
                                    self.pauseAutoPlay = true;
                                    self.prev();
                                }
                            }
                        }
                    }
                    }
                });
            }



            if( (self.browser.msie !== true) && (self.options.touch !== false) ){
                var originalCoords = { x: 0, y: 0 };
                var finalCoords = { x: 0, y: 0 };
                var threshold = self.options.touchThreshold;
                el[0].addEventListener('touchstart', function(event){
                    originalCoords.x = event.targetTouches[0].pageX;
                    originalCoords.y = event.targetTouches[0].pageY;
                }, false);
                el[0].addEventListener('touchmove', function(event){
                    event.preventDefault();
                    finalCoords.x = event.targetTouches[0].pageX;
                    finalCoords.y = event.targetTouches[0].pageY;
                }, false);
                el[0].addEventListener('touchend', function(event){
                    var limitLeft = originalCoords.x - threshold.x;
                    var limitRight = originalCoords.x + threshold.x;
                    var limitUp = originalCoords.y - threshold.y;
                    var limitDown = originalCoords.y + threshold.y;

                    if(finalCoords.x !== 0){
                        if(finalCoords.x <= limitLeft){
                            self.pauseAutoPlay = true;
                            self.next();
                        } else if(finalCoords.x >= limitRight){
                            self.pauseAutoPlay = true;
                            self.prev();
                        }
                    }

                    if(finalCoords.y !== 0){
                        if(finalCoords.y <= limitUp){
                            self.pauseAutoPlay = true;
                            self.vertical().next();
                        } else if(finalCoords.y >= limitDown){
                            self.pauseAutoPlay = true;
                            self.vertical().prev();
                        }
                    }

                    originalCoords = { x: 0, y: 0 };
                    finalCoords = { x: 0, y: 0 };
                }, false);
            }

            $(self.spines[self.current - 2]).addClass(self.classes.previous);
            $(self.spines[self.current]).addClass(self.classes.next);

            updateAddons();
            updateControl();

            // Called only ones. So it autoplay work smoothly if window resize.
            if(self.isLoaded === false) {
                autoPlay();
            }
            self.isLoaded = true;
        };

        var getPrevValidSlide = function(ind){
            ind = Math.max(1,ind - 1);
            if($.inArray(ind,self.disabledSlides) !== -1){
                if(ind === 1){
                    ind = 1;
                } else {
                    ind = getPrevValidSlide(ind);
                }
            }
            return ind;
        };

        var getNextValidSlide = function(ind){
            ind = Math.min(self.slides.length,ind + 1);
            if($.inArray(ind,self.disabledSlides) !== -1){
                if (ind === self.slides.length) {
                    ind = self.current;
                }
                else {
                    ind = getNextValidSlide(ind);
                }
            }
            return ind;
        };

        var getValidSlide = function(ind){
            ind = Math.min(self.slides.length,Math.max(1,ind));
            if($.inArray(ind,self.disabledSlides) !== -1){
                if (ind < self.current) {
                    ind = getPrevValidSlide(ind);
                }
                else {
                    ind = getNextValidSlide(ind);
                }
            }
            return ind;
        };

        var completeCallback = function(params){
            var afterFunctions = [];
            if(typeof(self.options.complete) === "function"){
                afterFunctions.push(function(){ self.options.complete(self); });
            }
            switch(typeof(params)){
                case "function":    // Only function passed
                    afterFunctions.push(function(){ params(self); });
                break;
                case "object":        // One of a pair of functions passed
                    afterFunctions.push(function(){ params.complete(self); });
                break;
            }

            var callbackFunction = function(){
                self.looping = false;

                for(var z=0; z<afterFunctions.length; z++){
                    afterFunctions[z](self);
                }
            };

            return callbackFunction;
        };


        var transitions = {
            /**
             * Cross-fade animation
             *
             * Fades between slides. This is used as a fall-back in most cases for those transitions
             * that are not supported by the user's browser (Internet Explorer in most cases).
             */
            fade: function(ind, params, forward){
                var $currentSlide = self.slides.eq(self.current - 1);

                // Fade out other slides
                self.slides.not($currentSlide).stop().animate({
                    opacity: 0
                }, self.options.speed, function(){
                    this.style.display = "none";
                });

                // Fade in the current slide
                $currentSlide.css({
                    display: 'block',
                    opacity: 0
                }).addClass(self.classes.active).stop().animate({
                    opacity: 1
                }, self.options.speed, function(){
                    this.style.display = "block";
                    // Run the complete callback functions
                    completeCallback(params)();
                });

				// auto adjust height of div if option is set to true.

				if( self.options.auto_height || self.options.device_width < 700 ) {


					var slide_actual_height = 0;
						$($currentSlide).children('img, div').each(function(){
							var pad_top = 0;
							var bottom = 0;
							if( $( this ).hasClass( 'slide-content' ) ){
								pad_top = jQuery( this ).css('padding-top');
								bottom = jQuery( this ).css('bottom');
							}
							// video slider
							var div_height = this.clientHeight;
							if( $( this ).find('.slide-content').length ){
								div_height = $( this ).find('.slide-content').height();
								pad_top = $( this ).find('.slide-content').css('padding-top');
								bottom = $( this ).find('.slide-content').css('bottom');
							}
							if( div_height >  slide_actual_height){
								slide_actual_height = div_height + parseInt( pad_top ) + parseInt( bottom );
							}

						});

						// If calculated height is less then use default height
						if( parseInt(slide_actual_height) < 20 && self.options.device_width > 700 ){
							slide_actual_height = height;
						} else if( parseInt(slide_actual_height) < 20 && self.options.device_width < 700 ){
							// set min height 200 for mobile devices
							slide_actual_height = 200;
						}

						slide_height = slide_actual_height;
						$currentSlide.css('height',slide_height);
						$currentSlide.context.style.transition = "all 1s";
						$currentSlide.context.style.height = slide_height + "px";

						// if user is on backend then adjust the height of iframe

						var preview_iframe = parent.document.getElementById('slidedeck-preview');
						if( preview_iframe !== null ){
							var nav_height = jQuery('.slidedeck-frame .sd-nav-wrapper').height();
							preview_iframe.style.height = slide_height + nav_height + 100 + "px";
						}

				} else {
					slidedeckAdjustImage( $currentSlide );
				}
            },

            /**
             * Flip animation
             *
             * Creates a flipping effect to move between slides. This is currently only supported
             * by those browsers which have support for CSS transition effects, in other words,
             * pretty much everything but Internet Explorer.
             */
            flip: function(ind, params, forward, horizontal){
                var secondsSpeed = (self.options.speed / 1000) / 2;
                var $formerSlide = self.slides.eq(self.former - 1);
                var $currentSlide = self.slides.eq(self.current - 1);

                if(typeof(horizontal) === 'undefined'){
                    horizontal = false;
                }

                var direction = horizontal === true ? "X" : "Y";

				// adjust the height of frame if option is set to true.

				if( self.options.auto_height || self.options.device_width < 700 ) {

					var slide_actual_height = 0;

					// loop through all childrens to get the max height

							$($currentSlide).children('img, div').each(function(){
							var pad_top = 0;
							var bottom = 0;
							if( $( this ).hasClass( 'slide-content' ) ){
								pad_top = jQuery( this ).css('padding-top');
								bottom = jQuery( this ).css('bottom');
							}
							// video slider
							var div_height = this.clientHeight;
							if( $( this ).find('.slide-content').length ){
								div_height = $( this ).find('.slide-content').height();
								pad_top = $( this ).find('.slide-content').css('padding-top');
								bottom = $( this ).find('.slide-content').css('bottom');
							}
							if( div_height >  slide_actual_height){
								slide_actual_height = div_height + parseInt( pad_top ) + parseInt( bottom );
							}

						});

						// If calculated height is less then use default height
						if( parseInt(slide_actual_height) < 20 && self.options.device_width > 700 ){
							slide_actual_height = height;
						} else if( parseInt(slide_actual_height) < 20 && self.options.device_width < 700 ){
							// set min height 200 for mobile devices
							slide_actual_height = 200;
						}

						slide_height = slide_actual_height;
						$currentSlide.css('height',slide_height);
						$currentSlide.context.style.transition = "all 1s";
						$currentSlide.context.style.height = slide_height + "px";
						var preview_iframe = parent.document.getElementById('slidedeck-preview');
						if( preview_iframe !== null ){
							var nav_height = jQuery('.slidedeck-frame .sd-nav-wrapper').height();
							preview_iframe.style.height = slide_height + nav_height + 100 + "px";
						}
				} else {
					slidedeckAdjustImage( $currentSlide );
				}
                // Mask styles
                var maskCSS = {
                    position: 'absolute',
                    zIndex: 999,
                    top: 0,
                    right: 0,
                    bottom: 0,
                    left: 0,
                    width: '100%',
                    height: '100%',
                    opacity: 0
                };
                // Former slide mask
                var $formerMask = $formerSlide.find('.slidedeck-slide-mask');
                // If a mask was left over for some reason, remove it so we can start the CSS from scratch
                if($formerMask.length){
                    $formerMask.remove();
                }
                $formerSlide.append('<div class="slidedeck-slide-mask mask-out"></div>');
                $formerMask = $formerSlide.find('.slidedeck-slide-mask').css(maskCSS);

                // Current slide mask
                var $currentMask = $currentSlide.find('.slidedeck-slide-mask');
                // If a mask was left over for some reason, remove it so we can start the CSS from scratch
                if($currentMask.length){
                    $formerMask.remove();
                }
                $currentSlide.addClass(self.classes.active).append('<div class="slidedeck-slide-mask mask-in"></div>');
                maskCSS.opacity = 1;
                $currentMask = $currentSlide.find('.slidedeck-slide-mask').css(maskCSS);

                // Hide all other slides first so the transition happens properly
                var resetCSS = {};
                    resetCSS[prefix + 'transition'] = "";
                    resetCSS[prefix + 'transform-origin'] = "50% 50%";
                    resetCSS[prefix + 'transform'] = "scale" + direction + "(0)";
                self.slides.not($formerSlide).css(resetCSS);

                // Default animation CSS transform properties
                var animateCSS = {};
                    animateCSS[prefix + 'transform-origin'] = "50% 50%";

                // Currently viewed slide (the slide we're moving away from)
                animateCSS[prefix + 'transform'] = "scale" + direction + "(0)";
                $formerSlide.css(prefix + 'transition', prefix + 'transform ' + secondsSpeed + 's ease-out').css(animateCSS);
                $formerMask.animate({
                    opacity: 1
                }, {
                    duration: self.options.speed/2,
                    complete: function(){
                        $formerMask.remove();
                    }
                });

                // The slide we're moving to
                // Static animation to wait until this slide begins showing itself
                $currentMask.animate({
                    opacity: 1
                }, {
                    duration: self.options.speed/2,
                    complete: function(){
                        animateCSS[prefix + 'transform'] = "scale" + direction + "(1)";
                        $currentSlide.addClass(self.classes.active).css(prefix + 'transition', prefix + 'transform ' + secondsSpeed + 's ease-out').css(animateCSS);

                        // Start an animation to fade out slide
                        $currentMask.animate({
                            opacity: 0
                        }, {
                            dureation: self.options.speed/2,
                            complete: function(){
                                // Remove all transition effects
                                self.slides.css(prefix + 'transition', "");

                                // Snap current slide to open - maybe?
                                var finishCSS = {};
                                    finishCSS[prefix + 'transform-origin'] = "50% 50%";
                                    finishCSS[prefix + 'transform'] = "scale" + direction + "(1)";
                                self.slides.eq(self.current - 1).css(finishCSS);

                                completeCallback(params)();

                                // Clean up the masks that may be left over
                                $formerMask.remove();
                                $currentMask.remove();
                            }
                        });
                    }
                });
            },

            flipHorizontal: function(ind, params, forward){
                this.flip(ind, params, forward, true);
            },

            stack: function(ind, params, forward){

                if(
                    // Looping from first to last
                    (self.current === self.slides.length && self.former === 1) ||
                    // Looping from last to first
                    (self.former === self.slides.length && self.current === 1)
                ){
                    self.looping = true;
                }

                for (var i = 0; i < self.slides.length; i++) {
                    var pos = 0;
                    var slide = self.slides.eq(i);

                    if(self.looping === false){
                        if(i < self.current - 1) {
                            if (i === (self.current - 1)) {
                                slide.addClass(self.classes.active);
                                updateAddons();
                            }
                            pos = (0 - width);
                       }
                        else {
                            pos = 0;
                        }
                    } else {
                        if(self.former === self.slides.length && self.current === 1){
                            // Going from last to first
                            if(i === (self.current) -1){
                                slide.css({
                                    left: 0,
                                    zIndex: 5
                                }).addClass(self.classes.active);
                                updateAddons();
                                pos = 0;
                            } else {
                                if(i === (self.former - 1)){
                                    slide.css('z-index', 10);
                                    pos = 0 - width;
                                } else {
                                    slide.css('z-index', 1);
                                    pos = 0;
                                }
                            }
                        } else if(self.former === 1 && self.current === self.slides.length) {
                            // Going from first to last
                            if(i !== self.former - 1){
                                if(i === (self.current - 1)) {
                                    slide.css({
                                        left: (0 - width),
                                        zIndex: 100
                                    });
                                    slide.addClass(self.classes.active);
                                    updateAddons();
                                    pos = 0;
                                }
                            }
                        }
                    }

                    var animOpts = {
                        duration: self.options.speed,
                        easing: self.options.transition
                    };

                    // Detect a function to run after animating
                    if(i === (forward === true && self.current - 1) || i === (forward === false && self.current)){
                        animOpts.complete = function(){
                            if(self.looping === true){
                                self.slides.each(function(ind){
                                    if(ind !== (self.current - 1)) {
                                        this.style.left = (self.current === 1 ? 0 : (0 - width)) + "px";
                                    }
                                    this.style.zIndex = self.slides.length - ind;
                                });
                            }
                            completeCallback(params)();
                        };
                    }

					// adjust the height of frame if option is set to true.
					var slide_height = height;
					if( self.options.auto_height || self.options.device_width < 700 ) {
						if( i === (self.current - 1) ){

						var slide_actual_height = 0;

						// loop through all childrens to get the max height

						$(slide).children('img, div').each(function(){
							var pad_top = 0;
							var bottom = 0;
							if( $( this ).hasClass( 'slide-content' ) ){
								pad_top = jQuery( this ).css('padding-top');
								bottom = jQuery( this ).css('bottom');
							}
							// video slider
							var div_height = this.clientHeight;
							if( $( this ).find('.slide-content').length ){
								div_height = $( this ).find('.slide-content').height();
								pad_top = $( this ).find('.slide-content').css('padding-top');
								bottom = $( this ).find('.slide-content').css('bottom');
							}
							if( div_height >  slide_actual_height){
								slide_actual_height = div_height + parseInt( pad_top ) + parseInt( bottom );
							}

						});

						// If calculated height is less then use default height
						if( parseInt(slide_actual_height) < 20 && self.options.device_width > 700 ){
							slide_actual_height = height;
						} else if( parseInt(slide_actual_height) < 20 && self.options.device_width < 700 ){
							// set min height 200 for mobile devices
							slide_actual_height = 200;
						}

						slide_height = slide_actual_height;
						self.slides.context.style.height = slide_height + "px";

							var preview_iframe = parent.document.getElementById('slidedeck-preview');
							if( preview_iframe !== null ){
								var nav_height = jQuery('.slidedeck-frame .sd-nav-wrapper').height();
								preview_iframe.style.height = slide_height + nav_height + 100 + "px";
							}
						}


						slide.stop().animate({
							left: pos,
							width: self.slide_width,
							height: slide_height
						}, animOpts);

					} else {
						slide.stop().animate({
							left: pos,
							width: self.slide_width,
							height: height
						}, animOpts);
						if( i === (self.current - 1) ){
							slidedeckAdjustImage( slide );
						}
					}
                }
            },

            /**
             * Classic SlideDeck transition: Slide
             *
             * This transition will take a stack or line of slides and move them all to the left or
             * the right keeping their order.
             */
            slide: function(ind, params, forward){
                for (var i = 0; i < self.slides.length; i++) {
                    var pos = spine_pos = 0;
                    if(self.options.hideSpines !== true){
                        var spine = $(self.spines[i]);
                    }
                    var slide = $(self.slides[i]);

	                 if (i < self.current) {


                        if (i === (self.current - 1)) {
                            slide.addClass(self.classes.active);
                            if(self.options.hideSpines !== true){
                                spine.addClass(self.classes.active);
                                spine.next('.' + self.classes.activeCorner).show();
                            }
                            updateAddons();
                        }
                        pos = i * spine_outer_width;


                    }
                     else if(self.options.start == self.slides.length){

			if(jQuery(".slidedeck-frame.lens-classic > .slidedeck > dt").hasClass("sd2-spinePosition-horizontal")){
                        	pos =  (slide_width -(i * spine_outer_width)); // for last slide : By Niranjan.
			}
			else if(jQuery(".slidedeck-frame.lens-classic > .slidedeck > dt").hasClass("sd2-spinePosition-vertical")){

				pos =  (slide_height -((self.slides.length-i) * spine_outer_width)); // for last slide : By Niranjan.
			}

                    }
                    else if(self.options.start != self.slides.length ) {



		       if(jQuery(".slidedeck-frame.lens-classic > .slidedeck > dt").hasClass("sd2-spinePosition-horizontal")){
				spine_pos = i * spine_outer_width
                        	pos =  spine_pos + slide_width;
			}
			else if(jQuery(".slidedeck-frame.lens-classic > .slidedeck > dt").hasClass("sd2-spinePosition-vertical")){

				spine_pos = (self.slides.length-i) * spine_outer_width;
				pos =  slide_height - spine_pos;
			}


                    }

                    if(jQuery(self.deck.parent()).is('.display-nav-always')){
		   if(jQuery(".slidedeck-frame.lens-classic > .slidedeck > dt").hasClass("sd2-spinePosition-horizontal")){
                    jQuery('.lens-classic .slide img').css('left',(self.current * spine_outer_width));
		   }
		   else if(jQuery(".slidedeck-frame.lens-classic > .slidedeck > dt").hasClass("sd2-spinePosition-vertical")){
		    	jQuery('.lens-classic .slide img').css('top',(self.current * spine_outer_width));
		    }

					}
                    if(self.options.hideSpines === true){

                        pos = (i - self.current + 1) * el.width();
			if(jQuery(".slidedeck-frame.lens-classic > .slidedeck > dt").hasClass("sd2-spinePosition-horizontal")){
                        	pos = (i - self.current + 1) * el.width();
			}
			else if(jQuery(".slidedeck-frame.lens-classic > .slidedeck > dt").hasClass("sd2-spinePosition-vertical")){

				pos = ((self.slides.length-i) - self.current + 1) * el.height();
			}
                    }

                    var animOpts = {
                        duration: self.options.speed,
                        easing: self.options.transition
                    };

                    // Detect a function to run after animating
                    // only run it once.
                    if(i === 0) {
                        animOpts.complete = completeCallback(params);
                    }
					var slide_height = height;

					// for titles remove nav height

					if( jQuery(slide).closest('.lens-titles').length > 0 ){
						var nav_height = jQuery('.slidedeck-frame .button-nav').height();
						var padd = Math.round( parseInt( jQuery('.slidedeck-frame .button-nav').css('padding-top') ) );
						slide_height = slide_height - parseInt(nav_height) - parseInt(padd) - 15;
					}

					// adjust height
                                        $(slide).children('img').each(function(){
                                            $(this).css('margin-left','0px');
                                         });
					if( i === (self.current - 1) && ( self.options.auto_height || self.options.device_width < 700 ) ){

						var slide_actual_height = 0;

						// loop through all childrens to get the max height

						$(slide).children('img, div').each(function(){
							var pad_top = 0;
							var bottom = 0;
							if( $( this ).hasClass( 'slide-content' ) ){
								pad_top = jQuery( this ).css('padding-top');
								bottom = jQuery( this ).css('bottom');
							}
							// video slider
							var div_height = this.clientHeight;
							if( $( this ).find('.slide-content').length ){
								div_height = $( this ).find('.slide-content').height();
								pad_top = $( this ).find('.slide-content').css('padding-top');
								bottom = $( this ).find('.slide-content').css('bottom');
							}
							if( div_height >  slide_actual_height){
								slide_actual_height = div_height + parseInt( pad_top ) + parseInt( bottom );
							}

						});


						// If calculated height is less then use default height
						if( parseInt(slide_actual_height) < 20 && self.options.device_width > 700 ){
							slide_actual_height = height;
						} else if( parseInt(slide_actual_height) < 20 && self.options.device_width < 700 ){
							// set min height 200 for mobile devices
							slide_actual_height = 200;
						}

						slide_height = slide_actual_height;

						// adjust the height of iframe in backend

						var preview_iframe = parent.document.getElementById('slidedeck-preview');
						if( preview_iframe !== null ){
							var nav_height = jQuery('.slidedeck-frame .sd-nav-wrapper').height();
							preview_iframe.style.height = slide_actual_height + nav_height + 100 + "px";
						}
						self.slides.context.style.height = slide_height + "px";

					}


					if(self.options.hideSpines === true){

						// adjust the height of frame if option is set to true.
						if( self.options.auto_height || self.options.device_width < 700 ) {
							slide.stop().animate({
							left: pos + "px",
							width: self.slide_width + "px",
							height: slide_height
							}, animOpts);
						} else {

							var sPad = {
										top: parseInt(slide.css('padding-top'),10),
										right: parseInt(slide.css('padding-right'),10),
										bottom: parseInt(slide.css('padding-bottom'),10),
										left: parseInt(slide.css('padding-left'),10)
									};

							var dd_height = height;

							if( slide.closest('.layout-three-wide').length > 0 || slide.closest('.layout-peek').length > 0 ){
								height = (height - sPad.top - sPad.bottom) + "px"
							}

							// for titles remove nav height

							if( jQuery(slide).closest('.lens-titles').length > 0 ){
								var nav_height = jQuery('.slidedeck-frame .button-nav').height();
								var padd = Math.round( parseInt( jQuery('.slidedeck-frame .button-nav').css('padding-top') ) );
								dd_height = height - parseInt(nav_height) - parseInt(padd) - 15;
							}

							if( slide.find('.slidedeck-vertical-center-inner').length > 0 ){
								var nav_height = jQuery('.nav-slidedeck').height();
								var new_height = ( parseInt(height) - nav_height ) + "px";
								slide.stop().animate({
									left: pos + "px",
									width: self.slide_width + "px",
									height: new_height
									}, animOpts);
							} else {
								slide.stop().animate({
									left: pos + "px",
									width: self.slide_width + "px",
									height: dd_height
									}, animOpts);
							}
							if( i === (self.current - 1) ){
								slidedeckAdjustImage( slide );
							}
						}

					} else {

						// changed the logic for clasic lense

						if(jQuery(".slidedeck-frame.lens-classic > .slidedeck > dt").hasClass("sd2-spinePosition-horizontal")){
                        				var left_offset = 0;
							if (i === (self.current - 1)) {
								left_offset = 0;
							} else {
								left_offset = pos;
							}
							slide.stop().animate({
                        				left: left_offset + "px",
                        				width: width + "px"
							}, animOpts);
						}
						else if(jQuery(".slidedeck-frame.lens-classic > .slidedeck > dt").hasClass("sd2-spinePosition-vertical")){
							var top_offset = 0;
							if (i === (self.current - 1)) {
							top_offset = 0;
							} else {
								top_offset = pos;
							}
							slide.stop().animate({
                        				top: top_offset + "px",
                                                        left:0+"px",
                        				width: width + "px"
							}, animOpts);
						}
					}

                    if(self.options.hideSpines !== true){
						if (i === (self.current - 1)) {
							slidedeckAdjustImage( slide );
						}
                        FixIEAA(spine);
                        if(spine.css('left') !== pos+"px"){
				if(jQuery(".slidedeck-frame.lens-classic > .slidedeck > dt").hasClass("sd2-spinePosition-horizontal")){
                        		spine.stop().animate({
                                		left: pos + "px"
                            		},{
                                		duration: self.options.speed,
                                		easing: self.options.transition
                            		});

                            		spine.next('.' + self.classes.activeCorner).stop().animate({
                                		left: pos + spine_outer_width + "px"
                            		},{
                                		duration: self.options.speed,
                                		easing: self.options.transition
                            		});
				}
				else if(jQuery(".slidedeck-frame.lens-classic > .slidedeck > dt").hasClass("sd2-spinePosition-vertical")){

						spine.stop().animate({
                                		top: pos + "px",
						left: 0+"px"
                            		},{
                                		duration: self.options.speed,
                                		easing: self.options.transition
                            		});

                            		spine.next('.' + self.classes.activeCorner).stop().animate({
                                		top: slide_height-spine_pos + "px",
						left: 0+"px"
                            		},{
                                		duration: self.options.speed,
                                		easing: self.options.transition
                            		});

				}


                        }
                    }
                }
            }
        };


        var slide = function(ind, params){
            ind = getValidSlide(ind);
            if ((ind <= self.controlTo || self.options.controlProgress !== true) && self.looping === false) {
                // Determine if we are moving forward in the SlideDeck or backward,
                // this is used to determine when the callback should be run
                var forward = true;
                if(ind < self.current){
                    forward = false;
                }

                var classReset = [self.classes.active, self.classes.next, self.classes.previous].join(' ');

                self.former = self.current;
                self.current = ind;

                // Detect a function to run before animating
                if (typeof(self.options.before) === "function") {
                    self.options.before(self);
                }
                if (typeof(params) !== "undefined") {
                    if (typeof(params.before) === "function") {
                        params.before(self);
                    }
                }

                if(self.current !== self.former){
                    self.spines.removeClass(classReset);
                    self.slides.removeClass(classReset);
                    el.find('.' + self.classes.activeCorner).hide();

                    self.spines.eq(self.current - 2).addClass(self.classes.previous);
                    self.spines.eq(self.current).addClass(self.classes.next);

                    var slideTransition = 'slide';
                    if(typeof(transitions[self.options.slideTransition]) !== 'undefined'){
                        slideTransition = self.options.slideTransition;
                    }

                    transitions[slideTransition](ind, params, forward);
                }
                $(window).trigger( 'slidedeckChange', [ self.slides , ind ] );
                updateBug();
            }
        };

        var setOption = function(opts, val){
            var newOpts = opts;

            if(typeof(opts) === "string"){
                newOpts = {};
                newOpts[opts] = val;
            }

            for(var key in newOpts){
                val = newOpts[key];

                switch(key){
                    case "speed":
                    case "start":
                        val = parseFloat(val);
                        if(isNaN(val)){
                            val = self.options[key];
                        }
                    break;
                    case "autoPlay":
                        if(typeof(val) !== "boolean"){
                            val = self.options[key];
                        }
                        self.pauseAutoPlay = false;
                    break;
                    case "scroll":
                    case "keys":
                    case "activeCorner":
                    case "controlProgress":
                    case "hideSpines":
                    case "cycle":
                        if(typeof(val) !== "boolean"){
                            val = self.options[key];
                        }
                    break;
                    case "cufonRefresh":
                    case "transition":
                        if(typeof(val) !== "string"){
                            val = self.options[key];
                        }
                    break;
                    case "complete":
                    case "before":
                        if(typeof(val) !== "function"){
                            val = self.options[key];
                        }
                    break;
                    case "index":
                        if(typeof(val) !== "boolean"){
                            if(!$.isArray(val)){
                                val = self.options[key];
                            }
                        }
                    break;
                    case "slideTransition":
                        for(var k in transitions){
                            if(val === k){
                                // Fallback adjustments
                                switch(self.browser._this){
                                    case "msie":
                                    case "msie7":
                                    case "msie8":
                                    case "msie9":
                                    case "msie10":
                                      switch(val){
                                            case "flip":
                                            case "flipHorizontal":
                                                val = "fade";
                                            break;
                                        }
                                    break;
                                }

                                self.options.slideTransition = val;

                                for(var i = 0; i < self.slides.length; i++){
                                    buildSlideTransition(self.options.slideTransition, i);
                                }
                            }
                        }
                    break;
                }

                self.options[key] = val;
            }
        };


        var disableSlide = function(ind){
            if($.inArray(ind,self.disabledSlides) === -1 && ind !== 1 && ind !== 0){
                self.disabledSlides.push(ind);
            }
        };


        var enableSlide = function(ind){
            var indIndex = $.inArray(ind,self.disabledSlides);
            if(indIndex !== -1){
                self.disabledSlides.splice(indIndex,1);
            }
        };


        /**
         * VerticalSlide Class
         *
         * @author: John Botica
         * @contributors: John Botica, Dave Shepard, Jamie Hamel-Smith
         * @version: 1.0
         */
        var VerticalSlide = function(el, deck, opts){
            var self = this;

            var el = $(el);

            var elChildren = el.children();
            if(el[0].nodeName === "DL"){
                elChildren = el.children('dd');
                var elNavTitles = el.children('dt').hide();
            }

            var total = elChildren.length;
            var parentSlide = el.parents('dd.slide');
            var elParent = el.parent();
            var height = parentSlide.innerHeight();
            var zIndex = 100;

            if(deck.deck.find('.' + deck.classes.activeCorner).length){
                zIndex = deck.deck.find('.' + deck.classes.activeCorner).css('z-index') - 1;
            }

            this.navParent = null;
            this.navChildren = null;
            this.current = 0;
            this.slides = elChildren;

            this.options = {
                speed: 500,
                scroll: true,
                continueScrolling: deck.options.continueScrolling
            };
            if(typeof(opts) === 'object'){
                for(var k in opts){
                    this.options[k] = opts[k];
                }
            }

            this.classes = {
                navContainer: 'verticalSlideNav',
                arrow: 'arrow',
                prefix: 'verticalSlide'
            };

            var slide = function(index, snap, callback){
                self.current = index;

                if(typeof(self.options.before) === 'function'){
                    self.options.before(self);
                }

                if(typeof(callback) === 'object'){
                    if(typeof(callback.before) === 'function'){
                        callback.before(self);
                    }
                }

                var speed = self.options.speed;
                if(typeof(snap) !== 'undefined'){
                    speed = 0;
                }

                speed = parseInt(speed, 10);

                parentSlide.find('ul.' + self.classes.navContainer + ' li.' + self.classes.arrow).stop().animate({
                    top: $(self.navChildren[self.current]).position().top + 'px'
                }, speed);
                self.navChildren.removeClass(deck.classes.active);
                $(self.navChildren[self.current]).addClass(deck.classes.active);

                self.slides.removeClass(deck.classes.active);
                $(self.slides[index]).addClass(deck.classes.active);

				slidedeckAdjustImage( self.slides[index] );

                el.stop().animate({
                   top: 0 - (self.current * height) + 'px'
                }, {
                    duration: speed,
                    easing: deck.options.transition,
                    complete: function(){
                        if(typeof(self.options.complete) === 'function'){
                            self.options.complete(self);
                        }
                        if(typeof(callback) === 'object'){
                            if(typeof(callback.complete) === 'function'){
                                callback.complete(self);
                            }
                        }else if(typeof(callback) === 'function'){
                            callback(deck);
                        }
                    }
                });

            };

            var createVerticalNav = function(){
                var navParent = document.createElement('UL');
                    navParent.className = self.classes.navContainer;
                    navParent.style.position = 'absolute';
                    navParent.style.zIndex = zIndex;
                    navParent.style.listStyleType = 'none';

                for(var a = 0; a < total; a++){
                    var navLi = document.createElement('LI');
                        navLi.className = 'nav_' + (a + 1) + (a === 0 ? ' active' : '');
                        navLi.style.listStyleType = 'none';

                    var navChild = document.createElement('A');

                    if(elChildren[a].id){
                        navChild.href = "#" + elChildren[a].id;
                    } else {
                        navChild.href = "#" + (a + 1);
                    }
                    navChild.className = 'nav_' + (a + 1);

                    var navTitle = "Nav " + (a + 1);
                    if(typeof(elNavTitles) !== 'undefined'){
                        navTitle = elNavTitles.eq(a).html();
                    }

                    navChild.innerHTML = navTitle;
                    navLi.appendChild(navChild);
                    navParent.appendChild(navLi);
                }

                var arrow = document.createElement('LI');
                    arrow.className = self.classes.arrow;
                    arrow.style.top = 0;
                    arrow.appendChild(document.createTextNode(' '));
                navParent.appendChild(arrow);

                parentSlide.append(navParent);
                self.navChildren = parentSlide.find('.' + navParent.className + ' li');

                parentSlide.find('.' + navParent.className + ' li a').click(function(event){
                    event.preventDefault();
                    deck.pauseAutoPlay = true;
                    slide(this.className.match('nav_([0-9]+)')[1] - 1);
                });
            };

            this.goTo = function(v, h, snap){
                v = Math.min(total - 1, Math.max(0, v - 1));
                h = Math.min(deck.slides.length - 1, Math.max(0, v));
                $(deck.slides[h]).find('.' + this.classes.navContainer + ' a:eq(' + v + ')').addClass(deck.classes.active).siblings().removeClass(deck.classes.active);
                slide(v, snap);
            };

            this.next = function(callback){
                slide(Math.min(total - 1, self.current + 1), undefined, callback);
            };

            this.prev = function(callback){
                slide(Math.max(0, self.current - 1), undefined, callback);
            };

            this.snapTo = function(v, callback){
                slide(Math.max(0, Math.min(total - 1, v)), true, callback);
            };

            var initialize = function(){
                if(!parentSlide.find('.' + self.classes.navContainer).length){

                    // If not less than or equal to IE8, or is Chrome Frame, or is IE9
                    var spineOffset = (( (deck.browser.msie !== true) || deck.browser.msie9 || deck.browser.msie10 ) ? $(deck.spines[0]).outerHeight() : $(deck.spines[0]).outerWidth());
                    if(deck.options.hideSpines === true){
                        spineOffset = 0;
                    }

                    el.css({
                        position: 'absolute',
                        zIndex: zIndex - 1,
                        top: '0px',
                        left: spineOffset,
                        listStyleType: 'none',
                        padding: '0px',
                        margin: '0px',
                        width: elParent.innerWidth() - spineOffset,
                        height: height * total
                    });

                    var slidePadding = {
                        top: parseInt(elChildren.css('padding-top'),10),
                        right: parseInt(elChildren.css('padding-right'),10),
                        bottom: parseInt(elChildren.css('padding-bottom'),10),
                        left: parseInt(elChildren.css('padding-left'),10)
                    };
                    var slideBorder = {
                        top: parseInt(elChildren.css('border-top-width'),10),
                        right: parseInt(elChildren.css('border-right-width'),10),
                        bottom: parseInt(elChildren.css('border-bottom-width'),10),
                        left: parseInt(elChildren.css('border-left-width'),10)
                    };
                    for(var k in slideBorder){
                        if(isNaN(slideBorder[k])){
                            slideBorder[k] = 0;
                        }
                    }

                    var slideHeight = height - slidePadding.top - slidePadding.bottom - slideBorder.top - slideBorder.bottom;
                    var slideWidth = el.width() - slidePadding.right - slidePadding.left - slideBorder.right - slideBorder.left;

                    elChildren.each(function(ind, e){
                        $(e).css({
                            listStyleType: 'none',
                            position: 'absolute',
                            top: ind * height,
                            width: slideWidth,
                            height: slideHeight
                        }).addClass(self.classes.prefix + '_' + (ind + 1));
                    });
                    $(elChildren.get(0)).addClass(deck.classes.active);
                    elParent.css({
                        overflow: 'hidden'
                    });

                    createVerticalNav();

                    if(typeof($.event.special.mousewheel) !== "undefined"){
                        el.bind("mousewheel", function(event, mousewheeldelta){
                            if(self.options.scroll !== false){
                                //Initial mousewheel assignment (legacy)
                                var delta = event.detail ? event.detail : event.wheelDelta;
                                // Try new mousewheel assignment:
                                if( typeof(delta) === 'undefined' ){
                                    delta = 0 - mousewheeldelta;
                                }

                                var internal = false;
                                if($(event.originalTarget).parents(self.deck).length){
                                    if($.inArray(event.originalTarget.nodeName.toLowerCase(),['input','select','option','textarea']) !== -1){
                                        internal = true;
                                    }
                                }

                                if (internal !== true) {
                                    var firstSlide, lastSlide = false;
                                    if( self.options.continueScrolling === true ){
                                        if( (self.current + 1) === 1 ){
                                            firstSlide = true;
                                        }else if( (self.current + 1) === self.slides.length ){
                                            lastSlide = true;
                                        }
                                    }

                                    if (delta > 0) {
                                        event.preventDefault();
                                        deck.pauseAutoPlay = true;
                                        if( lastSlide ){
                                            deck.next();
                                            return false;
                                        }else{
                                            self.next();
                                        }
                                    } else {
                                        event.preventDefault();
                                        deck.pauseAutoPlay = true;
                                        if( firstSlide ){
                                            deck.prev();
                                            return false;
                                        }else{
                                            self.prev();
                                        }
                                    }
                                }
                            }
                        });
                    }
                }
            };

            if(height > 0){
                initialize();
            } else {
                var startupTimer;
                startupTimer = setInterval(function(){
                    el = $(el);
                    elChildren = el.children();
                    total = elChildren.length;
                    parentSlide = el.parents('.slide');
                    elParent = el.parent();
                    height = parentSlide.innerHeight();

                    if (height > 0) {
                        clearInterval(startupTimer);
                        initialize();
                    }
                }, 20);
            }
        };


        var setupDimensions = function(){
            height = el.height();
            width = el.width();

            el.css('height', height + "px");

            spine_inner_width = 0;
            spine_outer_width = 0;

            if(self.options.hideSpines !== true && self.spines.length > 0){
                spine_inner_width = $(self.spines[0]).height();
                spine_outer_width = $(self.spines[0]).outerHeight();
            }

            //slide_width = width - spine_outer_width*self.spines.length;
            //if(self.options.hideSpines === true){
            //    slide_width = width;
            //}

			// full slider width for all lenses

			slide_width = width;

            spine_half_width = Math.ceil(spine_inner_width/2);
        };


        var initialize = function(opts){
            // Halt all processing for unsupported browsers
            if((self.browser.opera && self.browser.version < "10.5") || self.browser.msie6 || self.browser.firefox2 || self.browser.firefox30){
                if(typeof(console) !== "undefined"){
                    if(typeof(console.error) === "function"){
                        console.error("This web browser is not supported by SlideDeck. Please view this page in a modern, CSS3 capable browser or a current version of Internet Explorer");
                    }
                }
                return false;
            }

            if(typeof(opts) !== "undefined"){
                for(var key in opts){
                    self.options[key] = opts[key];
                }
            }
            // Override hideSpines option if no spines are present in the DOM
            if(self.spines.length < 1){
                self.options.hideSpines = true;
            }

            // Fallback adjustments
            switch(self.browser._this){
                case "msie":
                case "msie7":
                case "msie8":
                case "msie9":
                case "msie10":
                   switch(self.options.slideTransition){
                        case "flip":
                        case "flipHorizontal":
                            self.options.slideTransition = "fade";
                        break;
                    }
                break;
            }

            // Transition option adjustments (certain transitions only work with certain settings, we accommodate for them here)
            switch(self.options.slideTransition){
                case "flip":
                case "flipHorizontal":
                case "fade":
                case "stack":
                    // Flip and fade only work with spines off, so force this
                    self.options.hideSpines = true;
                break;
            }

            // Turn off activeCorner if hideSpines is on
            if(self.options.hideSpines === true){
                self.options.activeCorner = false;
            }

            self.current = Math.min(self.slides.length,Math.max(1,self.options.start));

            if(el.height() > 0){
                setupDimensions();
                buildDeck();
            } else {
                var startupTimer;
                startupTimer = setTimeout(function(){
                    setupDimensions();
                    if(el.height() > 0){
                        clearInterval(startupTimer);
                        setupDimensions();
                        buildDeck();
                    }
                }, 20);
            }
        };


        var loaded = function(func){
            var thisTimer;
            thisTimer = setInterval(function(){
                if(self.isLoaded === true){
                    clearInterval(thisTimer);
                    func(self);
                }
            }, 20);
        };

		// global function to adjust heightadju

		this.autoAdjustAfterLoad = function(func){
            if( self.slides.length > 0 ){
				for(var i=0; i<self.slides.length; i++){
					if(i === self.current - 1){
						autoAdjustHeight(); // slidedeck-options-groups
					}
				}
			}
        };

		// reload slidedeck after orientation change

		this.reloadSlidedeck = function(func){
            buildDeck();
			if( self.slides.length > 1 ){
				for(var i=0; i<self.slides.length; i++){
					if(i === self.current - 1){
						autoAdjustHeight(); // slidedeck-options-groups
					}
				}
			}
        };


        this.loaded = function(func){
            loaded(func);
            return self;
        };

        this.next = function(params){

            var nextSlide = Math.min(self.slides.length,(self.current + 1));
            if(self.options.cycle === true){
                if(self.current + 1 > self.slides.length){
                    nextSlide = 1;
                }
            }
            slide(nextSlide,params);
            if( self.options.progressBar == true  ) {
                animateTimeline();
            }
            return self;
        };

        this.prev = function(params){

            var prevSlide = Math.max(1,(self.current - 1));
            if(self.options.cycle === true){
                if(self.current - 1 < 1){
                    prevSlide = self.slides.length;
                }
            }
            slide(prevSlide,params);
            if( self.options.progressBar == true  ) {
                animateTimeline();
            }
            return self;
        };

        this.goTo = function(ind,params){
            self.pauseAutoPlay = true;

            // If the ind value is a string, look up the slide by ID
            if(typeof(ind) === "string"){
                // Check if the string starts with a hash and prepend it if not
                if(ind === ":first"){
                    ind = self.slides.filter(':first');
                } else if(ind === ":last"){
                    ind = self.slides.filter(':last');
                } else if(!ind.match(/^\#/)){
                    ind = "#" + ind;
                }
                // Get the index of the requested element in the slides
                var slideIndex = self.slides.index($(ind));

                // If the ID exists, go to it
                if(slideIndex !== -1){
                    ind = slideIndex + 1;
                }
                // Otherwise, return false since there is no ID to go to
                else {
                    return false;
                }
            }

            slide(Math.min(self.slides.length,Math.max(1,ind)),params);
            return self;
        };

        this.progressTo = function(ind,params){
            self.pauseAutoPlay = true;
            self.updateControlTo(ind);
            self.goTo(ind,params);
            return self;
        };

        this.updateControlTo = function(ind){
            self.controlTo = ind;
            updateControl();
            return self;
        };

        this.disableSlide = function(ind){
            disableSlide(ind);
            return self;
        };

        this.enableSlide = function(ind){
            enableSlide(ind);
            return self;
        };

        this.setOption = function(opts,val){
            setOption(opts,val);
            return self;
        };

        this.vertical = function(opts){
            var self = this;

            if(typeof(this.verticalSlides) === 'undefined'){
                this.verticalSlides = {};

                for(var i = 0; i < this.slides.length; i++){
                    var slideElem = $(this.slides[i]).find('.' + this.classes.vertical);
                    var v = {
                        next: function(){ return false; },
                        prev: function(){ return false; },
                        goTo: function(){ return false; }
                    };
                    if(slideElem.length){
                        v = new VerticalSlide(slideElem, this, opts);
                    }
                    this.verticalSlides[i] = v;
                }
            } else {
                return this.verticalSlides[this.current - 1];
            }
        };

        this.goToVertical = function(v, h){
            if(typeof(h) !== 'undefined'){
                if(this.verticalSlides[h - 1] !== false){
                    if(this.current === h){
                        this.vertical().goTo(v);
                    } else {
                        this.verticalSlides[h - 1].goTo(v, h, true);
                        this.goTo(h);
                    }
                }
            } else {
                this.vertical().goTo(v);
            }
        };

        this.resetVertical = function(h, snapTo){
            if(typeof(snapTo) === 'undefined'){
                snapTo = true;
            }
            if(typeof(h) === 'undefined'){
                h = this.current;
            }
            if(snapTo === true){
                this.verticalSlides[h-1].snapTo(0);
            } else {
                this.verticalSlides[h-1].goTo(0);
            }
        };

        initialize(opts);
    };

    $.fn.slidedeck = function(opts){
        var returnArr = [];
        for(var i=0; i<this.length; i++){
            if(!this[i].slidedeck){
                this[i].slidedeck = new SlideDeck(this[i],opts);
            }
            returnArr.push(this[i].slidedeck);
        }
        return returnArr.length > 1 ? returnArr : returnArr[0];
    };

})(jQuery);
