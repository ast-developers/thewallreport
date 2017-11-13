var CampaignApp = (function($){
  var $ = jQuery;

  // campaigns model, view and collection declaring
  var CampaignModel;
  var CampaignModelsCollection;
  var CampaignView;

  // rows model, view and collection declaring
  var CampaignRowModel;
  var CampaignRowModelsCollection;
  var CampaignRowView;

  // instances declaring
  var Campaigns;
  var campaignRowModels;
  var campaignModels;
  var campaignElements;

  var templates = {
    'campaignRow' : '<td class="controls"><div class="loader-wrapper"><div class="throbber-loader"></div></div><i class="flaticon-pen"></i> <i class="flaticon-copy"></i> <i class="flaticon-trash"></i></td> <td class="td-status"><span class="status-light-<%= readableStatus %>"></span></td><td class="td-name">Unnamed</td> <td class="td-start">-</td> <td class="td-end">-</td> <td class="td-views">0</td> <td class="td-clicks">0</td> <td class="td-conversion">0%</td>',
    'campaignRowEmpty' : '<tr class="empty-row"><td class="empty-cell" colspan="8">Please create at least one campaign</td></tr>',
    'campaign' : '<div class="section"><h1><%= header %><span class="admin-button grey-button button-go-back">Back to list</span></h1><dl class="section-settings"><dt class="vert-aligned">Campaign Name</dt><dd><input type="text" name="campaign-<%= id %>-name" placeholder="Enter name of your campaign"></dd><dt class="vert-aligned multiline">Delivery Period<p class="desc">Leave blank to keep your campaign working only from or till some date or always working if both are empty.</p></dt><dd class="date-pickers"><label>Starts on: <input type="text" data-role="start" data-date-format="mm/dd/yy" class="custom-datepicker" name="campaign-<%= id %>-start"></label><label>Ends on: <input type="text" data-role="end" data-date-format="mm/dd/yy" class="custom-datepicker" name="campaign-<%= id %>-end"></label></dd><dt class="vert-aligned">Current Status</dt><dd class="text-def status-text"><%= readableStatus %></dd></dl><span id="campaign-name-sbmt-<%= id %>" class="admin-button green-button submit-button">Save Changes</span><span id="campaign-publish-<%= id %>" class="admin-button blue-button status-button current-status-<%= status %>"><%= nextReadableStatus %></span></div>'
                      + '<div class="section campaign-streams"><h1 class="desc-following"><span>Connected Streams</span></h1><p class="desc">You can preview how campaign looks in stream if you click on stream button.</p><div class="campaign-streams__list"></div><span class="campaign-streams__add">+ Connect campaign to stream</span><div class="campaign-streams__select"><div class="select-wrapper"><select></select></div><span class="campaign-streams__btn campaign-streams__ok"><i class="flaticon-plus"></i></span><span class="campaign-streams__btn campaign-streams__close"><i class="flaticon-cross"></i></span></div></div>'
                      + '<div class="section campaign-elements"><h1 class="desc-following"><span>Campaign Elements</span><span class="admin-button green-button button-add">Add element</span></h1><p class="desc">Drag elements in priority you want them to have. <a href="" class="help_link">Click here for builder how-to</a></p><div class="campaign-elements__list ff-transition--fast"></div><span id="campaign-elements-sbmt-<%= id %>" class="admin-button green-button submit-button">Save Changes</span></div>'
                      + '<div class="section campaign-display"><h1 class="desc-following"><span>Display Settings</span></h1><p class="desc">Setup frequency and order to display your Elements.</p><dl class="section-settings section-compact"><dt class="dt-oneline"><span class="valign">First ad starts at</span></dt><dd><input id="campaign-<%= id %>-firstAdIndex" class="short" type="text" name="campaign-<%= id %>-firstAdIndex" placeholder=""> position in grid</dd><dt class="dt-oneline"><span class="valign">Show ad after each</span></dt><dd><input class="short" id="campaign-<%= id %>-adsDistrubution" type="text" name="campaign-<%= id %>-adsDistrubution" placeholder=""> posts</dd><dt><span class="valign">Randomize order</span></dt><dd><label for="campaign-<%= id %>-randomize"><input id="campaign-<%= id %>-randomize" class="switcher" type="checkbox" name="campaign-<%= id %>-randomize" value="yep"/><div><div></div></div></label></dd></dl><span id="campaign-display-sbmt-<%= id %>" class="admin-button green-button submit-button">Save Changes</span></div>'
                      + '<div class="section campaign-adsense"><h1 class="desc-following"><span>AdSense Settings</span></h1><p class="desc">Here are settings related to AdSense usage in campaign. <a href="http://flow.looks-awesome.com/wp-content/uploads/2016/02/adsense-ID.png" target="_blank">Where to find?</a></p><dl class="section-settings section-compact"><dt class="dt-oneline"><span class="valign">AdSense client ID</span></dt><dd><input id="campaign-<%= id %>-adsenseClient" class="" type="text" name="campaign-<%= id %>-adsenseClient" placeholder=""></dd></dl><span id="campaign-display-sbmt-<%= id %>" class="admin-button green-button submit-button">Save Changes</span></div>'
/*                      + '<div class="section campaign-adblock"><h1 class="desc-following"><span>AdBlock</span></h1><p class="desc">When Adblock software is detected you can display placeholder message instead of empty space</p><dl class="section-settings section-compact"><dt class="dt-oneline"><span class="valign">Placeholder message</span></dt><dd><input id="campaign-<%= id %>-adblock" class="" type="text" name="campaign-<%= id %>-adblock"></dd></dl><span id="campaign-adblock-sbmt-<%= id %>" class="admin-button green-button submit-button">Save Changes</span></div>' */
                      + '<div class="section campaign-analytics"><h1><span>Elements Analytics</span></h1><table class="campaign-analytics__table"><thead><tr><th class="no-sort"></th><th><span>Element name</span></th><th><span>Views</span></th><th><span>Clicks</span></th><th><span>Conversion</span></th></tr></thead><tbody></tbody></div>',
    'campaignElement' : '<div class="campaign-elements__item ff-template__<%= type %> <%= label %>" data-id="<%= id %>" data-type="<%= type %>"><div class="campaign-elements__topbottom"></div><div class="campaign-elements__leftright"></div><div class="campaign-elements__controls ff-transition--fast"><span class="campaign-elements__drag"></span><span class="campaign-elements__index"></span><span class="campaign-elements__delete"></span><span class="campaign-elements__clone"></span><span class="campaign-elements__edit"></span></div><div class="campaign-elements__label" style="background-color: <%= labelCol %>"><%= labelTxt %></div><div class="campaign-elements__close_editor ff-transition--fast"><i class="flaticon-cross"></i></div><div class="campaign-elements__content" data-editable data-name="campaign-element-<%= id %>" style="background-color: <%= cardBG %>;color: <%= textCol %>"><%= content %></div></div>',
    'analyticsRow' : '<tr><td class="campaign-analytics__image_cell"><%= thumb %></td><td><%= name %></td><td><%= views %></td><td><%= clicks %></td><td><%= conversion %></td></tr>',
    'elementPopup' : '<div class="cd-popup" role="promt"><div class="cd-popup-container"><p>What will it be?</p> <ul class="campaign-elements__types"><li data-type="html">Rich HTML</li><li data-type="js">Plain code</li><li data-type="ad">AdSense</li></ul><a href="#0" class="cd-popup-close img-replace">Close</a></div></div>',
    'elementTemplate' : {
      'html' : '<img src="<%= url %>/css/images/default.png"><p class="campaign-elements__text">You can edit this text if you just click it. You can drag any block inside this card. To drag blocks you need to click and hold until cursor changes.</p><p>You can add images, videos and buttons using floating editor pane.</p>',
      'js' : '<div class="campaign-elements__image campaign-elements__dummy"></div>',
      'ad' : '<div class="campaign-elements__image campaign-elements__dummy"></div>'
    },
    'elementSettings' : {
      'html' : '<div class="campaign-elements__row campaign-elements__switcher"><span>Card enabled?</span><label for="element-<%= id %>-enabled"><input id="element-<%= id %>-enabled" class="switcher" type="checkbox" name="element-<%= id %>-enabled" value="yep"><div><div></div></div></label></div><div class="campaign-elements__row"><input name="element-<%= id %>-name" type="text" placeholder="Element Name"></div><div class="campaign-elements__row"><span>Text color</span><input data-color-format="rgba" class="card-settings__textCol" name="element-<%= id %>-textCol" type="text" value="rgb(48, 50, 51)" tabindex="-1"></div><div class="campaign-elements__row"><span>BG color</span> <input data-color-format="rgba" class="card-settings__cardBG" name="element-<%= id %>-cardBG" type="text" value="rgb(248, 248, 248)" tabindex="-1"></div><div class="campaign-elements__row campaign-elements__switcher"><span>Show label</span><label for="element-<%= id %>-label"><input id="element-<%= id %>-label" class="switcher label-switcher" type="checkbox" name="element-<%= id %>-label" value="yep"><div><div></div></div></label></div><div class="campaign-elements__row label__settings"><span>Label color</span> <input data-color-format="rgba" class="label__input" name="element-<%= id %>-labelCol" type="text" value="rgb(245, 166, 35)" tabindex="-1"></div><div class="campaign-elements__row label__settings"><input name="element-<%= id %>-labelTxt" class="label__input" type="text" placeholder="Label Text"></div><div class="campaign-elements__row">Link to make entire card clickable:</div><div class="campaign-elements__row"><input name="element-<%= id %>-link" class="" type="text" placeholder="Enter URL here"></div><div class="campaign-elements__row"><span class="admin-button green-button">Save Changes</span></div>',
      'js' :   '<div class="campaign-elements__row campaign-elements__switcher"><span>Card enabled?</span><label for="element-<%= id %>-enabled"><input id="element-<%= id %>-enabled" class="switcher" type="checkbox" name="element-<%= id %>-enabled" value="yep"><div><div></div></div></label></div><div class="campaign-elements__row"><input name="element-<%= id %>-name" type="text" placeholder="Element Name"></div><div class="campaign-elements__row"><span>Text color</span><input data-color-format="rgba" class="card-settings__textCol" name="element-<%= id %>-textCol" type="text" value="rgb(48, 50, 51)" tabindex="-1"></div><div class="campaign-elements__row"><span>BG color</span> <input data-color-format="rgba" class="card-settings__cardBG" name="element-<%= id %>-cardBG" type="text" value="rgb(248, 248, 248)" tabindex="-1"></div><div class="campaign-elements__row"><textarea rows="5" name="element-<%= id %>-code" type="text" placeholder="Paste plain code here"></textarea></div><div class="campaign-elements__row"><span>Height (required)</span> <input class="short" name="element-<%= id %>-height" type="text" placeholder=""> px</div><div class="campaign-elements__row campaign-elements__switcher"><span>Show label</span><label for="element-<%= id %>-label"><input id="element-<%= id %>-label" class="switcher label-switcher" type="checkbox" name="element-<%= id %>-label" value="yep"><div><div></div></div></label></div><div class="campaign-elements__row label__settings"><span>Label color</span> <input data-color-format="rgba" class="label__input" name="element-<%= id %>-labelCol" type="text" value="rgb(245, 166, 35)" tabindex="-1"></div><div class="campaign-elements__row label__settings"><input name="element-<%= id %>-labelTxt" class="label__input" type="text" placeholder="Label Text"></div><div class="campaign-elements__row"><span class="admin-button green-button">Save Changes</span></div>',
      'ad' :   '<div class="campaign-elements__row campaign-elements__switcher"><span>Card enabled?</span><label for="element-<%= id %>-enabled"><input id="element-<%= id %>-enabled" class="switcher" type="checkbox" name="element-<%= id %>-enabled" value="yep"><div><div></div></div></label></div><div class="campaign-elements__row"><input name="element-<%= id %>-name" type="text" placeholder="Element Name"></div><div class="campaign-elements__row"><span>BG color</span><input data-color-format="rgba" class="card-settings__cardBG" name="element-<%= id %>-cardBG" type="text" value="rgb(248, 248, 248)" tabindex="-1"></div><div class="campaign-elements__row"><span class="two-liner">Ad Unit ID<br><a target="_blank" href="http://flow.looks-awesome.com/wp-content/uploads/2016/02/adsense-slot.png">Where to find?</a></i></span> <input class="element-input--short" name="element-<%= id %>-slot" type="text" placeholder="Enter ID"></div><div class="campaign-elements__row campaign-elements__switcher"><span>Show label</span><label for="element-<%= id %>-label"><input id="element-<%= id %>-label" class="switcher label-switcher" type="checkbox" name="element-<%= id %>-label" value="yep"><div><div></div></div></label></div><div class="campaign-elements__row label__settings"><span>Label color</span> <input data-color-format="rgba" class="label__input" name="element-<%= id %>-labelCol" type="text" value="rgb(245, 166, 35)" tabindex="-1"></div><div class="campaign-elements__row label__settings"><input name="element-<%= id %>-labelTxt" class="label__input" type="text" placeholder="Label Text"></div><div class="campaign-elements__row"><span class="admin-button green-button">Save Changes</span></div>'
    },
    'help' : {
      'builder' : '<div class="section"><h1 class="desc-following">Builder Tips</h1><p class="desc">Here are some tips how to use builder</p><div class="section__container"><h2>How to add button and link it to URL</h2><p><iframe width="820" height="461" src="https://www.youtube.com/embed/hxWT9Zb2byQ?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe></p><h2>How to change button color and add icon</h2><p><iframe width="820" height="461" src="https://www.youtube.com/embed/_-qIqF4Enxg?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe></p></div></div>'
    }
  }

  var sessionStorage = window.sessionStorage || {getItem: function(){return false}, setItem: function(){}};

  var transitionEnd = window.transitionEnd;

  var iterator = 1, elemIterator = 1;

  var colorPickerOpts = {
    previewontriggerelement: true,
    previewformat: 'rgba',
    flat: false,
    color: '#000',
    customswatches: 'card_bg',
    swatches: [
      '#c0392b',
      'a3503c',
      '925873',
      '927758',
      '589272',
      '588c92',
      '2bb1c0',
      '2b8ac0',
      'e96701',
      'c02b74',
      '000000',
      '4C4C4C',
      'CCCCCC',
      'F0F0F0',
      'FFFFFF'
    ],
    order: {
      hsl: 1,
      opacity: 2,
      preview: 3
    },
    onchange: function(container, color) {
      // todo update card
      var $inp = container.data('input');
      $inp.trigger('colorpicker-change');
    }
  };

  var Controller = {
    savedView : sessionStorage.getItem('ff_campaign') || 'list',
    $container : null,
    $list : null,
    $streamsList : null,
    $html : null,
    $overlay : null,
    $previewStyles: null,
    editor: null,
    makeOverlayTo: function (op, classN) {
      this.$html.removeClass('popup_visible');
      this.$overlay[( op === 'show' ? 'add' : 'remove' ) + 'Class'](classN || 'loading');
    },
    init : function () {
      this.$container = $('#campaigns-cont');
      this.$list = this.$container.find('#campaigns-list tbody');
      this.$streamsList = $('#streams-list-section');
      this.$html = $('html');
      this.$overlay = $('#fade-overlay');

      this.attachGlobalEvents();
      this.setupModelsAndViews();

      this.getEditor();

      this.setActivated();

    },

    setupModelsAndViews : function () {

      var self = this;
      for (var i = 0, len = window.ads.length; i < len; i++) {
        campaignRowModels.add(window.ads[i]);
      }

      $('#campaigns-list tbody tr').not('.empty-row').each(function(){
        var $t = $(this);
        var view = new CampaignRowView({model: campaignRowModels.get($t.attr('data-campaign-id')), el: this});
      });

      if (this.savedView !== 'list' && campaignRowModels.get(this.savedView)) {
        this.makeOverlayTo('show', 'loading-copy');
        campaignRowModels.get(this.savedView).view.edit().then(function(){
          var savedScrollState = sessionStorage.getItem('as_scroll');
          var $htmlAndBody = $('html, body');

          if (savedScrollState) {
            $htmlAndBody.scrollTop(savedScrollState);
          }

          self.makeOverlayTo('hide', 'loading-copy');

          setTimeout(function(){

            self.$container.addClass('transition--enabled');

            if (savedScrollState) {
              $htmlAndBody.scrollTop(savedScrollState);
            }

          }, 800);
        });
      } else  {
        this.savedView = 'list';
        this.switchToView('list');
        setTimeout(function(){
          self.$container.addClass('transition--enabled');
        }, 100);
      }
    },

    getEditor: function () {

      // predefined styles
      ContentTools.StylePalette.add([
        new ContentTools.Style('Facebook BG color', 'ct-bg-fb', ['p']),
        new ContentTools.Style('Twitter BG color', 'ct-bg-tw', ['p']),
        new ContentTools.Style('Instagram BG color', 'ct-bg-ig', ['p']),
        new ContentTools.Style('Google BG color', 'ct-bg-gp', ['p']),
        new ContentTools.Style('Youtube BG color', 'ct-bg-yt', ['p']),
        new ContentTools.Style('Pinterest BG color', 'ct-bg-pin', ['p']),
        new ContentTools.Style('Lindedin BG color', 'ct-bg-li', ['p']),
        new ContentTools.Style('Flickr BG color', 'ct-bg-fl', ['p']),
        new ContentTools.Style('Tumblr BG color', 'ct-bg-tu', ['p']),
        new ContentTools.Style('Vimeo BG color', 'ct-bg-vi', ['p']),
        new ContentTools.Style('Wordpress BG color', 'ct-bg-wp', ['p']),
        new ContentTools.Style('Foursquare BG color', 'ct-bg-fs', ['p']),
        new ContentTools.Style('Soundcloud BG color', 'ct-bg-sc', ['p']),
        new ContentTools.Style('Vine BG color', 'ct-bg-vi', ['p']),
        new ContentTools.Style('Dribbble BG color', 'ct-bg-dr', ['p']),
        new ContentTools.Style('RSS BG color', 'ct-bg-rss', ['p'])
      ]);

      this.editor = ContentTools.EditorApp.get();

    },

    initEditor: function (selector) {
      this.editor.init(selector || '.ff-template__html [data-editable]', 'data-name');
    },

    startEditor: function (){
      if (this.editor._state === 'ready') {
        this.editor.start();
        this.editor.$uiEl = $(this.editor._domElement).addClass('ff-transition--fast');
        debugger
        this.hideEditorUI(); // when needed
      }
    },

    hideEditorUI: function () {
      console.log('hide editor');
      var focused = ContentEdit.Root.get().focused();
      if (focused) focused.blur();
      if (this.editor.$uiEl) this.editor.$uiEl.addClass('ff-transition__fadeOut');
    },

    showEditorUI: function () {
      console.log('show editor')
      if (this.editor.$uiEl) this.editor.$uiEl.removeClass('ff-transition__fadeOut');
    },

    attachGlobalEvents : function () {

      var self = this;

      this.$container.find('.button-add').on('click', function(){
        var model, view;

        if (!self.$container.find('#campaign-view-new').length) {
          model = new CampaignModel();
          view = new CampaignView({model: model});
          campaignModels.add(model);
          self.$container.append(view.$el);

          view.$el.find('.campaign-elements__list').imagesLoaded( function() {
            Controller.initEditor();
            Controller.startEditor();
          });

          view.saveViaAjax();

        }

        self.switchToView('new');
      });

      $(document).on('section-toggle', function(e, id) {
        self.setHeight(id.replace('c', ''));
      });

      this.$container.on('click', '.ff-ad-cta a', function(e) {
        e.preventDefault();
      });
    },

    switchToView : function (view) {

      var self = this;
      this.$container.find('.view-visible').removeClass('view-visible');
      this.setHeight(view);

      setTimeout(function(){
        if (view === 'list') {
          self.$container.find('#campaigns-' + view).addClass('view-visible');
        } else {
          self.$container.find('#campaign-view-' + view).addClass('view-visible');
        }
      },0)

      sessionStorage.setItem('ff_campaign', view);
    },

    setHeight : function (id) {
      var self = this;

      var heights = [];
      var maxH;
      //
      if (id && !isNaN(parseInt(id))) {
        self.$container.find('#campaign-view-' + id + ', #campaigns-list').each(function(){
          heights.push($(this).outerHeight());
        });
      } else {
        self.$container.find('.section-stream[data-view-mode="streams-update"], #campaigns-list').each(function(){
          heights.push($(this).outerHeight());
        });
      }

      maxH = Math.max.apply(Math, heights);
      self.$container.css('minHeight', maxH);
    },

    setActivated: function () {
      $('#extension-ads .extension__cta').addClass('extension__cta--activated').html('Activated')
    }
  }

  CampaignModel = Backbone.Model.extend({
    defaults: function () {
      return {
        'name' : '',
        'status' : 0,
        'readableStatus' : 'draft',
        'nextReadableStatus' : 'published',
        'start' : 0,
        'end' : 0,
        'views' : 0,
        'clicks' : 0,
        'conversion' : 0,
        'elements': [],
        'streams': [],
        'firstAdIndex': 1,
        'adsenseClient': '',
        'randomize': 'nope',
        'adsDistrubution': 5
      }
    },
    initialize: function() {
      console.log('initialize Campaign Model', this);
    },
    save: function(status){
      var self = this;
      var $params = {
        emulateJSON: true,
        data: {
          action: la_plugin_slug_down + '_save_campaign',
          campaign: this.toJSON(),
          status: status
        }
      };
      return Backbone.sync( 'create', this, $params ).done(function(serverModel){
        console.log('save callback');
        // manually update model
        for (var prop in serverModel) {
          self.set(prop, serverModel[prop])
        }
      }); // always 'create' because we can't use CRUD request names, only POST
    },
    fetch: function(){
      var $params = {
        emulateJSON: true,
        data: {
          action: la_plugin_slug_down + '_get_campaign',
          id: this.get('id')
        }
      };
      return Backbone.sync( 'read', this, $params )
    },
    destroy: function() {
      var self = this;
      var $params = {
        emulateJSON: true,
        type: 'POST',
        data: {
          action: la_plugin_slug_down + '_delete_campaign',
          id: this.get('id')
        }
      };
      return Backbone.sync( 'delete', this, $params ).done(function(){
        console.log('sync callback');
        self.collection.remove(self);
      })
    },
    urlRoot: _ajaxurl,
    url: function () {
      return this.urlRoot;
    }
  });

  CampaignRowModel = Backbone.Model.extend({
    defaults: function () {
      return {
        'name' : '',
        'status' : 0,
        'readableStatus' : 'draft',
        'start' : 0,
        'end' : 0,
        'views' : 0,
        'clicks' : 0,
        'conversion' : 0,
        'streams' : []
      }
    },
    initialize: function() {
      //        console.log('initialize Row Model', this);
    },
    destroy: function() {
      var self = this;
      var $params = {
        emulateJSON: true,
        type: 'POST',
        data: {
          action: la_plugin_slug_down + '_delete_campaign',
          id: this.get('id')
        }
      };
      ; //
      return Backbone.sync( 'delete', this, $params).done(function(){
        console.log('sync callback');
        self.collection.remove(self);
      })
    },
    clone: function() {
      var self = this;
      var $params = {
        emulateJSON: true,
        type: 'POST',
        data: {
          action: la_plugin_slug_down + '_clone_campaign',
          id: this.get('id')
        }
      };
      return Backbone.sync( 'create', this, $params).done(function(campaign){
        campaignRowModels.add(campaign);
      })
    },
    urlRoot: _ajaxurl,
    url: function () {
      return this.urlRoot;
    }
  });

  CampaignModelsCollection = Backbone.Collection.extend({
    model: CampaignModel
  });
  CampaignRowModelsCollection = Backbone.Collection.extend({
    model: CampaignRowModel
  });
  campaignModels = new CampaignModelsCollection();
  campaignRowModels = new CampaignRowModelsCollection();

  CampaignRowView = Backbone.View.extend({
    model: CampaignRowModel,
    tagName: "tr",
    template:  _.template(templates.campaignRow),
    className: "campaign-row",
    events: {
      "click label": "changeStatus",
      "click .flaticon-pen, .td-name": "edit",
      "click .flaticon-trash": "destroy",
      "click .flaticon-copy": "clone"
    },
    initialize: function() {
      this.listenTo(this.model, "change", this.updateView);

      this.model.view = this; // we can work with models collection now

      if (!this.rendered) {
        this.render()
      }

      this.updateView();

    },
    render: function() {
      this.$el.html(this.template({id: this.model.get('id') || 'new', readableStatus: this.model.get('readableStatus') || 'draft'}));
      this.$el.attr('data-campaign-id', this.model.get('id') || 'new').attr('data-status', 'draft');
      this.rendered = true;
    },
    updateTime: function (){
      this.$el.find('.td-start').html(this.getDateStr(this.model.get('start')));
      this.$el.find('.td-end').html(this.getDateStr(this.model.get('end')));
    },
    getDateStr: function (timestamp) {
      timestamp = parseInt(timestamp);
      if (!timestamp || isNaN(timestamp)) return '-';

      var date = new Date(timestamp);
      var month = date.getMonth() + 1;
      var day = date.getDate();
      var year = date.getFullYear() - 2000;
      return (month > 9 ? month : '0' + month)   + '/' + (day > 9 ? day : '0' + day)  + '/' + year;
    },
    updateView: function() {
      console.log('render row');

      this.$el.find('.td-name').html(this.model.get('name') || 'Unnamed');
      this.$el.find('.td-views').html(this.model.get('views'));
      this.$el.find('.td-clicks').html(this.model.get('clicks'));
      this.$el.find('.td-conversion').html(this.model.get('conversion') + '%');
      this.$el.find('.td-status span').removeClass().addClass('status-light-' + this.model.get('readableStatus'));
      this.updateTime();

      // todo update rest?
    },

    changeStatus: function(e) {

      e.preventDefault()

      var confirm = confirmPopup('Change campaign status?');
      var self = this;
      var $t = $(e.currentTarget).find('input')

      confirm.then( function yes (){
        var _promise = self.edit(undefined, true);

        _promise
          .done(function(){
            $t.attr('checked', !$t.is(':checked')) // toggle input state
          })
          .fail(function(){
            alert('Something went wrong, please try to reload page')
          })
      }, function no (){})
    },

    edit: function(e, viewStays) {
      console.log('row edit', this);
      var defer = $.Deferred();

      var self = this, model, request;

      var id = this.model.get('id');

      if (!id) {
        alert('Something went wrong, please try to reload page')
      }

      if (!Controller.$container.find('#campaign-view-' + id).length) {

        this.$el.addClass('stream-loading');

        model = new CampaignModel({id: id});

        request = model.fetch();
        request.done(
          function (response, status, xhr) {
            var view;

            model.attributes = response; // updated from server
            view = new CampaignView({model: model});
            campaignModels.add(model);

            Controller.$container.append(view.$el);
            if (!viewStays) Controller.switchToView(id);

            view.$el.find('.campaign-elements__list').imagesLoaded().always( function() {
              console.log('init editor')
              Controller.initEditor();
              Controller.startEditor();
            });

            self.$el.removeClass('stream-loading');

            defer.resolve(id);
          }
        ).fail (function () {
          alert('Something went wrong, please try to reload page')
          self.$el.removeClass('stream-loading');
          defer.reject();
        })

      } else {
        if (!viewStays) Controller.switchToView(id);
        defer.resolve(id);
      }

      return defer.promise()
    },
    destroy: function() {
      var promise = confirmPopup('Just checking for misclick. Delete campaign?');
      var self = this;

      promise.then(function(){
        var id = self.model.get('id');
        var request = self.model.destroy();
        Controller.makeOverlayTo('show');

        request.done(function(){
          self.remove();
          if (campaignRowModels.length === 0) {
            Controller.$list.append(templates.campaignRowEmpty);
          }
        }).always(function(){
          Controller.makeOverlayTo('hide');
        }).fail(function(){
          alert('Something went wrong, please try to reload page');
        })
      },function(){})
    },
    clone: function() {
      var self = this;
      var request = self.model.clone();

      Controller.makeOverlayTo('show');

      request.done(function(campaign){
        var view = new CampaignRowView({model: campaignRowModels.get(campaign.id)});
        Controller.$list.append(view.$el);

      }).always(function(){
        Controller.makeOverlayTo('hide');
      }).fail(function(){
        alert('Something went wrong, please try to reload page');
      })
    }
  });

  CampaignView = Backbone.View.extend({
    tagname: "div",
    template:  _.template(templates.campaign),
    className: "section-campaign section-stream",
    streams: [],
    rowModel: null,
    rowView: null,
    currentId: 'new',
    events: {
      "click .button-go-back":   "goBack",
      "click .admin-button.submit-button": "saveViaAjax",
      "change input": "updateModel",
      "change select:not(.campaign-streams__select select)": "updateModel",
      "click .disabled-button": "disableAction",
      "click .status-button": "saveViaAjax",
      "click .campaign-streams__item .flaticon-cross": "detachStream",
      "click .campaign-streams__add": "displayStreamSelect",
      "click .help_link": "showHelp",
      "click .campaign-streams__btn": "connectStream",
      "click .campaign-elements .button-add": "addElement",
      "click .campaign-elements__delete": "removeElement",
      "click .campaign-elements__edit": "editElement",
      "click .campaign-elements__clone": "cloneElement",
      "mousedown .campaign-elements__content": "editElement",
      "click .campaign-elements__close_editor": "closeEditor",
      "click .campaign-streams__item": "showPreview"
    },

    initialize: function() {
      //this.listenTo(this.model, "change", this.render);
      var self = this;
      var rowModel, rowView;
      var rendered = this.rendered;

      this.model.view = this;

      this.render();

      this.model.listenTo(this, 'changeModel', function (data){
        console.log('changeModel event', data);
        self.model.set(data.name, data.val);
      })

      if (this.model.isNew()) {

      } else {
        this.rowModel = campaignRowModels.get(this.model.get('id'));
        this.bindModels();
      }
    },

    bindModels: function () {
      var self = this;

      this.model.listenTo(this.rowModel, 'changed', function(){
        console.log('listening to campaignRowModel');
      });

      this.rowModel.listenTo(this.model, 'campaign-saved', function (model) {
        var attrs = self.model.attributes;
        for (var prop in attrs) {
          if (self.rowModel['attributes'][prop] !== undefined) self.rowModel.set(prop, attrs[prop]);
        }
      })
    },

    render: function() {
      var id = this.model.get('id');
      var nextStatus = this.model.get('nextReadableStatus') || 'Publish';
      var $statusBtn, $statusTxt;
      if (nextStatus === 'live') nextStatus = 'run';
      console.log('render campaign view');

      if ( !this.rendered || !this.currentId ) {
        this.$el.attr('data-view-mode', 'streams-update').attr('id', 'campaign-view-' + (id || 'new'));
        this.$el.html(this.template({
          id: id || 'new',
          header: id ? 'Campaign #' + id : 'Creating...',
          status: this.model.get('nextReadableStatus'),
          readableStatus: capitaliseFirstLetter(this.model.get('readableStatus') || 'draft'),
          nextReadableStatus: capitaliseFirstLetter(nextStatus)
        }))

        this.initDatepickers();
        this.renderConnectedStreams();
        this.renderElements();

        window.sectionExpandCollapse.init({
          $element: this.$el,
          id: 'c' + this.model.id
        });

        $statusBtn = this.$el.find('.status-button');
        $statusTxt = this.$el.find('.status-text');

        this.rendered = true;

      } else {
        $statusBtn = this.$el.find('.status-button');
        $statusTxt = this.$el.find('.status-text');
        $statusBtn.removeClass (function (index, css) {
          return (css.match (/(^|\s)current-status-\S+/g) || []).join(' ');
        }).html(nextStatus).addClass('current-status-' + this.model.get('nextReadableStatus'));
        $statusTxt.html(capitaliseFirstLetter(this.model.get('readableStatus')));
      }

      if (nextStatus === 'finished') {
        this.$el.find('.status-button').addClass('disabled-button').after('<span class="ff-notification">Set delivery end date in future and hit Save to continue campaign running</span>')
      } else {
        this.$el.find('.status-button')
          .removeClass('disabled-button')
          .next('.ff-notification').remove()
      }

      this.setInputsValue();
      this.renderAnalyticsTable();


      this.currentId = id;
    },

    initDatepickers: function () {
      var now = window.server_time * 1000 - 60 * 60 * 24 * 1000; // convert from php default;
      var self = this;

      var start = this.$el.find('.custom-datepicker[data-role=start]').fdatepicker({
        onRender: function (date) {
          return date.valueOf() < now.valueOf() ? 'disabled' : '';
        }
      }).on('changeDate', function (ev) {
        if (ev.date.valueOf() > end.date.valueOf()) {
          var newDate = new Date(ev.date)
          newDate.setDate(newDate.getDate() + 1);
          end.update(newDate);
        }
        start.hide();
        self.$el.find('.custom-datepicker[data-role=end]')[0].focus();
      }).data('datepicker');

      var end = this.$el.find('.custom-datepicker[data-role=end]').fdatepicker({
        onRender: function (date) {
//          return  date.valueOf() <= start.date.valueOf()  ? 'disabled' : '';
          return  date.valueOf() <= start.date.valueOf()  ? '' : ''; // todo for testing
        }
      }).on('changeDate', function (ev) {
        end.hide();
      }).data('datepicker');
      // set dependencies
    },

    disableAction: function (e) {
      e.stopImmediatePropagation()
    },

    renderAnalyticsTable: function () {
      var $table = this.$el.find('.campaign-analytics__table');
      var $elements = this.$el.find('.campaign-elements__item');
      var elements = this.model.get('elements') || [], i, len = elements.length, curr, $img, thumb, src;
      var rows = '';

      if ($table.data('tablesort')) $table.data('tablesort').destroy();

      if (len === 0) {
        $table.find('tbody').html('').append('<tr class="empty-row"><td colspan="5">Add at least one element</td></tr>');
      } else {
        for (i = 0; i < len; i++) {
          curr = elements[i];
          $img = $elements.eq(i).find('.campaign-elements__content img');

          if ($img.length) {
            src = $img.attr('src');
          } else {
            $img = $elements.eq(i).find('.campaign-elements__content .ce-element--type-image');
            if ($img.length) {
              src = $img.css('backgroundImage').slice(4, -1).replace(/"/g, "");
            }
          }

          if (curr.type === 'html' ) {
            thumb =  $img.length ? '<div class="campaign-analytics__image campaign-analytics__image--html" style="background-image:url(' +  src + ')"></div>' : '';
          } else {
            thumb = '<div class="campaign-analytics__image campaign-analytics__image--' + curr.type + '"></div>'
          }

          rows += _.template(templates.analyticsRow)({
            thumb: thumb,
            name: curr.name || 'Unnamed element',
            views: curr.views,
            clicks: curr.clicks,
            conversion: curr.conversion + '%'
          })
        }
        $table.find('tbody').html('').append(rows);
      }

      $table.tablesort();

      // sort initial
      $table.data('tablesort').sort($table.find('th:eq(2)'), 'desc');
    },

    getDateStr: function (timestamp) {
      timestamp = parseInt(timestamp);
      if (!timestamp || isNaN(timestamp)) return '';

      var date = new Date(timestamp);
      var month = date.getMonth() + 1;
      var day = date.getDate();
      var year = date.getFullYear() - 2000;
      return (month > 9 ? month : '0' + month)   + '/' + (day > 9 ? day : '0' + day)  + '/' + year;
    },

    setInputsValue: function () {
      console.log('set inputs value');
      var $input;
      var id = this.model.get('id');
      var attrs = this.model.attributes;
      var val;

      for (var name in attrs ) {
        $input = this.$el.find('[name="campaign-' + id + '-' + name + '"]');

        val = typeof attrs[name] === 'object' ? JSON.stringify( attrs[name] ) : attrs[name];

        if ($input.is(':radio') || $input.is(':checkbox')) {
          $input.each(function(){
            var $t = $( this );
            $t.attr( 'checked', $t.val() == attrs[name] );
          });
        } else {
          if ($input.is('.custom-datepicker')) {
            val = this.getDateStr(val);
            $input.val(val).attr('value', val);
          } else {
            $input.val(val)
          }
        }
      }
    },

    renderConnectedStreams: function () {
      var streams = this.model.get('streams');
      var $cont = this.$el.find('.campaign-streams__list'), $streamRow;
      var name;
      var items = '';

      for (var i = 0, len = streams.length; i < len; i++) { // reverse
        $streamRow = Controller.$streamsList.find("[data-stream-id=" + streams[i] + "]");
        name = $streamRow.find(".td-name").text() || 'Unnamed';

        if (name.length > 15) name = name.substr(0, 15) + '...';
        items += '<span data-id="' +  streams[i] +'" class="campaign-streams__item">' + name + '<i class="flaticon-cross"></i></span>';
      }
      $cont.html('').append(items).closest('.campaign-streams').removeClass('campaign-streams--connecting');
    },

    renderElements: function () {
      var self = this;
      var $cont = this.$el.find('.campaign-elements__list');
      var elements = this.model.get('elements') || [], i, len = elements.length, curr;
      var items = '';

      if (len !== 0) {
        for (i = 0; i < len; i++) {
          curr = elements[i];
          items += _.template(templates.campaignElement)({
            content: curr.content,
            type: curr.type,
            id: curr.id,
            label: curr.label === 'yep' ? 'campaign-elements--label_visible' : '',
            labelTxt: curr.labelTxt,
            labelCol: curr.labelCol,
            textCol: curr.textCol,
            cardBG: curr.cardBG
          })
        }
        $cont.html('').append(items);
      }

      function updateElements (evt) {
        var elements = self.model.get('elements');
        elements.splice(evt.newIndex, 0, elements.splice(evt.oldIndex, 1)[0]);
        self.model.set('elements', elements);
      }

      $cont.sortableCustom({
        handle: '.campaign-elements__controls',
        animation: 250,
        draggable: '.campaign-elements__item',
        onUpdate: updateElements
      })
    },

    addElement: function () {
      var elements = this.model.get('elements');
      var $cont = this.$el.find('.campaign-elements__list');
      var top;
      var $popup = $(templates.elementPopup);
      var self = this;
      $('body').append($popup);

      setTimeout(function(){
        $popup.addClass('is-visible');

        $popup.on('click', function(e){
          var $t = $(e.target);

          if ($t.is('li')) {
            addElementToDom($t.data('type'))
          } else {
            popupHideAndDestroy();
          }
        })

        function addElementToDom(type){
          var html = templates.elementTemplate[type].replace('<%= url %>', window.plugin_url.replace('flow-flow/flow-flow', 'flow-flow/flow-flow-ads'));
          var $elem = $(_.template(templates.campaignElement)({
            content: html,
            type: type,
            id: 'new' + elemIterator++,
            label: '',
            labelTxt: 'Label',
            labelCol: 'rgb(245, 166, 35)',
            textCol: 'rgb(48, 50, 51)',
            cardBG: 'rgb(248, 248, 248)'
          }));

          $elem.addClass('ff-transition--fast ff-transform__shrink');
          $elem.data('type', type);

          $cont.append( $elem );
          setTimeout(function(){
            $elem.removeClass('ff-transform__shrink');
            Controller.setHeight(self.model.get('id'));
          }, 0);
          top = $cont.offset().top + $cont.height() - $elem.height() - 200;

          $('html, body').animate({
            scrollTop: top
          }, 300);

          popupHideAndDestroy();

          elements.push({
            name: '',
            type: type,
            views: 0,
            clicks: 0,
            conversion: 0,
            enabled: 'yep',
            label: false,
            labelTxt: 'Label',
            labelCol: 'rgb(245, 166, 35)',
            textCol: 'rgb(48, 50, 51)',
            cardBG: 'rgb(248, 248, 248)',
            link: '',
            code: '',
            slot: '',
            height: 250,
            content: html
          });

          $elem.imagesLoaded( function() {
            console.log('imagesLoaded')
            //            Controller.initEditor();
            $cont.closest('.section').find('.submit-button').click()
          });

        }

        function popupHideAndDestroy(){
          $popup.removeClass('is-visible');
          setTimeout(function(){
            $popup.remove();
          }, 350)
        }
      },0)
    },

    cloneElement: function(e) {
      var self = this;
      var $elem = $(e.target).closest('.campaign-elements__item');
      var $cont = this.$el.find('.campaign-elements__list');
      var elements = this.model.get('elements');
      var model = elements[$elem.index()]; // link to object
      var clonedModel = _.clone(model);
      var type = $elem.data('type');
      var top;
      if (Controller.editor) {
        Controller.editor.save();
        this.updateElementsInModel();
      }

      var $clone = $elem.clone();
      // todo clone

      $clone.addClass('ff-transition--fast ff-transform__shrink');
      $clone.data('type', type);

      $cont.append( $clone );
      setTimeout(function(){$clone.removeClass('ff-transform__shrink')}, 0);
      top = $cont.offset().top + $cont.height() - $clone.height() - 200;

      $('html, body').animate({
        scrollTop: top
      }, 300);

      Controller.setHeight(self.model.get('id'));

      delete clonedModel.id;
      elements.push(clonedModel);

      this.model.set('elements', elements);

      $clone.imagesLoaded( function() {
        console.log('imagesLoaded')
        //        Controller.initEditor();
        self.saveViaAjax('reload');
      });

    },

    editElement: function(e) {
      var self = this;
      var $elem = $(e.target).closest('.campaign-elements__item');
      var $settingCont;
      var type = $elem.data('type');
      var elements = this.model.get('elements');
      var settings = elements[$elem.index()]; // link to object
      var id = settings.id || 'new' + iterator++;
      var $input, $colorPickers;
      var val;
      var $cont = this.$el.find('.campaign-elements__list');
      var isThereSpaceOnLeft = $cont.outerWidth() > $elem.position().left + 540;
      if ($elem.data('editor-state') === 'editing') return;

      this.closeEditor(); // if another opened
      $elem.addClass('campaign-elements__item--editing').data('editor-state', 'editing')
      $settingCont = $('<div class="campaign-elements__settings ff-transition--fast campaign-elements__settings--'+ (isThereSpaceOnLeft ? 'left': 'right') + '">' + templates.elementSettings[type].replace(/<%= id %>/g, id) + '</div>');
      $elem.append($settingCont);
      $colorPickers = $settingCont.find('input[data-color-format]');

      for (var name in settings ) {
        $input = $elem.find('[name="element-' + id + '-' + name + '"]');

        val = typeof settings[name] === 'object' ? JSON.stringify( settings[name] ) : settings[name];

        if ($input.is(':radio') || $input.is(':checkbox')) {
          $input.each(function(){
            var $t = $( this );
            $t.attr( 'checked', $t.val() == settings[name] );
          });
        } else {
          $input.val(val)
        }
      }

      function onChange(e){
        console.log(e.type);
        var $t = $(e.target);
        var _name = e.target.name.replace('element-' + id + '-', '');
        var $parent = $t.closest('.campaign-elements__item');
        var val;
        var $label;

        if ($t.is(':radio, :checkbox')) {
          val = $t.is(':checked') ? 'yep' : 'nope'
        } else {
          val = $t.val();
        }

        if ($t.is('.label-switcher')) {
           if (val === 'yep') {
             $parent.addClass('campaign-elements--label_visible')
           } else {
             $parent.removeClass('campaign-elements--label_visible')
           }
        }

        if ($t.is('.label__input')) {
          $label = $parent.find('.campaign-elements__label')
          if ($t.is('[data-color-format]')) {
            $label.css('backgroundColor', val)
          } else {
            $label.html(val)
          }
        } else if ($t.is('[data-color-format]')) {
          if ($t.is('.card-settings__cardBG')) {
            $parent.find('.campaign-elements__content').css('backgroundColor', $t.val())
          } else if ($t.is('.card-settings__textCol')) {
            $parent.find('.campaign-elements__content').css('color', $t.val())
          }
        }
        settings[_name] = val;
      }

      $settingCont.on('change input colorpicker-change', onChange);

      $settingCont.find('.admin-button').click(function(){
        $(this).closest('.section').find('.submit-button').click()
      }); // proxy

      this.bindedHandler = this.outsideClickHandler.bind(this);
      Controller.$html.on('click', this.bindedHandler);

      if (type === 'html') Controller.showEditorUI();

      setTimeout(function(){
        $colorPickers.ColorPickerSliders(colorPickerOpts)
      },0);

    },

    bindedHandler: null,

    outsideClickHandler: function (e) {
      debugger
       if (!$(e.target).closest('.campaign-elements__item, .ct-widget').length) {
         this.closeEditor();
       }
    },

    closeEditor: function (e) {
      var $elem = $('.campaign-elements__item--editing');
      var $settingCont = $elem.find('.campaign-elements__settings');

      if ($elem.data('editor-state') !== 'editing') return;

      $settingCont.on(transitionEnd, function(){
        $settingCont.remove()
      });

      $settingCont.find('[data-color-format]').remove()
      $settingCont.addClass('ff-transition__fadeOut');

      $elem.data('editor-state', 'hidden').removeClass('campaign-elements__item--editing');
debugger
      Controller.hideEditorUI();
      Controller.$html.off('click', this.bindedHandler);
    },

    removeElement: function (e) {
      var self = this;
      var $elem = $(e.target).closest('.campaign-elements__item');

      confirmPopup('Are you sure you want to remove element?').then(
        function success () {
          var index = $elem.index();
          var elements = self.model.get('elements');
          var $sbmt = $elem.closest('.section').find('.submit-button');

          $elem.on(transitionEnd, function(){
            $elem.remove();
            $sbmt.click();
          })

          elements = _.without(elements, elements[index]);
          self.model.set('elements', elements)

          setTimeout(function(){
            $elem.addClass('ff-transition--fast ff-transform__shrink');
          }, 200);


        },
        function fail () {

        }
      )
    },

    updateElementsInModel: function(){
      var elements = this.model.get('elements');
      var $elements = this.$el.find('.campaign-elements__item');

      $elements.each(function(index, element){
        var $t = $(element);
        if ($t.is('.ff-template__html')) {
          elements[index]['content'] = $t.find('.campaign-elements__content').html();
        }
      });

      this.model.set('elements', elements)
    },

    updateElementIDs: function(elements){
      var $elements = this.$el.find('.campaign-elements__item');
      $elements.each(function(index, element){
        var $t = $(element);
        var data = elements[index];
        if (data) {
          $t.attr('data-id', data.id);
        }
      });
    },

    goBack: function() {
      Controller.switchToView('list');
    },

    updateModel: function(event) {
      var $t = $(event.target);
      var val = $t.val();
      var name = $t.attr('name');

      if (!name) return;

      if ($t.data('date-format') ) {
        val = /\d+\/\d+\/\d+/.test(val) ? new Date(val).getTime() : '';
      }
      if ($t.is(':radio, :checkbox')) {
        val = $t.is(':checked') ? 'yep' : 'nope'
      }
      this.trigger('changeModel', {name: $t.attr('name').replace('campaign-' + (this.model.get('id') || 'new') + '-', ''), val: val })
    },

    saveViaAjax: function(arg) {
      console.log('save campaign')
      debugger
      var self = this;
      var emptyList = campaignRowModels.length === 0;
      var $t = $(typeof arg === 'object' ? arg.target : '');
      var $editing = this.$el.find('.campaign-elements__item--editing');
      var isNew = this.model.isNew();

      if ($editing.length) this.closeEditor();

      if (Controller.editor) {
        Controller.editor.save();
        this.updateElementsInModel();
      }

      Controller.makeOverlayTo('show');
      $t.addClass('button-in-progress');

      var promise = this.model.save($t.is('.status-button'));

      promise.done(function(serverModel){
        Controller.makeOverlayTo('hide');
        self.render();

        if (isNew) {
          self.rowModel = new CampaignRowModel();
          self.rowView = new CampaignRowView({model: self.rowModel});
          campaignRowModels.add(self.rowModel);

          Controller.$list.append(self.rowView.$el);

          self.bindModels();
        }

        self.rowModel.set('id', serverModel.id);
        self.model.trigger('campaign-saved');

//        if (Controller.editor) Controller.editor.start();
        Controller.initEditor();
        Controller.startEditor();


        if (emptyList) {
          Controller.$list.find('.empty-row').remove();
        }
        self.updateElementIDs(serverModel.elements);
        // todo update elements ID
        if ($editing.length) $editing.find('.campaign-elements__edit').click();

        sessionStorage.setItem('ff_campaign', serverModel.id);

        if ($t.is('.status-button')) return;
        
        $t.addClass('updated-button').html('&#10004;&nbsp;&nbsp;Updated');
        $t.removeClass('button-in-progress');

        setTimeout( function () {
          $t.html('Save changes').removeClass('updated-button');
        }, 2500);

      }).fail(function(){

      });
    },

    connectStream: function (e) {
      var self = this;

      var $t = $(e.target).closest('.campaign-streams__btn');
      var streams = this.model.get('streams');

      var request;

      if ($t.is('.campaign-streams__close')) {
        $t.closest('.campaign-streams').removeClass('campaign-streams--connecting')
        return;
      }

      var val = this.$el.find('.campaign-streams select :selected').val();
      streams.push(parseInt(val));
      this.model.set('streams', streams);

      Controller.makeOverlayTo('show');

      request = this.model.save();

      request.done(function(serverModel){
        self.model.trigger('campaign-saved');
        self.renderConnectedStreams();
      }).always(function(){
        Controller.makeOverlayTo('hide');
      });
    },

    showPreview: function (e) {
      var $t = $(e.target);
      var id = $t.data('id');
      Controller.makeOverlayTo('show');
      $.get(_ajaxurl, {
          'action' :  'flow_flow_show_preview',
          'stream-id' : id
      }).success(function(response){
          var $popup = $('.content-popup');
          var $body = $('body');
          Controller.makeOverlayTo('hide');
          $body.css('overflow', 'hidden');
          $popup.off(transitionEnd).addClass('is-visible').find('.content-popup__content').html(response);

          if (Controller.$previewStyles) {
            Controller.$previewStyles.appendTo('head');
          }

          $popup.on('click', function(event){
            if( $(event.target).is('.content-popup__close') || $(event.target).is('.content-popup') ) {
              event.preventDefault();
              var self = this;
              $(this).removeClass('is-visible');
              $popup.off('click');
              $popup.on(transitionEnd, function(){
                $popup.find('.content-popup__content').html('').off(transitionEnd);
                $body.find('.ff-slideshow').remove();
                if (!Controller.$previewStyles) {
                  Controller.$previewStyles = $('#ff_style, #ff_ad_style');
                }
                Controller.$previewStyles.detach();
              })
              $body.css('overflow', '');

            }
          });
      }).fail(function(){
        Controller.makeOverlayTo('hide');

        alert('Something went wrong. Please try again after page refresh')
      })
    },

    detachStream: function (e) {
      var promise = confirmPopup('Detach campaign from stream?');
      var self = this;
      var $t = $(e.target).closest('span');
      var id = $t.data('id');

      e.stopPropagation();

      promise.then(
        function success () {
          self.model.set('streams', _.without(self.model.get('streams'), id.toString()));
          Controller.makeOverlayTo('show');

          var request = self.model.save();
          request.done(function(serverModel){
            self.model.trigger('campaign-saved');
            $t.remove();
          }).always(function(){
            Controller.makeOverlayTo('hide');
          });
        },
        function fail () {

        }
      )
    },

    displayStreamSelect: function () {
      var streams = this.model.get('streams');
      var notConnected = this.model.get('available_streams') || {};
      var prop;

      var $select = this.$el.find('.campaign-streams select');
      var options = '';
      var name;

      if (_.isEmpty(notConnected)) {
        alert('All streams already connected.');
        return
      }

      for (var prop in notConnected) {
        name = notConnected[prop];
        options += '<option value="' + prop + '">' + name + '</option>';
      }

      $select.html('').append(options).closest('.campaign-streams').addClass('campaign-streams--connecting');

    },

    showHelp: function (e) {
      var $popup = $('.content-popup');
      var $body = $('body');

      $body.css('overflow', 'hidden');
      $popup.off(transitionEnd).addClass('is-visible').find('.content-popup__content').html(templates.help.builder);

      $popup.on('click', function(event){
        if( $(event.target).is('.content-popup__close') || $(event.target).is('.content-popup') ) {
          event.preventDefault();
          $(this).removeClass('is-visible');
          $popup.off('click');
          $popup.on(transitionEnd, function(){
            $popup.find('.content-popup__content').html('').off(transitionEnd);
          })
          $body.css('overflow', '')
        }
      });

      return false
    }
  });

  return {
    'init' : function () {
      var self = this;
      var controller = Controller.init.apply(Controller, arguments);

      self.init = function(){return self}
      return self;
    },
    'Controller' : Controller,
    'Model' : {
      'CampaingRow' : {
        'collection' : campaignRowModels,
        'class' : CampaignRowModel
      },
      'Campaign' : {
        'collection' : campaignModels,
        'class' : CampaignModel
      }
    },
    'View' : {
      'CampaingRow' : {
        'class' : CampaignRowView
      },
      'Campaign' : {
        'class' : CampaignView
      }
    }
  }
})(jQuery)

jQuery(document).bind('html_ready', function(){
  var app = CampaignApp.init();
});