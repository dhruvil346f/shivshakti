! function(e) {
    SlideDeckSkin.fashion = function(a) {
        function n(a, n) {
            if (!n) var n = !1;
            var i, s, d, l = '<dl class="sd-nav">';
            return t.horizontalSlides.each(function(a) {
                var r = a + 1;
                if (1 == r && (l += '<dd><table class="deck-navigation-table" border="0" cellpadding="0" cellspacing="0"><tr>'), l += '<td><a href="#nav-' + r + '"><span class="deck-nav-front"><span class="deck-nav-inner">' + r + '</span></span><span class="deck-nav-back accent-color-background">&nbsp;</span>', e(this).hasClass("has-image") ? l += '<span class="deck-navigation-image-tip"><span>&nbsp;</span></span>' : e(this).hasClass("no-image") && (l += '<span class="deck-navigation-image-tip no-image"><span>&nbsp;</span></span>'), l += "</a></td>", r % n === 0 && r != c.slideCount && (i = r, s = t.horizontalSlides.length - i, d = n - s, l += '</tr></table></dd><dd><table class="deck-navigation-table" border="0" cellpadding="0" cellspacing="0"><tr>'), r == c.slideCount) {
                    if (d)
                        for (var o = 0; d > o; o++) l += '<td><span class="spacer">&nbsp;</span></td>';
                    l += "</tr></table></dd>"
                }
            }), l += "</dl>"
        }
        var i = function() {
                for (var e, a = 3, n = document.createElement("div"), i = n.getElementsByTagName("i"); n.innerHTML = "<!--[if gt IE " + ++a + "]><i></i><![endif]-->", i[0];);
                return a > 4 ? a : e
            }(),
            s = "fashion",
            d = e(a).slidedeck(),
            t = {};
        t.slidedeck = d.deck, t.frame = t.slidedeck.closest(".lens-" + s), t.horizontalSlides = d.slides, t.frame.append('<div class="slidedeck-nav"><div class="accent-bar-top accent-color-background">&nbsp;</div><div class="deck-navigation-inner"></div></div>'), t.horizontalSlides.each(function() {
            e(this).find(".slide-title span").last().css({
                "padding-right": "0.3em"
            })
        });
        var l, c = {
            navItemWidth: 30,
            navigationParent: e(t.frame).find(".slidedeck-nav"),
            navigationInner: e(t.frame).find(".deck-navigation-inner"),
            slideCount: t.horizontalSlides.length
        };
        c.navigationWidth = c.navigationInner.width(), c.slideCount * c.navItemWidth < c.navigationWidth ? (c.navigationParent.removeClass("paged"), t.navItems = n(!1)) : (c.navigationParent.addClass("paged"), c.navigationInner.append('<a href="#prev-nav" class="deck-pagination prev"><span class="front">Previous<span class="deck-pagination-inner">&nbsp;</span></span><span class="back accent-color-background">&nbsp;</span></a><a href="#next-nav" class="deck-pagination next"><span class="front">Next<span class="deck-pagination-inner">&nbsp;</span></span><span class="back accent-color-background">&nbsp;</span></a>'), t.navPrev = c.navigationInner.find("a.deck-pagination.prev"), t.navNext = c.navigationInner.find("a.deck-pagination.next"), c.navigationWidth = c.navigationInner.width(), c.navItemsPerSlide = Math.floor(c.navigationWidth / c.navItemWidth), t.navItems = n(!0, c.navItemsPerSlide)), c.navigationInner.append(t.navItems), t.navDeck = t.frame.find("dl.sd-nav"), t.navDeck.wrap('<div class="sd-nav-wrapper"></div>'), t.navDeckNavItems = t.navDeck.find("a"), t.navigationImageTips = t.frame.find("span.deck-navigation-image-tip > span"), t.horizontalSlides.each(function(e) {
            var a = t.horizontalSlides.eq(e);
            if (a.hasClass("has-image")) {
                var n = a.css("background-image");
                "none" == n && a.find(".sd2-slide-background").length && (n = a.find(".sd2-slide-background").css("background-image")), n.match(/url\([\"\'](.*)[\"\']\)/) && (n = n.match(/url\([\"\'](.*)[\"\']\)/)[1]);
                var s = a.attr("data-thumbnail-src");
                8 >= i ? (t.navigationImageTips.eq(e).css({
                    background: "none"
                }), t.navigationImageTips[e].style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + s + "', sizingMethod='scale')", a.css({
                    background: "none"
                }), t.horizontalSlides[e].style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + imgurl + "', sizingMethod='scale')") : t.navigationImageTips.eq(e).css({
                    backgroundImage: "url(" + s + ")"
                })
            }
        }), t.slidedeck.slidedeck().loaded(function() {
            t.slidedeck.activeSlide = t.slidedeck.find("li.active"), t.slidedeck.activeSlideIndex = t.horizontalSlides.index(t.slidedeck.activeSlide), t.currentNav = e(t.frame).find(".sd-nav a:eq(" + [t.slidedeck.activeSlideIndex] + ")"), t.currentNav.addClass("active"), c.currentNavSlideNumber = Math.floor(t.slidedeck.activeSlideIndex / c.navItemsPerSlide), l = t.navDeck.slidedeck({
                scroll: !1,
                keys: !1,
                hideSpines: !0,
                speed: 250,
                cycle: !0,
                start: c.currentNavSlideNumber + 1,
                complete: function(a) {
                    0 == t.slidedeck.slidedeck().options.cycle && (a.current == a.slides.length ? (e(t.navNext).addClass("disabled"), e(t.navPrev).removeClass("disabled")) : 1 == a.current ? (e(t.navPrev).addClass("disabled"), e(t.navNext).removeClass("disabled")) : (e(t.navPrev).removeClass("disabled"), e(t.navNext).removeClass("disabled")))
                }
            }).loaded(function() {
                var a = t.frame.find(".slidedeck-nav"),
                    n = t.frame.find(".slidedeck-nav .deck-navigation-table");
                a.addClass("behind"), n.bind("mouseenter mouseleave", function(e) {
                    "mouseenter" == e.type ? a.removeClass("behind") : a.addClass("behind")
                });
                var i = c.currentNavSlideNumber + 1;
                0 == d.options.cycle && (l.options.cycle = !1, i == l.slides.length ? e(t.navNext).addClass("disabled") : 1 == i && e(t.navPrev).addClass("disabled")), t.navDeckNavItems.each(function() {
                    e(this).click(function(a) {
                        a.preventDefault();
                        var n = t.navDeckNavItems.index(e(this));
                        t.navDeckNavItems.removeClass("active"), e(this).addClass("active"), d.goTo(n + 1)
                    })
                })
            }), t.frame.find("a.deck-pagination").click(function(a) {
                a.preventDefault(), l.options.pauseAutoPlay = !0, e(this).hasClass("prev") ? l.prev() : l.next()
            }), t.frame.find(".deck-navigation").bind("click", function(e) {
                e.preventDefault();
                var a = this.href.split("#")[1];
                d.pauseAutoPlay = !0, "next" == a ? d.next() : "prev" == a && d.prev()
            });
            var a = t.slidedeck.slidedeck().options.before,
                n = t.slidedeck.slidedeck().options.complete,
                i = t.slidedeck.slidedeck();
            t.slidedeck.slidedeck().options.before = function(n) {
                "function" == typeof a && a(n);
                var s = (t.slidedeck.activeSlideIndex, i.current),
                    d = s - 1,
                    r = Math.floor(d / c.navItemsPerSlide);
                t.navDeckNavItems.removeClass("active"), e(t.navDeckNavItems[d]).addClass("active"), r != c.currentNavSlideNumber && (l.goTo(r + 1), c.currentNavSlideNumber = r)
            }, t.slidedeck.slidedeck().options.complete = function(e) {
                "function" == typeof n && n(e)
            }
        }), d.slides.each(function(e) {
            var a = d.slides.eq(e),
                n = a.find(".sd2-slide-title .sd2-slide-title-inner");
            // if (a.find(".sd2-slide-title, .sd2-slide-title a").removeClass("accent-color"), n.find("a").length) var n = n.find("a");
            var i = jQuery.trim(n.text()),
                s = i.split(" "),
                t = !0;
            for (var l in s) s[l] = 1 == t ? '<span class="first">' + s[l] + "</span>" : "<span>" + s[l] + "</span>", t = !1;
            // n.html('<span class="before-rule">&nbsp;</span>' + s.join("") + '<span class="after-rule">&nbsp;</span>'), a.find("div.sd2-node-caption").append('<div class="accent-bar-top accent-color-background">&nbsp;</div>')
        }), t.slidedeck.find(".play-video-alternative").addClass("accent-color-background")
    }, e(document).ready(function() {
        e(".lens-fashion .slidedeck").each(function() {
            ("undefined" == typeof e.data(this, "lens-fashion") || null == e.data(this, "lens-fashion")) && e.data(this, "lens-fashion", new SlideDeckSkin.fashion(this))
        })
    })
}(jQuery);