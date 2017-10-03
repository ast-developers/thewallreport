window.CustomModernizr = function (e, t, i) {
    function n(e) {
        y.cssText = e
    }

    function s(e, t) {
        return typeof e === t
    }

    function r(e, t) {
        return !!~("" + e).indexOf(t)
    }

    function o(e, t) {
        for (var n in e) {
            var s = e[n];
            if (!r(s, "-") && y[s] !== i)return "pfx" == t ? s : !0
        }
        return !1
    }

    function a(e, t, n) {
        for (var r in e) {
            var o = t[e[r]];
            if (o !== i)return n === !1 ? e[r] : s(o, "function") ? o.bind(n || t) : o
        }
        return !1
    }

    function l(e, t, i) {
        var n = e.charAt(0).toUpperCase() + e.slice(1), r = (e + " " + _.join(n + " ") + n).split(" ");
        return s(t, "string") || s(t, "undefined") ? o(r, t) : (r = (e + " " + b.join(n + " ") + n).split(" "), a(r, t, i))
    }

    var d, f, p, h = "2.6.2", c = {}, u = !0, m = t.documentElement, g = "modernizr", v = t.createElement(g), y = v.style, w = ({}.toString, " -webkit- -moz- -o- -ms- ".split(" ")), x = "Webkit Moz O ms", _ = x.split(" "), b = x.toLowerCase().split(" "), I = {}, C = [], T = C.slice, S = function (e, i, n, s) {
        var r, o, a, l, d = t.createElement("div"), f = t.body, p = f || t.createElement("body");
        if (parseInt(n, 10))for (; n--;)a = t.createElement("div"), a.id = s ? s[n] : g + (n + 1), d.appendChild(a);
        return r = ["&#173;", '<style id="s', g, '">', e, "</style>"].join(""), d.id = g, (f ? d : p).innerHTML += r, p.appendChild(d), f || (p.style.background = "", p.style.overflow = "hidden", l = m.style.overflow, m.style.overflow = "hidden", m.appendChild(p)), o = i(d, e), f ? d.parentNode.removeChild(d) : (p.parentNode.removeChild(p), m.style.overflow = l), !!o
    }, k = {}.hasOwnProperty;
    p = s(k, "undefined") || s(k.call, "undefined") ? function (e, t) {
            return t in e && s(e.constructor.prototype[t], "undefined")
        } : function (e, t) {
            return k.call(e, t)
        }, Function.prototype.bind || (Function.prototype.bind = function (e) {
        var t = this;
        if ("function" != typeof t)throw new TypeError;
        var i = T.call(arguments, 1), n = function () {
            if (this instanceof n) {
                var s = function () {
                };
                s.prototype = t.prototype;
                var r = new s, o = t.apply(r, i.concat(T.call(arguments)));
                return Object(o) === o ? o : r
            }
            return t.apply(e, i.concat(T.call(arguments)))
        };
        return n
    }), I.csstransforms = function () {
        return !!l("transform")
    }, I.csstransforms3d = function () {
        var e = !!l("perspective");
        return e && "webkitPerspective" in m.style && S("@media (transform-3d),(-webkit-transform-3d){#modernizr{left:9px;position:absolute;height:3px;}}", function (t, i) {
            e = 9 === t.offsetLeft && 3 === t.offsetHeight
        }), e
    }, I.csstransitions = function () {
        return l("transition")
    };
    for (var N in I)p(I, N) && (f = N.toLowerCase(), c[f] = I[N](), C.push((c[f] ? "" : "no-") + f));
    return c.addTest = function (e, t) {
        if ("object" == typeof e)for (var n in e)p(e, n) && c.addTest(n, e[n]); else {
            if (e = e.toLowerCase(), c[e] !== i)return c;
            t = "function" == typeof t ? t() : t, "undefined" != typeof u && u && (m.className += " " + (t ? "" : "no-") + e), c[e] = t
        }
        return c
    }, n(""), v = d = null, c._version = h, c._prefixes = w, c._domPrefixes = b, c._cssomPrefixes = _, c.testProp = function (e) {
        return o([e])
    }, c.testAllProps = l, c.testStyles = S, c.prefixed = function (e, t, i) {
        return t ? l(e, t, i) : l(e, "pfx")
    }, m.className = m.className.replace(/(^|\s)no-js(\s|$)/, "$1$2") + (u ? " js " + C.join(" ") : ""), c
}(this, this.document), window.findAndReplaceDOMText = function () {
    function e(e) {
        return String(e).replace(/([.*+?^=!:${}()|[\]\/\\])/g, "\\$1")
    }

    function t() {
        return i.apply(null, arguments) || n.apply(null, arguments)
    }

    function i(e, i, s, r, o) {
        if (i && !i.nodeType && arguments.length <= 2)return !1;
        var a = "function" == typeof s;
        a && (s = function (e) {
            return function (t, i) {
                return e(t.text, i.startIndex)
            }
        }(s));
        var l = n(i, {
            find: e, wrap: a ? null : s, replace: a ? s : "$" + (r || "&"), prepMatch: function (e, t) {
                if (!e[0])throw"findAndReplaceDOMText cannot handle zero-length matches";
                if (r > 0) {
                    var i = e[r];
                    e.index += e[0].indexOf(i), e[0] = i
                }
                return e.endIndex = e.index + e[0].length, e.startIndex = e.index, e.index = t, e
            }, filterElements: o
        });
        return t.revert = function () {
            return l.revert()
        }, !0
    }

    function n(e, t) {
        return new s(e, t)
    }

    function s(e, t) {
        t.portionMode = t.portionMode || r, this.node = e, this.options = t, this.prepMatch = t.prepMatch || this.prepMatch, this.reverts = [], this.matches = this.search(), this.matches.length && this.processMatches()
    }

    var r = "retain", o = "first", a = document;
    return {}.toString, t.Finder = s, s.prototype = {
        search: function () {
            var t, i = 0, n = this.options.find, s = this.getAggregateText(), r = [];
            if (n = "string" == typeof n ? RegExp(e(n), "g") : n, n.global)for (; t = n.exec(s);)r.push(this.prepMatch(t, i++)); else(t = s.match(n)) && r.push(this.prepMatch(t, 0));
            return r
        }, prepMatch: function (e, t) {
            if (!e[0])throw new Error("findAndReplaceDOMText cannot handle zero-length matches");
            return e.endIndex = e.index + e[0].length, e.startIndex = e.index, e.index = t, e
        }, getAggregateText: function () {
            function e(i) {
                if (3 === i.nodeType)return i.data;
                if (t && !t(i))return "";
                var n = "";
                if (i = i.firstChild)do n += e(i); while (i = i.nextSibling);
                return n
            }

            var t = this.options.filterElements;
            return e(this.node)
        }, processMatches: function () {
            var e, t, i, n = this.matches, s = this.node, r = this.options.filterElements, o = [], a = s, l = n.shift(), d = 0, f = 0, p = 0, h = [s];
            e:for (; ;) {
                if (3 === a.nodeType && (!t && a.length + d >= l.endIndex ? t = {
                            node: a,
                            index: p++,
                            text: a.data.substring(l.startIndex - d, l.endIndex - d),
                            indexInMatch: d - l.startIndex,
                            indexInNode: l.startIndex - d,
                            endIndexInNode: l.endIndex - d,
                            isEnd: !0
                        } : e && o.push({
                            node: a,
                            index: p++,
                            text: a.data,
                            indexInMatch: d - l.startIndex,
                            indexInNode: 0
                        }), !e && a.length + d > l.startIndex && (e = {
                        node: a,
                        index: p++,
                        indexInMatch: 0,
                        indexInNode: l.startIndex - d,
                        endIndexInNode: l.endIndex - d,
                        text: a.data.substring(l.startIndex - d, l.endIndex - d)
                    }), d += a.data.length), i = 1 === a.nodeType && r && !r(a), e && t) {
                    if (a = this.replaceMatch(l, e, o, t), d -= t.node.data.length - t.endIndexInNode, e = null, t = null, o = [], l = n.shift(), p = 0, f++, !l)break
                } else if (!i && (a.firstChild || a.nextSibling)) {
                    a.firstChild ? (h.push(a), a = a.firstChild) : a = a.nextSibling;
                    continue
                }
                for (; ;) {
                    if (a.nextSibling) {
                        a = a.nextSibling;
                        break
                    }
                    if (a = h.pop(), a === s)break e
                }
            }
        }, revert: function () {
            for (var e = this.reverts.length; e--;)this.reverts[e]();
            this.reverts = []
        }, prepareReplacementString: function (e, t, i, n) {
            var s = this.options.portionMode;
            return s === o && t.indexInMatch > 0 ? "" : (e = e.replace(/\$(\d+|&|`|')/g, function (e, t) {
                    var n;
                    switch (t) {
                        case"&":
                            n = i[0];
                            break;
                        case"`":
                            n = i.input.substring(0, i.startIndex);
                            break;
                        case"'":
                            n = i.input.substring(i.endIndex);
                            break;
                        default:
                            n = i[+t]
                    }
                    return n
                }), s === o ? e : t.isEnd ? e.substring(t.indexInMatch) : e.substring(t.indexInMatch, t.indexInMatch + t.text.length))
        }, getPortionReplacementNode: function (e, t, i) {
            var n = this.options.replace || "$&", s = this.options.clss, r = this.options.wrap;
            if (r && r.nodeType) {
                var o = a.createElement("div");
                o.innerHTML = r.outerHTML || (new XMLSerializer).serializeToString(r), r = o.firstChild
            }
            if ("function" == typeof n)return n = n(e, t, i), n && n.nodeType ? n : a.createTextNode(String(n));
            var l = "string" == typeof r ? a.createElement(r) : r;
            return s && (l.className = s), n = a.createTextNode(this.prepareReplacementString(n, e, t, i)), n.data && l ? (l.appendChild(n), l) : n
        }, replaceMatch: function (e, t, i, n) {
            var s, r, o = t.node, l = n.node;
            if (o === l) {
                var d = o;
                t.indexInNode > 0 && (s = a.createTextNode(d.data.substring(0, t.indexInNode)), d.parentNode.insertBefore(s, d));
                var f = this.getPortionReplacementNode(n, e);
                return d.parentNode.insertBefore(f, d), n.endIndexInNode < d.length && (r = a.createTextNode(d.data.substring(n.endIndexInNode)), d.parentNode.insertBefore(r, d)), d.parentNode.removeChild(d), this.reverts.push(function () {
                    s === f.previousSibling && s.parentNode.removeChild(s), r === f.nextSibling && r.parentNode.removeChild(r), f.parentNode.replaceChild(d, f)
                }), f
            }
            s = a.createTextNode(o.data.substring(0, t.indexInNode)), r = a.createTextNode(l.data.substring(n.endIndexInNode));
            for (var p = this.getPortionReplacementNode(t, e), h = [], c = 0, u = i.length; u > c; ++c) {
                var m = i[c], g = this.getPortionReplacementNode(m, e);
                m.node.parentNode.replaceChild(g, m.node), this.reverts.push(function (e, t) {
                    return function () {
                        t.parentNode.replaceChild(e.node, t)
                    }
                }(m, g)), h.push(g)
            }
            var v = this.getPortionReplacementNode(n, e);
            return o.parentNode.insertBefore(s, o), o.parentNode.insertBefore(p, o), o.parentNode.removeChild(o), l.parentNode.insertBefore(v, l), l.parentNode.insertBefore(r, l), l.parentNode.removeChild(l), this.reverts.push(function () {
                s.parentNode.removeChild(s), p.parentNode.replaceChild(o, p), r.parentNode.removeChild(r), v.parentNode.replaceChild(l, v)
            }), v
        }
    }, t
}(), function (e) {
    function t(t, r) {
        if (this.element = t, this.options = e.extend({}, n, r), e(this.element).data("max-height", this.options.maxHeight), e(this.element).data("height-margin", this.options.heightMargin), delete this.options.maxHeight, this.options.embedCSS && !s) {
            var o = ".readmore-js-toggle, .readmore-js-section { " + this.options.sectionCSS + " } .readmore-js-section { overflow: hidden; }";
            !function (e, t) {
                var i = e.createElement("style");
                i.type = "text/css", i.styleSheet ? i.styleSheet.cssText = t : i.appendChild(e.createTextNode(t)), e.getElementsByTagName("head")[0].appendChild(i)
            }(document, o), s = !0
        }
        this._defaults = n, this._name = i, this.init()
    }

    var i = "readmore", n = {
        speed: 100,
        maxHeight: 200,
        heightMargin: 16,
        moreLink: '<a href="#">' + window.FlowFlowOpts.expand_text + "</a>",
        lessLink: '<a href="#">' + window.FlowFlowOpts.collapse_text + "</a>",
        embedCSS: !0,
        sectionCSS: "display: block; width: 100%;",
        startOpen: !1,
        expandedClass: "readmore-js-expanded",
        collapsedClass: "readmore-js-collapsed",
        beforeToggle: function () {
        },
        afterToggle: function () {
        }
    }, s = !1;
    t.prototype = {
        init: function () {
            var t = this;
            e(this.element).each(function () {
                var i = e(this), n = i.css("max-height"), s = n.replace(/[^-\d\.]/g, "") > i.data("max-height") ? n.replace(/[^-\d\.]/g, "") : i.data("max-height"), r = i.data("height-margin");
                if ("none" != n && i.css("max-height", "none"), t.setBoxHeight(i), i.outerHeight(!0) <= s + r)return !0;
                i.addClass("readmore-js-section " + t.options.collapsedClass).data("collapsedHeight", s);
                var o = t.options.startOpen ? t.options.lessLink : t.options.moreLink;
                i.after(e(o).on("click", function (e) {
                    t.toggleSlider(this, i, e)
                }).addClass("readmore-js-toggle")), t.options.startOpen || i.css({height: s})
            })
        }, toggleSlider: function (t, i, n) {
            n.preventDefault();
            var s = this, r = newLink = sectionClass = "", o = !1, a = e(i).data("collapsedHeight");
            e(i).height() <= a ? (r = e(i).data("expandedHeight") + "px", newLink = "lessLink", o = !0, sectionClass = s.options.expandedClass) : (r = a, newLink = "moreLink", sectionClass = s.options.collapsedClass), s.options.beforeToggle(t, i, o), e(i).animate({height: r}, {
                duration: s.options.speed,
                complete: function () {
                    s.options.afterToggle(t, i, o), e(t).replaceWith(e(s.options[newLink]).on("click", function (e) {
                        s.toggleSlider(this, i, e)
                    }).addClass("readmore-js-toggle")), e(this).removeClass(s.options.collapsedClass + " " + s.options.expandedClass).addClass(sectionClass)
                }
            })
        }, setBoxHeight: function (e) {
            var t = e.clone().css({
                height: "auto",
                width: e.width(),
                overflow: "hidden"
            }).insertAfter(e), i = t.outerHeight(!0);
            t.remove(), e.data("expandedHeight", i)
        }, resizeBoxes: function () {
            var t = this;
            e(".readmore-js-section").each(function () {
                var i = e(this);
                t.setBoxHeight(i), (i.height() > i.data("expandedHeight") || i.hasClass(t.options.expandedClass) && i.height() < i.data("expandedHeight")) && i.css("height", i.data("expandedHeight"))
            })
        }, destroy: function () {
            var t = this;
            e(this.element).each(function () {
                var i = e(this);
                i.removeClass("readmore-js-section " + t.options.collapsedClass + " " + t.options.expandedClass).css({
                    "max-height": "",
                    height: "auto"
                }).next(".readmore-js-toggle").remove(), i.removeData()
            })
        }
    }, e.fn[i] = function (n) {
        var s = arguments;
        return void 0 === n || "object" == typeof n ? this.each(function () {
                if (e.data(this, "plugin_" + i)) {
                    var s = e.data(this, "plugin_" + i);
                    s.destroy.apply(s)
                }
                e.data(this, "plugin_" + i, new t(this, n))
            }) : "string" == typeof n && "_" !== n[0] && "init" !== n ? this.each(function () {
                    var r = e.data(this, "plugin_" + i);
                    r instanceof t && "function" == typeof r[n] && r[n].apply(r, Array.prototype.slice.call(s, 1))
                }) : void 0
    }
}(jQuery), function (e) {
    window.Shuffle = e(window.jQuery, window.CustomModernizr)
}(function (e, t, i) {
    "use strict";
    function n(e) {
        return e ? e.replace(/([A-Z])/g, function (e, t) {
                return "-" + t.toLowerCase()
            }).replace(/^ms-/, "-ms-") : ""
    }

    function s(t, i, n) {
        var s, r, o, a = null, l = 0;
        n = n || {};
        var d = function () {
            l = n.leading === !1 ? 0 : e.now(), a = null, o = t.apply(s, r), s = r = null
        };
        return function () {
            var f = e.now();
            l || n.leading !== !1 || (l = f);
            var p = i - (f - l);
            return s = this, r = arguments, 0 >= p || p > i ? (clearTimeout(a), a = null, l = f, o = t.apply(s, r), s = r = null) : a || n.trailing === !1 || (a = setTimeout(d, p)), o
        }
    }

    function r(e, t, i) {
        for (var n = 0, s = e.length; s > n; n++)if (t.call(i, e[n], n, e) === {})return
    }

    function o(t, i, n) {
        return setTimeout(e.proxy(t, i), n)
    }

    function a(e) {
        return Math.max.apply(Math, e)
    }

    function l(e) {
        return Math.min.apply(Math, e)
    }

    function d(t) {
        return e.isNumeric(t) ? t : 0
    }

    function f(e) {
        var t, i, n = e.length;
        if (!n)return e;
        for (; --n;)i = Math.floor(Math.random() * (n + 1)), t = e[i], e[i] = e[n], e[n] = t;
        return e
    }

    if ("object" != typeof t)throw new Error("Shuffle.js requires Modernizr.\nhttp://vestride.github.io/Shuffle/#dependencies");
    var p = t.prefixed("transition"), h = t.prefixed("transitionDelay"), c = t.prefixed("transitionDuration"), u = {
        WebkitTransition: "webkitTransitionEnd",
        transition: "transitionend"
    }[p], m = t.prefixed("transform"), g = n(m), v = t.csstransforms && t.csstransitions, y = t.csstransforms3d, w = "shuffle", x = .3, _ = "all", b = "groups", I = 1, C = .001, T = function (e, t) {
        this.x = d(e), this.y = d(t)
    };
    T.equals = function (e, t) {
        return e.x === t.x && e.y === t.y
    };
    var S = 0, k = e(window), N = 0, E = function (t, i) {
        i = i || {}, e.extend(this, E.options, i, E.settings), this.$el = e(t), this.id = N++, this.element = t, this.unique = "shuffle_" + S++, this._fire(E.EventType.LOADING), this._init(), o(function () {
            this.initialized = !0, this._fire(E.EventType.DONE)
        }, this, 16)
    };
    return E.EventType = {
        LOADING: "loading",
        DONE: "done",
        LAYOUT: "layout",
        REMOVED: "removed"
    }, E.ClassName = {
        BASE: w,
        SHUFFLE_ITEM: "shuffle-item",
        FILTERED: "filtered",
        CONCEALED: "concealed"
    }, E.options = {
        group: _,
        speed: 250,
        easing: "ease-out",
        itemSelector: "",
        sizer: null,
        gutterWidth: 0,
        columnWidth: 0,
        delimeter: null,
        buffer: 0,
        initialSort: null,
        throttle: s,
        throttleTime: 300,
        sequentialFadeDelay: 150,
        supported: v
    }, E.settings = {
        useSizer: !1,
        itemCss: {position: "absolute", top: 0, left: 0, visibility: "visible"},
        revealAppendedDelay: 300,
        lastSort: {},
        lastFilter: _,
        enabled: !0,
        destroyed: !1,
        initialized: !1,
        _animations: [],
        styleQueue: []
    }, E.Point = T, E._getItemTransformString = function (e, t) {
        return y ? "translate3d(" + e.x + "px, " + e.y + "px, 0) scale3d(" + t + ", " + t + ", 1)" : "translate(" + e.x + "px, " + e.y + "px) scale(" + t + ")"
    }, E._getNumberStyle = function (t, i) {
        return E._getFloat(e(t).css(i))
    }, E._getInt = function (e) {
        return d(parseInt(e, 10))
    }, E._getFloat = function (e) {
        return d(parseFloat(e))
    }, E._getOuterWidth = function (t, i) {
        return e(t).outerWidth(!!i)
    }, E._getOuterHeight = function (t, i) {
        return e(t).outerHeight(!!i)
    }, E._skipTransition = function (e, t, i) {
        var n = e.style[c];
        e.style[c] = "0ms", t.call(i);
        var s = e.offsetWidth;
        s = null, e.style[c] = n
    }, E.prototype._init = function () {
        this.$items = this._getItems(), this.sizer = this._getElementOption(this.sizer), this.sizer && (this.useSizer = !0), this.$el.addClass(E.ClassName.BASE), this._initItems(), k.on("resize." + w + "." + this.unique, this._getResizeFunction());
        var t = this.$el.css(["position", "overflow"]), i = E._getOuterWidth(this.element);
        this._validateStyles(t), this._setColumns(i), this._itemMargin = parseInt(e(this.sizer).css("marginLeft") || 0), this.shuffle(this.group, this.initialSort), this.supported && o(function () {
            this.destroyed || (this._setTransitions(), this.element.style[p] = "height " + this.speed + "ms " + this.easing)
        }, this)
    }, E.prototype._getResizeFunction = function () {
        var t = e.proxy(this._onResize, this);
        return this.throttle ? this.throttle(t, this.throttleTime) : t
    }, E.prototype._getElementOption = function (e) {
        return "string" == typeof e ? this.$el.find(e)[0] || null : e && e.nodeType && 1 === e.nodeType ? e : e && e.jquery ? e[0] : null
    }, E.prototype._validateStyles = function (e) {
        "static" === e.position && (this.element.style.position = "relative"), "hidden" !== e.overflow
    }, E.prototype._filter = function (e, t) {
        e = e || this.lastFilter, t = t || this.$items;
        var i = this._getFilteredSets(e, t);
        return this._toggleFilterClasses(i.filtered, i.concealed), this.lastFilter = e, "string" == typeof e && (this.group = e), i.filtered
    }, E.prototype._getFilteredSets = function (t, i) {
        var n = e(), s = e();
        return t === _ ? n = i : r(i, function (i) {
                var r = e(i);
                this._doesPassFilter(t, r) ? n = n.add(r) : s = s.add(r)
            }, this), {filtered: n, concealed: s}
    }, E.prototype._doesPassFilter = function (t, i) {
        if (e.isFunction(t))return t.call(i[0], i, this);
        var n = i.data(b), s = this.delimeter && !e.isArray(n) ? n.split(this.delimeter) : n;
        return e.inArray(t, s) > -1
    }, E.prototype._toggleFilterClasses = function (e, t) {
        e.removeClass(E.ClassName.CONCEALED).addClass(E.ClassName.FILTERED), t.removeClass(E.ClassName.FILTERED).addClass(E.ClassName.CONCEALED)
    }, E.prototype._initItems = function (e) {
        e = e || this.$items, e.addClass([E.ClassName.SHUFFLE_ITEM, E.ClassName.FILTERED].join(" ")), e.css(this.itemCss).data("point", new T).data("scale", I)
    }, E.prototype._updateItemCount = function () {
        this.visibleItems = this._getFilteredItems().length
    }, E.prototype._setTransition = function (e) {
        e.style[p] = g + " " + this.speed + "ms " + this.easing + ", opacity " + this.speed + "ms " + this.easing
    }, E.prototype._setTransitions = function (e) {
        e = e || this.$items, r(e, function (e) {
            this._setTransition(e)
        }, this)
    }, E.prototype._setSequentialDelay = function (e) {
        this.supported && r(e, function (e, t) {
            e.style[h] = "0ms," + (t + 1) * this.sequentialFadeDelay + "ms"
        }, this)
    }, E.prototype._getItems = function () {
        return this.$el.children(this.itemSelector)
    }, E.prototype._getFilteredItems = function () {
        return this.destroyed ? e() : this.$items.filter("." + E.ClassName.FILTERED)
    }, E.prototype._getConcealedItems = function () {
        return this.$items.filter("." + E.ClassName.CONCEALED)
    }, E.prototype._getColumnSize = function (t, i) {
        var n;
        return n = e.isFunction(this.columnWidth) ? this.columnWidth(t) : this.useSizer ? E._getOuterWidth(this.sizer) : this.columnWidth ? this.columnWidth : this.$items.length > 0 ? E._getOuterWidth(this.$items[0], !0) : t, 0 === n && (n = t), n + i
    }, E.prototype._getGutterSize = function (t) {
        var i;
        return i = e.isFunction(this.gutterWidth) ? this.gutterWidth(t) : this.useSizer ? E._getNumberStyle(this.sizer, "marginLeft") : this.gutterWidth
    }, E.prototype._setColumns = function (e) {
        var t = e || E._getOuterWidth(this.element), i = this._getGutterSize(t), n = this._getColumnSize(t, i), s = (t + i) / n;
        this.cols = Math.max(Math.floor(s), 1), this.containerWidth = t, this.colWidth = n
    }, E.prototype._setContainerSize = function () {
        this.$el.css("height", this._getContainerSize())
    }, E.prototype._getContainerSize = function () {
        return a(this.positions)
    }, E.prototype._fire = function (e, t) {
        this.$el.trigger(e + "." + w, t && t.length ? t : [this])
    }, E.prototype._resetCols = function () {
        var e = this.cols;
        for (this.positions = []; e--;)this.positions.push(0)
    }, E.prototype._layout = function (e, t) {
        r(e, function (e) {
            this._layoutItem(e, !!t)
        }, this), this._processStyleQueue(), this._setContainerSize()
    }, E.prototype._layoutItem = function (t, i) {
        var n = e(t), s = n.data(), r = (s.point, s.scale, {
            width: E._getOuterWidth(t, !0),
            height: E._getOuterHeight(t, !0)
        }), o = this._getItemPosition(r);
        s.point = o, s.scale = I, this.styleQueue.push({
            $item: n,
            point: o,
            scale: I,
            opacity: i ? 0 : 1,
            skipTransition: i,
            callfront: function () {
                i || n.css("visibility", "visible")
            },
            callback: function () {
                i && n.css("visibility", "hidden")
            }
        })
    }, E.prototype._getItemPosition = function (e) {
        for (var t = this._getColumnSpan(e.width, this.colWidth, this.cols), i = this._getColumnSet(t, this.cols), n = this._getShortColumn(i, this.buffer), s = Math.round((this.containerWidth - (e.width * this.cols + this._itemMargin * (this.cols - 1))) / 2), r = new T(Math.round(this.colWidth * n + (s > 0 ? s : 0)), Math.round(i[n])), o = i[n] + e.height, a = this.cols + 1 - i.length, l = 0; a > l; l++)this.positions[n + l] = o;
        return r
    }, E.prototype._getColumnSpan = function (e, t, i) {
        var n = e / t;
        return Math.abs(Math.round(n) - n) < x && (n = Math.round(n)), Math.min(Math.ceil(n), i)
    }, E.prototype._getColumnSet = function (e, t) {
        if (1 === e)return this.positions;
        for (var i = t + 1 - e, n = [], s = 0; i > s; s++)n[s] = a(this.positions.slice(s, s + e));
        return n
    }, E.prototype._getShortColumn = function (e, t) {
        for (var i = l(e), n = 0, s = e.length; s > n; n++)if (e[n] >= i - t && e[n] <= i + t)return n;
        return 0
    }, E.prototype._shrink = function (t) {
        var i = t || this._getConcealedItems();
        r(i, function (t) {
            var i = e(t), n = i.data();
            n.scale !== C && (n.scale = C, this.styleQueue.push({
                $item: i,
                point: n.point,
                scale: C,
                opacity: 0,
                callback: function () {
                    i.css("visibility", "hidden")
                }
            }))
        }, this)
    }, E.prototype._onResize = function () {
        if (this.enabled && !this.destroyed && !this.isTransitioning) {
            var e = E._getOuterWidth(this.element);
            e !== this.containerWidth && this.update()
        }
    }, E.prototype._getStylesForTransition = function (e) {
        var t = {opacity: e.opacity};
        return this.supported ? t[m] = E._getItemTransformString(e.point, e.scale) : (t.left = e.point.x, t.top = e.point.y), t
    }, E.prototype._transition = function (t) {
        var i = this._getStylesForTransition(t);
        t.$item.data("keep-pos") ? (t.$item.removeData("keep-pos"), o(function () {
                this._startItemAnimation(t.$item, i, t.callfront || e.noop, t.callback || e.noop)
            }, this, 1e3)) : this._startItemAnimation(t.$item, i, t.callfront || e.noop, t.callback || e.noop)
    }, E.prototype._startItemAnimation = function (t, i, n, s) {
        function r(t) {
            t.target === t.currentTarget && (e(t.target).off(u, r), s())
        }

        if (n(), !this.initialized)return t.css(i), void s();
        if (this.supported) t.css(i), t.on(u, r); else {
            var o = t.stop(!0).animate(i, this.speed, "swing", s);
            this._animations.push(o.promise())
        }
    }, E.prototype._processStyleQueue = function (t) {
        var i = e();
        r(this.styleQueue, function (e) {
            e.skipTransition ? this._styleImmediately(e) : (i = i.add(e.$item), this._transition(e))
        }, this), i.length > 0 && this.initialized ? (this.isTransitioning = !0, this.supported ? (this._whenCollectionDone(i, u, this._movementFinished), this.isTransitioning = !1) : (this._whenAnimationsDone(this._movementFinished), this.isTransitioning = !1)) : t || o(this._layoutEnd, this), this.styleQueue.length = 0
    }, E.prototype._styleImmediately = function (e) {
        E._skipTransition(e.$item[0], function () {
            e.$item.css(this._getStylesForTransition(e))
        }, this)
    }, E.prototype._movementFinished = function () {
        this._layoutEnd()
    }, E.prototype._layoutEnd = function () {
        this.destroyed || this._fire(E.EventType.LAYOUT)
    }, E.prototype._addItems = function (e, t, i) {
        this._initItems(e), this._setTransitions(e), this.$items = this._getItems(), this._shrink(e), r(this.styleQueue, function (e) {
            e.skipTransition = !0
        }), this._processStyleQueue(!0), t ? this._addItemsToEnd(e, i) : this.shuffle(this.lastFilter)
    }, E.prototype._addItemsToEnd = function (e, t) {
        var i = this._filter(null, e), n = i.get();
        this._updateItemCount(), this._layout(n, !0), t && this.supported && this._setSequentialDelay(n), this._revealAppended(n)
    }, E.prototype._revealAppended = function (t) {
        o(function () {
            r(t, function (t) {
                var i = e(t);
                this._transition({$item: i, opacity: 1, point: i.data("point"), scale: I})
            }, this), this._whenCollectionDone(e(t), u, function () {
                e(t).css(h, "0ms"), this._movementFinished()
            })
        }, this, this.revealAppendedDelay)
    }, E.prototype._whenCollectionDone = function (t, i, n) {
        function s(t) {
            t.target === t.currentTarget && (e(t.target).off(i, s), r++, r === o && n.call(a))
        }

        var r = 0, o = t.length, a = this;
        t.on(i, s)
    }, E.prototype._whenAnimationsDone = function (t) {
        e.when.apply(null, this._animations).always(e.proxy(function () {
            this._animations.length = 0, t.call(this)
        }, this))
    }, E.prototype.shuffle = function (e, t) {
        this.enabled && !this.isTransitioning && (e || (e = _), this._filter(e), this._updateItemCount(), this._shrink(), this.sort(t))
    }, E.prototype.sort = function (e) {
        if (this.enabled && !this.isTransitioning) {
            this._resetCols();
            var t = e || this.lastSort, i = this._getFilteredItems().sorted(t);
            this._layout(i), this.lastSort = t
        }
    }, E.prototype.update = function (e) {
        this.enabled && !this.isTransitioning && (e || this._setColumns(), this.sort())
    }, E.prototype.layout = function () {
        this.destroyed || this.update(!0)
    }, E.prototype.appended = function (e, t, i) {
        this._addItems(e, !0, !0)
    }, E.prototype.disable = function () {
        this.enabled = !1
    }, E.prototype.enable = function (e) {
        this.enabled = !0, e !== !1 && this.update()
    }, E.prototype.remove = function (t) {
        function i() {
            t.remove(), this.$items = this._getItems(), this._updateItemCount(), this._fire(E.EventType.REMOVED, [t, this]), t = null
        }

        t.length && t.jquery && (this._toggleFilterClasses(e(), t), this._shrink(t), this.sort(), this.$el.one(E.EventType.LAYOUT + "." + w, e.proxy(i, this)))
    }, E.prototype.destroy = function () {
        k.off("." + this.unique), this.$el.removeClass(w).removeAttr("style").removeData(w), this.$items.removeAttr("style").removeData("point").removeData("scale").removeClass([E.ClassName.CONCEALED, E.ClassName.FILTERED, E.ClassName.SHUFFLE_ITEM].join(" ")), this.$items = null, this.$el = null, this.sizer = null, this.element = null, this.destroyed = !0
    }, e.fn.shuffle = function (t) {
        var i = Array.prototype.slice.call(arguments, 1);
        return this.each(function () {
            var n = e(this), s = n.data(w);
            s ? "string" == typeof t && s[t] && s[t].apply(s, i) : (s = new E(this, t), n.data(w, s))
        })
    }, e.fn.sorted = function (t) {
        var n = e.extend({}, e.fn.sorted.defaults, t), s = this.get(), r = !1;
        return s.length ? n.randomize ? f(s) : (e.isFunction(n.by) && s.sort(function (t, s) {
                    if (r)return 0;
                    var o = n.by(e(t)), a = n.by(e(s));
                    return o === i && a === i ? (r = !0, 0) : a > o || "sortFirst" === o || "sortLast" === a ? -1 : o > a || "sortLast" === o || "sortFirst" === a ? 1 : 0
                }), r ? this.get() : (n.reverse && s.reverse(), s)) : []
    }, e.fn.sorted.defaults = {reverse: !1, by: null, randomize: !1}, E
}), function (e, t) {
    var i, n = e.jQuery || e.Cowboy || (e.Cowboy = {});
    n.throttle = i = function (e, i, s, r) {
        function o() {
            function n() {
                l = +new Date, s.apply(d, p)
            }

            function o() {
                a = t
            }

            var d = this, f = +new Date - l, p = arguments;
            r && !a && n(), a && clearTimeout(a), r === t && f > e ? n() : i !== !0 && (a = setTimeout(r ? o : n, r === t ? e - f : e))
        }

        var a, l = 0;
        return "boolean" != typeof i && (r = s, s = i, i = t), n.guid && (o.guid = s.guid = s.guid || n.guid++), o
    }, n.debounce = function (e, n, s) {
        return s === t ? i(e, n, !1) : i(e, s, n !== !1)
    }
}(this), function (e) {
    "use strict";
    var t = null, i = e(window), n = function (t) {
        var i = this;
        if (e.extend(i, n.options, t, n.settings), !e.isFunction(i.enter))throw new TypeError("Viewport.add :: No `enter` function provided in Viewport options.");
        "string" == typeof i.threshold && i.threshold.indexOf("%") > -1 ? (i.isThresholdPercentage = !0, i.threshold = parseFloat(i.threshold) / 100) : i.threshold < 1 && i.threshold > 0 && (i.isThresholdPercentage = !0), i.hasLeaveCallback = e.isFunction(i.leave), i.$element = e(i.element), i.update()
    };
    n.prototype.update = function () {
        var e = this;
        e.offset = e.$element.offset(), e.height = e.$element.height(), e.$element.data("height", e.height), e.width = e.$element.width(), e.$element.data("width", e.width)
    }, n.options = {threshold: 200, delay: 0}, n.settings = {triggered: !1, isThresholdPercentage: !1};
    var s = function () {
        this.init()
    };
    s.prototype = {
        init: function () {
            var e = this;
            e.list = [], e.lastScrollY = 0, e.windowHeight = i.height(), e.windowWidth = i.width(), e.throttleTime = 100, e.onResize(), e.bindEvents(), e.willProcessNextFrame = !0, requestAnimationFrame(function () {
                e.setScrollTop(), e.process(), e.willProcessNextFrame = !1
            })
        }, bindEvents: function () {
            var t, n = this;
            t = function () {
                setTimeout(function () {
                    n.refresh()
                }, 0)
            }, i.on("resize.viewport", e.proxy(n.onResize, n)), i.on("scroll.viewport", e.throttle(n.throttleTime, e.proxy(n.onScroll, n))), n.hasActiveHandlers = !0
        }, unbindEvents: function () {
            i.off(".viewport"), this.hasActiveHandlers = !1
        }, maybeUnbindEvents: function () {
            var e = this;
            e.list.length || e.unbindEvents()
        }, add: function (e) {
            var t = this;
            t.list.push(e), t.hasActiveHandlers || t.bindEvents(), t.willProcessNextFrame || (t.willProcessNextFrame = !0, requestAnimationFrame(function () {
                t.willProcessNextFrame = !1, t.process()
            }))
        }, saveDimensions: function () {
            var t = this;
            e.each(t.list, function (e, t) {
                t.update()
            }), t.windowHeight = i.height(), t.windowWidth = i.width()
        }, onScroll: function () {
            var e = this;
            e.list.length && (e.setScrollTop(), e.process())
        }, onResize: function () {
            this.refresh()
        }, refresh: function () {
            this.list.length && this.saveDimensions()
        }, isInViewport: function (e) {
            var t, i = this, n = e.offset, s = e.threshold, r = s, o = i.lastScrollY;
            return e.isThresholdPercentage && (s = 0), t = i.isTopInView(o, i.windowHeight, n.top, e.height, s), t && e.isThresholdPercentage && (t = i.isTopPastPercent(o, i.windowHeight, n.top, e.height, r)), t
        }, isTopInView: function (e, t, i, n, s) {
            var r = e + t;
            return i + s >= e && r > i + s
        }, isTopPastPercent: function (e, t, i, n, s) {
            var r = e + t, o = r - i, a = o / t;
            return a >= s
        }, isOutOfViewport: function (e, t) {
            var i, n = this, s = e.offset, r = n.lastScrollY;
            return "bottom" === t && (i = !n.isBottomInView(r, n.windowHeight, s.top, e.height)), i
        }, isBottomInView: function (e, t, i, n) {
            var s = e + t, r = i + n;
            return r > e && s >= r
        }, triggerEnter: function (t) {
            var i = this;
            setTimeout(function () {
                t.enter.call(t.element, t)
            }, t.delay), e.isFunction(t.leave) ? t.triggered = !0 : i.list.splice(e.inArray(t, i.list), 1), i.maybeUnbindEvents()
        }, triggerLeave: function (e) {
            setTimeout(function () {
                e.leave.call(e.element, e)
            }, e.delay), e.triggered = !1
        }, setScrollTop: function () {
            this.lastScrollY = i.scrollTop()
        }, process: function () {
            var t = this, i = e.extend([], t.list);
            e.each(i, function (e, i) {
                var n = t.isInViewport(i), s = i.hasLeaveCallback && t.isOutOfViewport(i, "bottom");
                return !i.triggered && n ? t.triggerEnter(i) : !n && s && i.triggered ? t.triggerLeave(i) : void 0
            })
        }
    }, s.add = function (e) {
        var t = s.getInstance();
        return t.add(new n(e))
    }, s.refresh = function () {
        s.getInstance().refresh()
    }, s.getInstance = function () {
        return t || (t = new s), t
    }, window.FF_Viewport = s
}(jQuery), function (e, t, i) {
    "use strict";
    function n(e, t) {
        e.style.WebkitTransform = t, e.style.msTransform = t, e.style.transform = t
    }

    function s() {
        var t = l.clientWidth, i = e.innerWidth;
        return i > t ? i : t
    }

    function r() {
        var t = l.clientHeight, i = e.innerHeight;
        return i > t ? i : t
    }

    function o(e, t) {
        for (var i in t)t.hasOwnProperty(i) && (e[i] = t[i]);
        return e
    }

    function a(e, t) {
        return this.el = e[0], this.$el = e, this.options = o({}, this.options), o(this.options, t), this._init()
    }

    var l = e.document.documentElement, d = {
        WebkitTransition: "webkitTransitionEnd",
        MozTransition: "transitionend",
        OTransition: "oTransitionEnd",
        msTransition: "MSTransitionEnd",
        transition: "transitionend"
    }, f = d[t.prefixed("transition")], p = {transitions: t.csstransitions, support3d: t.csstransforms3d};
    a.prototype.options = {}, a.prototype._init = function () {
        return this.$body = i("body"), this.grid = this.el.querySelector(".ff-stream-wrapper"), this.gridItems = [].slice.call(this.grid.querySelectorAll(".ff-item:not(.ff-ad)")), this.itemsCount = this.gridItems.length, this.$wrapper = this.$el.find(".ff-slideshow"), this.slideshow = this.el.querySelector(".ff-slideshow > ul"), this.$slideshow = i(this.slideshow), this.$slideshow.data("media", !1), this._addSlideShowItems(this.gridItems), this.slideshowItems = [].slice.call(this.slideshow.children), this.current = -1, this.ctrlPrev = this.el.querySelector(".ff-nav-prev"), this.ctrlNext = this.el.querySelector(".ff-nav-next"), this.ctrlClose = this.el.querySelector(".ff-nav-close"), this._initEvents(), this
    }, a.prototype._addSlideShowItems = function (t) {
        var n = this;
        t.forEach(function (t, s) {
            var r, o, a, l, d, f = i(t), p = i('<li><div class="ff-slide-wrapper"></div></li>'), h = p.find(".ff-slide-wrapper"), c = f.find(".picture-item__inner").children().clone(), u = f.attr("data-type"), m = "", g = !1;
            f.attr("data-media") ? (n.$slideshow.data("media", !0), a = f.attr("data-media").split(";"), r = i('<div class="ff-media-wrapper' + ("image" == a[3] ? "" : " ff-video") + '" style="width: 100%; max-height: ' + a[1] + 'px;"></div>'), h.prepend(r), "image" == a[3] ? (d = parseInt(a[0]), l = d > 600 ? 600 / d * parseInt(a[1]) : a[1], m = '<span class="ff-img-holder" style="width: ' + a[0] + "px; max-height: " + a[1] + "px; height: " + l + "px; background-image: url(" + a[2] + ');"></span>', r.addClass("ff-slide-img-loading").data("media-image", a[2])) : "video/mp4" == a[3] ? m = '<video controls width="' + a[0] + '" height="' + a[1] + '"><source src="' + a[2] + '" type="video/mp4">Your browser does not support the video tag.</video>' : (a[2] = a[2].replace("http:", "").replace("https:", "").replace("/v/", "/embed/").replace("autoplay=1", "autoplay=0&fs=1"), m = '<iframe width="' + a[0] + '" height="' + a[1] + '" src="' + a[2] + '" frameborder="0" allowfullscreen webkitallowfullscreen mozallowfullscreen autoplay="1" wmode="opaque"></iframe>', a[2].indexOf("facebook.com/video/embed") + 1 && r.after('<span class="ff-cta">(Click image to play video)</span>')), r.data("media", m), c.find(".ff-img-holder").remove()) : c.find(".ff-img-holder").length && c.find(".ff-img-holder").each(function (e, t) {
                    var n = i(this), s = i(this).find("img"), r = s.get(0);
                    g ? n.remove() : (n.removeClass("ff-img-loading").addClass("ff-img-loaded").css({
                            "background-image": 'url("' + r.src + '")',
                            width: parseInt(r.style.width),
                            height: parseInt(r.style.height)
                        }), s.remove(), g = !0)
                }), h.append(c.not(".ff-img-holder")), o = h.find(".ff-item-cont"), /posts/.test(u) && (u = "wordpress"), o.append(p.find("h4")), o.append(p.find(".ff-article")), o.append(p.find(".ff-content").prepend(p.find(".ff-img-holder"))), o.append(p.find(".ff-item-meta")), o.find(".ff-userpic").append(p.find(".ff-icon")), o.find(".ff-item-meta").prepend(o.find(".ff-userpic")), o.find(".ff-timestamp").before("<br>").before('<span class="ff-posted">' + e.FlowFlowOpts.posted_on + " <span>" + u + "</span></span>"), p.find(".ff-content").each(function () {
                var e = i(this);
                e.is(":empty") ? e.remove() : e.wrap('<div class="ff-table"/>')
            }), n.$slideshow.append(p.attr("data-type", f.attr("data-type")))
        }), n.$slideshow.data("media") && n.$slideshow.addClass("ff-slideshow-media")
    }, a.prototype._initEvents = function (t) {
        var n = this;
        this.initItemsEvents(this.gridItems), i(this.ctrlPrev).on("click", function () {
            n._navigate("prev")
        }), i(this.ctrlNext).on("click", function () {
            n._navigate("next")
        }), i(this.ctrlClose).on("click", function () {
            n._closeSlideshow()
        }), this.$wrapper.on("click", function (e) {
            i(e.target).closest("li, nav").length || n._closeSlideshow();
        }), i(e).on("resize", function () {
            n._resizeHandler()
        }), i(document).on("keydown", function (e) {
            if (n.isSlideshowVisible) {
                var t = e.keyCode || e.which;
                switch (t) {
                    case 37:
                        n._navigate("prev");
                        break;
                    case 39:
                        n._navigate("next");
                        break;
                    case 27:
                        n._closeSlideshow()
                }
            }
        })
    }, a.prototype.initItemsEvents = function (e, t) {
        var n = this, s = i(this.grid).data("opts") && i(this.grid).data("opts").titles;
        t = t || 0, e.forEach(function (e, r) {
            i(e).find(".picture-item__inner").on("click", function (e) {
                var o = i(e.target), a = o.closest("a"), l = o.closest("h4").length;
                if (a.length && !o.is("img")) {
                    if ("yep" === s && l)return;
                    if (!l)return
                }
                e.preventDefault(), n._openSlideshow(r + t)
            })
        })
    }, a.prototype._freezeScroll = function (e) {
        e.preventDefault()
    }, a.prototype.checkScrollbar = function () {
        this.bodyIsOverflowing = document.body.scrollHeight > document.documentElement.clientHeight, this.scrollbarWidth = this.measureScrollbar()
    }, a.prototype.setScrollbar = function () {
        var e = parseInt(this.$body.css("padding-right") || 0, 10);
        this.bodyIsOverflowing && this.$body.css("padding-right", e + this.scrollbarWidth)
    }, a.prototype.resetScrollbar = function () {
        this.$body.css("padding-right", "")
    }, a.prototype.measureScrollbar = function () {
        var e = document.createElement("div");
        e.className = "ff-modal-scrollbar-measure", this.$body.append(e);
        var t = e.offsetWidth - e.clientWidth;
        return this.$body[0].removeChild(e), t
    }, a.prototype._openSlideshow = function (e) {
        this.isSlideshowVisible = !0, this.current = e, this.checkScrollbar(), this.setScrollbar(), this.$body.addClass("ff-modal-open");
        var t = this;
        setTimeout(function () {
            t.$wrapper.addClass("ff-slideshow-open").scrollTop(0), t._setViewportItems();
            var e = i(t.currentItem), o = i(t.nextItem), a = i(t.prevItem), l = s(), d = r();
            t.$curr = e, e.find(".ff-media-wrapper").each(function (e, t) {
                var n = i(this);
                if (n.data("media") && "inserted" !== n.data("media")) {
                    if (n.data("media-image")) {
                        var s = new Image;
                        s.src = n.data("media-image"), s.onload = function () {
                            n.removeClass("ff-slide-img-loading")
                        }
                    }
                    n.prepend(n.data("media")), n.data("media", "inserted")
                }
            }), o.add(a).find(".ff-media-wrapper").each(function (e, t) {
                var n = i(this), s = n.data("media");
                if (s && "inserted" !== s && !/iframe|video/.test(s)) {
                    if (n.data("media-image")) {
                        var r = new Image;
                        r.src = n.data("media-image"), r.onload = function () {
                            n.removeClass("ff-slide-img-loading")
                        }
                    }
                    n.prepend(n.data("media")), n.data("media", "inserted")
                }
            }), e.addClass("ff-current ff-show");
            var f = parseInt(Number(1 * (t.currentItem.offsetHeight / 2)));
            if (2 * f > d ? f = parseInt(d / 2) - 25 : t.$slideshow.bind("mousewheel DOMMouseScroll", t._freezeScroll), n(t.currentItem, p.support3d ? "translate3d(" + parseInt(Number(-1 * (t.currentItem.offsetWidth / 2))) + "px, -" + f + "px, 0px)" : "translate(-50%, -50%)"), t.prevItem) {
                a.addClass("ff-show");
                var h = Number(-1 * (l / 2 + t.prevItem.offsetWidth / 2));
                n(t.prevItem, p.support3d ? "translate3d(" + h + "px, -50%, -150px)" : "translate(" + h + "px, -50%)")
            }
            if (t.nextItem) {
                o.addClass("ff-show");
                var h = Number(l / 2 + t.nextItem.offsetWidth / 2);
                n(t.nextItem, p.support3d ? "translate3d(" + h + "px,-50%, -150px)" : "translate(" + h + "px, -50%)")
            }
        }, 100)
    }, a.prototype._navigate = function (e) {
        if (!this.isAnimating) {
            if ("next" === e && this.current === this.itemsCount - 1 || "prev" === e && 0 === this.current)return void this._closeSlideshow();
            this.isAnimating = !0, this._setViewportItems();
            var t, o, a, l = this, d = s(), h = r(), c = this.currentItem.offsetWidth, u = p.support3d ? "translate3d(-" + Number(d / 2 + c / 2) + "px, -50%, -150px)" : "translate(-" + Number(d / 2 + c / 2) + "px, -50%)", m = p.support3d ? "translate3d(" + Number(d / 2 + c / 2) + "px, -50%, -150px)" : "translate(" + Number(d / 2 + c / 2) + "px, -50%)";
            "next" === e ? (t = p.support3d ? "translate3d( -" + Number(2 * d / 2 + c / 2) + "px, -50%, -150px )" : "translate(-" + Number(2 * d / 2 + c / 2) + "px, -50%)", o = p.support3d ? "translate3d( " + Number(2 * d / 2 + c / 2) + "px, -50%, -150px )" : "translate(" + Number(2 * d / 2 + c / 2) + "px, -50%)") : (t = p.support3d ? "translate3d( " + Number(2 * d / 2 + c / 2) + "px, -50%, -150px )" : "translate(" + Number(2 * d / 2 + c / 2) + "px)", o = p.support3d ? "translate3d( -" + Number(2 * d / 2 + c / 2) + "px, -50%, -150px )" : "translate(-" + Number(2 * d / 2 + c / 2) + "px, -50%)"), l.$slideshow.removeClass("ff-animatable"), ("next" === e && this.current < this.itemsCount - 2 || "prev" === e && this.current > 1) && (a = this.slideshowItems["next" === e ? this.current + 2 : this.current - 2], n(a, o), i(a).addClass("ff-show").find(".ff-media-wrapper").each(function (e, t) {
                var n = i(this), s = n.data("media");
                if (s && "inserted" !== s && !/iframe|video/.test(s)) {
                    if (n.data("media-image")) {
                        var r = new Image;
                        r.src = n.data("media-image"), r.onload = function () {
                            n.removeClass("ff-slide-img-loading")
                        }
                    }
                    n.prepend(n.data("media")), n.data("media", "inserted")
                }
            }));
            var g = function () {
                var s;
                l.$slideshow.addClass("ff-animatable"), l.$curr.removeClass("ff-current");
                var r = "next" === e ? l.nextItem : l.prevItem;
                i(r).addClass("ff-current").find(".ff-media-wrapper").each(function (e, t) {
                    var n = i(this), s = n.data("media");
                    if (s && "inserted" !== s) {
                        if (n.data("media-image")) {
                            var r = new Image;
                            r.src = n.data("media-image"), r.onload = function () {
                                n.removeClass("ff-slide-img-loading")
                            }
                        }
                        n.prepend(n.data("media")), n.data("media", "inserted")
                    }
                }), n(l.currentItem, "next" === e ? u : m), l.nextItem && (s = parseInt(Number(1 * (l.nextItem.offsetHeight / 2))), 2 * s > h ? (s = parseInt(h / 2) - 25, "next" === e && l.$slideshow.off("mousewheel DOMMouseScroll", l._freezeScroll)) : "next" === e && (l.$slideshow.on("mousewheel DOMMouseScroll", l._freezeScroll), l.$wrapper.scrollTop(0)), n(l.nextItem, "next" === e ? p.support3d ? "translate3d(" + parseInt(Number(-1 * (l.nextItem.offsetWidth / 2))) + "px, -" + s + "px, 0px)" : "translate(-50%, -50%)" : t)), l.prevItem && (s = parseInt(Number(1 * (l.prevItem.offsetHeight / 2))), 2 * s > h ? (s = parseInt(h / 2) - 25, "prev" === e && l.$slideshow.off("mousewheel DOMMouseScroll", l._freezeScroll).scrollTop(0)) : "prev" === e && (l.$slideshow.on("mousewheel DOMMouseScroll", l._freezeScroll), l.$wrapper.scrollTop(0)), n(l.prevItem, "next" === e ? t : p.support3d ? "translate3d(" + parseInt(Number(-1 * (l.prevItem.offsetWidth / 2))) + "px, -" + s + "px, 0px)" : "translate(-50%, -50%)")), a && n(a, "next" === e ? m : u);
                var o = function (t) {
                    if (p.transitions && d >= 800) {
                        if (-1 === t.originalEvent.propertyName.indexOf("transform"))return !1;
                        i(this).off(f, o)
                    }
                    l.prevItem && "next" === e ? i(l.prevItem).removeClass("ff-show") : l.nextItem && "prev" === e && i(l.nextItem).removeClass("ff-show"), l._resetMedia(i(l.currentItem)), "next" === e ? (l.prevItem = l.currentItem, l.currentItem = l.nextItem, a && (l.nextItem = a)) : (l.nextItem = l.currentItem, l.currentItem = l.prevItem, a && (l.prevItem = a)), l.$curr = i(l.currentItem), l.current = "next" === e ? l.current + 1 : l.current - 1, l.isAnimating = !1
                };
                p.transitions && d >= 800 ? l.$curr.on(f, o) : o()
            };
            setTimeout(g, 25)
        }
    }, a.prototype._closeSlideshow = function (e) {
        this.$wrapper.removeClass("ff-slideshow-open"), this.$slideshow.removeClass("ff-animatable").unbind("mousewheel DOMMouseScroll", this._freezeScroll), this.resetScrollbar(), this.$body.removeClass("ff-modal-open");
        var t = this, s = function (e) {
            if (p.transitions && e) {
                if ("section" !== e.target.tagName.toLowerCase())return;
                i(this).off(f, s)
            }
            var r = i(t.currentItem);
            t.$curr = r, r.removeClass("ff-current"), r.removeClass("ff-show"), t._resetMedia(r), t.prevItem && i(t.prevItem).removeClass("ff-show"), t.nextItem && i(t.nextItem).removeClass("ff-show"), t.slideshowItems.forEach(function (e) {
                n(e, "")
            }), t.isSlideshowVisible = !1
        };
        p.transitions ? this.$wrapper.on(f, s) : s()
    }, a.prototype._resetMedia = function (e) {
        var t = e.attr("data-type");
        if ("vine" !== t && "soundcloud" !== t) {
            var i = e.find(".ff-video"), n = i.find("iframe, video");
            i.prepend(n)
        }
    }, a.prototype._setViewportItems = function () {
        this.currentItem = null, this.prevItem = null, this.nextItem = null, this.$curr = null, this.current > 0 && (this.prevItem = this.slideshowItems[this.current - 1]), this.current < this.itemsCount - 1 && (this.nextItem = this.slideshowItems[this.current + 1]), this.currentItem = this.slideshowItems[this.current], this.$curr = i(this.currentItem)
    }, a.prototype._resizeHandler = function () {
        function e() {
            t._resize(), t._resizeTimeout = null
        }

        var t = this;
        this._resizeTimeout && clearTimeout(this._resizeTimeout), this._resizeTimeout = setTimeout(e, 50)
    }, a.prototype._resize = function () {
        if (this.isSlideshowVisible) {
            if (this.prevItem) {
                var e = Number(-1 * (s() / 2 + this.prevItem.offsetWidth / 2));
                n(this.prevItem, p.support3d ? "translate3d(" + e + "px, -50%, -150px)" : "translate(" + e + "px, -50%)")
            }
            if (this.nextItem) {
                var e = Number(s() / 2 + this.nextItem.offsetWidth / 2);
                n(this.nextItem, p.support3d ? "translate3d(" + e + "px, -50%, -150px)" : "translate(" + e + "px, -50%)")
            }
        }
    }, e.CBPGridGallery = a
}(window, window.CustomModernizr, window.jQuery), function (e) {
    "use strict";
    function t(e) {
        if (document.createEvent) {
            var t = document.createEvent("MouseEvents");
            t.initEvent("click", !1, !0), e.dispatchEvent(t)
        } else document.createEventObject ? e.fireEvent("onclick") : "function" == typeof e.onclick && e.onclick()
    }

    var i, n, s = e("html"), r = navigator.userAgent.toLowerCase(), o = /safari|chrome/.test(r), a = /android|blackBerry|iphone|ipad|ipod|opera mini|iemobile/i.test(r), l = /msie|trident.*rv\:11\./.test(r), d = /firefox/.test(r), f = !1, p = window.FlowFlowOpts;
    if (l) {
        if (/msie 8/.test(r))return;
        i = /msie 9/.test(r)
    }
    s.addClass("ff-browser-" + (o ? /chrome/.test(r) ? "chrome" : "safari" : l ? "ie" + (i ? " ff-ie9" : "") : d ? "ff" : "")), e.expr.createPseudo && "function" == typeof e.expr.createPseudo ? e.expr[":"].contains = e.expr.createPseudo(function (t) {
            return function (i) {
                return e(i).text().toUpperCase().indexOf(t.toUpperCase()) >= 0
            }
        }) : jQuery.expr[":"].contains = function (e, t, i) {
            return jQuery(e).text().toUpperCase().indexOf(i[3].toUpperCase()) >= 0
        };
    var h = function (e) {
        function i() {
            return e(document).bind("ffimgloaded", function (e, t) {
                var i = t.$grid.data("shuffle");
                i && i.layout()
            }), i = function () {
                return h
            }, h
        }

        function s(i, n, s, l) {
            var d, f, h, c, m, y, w, x, _, b, I = "", C = "grid" === n.layout ? "ff-theme-" + n.theme : "";
            if (!n.feeds || "[]" === n.feeds)return "<p>No feeds to show. Add at least one</p>";
            if (!n.layout || !n.theme)return "<p>Please choose stream layout on options page</p>";
            "string" == typeof n.feeds && (n.feeds = JSON.parse(n.feeds)), y = n.feeds, n.hash = i.hash, n["next-page"] = i.page + 1, n.countOfPages = i.countOfPages;
            var T = i.items, S = 0, N = T.length, E = e('[id^="ff-uid-"]').length + 1 || 1;
            if ("yep" === n.gallery && !a) {
                var F = window.FlowFlowOpts.lightbox_navigate;
                I += '<section class="ff-slideshow"><ul></ul><nav><span class="ff-nav-prev"></span><span class="icon ff-nav-next"></span><span class="ff-nav-close"></span></nav><div class="ff-nav-info-keys">' + F + "</div></section>"
            }
            if (I += '<div class="ff-header ff-loading">', n.heading && (I += "<h1>" + n.heading + "</h1>"), n.subheading && (I += "<h2>" + n.subheading + "</h2>"), "yep" === n.filter) {
                for (w = "", x = {}, _ = 0, S = 0; N > S; S++)x[T[S].type] = 1;
                for (var O in x)"ad" !== O && (_ += 1, w += '<span class="ff-filter ff-type-' + O + '" data-filter="' + O + '"></span>');
                I += '<div class="ff-filter-holder">' + (_ > 1 ? '<span class="ff-filter ff-type-all">' + p.filter_all + "</span>" + w : "") + '<span class="ff-search"><input type="text" ' + ("grid" === n.layout ? 'placeholder="' + p.filter_search + '"' : "") + "/></span></div>"
            }
            if (s && (p.moderation = s, I += '<div class="ff-moderation-holder"><p><strong>PREMODERATION MODE IS ON</strong>. APPROVE POSTS AND HIT <strong>APPLY CHANGES</strong>.</p><span class="ff-moderation-button ff-moderation-apply">Apply changes</span><span class="ff-moderation-button ff-moderation-approve-new">Approve new posts</span></div>'), I += "</div>", m = "grid" === n.layout ? n[n.layout.charAt(0) + n.theme.charAt(0) + "-style"] : n["compact-style"], I += '<div class="ff-stream-wrapper ' + C + " ff-" + (a ? "mobile" : "desktop") + " ff-" + (m || "nostyle") + " shuffle--container" + ("grid" === n.layout && "yep" === n.viewportin && !a && window.requestAnimationFrame ? " shuffle--animatein" : " shuffle--animateoff") + " ff-c-" + n.cmeta + '">', b = u(T, E, !0, s, n), I += b, I += '<div class="shuffle__sizer"></div></div>', i.countOfPages > 1 && "grid" === n.layout && i.page + 1 != i.countOfPages && ("yep" !== n.mobileslider || !a) && (I += '<div class="ff-loadmore-wrapper"><span class="ff-btn">' + window.FlowFlowOpts.show_more + "</span></div>"), d = e(I), d.each(function (t) {
                    return this.className.indexOf("ff-stream-wrapper") + 1 ? (f = e(this), !1) : void 0
                }), h = d.find(".ff-item"), c = h.not(".ff-ad"), f.data("opts", n).data("items", h), c.each(function () {
                    e(this).find("img").not(":first").remove()
                }), d.find("p:empty, .ff-content:empty, .ff-content a:empty").remove(), d.find("img").each(function () {
                    o.apply(this, [f])
                }), d.find(".ff-filter").click(function () {
                    d.find(".ff-filter--active").removeClass("ff-filter--active");
                    var t = e(this).addClass("ff-filter--active").attr("data-filter");
                    v(f, t)
                }), d.find(".ff-search input").on("keyup", function () {
                    var e = this.value.toLowerCase();
                    g(f, e)
                }), d.on("click", "a", function () {
                    var t, i = e(this);
                    return i.closest(".ff-share-wrapper").length ? (t = e(this).attr("href"), window.open(t, "sharer", "toolbar=0,status=0,width=626,height=436"), !1) : i.is(".ff-no-link") && ("nope" === n.gallery || a) ? !1 : void 0
                }), "nope" === n.gallery || a ? (f.addClass("ff-gallery-off").on("click", '.ff-item:not(".ff-ad") .picture-item__inner', function (i) {
                        var n = e(i.target), s = e(this), r = n.closest("a");
                        return !r.length || n.is("img") ? (a ? s.toggleClass("ff-taped") : t(s.find(".ff-timestamp")[0]), !1) : void 0
                    }), f.on("click", ".ff-timestamp", function (e) {
                        e.stopImmediatePropagation()
                    })) : f.addClass("ff-gallery-on"), "yep" === p.open_in_new) {
                var $ = location.hostname;
                d.find("a").filter(function () {
                    return this.hostname != $
                }).attr("target", "_blank")
            }
            r(c, n), s && k(d, T, n), M[n.id] = f;
            for (var z in l)l[z] && this[z].init(f);
            return d
        }

        function r(t, i) {
            var n, s = "grid" === i.layout && "flat" === i.theme;
            s ? (n = i["gf-style"], I(t, n, i.hidemeta)) : t.each(function (t, i) {
                    var n = e(i), s = n.find(".ff-item-cont"), r = n.find(".ff-content .ff-img-holder");
                    n.addClass("ff-" + (r.length ? "" : "no-") + "image"), s.prepend(r)
                }), "compact" === i.layout && "c-style-2" === i["compact-style"] && t.find(".picture-item__inner").each(function () {
                var t = e(this);
                t.append(t.find(".ff-item-meta"))
            })
        }

        function o(t) {
            var i, n, s = e(this), r = this, o = s.parent(), a = o.is("a") ? o : s, l = !0;
            o.is(".ff-img-holder") || (i = s.attr("height"), s.removeAttr("width").removeAttr("height"), l = i && 0 != parseInt(i), n = e('<span class="ff-img-holder ff-img-loading" style="width: 100%;max-height: none"></span>'), a.wrap(n)), r.onload = function () {
                l || e(document).trigger("ffimgloaded", {$grid: t}), s.closest(".ff-img-holder").removeClass("ff-img-loading").addClass("ff-img-loaded")
            }
        }

        function l(e) {
            e.$el.layout()
        }

        function d(e) {
            var t, i, n, s, r, o, a, l = 0, d = p.server_time, f = d - e, h = new Date(1e3 * e), u = F.length - 1;
            for (a = u; a >= 0 && (t = f / F[a]) <= 1; a--);
            switch (0 > a && (a = 0), t = Math.floor(t), a) {
                case 3:
                    if (1 == t) {
                        i = p.dates.Yesterday;
                        break
                    }
                case 4:
                case 5:
                    s = h.getMonth(), r = h.getDate(), i = O[s] + " " + r;
                    break;
                case 6:
                case 7:
                    s = h.getMonth(), r = h.getDate(), o = h.getFullYear(), i = O[s] + " " + r + ", " + o;
                    break;
                default:
                    n = d - f % F[a], i = c(t, d, n, l, a)
            }
            return i
        }

        function c(e, t, i, n, s) {
            var r = $;
            r = r[s];
            var o = e + r;
            return o + " " + p.dates.ago
        }

        function u(e, t, i, n, s, r) {
            var o, l, d, f, h, c, u, m = e.length, g = "";
            for (r || (r = 0), s && "randomCompare" == s.order && (e = N(e)), o = 0; m > o; o++) {
                if (d = e[o], l = o + 1, "ad" !== d.type) {
                    u = "undefined" != typeof d.source ? d.source : d.permalink;
                    var v = "";
                    if (n) {
                        var y = "new" == d.status ? " ff-moderation-new-post" : "", w = "approved" == d.status ? "checked" : "";
                        v = '<div class="ff-moderation-wrapper ' + ("approved" == d.status ? "ff-approved" : "") + y + '"><span>Approve post</span> <label for="ff-mod-' + t + '"><input id="ff-mod-' + t + '" type="checkbox" class="ff-switcher" value="yes" ' + w + "/><div><span></span></div></label></div>"
                    }
                    g += '<div class="ff-item' + (d.media && "image" != d.media.type ? " ff-video-preview" : "") + " ff-" + d.type + '" id="ff-uid-' + t + '" post-id="' + d.id + '" data-type="' + d.type + '" data-index="' + (l + r) + '"' + (d.media ? ' data-media="' + d.media.width + ";" + d.media.height + ";" + ("yep" === p.forceHTTPS ? d.media.url.replace("http:", "https:") : d.media.url) + ";" + d.media.type + '"' : "") + ' data-timestamp="' + d.system_timestamp + '">' + (1 == FlowFlowOpts.isAdmin ? '<div class="ff-moderation-wrapper ff-moderation-featured-wrapper"><div class="featured_response"></div><span>Featured </span><label class="switch"><input id="ff-featured-' + (t + r) + '" value="yes" type="checkbox"  ' + ("1" == d.featured ? "checked" : "") + ' ><span class="slider round"></span></label></div>' : "") + (1 == FlowFlowOpts.isAdmin ? '<div class="ff-moderation-wrapper ff-moderation-is-active-wrapper"><div class="is-active-response"></div><span>Show/Hide </span><label class="switch"><input id="ff-is-active-' + (t + r) + '" value="yes" type="checkbox"  ' + ("1" == d.is_active ? "checked" : "") + ' ><span class="slider round"></span></label></div>' : "") + v + '<div class="picture-item__inner"><div class="ff-item-cont">' + (d.img ? '<span class="ff-img-holder ff-img-loading ff-no-margin" style="width:100%;max-height:' + d.img.height + 'px;"><img src="' + ("yep" === p.forceHTTPS ? d.img.url.replace("http:", "https:") : d.img.url) + '" style="width:' + d.img.width + "px;height:" + d.img.height + 'px;" /></span>' : "") + (d.header ? '<h4><a rel="nofollow" href="' + u + '">' + d.header + "</a></h4>" : "") + '<div class="ff-content">' + d.text + "</div>", g += '<div class="ff-item-meta"><span class="ff-userpic" style="background:url(' + ("yep" === p.forceHTTPS ? d.userpic.replace("http:", "https:") : d.userpic) + ')"><i class="ff-icon"><i class="ff-icon-inner"></i></i></span><a rel="nofollow" href="' + d.userlink + '" class="ff-name ' + (d.userlink ? "" : " ff-no-link") + '">' + d.screenname + "</a>" + (d.nickname ? '<a rel="nofollow" href="' + d.userlink + '" class="ff-nickname' + (d.userlink ? "" : " ff-no-link") + '">' + d.nickname + "</a>" : "") + '<a rel="nofollow" href="' + d.permalink + '" class="ff-timestamp">' + E(d.system_timestamp, d.timestamp) + "</a></div></div>", i && ("twitter" === d.type ? g += '<div class="ff-share-wrapper"><a href="https://twitter.com/intent/tweet?in_reply_to=' + d.id + '" class="ff-tw-reply"></a><a href="https://twitter.com/intent/retweet?tweet_id=' + d.id + '" class="ff-tw-retweet"></a><a href="https://twitter.com/intent/favorite?tweet_id=' + d.id + '" class="ff-tw-fav"></a></div>' : (c = encodeURIComponent(d.permalink), g += '<div class="ff-share-wrapper"><a href="http://www.facebook.com/sharer.php?u=' + c + '" class="ff-fb-share"></a><a href="https://twitter.com/share?' + (d.header ? "text=" + encodeURIComponent(d.header) + "&" : "") + "url=" + c + '" class="ff-tw-share"></a><a href="https://plus.google.com/share?url=' + c + '" class="ff-gp-share"></a></div>')), a && (g += '<a class="ff-mob-link" href="' + d.permalink + '"></a>'), g += "</div></div>"
                } else f = "yep" === d.label ? 'data-label="' + d.labelTxt + ";" + d.labelCol + '"' : "", h = 'style="' + (d.textCol ? "color:" + d.textCol + ";" : "") + ("js" === d.adtype ? "height:" + d.height + "px" : "") + '"', g += '<div class="ff-item ff-' + d.type + (d.permalink ? " ff-ad-link" : "") + '" id="ff-uid-' + t + '" post-id="' + d.id + '" data-type="' + d.type + '" data-adtype="' + d.adtype + '" data-index="' + l + '" ' + f + '><div class="picture-item__inner" style="' + (d.cardBG ? "background-color:" + d.cardBG + ";" : "") + '"><div class="ff-item-cont"><div class="ff-content" ' + h + ">" + d.text.replace(/document\.write\((.+?)\)/i, function (e, i) {
                        return "jQuery(" + i + ').appendTo(jQuery("#ff-uid-' + t + ' .ff-content"))'
                    }) + "</div>", d.permalink && (g += '<a class="ff-link" href="' + d.permalink + '"></a>'), g += "</div></div></div>";
                t++
            }
            return g
        }

        function m(e, t, i, n, s, r) {
            setTimeout(function () {
                y(e, t, i, n, s, r)
            }, 0)
        }

        function g(t, i) {
            clearTimeout(n), f || (t.find(".ff-item").each(_), f = !0), n = setTimeout(function () {
                g.finder, t.find(".ff-highlight").each(function () {
                    e(this).replaceWith(this.childNodes)
                }), i && t.shuffle("shuffle", function (t, n) {
                    var s, r;
                    return "all" !== n.group && -1 === e.inArray(n.group, t.data("groups")) ? !1 : (s = t.find(':contains("' + i + '")'), s.length && s.first().find("*").filter(function () {
                            var t = e(this);
                            return !t.children().length || t.is("p")
                        }).each(function (t, n) {
                            var s = e(n);
                            s.is("p") ? g.finder = window.findAndReplaceDOMText(n, {
                                    find: new RegExp(i, "i"),
                                    wrap: "span",
                                    clss: "ff-highlight"
                                }) : e(n).html(function (e, t) {
                                    var n = t.replace(new RegExp(i, "i"), function (e) {
                                        return '<span class="ff-highlight">' + e + "</span>"
                                    });
                                    return n
                                })
                        }), s.length || (r = e.trim(t.attr("data-type")).toLowerCase(), r = -1 !== r.indexOf(i)), s.length || r)
                })
            }, 100)
        }

        function v(t, i) {
            f || (t.find(".ff-item").each(_), f = !0), t.shuffle("shuffle", function (t, n) {
                if ("all" !== n.group && -1 === e.inArray(n.group, t.data("groups")))return !1;
                var s = e.trim(t.attr("data-type")).toLowerCase();
                return i ? -1 !== s.indexOf(i) : 1
            })
        }

        function y(t, i, n, s, l, d) {
            var f, h, c, m, g = t.find(".shuffle__sizer"), v = t.find(".ff-item");
            return x(v), s && !a && (c = t.parent(), h = new CBPGridGallery(c), m = c.find(".ff-slideshow").attr("id", c.attr("id") + "-slideshow"), "yep" === l.hidemeta && m.addClass("ff-hide-meta"), setTimeout(function () {
                document.body.appendChild(m.get(0))
            }, 0)), t.find(".ff-item:not(.ff-ad) .ff-content").readmore({
                maxHeight: 200,
                speed: 0,
                afterToggle: function () {
                    f.layout()
                }
            }), t.shuffle({
                itemSelector: ".ff-item",
                sizer: g
            }), f = t.data("shuffle"), i && (i = parseInt(i), t.addClass("ff-slider").parent().css("paddingBottom", "70px"), C(t, i, f, n), t.shuffle("shuffle", function (e, t) {
                return parseInt(e.attr("data-index")) <= i
            }), t.data("num", v.length), t.data("visible", 0)), window.requestAnimationFrame && w(t, v), t.on("done.shuffle", function () {
                setTimeout(function () {
                    f.layout(), d.find(".ff-loadmore-wrapper").css("visibility", "visible")
                }, 1e3)
            }), d.find(".ff-loadmore-wrapper span").click(function () {
                var i = e(this), n = d.find(".ff-loader"), s = d.find(".ff-item").not(".ff-ad").length, a = {
                    action: "fetch_posts",
                    "stream-id": l.id,
                    page: l["next-page"],
                    countOfPages: l.countOfPages,
                    hash: l.hash
                };
                i.css("opacity", 0), n.insertAfter(i).removeClass("ff-squeezed"), e.get(FlowFlowOpts.ajaxurl, a, function (a) {
                    var d = JSON.parse(a), c = d.items, m = (c.length, e('[id^="ff-uid-"]').length + 1 || 1), g = u(c, m, !0, p.moderation, l), v = e(g), y = v.not(".ff-ad"), _ = y.toArray();
                    if (t.trigger("loaded_more", {items: v}), l.hash = d.hash, l["next-page"] = d.page + 1, l.countOfPages = d.countOfPages, t.append(v), t.shuffle("appended", v), x(v), window.requestAnimationFrame && w(t, v), y.each(function () {
                            e(this).find("img").not(":first").remove()
                        }), v.find("img").each(function () {
                            o.apply(this, [t])
                        }), h && (h._addSlideShowItems(_), h.initItemsEvents(_, s), h.slideshowItems = [].slice.call(h.slideshow.children), h.itemsCount = h.itemsCount + y.length), "yep" === p.open_in_new) {
                        var b = location.hostname;
                        v.find("a").filter(function () {
                            return this.hostname != b
                        }).attr("target", "_blank")
                    }
                    if (r(y, l), n.addClass("ff-squeezed"), setTimeout(function () {
                            y.filter(":lt(5)").addClass("in"), y.find(".ff-content").readmore({
                                maxHeight: 200,
                                speed: 0,
                                afterToggle: function () {
                                    f.layout()
                                }
                            }), setTimeout(function () {
                                d.page + 1 != d.countOfPages ? i.css("opacity", 1) : i.remove(), f.layout()
                            }, 200)
                        }, 14), FlowFlowOpts.dependencies.ads && d.ads) {
                        var I = jQuery.post(p.ajaxurl, {action: "flow_flow_ad_action", status: "view", id: d.ads});
                        e.when(I).always(function (e) {
                        })
                    }
                })
            }), f
        }

        function w(e, t) {
            t.each(function () {
                FF_Viewport.add({element: this, threshold: 130, enter: _, leave: b})
            })
        }

        function x(e) {
            e.find(".picture-item__inner").addClass("picture-item__inner--transition")
        }

        function _() {
            e(this).addClass("in").data("viewport", "in")
        }

        function b() {
            e(this).data("viewport", "out")
        }

        function I(t, i, n) {
            t.each(function (t, s) {
                var r, o = e(s), a = o.find(".picture-item__inner"), l = o.find(".ff-img-holder");
                /[12]/.test(i) ? (r = o.find(".ff-item-meta"), "yep" !== n && (o.find(".ff-item-cont").prepend(r), l.length || "style-1" === i && r.append(r.find(".ff-userpic")))) : "style-3" === i && (a.prepend(o.find(".ff-icon")), "yep" === n && (r = o.find(".ff-item-meta"), o.find(".ff-item-cont").prepend(r.hide()))), o.addClass("ff-" + (l.length ? "" : "no-") + "image"), a.prepend(l)
            })
        }

        function C(t, i, n, s) {
            function r() {
                var e = f.data("currentSlide"), t = e - 1;
                1 > t && (t = c), f.data("currentSlide", t), l(t), s && setTimeout(d, 0)
            }

            function o() {
                var e = f.data("currentSlide"), t = e + 1;
                t > c && (t = 1), f.data("currentSlide", t), l(t), s && setTimeout(d, 0)
            }

            function l(n) {
                t.shuffle("shuffle", function (t, s) {
                    var r, o, a;
                    return "all" !== s.group && -1 === e.inArray(s.group, t.data("groups")) ? !1 : (r = t.attr("data-index"), o = i * (n - 1), a = i * n, r > o && a >= r)
                })
            }

            function d() {
                var i = t.offset().top;
                e("html, body").animate({scrollTop: i - 100}, 300)
            }

            var f, p = e('<span class="ff-control-prev"/>'), h = e('<span class="ff-control-next"/>'), c = Math.ceil(n.$items.length / i);
            p.on("click", r), h.on("click", o), a && S(t, r, o), f = e('<div class="ff-controls-wrapper"></div>').append(p).append(h), f.data("currentSlide", 1), t.on("layout.shuffle", function () {
            }), t.append(f)
        }

        function T(t, i) {
            t.find("img").each(function () {
                var t = e(this), n = parseInt(t.css("height")), s = parseInt(t.css("width")), r = i / s;
                t.css("height", Math.round(n * r) + "px")
            })
        }

        function S(e, t, i) {
            var n, s, r, o, a;
            e.bind("touchstart", function (e) {
                r = (new Date).getTime(), n = e.originalEvent.touches[0].pageX, s = e.originalEvent.touches[0].clientY
            }).bind("touchmove", function (e) {
                o = e.originalEvent.touches[0].pageX, a = e.originalEvent.touches[0].clientY
            }).bind("touchend", function () {
                var e = o > n ? "right" : "left", l = a - s > 60 || -60 > a - s, d = o - n > 60 || -60 > o - n, f = (new Date).getTime();
                if (!(f - r > 300 || l) && d)switch (e) {
                    case"left":
                        i();
                        break;
                    case"right":
                        t()
                }
            })
        }

        function k(t, i, n) {
            var s = n.id, r = n.hash, o = {};
            t.find(".ff-moderation-apply").click(function (t) {
                var i = e.post(FlowFlowOpts.ajaxurl, {
                    action: "moderation_apply_action",
                    moderation_action: "custom_approve",
                    stream: s,
                    changed: o,
                    hash: r
                });
                e.when(i).done(function (e) {
                    location.reload()
                })
            }), t.find(".ff-moderation-approve-new").click(function (t) {
                var i = e.post(FlowFlowOpts.ajaxurl, {
                    action: "moderation_apply_action",
                    moderation_action: "new_posts_approve",
                    stream: s,
                    hash: r
                });
                e.when(i).done(function (e) {
                    location.reload()
                })
            }), t.on("change", ".ff-moderation-wrapper input", function (t) {
                var i = e(this), n = i.is(":checked"), s = i.closest(".ff-item").attr("post-id");
                i.closest(".ff-moderation-wrapper")[n ? "addClass" : "removeClass"]("ff-approved"), o[s] = {approved: n}
            })
        }

        function N(e) {
            for (var t, i, n = e.length; 0 !== n;)i = Math.floor(Math.random() * n), n -= 1, t = e[n], e[n] = e[i], e[i] = t;
            return e
        }

        var E = "agoStyleDate" === p.date_style ? function (e, t) {
                return d(e, t)
            } : function (e, t) {
                return t
            }, F = [1, 60, 3600, 86400, 604800, 2630880, 31570560, 315705600], O = p.dates.months, $ = [p.dates.s, p.dates.m, p.dates.h], M = {};
        return {
            init: i,
            streams: M,
            addTransitionToItems: x,
            addViewportItems: w,
            prepareImageFor: o,
            adjustItems: r,
            shuffle: y,
            recalcLayout: l,
            buildItems: u,
            buildStreamWith: s,
            setupGrid: m,
            reformat: I,
            adjustImgHeight: T
        }
    }(e);
    window.FlowFlow = h.init(), jQuery(document).ready(function () {
        jQuery("body").on("change", ".ff-moderation-featured-wrapper input", function () {
            var e = jQuery(this), t = jQuery(this), i = t.is(":checked"), n = t.closest(".ff-item").attr("post-id");
            t.closest(".ff-moderation-wrapper")[i ? "addClass" : "removeClass"]("ff-featured"), jQuery.ajax({
                url: FlowFlowOpts.ajaxurl,
                type: "post",
                data: {action: "featured_post_apply_action", featured: i, post_id: n}
            }).success(function (t) {
                var i = JSON.parse(t);
                i.status ? e.closest(".ff-moderation-featured-wrapper").find(".featured_response").html('<span  style="color:#3b981c">Post updated successfully.</span>').css("display", "block").fadeOut(5e3) : e.closest(".ff-moderation-featured-wrapper").find(".featured_response").html('<span style="color:#ff0000"> Post has not been updated successfully.</span>').css("display", "block").fadeOut(5e3)
            }).fail(function (t) {
                e.closest(".ff-moderation-featured-wrapper").find(".featured_response").html('<span style="color:#ff0000"> Post has not been updated successfully.</span>').css("display", "block").fadeOut(5e3)
            })
        }), jQuery("body").on("change", ".ff-moderation-is-active-wrapper input", function () {
            var e = jQuery(this), t = jQuery(this), i = t.is(":checked"), n = t.closest(".ff-item").attr("post-id");
            jQuery.ajax({
                url: FlowFlowOpts.ajaxurl,
                type: "post",
                data: {action: "post_display_action", is_active: i, post_id: n}
            }).success(function (t) {
                var i = JSON.parse(t);
                i.status ? e.closest(".ff-moderation-is-active-wrapper").find(".is-active-response").html('<span  style="color:#3b981c">Post updated successfully.</span>').css("display", "block").fadeOut(5e3) : e.closest(".ff-moderation-is-active-wrapper").find(".is-active-response").html('<span style="color:#ff0000"> Post has not been updated successfully.</span>').css("display", "block").fadeOut(5e3)
            }).fail(function (t) {
                e.closest(".ff-moderation-is-active-wrapper").find(".is-active-response").html('<span style="color:#ff0000"> Post has not been updated successfully.</span>').css("display", "block").fadeOut(5e3)
            })
        })
    })
}(jQuery);