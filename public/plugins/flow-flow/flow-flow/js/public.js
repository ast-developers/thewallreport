window.CustomModernizr = function(t, e, i) {
    function n(t) {
        m.cssText = t
    }

    function s(t, e) {
        return typeof t === e
    }

    function r(t, e) {
        return !!~("" + t).indexOf(e)
    }

    function a(t, e) {
        for (var n in t) {
            var s = t[n];
            if (!r(s, "-") && m[s] !== i) return "pfx" != e || s
        }
        return !1
    }

    function o(t, e, n) {
        for (var r in t) {
            var a = e[t[r]];
            if (a !== i) return !1 === n ? t[r] : s(a, "function") ? a.bind(n || e) : a
        }
        return !1
    }

    function l(t, e, i) {
        var n = t.charAt(0).toUpperCase() + t.slice(1),
            r = (t + " " + y.join(n + " ") + n).split(" ");
        return s(e, "string") || s(e, "undefined") ? a(r, e) : (r = (t + " " + w.join(n + " ") + n).split(" "), o(r, e, i))
    }
    var d, f, h = {},
        c = e.documentElement,
        p = "modernizr",
        u = e.createElement(p),
        m = u.style,
        g = " -webkit- -moz- -o- -ms- ".split(" "),
        v = "Webkit Moz O ms",
        y = v.split(" "),
        w = v.toLowerCase().split(" "),
        x = {},
        b = [],
        _ = b.slice,
        I = function(t, i, n, s) {
            var r, a, o, l, d = e.createElement("div"),
                f = e.body,
                h = f || e.createElement("body");
            if (parseInt(n, 10))
                for (; n--;) o = e.createElement("div"), o.id = s ? s[n] : p + (n + 1), d.appendChild(o);
            return r = ["&#173;", '<style id="s', p, '">', t, "</style>"].join(""), d.id = p, (f ? d : h).innerHTML += r, h.appendChild(d), f || (h.style.background = "", h.style.overflow = "hidden", l = c.style.overflow, c.style.overflow = "hidden", c.appendChild(h)), a = i(d, t), f ? d.parentNode.removeChild(d) : (h.parentNode.removeChild(h), c.style.overflow = l), !!a
        },
        C = {}.hasOwnProperty;
    f = s(C, "undefined") || s(C.call, "undefined") ? function(t, e) {
        return e in t && s(t.constructor.prototype[e], "undefined")
    } : function(t, e) {
        return C.call(t, e)
    }, Function.prototype.bind || (Function.prototype.bind = function(t) {
        var e = this;
        if ("function" != typeof e) throw new TypeError;
        var i = _.call(arguments, 1),
            n = function() {
                if (this instanceof n) {
                    var s = function() {};
                    s.prototype = e.prototype;
                    var r = new s,
                        a = e.apply(r, i.concat(_.call(arguments)));
                    return Object(a) === a ? a : r
                }
                return e.apply(t, i.concat(_.call(arguments)))
            };
        return n
    }), x.csstransforms = function() {
        return !!l("transform")
    }, x.csstransforms3d = function() {
        var t = !!l("perspective");
        return t && "webkitPerspective" in c.style && I("@media (transform-3d),(-webkit-transform-3d){#modernizr{left:9px;position:absolute;height:3px;}}", function(e, i) {
            t = 9 === e.offsetLeft && 3 === e.offsetHeight
        }), t
    }, x.csstransitions = function() {
        return l("transition")
    };
    for (var T in x) f(x, T) && (d = T.toLowerCase(), h[d] = x[T](), b.push((h[d] ? "" : "no-") + d));
    return h.addTest = function(t, e) {
        if ("object" == typeof t)
            for (var n in t) f(t, n) && h.addTest(n, t[n]);
        else {
            if (t = t.toLowerCase(), h[t] !== i) return h;
            e = "function" == typeof e ? e() : e, c.className += " " + (e ? "" : "no-") + t, h[t] = e
        }
        return h
    }, n(""), u = null, h._version = "2.6.2", h._prefixes = g, h._domPrefixes = w, h._cssomPrefixes = y, h.testProp = function(t) {
        return a([t])
    }, h.testAllProps = l, h.testStyles = I, h.prefixed = function(t, e, i) {
        return e ? l(t, e, i) : l(t, "pfx")
    }, c.className = c.className.replace(/(^|\s)no-js(\s|$)/, "$1$2") + " js " + b.join(" "), h
}(0, this.document), window.findAndReplaceDOMText = function() {
    function t(t) {
        return String(t).replace(/([.*+?^=!:${}()|[\]\/\\])/g, "\\$1")
    }

    function e() {
        return i.apply(null, arguments) || n.apply(null, arguments)
    }

    function i(t, i, s, r, a) {
        if (i && !i.nodeType && arguments.length <= 2) return !1;
        var o = "function" == typeof s;
        o && (s = function(t) {
            return function(e, i) {
                return t(e.text, i.startIndex)
            }
        }(s));
        var l = n(i, {
            find: t,
            wrap: o ? null : s,
            replace: o ? s : "$" + (r || "&"),
            prepMatch: function(t, e) {
                if (!t[0]) throw "findAndReplaceDOMText cannot handle zero-length matches";
                if (r > 0) {
                    var i = t[r];
                    t.index += t[0].indexOf(i), t[0] = i
                }
                return t.endIndex = t.index + t[0].length, t.startIndex = t.index, t.index = e, t
            },
            filterElements: a
        });
        return e.revert = function() {
            return l.revert()
        }, !0
    }

    function n(t, e) {
        return new s(t, e)
    }

    function s(t, e) {
        e.portionMode = e.portionMode || r, this.node = t, this.options = e, this.prepMatch = e.prepMatch || this.prepMatch, this.reverts = [], this.matches = this.search(), this.matches.length && this.processMatches()
    }
    var r = "retain",
        a = document;
    return e.Finder = s, s.prototype = {
        search: function() {
            var e, i = 0,
                n = this.options.find,
                s = this.getAggregateText(),
                r = [];
            if ((n = "string" == typeof n ? RegExp(t(n), "g") : n).global)
                for (; e = n.exec(s);) r.push(this.prepMatch(e, i++));
            else(e = s.match(n)) && r.push(this.prepMatch(e, 0));
            return r
        },
        prepMatch: function(t, e) {
            if (!t[0]) throw new Error("findAndReplaceDOMText cannot handle zero-length matches");
            return t.endIndex = t.index + t[0].length, t.startIndex = t.index, t.index = e, t
        },
        getAggregateText: function() {
            function t(i) {
                if (3 === i.nodeType) return i.data;
                if (e && !e(i)) return "";
                var n = "";
                if (i = i.firstChild)
                    do n += t(i); while (i = i.nextSibling);
                return n
            }
            var e = this.options.filterElements;
            return t(this.node)
        },
        processMatches: function() {
            var t, e, i, n = this.matches,
                s = this.node,
                r = this.options.filterElements,
                a = [],
                o = s,
                l = n.shift(),
                d = 0,
                f = 0,
                h = 0,
                c = [s];
            t: for (;;) {
                if (3 === o.nodeType && (!e && o.length + d >= l.endIndex ? e = {
                        node: o,
                        index: h++,
                        text: o.data.substring(l.startIndex - d, l.endIndex - d),
                        indexInMatch: d - l.startIndex,
                        indexInNode: l.startIndex - d,
                        endIndexInNode: l.endIndex - d,
                        isEnd: !0
                    } : t && a.push({
                        node: o,
                        index: h++,
                        text: o.data,
                        indexInMatch: d - l.startIndex,
                        indexInNode: 0
                    }), !t && o.length + d > l.startIndex && (t = {
                        node: o,
                        index: h++,
                        indexInMatch: 0,
                        indexInNode: l.startIndex - d,
                        endIndexInNode: l.endIndex - d,
                        text: o.data.substring(l.startIndex - d, l.endIndex - d)
                    }), d += o.data.length), i = 1 === o.nodeType && r && !r(o), t && e) {
                    if (o = this.replaceMatch(l, t, a, e), d -= e.node.data.length - e.endIndexInNode, t = null, e = null, a = [], l = n.shift(), h = 0, f++, !l) break
                } else if (!i && (o.firstChild || o.nextSibling)) {
                    o.firstChild ? (c.push(o), o = o.firstChild) : o = o.nextSibling;
                    continue
                }
                for (;;) {
                    if (o.nextSibling) {
                        o = o.nextSibling;
                        break
                    }
                    if ((o = c.pop()) === s) break t
                }
            }
        },
        revert: function() {
            for (var t = this.reverts.length; t--;) this.reverts[t]();
            this.reverts = []
        },
        prepareReplacementString: function(t, e, i, n) {
            var s = this.options.portionMode;
            return "first" === s && e.indexInMatch > 0 ? "" : (t = t.replace(/\$(\d+|&|`|')/g, function(t, e) {
                var n;
                switch (e) {
                    case "&":
                        n = i[0];
                        break;
                    case "`":
                        n = i.input.substring(0, i.startIndex);
                        break;
                    case "'":
                        n = i.input.substring(i.endIndex);
                        break;
                    default:
                        n = i[+e]
                }
                return n
            }), "first" === s ? t : e.isEnd ? t.substring(e.indexInMatch) : t.substring(e.indexInMatch, e.indexInMatch + e.text.length))
        },
        getPortionReplacementNode: function(t, e, i) {
            var n = this.options.replace || "$&",
                s = this.options.clss,
                r = this.options.wrap;
            if (r && r.nodeType) {
                var o = a.createElement("div");
                o.innerHTML = r.outerHTML || (new XMLSerializer).serializeToString(r), r = o.firstChild
            }
            if ("function" == typeof n) return n = n(t, e, i), n && n.nodeType ? n : a.createTextNode(String(n));
            var l = "string" == typeof r ? a.createElement(r) : r;
            return s && (l.className = s), (n = a.createTextNode(this.prepareReplacementString(n, t, e, i))).data && l ? (l.appendChild(n), l) : n
        },
        replaceMatch: function(t, e, i, n) {
            var s, r, o = e.node,
                l = n.node;
            if (o === l) {
                var d = o;
                e.indexInNode > 0 && (s = a.createTextNode(d.data.substring(0, e.indexInNode)), d.parentNode.insertBefore(s, d));
                var f = this.getPortionReplacementNode(n, t);
                return d.parentNode.insertBefore(f, d), n.endIndexInNode < d.length && (r = a.createTextNode(d.data.substring(n.endIndexInNode)), d.parentNode.insertBefore(r, d)), d.parentNode.removeChild(d), this.reverts.push(function() {
                    s === f.previousSibling && s.parentNode.removeChild(s), r === f.nextSibling && r.parentNode.removeChild(r), f.parentNode.replaceChild(d, f)
                }), f
            }
            s = a.createTextNode(o.data.substring(0, e.indexInNode)), r = a.createTextNode(l.data.substring(n.endIndexInNode));
            for (var h = this.getPortionReplacementNode(e, t), c = [], p = 0, u = i.length; u > p; ++p) {
                var m = i[p],
                    g = this.getPortionReplacementNode(m, t);
                m.node.parentNode.replaceChild(g, m.node), this.reverts.push(function(t, e) {
                    return function() {
                        e.parentNode.replaceChild(t.node, e)
                    }
                }(m, g)), c.push(g)
            }
            var v = this.getPortionReplacementNode(n, t);
            return o.parentNode.insertBefore(s, o), o.parentNode.insertBefore(h, o), o.parentNode.removeChild(o), l.parentNode.insertBefore(v, l), l.parentNode.insertBefore(r, l), l.parentNode.removeChild(l), this.reverts.push(function() {
                s.parentNode.removeChild(s), h.parentNode.replaceChild(o, h), r.parentNode.removeChild(r), v.parentNode.replaceChild(l, v)
            }), v
        }
    }, e
}(),
    function(t, e) {
        function i(t, e, i) {
            var n = t.children(),
                s = !1;
            t.empty();
            for (var a = 0, o = n.length; o > a; a++) {
                var l = n.eq(a);
                if (t.append(l), i && t.append(i), r(t, e)) {
                    l.remove(), s = !0;
                    break
                }
                i && i.detach()
            }
            return s
        }

        function n(e, i, a, o, l) {
            var d = !1;
            return e.contents().detach().each(function() {
                var f = this,
                    h = t(f);
                if (void 0 === f) return !0;
                if (h.is("script, .dotdotdot-keep")) e.append(h);
                else {
                    if (d) return !0;
                    e.append(h), !l || h.is(o.after) || h.find(o.after).length || e[e.is("a, table, thead, tbody, tfoot, tr, col, colgroup, object, embed, param, ol, ul, dl, blockquote, select, optgroup, option, textarea, script, style") ? "after" : "append"](l), r(a, o) && (d = 3 == f.nodeType ? s(h, i, a, o, l) : n(h, i, a, o, l)), d || l && l.detach()
                }
            }), i.addClass("is-truncated"), d
        }

        function s(e, i, n, s, o) {
            var f = e[0];
            if (!f) return !1;
            var c = d(f),
                p = -1 !== c.indexOf(" ") ? " " : "　",
                u = "letter" == s.wrap ? "" : p,
                m = c.split(u),
                g = -1,
                v = -1,
                y = 0,
                w = m.length - 1;
            for (s.fallbackToLetter && 0 == y && 0 == w && (u = "", m = c.split(u), w = m.length - 1); w >= y && (0 != y || 0 != w);) {
                var x = Math.floor((y + w) / 2);
                if (x == v) break;
                v = x, l(f, m.slice(0, v + 1).join(u) + s.ellipsis), n.children().each(function() {
                    t(this).toggle().toggle()
                }), r(n, s) ? (w = v, s.fallbackToLetter && 0 == y && 0 == w && (u = "", m = m[0].split(u), g = -1, v = -1, y = 0, w = m.length - 1)) : (g = v, y = v)
            }
            if (-1 == g || 1 == m.length && 0 == m[0].length) {
                var b = e.parent();
                e.detach();
                var _ = o && o.closest(b).length ? o.length : 0;
                if (b.contents().length > _ ? f = h(b.contents().eq(-1 - _), i) : (f = h(b, i, !0), _ || b.detach()), f && (c = a(d(f), s), l(f, c), _ && o)) {
                    var I = o.parent();
                    t(f).parent().append(o), t.trim(I.html()) || I.remove()
                }
            } else c = a(m.slice(0, g + 1).join(u), s), l(f, c);
            return !0
        }

        function r(t, e) {
            return t.innerHeight() > e.maxHeight
        }

        function a(e, i) {
            for (; t.inArray(e.slice(-1), i.lastCharacter.remove) > -1;) e = e.slice(0, -1);
            return t.inArray(e.slice(-1), i.lastCharacter.noEllipsis) < 0 && (e += i.ellipsis), e
        }

        function o(t) {
            return {
                width: t.innerWidth(),
                height: t.innerHeight()
            }
        }

        function l(t, e) {
            t.innerText ? t.innerText = e : t.nodeValue ? t.nodeValue = e : t.textContent && (t.textContent = e)
        }

        function d(t) {
            return t.innerText ? t.innerText : t.nodeValue ? t.nodeValue : t.textContent ? t.textContent : ""
        }

        function f(t) {
            do t = t.previousSibling; while (t && 1 !== t.nodeType && 3 !== t.nodeType);
            return t
        }

        function h(e, i, n) {
            var s, r = e && e[0];
            if (r) {
                if (!n) {
                    if (3 === r.nodeType) return r;
                    if (t.trim(e.text())) return h(e.contents().last(), i)
                }
                for (s = f(r); !s;) {
                    if ((e = e.parent()).is(i) || !e.length) return !1;
                    s = f(e[0])
                }
                if (s) return h(t(s), i)
            }
            return !1
        }

        function c(e, i) {
            return !!e && ("string" == typeof e ? !!(e = t(e, i)).length && e : !!e.jquery && e)
        }

        function p(t) {
            for (var e = t.innerHeight(), i = ["paddingTop", "paddingBottom"], n = 0, s = i.length; s > n; n++) {
                var r = parseInt(t.css(i[n]), 10);
                isNaN(r) && (r = 0), e -= r
            }
            return e
        }
        if (!t.fn.dotdotdot) {
            t.fn.dotdotdot = function(e) {
                if (0 == this.length) return t.fn.dotdotdot.debug('No element found for "' + this.selector + '".'), this;
                if (this.length > 1) return this.each(function() {
                    t(this).dotdotdot(e)
                });
                var s = this,
                    a = s.contents();
                s.data("dotdotdot") && s.trigger("destroy.dot"), s.data("dotdotdot-style", s.attr("style") || ""), s.css("word-wrap", "break-word"), "nowrap" === s.css("white-space") && s.css("white-space", "normal"), s.bind_events = function() {
                    return s.bind("update.dot", function(e, o) {
                        switch (s.removeClass("is-truncated"), e.preventDefault(), e.stopPropagation(), typeof l.height) {
                            case "number":
                                l.maxHeight = l.height;
                                break;
                            case "function":
                                l.maxHeight = l.height.call(s[0]);
                                break;
                            default:
                                l.maxHeight = p(s)
                        }
                        l.maxHeight += l.tolerance, void 0 !== o && (("string" == typeof o || "nodeType" in o && 1 === o.nodeType) && (o = t("<div />").append(o).contents()), o instanceof t && (a = o)), (m = s.wrapInner('<div class="dotdotdot" />').children()).contents().detach().end().append(a.clone(!0)).find("br").replaceWith("  <br />  ").end().css({
                            height: "auto",
                            width: "auto",
                            border: "none",
                            padding: 0,
                            margin: 0
                        });
                        var f = !1,
                            h = !1;
                        return d.afterElement && ((f = d.afterElement.clone(!0)).show(), d.afterElement.detach()), r(m, l) && (h = "children" == l.wrap ? i(m, l, f) : n(m, s, m, l, f)), m.replaceWith(m.contents()), m = null, t.isFunction(l.callback) && l.callback.call(s[0], h, a), d.isTruncated = h, h
                    }).bind("isTruncated.dot", function(t, e) {
                        return t.preventDefault(), t.stopPropagation(), "function" == typeof e && e.call(s[0], d.isTruncated), d.isTruncated
                    }).bind("originalContent.dot", function(t, e) {
                        return t.preventDefault(), t.stopPropagation(), "function" == typeof e && e.call(s[0], a), a
                    }).bind("destroy.dot", function(t) {
                        t.preventDefault(), t.stopPropagation(), s.unwatch().unbind_events().contents().detach().end().append(a).attr("style", s.data("dotdotdot-style") || "").removeClass("is-truncated").data("dotdotdot", !1)
                    }), s
                }, s.unbind_events = function() {
                    return s.unbind(".dot"), s
                }, s.watch = function() {
                    if (s.unwatch(), "window" == l.watch) {
                        var e = t(window),
                            i = e.width(),
                            n = e.height();
                        e.bind("resize.dot" + d.dotId, function() {
                            i == e.width() && n == e.height() && l.windowResizeFix || (i = e.width(), n = e.height(), h && clearInterval(h), h = setTimeout(function() {
                                s.trigger("update.dot")
                            }, 100))
                        })
                    } else f = o(s), h = setInterval(function() {
                        if (s.is(":visible")) {
                            var t = o(s);
                            f.width == t.width && f.height == t.height || (s.trigger("update.dot"), f = t)
                        }
                    }, 500);
                    return s
                }, s.unwatch = function() {
                    return t(window).unbind("resize.dot" + d.dotId), h && clearInterval(h), s
                };
                var l = t.extend(!0, {}, t.fn.dotdotdot.defaults, e),
                    d = {},
                    f = {},
                    h = null,
                    m = null;
                return l.lastCharacter.remove instanceof Array || (l.lastCharacter.remove = t.fn.dotdotdot.defaultArrays.lastCharacter.remove), l.lastCharacter.noEllipsis instanceof Array || (l.lastCharacter.noEllipsis = t.fn.dotdotdot.defaultArrays.lastCharacter.noEllipsis), d.afterElement = c(l.after, s), d.isTruncated = !1, d.dotId = u++, s.data("dotdotdot", !0).bind_events().trigger("update.dot"), l.watch && s.watch(), s
            }, t.fn.dotdotdot.defaults = {
                ellipsis: "... ",
                wrap: "word",
                fallbackToLetter: !0,
                lastCharacter: {},
                tolerance: 0,
                callback: null,
                after: null,
                height: null,
                watch: !1,
                windowResizeFix: !0
            }, t.fn.dotdotdot.defaultArrays = {
                lastCharacter: {
                    remove: [" ", "　", ",", ";", ".", "!", "?"],
                    noEllipsis: []
                }
            }, t.fn.dotdotdot.debug = function(t) {};
            var u = 1,
                m = t.fn.html;
            t.fn.html = function(i) {
                return i != e && !t.isFunction(i) && this.data("dotdotdot") ? this.trigger("update", [i]) : m.apply(this, arguments)
            };
            var g = t.fn.text;
            t.fn.text = function(i) {
                return i != e && !t.isFunction(i) && this.data("dotdotdot") ? (i = t("<div />").text(i).html(), this.trigger("update", [i])) : g.apply(this, arguments)
            }
        }
    }(jQuery), jQuery(document).ready(function(t) {
    t(".dot-ellipsis").each(function() {
        var e = t(this).hasClass("dot-resize-update"),
            i = t(this).hasClass("dot-timer-update"),
            n = 0,
            s = t(this).attr("class").split(/\s+/);
        t.each(s, function(t, e) {
            var i = e.match(/^dot-height-(\d+)$/);
            null !== i && (n = Number(i[1]))
        });
        var r = new Object;
        i && (r.watch = !0), e && (r.watch = "window"), n > 0 && (r.height = n), t(this).dotdotdot(r)
    })
}), jQuery(window).on("load", function() {
    jQuery(".dot-ellipsis.dot-load-update").trigger("update.dot")
}),
    function(t) {
        window.ShuffleCustom = t(window.jQuery, window.CustomModernizr)
    }(function(t, e, i) {
        "use strict";

        function n(t, e, i) {
            for (var n = 0, s = t.length; s > n; n++)
                if (e.call(i, t[n], n, t) === {}) return
        }

        function s(e, i, n) {
            return setTimeout(t.proxy(e, i), n)
        }

        function r(t) {
            return Math.max.apply(Math, t)
        }

        function a(t) {
            return Math.min.apply(Math, t)
        }

        function o(e) {
            return t.isNumeric(e) ? e : 0
        }

        function l(t) {
            var e, i, n = t.length;
            if (!n) return t;
            for (; --n;) e = t[i = Math.floor(Math.random() * (n + 1))], t[i] = t[n], t[n] = e;
            return t
        }
        if ("object" != typeof e) throw new Error("Shuffle.js requires Modernizr.\nhttp://vestride.github.io/Shuffle/#dependencies");
        var d = e.prefixed("transition"),
            f = e.prefixed("transitionDelay"),
            h = e.prefixed("transitionDuration"),
            c = {
                WebkitTransition: "webkitTransitionEnd",
                transition: "transitionend"
            }[d],
            p = e.prefixed("transform"),
            u = function(t) {
                return t ? t.replace(/([A-Z])/g, function(t, e) {
                    return "-" + e.toLowerCase()
                }).replace(/^ms-/, "-ms-") : ""
            }(p),
            m = e.csstransforms && e.csstransitions,
            g = e.csstransforms3d,
            v = function(t, e) {
                this.x = o(t), this.y = o(e)
            };
        v.equals = function(t, e) {
            return t.x === e.x && t.y === e.y
        };
        var y = 0,
            w = t(window),
            x = 0,
            b = function(e, i, n) {
                i = i || {}, t.extend(this, b.options, i, b.settings), this.$el = t(e), this.id = x++, this.element = e, this.only_sort = n, this.unique = "shuffle_" + y++, this._fire(b.EventType.LOADING), this._init(), s(function() {
                    this.initialized = !0, this._fire(b.EventType.DONE)
                }, this, 16)
            };
        return b.EventType = {
            LOADING: "loading",
            DONE: "done",
            LAYOUT: "layout",
            REMOVED: "removed"
        }, b.ClassName = {
            BASE: "shuffle",
            SHUFFLE_ITEM: "shuffle-item",
            FILTERED: "filtered",
            CONCEALED: "concealed"
        }, b.options = {
            group: "all",
            speed: 250,
            easing: "ease-out",
            itemSelector: "",
            sizer: null,
            gutterWidth: 0,
            columnWidth: 0,
            delimeter: null,
            buffer: 0,
            initialSort: null,
            throttle: function(e, i, n) {
                var s, r, a, o = null,
                    l = 0;
                n = n || {};
                var d = function() {
                    l = !1 === n.leading ? 0 : t.now(), o = null, a = e.apply(s, r), s = r = null
                };
                return function() {
                    var f = t.now();
                    l || !1 !== n.leading || (l = f);
                    var h = i - (f - l);
                    return s = this, r = arguments, 0 >= h || h > i ? (clearTimeout(o), o = null, l = f, a = e.apply(s, r), s = r = null) : o || !1 === n.trailing || (o = setTimeout(d, h)), a
                }
            },
            throttleTime: 100,
            sequentialFadeDelay: 150,
            supported: m
        }, b.settings = {
            useSizer: !1,
            itemCss: {
                position: "absolute",
                top: 0,
                left: 0,
                visibility: "visible"
            },
            revealAppendedDelay: 300,
            lastSort: {},
            lastFilter: "all",
            enabled: !0,
            destroyed: !1,
            initialized: !1,
            _animations: [],
            styleQueue: []
        }, b.Point = v, b._getItemTransformString = function(t, e) {
            return g ? "translate3d(" + t.x + "px, " + t.y + "px, 0) scale3d(" + e + ", " + e + ", 1)" : "translate(" + t.x + "px, " + t.y + "px) scale(" + e + ")"
        }, b._getNumberStyle = function(e, i) {
            return b._getFloat(t(e).css(i))
        }, b._getInt = function(t) {
            return o(parseInt(t, 10))
        }, b._getFloat = function(t) {
            return o(parseFloat(t))
        }, b._getOuterWidth = function(e, i) {
            return t(e).outerWidth(!!i)
        }, b._getOuterHeight = function(e, i) {
            return t(e).outerHeight(!!i)
        }, b._skipTransition = function(t, e, i) {
            var n = t.style[h];
            t.style[h] = "0ms", e.call(i), t.offsetWidth, t.style[h] = n
        }, b.prototype._init = function() {
            if (this.$items = this._getItems(), !this.only_sort) {
                this.sizer = this._getElementOption(this.sizer), this.sizer && (this.useSizer = !0), this.$el.addClass(b.ClassName.BASE), this.containerWidth = b._getOuterWidth(this.element), this._itemMargin = this._getGutterSize(this.containerWidth), this._initItems(), w.on("resize.shuffle." + this.unique, this._getResizeFunction());
                var t = this.$el.css(["position", "overflow"]),
                    e = b._getOuterWidth(this.element);
                this._validateStyles(t), this._setColumns(e)
            }
            this.shuffle(this.group, this.initialSort), this.supported && s(function() {
                this.destroyed || (this._setTransitions(), this.element.style[d] = "height " + this.speed + "ms " + this.easing)
            }, this)
        }, b.prototype._getResizeFunction = function() {
            var e = t.proxy(this._onResize, this);
            return this.throttle ? this.throttle(e, this.throttleTime) : e
        }, b.prototype._getElementOption = function(t) {
            return "string" == typeof t ? this.$el.find(t)[0] || null : t && t.nodeType && 1 === t.nodeType ? t : t && t.jquery ? t[0] : null
        }, b.prototype._validateStyles = function(t) {
            "static" === t.position && (this.element.style.position = "relative"), t.overflow
        }, b.prototype._filter = function(t, e) {
            t = t || this.lastFilter, e = e || this.$items;
            var i = this._getFilteredSets(t, e);
            return this._toggleFilterClasses(i.filtered, i.concealed), this.lastFilter = t, "string" == typeof t && (this.group = t), i.filtered
        }, b.prototype._getFilteredSets = function(e, i) {
            var s = t(),
                r = t();
            return "all" === e ? s = i : n(i, function(i) {
                var n = t(i);
                this._doesPassFilter(e, n) || n.is(".ff-ad") ? s = s.add(n) : r = r.add(n)
            }, this), {
                filtered: s,
                concealed: r
            }
        }, b.prototype._doesPassFilter = function(e, i) {
            if (t.isFunction(e)) return e.call(i[0], i, this);
            var n = i.data("groups"),
                s = this.delimeter && !t.isArray(n) ? n.split(this.delimeter) : n;
            return t.inArray(e, s) > -1
        }, b.prototype._toggleFilterClasses = function(t, e) {
            t.removeClass(b.ClassName.CONCEALED).addClass(b.ClassName.FILTERED), e.removeClass(b.ClassName.FILTERED).addClass(b.ClassName.CONCEALED)
        }, b.prototype._initItems = function(e, i) {
            var n = this;
            e = e || this.$items;
            var s, r, a, o, l = this.columnWidth(this.containerWidth, this._itemMargin),
                d = this.streamOpts.layout;
            this.itemCss.width = l, this.gridLayout = d, i || (e.addClass([b.ClassName.SHUFFLE_ITEM, b.ClassName.FILTERED].join(" ")), e.css(this.itemCss).data("point", new v).data("scale", 1)), "grid" === d ? (s = this.streamOpts["g-ratio-h"] * l / this.streamOpts["g-ratio-w"], s = Math.floor(s), r = Math.floor(s * this._altEval(this.streamOpts["g-ratio-img"])), o = e.first(), a = o.find(".ff-item-meta").height(), this._addStyleSheet(".ff-layout-grid .ff-item-cont { height: " + (s - 44) + "px; /*overflow:hidden*/} .ff-layout-grid .ff-ad .ff-item-cont { height: " + s + "px; overflow:hidden} .ff-layout-grid .ff-has-overlay .ff-item-cont { height: " + s + "px; /*overflow:hidden*/} .ff-layout-grid .ff-item .ff-img-holder{height: " + r + "px}.ff-layout-grid .ff-has-overlay .ff-img-holder{height: " + s + "px}", "ff-grid-css")) : this.streamOpts.isOverlay && (o = e.first(), a = o.find(".ff-item-meta").height()), e.each(function(e) {
                var o, f, h, c, p, u, m, g, v, y, w, x, b, _ = t(this),
                    I = _.data(),
                    C = I.media && I.media.split(";"),
                    T = _.find(".ff-img-holder img"),
                    S = {},
                    k = n.streamOpts.isOverlay && T.length;
                C && (f = (o = {
                    width: C[4] || C[0],
                    height: C[5] || C[1]
                }).width && o.height ? n._calcImageProportion(l, o, d) : 0, T.css("minHeight", f)), ("grid" === d || k) && (v = _.find(k ? ".ff-overlay-wrapper" : ".ff-item-cont"), m = _.find(".ff-content"), g = v.find("> h4"), y = v.children(), k && (y = y.not(".ff-overlay")), "label1" === n.streamOpts["icon-style"] && _.is(".ff-meta-first") || (y = y.not(".ff-label-wrapper")), x = parseInt(y.first().css("marginTop")), b = parseInt(y.last().css("marginBottom")), u = .07 * l, w = (y.length - 1) * u + x + b, p = g.length ? g.height() : 0, (h = (s || f || T.height()) - ("ad" === _.data("type") ? 0 : (T.length && !k ? r : 0) + p + a + 44) - w) < 21 && (h = h >= 20 ? 20 : p ? 0 : 0 > h ? 21 + h - u : h), S = {
                    height: h
                }, m.css(S), 0 !== S.height && m.length || (c = s - (T.length && !k ? r : 0) - a - 44 - w, S = {}, (c = Math.floor(c)) <= 21 && (c >= 20 ? (g.addClass("ff-header-min"), c = 21) : (c = 0 > c ? 21 + c - u : c, S.textIndent = "-9999px")), S.height = c, 0 >= c && g.detach(), g.css(S)), i && _.find(".ff-content").dotdotdot({
                    ellipsis: "...",
                    after: ""
                }))
            })
        }, b.prototype._calcImageProportion = function(t, e, i) {
            var n = t / e.width;
            return Math.round(e.height * n)
        }, b.prototype._addCSSRule = function(t, e, i) {
            if (t && t.cssRules) {
                for (var n = t.cssRules.length - 1, s = n; s > 0; s--) {
                    var r = t.cssRules[s];
                    r.selectorText === e && (i = r.style.cssText + i, t.deleteRule(s), n = s)
                }
                return t.insertRule ? t.insertRule(e + "{" + i + "}", n) : t.addRule(e, i, n), t.cssRules[n].cssText
            }
        }, b.prototype._altEval = function(t) {
            return new Function("return " + t)()
        }, b.prototype._addStyleSheet = function(t, e) {
            var i = document.createElement("style");
            return i.type = "text/css", e && (i.id = e), /WebKit|MSIE/i.test(navigator.userAgent) ? i.styleSheet ? i.styleSheet.cssText = t : i.innerText = t : i.innerHTML = t, document.getElementsByTagName("head")[0].appendChild(i), i
        }, b.prototype._updateItemCount = function() {
            this.visibleItems = this._getFilteredItems().length
        }, b.prototype._setTransition = function(t) {
            t.style[d] = u + " " + this.speed + "ms " + this.easing + ", opacity " + this.speed + "ms " + this.easing
        }, b.prototype._setTransitions = function(t) {
            n(t = t || this.$items, function(t) {
                this._setTransition(t)
            }, this)
        }, b.prototype._setSequentialDelay = function(t) {
            this.supported && n(t, function(t, e) {
                t.style[f] = "0ms," + (e + 1) * this.sequentialFadeDelay + "ms"
            }, this)
        }, b.prototype._getItems = function() {
            return this.$el.children(this.itemSelector)
        }, b.prototype._getFilteredItems = function() {
            return this.destroyed ? t() : this.$items.filter("." + b.ClassName.FILTERED)
        }, b.prototype._getConcealedItems = function() {
            return this.$items.filter("." + b.ClassName.CONCEALED)
        }, b.prototype._getColumnSize = function(e, i) {
            var n;
            return 0 === (n = t.isFunction(this.columnWidth) ? this.columnWidth(e, i) : this.useSizer ? b._getOuterWidth(this.sizer) : this.columnWidth ? this.columnWidth : this.$items.length > 0 ? b._getOuterWidth(this.$items[0], !0) : e) && (n = e), n + i
        }, b.prototype._getGutterSize = function(e) {
            return t.isFunction(this.gutterWidth) ? this.gutterWidth(e) : this.useSizer ? b._getNumberStyle(this.sizer, "marginLeft") : this.gutterWidth
        }, b.prototype._setColumns = function(t) {
            var e = t || b._getOuterWidth(this.element),
                i = this._itemMargin = this._getGutterSize(e),
                n = this._getColumnSize(e, i);
            this.containerWidth = e;
            var s = ((e -= 2 * i) + i) / n;
            this.cols = Math.max(Math.floor(s), 1), this.colWidth = n
        }, b.prototype._setContainerSize = function() {
            this.$el.css("height", this._getContainerSize())
        }, b.prototype._getContainerSize = function() {
            return r(this.positions)
        }, b.prototype._fire = function(t, e) {
            this.$el.trigger(t + ".shuffle", e && e.length ? e : [this])
        }, b.prototype._resetCols = function() {
            var t = this.cols;
            for (this.positions = []; t--;) this.positions.push(0)
        }, b.prototype._layout = function(t, e) {
            var i = this;
            n(t, function(t) {
                i._layoutItem(t, !!e)
            }, i), i._processStyleQueue(), i._setContainerSize()
        }, b.prototype._layoutItem = function(e, i) {
            var n = t(e),
                s = n.data(),
                r = (s.point, s.scale, {
                    width: b._getOuterWidth(e, !0),
                    height: b._getOuterHeight(e, !0)
                }),
                a = this._getItemPosition(r);
            s.point = a, s.scale = 1, this.styleQueue.push({
                $item: n,
                point: a,
                scale: 1,
                width: this.itemCss.width,
                opacity: i ? 0 : 1,
                skipTransition: i,
                callfront: function() {
                    i || n.css("visibility", "visible")
                },
                callback: function() {
                    i && n.css("visibility", "hidden")
                }
            })
        }, b.prototype._getItemPosition = function(t, e) {
            var i = this._getColumnSpan(t.width, this.colWidth, this.cols),
                n = this._getColumnSet(i, this.cols),
                s = this._getShortColumn(n, this.buffer),
                r = Math.round((this.containerWidth - (t.width * this.cols + this._itemMargin * (this.cols - 1))) / 2),
                a = new v(Math.round(this.colWidth * s + (r > 0 ? r : 0)), Math.round(n[s]));
            0 != a.y && (a.y = a.y + this._itemMargin);
            for (var o = n[s] + t.height + (0 != a.y ? this._itemMargin : 0), l = this.cols + 1 - n.length, d = 0; l > d; d++) this.positions[s + d] = o;
            return a
        }, b.prototype._getColumnSpan = function(t, e, i) {
            var n = t / e;
            return Math.abs(Math.round(n) - n) < .3 && (n = Math.round(n)), Math.min(Math.ceil(n), i)
        }, b.prototype._getColumnSet = function(t, e) {
            if (1 === t) return this.positions;
            for (var i = e + 1 - t, n = [], s = 0; i > s; s++) n[s] = r(this.positions.slice(s, s + t));
            return n
        }, b.prototype._getShortColumn = function(t, e) {
            for (var i = a(t), n = 0, s = t.length; s > n; n++)
                if (t[n] >= i - e && t[n] <= i + e) return n;
            return 0
        }, b.prototype._shrink = function(e) {
            n(e || this._getConcealedItems(), function(e) {
                var i = t(e),
                    n = i.data();
                .001 !== n.scale && (n.scale = .001, this.styleQueue.push({
                    $item: i,
                    point: n.point,
                    scale: .001,
                    opacity: 0,
                    callback: function() {
                        i.css("visibility", "hidden")
                    }
                }))
            }, this)
        }, b.prototype._onResize = function() {
            if (this.enabled && !this.destroyed && !this.isTransitioning) {
                var t = b._getOuterWidth(this.element);
                if (t !== this.containerWidth) {
                    if (this.containerWidth = t, this._itemMargin = this._getGutterSize(this.containerWidth), "grid" === this.gridLayout) {
                        var e = document.getElementById("ff-grid-css");
                        e.parentNode.removeChild(e)
                    }
                    this._initItems(this.$items, !0), this.update()
                }
            }
        }, b.prototype._getStylesForTransition = function(t, e) {
            var i = {
                opacity: t.opacity
            };
            return t.width && (i.width = t.width), this.supported ? i[p] = b._getItemTransformString(t.point, t.scale) : (i.left = t.point.x, i.top = t.point.y), i
        }, b.prototype._transition = function(e) {
            var i = this._getStylesForTransition(e);
            e.$item.data("keep-pos") ? (e.$item.removeData("keep-pos"), s(function() {
                this._startItemAnimation(e.$item, i, e.callfront || t.noop, e.callback || t.noop)
            }, this, 1e3)) : this._startItemAnimation(e.$item, i, e.callfront || t.noop, e.callback || t.noop)
        }, b.prototype._startItemAnimation = function(e, i, n, s) {
            function r(e) {
                e.target === e.currentTarget && (t(e.target).off(c, r), s())
            }
            if (n(), !this.initialized) return e.css(i), void s();
            if (this.supported) e.css(i), e.on(c, r);
            else {
                var a = e.stop(!0).animate(i, this.speed, "swing", s);
                this._animations.push(a.promise())
            }
        }, b.prototype._processStyleQueue = function(e) {
            var i = t();
            n(this.styleQueue, function(t) {
                t.skipTransition ? this._styleImmediately(t) : (i = i.add(t.$item), this._transition(t))
            }, this), i.length > 0 && this.initialized ? (this.isTransitioning = !0, this.supported ? (this._whenCollectionDone(i, c, this._movementFinished), this.isTransitioning = !1) : (this._whenAnimationsDone(this._movementFinished), this.isTransitioning = !1)) : e || s(this._layoutEnd, this), this.styleQueue.length = 0
        }, b.prototype._styleImmediately = function(t) {
            b._skipTransition(t.$item[0], function() {
                t.$item.css(this._getStylesForTransition(t))
            }, this)
        }, b.prototype._movementFinished = function() {
            this._layoutEnd()
        }, b.prototype._layoutEnd = function() {
            this.destroyed || this._fire(b.EventType.LAYOUT)
        }, b.prototype._addItems = function(t, e, i) {
            this._initItems(t), this._setTransitions(t), this.$items = this._getItems(), this._shrink(t), n(this.styleQueue, function(t) {
                t.skipTransition = !0
            }), this._processStyleQueue(!0), e ? this._addItemsToEnd(t, i) : this.shuffle(this.lastFilter)
        }, b.prototype._addItemsToEnd = function(t, e) {
            var i = this._filter(null, t).get();
            this._updateItemCount(), this._layout(i, !0), e && this.supported && this._setSequentialDelay(i), this._revealAppended(i)
        }, b.prototype._revealAppended = function(e) {
            s(function() {
                n(e, function(e) {
                    var i = t(e);
                    this._transition({
                        $item: i,
                        opacity: 1,
                        point: i.data("point"),
                        scale: 1
                    })
                }, this), this._whenCollectionDone(t(e), c, function() {
                    t(e).css(f, "0ms"), this._movementFinished()
                })
            }, this, this.revealAppendedDelay)
        }, b.prototype._whenCollectionDone = function(e, i, n) {
            function s(e) {
                e.target === e.currentTarget && (t(e.target).off(i, s), ++r === a && n.call(o))
            }
            var r = 0,
                a = e.length,
                o = this;
            e.on(i, s)
        }, b.prototype._whenAnimationsDone = function(e) {
            t.when.apply(null, this._animations).always(t.proxy(function() {
                this._animations.length = 0, e.call(this)
            }, this))
        }, b.prototype.shuffle = function(t, e) {
            this.enabled && !this.isTransitioning && (t || (t = "all"), this._filter(t), this._updateItemCount(), this._shrink(), this.sort(e))
        }, b.prototype.sort = function(t) {
            if (this.enabled && !this.isTransitioning) {
                this._resetCols();
                var e = t || this.lastSort,
                    i = this._getFilteredItems().sorted(e);
                this._layout(i), this.lastSort = e
            }
        }, b.prototype.update = function(e) {
            var i = this;
            this.enabled && !this.isTransitioning && (e || (this._setColumns(), this.$items.css("width", this.colWidth - this._itemMargin), this.$items.each(function(e, n) {
                var s = t(this),
                    r = s.data(),
                    a = r.media && r.media.split(";");
                if (a) {
                    var o = {
                            width: a[4],
                            height: a[5]
                        },
                        l = i._calcImageProportion(i.colWidth - i._itemMargin, o);
                    s.find(".ff-img-holder img").css("minHeight", l)
                }
            }), this.itemCss.width = this.colWidth - this._itemMargin), i.sort())
        }, b.prototype.layout = function() {
            this.destroyed || this.update(!0)
        }, b.prototype.appended = function(t, e, i) {
            this._addItems(t, !0, !0)
        }, b.prototype.disable = function() {
            this.enabled = !1
        }, b.prototype.enable = function(t) {
            this.enabled = !0, !1 !== t && this.update()
        }, b.prototype.remove = function(e) {
            e.length && e.jquery && (this._toggleFilterClasses(t(), e), this._shrink(e), this.sort(), this.$el.one(b.EventType.LAYOUT + ".shuffle", t.proxy(function() {
                e.remove(), this.$items = this._getItems(), this._updateItemCount(), this._fire(b.EventType.REMOVED, [e, this]), e = null
            }, this)))
        }, b.prototype.destroy = function() {
            w.off("." + this.unique), this.$el.removeClass("shuffle").removeAttr("style").removeData("shuffle"), this.$items.removeAttr("style").removeData("point").removeData("scale").removeClass([b.ClassName.CONCEALED, b.ClassName.FILTERED, b.ClassName.SHUFFLE_ITEM].join(" ")), this.$items = null, this.$el = null, this.sizer = null, this.element = null, this.destroyed = !0
        }, t.fn.shuffleCustom = function(e) {
            var i = Array.prototype.slice.call(arguments, 1);
            return this.each(function() {
                var n = t(this),
                    s = n.data("shuffle");
                s ? "string" == typeof e && s[e] && s[e].apply(s, i) : (s = new b(this, e, "only_sort" === i[1]), n.data("shuffle", s))
            })
        }, t.fn.sorted = function(e) {
            var n = t.extend({}, t.fn.sorted.defaults, e),
                s = this.get(),
                r = !1;
            return s.length ? n.randomize ? l(s) : (t.isFunction(n.by) && s.sort(function(e, s) {
                if (r) return 0;
                var a = n.by(t(e)),
                    o = n.by(t(s));
                return a === i && o === i ? (r = !0, 0) : o > a || "sortFirst" === a || "sortLast" === o ? -1 : a > o || "sortLast" === a || "sortFirst" === o ? 1 : 0
            }), r ? this.get() : (n.reverse && s.reverse(), s)) : []
        }, t.fn.sorted.defaults = {
            reverse: !1,
            by: null,
            randomize: !1
        }, b
    }),
    function(t, e) {
        var i, n = t.jQuery || t.Cowboy || (t.Cowboy = {});
        n.throttle = i = function(t, i, s, r) {
            function a() {
                function n() {
                    l = +new Date, s.apply(a, f)
                }
                var a = this,
                    d = +new Date - l,
                    f = arguments;
                r && !o && n(), o && clearTimeout(o), r === e && d > t ? n() : !0 !== i && (o = setTimeout(r ? function() {
                    o = e
                } : n, r === e ? t - d : t))
            }
            var o, l = 0;
            return "boolean" != typeof i && (r = s, s = i, i = e), n.guid && (a.guid = s.guid = s.guid || n.guid++), a
        }, n.debounce = function(t, n, s) {
            return s === e ? i(t, n, !1) : i(t, s, !1 !== n)
        }
    }(this),
    function(t) {
        "use strict";
        var e = null,
            i = t(window),
            n = function(e) {
                var i = this;
                if (t.extend(i, n.options, e, n.settings), !t.isFunction(i.enter)) throw new TypeError("Viewport.add :: No `enter` function provided in Viewport options.");
                "string" == typeof i.threshold && i.threshold.indexOf("%") > -1 ? (i.isThresholdPercentage = !0, i.threshold = parseFloat(i.threshold) / 100) : i.threshold < 1 && i.threshold > 0 && (i.isThresholdPercentage = !0), i.hasLeaveCallback = t.isFunction(i.leave), i.$element = t(i.element), i.update()
            };
        n.prototype.update = function() {
            var t = this;
            t.offset = t.$element.offset(), t.height = t.$element.height(), t.$element.data("height", t.height), t.width = t.$element.width(), t.$element.data("width", t.width)
        }, n.options = {
            threshold: 200,
            delay: 0
        }, n.settings = {
            triggered: !1,
            isThresholdPercentage: !1
        };
        var s = function() {
            this.init()
        };
        s.prototype = {
            init: function() {
                var t = this;
                t.list = [], t.lastScrollY = 0, t.windowHeight = i.height(), t.windowWidth = i.width(), t.screenSize = {
                    w: t.windowWidth,
                    h: t.windowHeight
                }, t.throttleTime = 100, t.onResize(), t.bindEvents(),
                    t.willProcessNextFrame = !0, requestAnimationFrame(function() {
                    t.setScrollTop(), t.process(), t.willProcessNextFrame = !1
                })
            },
            bindEvents: function() {
                var e = this;
                i.on("resize.viewport", t.proxy(e.onResize, e)), i.on("scroll.viewport", t.throttle(e.throttleTime, t.proxy(e.onScroll, e))), e.hasActiveHandlers = !0
            },
            unbindEvents: function() {
                i.off(".viewport"), this.hasActiveHandlers = !1
            },
            maybeUnbindEvents: function() {
                var t = this;
                t.list.length || t.unbindEvents()
            },
            add: function(t) {
                var e = this;
                e.list.push(t), e.hasActiveHandlers || e.bindEvents(), e.willProcessNextFrame || (e.willProcessNextFrame = !0, requestAnimationFrame(function() {
                    e.willProcessNextFrame = !1, e.process()
                }))
            },
            saveDimensions: function() {
                var e = this;
                t.each(e.list, function(t, e) {
                    e.update()
                }), e.windowHeight = i.height(), e.windowWidth = i.width(), e.screenSize = {
                    w: e.windowWidth,
                    h: e.windowHeight
                }
            },
            onScroll: function() {
                var t = this;
                t.list.length && (t.setScrollTop(), t.process())
            },
            onResize: function() {
                this.refresh()
            },
            refresh: function() {
                this.list.length && this.saveDimensions()
            },
            isInViewport: function(t) {
                var e, i = this,
                    n = t.offset,
                    s = t.threshold,
                    r = s,
                    a = i.lastScrollY;
                return t.isThresholdPercentage && (s = 0), (e = i.isTopInView(a, i.windowHeight, n.top, t.height, s)) && t.isThresholdPercentage && (e = i.isTopPastPercent(a, i.windowHeight, n.top, t.height, r)), e
            },
            isTopInView: function(t, e, i, n, s) {
                var r = t + e;
                return i + s >= t && r > i + s
            },
            isTopPastPercent: function(t, e, i, n, s) {
                return (t + e - i) / e >= s
            },
            isOutOfViewport: function(t, e) {
                var i, n = this,
                    s = t.offset,
                    r = n.lastScrollY;
                return "bottom" === e && (i = !n.isBottomInView(r, n.windowHeight, s.top, t.height)), i
            },
            isBottomInView: function(t, e, i, n) {
                var s = t + e,
                    r = i + n;
                return r > t && s >= r
            },
            triggerEnter: function(e) {
                var i = this;
                setTimeout(function() {
                    e.enter.call(e.element, e)
                }, e.delay), t.isFunction(e.leave) ? e.triggered = !0 : i.list.splice(t.inArray(e, i.list), 1), i.maybeUnbindEvents()
            },
            getScreenSize: function() {
                return this.screenSize
            },
            triggerLeave: function(t) {
                setTimeout(function() {
                    t.leave.call(t.element, t)
                }, t.delay), t.triggered = !1
            },
            setScrollTop: function() {
                this.lastScrollY = i.scrollTop()
            },
            process: function() {
                var e = this,
                    i = t.extend([], e.list);
                t.each(i, function(t, i) {
                    var n = e.isInViewport(i),
                        s = i.hasLeaveCallback && e.isOutOfViewport(i, "bottom");
                    return !i.triggered && n ? e.triggerEnter(i) : !n && s && i.triggered ? e.triggerLeave(i) : void 0
                })
            }
        }, s.add = function(t) {
            return s.getInstance().add(new n(t))
        }, s.refresh = function() {
            s.getInstance().refresh()
        }, s.getInstance = function() {
            return e || (e = new s), e
        }, window.FF_Viewport = s
    }(jQuery),
    function(t, e, i) {
        "use strict";

        function n(t, e) {
            t.style.WebkitTransform = e, t.style.msTransform = e, t.style.transform = e
        }

        function s() {
            var e = l.clientWidth,
                i = t.innerWidth;
            return i > e ? i : e
        }

        function r() {
            var e = l.clientHeight,
                i = t.innerHeight;
            return i > e ? i : e
        }

        function a(t, e) {
            for (var i in e) e.hasOwnProperty(i) && (t[i] = e[i]);
            return t
        }

        function o(t, e) {
            return this.el = t[0], this.$el = t, this.options = a({}, this.options), a(this.options, e), this._init()
        }
        var l = t.document.documentElement,
            d = {
                WebkitTransition: "webkitTransitionEnd",
                MozTransition: "transitionend",
                OTransition: "oTransitionEnd",
                msTransition: "MSTransitionEnd",
                transition: "transitionend"
            }[e.prefixed("transition")],
            f = {
                transitions: e.csstransitions,
                support3d: e.csstransforms3d
            };
        o.prototype.options = {}, o.prototype._init = function() {
            return this.$body = i("body"), this.grid = this.el.querySelector(".ff-stream-wrapper"), this.gridItems = [].slice.call(this.grid.querySelectorAll(".ff-item")), this.itemsCount = this.gridItems.length, this.$wrapper = this.$el.find(".ff-slideshow"), this.slideshow = this.el.querySelector(".ff-slideshow > ul"), this.$slideshow = i(this.slideshow), this.$slideshow.data("media", !1), this.$wrapper.addClass("ff-" + this.options.iconStyle + "-icon"), this._addSlideShowItems(this.gridItems), this.slideshowItems = [].slice.call(this.slideshow.children), this.current = -1, this.ctrlPrev = this.el.querySelector(".ff-nav-prev"), this.ctrlNext = this.el.querySelector(".ff-nav-next"), this.ctrlClose = this.el.querySelector(".ff-nav-close"), this._initEvents(), this
        }, o.prototype._addSlideShowItems = function(e) {
            var n = this;
            e.forEach(function(e, s) {
                var r, a, o, l, d, f = i(e),
                    h = i('<li><div class="ff-slide-wrapper"></div></li>'),
                    c = h.find(".ff-slide-wrapper"),
                    p = f.find(".picture-item__inner").children().clone(),
                    u = f.attr("data-type"),
                    m = "",
                    g = !1;
                f.attr("data-media") ? (n.$slideshow.data("media", !0), o = f.attr("data-media").split(";"), r = i('<div class="ff-media-wrapper' + ("image" == o[3] ? "" : " ff-video") + '" style="width: 100%; max-height: ' + o[1] + 'px;"></div>'), c.prepend(r), "image" == o[3] ? (l = (d = parseInt(o[0])) > 590 ? 590 / d * parseInt(o[1]) : o[1], m = '<span class="ff-img-holder" style="width: ' + o[0] + "px; max-height: " + o[1] + "px; height: " + l + "px; background-image: url(" + o[2] + ');"></span>', r.addClass("ff-slide-img-loading").data("media-image", o[2])) : "video/mp4" == o[3] ? m = '<video controls width="' + o[0] + '" height="' + o[1] + '"><source src="' + o[2] + '" type="video/mp4">Your browser does not support the video tag.</video>' : (o[2] = o[2].replace("http:", "").replace("https:", "").replace("/v/", "/embed/").replace("autoplay=1", "autoplay=0&fs=1"), m = '<iframe width="' + o[0] + '" height="' + o[1] + '" src="' + o[2] + '" frameborder="0" allowfullscreen webkitallowfullscreen mozallowfullscreen autoplay="1" wmode="opaque"></iframe>', o[2].indexOf("facebook.com/video/embed") + 1 && r.after('<span class="ff-cta">(Click image to play video)</span>')), r.data("media", m), p.find(".ff-img-holder").remove()) : p.find(".ff-img-holder").length && p.find(".ff-img-holder").each(function(t, e) {
                    var n = i(this),
                        s = i(this).find("img"),
                        r = s.get(0);
                    g ? n.remove() : (n.removeClass("ff-img-loading").addClass("ff-img-loaded").css({
                        "background-image": 'url("' + r.src + '")',
                        width: parseInt(r.style.width),
                        height: parseInt(r.style.height)
                    }), s.remove(), g = !0)
                }), c.append(p.not(".ff-img-holder")), a = c.find(".ff-item-cont"), /posts/.test(u) && (u = "wordpress"), a.append(h.find("h4")), a.append(h.find(".ff-article")), a.append(h.find(".ff-content").prepend(h.find(".ff-img-holder"))), a.append(h.find(".ff-item-meta")), a.find(".ff-userpic").append(h.find(".ff-icon")), a.find(".ff-item-meta").prepend(a.find(".ff-userpic")).prepend(c.find(".ff-item-bar")), a.find(".ff-timestamp").before("<br>").before('<span class="ff-posted">' + t.FlowFlowOpts.posted_on + " <span>" + u + "</span></span>"), h.find(".ff-content").each(function() {
                    var t = i(this);
                    t.is(":empty") ? t.remove() : t.wrap('<div class="ff-table"/>')
                }), n.$slideshow.append(h.attr("data-type", f.attr("data-type")))
            }), n.$slideshow.data("media") && n.$slideshow.addClass("ff-slideshow-media")
        }, o.prototype._initEvents = function(e) {
            var n = this;
            this.initItemsEvents(this.gridItems), i(this.ctrlPrev).on("click", function() {
                n._navigate("prev")
            }), i(this.ctrlNext).on("click", function() {
                n._navigate("next")
            }), i(this.ctrlClose).on("click", function() {
                n._closeSlideshow()
            }), this.$wrapper.on("click", function(t) {
                i(t.target).closest("li, nav").length || n._closeSlideshow()
            }), i(t).on("resize", function() {
                n._resizeHandler()
            }), i(document).on("keydown", function(t) {
                if (n.isSlideshowVisible) switch (t.keyCode || t.which) {
                    case 37:
                        n._navigate("prev");
                        break;
                    case 39:
                        n._navigate("next");
                        break;
                    case 27:
                        n._closeSlideshow()
                }
            })
        }, o.prototype.initItemsEvents = function(t, e) {
            var n = this,
                s = i(this.grid).data("opts") && i(this.grid).data("opts").titles;
            e = e || 0, t.forEach(function(t, r) {
                i(t).find(".picture-item__inner").on("click", function(t) {
                    var a = i(t.target),
                        o = a.closest("a"),
                        l = a.closest("h4").length,
                        d = a.closest(".ff-icon-share").length;
                    if (o.length && !a.is("img") || d) {
                        if ("yep" === s && l) return;
                        if (!l) return
                    }
                    t.preventDefault(), n._openSlideshow(r + e)
                })
            })
        }, o.prototype._freezeScroll = function(t) {
            t.preventDefault()
        }, o.prototype.checkScrollbar = function() {
            this.bodyIsOverflowing = document.body.scrollHeight > document.documentElement.clientHeight, this.scrollbarWidth = this.measureScrollbar()
        }, o.prototype.setScrollbar = function() {
            var t = parseInt(this.$body.css("padding-right") || 0, 10);
            this.bodyIsOverflowing && this.$body.css("padding-right", t + this.scrollbarWidth)
        }, o.prototype.resetScrollbar = function() {
            this.$body.css("padding-right", "")
        }, o.prototype.measureScrollbar = function() {
            var t = document.createElement("div");
            t.className = "ff-modal-scrollbar-measure", this.$body.append(t);
            var e = t.offsetWidth - t.clientWidth;
            return this.$body[0].removeChild(t), e
        }, o.prototype._openSlideshow = function(t) {
            this.isSlideshowVisible = !0, this.current = t, this.checkScrollbar(), this.setScrollbar(), this.$body.addClass("ff-modal-open");
            var e = this;
            e._setViewportItems();
            var a = i(e.currentItem),
                o = i(e.nextItem),
                l = i(e.prevItem),
                d = s(),
                h = r();
            e.$curr = a, a.find(".ff-media-wrapper").each(function(t, e) {
                var n = i(this);
                if (n.data("media") && "inserted" !== n.data("media")) {
                    if (n.data("media-image")) {
                        var s = new Image;
                        s.src = n.data("media-image"), s.onload = function() {
                            n.removeClass("ff-slide-img-loading")
                        }
                    }
                    n.prepend(n.data("media")), n.data("media", "inserted")
                }
            }), o.add(l).find(".ff-media-wrapper").each(function(t, e) {
                var n = i(this),
                    s = n.data("media");
                if (s && "inserted" !== s && !/iframe|video/.test(s)) {
                    if (n.data("media-image")) {
                        var r = new Image;
                        r.src = n.data("media-image"), r.onload = function() {
                            n.removeClass("ff-slide-img-loading")
                        }
                    }
                    n.prepend(n.data("media")), n.data("media", "inserted")
                }
            }), a.addClass("ff-current ff-show");
            var c = parseInt(Number(e.currentItem.offsetHeight / 2 * 1));
            if (2 * c > h ? c = parseInt(h / 2) - 25 : e.$slideshow.bind("mousewheel DOMMouseScroll", e._freezeScroll), n(e.currentItem, f.support3d ? "translate3d(" + parseInt(Number(e.currentItem.offsetWidth / 2 * -1)) + "px, -" + c + "px, 0px)" : "translate(-50%, -50%)"), e.prevItem && (l.addClass("ff-show"), p = Number(-1 * (d / 2 + e.prevItem.offsetWidth / 2)), n(e.prevItem, f.support3d ? "translate3d(" + (p + 100) + "px, -50%, 0px)" : "translate(" + p + "px, -50%)")), e.nextItem) {
                o.addClass("ff-show");
                var p = Number(d / 2 + e.nextItem.offsetWidth / 2);
                n(e.nextItem, f.support3d ? "translate3d(" + (p - 100) + "px,-50%, 0px)" : "translate(" + p + "px, -50%)")
            }
            setTimeout(function() {
                if(e.$wrapper.find('.iframe-hide').length){
                    e.$wrapper.find('.iframe-hide').show();
                }
                if(e.$wrapper.find('.ifrmage-image-show').length){
                    e.$wrapper.find('.ifrmage-image-show').hide();
                }
                e.$wrapper.addClass("ff-slideshow-open").scrollTop(0)
            }, 200)
        }, o.prototype._navigate = function(t) {
            if (!this.isAnimating)
                if ("next" === t && this.current === this.itemsCount - 1 || "prev" === t && 0 === this.current) this._closeSlideshow();
                else {
                    this.isAnimating = !0, this._setViewportItems();
                    var e, a, o, l = this,
                        h = s(),
                        c = r(),
                        p = this.currentItem.offsetWidth,
                        u = f.support3d ? "translate3d(-" + Number(h / 2 + p / 2) + "px, -50%, -150px)" : "translate(-" + Number(h / 2 + p / 2) + "px, -50%)",
                        m = f.support3d ? "translate3d(" + Number(h / 2 + p / 2) + "px, -50%, -150px)" : "translate(" + Number(h / 2 + p / 2) + "px, -50%)";
                    "next" === t ? (e = f.support3d ? "translate3d( -" + Number(2 * h / 2 + p / 2) + "px, -50%, -150px )" : "translate(-" + Number(2 * h / 2 + p / 2) + "px, -50%)", a = f.support3d ? "translate3d( " + Number(2 * h / 2 + p / 2) + "px, -50%, -150px )" : "translate(" + Number(2 * h / 2 + p / 2) + "px, -50%)") : (e = f.support3d ? "translate3d( " + Number(2 * h / 2 + p / 2) + "px, -50%, -150px )" : "translate(" + Number(2 * h / 2 + p / 2) + "px)", a = f.support3d ? "translate3d( -" + Number(2 * h / 2 + p / 2) + "px, -50%, -150px )" : "translate(-" + Number(2 * h / 2 + p / 2) + "px, -50%)"), l.$slideshow.removeClass("ff-animatable"), ("next" === t && this.current < this.itemsCount - 2 || "prev" === t && this.current > 1) && (n(o = this.slideshowItems["next" === t ? this.current + 2 : this.current - 2], a), i(o).addClass("ff-show").find(".ff-media-wrapper").each(function(t, e) {
                        var n = i(this),
                            s = n.data("media");
                        if (s && "inserted" !== s && !/iframe|video/.test(s)) {
                            if (n.data("media-image")) {
                                var r = new Image;
                                r.src = n.data("media-image"), r.onload = function() {
                                    n.removeClass("ff-slide-img-loading")
                                }
                            }
                            n.prepend(n.data("media")), n.data("media", "inserted")
                        }
                    })), setTimeout(function() {
                        var s;
                        l.$slideshow.addClass("ff-animatable"), l.$curr.removeClass("ff-current");
                        var r = "next" === t ? l.nextItem : l.prevItem;
                        i(r).addClass("ff-current").find(".ff-media-wrapper").each(function(t, e) {
                            var n = i(this),
                                s = n.data("media");
                            if (s && "inserted" !== s) {
                                if (n.data("media-image")) {
                                    var r = new Image;
                                    r.src = n.data("media-image"), r.onload = function() {
                                        n.removeClass("ff-slide-img-loading")
                                    }
                                }
                                n.prepend(n.data("media")), n.data("media", "inserted")
                            }
                        }), n(l.currentItem, "next" === t ? u : m), l.nextItem && (2 * (s = parseInt(Number(l.nextItem.offsetHeight / 2 * 1))) > c ? (s = parseInt(c / 2) - 25, "next" === t && l.$slideshow.off("mousewheel DOMMouseScroll", l._freezeScroll)) : "next" === t && (l.$slideshow.on("mousewheel DOMMouseScroll", l._freezeScroll), l.$wrapper.scrollTop(0)), n(l.nextItem, "next" === t ? f.support3d ? "translate3d(" + parseInt(Number(l.nextItem.offsetWidth / 2 * -1)) + "px, -" + s + "px, 0px)" : "translate(-50%, -50%)" : e)), l.prevItem && (2 * (s = parseInt(Number(l.prevItem.offsetHeight / 2 * 1))) > c ? (s = parseInt(c / 2) - 25, "prev" === t && l.$slideshow.off("mousewheel DOMMouseScroll", l._freezeScroll).scrollTop(0)) : "prev" === t && (l.$slideshow.on("mousewheel DOMMouseScroll", l._freezeScroll), l.$wrapper.scrollTop(0)), n(l.prevItem, "next" === t ? e : f.support3d ? "translate3d(" + parseInt(Number(l.prevItem.offsetWidth / 2 * -1)) + "px, -" + s + "px, 0px)" : "translate(-50%, -50%)")), o && n(o, "next" === t ? m : u);
                        var a = function(e) {
                            if (f.transitions && h >= 800) {
                                if (-1 === e.originalEvent.propertyName.indexOf("transform")) return !1;
                                i(this).off(d, a)
                            }
                            l.prevItem && "next" === t ? i(l.prevItem).removeClass("ff-show") : l.nextItem && "prev" === t && i(l.nextItem).removeClass("ff-show"), l._resetMedia(i(l.currentItem)), "next" === t ? (l.prevItem = l.currentItem, l.currentItem = l.nextItem, o && (l.nextItem = o)) : (l.nextItem = l.currentItem, l.currentItem = l.prevItem, o && (l.prevItem = o)), l.$curr = i(l.currentItem), l.current = "next" === t ? l.current + 1 : l.current - 1, l.isAnimating = !1
                        };
                        f.transitions && h >= 800 ? l.$curr.on(d, a) : a()
                    }, 25)
                }
        }, o.prototype._closeSlideshow = function(t) {
            this.$wrapper.removeClass("ff-slideshow-open"), this.$slideshow.removeClass("ff-animatable").unbind("mousewheel DOMMouseScroll", this._freezeScroll), this.resetScrollbar(), this.$body.removeClass("ff-modal-open");
            var e = this,
                s = function(t) {
                    if (f.transitions && t) {
                        if ("section" !== t.target.tagName.toLowerCase()) return;
                        i(this).off(d, s)
                    }
                    var r = i(e.currentItem);
                    e.$curr = r, r.removeClass("ff-current"), r.removeClass("ff-show"), e._resetMedia(r), e.prevItem && i(e.prevItem).removeClass("ff-show"), e.nextItem && i(e.nextItem).removeClass("ff-show"), e.slideshowItems.forEach(function(t) {
                        n(t, "")
                    }), e.isSlideshowVisible = !1
                };
            f.transitions ? this.$wrapper.on(d, s) : s()
        }, o.prototype._resetMedia = function(t) {
            var e = t.attr("data-type");
            if ("vine" !== e && "soundcloud" !== e) {
                var i = t.find(".ff-video"),
                    n = i.find("iframe, video");
                i.prepend(n)
                // force pause video on slide hide
                if(i.find("video").length){
                    i.find("video")[0].pause();
                }
                t.find('iframe').each(function(){
                    this.contentWindow.postMessage('{"event":"command","func":"' + 'stopVideo' + '","args":""}', '*')
                });
            }
        }, o.prototype._setViewportItems = function() {
            this.currentItem = null, this.prevItem = null, this.nextItem = null, this.$curr = null, this.current > 0 && (this.prevItem = this.slideshowItems[this.current - 1]), this.current < this.itemsCount - 1 && (this.nextItem = this.slideshowItems[this.current + 1]), this.currentItem = this.slideshowItems[this.current], this.$curr = i(this.currentItem)
        }, o.prototype._resizeHandler = function() {
            var t = this;
            this._resizeTimeout && clearTimeout(this._resizeTimeout), this._resizeTimeout = setTimeout(function() {
                t._resize(), t._resizeTimeout = null
            }, 50)
        }, o.prototype._resize = function() {
            if (this.isSlideshowVisible && (this.prevItem && (t = Number(-1 * (s() / 2 + this.prevItem.offsetWidth / 2)), n(this.prevItem, f.support3d ? "translate3d(" + t + "px, -50%, -150px)" : "translate(" + t + "px, -50%)")), this.nextItem)) {
                var t = Number(s() / 2 + this.nextItem.offsetWidth / 2);
                n(this.nextItem, f.support3d ? "translate3d(" + t + "px, -50%, -150px)" : "translate(" + t + "px, -50%)")
            }
        }, t.CBPGridGallery = o
    }(window, window.CustomModernizr, window.jQuery),
    function(t) {
        function e(t, e, i, n) {
            var s = i / e;
            return Math.round(t * s)
        }

        function i(e, i, n, r) {
            var a = s(n, i);
            return a.filtered.each(function() {
                var e = t(this);
                e.add(e.find(".ff-img-holder, .picture-item__inner")).removeAttr("style")
            }), a.concealed.hide(), t(e).data("group", a.filtered), a.filtered
        }

        function n(t, e, i) {
            for (var n = 0, s = t.length; s > n; n++)
                if (e.call(i, t[n], n, t) === {}) return
        }

        function s(e, i) {
            var s = t(),
                a = t();
            return n(i, function(i) {
                var n = t(i);
                r(e, n) || n.is(".ff-ad") ? s = s.add(n) : a = a.add(n)
            }, this), {
                filtered: s,
                concealed: a
            }
        }

        function r(t, e) {
            return t.call(e[0], e)
        }

        function a(i, n, s) {
            function r(t, e) {
                var i, n, s;
                for (i = e.length; i--;)
                    if (s = e[i].size, s > t) {
                        n = parseInt(e[i].val);
                        break
                    }
                return n
            }
            var a, o, l, d, f = 0,
                h = [],
                c = (s = jQuery.makeArray(s || i.querySelectorAll(n.itemSelector))).length,
                p = t(i),
                u = t(s),
                m = i.getBoundingClientRect(),
                g = n.sizes.spacing;
            for (T = g.length; T--;)
                if (d = g[T].size, m.width < d) {
                    l = parseInt(g[T].val);
                    break
                }
            for (var v, y, w, x, b = Math.floor(m.right - m.left) - 2 * l, _ = [], I = r(b, n.sizes.row), C = r(b, n.sizes.spacing), T = 0; c > T; ++T) !(v = s[T].getElementsByTagName("img")[0]) || s[T].className.indexOf("ff-ad") + 1 ? (y = 300, w = I) : ((x = v.getAttribute("data-size")) && (x = x.split(";"), y = parseInt(x[0]), w = parseInt(x[1])), y && w || ((y = parseInt(v.getAttribute("width"))) || v.setAttribute("width", y = v.offsetWidth), (w = parseInt(v.getAttribute("height"))) || v.setAttribute("height", w = v.offsetHeight))), _[T] = {
                width: e(y, w, I, C),
                height: I
            };
            p.css("padding", "0 " + l + "px"), c = s.length;
            for (var S = 0; c > S; ++S) {
                if (s[S].classList ? (s[S].classList.remove(n.firstItemClass), s[S].classList.remove(n.lastRowClass)) : s[S].className = s[S].className.replace(new RegExp("(^|\\b)" + n.firstItemClass + "|" + n.lastRowClass + "(\\b|$)", "gi"), " "), f += _[S].width, h.push(s[S]), S === c - 1)
                    for (M = 0; M < h.length; M++) 0 === M && (h[M].className += " " + n.lastRowClass), h[M].style.cssText = "width: " + _[S + parseInt(M) - h.length + 1].width + "px;height: " + _[S + parseInt(M) - h.length + 1].height + "px;margin-right:" + (M < h.length - 1 ? C + "px" : 0);
                if (f + C * (h.length - 1) > b) {
                    for (var k, N = f + C * (h.length - 1) - b, E = (h.length, 0), M = 0; M < h.length; M++) {
                        k = h[M];
                        var z = _[S + parseInt(M) - h.length + 1].width,
                            O = z - z / f * N,
                            F = Math.round(_[S + parseInt(M) - h.length + 1].height * (O / z));
                        E + 1 - O % 1 >= .5 ? (E -= O % 1, O = Math.floor(O)) : (E += 1 - O % 1, O = Math.ceil(O)), k.style.cssText = "width: " + O + "px;height: " + F + "px;margin-right: " + (M < h.length - 1 ? C : 0) + "px;margin-bottom: " + C + "px", k.querySelectorAll(".ff-img-holder").length ? k.querySelectorAll(".ff-img-holder")[0].style.cssText = "width: " + O + "px;height: " + F + "px;" : k.querySelectorAll(".picture-item__inner")[0].style.cssText = "width: " + O + "px;height: " + F + "px;", t(k).data("newHeight", F), t(k).data("newWidth", O), 0 === M && (k.className += " " + n.firstItemClass)
                    }
                    h = [], f = 0
                }
            }
            o = u.not(".ff-ad").first(), a = o.find(".ff-item-meta").height(), u.each(function(e) {
                var i, s, r, o, l, d, f, h, c, p, u, m = t(this),
                    g = m.data(),
                    v = (g.media && g.media.split(";"), {}),
                    y = !!m.find(".ff-img-holder img").length;
                f = m.find(y ? ".ff-overlay-wrapper" : ".ff-item-cont"), l = m.find(".ff-content"), d = m.find(".ff-overlay-wrapper > h4"), h = (h = f.children()).not(".ff-overlay"), "label1" === n.streamOpts["icon-style"] && m.is(".ff-meta-first") || (h = h.not(".ff-label-wrapper")), p = parseInt(h.first().css("marginTop")), u = parseInt(h.last().css("marginBottom")), o = .07 * m.data("newWidth"), c = (h.length - 1) * o + p + u, r = d.length ? d.height() : 0, (i = m.data("newHeight") - r - a - 44 - c) < 21 && (i = i >= 20 ? 20 : r ? 0 : 0 > i ? 21 + i - o : i), v = {
                    height: i
                }, l.css(v), 0 !== v.height && l.length || (s = m.data("newHeight") - a - 44 - c, v = {}, (s = Math.floor(s)) <= 21 && (s + o >= 20 ? (d.addClass("ff-header-min"), s = 21) : (s = 0 > s ? 21 + s - o : s, v.textIndent = "-9999px")), v.height = s, 0 >= s && d.detach(), d.css(v))
            })
        }
        t.fn.rowGrid = function(e, n) {
            return this.each(function() {
                var s, r, o = t(this);
                "appended" === e ? (e = o.data("grid-options"), s = (r = o.children("." + e.lastRowClass)).nextAll(e.itemSelector).add(r), a(this, e, s)) : "shuffle" === e ? (e = o.data("grid-options"), s = i(this, s = o.data("items"), n), a(this, e, s)) : (e = t.extend({}, t.fn.rowGrid.defaults, e), o.data("grid-options", e), a(this, e), e.resize && t(window).on("resize.rowGrid", {
                    container: this
                }, function(i) {
                    var n = t(i.data.container).data("group");
                    n && n.each(function() {
                        var e = t(this);
                        e.add(e.find(".ff-img-holder, .picture-item__inner")).removeAttr("style")
                    }), t(i.data.container).find(".ff-item:not(.ff-ad) .ff-content").dotdotdot({
                        ellipsis: "...",
                        after: ""
                    }), a(i.data.container, e, n)
                }))
            })
        }, t.fn.rowGrid.defaults = {
            minMargin: null,
            maxMargin: null,
            resize: !0,
            lastRowClass: "last-row",
            firstItemClass: null
        }
    }(jQuery),
    function(t) {
        "use strict";

        function e(t) {
            if (document.createEvent) {
                var e = document.createEvent("MouseEvents");
                e.initEvent("click", !1, !0), t.dispatchEvent(e)
            } else document.createEventObject ? t.fireEvent("onclick") : "function" == typeof t.onclick && t.onclick()
        }

        function i(t, e, i, s) {
            if (t = Number(t), !1 !== (s = s || !1)) return n(t, e, i, s);
            var r;
            return r = t >= 1e12 ? "T" : t >= 1e9 ? "B" : t >= 1e6 ? "M" : t >= 1e3 ? "K" : "", n(t, e, i, r)
        }

        function n(t, e, i, n) {
            var s = 0;
            switch (n) {
                case "T":
                    s = t / 1e12;
                    break;
                case "B":
                    s = t / 1e9;
                    break;
                case "M":
                    s = t / 1e6;
                    break;
                case "K":
                    s = t / 1e3;
                    break;
                case "":
                    s = t
            }
            return !1 !== e && new RegExp("\\.\\d{" + (e + 1) + ",}$").test("" + s) && (s = s.toFixed(e)), !1 !== i && (s = Number(s).toFixed(i)), s + n
        }
        var s, r, a = t("html"),
            o = navigator.userAgent.toLowerCase(),
            l = /safari|chrome/.test(o),
            d = /android|blackBerry|iphone|ipad|ipod|opera mini|iemobile/i.test(o),
            f = /msie|trident.*rv\:11\./.test(o),
            h = /firefox/.test(o),
            c = !1,
            p = window.FlowFlowOpts;
        if (f) {
            if (/msie 8/.test(o)) return;
            s = /msie 9/.test(o)
        }
        a.addClass("ff-browser-" + (l ? /chrome/.test(o) ? "chrome" : "safari" : f ? "ie" + (s ? " ff-ie9" : "") : h ? "ff" : "")), t.expr.createPseudo && "function" == typeof t.expr.createPseudo ? t.expr[":"].contains = t.expr.createPseudo(function(e) {
            return function(i) {
                return t(i).text().toUpperCase().indexOf(e.toUpperCase()) >= 0
            }
        }) : jQuery.expr[":"].contains = function(t, e, i) {
            return jQuery(t).text().toUpperCase().indexOf(i[3].toUpperCase()) >= 0
        };
        var u = function(t) {
            function n() {
                return t(document).bind("ffimgloaded", function(t, e) {
                    var i = e.$grid.data("shuffle");
                    i && i.layout()
                }), n = function() {
                    return u
                }, u
            }

            function s(e, i) {
                for (var n, s = 0, r = i.template.length; r > s; s++) "image" === i.template[s] && (n = s);
                e.each(function(e, i) {
                    var s, r, a = t(i),
                        o = a.find(".ff-img-holder"),
                        l = "insertBefore";
                    o.closest(".ff-content").length && (s = a.find(".ff-item-cont").children().not(".ff-label-wrapper"), n >= s.length ? (r = s.length - 1, n > s.length && (l = "insertAfter")) : r = n, o[l](s.eq(r))), a.addClass("ff-" + (o.length ? "" : "no-") + "image")
                })
            }

            function a(e) {
                var i, n, s, r, a = t(this),
                    o = this,
                    l = a.parent(),
                    d = l.is("a") ? l : a;
                (s = a.data("size")) && (i = s.split(";")[1], n = i && 0 != i), n || (i = a.attr("height") || a.height(), n = i && 0 != i), l.is(".ff-img-holder") || (a.removeAttr("width").removeAttr("height"), r = t('<span class="ff-img-holder ff-img-loading" style="width: 100%;max-height: none"></span>'), d.wrap(r)), o.onload = function() {
                    n || t(document).trigger("ffimgloaded", {
                        $grid: e
                    }), a.closest(".ff-img-holder").removeClass("ff-img-loading").addClass("ff-img-loaded"), a = null, o = null
                }, o.onerror = function() {
                    a.closest(".ff-img-holder").removeClass("ff-img-loading").addClass("ff-img-loaded"), a = null, o = null
                }, l = null, d = null
            }

            function o(t) {
                var e, i, n, s, r, a, o = p.server_time,
                    d = o - t,
                    f = new Date(1e3 * t);
                for (a = S.length - 1; a >= 0 && (e = d / S[a]) <= 1; a--);
                switch (0 > a && (a = 0), e = Math.floor(e), a) {
                    case 3:
                        if (1 == e) {
                            i = p.dates.Yesterday;
                            break
                        }
                    case 4:
                    case 5:
                        n = f.getMonth(), s = f.getDate(), i = k[n] + " " + s;
                        break;
                    case 6:
                    case 7:
                        n = f.getMonth(), s = f.getDate(), r = f.getFullYear(), i = k[n] + " " + s + ", " + r;
                        break;
                    default:
                        i = l(e, o, o - d % S[a], 0, a)
                }
                return i
            }

            function l(t, e, i, n, s) {
                var r = N;
                return t + (r = r[s]) + " " + p.dates.ago
            }

            function f(t, e, n, s, r, a) {
                var o, l, f, h, c, u, m, g, v, y, w, x, b, _, I, S, k, N, E = t.length,
                    M = "",
                    z = "",
                    O = "",
                    F = r["icon-style"] && r["icon-style"].indexOf("stamp") > -1,
                    d = "",
                    $ = e;
                for (a || (a = 0), r && "randomCompare" == r.order && (t = C(t)), o = 0; E > o; o++) {
                    if (f = t[o], l = o + 1, v = O = g = N = z = "", _ = {}, k = r.isOverlay && (!!f.img || -1 !== f.text.indexOf("<img")), "ad" !== f.type /*1==1*/) {
                        m = void 0 !== f.source ? f.source : f.permalink, !0 && (I = "new" == f.status ? " ff-moderation-new-post" : "", S = "approved" == f.status ? "checked" : "", z = f.mod ? '<div class="ff-moderation-wrapper ' + ("approved" == f.status ? "ff-approved" : "") + I + '"><span>Approve</span> <label for="ff-mod-' + ($ + a) + '"><input id="ff-mod-' + ($ + a) + '" type="checkbox" class="ff-switcher" value="yes" ' + S + '/><div><span></span></div></label></div>':'', d = FlowFlowOpts.isAdmin ? '<div class="ff-moderation-wrapper switch-response"></div><div class="ff-moderation-wrapper ff-moderation-featured-wrapper' + I + '"><span>Featured</span> <label for="ff-featured-' + ($ + a) + '"><input id="ff-featured-' + ($ + a) + '" type="checkbox" class="ff-switcher" value="yes"  ' + ("1" == f.featured ? "checked" : "") + '/><div><span></span></div></label></div><div class="ff-moderation-wrapper ff-moderation-is-active-wrapper' + I + '"><span>Show/Hide</span> <label for="ff-is-active-' + ($ + a) + '"><input id="ff-is-active-' + ($ + a) + '" type="checkbox" class="ff-switcher" value="yes" ' + ("1" == f.is_active ? "checked" : "") + "/><div><span></span></div></label></div>":''), f.additional && ("twitter" === f.type && (v += '<a href="https://twitter.com/intent/tweet?in_reply_to=' + f.id + '" class="ff-comments"> <i class="ff-icon-reply"></i></a>'), (b = parseInt(f.additional.views)) > -1 && (v += '<span class="feed-view"><i class="ff-icon-view"></i> <span>' + (0 > b ? "" : i(b, 2)) + "</span></span>"), (y = parseInt(f.additional.likes)) > -1 && "twitter" !== f.type && (v += '<span class="feed-likes"><i class="ff-icon-like"></i> <span>' + (0 > y ? "" : i(y, 2)) + "</span></span>"), (x = parseInt(f.additional.shares)) > -1 && (v += '<a href="' + ("twitter" === f.type ? "https://twitter.com/intent/retweet?tweet_id=" + f.id : f.permalink) + '" class="ff-shares"><i class="ff-icon-shares"></i> <span>' + (0 > x ? "" : i(x, 2)) + "</span></a>"), y > -1 && "twitter" === f.type && (v += '<a href="https://twitter.com/intent/favorite?tweet_id=' + f.id + '" class="ff-likes"><i class="ff-icon-like"></i> <span>' + (0 > y ? "" : i(y, 2)) + "</span></a>"), w = parseInt(f.additional.comments), "twitter" !== f.type && w > -1 && (v += '<span class="feed-comments"><i class="ff-icon-comment"></i> <span>' + (w > -1 ? i(w, 2) : "") + "</span></span>")), n && (O += '<div class="ff-share-wrapper"><i class="ff-icon-share"></i><div class="ff-share-popup"><a href="http://www.facebook.com/sharer.php?u=' + window.base_url + "feed/" + f.id + "/" + f.feed_id + '" class="ff-fb-share"><span>Facebook</span></a><a href="https://twitter.com/share?' + (f.header ? "text=" + encodeURIComponent(f.header) + "&" : "") + "url=" + window.base_url + "feed/" + f.id + "/" + f.feed_id + '" class="ff-tw-share"><span>Twitter</span></a><a href="https://plus.google.com/share?url=' + window.base_url + "feed/" + f.id + "/" + f.feed_id + '" class="ff-gp-share"><span>Google+</span></a><a href="https://www.pinterest.com/pin/create/button/?url=' + window.base_url + "feed/" + f.id + "/" + f.feed_id + (f.media ? "&media=" + encodeURIComponent(f.media.url) : "") + '" class="ff-pin-share" data-pin-description="' + f.plain_text + '"><span>Pinterest</span></a></div></div> <a href=' + window.base_url + "feed/" + f.id + "/" + f.feed_id + ' title="read more" class="external-link"><i class="fa fa-long-arrow-up"></i></a>'), N = f.media ? ' data-media="' + f.media.width + ";" + f.media.height + ";" + ("yep" === p.forceHTTPS ? f.media.url.replace("http:", "https:") : f.media.url) + ";" + f.media.type + (f.img ? ";" + f.img.width + ";" + f.img.height : "") + '"' : "", _.image = f.img ? '<span class="ff-img-holder ff-img-loading" ' + N + '><img class="ff-initial-image" src="' + ("yep" === p.forceHTTPS ? f.img.url.replace("http:", "https:") : f.img.url) + '" data-size="' + f.img.width + ";" + f.img.height + '" rel="image_src" /></span>' : "", _.header = f.header ? '<h4><span>' + f.header + "</span></h4>" : "", _.text = '<div class="ff-content">' + f.text + "</div>", _.meta = '<div class="ff-item-meta"><span class="ff-userpic" style="background:url(' + ("yep" === p.forceHTTPS ? f.userpic.replace("http:", "https:") : f.userpic) + ')"><i class="ff-icon"><i class="ff-icon-inner"></i></i></span><h6><span rel="nofollow" class="ff-name ' + (f.userlink ? "" : " ff-no-link") + '">' + f.screenname + "</span></h6>" + (f.nickname ? '<span rel="nofollow" class="ff-nickname' + (f.userlink ? "" : " ff-no-link") + '">' + f.nickname + "</span>" : "") + '<span rel="nofollow" class="ff-timestamp">' + T(f.system_timestamp, f.timestamp) + "</span></div>", _.labelIcon = F ? "" : '<h6 class="ff-label-wrapper"><i class="ff-icon"><i class="ff-icon-inner"><span class="ff-label-text">' + f.type + "</span></i></i></h6>";
                        for (var A = 0, P = r.template.length; P > A; A++) 1 === A && k && (g += '<div class="ff-overlay-wrapper">'), g += _[r.template[A]], "meta" === r.template[A] && (g += _.labelIcon), A === P - 1 && k && (g += '<h6 class="ff-item-bar">' + v + O + "</h6>", g += '<div class="ff-overlay"></div></div>');
                        M += '<article class="ff-item' + (f.media && "image" != f.media.type ? " ff-video-preview" : "") + " ff-" + f.type + ("meta" === r.template[r.isOverlay ? 1 : 0] || !f.img && "meta" === r.template[1] ? " ff-meta-first" : "") + (f.header ? " ff-has-header" : "") + (f.img ? " ff-image" : " ff-no-image") + (k ? " ff-has-overlay" : "") + '" id="ff-uid-' + $ + '" post-id="' + f.id + '" data-type="' + f.type + '" data-index="' + (l + a) + '"' + N + ' data-timestamp="' + f.system_timestamp + '">' + (s && f.mod ? z : "") + (FlowFlowOpts.isAdmin ? d : "") + '<div class="picture-item__inner">'+((f.featured == "1" &&FlowFlowOpts.isAdmin!=1) ? "<div class='featured-badge'></div></span>" : "")+'<div class="ff-item-cont">' + g + "</div>" + (k ? "" : '<h6 class="ff-item-bar">' + v + O + "</h6>"), d && (M += '<a class="ff-mob-link" href="' + f.permalink + '"></a>'), M += "</div></article>"
                    } else {
                        const regex = /<iframe\s+.*?\s+src=\"(.*?)\".*?<\/iframe>/g;
                        const result = f.text.replace(regex, function replacer(match, p1, p2, p3, offset, string) {
                            /*
                             * match = entire iframe tag
                             * p1 = src of iframe
                             */
                            var ytVId = ytVidId(p1);
                            if(ytVId){
                                return '<div class="iframe-hide" style="display: none;">'+'<iframe frameborder="0" height="116" src="'+p1+'?version=3&amp;enablejsapi=1&amp;f=videos&amp;autoplay=0" width="208" allowfullscreen="" webkitallowfullscreen="" mozallowfullscreen="" autoplay="0" wmode="opaque"></iframe>'+'</div>' + '<div class="ff-video-preview"><span class="ifrmage-image-show ff-img-holder ff-img-loaded" data-media="600;338;'+p1+'&f=videos&autoplay=0;application/x-shockwave-flash;230;130"><img class="ff-initial-image" src="//i1.ytimg.com/vi/'+ytVId+'/mqdefault.jpg"/></span></div>';
                            } else {
                                var vimeoVideoID = vimeoVId(p1);
                                if(vimeoVideoID){
                                    var imageSrc= jQuery.ajax({
                                        url: window.base_url + "adfeed/get-vimeo-image/" + vimeoVideoID,
                                        async: false
                                    }).responseText;
                                    return '<div class="iframe-hide" style="display: none;">'+'<iframe frameborder="0" height="116" src="'+p1+'?version=3&amp;enablejsapi=1&amp;f=videos&amp;autoplay=0" width="208" allowfullscreen="" webkitallowfullscreen="" mozallowfullscreen="" autoplay="0" wmode="opaque"></iframe>'+'</div>' + '<span class="ifrmage-image-show ff-img-holder ff-img-loaded" data-media="600;338;'+p1+'&f=videos&autoplay=0;application/x-shockwave-flash;230;130"><img class="ff-initial-image" src="'+imageSrc+'"/></span>';
                                }
                            }
                            return match;
                        });

                        h = "yep" === f.label ? 'data-label="' + f.labelTxt + ";" + f.labelCol + '"' : "", c = 'style="' + (f.textCol ? "color:" + f.textCol + ";" : "") + ("js" === f.adtype ? "height:" + f.height + "px" : "") + '"', M += '<div class="ff-item ff-' + f.type + (f.permalink ? " ff-ad-link" : "") + '" id="ff-uid-' + $ + '" post-id="' + f.id + '" data-type="' + f.type + '" data-adtype="' + f.adtype + '" data-index="' + l + '" ' + h + '><div class="picture-item__inner"><div class="ff-item-cont ff-' + f.type + '" style="' + (f.cardBG ? "background-color:" + f.cardBG + ";" : "") + '"><div class="ff-content" ' + c + ">" + /*f.text.replace*/ result.replace(/document\.write\((.+?)\)/i, function (t, e) {
                                return "jQuery(" + e + ').appendTo(jQuery("#ff-uid-' + $ + ' .ff-content"))'
                            }) + "</div>", (M += '<div class="ff-item-meta"><br><span>&nbsp;</span></div>'), (M += '</div>'), (f.permalink && (M += '<h6 class="ff-item-bar" style="' + (f.cardBG ? "background-color:" + f.cardBG + ";" : "") + '"><a href=' + f.permalink + ' title="read more" class="external-link"><i class="fa fa-long-arrow-up"></i></a></h6>')), (M += '</div></div>');
                    }
                    $++
                }
                return M
            }
            function ytVidId(url) {
                var p = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
                return (url.match(p)) ? RegExp.$1 : false;
            }
            function vimeoVId(url){
                var vID = false;

                // Look for a string with 'vimeo', then whatever, then a
                // forward slash and a group of digits.
                var match = /vimeo.*\/(\d+)/i.exec( url );

                // If the match isn't null (i.e. it matched)
                if ( match ) {
                    // The grouped/matched digits from the regex
                    vID =  match[1];
                }

                return vID;
            }

            function h(e, i) {
                clearTimeout(r), c || (e.find(".ff-item").each(w), c = !0), r = setTimeout(function() {
                    if (h.finder, e.find(".ff-highlight").each(function() {
                            t(this).replaceWith(this.childNodes)
                        }), i) {
                        var n = "justified" !== e.data("opts").layout ? "shuffleCustom" : "rowGrid";
                        e[n]("shuffle", function(e, n) {
                            var s, r;
                            return (!n || "all" === n.group || -1 !== t.inArray(n.group, e.data("groups"))) && ((s = e.find(':contains("' + i + '")')).length && s.first().find("*").filter(function() {
                                    var e = t(this);
                                    return !e.children().length || e.is("p")
                                }).each(function(e, n) {
                                    t(n).is("p") ? h.finder = window.findAndReplaceDOMText(n, {
                                        find: new RegExp(i, "i"),
                                        wrap: "span",
                                        clss: "ff-highlight"
                                    }) : t(n).html(function(t, e) {
                                        return e.replace(new RegExp(i, "i"), function(t) {
                                            return '<span class="ff-highlight">' + t + "</span>"
                                        })
                                    })
                                }), s.length || (r = -1 !== (r = t.trim(e.attr("data-type")).toLowerCase()).indexOf(i)), s.length || r)
                        }, "only_sort")
                    }
                }, 100)
            }

            function m(e, i) {
                c || (e.find(".ff-item").each(w), c = !0), e["justified" !== e.data("opts").layout ? "shuffleCustom" : "rowGrid"]("shuffle", function(e, n) {
                    if (n && "all" !== n.group && -1 === t.inArray(n.group, e.data("groups"))) return !1;
                    var s = t.trim(e.attr("data-type")).toLowerCase();
                    return i ? -1 !== s.indexOf(i) : 1
                }, "only_sort")
            }

            function g(e, i, n, r, o, l) {
                e.find(".shuffle__sizer");
                var d, h, c, u, m = e.find(".ff-item"),
                    g = "grid" === o.layout ? "" : "masonry" === o.layout ? "m-" : "j-",
                    w = {
                        columns: [{
                            size: 1e4,
                            val: o[g + "c-desktop"]
                        }, {
                            size: 1200,
                            val: o[g + "c-laptop"]
                        }, {
                            size: 1024,
                            val: o[g + "c-tablet-l"]
                        }, {
                            size: 768,
                            val: o[g + "c-tablet-p"]
                        }, {
                            size: 480,
                            val: o[g + "c-smart-l"]
                        }, {
                            size: 380,
                            val: o[g + "c-smart-p"]
                        }],
                        spacing: [{
                            size: 1e4,
                            val: o[g + "s-desktop"]
                        }, {
                            size: 1200,
                            val: o[g + "s-laptop"]
                        }, {
                            size: 1024,
                            val: o[g + "s-tablet-l"]
                        }, {
                            size: 768,
                            val: o[g + "s-tablet-p"]
                        }, {
                            size: 480,
                            val: o[g + "s-smart-l"]
                        }, {
                            size: 380,
                            val: o[g + "s-smart-p"]
                        }],
                        row: [{
                            size: 1e4,
                            val: o[g + "h-desktop"]
                        }, {
                            size: 1200,
                            val: o[g + "h-laptop"]
                        }, {
                            size: 1024,
                            val: o[g + "h-tablet-l"]
                        }, {
                            size: 768,
                            val: o[g + "h-tablet-p"]
                        }, {
                            size: 480,
                            val: o[g + "h-smart-l"]
                        }, {
                            size: 380,
                            val: o[g + "h-smart-p"]
                        }]
                    };
                return y(m), "justified" !== o.layout ? (e.shuffleCustom({
                    itemSelector: ".ff-item",
                    gutterWidth: function(t) {
                        var e = Array.prototype.slice.call(arguments);
                        return e.push(w.spacing),
                            function(t, e) {
                                var i, n, s;
                                for (i = e.length; i--;)
                                    if (s = e[i].size, s > t) {
                                        n = parseInt(e[i].val);
                                        break
                                    }
                                return n
                            }.apply(null, e)
                    },
                    columnWidth: function(t, e) {
                        var i = Array.prototype.slice.call(arguments);
                        return e || this._itemMargin, i.push(w.columns),
                            function(t, e, i) {
                                var n, s, r, a;
                                for (n = i.length; n--;)
                                    if (r = i[n].size, r > t) {
                                        s = (t - 2 * e - e * ((a = parseInt(i[n].val)) - 1)) / a;
                                        break
                                    }
                                return s ? Math.floor(s) : 260
                            }.apply(null, i)
                    },
                    streamOpts: o
                }), e.on("done.shuffle", function() {
                    setTimeout(function() {
                        d.layout(), l.find(".ff-loadmore-wrapper").css("visibility", "visible")
                    }, 0)
                })) : (e.rowGrid({
                    minMargin: 5,
                    maxMargin: 5,
                    itemSelector: ".ff-item",
                    firstItemClass: "first-item",
                    resize: !0,
                    sizes: w,
                    streamOpts: o
                }), setTimeout(function() {
                    l.find(".ff-loadmore-wrapper").css("visibility", "visible")
                }, 0)), r && (c = e.parent(), h = new CBPGridGallery(c, {
                    iconStyle: o["icons-style"]
                }), u = c.find(".ff-slideshow").attr("id", c.attr("id") + "-slideshow"), "yep" === o.hidemeta && u.addClass("ff-hide-meta"), setTimeout(function() {
                    document.body.appendChild(u.get(0))
                }, 0)), window.requestAnimationFrame && v(e, m), e.find(".ff-item:not(.ff-ad) .ff-content").dotdotdot({
                    ellipsis: "...",
                    after: ""
                }), d = e.data("shuffle"), i && (i = parseInt(i), e.addClass("ff-slider").parent().css("paddingBottom", "70px"), b(e, i, d, n), e.shuffleCustom("shuffle", function(t, e) {
                    return parseInt(t.attr("data-index")) <= i
                }), e.data("num", m.length), e.data("visible", 0)), l.find(".ff-loadmore-wrapper span").click(function() {
                    var i = t(this),
                        n = l.find(".ff-loader"),
                        r = l.find(".ff-item")/*.not(".ff-ad")*/.length,
                        c = {
                            action: "fetch_posts",
                            "stream-id": o.id,
                            page: o["next-page"],
                            countOfPages: o.countOfPages,
                            hash: o.hash
                        };
                    i.css("opacity", 0), n.insertAfter(i).show().removeClass("ff-squeezed"),
                        t.get(FlowFlowOpts.ajaxurl, c, function(l) {
                            var c = JSON.parse(l),
                                u = c.items,
                                m = (u.length, f(u, t('[id^="ff-uid-"]').length + 1 || 1, !0, p.moderation, o)),
                                g = t(m),
                                w = g,
                                x = w.toArray();
                            if (e.trigger("loaded_more", {
                                    items: g
                                }), o.hash = c.hash, o["next-page"] = c.page + 1, o.countOfPages = c.countOfPages, e.append(g), "justified" !== o.layout ? e.shuffleCustom("appended", g) : e.rowGrid("appended"), y(g), window.requestAnimationFrame && v(e, g), w.each(function() {
                                    t(this).find("img").not(":first").remove()
                                }), g.find("img").each(function() {
                                    a.apply(this, [e])
                                }), "yep" === p.open_in_new) {
                                var b = location.hostname;
                                g.find("a").filter(function() {
                                    return this.hostname != b
                                }).attr("target", "_blank")
                            }
                            if (h && (h._addSlideShowItems(x), h.initItemsEvents(x, r), h.slideshowItems = [].slice.call(h.slideshow.children), h.itemsCount = h.itemsCount + w.length), s(w, o), n.addClass("ff-squeezed").delay(300).hide(), setTimeout(function() {
                                    w.filter(":lt(5)").addClass("in"), w.find(".ff-content").dotdotdot({
                                        ellipsis: "...",
                                        after: ""
                                    }), setTimeout(function() {
                                        c.page + 1 != c.countOfPages ? i.css("opacity", 1) : i.remove(), d.layout()
                                    }, 200)
                                }, 14), FlowFlowOpts.dependencies.ads && c.ads) {
                                var _ = jQuery.post(p.ajaxurl, {
                                    action: "flow_flow_ad_action",
                                    status: "view",
                                    id: c.ads
                                });
                                t.when(_).always(function(t) {})
                            }
                        })
                }), d
            }

            function v(t, e) {
                e.each(function() {
                    FF_Viewport.add({
                        element: this,
                        threshold: 130,
                        enter: w,
                        leave: x
                    })
                })
            }

            function y(t) {
                t.find(".picture-item__inner").addClass("picture-item__inner--transition")
            }

            function w() {
                t(this).addClass("in").data("viewport", "in")
            }

            function x() {
                t(this).data("viewport", "out")
            }

            function b(e, i, n, s) {
                function r() {
                    var t = f.data("currentSlide") - 1;
                    1 > t && (t = p), f.data("currentSlide", t), o(t), s && setTimeout(l, 0)
                }

                function a() {
                    var t = f.data("currentSlide") + 1;
                    t > p && (t = 1), f.data("currentSlide", t), o(t), s && setTimeout(l, 0)
                }

                function o(n) {
                    e.shuffleCustom("shuffle", function(e, s) {
                        var r, a, o;
                        return ("all" === s.group || -1 !== t.inArray(s.group, e.data("groups"))) && (r = e.attr("data-index"), a = i * (n - 1), o = i * n, r > a && o >= r)
                    })
                }

                function l() {
                    var i = e.offset().top;
                    t("html, body").animate({
                        scrollTop: i - 100
                    }, 300)
                }
                var f, h = t('<span class="ff-control-prev"/>'),
                    c = t('<span class="ff-control-next"/>'),
                    p = Math.ceil(n.$items.length / i);
                h.on("click", r), c.on("click", a), d && _(e, r, a), (f = t('<div class="ff-controls-wrapper"></div>').append(h).append(c)).data("currentSlide", 1), e.on("layout.shuffle", function() {}), e.append(f)
            }

            function _(t, e, i) {
                var n, s, r, a, o;
                t.bind("touchstart", function(t) {
                    r = (new Date).getTime(), n = t.originalEvent.touches[0].pageX, s = t.originalEvent.touches[0].clientY
                }).bind("touchmove", function(t) {
                    a = t.originalEvent.touches[0].pageX, o = t.originalEvent.touches[0].clientY
                }).bind("touchend", function() {
                    var t = a > n ? "right" : "left",
                        l = o - s > 60 || -60 > o - s,
                        d = a - n > 60 || -60 > a - n;
                    if (!((new Date).getTime() - r > 300 || l) && d) switch (t) {
                        case "left":
                            i();
                            break;
                        case "right":
                            e()
                    }
                })
            }

            function I(e, i, n) {
                var s = n.id,
                    r = n.hash,
                    a = {};
                e.find(".ff-moderation-apply").click(function(e) {
                    var i = t.post(FlowFlowOpts.ajaxurl, {
                        action: "moderation_apply_action",
                        moderation_action: "custom_approve",
                        stream: s,
                        changed: a,
                        hash: r
                    });
                    t.when(i).done(function(t) {
                        location.reload()
                    })
                }), e.find(".ff-moderation-approve-new").click(function(e) {
                    var i = t.post(FlowFlowOpts.ajaxurl, {
                        action: "moderation_apply_action",
                        moderation_action: "new_posts_approve",
                        stream: s,
                        hash: r
                    });
                    t.when(i).done(function(t) {
                        location.reload()
                    })
                }), e.on("change", ".ff-moderation-wrapper input", function(e) {
                    var i = t(this),
                        n = i.is(":checked"),
                        s = i.closest(".ff-item").attr("post-id");
                    i.closest(".ff-moderation-wrapper")[n ? "addClass" : "removeClass"]("ff-approved"), a[s] = {
                        approved: n
                    }
                })
            }

            function C(t) {
                for (var e, i, n = t.length; 0 !== n;) i = Math.floor(Math.random() * n), e = t[n -= 1], t[n] = t[i], t[i] = e;
                return t
            }
            var T = "agoStyleDate" === p.date_style ? function(t, e) {
                    return o(t)
                } : function(t, e) {
                    return e
                },
                S = [1, 60, 3600, 86400, 604800, 2630880, 31570560, 315705600],
                k = p.dates.months,
                N = [p.dates.s, p.dates.m, p.dates.h],
                E = (FF_Viewport.getInstance(), {});
            return {
                init: n,
                streams: E,
                addTransitionToItems: y,
                addViewportItems: v,
                prepareImageFor: a,
                adjustItems: s,
                shuffle: g,
                recalcLayout: function(t) {
                    t.$el.layout()
                },
                buildItems: f,
                buildStreamWith: function(i, n, r, o) {
                    var l, c, u, g, v, y, w, x, b = "";
                    if ("string" == typeof n.feeds && (n.feeds = JSON.parse(n.feeds)), 0 === n.feeds.length) return "<p>No feeds to show. Add at least one</p>";
                    if (!n.layout) return "<p>Please choose stream layout on options page</p>";
                    n.hash = i.hash, n["next-page"] = i.page + 1, n.countOfPages = i.countOfPages;
                    var _ = i.items,
                        C = 0,
                        T = _.length,
                        S = t('[id^="ff-uid-"]').length + 1 || 1;
                    if ("yep" === n.gallery && (b += '<section class="ff-slideshow"><ul></ul><nav><span class="ff-nav-prev"></span><span class="icon ff-nav-next"></span><span class="ff-nav-close"></span></nav><div class="ff-nav-info-keys">' + window.FlowFlowOpts.lightbox_navigate + "</div></section>"), b += '<div class="ff-header ff-loading">', n.heading && (b += "<h1>" + n.heading.replace(/\\/g, "") + "</h1>"), n.subheading && (b += "<h2>" + n.subheading.replace(/\\/g, "") + "</h2>"), "yep" === n.filter) {
                        for (v = "", y = {}, w = 0, C = 0; T > C; C++) y[_[C].type] = 1;
                        for (var k in y) "ad" !== k && (w += 1, v += '<span class="ff-filter ff-type-' + k + '" data-filter="' + k + '"></span>');
                        b += '<div class="ff-filter-holder">' + (w > 1 ? '<span class="ff-filter ff-type-all ff-filter--active">' + p.filter_all + "</span>" + v : "") + '<span class="ff-search"><input type="text" placeholder="' + p.filter_search + '"/></span></div>'
                    }
                    if (r && (p.moderation = r, b += '<div class="ff-moderation-holder"><p><strong>PREMODERATION MODE IS ON</strong>. APPROVE POSTS AND HIT <strong>APPLY CHANGES</strong>.</p><span class="ff-moderation-button ff-moderation-apply">Apply changes</span><span class="ff-moderation-button ff-moderation-approve-new">Approve new posts</span></div>'), b += "</div>", n["gc-style"], b += '<div class="ff-stream-wrapper ff-' + (d ? "mobile" : "desktop") + " shuffle--container" + ("yep" === n.viewportin && !d && window.requestAnimationFrame ? " shuffle--animatein" : " shuffle--animateoff") + " ff-layout-" + n.layout + " ff-upic-" + n["upic-pos"] + " ff-upic-" + n["upic-style"] + " ff-align-" + n.talign + " ff-sc-" + n["icon-style"] + " ff-" + n["icons-style"] + '-icon">', x = f(_, S, !0, r, n), b += x, b += '<div class="shuffle__sizer"></div></div>', i.countOfPages > 1 && i.page + 1 != i.countOfPages && ("yep" !== n.mobileslider || !d) && (b += '<div class="ff-loadmore-wrapper"><span class="ff-btn">' + window.FlowFlowOpts.show_more + "</span></div>"), (l = t(b)).each(function(e) {
                            return this.className.indexOf("ff-stream-wrapper") + 1 ? (c = t(this), !1) : void 0
                        }), u = l.find(".ff-item"), g = u.not(".ff-ad"), c.data("opts", n).data("items", u), g.each(function() {
                            var e = t(this);
                            e.is(".ff-image") ? e.find("img").not(".ff-initial-image").remove() : e.find("img").not(":first").remove()
                        }), l.find("p:empty, .ff-content a:empty").remove(), l.find("img").each(function() {
                            a.apply(this, [c])
                        }), l.find(".ff-filter").click(function() {
                            l.find(".ff-filter--active").removeClass("ff-filter--active");
                            var e = t(this).addClass("ff-filter--active").attr("data-filter");
                            m(c, e)
                        }), l.find(".ff-search input").on("keyup", function() {
                            var t = this.value.toLowerCase();
                            h(c, t)
                        }), l.on("click", "a", function(event) {
                            var href = $(this).attr('href');
                            var e, i = t(this);
                            if(i.closest(".ff-share-popup").length) {
                                return (e = t(this).attr("href"), window.open(e, "sharer", "toolbar=0,status=0,width=626,height=436"), !1)
                            }  else if(i.closest(".ff-content").length && !i.parents('.ff-slideshow').length) {
                                if(href.indexOf('explore/tags/') >= 0){
                                    var search = $(this).text();
                                    event.stopPropagation();
                                    event.preventDefault();
                                    $('.ff-search input').val(search);
                                    h(c,search);
                                    $('html,body').animate({
                                            scrollTop: $(".ff-stream").offset().top},
                                        'slow');
                                }
                            } else {
                                return (!i.is(".ff-no-link") || "nope" !== n.gallery && !d) && void 0
                            }
                        }), l.on("click", ".ff-icon-share", function(e) {
                            var i = t(this).parent();
                            return i.data("opened") ? (i.removeClass("ff-popup__visible"), i.data("opened", !1)) : (i.addClass("ff-popup__visible"), i.data("opened", !0)), !1
                        }), "nope" === n.gallery ? (c.addClass("ff-gallery-off").on("click", '.ff-item:not(".ff-ad") .picture-item__inner', function(i) {
                            var n = t(i.target),
                                s = t(this);
                            return !n.closest("a").length || n.is("img") ? (d ? s.toggleClass("ff-taped") : e(s.find(".ff-timestamp")[0]), !1) : void 0
                        }), c.on("click", ".ff-timestamp", function(t) {
                            t.stopImmediatePropagation()
                        })) : c.addClass("ff-gallery-on"), "yep" === p.open_in_new) {
                        var N = location.hostname;
                        l.find("a").filter(function() {
                            return this.hostname != N
                        }).attr("target", "_blank")
                    }
                    s(g, n), r && I(l, _, n), E[n.id] = c;
                    for (var M in o) o[M] && this[M].init(c);
                    return l
                },
                setupGrid: function(t, e, i, n, s, r) {
                    setTimeout(function() {
                        g(t, e, i, n, s, r)
                    }, 0)
                },
                adjustImgHeight: function(e, i) {
                    e.find("img").each(function() {
                        var e = t(this),
                            n = parseInt(e.css("height")),
                            s = parseInt(e.css("width")),
                            r = i / s;
                        e.css("height", Math.round(n * r) + "px")
                    })
                }
            }
        }(t);
        window.FlowFlow = u.init()
    }(jQuery), jQuery(document).on("done.shuffle", function(t, e) {
    jQuery(function() {
        setTimeout(function() {}, 500)
    }), jQuery(document).ready(function() {
        jQuery("body").on("change", ".ff-moderation-featured-wrapper input", function() {
            var t = jQuery(this),
                e = jQuery(this),
                i = e.is(":checked"),
                n = e.closest(".ff-item").attr("post-id");
            e.closest(".ff-moderation-wrapper")[i ? "addClass" : "removeClass"]("ff-featured"), jQuery.ajax({
                url: FlowFlowOpts.ajaxurl,
                type: "post",
                data: {
                    action: "featured_post_apply_action",
                    featured: i,
                    post_id: n
                }
            }).success(function(e) {
                var i = JSON.parse(e);
                i.status ? t.closest(".ff-item").find(".switch-response").html('<span  style="color:#3b981c">Post updated successfully.</span>').css("display", "block").fadeOut(5e3) : t.closest(".ff-moderation-featured-wrapper").find(".switch-response").html('<span style="color:#ff0000"> Post has not been updated successfully.</span>').css("display", "block").fadeOut(5e3)
            }).fail(function(e) {
                t.closest(".ff-item").find(".switch-response").html('<span style="color:#ff0000"> Post has not been updated successfully.</span>').css("display", "block").fadeOut(5e3)
            })
        }), jQuery("body").on("change", ".ff-moderation-is-active-wrapper input", function() {
            var t = jQuery(this),
                e = jQuery(this),
                i = e.is(":checked"),
                n = e.closest(".ff-item").attr("post-id");
            jQuery.ajax({
                url: FlowFlowOpts.ajaxurl,
                type: "post",
                data: {
                    action: "post_display_action",
                    is_active: i,
                    post_id: n
                }
            }).success(function(e) {
                var i = JSON.parse(e);
                i.status ? t.closest(".ff-item").find(".switch-response").html('<span  style="color:#3b981c">Post updated successfully.</span>').css("display", "block").fadeOut(5e3) : t.closest(".ff-moderation-is-active-wrapper").find(".is-active-response").html('<span style="color:#ff0000"> Post has not been updated successfully.</span>').css("display", "block").fadeOut(5e3)
            }).fail(function(e) {
                t.closest(".ff-item").find(".switch-response").html('<span style="color:#ff0000"> Post has not been updated successfully.</span>').css("display", "block").fadeOut(5e3)
            })
        })
    })
});