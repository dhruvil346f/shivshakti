! function(a) {
    SlideDeckLens["tool-kit"] = function(s) {

        var e = function() {
                for (var a, s = 3, e = document.createElement("div"), n = e.getElementsByTagName("i"); e.innerHTML = "<!--[if gt IE " + ++s + "]><i></i><![endif]-->", n[0];);
                return s > 4 ? s : a
            }(),
            n = "tool-kit",
            t = a(s).slidedeck(),
            r = t.vertical(),
            d = {};
        d.slidedeck = t.deck, d.frame = d.slidedeck.closest(".lens-" + n), d.slides = t.slides, d.deckWrapper = d.frame.find(".sd-wrapper"), d.horizNav = d.frame.find(".deck-navigation.horizontal"), d.horizNavPrev = d.frame.find(".deck-navigation.horizontal.prev"), d.horizNavNext = d.frame.find(".deck-navigation.horizontal.next"), d.vertNav = d.frame.find(".deck-navigation.vertical"), d.vertNavPrev = d.frame.find(".deck-navigation.vertical.prev"), d.vertNavNext = d.frame.find(".deck-navigation.vertical.next"), d.slidedeck.find(".sd2-slide-text a").addClass("accent-color"), t.loaded(function(s) {
            var n = !1;
            d.frame.find(".slidesVertical").length && (n = !0), n && (d.slides = s.vertical().slides, r.options.scroll = s.options.scroll ? !0 : !1);

//var slidedeck_frame = jQuery(".slidedeck-frame");
var parent_frame = d.frame.parent();

slidedeck_fullwidth = function() {
    
                    var slidedeck_width = jQuery( window ).width(); 
                    parent_frame.css({
                       "width" : slidedeck_width,
                       "max-width" : slidedeck_width,
                       "left" : ( 0 - parent_frame.parent().offset().left ),
                    });
                    var parent_style = parent_frame.attr('style');
                    parent_frame.attr( 'style', parent_style + 'width: ' + slidedeck_width + 'px !important;');
		    d.frame.css({'width': slidedeck_width+'px','height':"auto",'left':( 0 - parent_frame.offset().left ) + 'px'});
		    		
		    d.frame.find("dl dd.slide").addClass("sd-fullwidth-active");
		    d.frame.find(".sd-fullwidth-active").css({'width': slidedeck_width + 'px !important' , 'margin-top' : 0+'px'}); 	
                   
                   var parent_frame_height;
                   if(slidedeck_width < 700) {
                       parent_frame_height = parent_frame.find('img').height()+40;
                   } else {
                       parent_frame_height = d.frame.height() + 40
                   }
                }     /* .css({'max-width': '100% !important'}); */           
               
 if( d.frame.parent('.slidedeck-fullwidth-wrapper').length > 0 ) {
                    slidedeck_fullwidth();
                }

            var t = function() {
                    d.frame.hasClass("sd2-frame") && jQuery('<div class="sd-lens-shadow-top"></div><div class="sd-lens-shadow-left"></div><div class="sd-lens-shadow-corner"></div>').appendTo(d.slidedeck)
                },
                i = function() {
                    if (!d.frame.hasClass("sd2-nav-none")) {

			if(d.frame.hasClass("sd2-nav-video")){
				d.frame.addClass("sd2-nav-dots");
			}
                        if (deckCount = d.slides.length, jQuery('<div class="sd-nav-wrapper"></div>').appendTo(d.deckWrapper), d.navWrapper = d.frame.find(".sd-nav-wrapper"), jQuery(d.navWrapper).css("box-sizing", "border-box"), jQuery('<dl class="sd-nav-deck"></dl>').appendTo(d.navWrapper), d.navDeck = d.navWrapper.find(".sd-nav-deck"), n && d.frame.hasClass("sd2-nav-thumb") && (jQuery('<dd><dl class="slidesVertical"></dl></dd>').appendTo(d.navDeck), d.verticalSlides = d.navDeck.find(".slidesVertical")), d.frame.hasClass("sd2-nav-dots")) {
			    
			    if(! d.frame.hasClass("sd2-nav-video")){	
                            for (var t = 1; deckCount >= t;) jQuery('<dd class="sd-nav-dot"></dd>').appendTo(d.navDeck), t++;
                            }
			    else if( d.frame.hasClass("sd2-nav-video")){
			    d.navDeck.find('.sd-nav-deck').css({'width':"100% !important"});	
			    a(d.slidedeck).slidedeck().options.autoPlay = true;
			   
		   	    jQuery('<span class="sd-nav-start "></dd>').appendTo(d.navDeck),d.navDeck.find(".sd-nav-start").click(function(){
						if(jQuery(".sd-nav-start").hasClass('sd-nav-start-active')){
						a(d.slidedeck).slidedeck().options.autoPlay = true;

					            d.navDeck.find(".sd-nav-start").css({"background-position": "-24px 0"});
						    d.navDeck.find(".sd-nav-stop").css({"background-position": "0px -24px"});
						    d.navDeck.find(".sd-nav-start").removeClass("sd-nav-start-active");	
						}


});
				for (var t = 1; deckCount >= t;) jQuery('<dd class="sd-nav-dot"></dd>').appendTo(d.navDeck), t++;
                                jQuery('<span class="sd-nav-stop"></dd>').appendTo(d.navDeck),d.navDeck.find(".sd-nav-stop").click(function(){
					if(!(jQuery(".sd-nav-start").hasClass('sd-nav-start-active'))){
						a(d.slidedeck).slidedeck().options.autoPlay = false;
						d.navDeck.find(".sd-nav-start").css({"background-position": "0px 0"});
                                                d.navDeck.find(".sd-nav-stop").css({"background-position": "-24px -24px"});
						d.navDeck.find(".sd-nav-start").addClass("sd-nav-start-active");
					}
					
});;
			    }	

                            if (d.navDots = d.navDeck.find(".sd-nav-dot"), d.navDots.click(function() {
                                    a(d.slidedeck).slidedeck().options.autoPlay = !1, s.options.pauseAutoPlay = !0;
                                     var e = jQuery(this),
                                        t = "active";
				
				if( d.frame.hasClass("sd2-nav-video")){
					var rNavPos = r.goTo(e.index());
					var sNavPos = s.goTo(e.index());  
				}
				 else if(! d.frame.hasClass("sd2-nav-video"))
				{
					var rNavPos = r.goTo(e.index()+1);
					var sNavPos = s.goTo(e.index()+1);
				}
                                    d.frame.hasClass("sd2-nav-hanging") && (t = "accent-color-background"), d.navDots.removeClass("accent-color-background active"), e.addClass(t), n ? rNavPos : sNavPos
                                }), n) {
                                dotSpacing = parseInt(d.navDots.outerHeight() + 10), d.navDots.first().css("margin-top", 0);
                                var i = dotSpacing * d.navDots.length;
                                d.navDeck.css({
                                    height: i
                                }), d.navWrapper.css({
                                    height: i,
                                    "margin-top": -1 * Math.round(i / 2)
                                })
                            } else dotSpacing = parseInt(d.navDots.outerWidth() + 10), d.navDeck.css("width", dotSpacing * d.navDots.length - parseInt(d.navDots.last().css("margin-left"), 10));
                            if (!d.frame.hasClass("sd2-nav-bar") && !d.frame.hasClass("sd2-nav-hanging") && !n) {
                                var o = parseInt(d.frame.css("padding-left"), 10) + 20;
                                if (d.frame.hasClass("sd2-nav-pos-top")) var v = o,
                                    h = "auto";
                                else var v = "auto",
                                    h = o;
                                var f = -(d.navWrapper.width() / 2);
                                d.frame.hasClass("sd2-nav-dots") && d.frame.hasClass("sd2-nav-pos-top") && !d.frame.hasClass("sd2-nav-default") && (f = 0), d.frame.hasClass("sd2-nav-dots") && d.frame.hasClass("sd2-nav-pos-top") && d.frame.hasClass("sd2-nav-hanging") && (v /= 2), d.navWrapper.css({
                                    "margin-left": f,
                                    top: v,
                                    bottom: h
                                })
                            }
                            if (d.frame.hasClass("sd2-nav-default") && !d.frame.hasClass("sd2-title-pos-top") && !d.frame.hasClass("sd2-hide-title") && !d.frame.hasClass("sd2-title-pos-bottom") && d.frame.hasClass("sd2-nav-dots") && !d.frame.hasClass("sd2-small"))
                                if (n) d.frame.hasClass("sd2-nav-default") && d.frame.hasClass("sd2-nav-dots") && !d.frame.hasClass("sd2-small") && d.navWrapper.css({
                                    "margin-top": f + m
                                });
                                else {
                                    var p = d.frame.find(".sd-node-title-box").outerWidth();
                                    if (d.frame.hasClass("sd2-title-pos-right")) var m = -(p / 2);
                                    else if (d.frame.hasClass("sd2-title-pos-left")) var m = p / 2;
                                    d.navWrapper.css({
                                        "margin-left": f + m
                                    })
                                }
                            var u = "active";
                            d.frame.hasClass("sd2-nav-hanging") && (u = "accent-color-background"), a(".sd-nav-dot").eq(s.current - 1).addClass(u), n && l(s.options.startVertical - 1)
                        }
                        if (d.frame.hasClass("sd2-nav-hanging") && d.navWrapper.appendTo(d.frame), d.frame.hasClass("sd2-nav-thumb")) {
                            var g = 73;
                            d.frame.hasClass("sd2-nav-arrow-style-2") && d.frame.hasClass("sd2-nav-bar") && (g = 85), n ? (d.frame.hasClass("sd2-small") && (g = 55), d.frame.hasClass("sd2-nav-arrow-style-2") && d.frame.hasClass("sd2-nav-bar") && d.frame.hasClass("sd2-small") && (g = 58), d.navWrapper.css({
                                "padding-top": g,
                                "padding-bottom": g
                            }), d.navWrapper.css("height", d.slidedeck.outerHeight()), d.navDeck.css("height", d.slidedeck.outerHeight() - 2 * g), d.navWrapper.css({
                                "margin-top": Math.round(d.navWrapper.outerHeight() * -.5),
                                top: "50%"
                            })) : (d.navWrapper.css({
                                "padding-left": g,
                                "padding-right": g
                            }), d.navWrapper.css("width", d.slidedeck.outerWidth()), d.navDeck.css("width", d.slidedeck.outerWidth() - 2 * g), d.navWrapper.css({
                                "margin-left": Math.round(d.navWrapper.outerWidth() * -.5),
                                left: "50%"
                            })), d.navDeck.addClass("thumb");
                            for (var t = 1; deckCount >= t;) jQuery('<span class="sd-thumb sd2-custom-title-font"><span class="number">' + t + '</span><span class="inner-image"></span></span>').appendTo(n ? d.verticalSlides : d.navDeck), 8 >= e ? d.frame.find("span.sd-thumb .inner-image").eq(t - 1)[0].style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + d.slides.eq(t - 1).attr("data-thumbnail-src") + "', sizingMethod='scale')" : d.frame.find("span.sd-thumb .inner-image").eq(t - 1).css("background-image", "url(" + d.slides.eq(t - 1).attr("data-thumbnail-src") + ")"), t++;
                            if (singleThumb = d.frame.find(".sd-thumb"), n) {
                                thumbHeight = singleThumb.height(), thumbSpacing = parseInt(singleThumb.last().css("margin-bottom")), fullThumb = thumbHeight + thumbSpacing, thumbsPerSlide = Math.floor((d.frame.find(".sd-nav-wrapper").height() + thumbSpacing) / fullThumb);
                                var k = d.verticalSlides.children(".sd-thumb")
                            } else {
                                thumbWidth = parseInt(singleThumb.css("width"), 10), thumbSpacing = parseInt(singleThumb.last().css("margin-left"), 10), fullThumb = thumbWidth + thumbSpacing, thumbsPerSlide = Math.floor((d.frame.find(".sd-nav-wrapper").width() + thumbSpacing) / fullThumb);
                                var k = d.navDeck.children(".sd-thumb")
                            }
                            k.remove();
                            for (var t = 0; deckCount > t;)(0 == t || t % thumbsPerSlide == 0) && jQuery('<dd class="thumb-slide"></dd>').appendTo(n ? d.verticalSlides : d.navDeck), jQuery(k[t]).appendTo(d.navDeck.find(".thumb-slide").last()), t++;
                            n ? (d.verticalSlides.children("dd").wrapInner('<div class="nav-centered"></div>'), d.navDeck.find(".nav-centered").each(function() {
                                var s = Math.round(parseInt(a(this).find(".sd-thumb").last().css("margin-bottom")) / 2);
                                a(this).css({
                                    "margin-top": a(this).outerHeight() * -.5 + s,
                                    "margin-left": a(this).outerWidth() * -.5
                                })
                            })) : (d.navDeck.children("dd").wrapInner('<div class="nav-centered"></div>'), d.navDeck.find(".nav-centered").each(function() {
                                var s = a(this),
                                    e = s.find(".sd-thumb").length,
                                    n = fullThumb * e;
                                s.css("width", n)
                            })), d.navDeck.show();
                            
                            var b = !1;
                            s.options.cycle && (b = !0);
                            var C = {
                                hideSpines: !0,
                                cycle: b,
                                keys: !1,
                                scroll: !1
                            };
                            d.navSlideDeck = d.navDeck.slidedeck(C), d.navSlideDeck.vertical(C), d.thumbs = d.navDeck.find(".sd-thumb"), d.navDeck.delegate(".sd-thumb", "click", function(e) {
                                e.preventDefault();
                                var t = a.data(this, "$this"),
                                    i = a.data(this, "thumbIndex");
                                this.style.backgroundColor = "", d.thumbs.removeClass("active accent-color-background"), t.addClass("active accent-color-background"), n ? (a(d.slidedeck).slidedeck().options.autoPlay = !1, s.options.pauseAutoPlay = !0, r.goTo(i + 1)) : s.goTo(i + 1)
                            }).delegate(".sd-thumb", "mouseenter", function() {
                                var s = a.data(this, "$this"),
                                    e = a.data(this, "thumbIndex");
                                s || (s = a(this), a.data(this, "$this", s)), e || (e = d.thumbs.index(s), a.data(this, "thumbIndex", e));
                                var n = s.css("background-color"),
                                    t = Raphael.getRGB(n),
                                    r = Raphael.rgb2hsl(t.r, t.g, t.b);
                                r.l = Math.min(100, 120 * r.l) / 100;
                                var i = Raphael.hsl(r.h, r.s, r.l);
                                s.css("background-color", i)
                            }).delegate(".sd-thumb", "mouseleave", function() {
                                this.style.backgroundColor = ""
                            }), d.navSlides = d.navDeck.find("dd"), n && (d.navSlides = d.navDeck.find(".slidesVertical dd")), d.navSlides.length > 1 && (jQuery('<a class="deck-navigation-arrows prev" href="#prev" target="_blank"><span>Prev</span></a><a class="deck-navigation-arrows next" href="#next" target="_blank"><span>Next</span></a>').appendTo(d.navWrapper), d.navArrows = d.navWrapper.find(".deck-navigation-arrows"), d.navArrows.click(function(s) {
                                switch (s.preventDefault(), a.data(d.navDeck[0], "pauseAutoPaginate", !0), this.href.split("#")[1]) {
                                    case "next":
                                        d.navSlideDeck.next();
                                        break;
                                    case "prev":
                                        d.navSlideDeck.prev()
                                }
                            })), d.frame.find(".sd-nav-deck .sd-thumb").eq(s.current - 1).addClass("active accent-color-background"), n ? c(s.options.startVertical - 1) : d.navSlideDeck.goTo(d.navDeck.find(".chrome-thumb.active").parents("dd").index() + 1)
                            d.frame.find(".sd-nav-deck .thumb-slide").css({"max-width":"100%"});
                        }
                    }
                },
                o = function() {
                    n && (s = r);
                    var e = s.options.before;
                    if (n && d.frame.hasClass("sd2-nav-thumb") && (d.navSlideDeck = d.navSlideDeck.vertical()), s.options.before = function(s) {
                            if ("function" == typeof e && e(s), d.frame.hasClass("sd2-nav-dots")) {
                                var t = "active";
                                d.frame.hasClass("sd2-nav-hanging") && (t = "accent-color-background"), d.navDots.removeClass(t), d.navDots.eq(s.current - 1).addClass(t), l(n ? s.current : s.current - 1)
                            } else d.frame.hasClass("sd2-nav-thumb") && (c(s.current), a.data(d.navDeck[0], "pauseAutoPaginate") || d.navSlideDeck.goTo(d.navDeck.find(".sd-thumb.active").parents("dd").index() + 1), a.data(d.navDeck[0], "pauseAutoPaginate", !1))
                        }, n) {
                        var t = r.options.complete;
                        r.options.complete = function(a) {
                            "function" == typeof t && t(a), d.frame.hasClass("sd2-nav-dots") || d.frame.hasClass("sd2-nav-thumb")
                        }
                    }
                },
                l = function(s) {
                    if (d.navDots) {
                        var e = "active";
                        d.frame.hasClass("sd2-nav-hanging") && (e = "accent-color-background"), d.navDots.removeClass("accent-color-background active"), a(d.navDots[s]).addClass(e)
                    }
                },
                c = function(s) {
                    if (d.thumbs) {
                        n || s--;
                        var e = "accent-color-background active";
                        d.thumbs.removeClass(e), a(d.thumbs[s]).addClass(e)
                    }
                },
                v = function() {
                    "undefined" != typeof a.event.special.mousewheel && d.frame.bind("mousewheel", function(a, s) {
                        r.options && r.options.scroll && (1 == s ? l(r.current) : -1 == s && l(r.current))
                    })
                },
                h = function() {
                    "undefined" != typeof a.event.special.mousewheel && d.frame.bind("mousewheel", function(a, s) {
                        r.options && r.options.scroll && (1 == s ? c(r.current) : -1 == s && c(r.current))
                    })
                },
                f = function() {
                    if (d.frame.hasClass("sd2-nav-hanging"), d.frame.hasClass("sd2-frame") && d.frame.hasClass("sd2-nav-pos-top") && d.frame.hasClass("sd2-nav-bar") && d.frame.css("padding-bottom", parseInt(d.frame.css("padding-left"), 10)), d.frame.hasClass("sd2-nav-pos-top") && d.frame.hasClass("sd2-frame") && d.frame.hasClass("sd2-nav-hanging") && d.navWrapper.appendTo(d.frame), d.frame.hasClass("sd2-nav-thumb") && d.frame.hasClass("sd2-nav-arrow-style-2"))
                        if (n) {
                            var a = d.navWrapper.outerWidth();
                            d.navWrapper.find(".deck-navigation-arrows").css("height", a)
                        } else {
                            var s = d.navWrapper.outerHeight();
                            d.navWrapper.find(".deck-navigation-arrows").css("width", s)
                        }
                    var e, t = 0;
                    d.frame.hasClass("sd2-small") ? e = 3 : d.frame.hasClass("sd2-medium") ? e = 10 : d.frame.hasClass("sd2-large") && (e = 10), d.frame.hasClass("sd2-frame") && (t = 5), d.frame.hasClass("sd2-frame") && (d.horizNavPrev.css("left", parseInt(d.horizNavPrev.css("left")) + e), d.horizNavNext.css("right", parseInt(d.horizNavNext.css("right")) + e)), d.frame.hasClass("sd2-no-nav") || (d.frame.hasClass("sd2-nav-pos-top") ? d.frame.is(".sd2-nav-bar") && d.horizNav.css("marginTop", parseInt(d.horizNav.css("marginTop")) + Math.round(d.frame.find(".sd-nav-wrapper").outerHeight() / 2) - t) : (!d.frame.hasClass("sd2-frame") || d.frame.hasClass("sd2-nav-bar")) && d.frame.is(".sd2-nav-bar, .sd2-nav-hanging") && d.horizNav.css("marginTop", parseInt(d.horizNav.css("marginTop")) - Math.round(d.frame.find(".sd-nav-wrapper").outerHeight() / 2) + t))
                };
            i(), t(), o(), f(), v(), h()
        })
    }, a(document).ready(function() {
        a(".lens-tool-kit .slidedeck").each(function() {
            ("undefined" == typeof a.data(this, "lens-tool-kit") || null == a.data(this, "lens-tool-kit")) && a.data(this, "lens-tool-kit", new SlideDeckLens["tool-kit"](this))
        })
    })

}(jQuery);
