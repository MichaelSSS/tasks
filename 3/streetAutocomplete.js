(function($) {
 
  var Autocomplete = function(element, options){
    this.options = options;
    this.$el = $(element);
    this.cache = {};
    this.init();
  };

  Autocomplete.prototype = {
    constructor: Autocomplete,
    init: function() {
      var that = this;

      that.$el.attr('autocomplete', 'off');

      that.$list = $('<ul class="street-autocomplete"></ul>');

      that.$list.appendTo('body');

      that.$el.on('input', function() {
        var val = that.$el.val();

        if (val.length >= that.options.minChars) {
          clearTimeout(that.timeout);
        
          that.timeout = setTimeout(function() {
            that.suggest(val);
          }, 300);
        }
      })
      .on('blur', function(event) {
        if (that.$list.find('li:hover').length === 0) { 
          that.$list.hide();
        }
      });

      that.$list.on('click', 'li', function() {
        var index = $(this).data('index');
        that.$el.val(that.data[index]);
        that.$list.hide();
      });
    },

    loadData: function(term, success) {
      var that = this;

      if(that.cache[term]) {
        that.data = that.cache[term];
        success(that.data);

        return;
      }

      $.ajax({
        method: 'GET',
        data: 'term=' + term,
        url: that.options.url,
        dataType: 'json'
      }).done(function(resp) {
        that.data = resp;
        that.cache[term] = resp;
        success(resp);
      });
    },

    renderItem: function(index) {
      return '<li data-index="' + index + '">' + this.data[index] + '</li>';
    },

    showList: function() {
      var input = this.$el;
      this.$list.css({
        top: input.offset().top + input.outerHeight(),
        left: input.offset().left,
        width: input.outerWidth()
      });
      this.$list.show();
    },

    updateList: function(data) {
      var i, len, html = '';
      for(i = 0, len = data.length; i < len; i++) {
        html += this.renderItem(i);
      }
      this.$list.html(html);
      this.showList();
    },

    suggest: function(search) {
      var that = this;
      that.loadData(search, function(resp) {
        that.updateList(resp);
      });
    }
  }

  $.fn.streetAutocomplete = function(options) {
    this.filter('input').each(function() {
      new Autocomplete(this, options);
    });
 
    return this;
  };
 
}(jQuery));
