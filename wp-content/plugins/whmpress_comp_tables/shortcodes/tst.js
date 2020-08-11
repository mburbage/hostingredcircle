/**
 * Created by fokado on 8/11/2016.
 */

!function (e) {
    "use strict";
    "function" == typeof define && define.amd ? define(["jquery"], e) : "undefined" != typeof exports ? module.exports = e(require("jquery")) : e(jQuery)
}(function (e) {
    "use strict";
    var i = window.Slick || {};
    i = function () {
        function i(i, o) {
            var s, n = this;
            n.defaults = {
                accessibility: !0,
                adaptiveHeight: !1,
                appendArrows: e(i),
                appendDots: e(i),
                arrows: !0,
                asNavFor: null,
                prevArrow: '<button type="button" data-role="none" class="slick-prev" aria-label="Previous" tabindex="0" role="button"><div class="slick-prev-inner"><br /><br />More<br />support</div></button>',
                nextArrow: '<button type="button" data-role="none" class="slick-next" aria-label="Next" tabindex="0" role="button"><div class="slick-next-inner"><br /><br />More<br />&nbsp;&nbsp;control&nbsp;&nbsp;</div></button>',
                autoplay: !1,
                autoplaySpeed: 3e3,
                centerMode: !1,
                centerPadding: "50px",
                cssEase: "ease",
                customPaging: function (e, i) {
                    return '<button type="button" data-role="none" role="button" aria-required="false" tabindex="0">' + (i + 1) + "</button>"
                },
                dots: !1,
                dotsClass: "slick-dots",
                draggable: !0,
                easing: "linear",
                edgeFriction: .35,
                fade: !1,
                focusOnSelect: !1,
                infinite: !0,
                initialSlide: 0,
                lazyLoad: "ondemand",
                mobileFirst: !1,
                pauseOnHover: !0,
                pauseOnDotsHover: !1,
                respondTo: "window",
                responsive: null,
                rows: 1,
                rtl: !1,
                slide: "",
                slidesPerRow: 1,
                slidesToShow: 1,
                slidesToScroll: 1,
                speed: 500,
                swipe: !0,
                swipeToSlide: !1,
                touchMove: !0,
                touchThreshold: 5,
                useCSS: !0,
                variableWidth: !1,
                vertical: !1,
                verticalSwiping: !1,
                waitForAnimate: !0,
                zIndex: 1e3
            }, n.initials = {
                animating: !1,
                dragging: !1,
                autoPlayTimer: null,
                currentDirection: 0,
                currentLeft: null,
                currentSlide: 0,
                direction: 1,
                $dots: null,
                listWidth: null,
                listHeight: null,
                loadIndex: 0,
                $nextArrow: null,
                $prevArrow: null,
                slideCount: null,
                slideWidth: null,
                $slideTrack: null,
                $slides: null,
                sliding: !1,
                slideOffset: 0,
                swipeLeft: null,
                $list: null,
                touchObject: {},
                transformsEnabled: !1,
                unslicked: !1
            }, e.extend(n, n.initials), n.activeBreakpoint = null, n.animType = null, n.animProp = null, n.breakpoints = [], n.breakpointSettings = [], n.cssTransitions = !1, n.hidden = "hidden", n.paused = !1, n.positionProp = null, n.respondTo = null, n.rowCount = 1, n.shouldClick = !0, n.$slider = e(i), n.$slidesCache = null, n.transformType = null, n.transitionType = null, n.visibilityChange = "visibilitychange", n.windowWidth = 0, n.windowTimer = null, s = e(i).data("slick") || {}, n.options = e.extend({}, n.defaults, s, o), n.currentSlide = n.options.initialSlide, n.originalSettings = n.options, "undefined" != typeof document.mozHidden ? (n.hidden = "mozHidden", n.visibilityChange = "mozvisibilitychange") : "undefined" != typeof document.webkitHidden && (n.hidden = "webkitHidden", n.visibilityChange = "webkitvisibilitychange"), n.autoPlay = e.proxy(n.autoPlay, n), n.autoPlayClear = e.proxy(n.autoPlayClear, n), n.changeSlide = e.proxy(n.changeSlide, n), n.clickHandler = e.proxy(n.clickHandler, n), n.selectHandler = e.proxy(n.selectHandler, n), n.setPosition = e.proxy(n.setPosition, n), n.swipeHandler = e.proxy(n.swipeHandler, n), n.dragHandler = e.proxy(n.dragHandler, n), n.keyHandler = e.proxy(n.keyHandler, n), n.autoPlayIterator = e.proxy(n.autoPlayIterator, n), n.instanceUid = t++, n.htmlExpr = /^(?:\s*(<[\w\W]+>)[^>]*)$/, n.registerBreakpoints(), n.init(!0), n.checkResponsive(!0)
        }

        var t = 0;
        return i
    }(), i.prototype.addSlide = i.prototype.slickAdd = function (i, t, o) {
        var s = this;
        if ("boolean" == typeof t)o = t, t = null; else if (t < 0 || t >= s.slideCount)return !1;
        s.unload(), "number" == typeof t ? 0 === t && 0 === s.$slides.length ? e(i).appendTo(s.$slideTrack) : o ? e(i).insertBefore(s.$slides.eq(t)) : e(i).insertAfter(s.$slides.eq(t)) : o === !0 ? e(i).prependTo(s.$slideTrack) : e(i).appendTo(s.$slideTrack), s.$slides = s.$slideTrack.children(this.options.slide), s.$slideTrack.children(this.options.slide).detach(), s.$slideTrack.append(s.$slides), s.$slides.each(function (i, t) {
            e(t).attr("data-slick-index", i)
        }), s.$slidesCache = s.$slides, s.reinit()
    }, i.prototype.animateHeight = function () {
        var e = this;
        if (1 === e.options.slidesToShow && e.options.adaptiveHeight === !0 && e.options.vertical === !1) {
            var i = e.$slides.eq(e.currentSlide).outerHeight(!0);
            e.$list.animate({height: i}, e.options.speed)
        }
    }, i.prototype.animateSlide = function (i, t) {
        var o = {}, s = this;
        s.animateHeight(), s.options.rtl === !0 && s.options.vertical === !1 && (i = -i), s.transformsEnabled === !1 ? s.options.vertical === !1 ? s.$slideTrack.animate({left: i}, s.options.speed, s.options.easing, t) : s.$slideTrack.animate({top: i}, s.options.speed, s.options.easing, t) : s.cssTransitions === !1 ? (s.options.rtl === !0 && (s.currentLeft = -s.currentLeft), e({animStart: s.currentLeft}).animate({animStart: i}, {
            duration: s.options.speed,
            easing: s.options.easing,
            step: function (e) {
                e = Math.ceil(e), s.options.vertical === !1 ? (o[s.animType] = "translate(" + e + "px, 0px)", s.$slideTrack.css(o)) : (o[s.animType] = "translate(0px," + e + "px)", s.$slideTrack.css(o))
            },
            complete: function () {
                t && t.call()
            }
        })) : (s.applyTransition(), i = Math.ceil(i), s.options.vertical === !1 ? o[s.animType] = "translate3d(" + i + "px, 0px, 0px)" : o[s.animType] = "translate3d(0px," + i + "px, 0px)", s.$slideTrack.css(o), t && setTimeout(function () {
            s.disableTransition(), t.call()
        }, s.options.speed))
    }, i.prototype.asNavFor = function (i) {
        var t = this, o = t.options.asNavFor;
        o && null !== o && (o = e(o).not(t.$slider)), null !== o && "object" == typeof o && o.each(function () {
            var t = e(this).slick("getSlick");
            t.unslicked || t.slideHandler(i, !0)
        })
    }, i.prototype.applyTransition = function (e) {
        var i = this, t = {};
        i.options.fade === !1 ? t[i.transitionType] = i.transformType + " " + i.options.speed + "ms " + i.options.cssEase : t[i.transitionType] = "opacity " + i.options.speed + "ms " + i.options.cssEase, i.options.fade === !1 ? i.$slideTrack.css(t) : i.$slides.eq(e).css(t)
    }, i.prototype.autoPlay = function () {
        var e = this;
        e.autoPlayTimer && clearInterval(e.autoPlayTimer), e.slideCount > e.options.slidesToShow && e.paused !== !0 && (e.autoPlayTimer = setInterval(e.autoPlayIterator, e.options.autoplaySpeed))
    }, i.prototype.autoPlayClear = function () {
        var e = this;
        e.autoPlayTimer && clearInterval(e.autoPlayTimer)
    }, i.prototype.autoPlayIterator = function () {
        var e = this;
        e.options.infinite === !1 ? 1 === e.direction ? (e.currentSlide + 1 === e.slideCount - 1 && (e.direction = 0), e.slideHandler(e.currentSlide + e.options.slidesToScroll)) : (e.currentSlide - 1 === 0 && (e.direction = 1), e.slideHandler(e.currentSlide - e.options.slidesToScroll)) : e.slideHandler(e.currentSlide + e.options.slidesToScroll)
    }, i.prototype.buildArrows = function () {
        var i = this;
        i.options.arrows === !0 && (i.$prevArrow = e(i.options.prevArrow).addClass("slick-arrow"), i.$nextArrow = e(i.options.nextArrow).addClass("slick-arrow"), i.slideCount > i.options.slidesToShow ? (i.$prevArrow.removeClass("slick-hidden").removeAttr("aria-hidden tabindex"), i.$nextArrow.removeClass("slick-hidden").removeAttr("aria-hidden tabindex"), i.htmlExpr.test(i.options.prevArrow) && i.$prevArrow.prependTo(i.options.appendArrows), i.htmlExpr.test(i.options.nextArrow) && i.$nextArrow.appendTo(i.options.appendArrows), i.options.infinite !== !0 && i.$prevArrow.addClass("slick-disabled").attr("aria-disabled", "true")) : i.$prevArrow.add(i.$nextArrow).addClass("slick-hidden").attr({
            "aria-disabled": "true",
            tabindex: "-1"
        }))
    }, i.prototype.buildDots = function () {
        var i, t, o = this;
        if (o.options.dots === !0 && o.slideCount > o.options.slidesToShow) {
            for (t = '<ul class="' + o.options.dotsClass + '">', i = 0; i <= o.getDotCount(); i += 1)t += "<li>" + o.options.customPaging.call(this, o, i) + "</li>";
            t += "</ul>", o.$dots = e(t).appendTo(o.options.appendDots), o.$dots.find("li").first().addClass("slick-active").attr("aria-hidden", "false")
        }
    }, i.prototype.buildOut = function () {
        var i = this;
        i.$slides = i.$slider.children(i.options.slide + ":not(.slick-cloned)").addClass("slick-slide"), i.slideCount = i.$slides.length, i.$slides.each(function (i, t) {
            e(t).attr("data-slick-index", i).data("originalStyling", e(t).attr("style") || "")
        }), i.$slidesCache = i.$slides, i.$slider.addClass("slick-slider"), i.$slideTrack = 0 === i.slideCount ? e('<div class="slick-track"/>').appendTo(i.$slider) : i.$slides.wrapAll('<div  class="slick-track"/>').parent(), i.$list = i.$slideTrack.wrap('<div class="container"><div   aria-live="polite" class="slick-list"/>').parent(), i.$slideTrack.css("opacity", 0), i.options.centerMode !== !0 && i.options.swipeToSlide !== !0 || (i.options.slidesToScroll = 1), e("img[data-lazy]", i.$slider).not("[src]").addClass("slick-loading"), i.setupInfinite(), i.buildArrows(), i.buildDots(), i.updateDots(), i.setSlideClasses("number" == typeof i.currentSlide ? i.currentSlide : 0), i.options.draggable === !0 && i.$list.addClass("draggable")
    }, i.prototype.buildRows = function () {
        var e, i, t, o, s, n, r, l = this;
        if (o = document.createDocumentFragment(), n = l.$slider.children(), l.options.rows > 1) {
            for (r = l.options.slidesPerRow * l.options.rows, s = Math.ceil(n.length / r), e = 0; e < s; e++) {
                var d = document.createElement("div");
                for (i = 0; i < l.options.rows; i++) {
                    var a = document.createElement("div");
                    for (t = 0; t < l.options.slidesPerRow; t++) {
                        var c = e * r + (i * l.options.slidesPerRow + t);
                        n.get(c) && a.appendChild(n.get(c))
                    }
                    d.appendChild(a)
                }
                o.appendChild(d)
            }
            l.$slider.html(o), l.$slider.children().children().children().css({
                width: 100 / l.options.slidesPerRow + "%",
                display: "inline-block"
            })
        }
    }, i.prototype.checkResponsive = function (i, t) {
        var o, s, n, r = this, l = !1, d = r.$slider.width(), a = window.innerWidth || e(window).width();
        if ("window" === r.respondTo ? n = a : "slider" === r.respondTo ? n = d : "min" === r.respondTo && (n = Math.min(a, d)), r.options.responsive && r.options.responsive.length && null !== r.options.responsive) {
            s = null;
            for (o in r.breakpoints)r.breakpoints.hasOwnProperty(o) && (r.originalSettings.mobileFirst === !1 ? n < r.breakpoints[o] && (s = r.breakpoints[o]) : n > r.breakpoints[o] && (s = r.breakpoints[o]));
            null !== s ? null !== r.activeBreakpoint ? (s !== r.activeBreakpoint || t) && (r.activeBreakpoint = s, "unslick" === r.breakpointSettings[s] ? r.unslick(s) : (r.options = e.extend({}, r.originalSettings, r.breakpointSettings[s]), i === !0 && (r.currentSlide = r.options.initialSlide), r.refresh(i)), l = s) : (r.activeBreakpoint = s, "unslick" === r.breakpointSettings[s] ? r.unslick(s) : (r.options = e.extend({}, r.originalSettings, r.breakpointSettings[s]), i === !0 && (r.currentSlide = r.options.initialSlide), r.refresh(i)), l = s) : null !== r.activeBreakpoint && (r.activeBreakpoint = null, r.options = r.originalSettings, i === !0 && (r.currentSlide = r.options.initialSlide), r.refresh(i), l = s), i || l === !1 || r.$slider.trigger("breakpoint", [r, l])
        }
    }, i.prototype.changeSlide = function (i, t) {
        var o, s, n, r = this, l = e(i.target);
        switch (l.is("a") && i.preventDefault(), l.is("li") || (l = l.closest("li")), n = r.slideCount % r.options.slidesToScroll !== 0, o = n ? 0 : (r.slideCount - r.currentSlide) % r.options.slidesToScroll, i.data.message) {
            case"previous":
                s = 0 === o ? r.options.slidesToScroll : r.options.slidesToShow - o, r.slideCount > r.options.slidesToShow && r.slideHandler(r.currentSlide - s, !1, t);
                break;
            case"next":
                s = 0 === o ? r.options.slidesToScroll : o, r.slideCount > r.options.slidesToShow && r.slideHandler(r.currentSlide + s, !1, t);
                break;
            case"index":
                var d = 0 === i.data.index ? 0 : i.data.index || l.index() * r.options.slidesToScroll;
                r.slideHandler(r.checkNavigable(d), !1, t), l.children().trigger("focus");
                break;
            default:
                return
        }
    }, i.prototype.checkNavigable = function (e) {
        var i, t, o = this;
        if (i = o.getNavigableIndexes(), t = 0, e > i[i.length - 1])e = i[i.length - 1]; else for (var s in i) {
            if (e < i[s]) {
                e = t;
                break
            }
            t = i[s]
        }
        return e
    }, i.prototype.cleanUpEvents = function () {
        var i = this;
        i.options.dots && null !== i.$dots && (e("li", i.$dots).off("click.slick", i.changeSlide), i.options.pauseOnDotsHover === !0 && i.options.autoplay === !0 && e("li", i.$dots).off("mouseenter.slick", e.proxy(i.setPaused, i, !0)).off("mouseleave.slick", e.proxy(i.setPaused, i, !1))), i.options.arrows === !0 && i.slideCount > i.options.slidesToShow && (i.$prevArrow && i.$prevArrow.off("click.slick", i.changeSlide), i.$nextArrow && i.$nextArrow.off("click.slick", i.changeSlide)), i.$list.off("touchstart.slick mousedown.slick", i.swipeHandler), i.$list.off("touchmove.slick mousemove.slick", i.swipeHandler), i.$list.off("touchend.slick mouseup.slick", i.swipeHandler), i.$list.off("touchcancel.slick mouseleave.slick", i.swipeHandler), i.$list.off("click.slick", i.clickHandler), e(document).off(i.visibilityChange, i.visibility), i.$list.off("mouseenter.slick", e.proxy(i.setPaused, i, !0)), i.$list.off("mouseleave.slick", e.proxy(i.setPaused, i, !1)), i.options.accessibility === !0 && i.$list.off("keydown.slick", i.keyHandler), i.options.focusOnSelect === !0 && e(i.$slideTrack).children().off("click.slick", i.selectHandler), e(window).off("orientationchange.slick.slick-" + i.instanceUid, i.orientationChange), e(window).off("resize.slick.slick-" + i.instanceUid, i.resize), e("[draggable!=true]", i.$slideTrack).off("dragstart", i.preventDefault), e(window).off("load.slick.slick-" + i.instanceUid, i.setPosition), e(document).off("ready.slick.slick-" + i.instanceUid, i.setPosition)
    }, i.prototype.cleanUpRows = function () {
        var e, i = this;
        i.options.rows > 1 && (e = i.$slides.children().children(), e.removeAttr("style"), i.$slider.html(e))
    }, i.prototype.clickHandler = function (e) {
        var i = this;
        i.shouldClick === !1 && (e.stopImmediatePropagation(), e.stopPropagation(), e.preventDefault())
    }, i.prototype.destroy = function (i) {
        var t = this;
        t.autoPlayClear(), t.touchObject = {}, t.cleanUpEvents(), e(".slick-cloned", t.$slider).detach(), t.$dots && t.$dots.remove(), t.options.arrows === !0 && (t.$prevArrow && t.$prevArrow.length && (t.$prevArrow.removeClass("slick-disabled slick-arrow slick-hidden").removeAttr("aria-hidden aria-disabled tabindex").css("display", ""), t.htmlExpr.test(t.options.prevArrow) && t.$prevArrow.remove()), t.$nextArrow && t.$nextArrow.length && (t.$nextArrow.removeClass("slick-disabled slick-arrow slick-hidden").removeAttr("aria-hidden aria-disabled tabindex").css("display", ""), t.htmlExpr.test(t.options.nextArrow) && t.$nextArrow.remove())), t.$slides && (t.$slides.removeClass("slick-slide slick-active slick-center slick-visible slick-current").removeAttr("aria-hidden").removeAttr("data-slick-index").each(function () {
            e(this).attr("style", e(this).data("originalStyling"))
        }), t.$slideTrack.children(this.options.slide).detach(), t.$slideTrack.detach(), t.$list.detach(), t.$slider.append(t.$slides)), t.cleanUpRows(), t.$slider.removeClass("slick-slider"), t.$slider.removeClass("slick-initialized"), t.unslicked = !0, i || t.$slider.trigger("destroy", [t])
    }, i.prototype.disableTransition = function (e) {
        var i = this, t = {};
        t[i.transitionType] = "", i.options.fade === !1 ? i.$slideTrack.css(t) : i.$slides.eq(e).css(t)
    }, i.prototype.fadeSlide = function (e, i) {
        var t = this;
        t.cssTransitions === !1 ? (t.$slides.eq(e).css({zIndex: t.options.zIndex}), t.$slides.eq(e).animate({opacity: 1}, t.options.speed, t.options.easing, i)) : (t.applyTransition(e), t.$slides.eq(e).css({
            opacity: 1,
            zIndex: t.options.zIndex
        }), i && setTimeout(function () {
            t.disableTransition(e), i.call()
        }, t.options.speed))
    }, i.prototype.fadeSlideOut = function (e) {
        var i = this;
        i.cssTransitions === !1 ? i.$slides.eq(e).animate({
            opacity: 0,
            zIndex: i.options.zIndex - 2
        }, i.options.speed, i.options.easing) : (i.applyTransition(e), i.$slides.eq(e).css({
            opacity: 0,
            zIndex: i.options.zIndex - 2
        }))
    }, i.prototype.filterSlides = i.prototype.slickFilter = function (e) {
        var i = this;
        null !== e && (i.unload(), i.$slideTrack.children(this.options.slide).detach(), i.$slidesCache.filter(e).appendTo(i.$slideTrack), i.reinit())
    }, i.prototype.getCurrent = i.prototype.slickCurrentSlide = function () {
        var e = this;
        return e.currentSlide
    }, i.prototype.getDotCount = function () {
        var e = this, i = 0, t = 0, o = 0;
        if (e.options.infinite === !0)for (; i < e.slideCount;)++o, i = t + e.options.slidesToShow, t += e.options.slidesToScroll <= e.options.slidesToShow ? e.options.slidesToScroll : e.options.slidesToShow; else if (e.options.centerMode === !0)o = e.slideCount; else for (; i < e.slideCount;)++o, i = t + e.options.slidesToShow, t += e.options.slidesToScroll <= e.options.slidesToShow ? e.options.slidesToScroll : e.options.slidesToShow;
        return o - 1
    }, i.prototype.getLeft = function (e) {
        var i, t, o, s = this, n = 0;
        return s.slideOffset = 0, t = s.$slides.first().outerHeight(!0), s.options.infinite === !0 ? (s.slideCount > s.options.slidesToShow && (s.slideOffset = s.slideWidth * s.options.slidesToShow * -1, n = t * s.options.slidesToShow * -1), s.slideCount % s.options.slidesToScroll !== 0 && e + s.options.slidesToScroll > s.slideCount && s.slideCount > s.options.slidesToShow && (e > s.slideCount ? (s.slideOffset = (s.options.slidesToShow - (e - s.slideCount)) * s.slideWidth * -1, n = (s.options.slidesToShow - (e - s.slideCount)) * t * -1) : (s.slideOffset = s.slideCount % s.options.slidesToScroll * s.slideWidth * -1, n = s.slideCount % s.options.slidesToScroll * t * -1))) : e + s.options.slidesToShow > s.slideCount && (s.slideOffset = (e + s.options.slidesToShow - s.slideCount) * s.slideWidth, n = (e + s.options.slidesToShow - s.slideCount) * t), s.slideCount <= s.options.slidesToShow && (s.slideOffset = 0, n = 0), s.options.centerMode === !0 && s.options.infinite === !0 ? s.slideOffset += s.slideWidth * Math.floor(s.options.slidesToShow / 2) - s.slideWidth : s.options.centerMode === !0 && (s.slideOffset = 0, s.slideOffset += s.slideWidth * Math.floor(s.options.slidesToShow / 2)), i = s.options.vertical === !1 ? e * s.slideWidth * -1 + s.slideOffset : e * t * -1 + n, s.options.variableWidth === !0 && (o = s.slideCount <= s.options.slidesToShow || s.options.infinite === !1 ? s.$slideTrack.children(".slick-slide").eq(e) : s.$slideTrack.children(".slick-slide").eq(e + s.options.slidesToShow), i = o[0] ? o[0].offsetLeft * -1 : 0, s.options.centerMode === !0 && (o = s.options.infinite === !1 ? s.$slideTrack.children(".slick-slide").eq(e) : s.$slideTrack.children(".slick-slide").eq(e + s.options.slidesToShow + 1), i = o[0] ? o[0].offsetLeft * -1 : 0, i += (s.$list.width() - o.outerWidth()) / 2)), i
    }, i.prototype.getOption = i.prototype.slickGetOption = function (e) {
        var i = this;
        return i.options[e]
    }, i.prototype.getNavigableIndexes = function () {
        var e, i = this, t = 0, o = 0, s = [];
        for (i.options.infinite === !1 ? e = i.slideCount : (t = i.options.slidesToScroll * -1, o = i.options.slidesToScroll * -1, e = 2 * i.slideCount); t < e;)s.push(t), t = o + i.options.slidesToScroll, o += i.options.slidesToScroll <= i.options.slidesToShow ? i.options.slidesToScroll : i.options.slidesToShow;
        return s
    }, i.prototype.getSlick = function () {
        return this
    }, i.prototype.getSlideCount = function () {
        var i, t, o, s = this;
        return o = s.options.centerMode === !0 ? s.slideWidth * Math.floor(s.options.slidesToShow / 2) : 0, s.options.swipeToSlide === !0 ? (s.$slideTrack.find(".slick-slide").each(function (i, n) {
            if (n.offsetLeft - o + e(n).outerWidth() / 2 > s.swipeLeft * -1)return t = n, !1
        }), i = Math.abs(e(t).attr("data-slick-index") - s.currentSlide) || 1) : s.options.slidesToScroll
    }, i.prototype.goTo = i.prototype.slickGoTo = function (e, i) {
        var t = this;
        t.changeSlide({data: {message: "index", index: parseInt(e)}}, i)
    }, i.prototype.init = function (i) {
        var t = this;
        e(t.$slider).hasClass("slick-initialized") || (e(t.$slider).addClass("slick-initialized"), t.buildRows(), t.buildOut(), t.setProps(), t.startLoad(), t.loadSlider(), t.initializeEvents(), t.updateArrows(), t.updateDots()), i && t.$slider.trigger("init", [t]), t.options.accessibility === !0 && t.initADA()
    }, i.prototype.initArrowEvents = function () {
        var e = this;
        e.options.arrows === !0 && e.slideCount > e.options.slidesToShow && (e.$prevArrow.on("click.slick", {message: "previous"}, e.changeSlide), e.$nextArrow.on("click.slick", {message: "next"}, e.changeSlide))
    }, i.prototype.initDotEvents = function () {
        var i = this;
        i.options.dots === !0 && i.slideCount > i.options.slidesToShow && e("li", i.$dots).on("click.slick", {message: "index"}, i.changeSlide), i.options.dots === !0 && i.options.pauseOnDotsHover === !0 && i.options.autoplay === !0 && e("li", i.$dots).on("mouseenter.slick", e.proxy(i.setPaused, i, !0)).on("mouseleave.slick", e.proxy(i.setPaused, i, !1))
    }, i.prototype.initializeEvents = function () {
        var i = this;
        i.initArrowEvents(), i.initDotEvents(), i.$list.on("touchstart.slick mousedown.slick", {action: "start"}, i.swipeHandler), i.$list.on("touchmove.slick mousemove.slick", {action: "move"}, i.swipeHandler), i.$list.on("touchend.slick mouseup.slick", {action: "end"}, i.swipeHandler), i.$list.on("touchcancel.slick mouseleave.slick", {action: "end"}, i.swipeHandler), i.$list.on("click.slick", i.clickHandler), e(document).on(i.visibilityChange, e.proxy(i.visibility, i)), i.$list.on("mouseenter.slick", e.proxy(i.setPaused, i, !0)), i.$list.on("mouseleave.slick", e.proxy(i.setPaused, i, !1)), i.options.accessibility === !0 && i.$list.on("keydown.slick", i.keyHandler), i.options.focusOnSelect === !0 && e(i.$slideTrack).children().on("click.slick", i.selectHandler), e(window).on("orientationchange.slick.slick-" + i.instanceUid, e.proxy(i.orientationChange, i)), e(window).on("resize.slick.slick-" + i.instanceUid, e.proxy(i.resize, i)), e("[draggable!=true]", i.$slideTrack).on("dragstart", i.preventDefault), e(window).on("load.slick.slick-" + i.instanceUid, i.setPosition), e(document).on("ready.slick.slick-" + i.instanceUid, i.setPosition)
    }, i.prototype.initUI = function () {
        var e = this;
        e.options.arrows === !0 && e.slideCount > e.options.slidesToShow && (e.$prevArrow.show(), e.$nextArrow.show()), e.options.dots === !0 && e.slideCount > e.options.slidesToShow && e.$dots.show(), e.options.autoplay === !0 && e.autoPlay()
    }, i.prototype.keyHandler = function (e) {
        var i = this;
        e.target.tagName.match("TEXTAREA|INPUT|SELECT") || (37 === e.keyCode && i.options.accessibility === !0 ? i.changeSlide({data: {message: "previous"}}) : 39 === e.keyCode && i.options.accessibility === !0 && i.changeSlide({data: {message: "next"}}))
    }, i.prototype.lazyLoad = function () {
        function i(i) {
            e("img[data-lazy]", i).each(function () {
                var i = e(this), t = e(this).attr("data-lazy"), o = document.createElement("img");
                o.onload = function () {
                    i.animate({opacity: 0}, 100, function () {
                        i.attr("src", t).animate({opacity: 1}, 200, function () {
                            i.removeAttr("data-lazy").removeClass("slick-loading")
                        })
                    })
                }, o.src = t
            })
        }

        var t, o, s, n, r = this;
        r.options.centerMode === !0 ? r.options.infinite === !0 ? (s = r.currentSlide + (r.options.slidesToShow / 2 + 1), n = s + r.options.slidesToShow + 2) : (s = Math.max(0, r.currentSlide - (r.options.slidesToShow / 2 + 1)), n = 2 + (r.options.slidesToShow / 2 + 1) + r.currentSlide) : (s = r.options.infinite ? r.options.slidesToShow + r.currentSlide : r.currentSlide, n = s + r.options.slidesToShow, r.options.fade === !0 && (s > 0 && s--, n <= r.slideCount && n++)), t = r.$slider.find(".slick-slide").slice(s, n), i(t), r.slideCount <= r.options.slidesToShow ? (o = r.$slider.find(".slick-slide"), i(o)) : r.currentSlide >= r.slideCount - r.options.slidesToShow ? (o = r.$slider.find(".slick-cloned").slice(0, r.options.slidesToShow), i(o)) : 0 === r.currentSlide && (o = r.$slider.find(".slick-cloned").slice(r.options.slidesToShow * -1), i(o))
    }, i.prototype.loadSlider = function () {
        var e = this;
        e.setPosition(), e.$slideTrack.css({opacity: 1}), e.$slider.removeClass("slick-loading"), e.initUI(), "progressive" === e.options.lazyLoad && e.progressiveLazyLoad()
    }, i.prototype.next = i.prototype.slickNext = function () {
        var e = this;
        e.changeSlide({data: {message: "next"}})
    }, i.prototype.orientationChange = function () {
        var e = this;
        e.checkResponsive(), e.setPosition()
    }, i.prototype.pause = i.prototype.slickPause = function () {
        var e = this;
        e.autoPlayClear(), e.paused = !0
    }, i.prototype.play = i.prototype.slickPlay = function () {
        var e = this;
        e.paused = !1, e.autoPlay()
    }, i.prototype.postSlide = function (e) {
        var i = this;
        i.$slider.trigger("afterChange", [i, e]), i.animating = !1, i.setPosition(), i.swipeLeft = null, i.options.autoplay === !0 && i.paused === !1 && i.autoPlay(), i.options.accessibility === !0 && i.initADA()
    }, i.prototype.prev = i.prototype.slickPrev = function () {
        var e = this;
        e.changeSlide({data: {message: "previous"}})
    }, i.prototype.preventDefault = function (e) {
        e.preventDefault()
    }, i.prototype.progressiveLazyLoad = function () {
        var i, t, o = this;
        i = e("img[data-lazy]", o.$slider).length, i > 0 && (t = e("img[data-lazy]", o.$slider).first(), t.attr("src", t.attr("data-lazy")).removeClass("slick-loading").load(function () {
            t.removeAttr("data-lazy"), o.progressiveLazyLoad(), o.options.adaptiveHeight === !0 && o.setPosition()
        }).error(function () {
            t.removeAttr("data-lazy"), o.progressiveLazyLoad()
        }))
    }, i.prototype.refresh = function (i) {
        var t = this, o = t.currentSlide;
        t.destroy(!0), e.extend(t, t.initials, {currentSlide: o}), t.init(), i || t.changeSlide({
            data: {
                message: "index",
                index: o
            }
        }, !1)
    }, i.prototype.registerBreakpoints = function () {
        var i, t, o, s = this, n = s.options.responsive || null;
        if ("array" === e.type(n) && n.length) {
            s.respondTo = s.options.respondTo || "window";
            for (i in n)if (o = s.breakpoints.length - 1, t = n[i].breakpoint, n.hasOwnProperty(i)) {
                for (; o >= 0;)s.breakpoints[o] && s.breakpoints[o] === t && s.breakpoints.splice(o, 1), o--;
                s.breakpoints.push(t), s.breakpointSettings[t] = n[i].settings
            }
            s.breakpoints.sort(function (e, i) {
                return s.options.mobileFirst ? e - i : i - e
            })
        }
    }, i.prototype.reinit = function () {
        var i = this;
        i.$slides = i.$slideTrack.children(i.options.slide).addClass("slick-slide"), i.slideCount = i.$slides.length, i.currentSlide >= i.slideCount && 0 !== i.currentSlide && (i.currentSlide = i.currentSlide - i.options.slidesToScroll), i.slideCount <= i.options.slidesToShow && (i.currentSlide = 0), i.registerBreakpoints(), i.setProps(), i.setupInfinite(), i.buildArrows(), i.updateArrows(), i.initArrowEvents(), i.buildDots(), i.updateDots(), i.initDotEvents(), i.checkResponsive(!1, !0), i.options.focusOnSelect === !0 && e(i.$slideTrack).children().on("click.slick", i.selectHandler), i.setSlideClasses(0), i.setPosition(), i.$slider.trigger("reInit", [i]), i.options.autoplay === !0 && i.focusHandler()
    }, i.prototype.resize = function () {
        var i = this;
        e(window).width() !== i.windowWidth && (clearTimeout(i.windowDelay), i.windowDelay = window.setTimeout(function () {
            i.windowWidth = e(window).width(), i.checkResponsive(), i.unslicked || i.setPosition()
        }, 50))
    }, i.prototype.removeSlide = i.prototype.slickRemove = function (e, i, t) {
        var o = this;
        return "boolean" == typeof e ? (i = e, e = i === !0 ? 0 : o.slideCount - 1) : e = i === !0 ? --e : e, !(o.slideCount < 1 || e < 0 || e > o.slideCount - 1) && (o.unload(), t === !0 ? o.$slideTrack.children().remove() : o.$slideTrack.children(this.options.slide).eq(e).remove(), o.$slides = o.$slideTrack.children(this.options.slide), o.$slideTrack.children(this.options.slide).detach(), o.$slideTrack.append(o.$slides), o.$slidesCache = o.$slides, void o.reinit())
    }, i.prototype.setCSS = function (e) {
        var i, t, o = this, s = {};
        o.options.rtl === !0 && (e = -e), i = "left" == o.positionProp ? Math.ceil(e) + "px" : "0px", t = "top" == o.positionProp ? Math.ceil(e) + "px" : "0px", s[o.positionProp] = e, o.transformsEnabled === !1 ? o.$slideTrack.css(s) : (s = {}, o.cssTransitions === !1 ? (s[o.animType] = "translate(" + i + ", " + t + ")", o.$slideTrack.css(s)) : (s[o.animType] = "translate3d(" + i + ", " + t + ", 0px)", o.$slideTrack.css(s)))
    }, i.prototype.setDimensions = function () {
        var e = this;
        e.options.vertical === !1 ? e.options.centerMode === !0 && e.$list.css({padding: "0px " + e.options.centerPadding}) : (e.$list.height(e.$slides.first().outerHeight(!0) * e.options.slidesToShow), e.options.centerMode === !0 && e.$list.css({padding: e.options.centerPadding + " 0px"})), e.listWidth = e.$list.width(), e.listHeight = e.$list.height(), e.options.vertical === !1 && e.options.variableWidth === !1 ? (e.slideWidth = Math.ceil(e.listWidth / e.options.slidesToShow), e.$slideTrack.width(Math.ceil(e.slideWidth * e.$slideTrack.children(".slick-slide").length))) : e.options.variableWidth === !0 ? e.$slideTrack.width(5e3 * e.slideCount) : (e.slideWidth = Math.ceil(e.listWidth), e.$slideTrack.height(Math.ceil(e.$slides.first().outerHeight(!0) * e.$slideTrack.children(".slick-slide").length)));
        var i = e.$slides.first().outerWidth(!0) - e.$slides.first().width();
        e.options.variableWidth === !1 && e.$slideTrack.children(".slick-slide").width(e.slideWidth - i)
    }, i.prototype.setFade = function () {
        var i, t = this;
        t.$slides.each(function (o, s) {
            i = t.slideWidth * o * -1, t.options.rtl === !0 ? e(s).css({
                position: "relative",
                right: i,
                top: 0,
                zIndex: t.options.zIndex - 2,
                opacity: 0
            }) : e(s).css({position: "relative", left: i, top: 0, zIndex: t.options.zIndex - 2, opacity: 0})
        }), t.$slides.eq(t.currentSlide).css({zIndex: t.options.zIndex - 1, opacity: 1})
    }, i.prototype.setHeight = function () {
        var e = this;
        if (1 === e.options.slidesToShow && e.options.adaptiveHeight === !0 && e.options.vertical === !1) {
            var i = e.$slides.eq(e.currentSlide).outerHeight(!0);
            e.$list.css("height", i)
        }
    }, i.prototype.setOption = i.prototype.slickSetOption = function (i, t, o) {
        var s, n, r = this;
        if ("responsive" === i && "array" === e.type(t))for (n in t)if ("array" !== e.type(r.options.responsive))r.options.responsive = [t[n]]; else {
            for (s = r.options.responsive.length - 1; s >= 0;)r.options.responsive[s].breakpoint === t[n].breakpoint && r.options.responsive.splice(s, 1), s--;
            r.options.responsive.push(t[n])
        } else r.options[i] = t;
        o === !0 && (r.unload(), r.reinit())
    }, i.prototype.setPosition = function () {
        var e = this;
        e.setDimensions(), e.setHeight(), e.options.fade === !1 ? e.setCSS(e.getLeft(e.currentSlide)) : e.setFade(), e.$slider.trigger("setPosition", [e])
    }, i.prototype.setProps = function () {
        var e = this, i = document.body.style;
        e.positionProp = e.options.vertical === !0 ? "top" : "left", "top" === e.positionProp ? e.$slider.addClass("slick-vertical") : e.$slider.removeClass("slick-vertical"), void 0 === i.WebkitTransition && void 0 === i.MozTransition && void 0 === i.msTransition || e.options.useCSS === !0 && (e.cssTransitions = !0), e.options.fade && ("number" == typeof e.options.zIndex ? e.options.zIndex < 3 && (e.options.zIndex = 3) : e.options.zIndex = e.defaults.zIndex), void 0 !== i.OTransform && (e.animType = "OTransform", e.transformType = "-o-transform", e.transitionType = "OTransition", void 0 === i.perspectiveProperty && void 0 === i.webkitPerspective && (e.animType = !1)), void 0 !== i.MozTransform && (e.animType = "MozTransform", e.transformType = "-moz-transform", e.transitionType = "MozTransition", void 0 === i.perspectiveProperty && void 0 === i.MozPerspective && (e.animType = !1)), void 0 !== i.webkitTransform && (e.animType = "webkitTransform", e.transformType = "-webkit-transform", e.transitionType = "webkitTransition", void 0 === i.perspectiveProperty && void 0 === i.webkitPerspective && (e.animType = !1)), void 0 !== i.msTransform && (e.animType = "msTransform", e.transformType = "-ms-transform", e.transitionType = "msTransition", void 0 === i.msTransform && (e.animType = !1)), void 0 !== i.transform && e.animType !== !1 && (e.animType = "transform", e.transformType = "transform", e.transitionType = "transition"), e.transformsEnabled = null !== e.animType && e.animType !== !1
    }, i.prototype.setSlideClasses = function (e) {
        var i, t, o, s, n = this;
        t = n.$slider.find(".slick-slide").removeClass("slick-active slick-center slick-current").attr("aria-hidden", "true"), n.$slides.eq(e).addClass("slick-current"), n.options.centerMode === !0 ? (i = Math.floor(n.options.slidesToShow / 2), n.options.infinite === !0 && (e >= i && e <= n.slideCount - 1 - i ? n.$slides.slice(e - i, e + i + 1).addClass("slick-active").attr("aria-hidden", "false") : (o = n.options.slidesToShow + e, t.slice(o - i + 1, o + i + 2).addClass("slick-active").attr("aria-hidden", "false")), 0 === e ? t.eq(t.length - 1 - n.options.slidesToShow).addClass("slick-center") : e === n.slideCount - 1 && t.eq(n.options.slidesToShow).addClass("slick-center")), n.$slides.eq(e).addClass("slick-center")) : e >= 0 && e <= n.slideCount - n.options.slidesToShow ? n.$slides.slice(e, e + n.options.slidesToShow).addClass("slick-active").attr("aria-hidden", "false") : t.length <= n.options.slidesToShow ? t.addClass("slick-active").attr("aria-hidden", "false") : (s = n.slideCount % n.options.slidesToShow, o = n.options.infinite === !0 ? n.options.slidesToShow + e : e, n.options.slidesToShow == n.options.slidesToScroll && n.slideCount - e < n.options.slidesToShow ? t.slice(o - (n.options.slidesToShow - s), o + s).addClass("slick-active").attr("aria-hidden", "false") : t.slice(o, o + n.options.slidesToShow).addClass("slick-active").attr("aria-hidden", "false")), "ondemand" === n.options.lazyLoad && n.lazyLoad()
    }, i.prototype.setupInfinite = function () {
        var i, t, o, s = this;
        if (s.options.fade === !0 && (s.options.centerMode = !1), s.options.infinite === !0 && s.options.fade === !1 && (t = null, s.slideCount > s.options.slidesToShow)) {
            for (o = s.options.centerMode === !0 ? s.options.slidesToShow + 1 : s.options.slidesToShow, i = s.slideCount; i > s.slideCount - o; i -= 1)t = i - 1, e(s.$slides[t]).clone(!0).attr("id", "").attr("data-slick-index", t - s.slideCount).prependTo(s.$slideTrack).addClass("slick-cloned");
            for (i = 0; i < o; i += 1)t = i, e(s.$slides[t]).clone(!0).attr("id", "").attr("data-slick-index", t + s.slideCount).appendTo(s.$slideTrack).addClass("slick-cloned");
            s.$slideTrack.find(".slick-cloned").find("[id]").each(function () {
                e(this).attr("id", "")
            })
        }
    }, i.prototype.setPaused = function (e) {
        var i = this;
        i.options.autoplay === !0 && i.options.pauseOnHover === !0 && (i.paused = e, e ? i.autoPlayClear() : i.autoPlay())
    }, i.prototype.selectHandler = function (i) {
        var t = this, o = e(i.target).is(".slick-slide") ? e(i.target) : e(i.target).parents(".slick-slide"), s = parseInt(o.attr("data-slick-index"));
        return s || (s = 0), t.slideCount <= t.options.slidesToShow ? (t.setSlideClasses(s), void t.asNavFor(s)) : void t.slideHandler(s)
    }, i.prototype.slideHandler = function (e, i, t) {
        var o, s, n, r, l = null, d = this;
        if (i = i || !1, (d.animating !== !0 || d.options.waitForAnimate !== !0) && !(d.options.fade === !0 && d.currentSlide === e || d.slideCount <= d.options.slidesToShow))return i === !1 && d.asNavFor(e), o = e, l = d.getLeft(o), r = d.getLeft(d.currentSlide), d.currentLeft = null === d.swipeLeft ? r : d.swipeLeft, d.options.infinite === !1 && d.options.centerMode === !1 && (e < 0 || e > d.getDotCount() * d.options.slidesToScroll) ? void(d.options.fade === !1 && (o = d.currentSlide, t !== !0 ? d.animateSlide(r, function () {
            d.postSlide(o)
        }) : d.postSlide(o))) : d.options.infinite === !1 && d.options.centerMode === !0 && (e < 0 || e > d.slideCount - d.options.slidesToScroll) ? void(d.options.fade === !1 && (o = d.currentSlide, t !== !0 ? d.animateSlide(r, function () {
            d.postSlide(o)
        }) : d.postSlide(o))) : (d.options.autoplay === !0 && clearInterval(d.autoPlayTimer),
            s = o < 0 ? d.slideCount % d.options.slidesToScroll !== 0 ? d.slideCount - d.slideCount % d.options.slidesToScroll : d.slideCount + o : o >= d.slideCount ? d.slideCount % d.options.slidesToScroll !== 0 ? 0 : o - d.slideCount : o, d.animating = !0, d.$slider.trigger("beforeChange", [d, d.currentSlide, s]), n = d.currentSlide, d.currentSlide = s, d.setSlideClasses(d.currentSlide), d.updateDots(), d.updateArrows(), d.options.fade === !0 ? (t !== !0 ? (d.fadeSlideOut(n), d.fadeSlide(s, function () {
            d.postSlide(s)
        })) : d.postSlide(s), void d.animateHeight()) : void(t !== !0 ? d.animateSlide(l, function () {
            d.postSlide(s)
        }) : d.postSlide(s)))
    }, i.prototype.startLoad = function () {
        var e = this;
        e.options.arrows === !0 && e.slideCount > e.options.slidesToShow && (e.$prevArrow.hide(), e.$nextArrow.hide()), e.options.dots === !0 && e.slideCount > e.options.slidesToShow && e.$dots.hide(), e.$slider.addClass("slick-loading")
    }, i.prototype.swipeDirection = function () {
        var e, i, t, o, s = this;
        return e = s.touchObject.startX - s.touchObject.curX, i = s.touchObject.startY - s.touchObject.curY, t = Math.atan2(i, e), o = Math.round(180 * t / Math.PI), o < 0 && (o = 360 - Math.abs(o)), o <= 45 && o >= 0 ? s.options.rtl === !1 ? "left" : "right" : o <= 360 && o >= 315 ? s.options.rtl === !1 ? "left" : "right" : o >= 135 && o <= 225 ? s.options.rtl === !1 ? "right" : "left" : s.options.verticalSwiping === !0 ? o >= 35 && o <= 135 ? "left" : "right" : "vertical"
    }, i.prototype.swipeEnd = function (e) {
        var i, t = this;
        if (t.dragging = !1, t.shouldClick = !(t.touchObject.swipeLength > 10), void 0 === t.touchObject.curX)return !1;
        if (t.touchObject.edgeHit === !0 && t.$slider.trigger("edge", [t, t.swipeDirection()]), t.touchObject.swipeLength >= t.touchObject.minSwipe)switch (t.swipeDirection()) {
            case"left":
                i = t.options.swipeToSlide ? t.checkNavigable(t.currentSlide + t.getSlideCount()) : t.currentSlide + t.getSlideCount(), t.slideHandler(i), t.currentDirection = 0, t.touchObject = {}, t.$slider.trigger("swipe", [t, "left"]);
                break;
            case"right":
                i = t.options.swipeToSlide ? t.checkNavigable(t.currentSlide - t.getSlideCount()) : t.currentSlide - t.getSlideCount(), t.slideHandler(i), t.currentDirection = 1, t.touchObject = {}, t.$slider.trigger("swipe", [t, "right"])
        } else t.touchObject.startX !== t.touchObject.curX && (t.slideHandler(t.currentSlide), t.touchObject = {})
    }, i.prototype.swipeHandler = function (e) {
        var i = this;
        if (!(i.options.swipe === !1 || "ontouchend" in document && i.options.swipe === !1 || i.options.draggable === !1 && e.type.indexOf("mouse") !== -1))switch (i.touchObject.fingerCount = e.originalEvent && void 0 !== e.originalEvent.touches ? e.originalEvent.touches.length : 1, i.touchObject.minSwipe = i.listWidth / i.options.touchThreshold, i.options.verticalSwiping === !0 && (i.touchObject.minSwipe = i.listHeight / i.options.touchThreshold), e.data.action) {
            case"start":
                i.swipeStart(e);
                break;
            case"move":
                i.swipeMove(e);
                break;
            case"end":
                i.swipeEnd(e)
        }
    }, i.prototype.swipeMove = function (e) {
        var i, t, o, s, n, r = this;
        return n = void 0 !== e.originalEvent ? e.originalEvent.touches : null, !(!r.dragging || n && 1 !== n.length) && (i = r.getLeft(r.currentSlide), r.touchObject.curX = void 0 !== n ? n[0].pageX : e.clientX, r.touchObject.curY = void 0 !== n ? n[0].pageY : e.clientY, r.touchObject.swipeLength = Math.round(Math.sqrt(Math.pow(r.touchObject.curX - r.touchObject.startX, 2))), r.options.verticalSwiping === !0 && (r.touchObject.swipeLength = Math.round(Math.sqrt(Math.pow(r.touchObject.curY - r.touchObject.startY, 2)))), t = r.swipeDirection(), "vertical" !== t ? (void 0 !== e.originalEvent && r.touchObject.swipeLength > 4 && e.preventDefault(), s = (r.options.rtl === !1 ? 1 : -1) * (r.touchObject.curX > r.touchObject.startX ? 1 : -1), r.options.verticalSwiping === !0 && (s = r.touchObject.curY > r.touchObject.startY ? 1 : -1), o = r.touchObject.swipeLength, r.touchObject.edgeHit = !1, r.options.infinite === !1 && (0 === r.currentSlide && "right" === t || r.currentSlide >= r.getDotCount() && "left" === t) && (o = r.touchObject.swipeLength * r.options.edgeFriction, r.touchObject.edgeHit = !0), r.options.vertical === !1 ? r.swipeLeft = i + o * s : r.swipeLeft = i + o * (r.$list.height() / r.listWidth) * s, r.options.verticalSwiping === !0 && (r.swipeLeft = i + o * s), r.options.fade !== !0 && r.options.touchMove !== !1 && (r.animating === !0 ? (r.swipeLeft = null, !1) : void r.setCSS(r.swipeLeft))) : void 0)
    }, i.prototype.swipeStart = function (e) {
        var i, t = this;
        return 1 !== t.touchObject.fingerCount || t.slideCount <= t.options.slidesToShow ? (t.touchObject = {}, !1) : (void 0 !== e.originalEvent && void 0 !== e.originalEvent.touches && (i = e.originalEvent.touches[0]), t.touchObject.startX = t.touchObject.curX = void 0 !== i ? i.pageX : e.clientX, t.touchObject.startY = t.touchObject.curY = void 0 !== i ? i.pageY : e.clientY, void(t.dragging = !0))
    }, i.prototype.unfilterSlides = i.prototype.slickUnfilter = function () {
        var e = this;
        null !== e.$slidesCache && (e.unload(), e.$slideTrack.children(this.options.slide).detach(), e.$slidesCache.appendTo(e.$slideTrack), e.reinit())
    }, i.prototype.unload = function () {
        var i = this;
        e(".slick-cloned", i.$slider).remove(), i.$dots && i.$dots.remove(), i.$prevArrow && i.htmlExpr.test(i.options.prevArrow) && i.$prevArrow.remove(), i.$nextArrow && i.htmlExpr.test(i.options.nextArrow) && i.$nextArrow.remove(), i.$slides.removeClass("slick-slide slick-active slick-visible slick-current").attr("aria-hidden", "true").css("width", "")
    }, i.prototype.unslick = function (e) {
        var i = this;
        i.$slider.trigger("unslick", [i, e]), i.destroy()
    }, i.prototype.updateArrows = function () {
        var e, i = this;
        e = Math.floor(i.options.slidesToShow / 2), i.options.arrows === !0 && i.slideCount > i.options.slidesToShow && !i.options.infinite && (i.$prevArrow.removeClass("slick-disabled").attr("aria-disabled", "false"), i.$nextArrow.removeClass("slick-disabled").attr("aria-disabled", "false"), 0 === i.currentSlide ? (i.$prevArrow.addClass("slick-disabled").attr("aria-disabled", "true"), i.$nextArrow.removeClass("slick-disabled").attr("aria-disabled", "false")) : i.currentSlide >= i.slideCount - i.options.slidesToShow && i.options.centerMode === !1 ? (i.$nextArrow.addClass("slick-disabled").attr("aria-disabled", "true"), i.$prevArrow.removeClass("slick-disabled").attr("aria-disabled", "false")) : i.currentSlide >= i.slideCount - 1 && i.options.centerMode === !0 && (i.$nextArrow.addClass("slick-disabled").attr("aria-disabled", "true"), i.$prevArrow.removeClass("slick-disabled").attr("aria-disabled", "false")))
    }, i.prototype.updateDots = function () {
        var e = this;
        null !== e.$dots && (e.$dots.find("li").removeClass("slick-active").attr("aria-hidden", "true"), e.$dots.find("li").eq(Math.floor(e.currentSlide / e.options.slidesToScroll)).addClass("slick-active").attr("aria-hidden", "false"))
    }, i.prototype.visibility = function () {
        var e = this;
        document[e.hidden] ? (e.paused = !0, e.autoPlayClear()) : e.options.autoplay === !0 && (e.paused = !1, e.autoPlay())
    }, i.prototype.initADA = function () {
        var i = this;
        i.$slides.add(i.$slideTrack.find(".slick-cloned")).attr({
            "aria-hidden": "true",
            tabindex: "-1"
        }).find("a, input, button, select").attr({tabindex: "-1"}), i.$slideTrack.attr("role", "listbox"), i.$slides.not(i.$slideTrack.find(".slick-cloned")).each(function (t) {
            e(this).attr({role: "option", "aria-describedby": "slick-slide" + i.instanceUid + t})
        }), null !== i.$dots && i.$dots.attr("role", "tablist").find("li").each(function (t) {
            e(this).attr({
                role: "presentation",
                "aria-selected": "false",
                "aria-controls": "navigation" + i.instanceUid + t,
                id: "slick-slide" + i.instanceUid + t
            })
        }).first().attr("aria-selected", "true").end().find("button").attr("role", "button").end().closest("div").attr("role", "toolbar"), i.activateADA()
    }, i.prototype.activateADA = function () {
        var e = this, i = e.$slider.find("*").is(":focus");
        e.$slideTrack.find(".slick-active").attr({
            "aria-hidden": "false",
            tabindex: "0"
        }).find("a, input, button, select").attr({tabindex: "0"}), i && e.$slideTrack.find(".slick-active").focus()
    }, i.prototype.focusHandler = function () {
        var i = this;
        i.$slider.on("focus.slick blur.slick", "*", function (t) {
            t.stopImmediatePropagation();
            var o = e(this);
            setTimeout(function () {
                i.isPlay && (o.is(":focus") ? (i.autoPlayClear(), i.paused = !0) : (i.paused = !1, i.autoPlay()))
            }, 0)
        })
    }, e.fn.slick = function () {
        var e, t = this, o = arguments[0], s = Array.prototype.slice.call(arguments, 1), n = t.length, r = 0;
        for (r; r < n; r++)if ("object" == typeof o || "undefined" == typeof o ? t[r].slick = new i(t[r], o) : e = t[r].slick[o].apply(t[r].slick, s), "undefined" != typeof e)return e;
        return t
    }
}), function () {
    function e() {
        for (var e = "<option value='' disabled selected hidden>Choose your role</option>", t = 0; t < l.length; t++)e += "<option value='" + t + "'>" + l[t].name + "</option>";
        $("#i_am_a").html(e), $("#i_am_a").change(function (e) {
            n = e.target.value, i(e.target.value), $(".comp_slider").html(""), $(".selector_arrow").addClass("pulse"), setTimeout(function () {
                $(".selector_arrow").removeClass("pulse")
            }, 2e3)
        })
    }

    function i(e) {
        var i = "<option value='' disabled selected hidden>Choose your goal</option>";
        if (e !== !1)for (var o = l[e].requirements, s = 0; s < o.length; s++)i += "<option value='" + s + "'>" + o[s].name + "</option>";
        $("#i_want_to_host").html(i), $("#i_want_to_host").off("change"), $("#i_want_to_host").change(function (i) {
            r = i.target.value, t(e, i.target.value);
            var o = $("html, body");
            o.on("scroll mousedown wheel DOMMouseScroll mousewheel keyup touchmove", function () {
                o.stop()
            }), o.animate({scrollTop: $("#selector").position().top}, 500, "swing", function () {
                o.off("scroll mousedown wheel DOMMouseScroll mousewheel keyup touchmove")
            }), $(".selector_arrow").addClass("pulse"), setTimeout(function () {
                $(".selector_arrow").removeClass("pulse")
            }, 2e3)
        })
    }

    function t(e, i) {
        var t = "", n = l[e].requirements[i];
        $.each(n.products, function (e, i) {
            var o = $.grep(a, function (e) {
                return e.id === i.id
            })[0], s = c;
            $.each(d, function (e, t) {
                i[t] && (o[t] = i[t]), s = s.replace("{{" + t + "}}", o[t])
            }), t += s
        }), $(".comp_slider").replaceWith("<div class='comp_slider clearfix'>" + t + "</div>"), $(".comp_slider").slick({
            infinite: !1,
            centerMode: !0,
            slidesToShow: 3,
            centerPadding: "200px",
            initialSlide: n.initialSlide,
            variableWidth: !0,
            responsive: [{
                breakpoint: 600,
                settings: {
                    infinite: !1,
                    centerMode: !0,
                    slidesToShow: 1,
                    centerPadding: "200px",
                    initialSlide: n.initialSlide,
                    variableWidth: !0
                }
            }, {breakpoint: 600, settings: "unslick"}]
        }), $(".comp_slider").on("init", function (e, i) {
            o(n.initialSlide)
        }), $(".comp_slider").on("beforeChange", function (e, i, t, n) {
            o(n), s = n
        }), o(n.initialSlide)
    }

    function o(e) {
        var i;
        $(".comp_panel_3up").removeClass("faded"), $(".comp_panel_3up").removeClass("fully_faded"), i = $(window).width() <= 1200 ? 1 : 2, $("[data-slick-index]").each(function (t, o) {
            Math.abs(e - $(o).data("slick-index")) == i ? ($(o).addClass("faded"), $(o).removeClass("fully_faded")) : Math.abs(e - $(o).data("slick-index")) > i ? ($(o).addClass("fully_faded"), $(o).removeClass("faded")) : ($(o).removeClass("fully_faded"), $(o).removeClass("faded"))
        })
    }

    var s, n = 0, r = 0, l = [{
        name: "Personal user",
        requirements: [{
            name: "Create a simple website",
            initialSlide: 1,
            products: [{id: 2}, {id: 1}, {id: 3}, {id: 5}]
        }, {
            name: "Showcase my CV/work",
            initialSlide: 1,
            products: [{id: 2}, {id: 1}, {id: 3}, {id: 5}]
        }, {
            name: "Create a community site",
            initialSlide: 1,
            products: [{id: 2}, {id: 1}, {id: 3}, {id: 5}]
        }, {
            name: "Sell online",
            initialSlide: 2,
            products: [{id: 2}, {id: 1}, {id: 3}, {id: 5}, {id: 6}]
        }, {name: "Get a personal email address", initialSlide: 0, products: [{id: 7}]}]
    }, {
        name: "Business",
        requirements: [{
            name: "Let my customers find me online",
            initialSlide: 1,
            products: [{id: 2}, {id: 1}, {id: 3}, {id: 5}]
        }, {
            initialSlide: 1,
            name: "Sell online",
            products: [{id: 2}, {id: 1}, {id: 3}, {id: 5}, {id: 6}]
        }, {initialSlide: 0, name: "Get professional email", products: [{id: 7}]}]
    }, {
        name: "Blogger",
        requirements: [{
            name: "Start a new blog",
            initialSlide: 1,
            products: [{id: 1}, {id: 3}, {id: 5}, {id: 6}]
        }, {
            initialSlide: 1,
            name: "Host multiple blogs",
            products: [{id: 1}, {id: 3}, {id: 4}, {id: 5}, {id: 6}]
        }, {initialSlide: 0, name: "Transfer in an existing blog", products: [{id: 1}, {id: 3}, {id: 5}, {id: 6}]}]
    }, {
        name: "Web designer",
        requirements: [{
            name: "Showcase my work",
            initialSlide: 1,
            products: [{id: 1}, {id: 3}, {id: 5}, {id: 4}, {id: 6}]
        }, {
            initialSlide: 1,
            name: "Host my clients' sites",
            products: [{id: 1}, {id: 3}, {id: 5}, {id: 4}, {id: 6}]
        }, {
            initialSlide: 1,
            name: "Create a sandbox/dev area",
            products: [{id: 3}, {id: 5}, {id: 4}, {id: 6}]
        }, {initialSlide: 1, name: "Host one or more large sites", products: [{id: 3}, {id: 5}, {id: 6}]}]
    }, {
        name: "Agency",
        requirements: [{
            name: "Host & manage my clients' sites",
            initialSlide: 1,
            products: [{id: 1}, {id: 3}, {id: 5}, {id: 4}, {id: 6}]
        }, {
            initialSlide: 0,
            name: "Host one or more large sites",
            products: [{id: 3}, {id: 5}, {id: 6}]
        }, {initialSlide: 0, name: "Host short term projects", products: [{id: 1}, {id: 3}, {id: 5}, {id: 4}, {id: 6}]}]
    }, {
        name: "Web developer",
        requirements: [{name: "Host my apps", initialSlide: 1, products: [{id: 3}, {id: 5}, {id: 6}]}, {
            initialSlide: 1,
            name: "Showcase my work",
            products: [{id: 1}, {id: 3}, {id: 5}, {id: 4}, {id: 6}]
        }, {
            initialSlide: 1,
            name: "Host my clients' sites",
            products: [{id: 1}, {id: 3}, {id: 5}, {id: 4}, {id: 6}]
        }, {
            initialSlide: 1,
            name: "Create a sandbox/dev area",
            products: [{id: 3}, {id: 5}, {id: 4}, {id: 6}]
        }, {initialSlide: 1, name: "Host one or more large sites", products: [{id: 3}, {id: 5}, {id: 6}]}]
    }], d = ["product_name", "upper_text", "price", "pence", "lower_text", "body_text", "button_text", "button_link", "offer_text"], a = [{
        id: 1,
        product_name: "Web Hosting",
        upper_text: "From only",
        price: "2",
        pence: ".49",
        lower_text: "Per month",
        body_text: "Fast, secure, and reliable cloud hosting for small to medium sized websites. Includes one-click install WordPress.",
        button_text: "View hosting plans",
        button_link: "/web-hosting"
    }, {
        id: 2,
        product_name: "Sitedesigner",
        upper_text: "From only",
        price: "5",
        pence: ".99",
        lower_text: "Per month",
        body_text: "Everything you need to create a beautiful and professional website. No previous experience needed.",
        button_text: "Build your site now",
        button_link: "/website-builder"
    }, {
        id: 3,
        product_name: "Premium Hosting",
        upper_text: "From only",
        price: "29",
        pence: ".99",
        lower_text: "Per month",
        body_text: "Server-level performance without the administration. Perfect for multisite hosting and demanding projects.",
        button_text: "Go premium today",
        button_link: "/premium-hosting",
        offer_text: "<small>3 months</small> 50% off"
    }, {
        id: 4,
        product_name: "Reseller Hosting",
        upper_text: "From only",
        price: "1",
        pence: ".00",
        lower_text: "First month - limited time",
        body_text: "Host unlimited client websites on one easy-to-use platform supported by our reliable and fast hosting platform.",
        button_text: "Start hosting",
        button_link: "/reseller-hosting",
        offer_text: "50% off"
    }, {
        id: 5,
        product_name: "VPS",
        upper_text: "From only",
        price: "9",
        pence: ".99",
        lower_text: "Per month",
        body_text: "Powerful VPS giving you the performance and control you need for projects of all sizes.",
        button_text: "Choose your VPS",
        button_link: "/vps",
        offer_text: "<small>3 months</small> 50% off"
    }, {
        id: 6,
        product_name: "Dedicated Servers",
        upper_text: "From only",
        price: "59",
        pence: ".00",
        lower_text: "Per month",
        body_text: "Customise your own high-powered server for mission-critical websites and applications",
        button_text: "Create your server",
        button_link: "/dedicated-servers"
    }, {
        id: 7,
        product_name: "Hosted Exchange",
        upper_text: "From only",
        price: "10",
        pence: ".00",
        lower_text: "Per month",
        body_text: "Make your email work for you with Microsoft Exchange.",
        button_text: "Get mailboxes",
        button_link: "/hosted-exchange"
    }], c = '<div class="comp_panel_3up fully_faded"><div class="comp_panel_holder"><h4>{{product_name}}</h4><div class="period">{{upper_text}}</div><br /><div class="price"> <span class="pound">&pound;</span><span class="pounds">{{price}}</span><span class="pence">{{pence}}</span></div><div class="period">{{lower_text}}</div><div class="divider"></div><div class="copy">{{body_text}}</div><a href="{{button_link}}"><button type="button" class="btn primary_button">{{button_text}}</button></a></div></div>';
    $(document).ready(function () {
        e(), i(!1), t(2, 1)
    });
    var p = !1;
    $(window).resize(function (e) {
        var i = l[n].requirements[r].initialSlide;
        o(i), $(window).width() < 600 ? ($(".comp_panel_3up").removeClass("fully_faded"), $(".comp_panel_3up").removeClass("faded"), p = !0) : p && (t(n, r), p = !1), setTimeout(function () {
            $(".comp_slider").slick("slickGoTo", i)
        }, 0)
    })
}();
