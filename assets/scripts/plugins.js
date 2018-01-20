// Avoid `console` errors in browsers that lack a console.
(function () {
  var method
  var noop = function () {}
  var methods = [
    'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
    'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
    'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
    'timeline', 'timelineEnd', 'timeStamp', 'trace', 'warn'
  ]
  var length = methods.length
  var console = (window.console = window.console || {})

  while (length--) {
    method = methods[length]

        // Only stub undefined methods.
    if (!console[method]) {
      console[method] = noop
    }
  }
}())

// Place any jQuery/helper plugins in here.

function isIE () { // eslint-disable-line
  var ie10 = window.navigator.msPointerEnabled
  if (ie10) { $('html').addClass('ie') }
  return (ie10) ? ie10 : $('html').hasClass('ie9')
}

function getImages ($el) {
  var images = []

  $el.find('*:not(script)').each(function () {
    var url = ''
    if ($(this).css('background-image').indexOf('none') == -1 && $(this).css('background-image').indexOf('-gradient') == -1) {
      url = $(this).css('background-image')
      if (url.indexOf('url') != -1) {
        var temp = url.match(/url\((.*?).*\)/)// /url\((.*?)\)/
        url = temp[1].replace(/\"/g, '')
      }
    } // else if ($(this).get(0).nodeName.toLowerCase() == 'img' && typeof($(this).attr('src')) != 'undefined') {
        //  url = $(this).attr('src');
        // }
    if (url.length > 0) {
      if (url.indexOf('http://') == -1) { url = BASE_URL + '/' + url }
      images.push(url)
    }
  })

  $el.find('img').each(function () {
    var url = ''
    if (typeof ($(this).attr('src')) !== 'undefined') {
      url = $(this).attr('src')
    }
    if (url.length > 0) {
      if (url.indexOf('http://') == -1) { url = BASE_URL + '/' + url }
      images.push(url)
    }
  })

  return images
}

/*
 * debouncedresize: special jQuery event that happens once after a window resize
 *
 * latest version and complete README available on Github:
 * https://github.com/louisremi/jquery-smartresize
 *
 * Copyright 2012 @louis_remi
 * Licensed under the MIT license.
 *
 * This saved you an hour of work?
 * Send me music http://www.amazon.co.uk/wishlist/HNTU0468LQON
 */
(function ($) {
  var $event = $.event,
    $special,
    resizeTimeout

  $special = $event.special.debouncedresize = {
    setup: function () {
      $(this).on('resize', $special.handler)
    },
    teardown: function () {
      $(this).off('resize', $special.handler)
    },
    handler: function (event, execAsap) {
        // Save the context
      var context = this,
        args = arguments,
        dispatch = function () {
                // set correct event type
          event.type = 'debouncedresize'
          $event.dispatch.apply(context, args)
        }

      if (resizeTimeout) {
        clearTimeout(resizeTimeout)
      }

      execAsap ?
            dispatch() :
            resizeTimeout = setTimeout(dispatch, $special.threshold)
    },
    threshold: 150
  }
})(jQuery)
