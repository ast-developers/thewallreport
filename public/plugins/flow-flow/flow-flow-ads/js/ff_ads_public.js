//
FlowFlow.ads = {
  init: function ($grid) {
    var opts = $grid.data('opts');
    var $items = $grid.find('.ff-ad');
    this.trackActions($grid);
    this.adjustAdItems(opts, $items);
    this.addLabels($items);
    this.attachEvents($grid);
    this.handleBlocker($grid, opts);
  },
  trackActions: function ($grid) {
    var self = this;
    var cancelTimeout;

    $grid.on('click', '.ff-ad a:not(.ff-ad-cta a), .ff-ad-cta', function(e){
      var $t = jQuery(this), url, isBlank;
      var $a;
      var deferred;
      var parent;
      $a = $t.is('a') ? $t : (parent = true) && $t.find('a');
      url = $a.attr('href');
      isBlank = $a.attr('target') === '_blank';
      if (url) {
        if (cancelTimeout) return false;
        cancelTimeout = setTimeout(function(){
          cancelTimeout = null // self-destruct
        }, 400)
        deferred = jQuery.post(FlowFlowOpts.ajaxurl, {
          'action'  : 'flow_flow_ad_action',
          'status'  : 'click',
          'id' : $t.closest('.ff-item').attr('post-id')
        });
        jQuery.when( deferred ).always(function(data) {
          if (!isBlank) {
            location.href = url;
          }
        })
        if (!isBlank) {
          return false; // cancel default action to have time for tracking
        }

        if (parent && e.target === this) {
          self.fireClick($a.get(0))
        }
      }

    });

    $grid.on('click', '.ff-ad-link', function (e) {
      var $t = jQuery(e.target);
      var isBtn = $t.is('.ff-ad-cta') || $t.parent().is('.ff-ad-cta');
      if ($t.is('.ff-link')) {
        return false;
      } else if (!$t.is('a') && !isBtn){
        self.fireClick(jQuery(e.currentTarget).find('.ff-link').get(0))
      }
    })
  },
  adjustAdItems: function (opts, $items) {
    var style;
    var isFlatGrid = opts.layout === 'grid' && opts.theme === 'flat';
    if (isFlatGrid) {
      style = opts['gf-style'];
      $items.each(function(i,el){
        var $el = jQuery(el);
        var $inner = $el.find('.picture-item__inner');
        var $first = $el.find('.ff-content').children().first();

        if ($first.is('.ff-img-holder')) $inner.prepend($first);
      })
    }

    //debugger
  },
  fireClick: function (node){
    if ( document.createEvent ) {
      var evt = document.createEvent('MouseEvents');
      evt.initEvent('click', false, true);
      node.dispatchEvent(evt);
    } else if( document.createEventObject ) {
      node.fireEvent('onclick') ;
    } else if (typeof node.onclick == 'function' ) {
      node.onclick();
    }
  },
  attachEvents: function ($grid) {
    var self = this;
    $grid.on('loaded_more', function(e, data){
      self.addLabels(data.items);
    })
  },
  addLabels: function ($items) {
   $items.each(function(){
     var $t = jQuery(this);
     var data, txt, col;
     data = $t.data('label');
     if (data) {
       data = data.split(';');
       $t.find('.picture-item__inner').prepend('<div class="ff-item__label" style="background-color:' + data[1] + '">' + data[0] + '</div>')
     }
   })
  },
  handleBlocker: function ($grid) {
      var test = document.createElement('div');
      test.innerHTML = '&nbsp;';
      test.className = 'adsbox';
      document.body.appendChild(test);


      window.setTimeout(function() {
          if (test.offsetHeight === 0) {
              var opts = $grid.data('opts');
              $grid.addClass('ff-block-enabled');
              if ($grid.data('shuffle')) $grid.data('shuffle').layout();
          }
          test.remove();
      }, 100);
  }
}
