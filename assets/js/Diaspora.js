/*
 * Diaspora
 * @author LoeiFy
 * @url http://lorem.in
 */

let Home = location.href,
    Pages = LocalConst.MAX_PAGES,
    xhr,
    xhrUrl = '',
    scrollFunction,
    newCommentIndex = 1;

let Diaspora = {

    L: function (url, f, err) {
        if (url == xhrUrl) {
            return false
        }

        xhrUrl = url;

        if (xhr) {
            xhr.abort()
        }

        xhr = $.ajax({
            type: 'GET',
            url: url,
            timeout: 10000,
            success: function (data) {
                f(data)
                xhrUrl = '';
            },
            error: function (a, b, c) {
                if (b == 'abort') {
                    err && err()
                } else {
                    window.location.href = url
                }
                xhrUrl = '';
            }
        })
    },

    P: function () {
        return !!('ontouchstart' in window);
    },

    PS: function () {
        if (!(window.history && history.pushState)) return;

        history.replaceState({ u: Home, t: document.title }, document.title, Home)

        window.addEventListener('popstate', function (e) {
            let state = e.state;

            if (!state) return;

            document.title = state.t;

            if (state.u == Home) {
                $('#preview').css('position', 'fixed')
                setTimeout(function () {
                    $('#preview').removeClass('show').addClass('trans')
                    $('#container').show()
                    window.scrollTo(0, parseInt($('#container').data('scroll')))
                    setTimeout(function () {
                        $('#preview').html('')
                        $(window).trigger('resize')
                    }, 300)
                }, 0)
            } else {
                Diaspora.loading()

                Diaspora.L(state.u, function (data) {

                    document.title = state.t;

                    $('#preview').html($(data).filter('#single'));

                    Diaspora.preview();

                    setTimeout(function () {
                        Diaspora.player(state.d);
                    }, 0);
                })
            }

        })
    },

    HS: function (tag, flag) {
        let id = tag.data('id') || 0,
            url = tag.attr('href'),
            title = tag.attr('title') || tag.text();

        if (!$('#preview').length || !(window.history && history.pushState)) location.href = url;

        Diaspora.loading()

        let state = { d: id, t: title, u: url };

        Diaspora.L(url, function (data) {

            if (!$(data).filter('#single').length) {
                location.href = url;
                return
            }

            switch (flag) {

                case 'push':
                    history.pushState(state, title, url)
                    break;

                case 'replace':
                    history.replaceState(state, title, url)
                    break;

            }

            document.title = title;

            $('#preview').html($(data).filter('#single'))

            switch (flag) {

                case 'push':
                    Diaspora.preview()
                    break;

                case 'replace':
                    window.scrollTo(0, 0)
                    Diaspora.loaded()
                    break;
            }

            setTimeout(function () {
                if (!id) id = $('.icon-play').data('id');
                Diaspora.player(id)

                // get download link
                $('.content img').each(function () {
                    if ($(this).attr('src').indexOf('/uploads/2014/downloading.png') > -1) {
                        $(this).hide()
                        $('.downloadlink').attr('href', $(this).parent().attr('href'))
                    }
                })

                if (flag == 'replace') {
                    $('#top').show()
                }
            }, 0)

        })
    },

    preview: function () {
        setTimeout(function () {
            $('#preview').addClass('show')
            $('#container').data('scroll', window.scrollY)
            setTimeout(function () {
                $('#container').hide()
                setTimeout(function () {
                    $('#preview').css({
                        'position': 'static',
                        'overflow-y': 'auto'
                    }).removeClass('trans')
                    $('#top').show()

                    Diaspora.loaded()
                }, 500)
            }, 300)
        }, 0)
    },

    player: function (id) {
        let p = $('#audio-' + id + '-1');

        if (!p.length) {
            $('.icon-play').css({
                'color': '#dedede',
                'cursor': 'not-allowed'
            })
            return
        }

        if (p.eq(0).data("autoplay") == true) {
            p[0].play();
        }

        p.on({
            'timeupdate': function () {
                $('.bar').css('width', p[0].currentTime / p[0].duration * 100 + '%')
            },
            'ended': function () {
                $('.icon-pause').removeClass('icon-pause').addClass('icon-play')
            },
            'playing': function () {
                $('.icon-play').removeClass('icon-play').addClass('icon-pause')
            }
        })
    },

    loading: function () {
        let w = window.innerWidth;
        let css = '<style class="loaderstyle" id="loaderstyle' + w + '">' +
            '@-moz-keyframes loader' + w + '{100%{background-position:' + w + 'px 0}}' +
            '@-webkit-keyframes loader' + w + '{100%{background-position:' + w + 'px 0}}' +
            '.loader' + w + '{-webkit-animation:loader' + w + ' 3s linear infinite;-moz-animation:loader' + w + ' 3s linear infinite;}' +
            '</style>';
        $('.loaderstyle').remove()
        $('head').append(css)

        $('#loader').removeClass().addClass('loader' + w).show()
    },

    loaded: function () {
        $('#loader').removeClass().hide()
    },

    F: function (id, w, h) {
        let _height = $(id).parent().height(),
            _width = $(id).parent().width(),
            ratio = h / w;

        if (_height / _width > ratio) {
            id.style.height = _height + 'px';
            id.style.width = _height / ratio + 'px';
        } else {
            id.style.width = _width + 'px';
            id.style.height = _width * ratio + 'px';
        }

        id.style.left = (_width - parseInt(id.style.width)) / 2 + 'px';
        id.style.top = (_height - parseInt(id.style.height)) / 2 + 'px';
    },

    loadDisqus: function () {
        let disqus_title = $('.comment-wrap').data('title'),
            disqus_url = $('.comment-wrap').data('url'),
            disqus_identifier = $('.comment-wrap').data('identifier'),
            disqus_load = false;

        if (!disqus_load) {
            let dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
            dsq.src = '//' + Page.DISQUS_SHORT_NAME + '.disqus.com/embed.js'; dsq.setAttribute('data-timestamp', +new Date());
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);

            $('.loadDisqus').remove();
            $(window).off("scroll", scrollFunction);
        }
    },

    setContent: function (id) {
        $elem = $('.content');

        if ($elem.length) {
            if (localStorage.getItem('isLike-' + id) == 1) {
                if ($('.likeThis').parents().is('.like-icon')) $('.likeThis').addClass('active');
            }

            window.onload = function () {
                Diaspora.bindAjaxComment();
            }
        }
    },

    getHitokoto: function () {
        $.ajax({
            type: "GET",
            url: "https://api.rua.dev/hitokoto",
            dataType: "json",
            cache: false,
            success: function (t) {
                if (t.data) {
                    $("#hitokoto").html(t.data.hitokoto)
                } else {
                    $("#hitokoto").html("读取数据失败了的说…… _(:з」∠)_")
                }
            }
        })
    },

    bindAjaxComment: function () {
        let htmlEncode = function (value) {
            return $('<div/>').text(value).html();
        };
        let loadCommentAvatar = function (avatar) {
            let src = avatar.attr("data-src");
            let type = avatar.attr("data-type") || 0;

            avatar.attr('data-src', '');

            let loadAvatar = function (url) {
                let img = new Image();
                img.src = url;
                img.onload = function () {
                    avatar.attr('src', url)
                }
            };

            if (type === 'json') {
                $.getJSON(src, null, function (data) {
                    loadAvatar(data.url);
                })
            } else {
                loadAvatar(src)
            }
        };
        let trim = function (str) {
            return $.trim(str);
        };
        $('#commentform').off('submit').on('submit', function (e) {
            let form = $(this);
            let submit = form.find('#submit');

            let respondDiv = form.parents('.comment-respond');
            let respondParent = respondDiv.parent();

            let author = form.find('#author').val();
            let website = form.find('#url').val();
            let commentText = form.find('#textarea').val();

            if (commentText === null || trim(commentText) === '') {
                alert(submit.attr('data-empty-comment'));
                return false;
            }

            if (form.find('#author').length === 0 && form.find('#url').length === 0) {
                author = $('a[href$="profile.php"]').text();
                website = document.location.origin;
            }

            submit.attr('disabled', 'disabled').val(submit.attr('data-posting'));

            let newCommentId = 'newComment-' + newCommentIndex;
            newCommentIndex++;
            let newComment =
                '<li id="' + newCommentId + '" class="comment">' +
                '<div id="div-' + newCommentId + '" class="comment-body">' +
                '<div class="comment-author vcard">' +
                '<img class="avatar" src="' + window.location.origin + '/usr/themes/diaspora/assets/images/spinner.svg" alt="' + author + '" width="40" height="40">' +
                '<cite class="fn" itemprop="name"><a href="' + website + '" rel="external nofollow" target="_blank">' + author + '</a></cite>' +
                '<span class="says">说道：</span>' +
                '</div>' +
                '<div class="comment-meta commentmetadata">' +
                '<a href="javascript:void(0)"><time itemprop="commentTime" datetime="' + submit.attr('data-now') + '">' + submit.attr('data-now') + '</time></a>' +
                '<span id="' + newCommentId + '-status" class="comment-posting">' + submit.attr('data-posting') + '</span>' +
                '</div>' +
                '<div>' +
                '<p>' + htmlEncode(commentText) + '</p>' +
                '</div>' +
                '</li>';
            let added = false;
            let firstComment = false;
            let commentOrderDESC = true; // LocalConst.COMMENTS_ORDER === 'DESC'
            if (respondParent.is('div') && respondParent.children('#comments')) {
                if (respondParent.children('#comments').children('.comment-list').length > 0) {
                    if (commentOrderDESC) {
                        respondParent.children('#comments').children('.comment-list').first().prepend(newComment);
                    } else {
                        respondParent.children('#comments').children('.comment-list').first().append(newComment);
                    }
                } else {
                    // 文章的第一条评论
                    /*respondParent.append('<div class="comment-separator">' +
                        '<div class="comment-tab-current">' +
                        '<span class="comment-num">已有 1 条评论</span>' +
                        '</div>' +
                        '</div>');*/
                    respondParent.children('#comments').append('<ol class="comment-list">' + newComment + '</ol>');
                    firstComment = true;
                }
                added = true;
            } else if (respondParent.is('li') && respondParent.hasClass('comment')) {
                if (respondParent.parent().parent().is('div') && respondParent.parent().parent().attr('id') === 'comments') {
                    // 评论主评论，加在主评论的子列表中
                    console.log(respondParent.children('.children'));
                    if (respondParent.children('.children').first().children('.comment-list').length > 0) {
                        respondParent.children('.children').first().children('.comment-list').first().append(newComment);
                    } else {
                        let commentList = '<div class="children" itemprop="discusses"><ol class="comment-list">'
                            + newComment + '</ol></div>';
                        respondParent.append(commentList);
                    }
                } else {
                    // 评论子评论，加在子评论列表最后
                    respondParent.children('.children').first().children('.comment-list').first().append(newComment);
                }
                added = true;
            }
            if (added) {
                try {
                    let offset = $('#' + newCommentId).offset();
                    if (typeof offset !== 'undefined') {
                        $('html,body').animate({ scrollTop: $('.comment-respond').offset().top - 100 }, 1000);
                    }
                } catch (e) {
                    console.error(e);
                }
                let error = function () {
                    try {
                        if (firstComment) {
                            // respondParent.children('.comment-separator').first().remove();
                            respondParent.children('.comment-list').first().remove();
                        } else {
                            $('#' + newCommentId).remove();
                        }
                        let offset = $('#comment-form').offset();
                        if (typeof offset !== 'undefined') {
                            $('html,body').animate({ scrollTop: $('.comment-respond').offset().top - 100 }, 1000);
                        }
                    } catch (e) {
                        console.error(e);
                    }
                };
                try {
                    $.ajax({
                        url: form.attr('action'),
                        type: form.attr('method'),
                        data: form.serializeArray(),
                        success: function (data) {
                            if (typeof data === 'undefined') {
                                window.location.reload();
                                return false;
                            }
                            if (data.indexOf('<title>' + 'Error</title>') > 0) {
                                let el = $('<div></div>');
                                el.html(data);
                                alert(trim($('.container', el).text()));
                                error();
                            } else {
                                form.find('#textarea').val('');
                                if (typeof (TypechoComment) !== 'undefined') {
                                    TypechoComment.cancelReply();
                                }
                                let commentList = data.match(/id="comment-\d+"/g);
                                if (commentList === null || commentList.length === 0) {
                                    window.location.reload();
                                } else {
                                    let new_id = commentList.join().match(/\d+/g).sort(function (a, b) {
                                        return a - b
                                    }).pop();
                                    let el = $('<div></div>');
                                    el.html(data);
                                    let resultElement = $('#comment-' + new_id, el);
                                    if (trim(resultElement.children('.comment-author').find('cite').text()) === trim(author)) {
                                        resultElement.children('.comment-meta').append('<span id="comment-' + new_id + '-status" class="comment-posted">' + submit.attr('data-posted') + '</span>');
                                        let content = resultElement.children('.comment-content');
                                        content.html(content.html());
                                        $('#' + newCommentId).replaceWith(resultElement);
                                        $('#comment-' + new_id + ' img.avatar[data-src]').each(function () {
                                            let avatar = $(this);
                                            loadCommentAvatar(avatar);
                                        });
                                    } else {
                                        $('#' + newCommentId + "-status").text(submit.attr('data-posted')).removeClass('comment-posting').addClass('comment-posted');
                                    }
                                }
                            }
                            submit.removeAttr('disabled').val(submit.attr('data-init'));
                        },
                        error: function (e) {
                            console.error(e);
                            error();
                            submit.removeAttr('disabled').val(submit.attr('data-init'));
                            // return true;
                        }
                    });
                    return false;
                } catch (e) {
                    console.error(e);
                }
            }
            return false;
        });
    }
}

$(function () {

    if (Diaspora.P()) {
        $('body').addClass('touch')
    }

    if ($('#preview').length) {

        let cover = {};
        cover.t = $('#cover');
        cover.w = cover.t.attr('width');
        cover.h = cover.t.attr('height');

        ; (cover.o = function () {
            $('#mark').height(window.innerHeight)
        })();

        if (cover.t.prop('complete')) {
            // why setTimeout ?
            setTimeout(function () { cover.t.load() }, 0)
        }

        cover.t.on('load', function () {

            ; (cover.f = function () {

                let _w = $('#mark').width(), _h = $('#mark').height(), x, y, i, e;

                e = (_w >= 1000 || _h >= 1000) ? 1000 : 500;

                if (_w >= _h) {
                    i = _w / e * 50;
                    y = i;
                    x = i * _w / _h;
                } else {
                    i = _h / e * 50;
                    x = i;
                    y = i * _h / _w;
                }

                $('.layer').css({
                    'width': _w + x,
                    'height': _h + y,
                    'marginLeft': - 0.5 * x,
                    'marginTop': - 0.5 * y
                })

                if (!cover.w) {
                    cover.w = cover.t.width();
                    cover.h = cover.t.height();
                }

                Diaspora.F($('#cover')[0], cover.w, cover.h)

            })();

            setTimeout(function () {
                $('html, body').removeClass('loading')
            }, 1000)

            $('#mark').parallax()

            let vibrant = new Vibrant(cover.t[0]);
            let swatches = vibrant.swatches()

            if (swatches['DarkVibrant']) {
                $('#vibrant polygon').css('fill', swatches['DarkVibrant'].getHex())
                $('#vibrant div').css('background-color', swatches['DarkVibrant'].getHex())
            }
            if (swatches['Vibrant']) {
                $('.icon-menu').css('color', swatches['Vibrant'].getHex())
            }

        })

        if (!cover.t.attr('src')) {
            alert('Please set the post thumbnail')
        }

        $('#preview').css('min-height', window.innerHeight)

        Diaspora.PS()

        $('.pview a').addClass('pviewa')

        let T;
        $(window).on('resize', function () {
            clearTimeout(T)

            T = setTimeout(function () {
                if (!Diaspora.P() && location.href == Home) {
                    cover.o()
                    cover.f()
                }

                if ($('#loader').attr('class')) {
                    Diaspora.loading()
                }
            }, 500)
        })

    } else {

        $('#single').css('min-height', window.innerHeight)
        $('html, body').removeClass('loading')

        window.addEventListener('popstate', function (e) {
            if (e.state) location.href = e.state.u;
        })

        Diaspora.player($('.icon-play').data('id'))
        Diaspora.setContent($('#single').data('id'))

        $('.icon-icon, .image-icon').attr('href', '/')

        // get download link
        /*$('.content img').each(function() {
            if ($(this).attr('src').indexOf('/uploads/2014/downloading.png') > -1) {
                $(this).hide()
                $('.downloadlink').attr('href', $(this).parent().attr('href')).css('display', 'block')
            }
        })*/

        $('#top').show()

    }

    $(window).on('scroll', function () {
        if ($('.scrollbar').length && !Diaspora.P() && !$('.icon-images').hasClass('active')) {
            let st = $(window).scrollTop(),
                ct = $('.content').height();

            if (st > ct) {
                st = ct
            }

            $('.scrollbar').width((50 + st) / ct * 100 + '%')

            if (st > 80 && window.innerWidth > 800) {
                $('.subtitle').fadeIn()
            } else {
                $('.subtitle').fadeOut()
            }
        }
    })

    $(window).on('scroll', scrollFunction = function (e) {
        if ($('#single').length) {
            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
                // Diaspora.loadDisqus ();
            }
        }
    })

    $(window).on('touchmove', function (e) {
        if ($('body').hasClass('mu')) {
            e.preventDefault()
        }
    })

    $('body').on('click', function (e) {

        let tag = $(e.target).attr('class') || '',
            rel = $(e.target).attr('rel') || '';

        if (!tag && !rel) return;

        switch (true) {

            // nav menu
            case (tag.indexOf('switchmenu') != -1):
                Diaspora.getHitokoto()
                window.scrollTo(0, 0)
                $('html, body').toggleClass('mu')
                break;

            // next page
            case (tag.indexOf('more') != -1):
                tag = $('.more');

                if (tag.data('status') == 'loading') {
                    return false
                }

                let num = parseInt(tag.data('page')) || 1;

                if (num == 1) {
                    tag.data('page', 1)
                }

                if (num >= Pages) {
                    return
                }

                tag.html('加载中..').data('status', 'loading')
                Diaspora.loading()

                Diaspora.L(tag.attr('href'), function (data) {
                    let link = $(data).find('.more').attr('href');
                    if (link != undefined) {
                        tag.attr('href', link).html('加载更多').data('status', 'loaded')
                        tag.data('page', parseInt(tag.data('page')) + 1)
                    } else {
                        $('#pager').remove()
                    }

                    let tempScrollTop = $(window).scrollTop();
                    $('#primary').append($(data).find('.post'))
                    $(window).scrollTop(tempScrollTop);
                    Diaspora.loaded()
                    $('html,body').animate({ scrollTop: tempScrollTop + 400 }, 500);
                }, function () {
                    tag.html('加载更多').data('status', 'loaded')
                })

                return false;
                break;

            // post images
            case (tag.indexOf('icon-images') != -1):
                window.scrollTo(0, 0)

                let d = $('.icon-images');

                if (d.data('status') == 'loading') {
                    return false
                }

                if (d.hasClass('active')) {
                    d.removeClass('active')

                    $('.article').css('height', 'auto')
                    $('.section').css('left', '-100%')
                    setTimeout(function () {
                        $('.images').data('height', $('.images').height()).css('height', '0')
                    }, 0)
                } else {
                    d.addClass('active')

                    $('.images').css('height', $('.images').data('height'))

                    if ($('.icon-images').hasClass('tg')) {
                        $('.section').css('left', 0)

                        setTimeout(function () { $('.article').css('height', '0') }, 0)
                    } else {
                        if (!(Diaspora.P() && window.innerWidth < 700)) {
                            $('.zoom').Chocolat()
                        }

                        Diaspora.loading()
                        d.data('status', 'loading')

                        let m = 5, r = 120;
                        if (Diaspora.P() && window.innerWidth < 600) {
                            m = 1;
                            r = 80;
                        }
                        $('#jg').justifiedGallery({
                            margins: m,
                            rowHeight: r,
                        }).on('jg.complete', function () {
                            $('.section').css('left', 0)
                            $('.icon-images').addClass('tg')

                            d.data('status', '')
                            Diaspora.loaded()
                            setTimeout(function () { $('.article').css('height', '0') }, 0)
                        })
                    }

                }
                break;

            // qrcode
            case (tag.indexOf('icon-wechat') != -1):
                if ($('.icon-wechat').hasClass('tg')) {
                    $('#qr').toggle()
                } else {
                    $('.icon-wechat').addClass('tg')
                    $('#qr').qrcode({ width: 128, height: 128, text: location.href }).toggle()
                }
                break;

            // audio play
            case (tag.indexOf('icon-play') != -1):
                $('#audio-' + $('.icon-play').data('id') + '-1')[0].play()
                $('.icon-play').removeClass('icon-play').addClass('icon-pause')
                break;

            // audio pause
            case (tag.indexOf('icon-pause') != -1):
                $('#audio-' + $('.icon-pause').data('id') + '-1')[0].pause()
                $('.icon-pause').removeClass('icon-pause').addClass('icon-play')
                break;

            // post like
            case (tag.indexOf('icon-like') != -1):
                let t = $(e.target).parent(),
                    classes = t.attr('class'),
                    id = t.attr('id').split('like-');

                if (t.prev().hasClass('icon-view')) return;

                classes = classes.split(' ');
                if (classes[1] == 'active') return;

                $.ajax({
                    type: 'POST',
                    url: window.location.origin + '/action/like',
                    data: {
                        cid: id[1]
                    },
                    dataType: 'json',
                    success: function (ret) {
                        let text = $('#like-' + id[1]).html();

                        localStorage.setItem('isLike-' + id[1], 1);
                        t.addClass('active');
                        $('.count').html(ret.data.count);
                    }
                })
                break;

            // load Disqus
            case (tag.indexOf('loadDisqus') != -1):
                // Diaspora.loadDisqus ()
                break;

            // history state
            case (tag.indexOf('cover') != -1):
                Diaspora.HS($(e.target).parent(), 'push')
                return false;
                break;

            // history state
            case (tag.indexOf('posttitle') != -1):
                Diaspora.HS($(e.target), 'push')
                return false;
                break;

            // relate post
            case (tag.indexOf('relatea') != -1):
                Diaspora.HS($(e.target), 'replace')
                return false;
                break;

            // relate post
            case (tag.indexOf('relateimg') != -1):
                Diaspora.HS($(e.target).parent(), 'replace')
                return false;
                break;

            // prev, next post
            case (rel == 'prev' || rel == 'next'):
                if (rel == 'prev') {
                    let t = $('#prev_next a')[0].text
                } else {
                    let t = $('#prev_next a')[1].text
                }
                $(e.target).attr('title', t)

                Diaspora.HS($(e.target), 'replace')
                return false;
                break;

            // quick view
            case (tag.indexOf('pviewa') != -1):
                $('body').removeClass('mu')

                setTimeout(function () {
                    Diaspora.HS($(e.target), 'push')
                }, 300)

                return false;
                break;

            default:
                return;
                break;
        }

    });
    // console.log("%c Github %c","background:#24272A; color:#ffffff","","https://github.com/LoeiFy/Diaspora")
    console.log("\n %c Diaspora For Typecho %c Jin < https://jcl.moe/ > \n", "color:rgb(255, 242, 242);background:rgb(244, 164, 164);padding:5px 0;border-radius:3px 0 0 3px;", "color:rgb(244, 164, 164);background:rgb(255, 242, 242);padding:5px 0;border-radius:0 3px 3px 0;")

});